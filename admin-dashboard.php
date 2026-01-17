<?php
session_start();
// Security Check
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin-login.php');
    exit;
}

require_once 'db.php';

// --- Fetch Stats ---

// 1. Total Rooms
// Mocking Total Rooms as 240 (60 rooms * 4 floors = 240 per building? No. 
// 20 rooms * 4 floors = 80 per building. 2 Buildings = 160 Total Rooms).
// Let's settle on 160.
$total_rooms = 160;

// 2. Confirmed Bookings (Occupied)
$sql_occupied = "SELECT COUNT(*) as count FROM bookings WHERE status = 'confirmed' OR status = 'pending'";
$res_occ = $conn->query($sql_occupied);
$occupied = $res_occ->fetch_assoc()['count'];

// 3. Available
$available = $total_rooms - $occupied;

// 4. Total Students (Same as occupied for now, or total unique students)
$total_students = $occupied;

// --- Fetch Recent Activity ---
$sql_recent = "SELECT * FROM bookings ORDER BY booking_date DESC LIMIT 50";
$recent_bookings = $conn->query($sql_recent);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SOLID CAMPUS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: #fff;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100%;
            left: 0;
            top: 0;
        }

        .sidebar-logo {
            margin-bottom: 3rem;
            text-align: center;
        }

        .sidebar-menu {
            list-style: none;
            flex-grow: 1;
        }

        .sidebar-menu li {
            margin-bottom: 1rem;
        }

        .sidebar-menu a {
            color: #bdc3c7;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.8rem;
            border-radius: 5px;
            transition: 0.3s;
        }

        .sidebar-menu a:hover, .sidebar-menu a.active {
            background-color: var(--secondary-color);
            color: #fff;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 2rem;
            background-color: var(--light-bg);
        }

        .header-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--card-bg);
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #fff;
        }

        .bg-blue { background-color: #3498db; }
        .bg-green { background-color: #2ecc71; }
        .bg-red { background-color: #e74c3c; }
        .bg-orange { background-color: #f39c12; }

        .stat-info h3 {
            font-size: 2rem;
            margin: 0;
            line-height: 1;
        }

        .stat-info p {
            margin: 0;
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        /* Recent Activity Table */
        .recent-section {
            background: var(--card-bg);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        th {
            font-weight: 600;
            color: #7f8c8d;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-confirmed { background-color: rgba(46, 204, 113, 0.2); color: #2ecc71; }
        .status-pending { background-color: rgba(243, 156, 18, 0.2); color: #f39c12; }

        .btn-action {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.8rem;
            margin-right: 5px;
            color: #fff;
        }
        .btn-confirm { background-color: #2ecc71; }
        .btn-delete { background-color: #e74c3c; }
        .btn-confirm:hover { background-color: #27ae60; }
        .btn-delete:hover { background-color: #c0392b; }

        .btn-view { background-color: #3498db; }
        .btn-view:hover { background-color: #2980b9; }

        /* Modal Styles */
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1000; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgba(0,0,0,0.5); 
            backdrop-filter: blur(4px);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto; 
            padding: 0;
            border: 1px solid #888;
            width: 100%;
            max-width: 500px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .modal-header {
            background: var(--primary-color);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 12px 12px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 { margin: 0; font-size: 1.2rem; }

        .close-modal {
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        .close-modal:hover { color: #f1c40f; }

        .modal-body {
            padding: 2rem;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 0.8rem 0;
            border-bottom: 1px solid #eee;
        }

        .detail-row:last-child { border-bottom: none; }

        .detail-label {
            font-weight: 600;
            color: #7f8c8d;
        }

        .detail-value {
            font-weight: 500;
            color: #2c3e50;
            text-align: right;
        }
    </style>
</head>
<body>

    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-logo">
                <div class="logo" style="justify-content: center; margin-bottom: 0.5rem;">
                    <span class="at-logo" style="font-size: 2.2rem;">SOLID</span>
                </div>
                <div style="font-size: 0.85rem; letter-spacing: 3px; color: rgba(255,255,255,0.6); font-weight: 600; text-transform: uppercase;">Campus Admin</div>
            </div>
            <ul class="sidebar-menu">
                <li><a href="#" class="active">📅 Dashboard</a></li>

                <li><a href="api/logout.php" style="color: #ff6b6b;">🚪 Logout</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="header-bar">
                <div>
                    <h2>Hello, Admin 👋</h2>
                    <p>Here's what's happening today.</p>
                </div>
            </div>

            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon bg-blue">🛏️</div>
                    <div class="stat-info">
                        <h3><?php echo $total_rooms; ?></h3>
                        <p>Total Rooms</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-green">✨</div>
                    <div class="stat-info">
                        <h3><?php echo $available; ?></h3>
                        <p>Available</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-red">🚫</div>
                    <div class="stat-info">
                        <h3><?php echo $occupied; ?></h3>
                        <p>Occupied</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-orange">👥</div>
                    <div class="stat-info">
                        <h3><?php echo $total_students; ?></h3>
                        <p>Total Students</p>
                    </div>
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="recent-section">
                <h3>Recent Bookings</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Year</th>
                            <th>Building</th>
                            <th>Room</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($recent_bookings->num_rows > 0) {
                            while($row = $recent_bookings->fetch_assoc()) {
                                $date = date('Y-m-d', strtotime($row['booking_date']));
                                echo "<tr>
                                    <td>{$row['student_name']}</td>
                                    <td>{$row['year_of_study']}</td>
                                    <td>{$row['building']}</td>
                                    <td>{$row['room_number']}</td>
                                    <td>{$date}</td>
                                    <td><span class='status-badge status-{$row['status']}'>{$row['status']}</span></td>
                                    <td>
                                        <button class='btn-action btn-view' 
                                            onclick='viewDetails(this)'
                                            data-name='{$row['student_name']}'
                                            data-reg='{$row['student_id']}'
                                            data-year='{$row['year_of_study']}'
                                            data-email='{$row['email']}'
                                            data-phone='{$row['phone']}'
                                            data-build='{$row['building']}'
                                            data-room='{$row['room_number']}'
                                            data-date='{$date}'
                                            data-status='{$row['status']}'>
                                            View
                                        </button>
                                        " . ($row['status'] == 'pending' ? "<button class='btn-action btn-confirm' onclick='confirmBooking({$row['id']}, this)'>Confirm</button>" : "") . "
                                        <button class='btn-action btn-delete' onclick='deleteBooking({$row['id']}, this)'>Remove</button>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No bookings found yet.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                </main>
    </div>

    <!-- View Details Modal -->
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Student Details</h2>
                <span class="close-modal">&times;</span>
            </div>
            <div class="modal-body">
                <div class="detail-row">
                    <span class="detail-label">Full Name</span>
                    <span class="detail-value" id="m-name"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Register No</span>
                    <span class="detail-value" id="m-reg"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Year</span>
                    <span class="detail-value" id="m-year"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Email</span>
                    <span class="detail-value" id="m-email"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Phone</span>
                    <span class="detail-value" id="m-phone"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Allocated Room</span>
                    <span class="detail-value" id="m-room"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Apply Date</span>
                    <span class="detail-value" id="m-date"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status</span>
                    <span class="detail-value status-badge" id="m-status"></span>
                </div>
            </div>
        </div>
    </div>
        </main>
    </div>

    <script>
        // Modal Logic
        const modal = document.getElementById("viewModal");
        const span = document.getElementsByClassName("close-modal")[0];

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        function viewDetails(btn) {
            document.getElementById('m-name').textContent = btn.dataset.name;
            document.getElementById('m-reg').textContent = btn.dataset.reg;
            document.getElementById('m-year').textContent = btn.dataset.year;
            document.getElementById('m-email').textContent = btn.dataset.email;
            document.getElementById('m-phone').textContent = btn.dataset.phone;
            document.getElementById('m-room').textContent = btn.dataset.build + ' - ' + btn.dataset.room;
            document.getElementById('m-date').textContent = btn.dataset.date;
            
            const statusSpan = document.getElementById('m-status');
            statusSpan.textContent = btn.dataset.status;
            statusSpan.className = 'detail-value status-badge status-' + btn.dataset.status;

            modal.style.display = "block";
        }

        function confirmBooking(id, btnElement) {
            if(confirm('Are you sure you want to confirm this booking?')) {
                // Show loading state
                const originalText = btnElement.innerText;
                btnElement.innerText = 'Processing...';
                btnElement.disabled = true;

                console.log('Sending confirm request for ID:', id);

                fetch('api/confirm_booking.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({id: id})
                })
                .then(res => res.text().then(text => { // Read as text first to debug non-JSON errors
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                         console.error('Server returned non-JSON:', text);
                         throw new Error('Server Error: ' + text.substring(0, 50));
                    }
                }))
                .then(data => {
                    console.log('Confirm response:', data);
                    if(data.success) {
                        alert('Booking Confirmed Successfully!');
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                        resetBtn(btnElement, originalText);
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    alert('Request failed: ' + error.message);
                    resetBtn(btnElement, originalText);
                });
            }
        }

        function deleteBooking(id, btnElement) {
            if(confirm('Are you sure you want to delete this booking? This will free up the space.')) {
                // Show loading state
                const originalText = btnElement.innerText;
                btnElement.innerText = 'Processing...';
                btnElement.disabled = true;

                console.log('Sending delete request for ID:', id);

                fetch('api/delete_booking.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({id: id})
                })
                .then(res => res.text().then(text => {
                    try {
                         return JSON.parse(text);
                    } catch (e) {
                         console.error('Server returned non-JSON:', text);
                         throw new Error('Server Error: ' + text.substring(0, 50));
                    }
                }))
                .then(data => {
                    console.log('Delete response:', data);
                    if(data.success) {
                        alert('Booking Removed Successfully! Vacancy updated.');
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                        resetBtn(btnElement, originalText);
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    alert('Request failed: ' + error.message);
                    resetBtn(btnElement, originalText);
                });
            }
        }

        function resetBtn(btn, text) {
            btn.innerText = text;
            btn.disabled = false;
        }
    </script>


</body>
</html>
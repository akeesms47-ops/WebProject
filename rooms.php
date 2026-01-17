<?php
session_start();
// Security Check
if ((!isset($_SESSION['student_logged_in']) || $_SESSION['student_logged_in'] !== true) && 
    (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true)) {
    header('Location: student-login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solid Campus Hostel - Room Selection</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .page-header {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 8rem 2rem 4rem;
            text-align: center;
        }
        
        /* Tab Styles */
        .building-tabs {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }
        
        .tab-btn {
            padding: 1rem 2rem;
            font-size: 1.1rem;
            background: var(--white);
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            border-radius: 50px;
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
        }
        
        .tab-btn:hover {
            background: #ecf0f1;
        }
        
        .tab-btn.active {
            background: var(--primary-color);
            color: var(--white);
        }
        
        /* Building Sections */
        .building-container {
            display: none; /* Hidden by default */
            animation: fadeIn 0.5s ease;
        }
        
        .building-container.active {
            display: block; /* Show when active */
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .floor-section {
            margin-bottom: 2rem;
        }
        
        .floor-title {
            font-size: 1.2rem;
            color: #7f8c8d;
            margin-bottom: 1rem;
            border-bottom: 1px solid #eee;
            padding-bottom: 0.5rem;
            display: inline-block;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo-container">
                <div class="logo">
                    <span class="at-logo">SOLID</span> CAMPUS
                </div>
                <div class="vision">Empowering Future Leaders</div>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="rooms.php" class="active">Hostels</a></li>
                <li><a href="reservation.php">Reservation</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="api/student_logout.php" style="color: #e74c3c;">Logout</a></li>
                <li><a href="reservation.php" class="btn-primary">Book Now</a></li>
                <li><button id="theme-toggle" class="theme-toggle" title="Toggle Dark Mode">🌙</button></li>
            </ul>
            <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </nav>
    </header>

    <main>
        <section class="page-header">
            <h1>Select Your Room</h1>
            <p>Choose your building and floor level</p>
        </section>

        <section class="hostel-buildings">
            
            <!-- Tab Navigation -->
            <div class="building-tabs">
                <button class="tab-btn active" onclick="switchBuilding('A')">Building A (Boys)</button>
                <button class="tab-btn" onclick="switchBuilding('B')">Building B (Girls)</button>
            </div>

            <div class="legend" style="justify-content: center;">
                <div class="legend-item">
                    <div class="legend-color legend-available"></div>
                    <span>Available</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color legend-occupied"></div>
                    <span>Full (4/4)</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color legend-partial"></div>
                    <span>Partial (1-3)</span>
                </div>
            </div>

            <!-- Building A Container -->
            <div id="building-A" class="building-container active">
                <div class="building-section">
                    <div class="building-header">
                        <h2>Building A - Boys Hostel</h2>
                        <span class="building-status">All Floors Open</span>
                    </div>

                    <div class="floor-section">
                        <h3 class="floor-title">Ground Floor</h3>
                        <div class="room-grid" id="grid-a-f0"></div>
                    </div>
                    
                    <div class="floor-section">
                        <h3 class="floor-title">Floor 1</h3>
                        <div class="room-grid" id="grid-a-f1"></div>
                    </div>
                    
                    <div class="floor-section">
                        <h3 class="floor-title">Floor 2</h3>
                        <div class="room-grid" id="grid-a-f2"></div>
                    </div>
                    
                    <div class="floor-section">
                        <h3 class="floor-title">Floor 3</h3>
                        <div class="room-grid" id="grid-a-f3"></div>
                    </div>
                </div>
            </div>

            <!-- Building B Container -->
            <div id="building-B" class="building-container">
                <div class="building-section">
                    <div class="building-header">
                        <h2>Building B - Girls Hostel</h2>
                        <span class="building-status">Secure Access Control</span>
                    </div>

                    <div class="floor-section">
                        <h3 class="floor-title">Ground Floor</h3>
                        <div class="room-grid" id="grid-b-f0"></div>
                    </div>

                    <div class="floor-section">
                        <h3 class="floor-title">Floor 1</h3>
                        <div class="room-grid" id="grid-b-f1"></div>
                    </div>
                    
                    <div class="floor-section">
                        <h3 class="floor-title">Floor 2</h3>
                        <div class="room-grid" id="grid-b-f2"></div>
                    </div>
                    
                    <div class="floor-section">
                        <h3 class="floor-title">Floor 3</h3>
                        <div class="room-grid" id="grid-b-f3"></div>
                    </div>
                </div>
            </div>
            
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-logo">
                <h3>Solid Campus Hostel Reservation</h3>
                <p>University accommodation services.</p>
            </div>
            <div class="footer-links">
                <a href="#">Rules & Regulations</a>
                <a href="#">Support</a>
                <a href="admin-login.php">Admin Login</a>
            </div>
            <p class="copyright">&copy; 2025 SOLID CAMPUS Reservation.</p>
        </div>
    </footer>

    <script src="js/script.js"></script>
    <script>
        // Tab Switcher Logic
        function switchBuilding(buildingId) {
            // Hide all buildings
            document.querySelectorAll('.building-container').forEach(el => el.classList.remove('active'));
            // Remove active class from buttons
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            
            // Show selected building
            document.getElementById(`building-${buildingId}`).classList.add('active');
            // Activate button
            const buttons = document.querySelectorAll('.tab-btn');
            if(buildingId === 'A') buttons[0].classList.add('active');
            else buttons[1].classList.add('active');
        }

        // Grid Generation Logic with API Data
        function renderGrid(elementId, buildingName, count, startNum, occupiedList) {
            const container = document.getElementById(elementId);
            if(!container) return; // Guard clause
            
            container.innerHTML = ''; // Clear existing

            for(let i = 0; i < count; i++) {
                const roomNum = String(startNum + i).padStart(3, '0');
                
                // Find room data
                const roomData = occupiedList.find(booking => 
                    booking.room == roomNum && buildingName.includes(booking.building)
                );
                
                const occupancyCount = roomData ? roomData.count : 0;
                const isFull = occupancyCount >= 4;
                const isPartial = occupancyCount > 0 && occupancyCount < 4;
                
                const square = document.createElement('div');
                let className = 'room-square ';
                if (isFull) className += 'occupied';
                else if (isPartial) className += 'partial';
                
                square.className = className;
                square.textContent = roomNum;
                square.setAttribute('data-room', roomNum);
                square.setAttribute('data-building', buildingName);
                
                // Tooltip info
                if (isFull) square.title = "Room Full";
                else if (isPartial) square.title = `${4 - occupancyCount} spots left`;
                else square.title = "Available (4 spots)";

                if(!isFull) {
                    square.addEventListener('click', () => {
                        window.location.href = `reservation.php?building=${buildingName}&room=${roomNum}`;
                    });
                }
                
                container.appendChild(square);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Fetch Occupied Rooms from Database
            fetch('api/get_room_status.php')
                .then(response => response.json())
                .then(data => {
                    console.log('Occupied Rooms:', data); // Debugging

                    // Building A
                    renderGrid('grid-a-f0', 'Building A', 20, 1, data);    // Ground Floor: 001-020
                    renderGrid('grid-a-f1', 'Building A', 20, 21, data);   // Floor 1: 021-040
                    renderGrid('grid-a-f2', 'Building A', 20, 41, data);   // Floor 2: 041-060
                    renderGrid('grid-a-f3', 'Building A', 20, 61, data);   // Floor 3: 061-080

                    // Building B
                    renderGrid('grid-b-f0', 'Building B', 20, 1, data);    // Ground Floor: 001-020
                    renderGrid('grid-b-f1', 'Building B', 20, 21, data);   // Floor 1: 021-040
                    renderGrid('grid-b-f2', 'Building B', 20, 41, data);   // Floor 2: 041-060
                    renderGrid('grid-b-f3', 'Building B', 20, 61, data);   // Floor 3: 061-080
                })
                .catch(error => {
                    console.error('Error fetching room status:', error);
                    // Fallback to empty if API fails (all green)
                    const empty = [];
                    renderGrid('grid-a-f0', 'Building A', 20, 1, empty);
                    renderGrid('grid-a-f1', 'Building A', 20, 21, empty);
                    renderGrid('grid-a-f2', 'Building A', 20, 41, empty);
                    renderGrid('grid-a-f3', 'Building A', 20, 61, empty);
                    renderGrid('grid-b-f0', 'Building B', 20, 1, empty);
                    renderGrid('grid-b-f1', 'Building B', 20, 21, empty);
                    renderGrid('grid-b-f2', 'Building B', 20, 41, empty);
                    renderGrid('grid-b-f3', 'Building B', 20, 61, empty);
                });
        });
    </script>
</body>
</html>
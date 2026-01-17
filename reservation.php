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
    <title>Solid Campus Hostel Reservation - Book Now</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .reservation-content {
            padding: 8rem 2rem 4rem;
            max-width: 800px;
            margin: 0 auto;
        }

        .form-container {
            background: var(--white);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: var(--font-main);
            transition: var(--transition);
        }

        .form-control:read-only {
            background-color: #f8f9fa;
            cursor: not-allowed;
            color: #7f8c8d;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 2px rgba(231, 76, 60, 0.2);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .selection-summary {
            background: #e8f6f3;
            border: 1px solid #2ecc71;
            color: #27ae60;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 2rem;
            display: none;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 5px;
            display: none;
            text-align: center;
        }

        @media (max-width: 600px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }

        /* Success Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            backdrop-filter: blur(4px);
            animation: fadeIn 0.3s;
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 2.5rem;
            border-radius: 15px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            animation: slideUp 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes fadeIn { from {opacity: 0;} to {opacity: 1;} }
        @keyframes slideUp { from {transform: translateY(50px); opacity: 0;} to {transform: translateY(0); opacity: 1;} }

        .success-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            display: inline-block;
            animation: popIn 0.5s 0.2s backwards;
        }

        @keyframes popIn { from {transform: scale(0);} to {transform: scale(1);} }

        .modal h2 { color: #2c3e50; margin-bottom: 0.5rem; }
        .modal p { color: #7f8c8d; margin-bottom: 2rem; line-height: 1.5; }

        .btn-modal {
            background-color: var(--secondary-color);
            color: white;
            padding: 0.8rem 2.5rem;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
        }
        .btn-modal:hover { background-color: #c0392b; transform: translateY(-2px); }

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
                <li><a href="rooms.php">Hostels</a></li>
                <li><a href="reservation.php" class="active">Reservation</a></li>
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
        <section class="reservation-content">
            <div class="section-title">
                <h1>Confirm Your Booking</h1>
                <p>Complete your reservation details</p>
            </div>

            <div id="selectionSummary" class="selection-summary">
                Selected: <strong id="summaryText"></strong>
            </div>

            <div class="form-container">
                <div id="success-alert" class="alert-success"></div>
                
                <form id="reservationForm">
                    <!-- Selected Room Info (Read Only) -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="building">Building</label>
                            <input type="text" id="building" class="form-control" readonly
                                placeholder="Select from Rooms page">
                        </div>
                        <div class="form-group">
                            <label for="roomNumber">Room Number</label>
                            <input type="text" id="roomNumber" class="form-control" readonly
                                placeholder="Select from Rooms page">
                        </div>
                    </div>

                    <!-- Personal Bio -->
                    <div class="form-row">
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" class="form-control" required placeholder="John Doe">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="studentId">Student Register Number</label>
                            <input type="text" id="studentId" class="form-control" required placeholder="e.g. SC-2023-001">
                        </div>
                        <div class="form-group">
                            <label for="yearOfStudy">Year of Student</label>
                            <select id="yearOfStudy" class="form-control" required>
                                <option value="" disabled selected>Select Year</option>
                                <option value="1st Year">1st Year</option>
                                <option value="2nd Year">2nd Year</option>
                                <option value="3rd Year">3rd Year</option>
                                <option value="4th Year">4th Year</option>
                            </select>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" class="form-control" required placeholder="john@example.com">
                        </div>
                         <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" class="form-control" required placeholder="+1 234 567 8900">
                        </div>
                    </div>

                    <!-- Booking Details -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="checkIn">Check-in Date</label>
                            <input type="date" id="checkIn" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="duration">Duration</label>
                            <select id="duration" class="form-control" required>
                                <option value="1-semester">1 Semester</option>
                                <option value="2-semesters">2 Semesters (1 Year)</option>
                                <option value="summer">Summer Only</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary" style="width: 100%;">Submit Reservation Request</button>
                    <p style="text-align: center; margin-top: 1rem; font-size: 0.9rem; color: #666;">
                        <a href="rooms.php" style="text-decoration: underline;">Change Room Selection</a>
                    </p>
                </form>
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
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="admin-login.php">Admin Login</a>
            </div>
            <p class="copyright">&copy; 2025 SOLID CAMPUS Reservation.</p>
        </div>
    </footer>

    <!-- Success Modal -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <div class="success-icon">🎉</div>
            <h2>Request Submitted!</h2>
            <p>Your room reservation request has been successfully sent. We will review it and confirm your booking very soon.</p>
            <button class="btn-modal" onclick="closeModal()">OK, Great!</button>
        </div>
    </div>

    <script src="js/script.js"></script>
    <script>
        // Parse URL parameters to pre-fill form
        document.addEventListener('DOMContentLoaded', () => {
            const params = new URLSearchParams(window.location.search);
            const building = params.get('building');
            const room = params.get('room');

            if (building && room) {
                document.getElementById('building').value = building;
                document.getElementById('roomNumber').value = room;

                const summaryDiv = document.getElementById('selectionSummary');
                const summaryText = document.getElementById('summaryText');
                summaryDiv.style.display = 'block';
                summaryText.textContent = `${building} - Room ${room}`;
            }
        });

        // Form Submission to API
        document.getElementById('reservationForm').addEventListener('submit', (e) => {
            e.preventDefault();
            
            const building = document.getElementById('building').value;
            if (!building) {
                alert('Please go back to the Hostels page and select a room first.');
                return;
            }

            const formData = {
                name: document.getElementById('name').value,
                student_id: document.getElementById('studentId').value,
                year: document.getElementById('yearOfStudy').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                building: building,
                room: document.getElementById('roomNumber').value
            };

            const submitBtn = e.target.querySelector('.btn-primary');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Processing...';
            submitBtn.disabled = true;

            fetch('api/book_room.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.text())
            .then(text => {
                try {
                    const data = JSON.parse(text);
                    if(data.success) {
                        // Show Success Modal
                        document.getElementById('successModal').style.display = 'block';
                        document.getElementById('reservationForm').reset();
                    } else {
                        alert('Error: ' + data.message);
                    }
                } catch (e) {
                    console.error('Server returned invalid JSON:', text);
                    alert('Server Error: ' + text.substring(0, 100)); // Show start of error
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred: ' + error.message);
            })
            .finally(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });

        function closeModal() {
            window.location.href = 'rooms.php';
        }
    </script>
</body>
</html>
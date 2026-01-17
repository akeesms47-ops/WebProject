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
    <title>Solid Campus Hostel Reservation - Contact Us</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .contact-content {
            padding: 8rem 2rem 4rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            margin-top: 3rem;
        }

        .contact-info-item {
            margin-bottom: 2rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .icon-box {
            background: var(--light-bg);
            padding: 1rem;
            border-radius: 50%;
            color: var(--secondary-color);
            font-size: 1.2rem;
        }

        .info-text h3 {
            font-size: 1.2rem;
            margin-bottom: 0.3rem;
        }

        .map-container {
            width: 100%;
            height: 100%;
            min-height: 400px;
            background: #eee;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
        }

        @media (max-width: 768px) {
            .contact-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
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
                <li><a href="rooms.php">Hostels</a></li>
                <li><a href="reservation.php">Reservation</a></li>
                <li><a href="contact.php" class="active">Contact</a></li>
                <li><a href="admin-login.php">Admin</a></li>
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
        <section class="contact-content">
            <div class="section-title">
                <h1>Get in Touch</h1>
                <p>Have questions? We're here to help you settling in.</p>
            </div>

            <div class="contact-grid">
                <div class="contact-info">
                    <div class="contact-info-item">
                        <div class="icon-box">📍</div>
                        <div class="info-text">
                            <h3>Our Location</h3>
                            <p>Solid University,<br>Ampara,Kalmunai-01,Sri Lanka.</p>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <div class="icon-box">📞</div>
                        <div class="info-text">
                            <h3>Phone Number</h3>
                            <p>076-3535-455<br>Mon - Fri, 8:00 AM - 6:00 PM</p>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <div class="icon-box">✉️</div>
                        <div class="info-text">
                            <h3>Email Address</h3>
                            <p>housing@ati.edu<br>support@atihostel.com</p>
                        </div>
                    </div>
                </div>

                <div class="map-container">
<img src="images/hostel-view.png" alt="View of Solid Campus Hostel Buildings" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-logo">
                <h3>Solid Campus Hostel Reservation</h3>
                <p>Providing quality accommodation for students since 2010.</p>
            </div>
            <div class="footer-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="contact.html">Contact Us</a>
                <a href="admin-login.php">Admin Login</a>
                <p class="copyright">&copy; 2025 Solid Campus Hostel Reservation. All rights reserved.</p>
            </div>
    </footer>

    <script src="js/script.js"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solid Campus Hostel Reservation - Student Accommodation</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
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
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="rooms.php">Hostels</a></li>
                <li><a href="reservation.php">Reservation</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="student-login.php" style="color: var(--secondary-color);">Student Login</a></li>
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
        <section class="hero">
            <div class="hero-content fade-in">
                <h1>Welcome Home, Students</h1>
                <p>Secure, comfortable, and affordable campus living. Choose your room in Building A or B today.</p>
                <a href="rooms.php" class="btn-primary">Student Login to Book</a>
            </div>
        </section>

        <!-- Facilities Overview instead of Room Gallery -->
        <section class="featured-rooms">
            <div class="section-title fade-in">
                <h2>Campus Living Experience</h2>
                <p>More than just a room—it's a community.</p>
            </div>
            <div class="features-grid">
                <!-- Facility 1 -->
                <div class="feature-card fade-in stagger-1" style="text-align: center;">
                    <div style="font-size: 3rem; padding: 2rem 0; color: var(--secondary-color);">🏢</div>
                    <div class="feature-info">
                        <h3>Two Modern Buildings</h3>
                        <p>Separate hostels for Boys (Building A) and Girls (Building B) with 24/7 security.</p>
                    </div>
                </div>

                <!-- Facility 2 -->
                <div class="feature-card fade-in stagger-2" style="text-align: center;">
                    <div style="font-size: 3rem; padding: 2rem 0; color: var(--secondary-color);">📚</div>
                    <div class="feature-info">
                        <h3>Study Environment</h3>
                        <p>Quiet study halls on every floor and high-speed Wi-Fi throughout the campus.</p>
                    </div>
                </div>

                <!-- Facility 3 -->
                <div class="feature-card fade-in stagger-3" style="text-align: center;">
                    <div style="font-size: 3rem; padding: 2rem 0; color: var(--secondary-color);">🍽️</div>
                    <div class="feature-info">
                        <h3>Full Amenities</h3>
                        <p>Hygienic mess facilities, laundry service, and recreational common rooms.</p>
                    </div>
                </div>
            </div>

            <div style="text-align: center; margin-top: 3rem;">
                <a href="rooms.html" class="btn-primary" style="display: inline-block;">View Building Maps</a>
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
</body>

</html>
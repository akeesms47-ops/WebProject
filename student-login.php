<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login - SOLID CAMPUS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            background-color: var(--light-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .login-card {
            background: var(--white);
            padding: 3rem;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .login-header {
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-group input:focus {
            border-color: var(--secondary-color);
            outline: none;
        }

        .alert-error {
            background-color: #fee;
            color: #c0392b;
            padding: 0.8rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            display: none;
            font-size: 0.9rem;
        }

        .back-link {
            display: block;
            margin-top: 1.5rem;
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        .back-link:hover {
            color: var(--secondary-color);
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <div class="logo-container" style="align-items: center; margin-bottom: 1rem;">
                <div class="logo" style="justify-content: center;">
                    <span class="at-logo">SOLID</span> CAMPUS
                </div>
                <div class="vision">Empowering Future Leaders</div>
            </div>
            <h2>Student Login</h2>
            <p>Access your hostel dashboard</p>
        </div>

        <div id="error-msg" class="alert-error">Invalid Email or Password</div>

        <form id="loginForm">
            <div class="form-group">
                <label for="email">Student Email</label>
                <input type="email" id="email" placeholder="student@solid.edu" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="********" required>
            </div>
            <button type="submit" class="btn-primary" style="width: 100%; border: none; cursor: pointer;">Login</button>
        </form>

        <a href="index.php" class="back-link">← Back to Home</a>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', (e) => {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const pass = document.getElementById('password').value;
            const errorMsg = document.getElementById('error-msg');
            const submitBtn = e.target.querySelector('button');

            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Verifying...';
            submitBtn.disabled = true;

            fetch('api/student_login.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email: email, password: pass })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    errorMsg.style.display = 'none';
                    window.location.href = 'rooms.php'; // Redirect to rooms after login
                } else {
                    errorMsg.style.display = 'block';
                    errorMsg.textContent = data.message || 'Login failed';
                    const card = document.querySelector('.login-card');
                    card.style.transform = 'translateX(10px)';
                    setTimeout(() => card.style.transform = 'translateX(0)', 100);
                }
            })
            .catch(err => {
                console.error(err);
                errorMsg.style.display = 'block';
                errorMsg.textContent = 'Server error';
            })
            .finally(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });
    </script>
</body>
</html>

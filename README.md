# SOLID CAMPUS - Installation & User Guide

## 1. Prerequisites
You need a local server environment to run PHP and MySQL.
- **Download XAMPP**: [https://www.apachefriends.org/download.html](https://www.apachefriends.org/download.html)
- Install it (default options are fine).

## 2. Start the Server
1. Open **XAMPP Control Panel**.
2. Click **Start** corresponding to **Apache**.
3. Click **Start** corresponding to **MySQL**.
   *(They should turn green).*

## 3. Setup the Database
1. Open your browser and go to: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2. Click **New** (sidebar) -> type Database Name: `hostel` -> Click **Create**.
3. Click the **Import** tab (top menu).
4. Click **Choose File** and select the file:
   `c:/Users/HP/Desktop/NEW/database/hostel.sql`
5. Scroll down and click **Import** (or Go).
   *(You should see a success message).*

## 4. Deploy the Website
1. Locate your project folder: `c:/Users/HP/Desktop/NEW`
2. **Copy** the entire `NEW` folder.
3. Go to your XAMPP installation folder (usually `C:\xampp`).
4. Keep going into the `htdocs` folder: `C:\xampp\htdocs\`.
5. **Paste** your `NEW` folder here.
   *Final path should look like: `C:\xampp\htdocs\NEW\`*

## 5. Run the Website
1. Open your browser.
2. Visit: [http://localhost/NEW/index.php](http://localhost/NEW/index.php)

## 6. Login Credentials

### Student Login (To Book Rooms)
- **URL**: [http://localhost/NEW/student-login.php](http://localhost/NEW/student-login.php)
- **Email**: `student@solid.edu`
- **Password**: `student123`

### Admin Login (To View Bookings)
- **URL**: [http://localhost/NEW/admin-login.php](http://localhost/NEW/admin-login.php)
- **Username**: `admin`
- **Password**: `admin123`

## Troubleshooting
- **"Site can't be reached"**: Make sure Apache is green in XAMPP.
- **"Database connection failed"**: Make sure MySQL is green in XAMPP and you imported `hostel.sql`.
- **PHP Code showing as text**: Ensure you are using `http://localhost/NEW/...` and NOT `file:///C:/...`.

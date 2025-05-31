# 👤 User Management System — Registration, Login & Profile

A complete, secure, and responsive web application for user registration, login, and profile management. This project demonstrates the integration of multiple technologies such as PHP, MySQL, Redis, and jQuery AJAX to provide a seamless user experience with modern session handling and strict security best practices.

---

## 🧩 Project Overview

This system allows users to register, securely log in, and manage their profile data (like age, DOB, and contact number). The application uses AJAX calls (without traditional form submissions) to handle real-time communication between the frontend and backend.

### 🔁 Flow of the Application

> **Flow: Register → Login → Profile View & Update**


---

## 🔐 Security & Session Management

- **Password Hashing**: All user passwords are securely hashed using `password_hash()` before being stored in the database.
- **Prepared Statements**: Used throughout to prevent SQL injection attacks.
- **Redis Sessions**: Session tokens are securely generated and stored in Redis for fast, scalable session management.
- **LocalStorage Tokens**: Browser localStorage is used to persist authentication tokens client-side (no PHP sessions used).
- **Validation**: Both client-side and server-side validation are enforced for all input fields.

---

## 🎯 Key Features

### ✅ Signup
- Real-time validation
- Password strength check (uppercase, lowercase, number, special character, min length)
- AJAX-based data submission to `signup.php`

### ✅ Login
- Secure login via email and password
- Token-based authentication
- Redis-backed session tracking
- AJAX request to `login.php` and token stored in localStorage

### ✅ Profile Page
- Loads profile data after verifying login token
- Allows user to update additional fields like:
  - Age
  - Date of Birth
  - Contact Number
- AJAX requests for both fetching and updating profile info

---

## 📁 Project Directory Structure

project-root/
```│
├── css/
│   ├── profile.css          # Styles for profile page
│   ├── login.css            # Styles for login page
│   └── signup.css           # Styles for signup page
│
├── js/
│   ├── signup.js            # Handles registration AJAX and validation
│   ├── login.js             # Manages login authentication and token storage
│   └── profile.js           # Loads and updates user profile via AJAX
│
├── php/
│   ├── db.php               # MySQL database connection
│   ├── signup.php           # Signup logic (validations + insert)
│   ├── login.php            # Login logic (authentication + Redis)
│   ├── getProfile.php       # Returns profile info for logged-in user
│   ├── updateProfile.php    # Handles profile update requests
│   └── redisSession.php     # Redis connection setup
│
├── index.html               # Login page
├── signup.html              # Signup form
├── profile.html             # Profile details and update UI
└── README.md                # Project documentation

----
```
## 🧠 Technologies Used

| Frontend      | Backend     | Database  | Caching  |
|---------------|-------------|-----------|----------|
| HTML5         | PHP 8+      | MySQL     | Redis    |
| Bootstrap 5   | PDO         |           |          |
| JavaScript    |             |           |          |
| jQuery + AJAX |             |           |          |

---

## 📌 Important Notes

- All form interactions happen via **jQuery AJAX** (no page reloads).
- Passwords are never stored in plain text.
- Redis ensures fast and secure token session storage.
- Login tokens are only stored on the client in **localStorage**.

---

## ⚙️ Setup Instructions

### 🔧 Prerequisites

- PHP 8 or higher
- MySQL
- Redis server
- Web server (Apache/XAMPP/Laragon)

### 🛠 Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/your-repo-name.git
   cd your-repo-name
   
2. **Database Setup**
  Create a MySQL database (e.g., user_system)

  Run this SQL to create the users table:
  ```
  CREATE TABLE users (
      id INT AUTO_INCREMENT PRIMARY KEY,
      username VARCHAR(100) NOT NULL,
      email VARCHAR(100) NOT NULL UNIQUE,
      password VARCHAR(255) NOT NULL,
      age INT DEFAULT NULL,
      dob DATE DEFAULT NULL,
      contact VARCHAR(20) DEFAULT NULL
  );
```
  Update your DB credentials in php/db.php

3. **Start Redis**
   ```
          redis-server
   ```
4. **Run the Application**

    Place the project folder in your web server directory (e.g., htdocs/ for XAMPP)
    
    Open signup.html or index.html in your browser


----

🧪 Password Rules for Signup
```
      1. At least 8 characters 
      2. One uppercase letter
      3. One lowercase letter
      4. One numeric digit
      5. One special character (e.g., !@#$%^&*())
```
      
----

🧹 Future Enhancements
```
     1.  Add profile picture upload using AJAX + PHP
     2.  Reset password functionality
     3.  Email verification after registration
     4.  OAuth login via Google or GitHub
     5.  Admin dashboard for user management
```

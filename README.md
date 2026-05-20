# Home-Amenity
Home Amenity is a web application that provides home services maintenance by connecting workers and customers at one secure platform.
# 🏠 Home Amenity

> A web-based home services platform that connects customers with skilled local workers for household tasks — built with PHP, MySQL, and vanilla JavaScript.

---

## 📌 About the Project

**Home Amenity** solves the everyday problem of finding reliable, nearby home service professionals. Instead of asking around or searching endlessly, customers can simply visit the platform, pick a service, find a verified worker in their city, and book them instantly.

The platform supports three types of users:

| Role | Description |
|------|-------------|
| 🛡️ **Admin** | Manages worker registrations, approves/rejects workers, sends email notifications |
| 🔧 **Worker** | Registers, gets verified, views bookings and chats with customers |
| 👤 **Customer** | Browses services, books workers, gives feedback and ratings |

---

## ✨ Features

- 🔍 **Service Browsing** — Electrician, Plumber, AC Servicing, and more with starting prices
- 📍 **Location-Based Matching** — Workers matched by city using GPS or manual entry
- 📅 **Booking System** — Customers book workers with preferred time slots
- ✅ **Worker Verification** — Admin approves workers before they appear in search results
- 📧 **Email Notifications** — PHPMailer + Gmail SMTP notifies workers upon approval
- 💬 **Chat System** — Real-time messaging between customers and workers
- 🌟 **Feedback & Ratings** — Customers rate workers after service completion
- 🔔 **Order Notifications** — Workers see a live badge count of new bookings on their profile
- 📱 **Fully Responsive** — Works on mobile, tablet, and desktop

---


---

## 🛠️ Tech Stack

| Technology | Purpose |
|------------|---------|
| **PHP 8+** | Backend logic, session management |
| **MySQL** | Database (workers, bookings, messages, feedback) |
| **HTML/CSS/JS** | Frontend UI |
| **PHPMailer** | Email notifications via Gmail SMTP |
| **Font Awesome** | Icons |
| **XAMPP/WAMP** | Local development server |

---

## ⚙️ Installation & Setup

### Prerequisites
- XAMPP or WAMP installed
- PHP 8.0+
- MySQL 5.7+

### Steps

 **Clone the repository**
   ```bash
   git clone https://github.com/your-username/home-amenity.git
   ```


 **Run the project**
   - Start Apache and MySQL in XAMPP
   - Visit: `http://localhost/Home-Amenity/home.php`

---

## 🔐 Admin Access

Navigate to:
```
http://localhost/Home-Amenity/admin/admin.php
```
Use the admin password configured in `admin.php`.

> ⚠️ **Note:** For production, store credentials using environment variables and hash passwords with `password_hash()`.

---



## 🗄️ Database Tables

| Table | Description |
|-------|-------------|
| `workers` | Worker registrations (name, city, category, rate, status) |
| `booking` | Customer bookings (worker_id, service, city, time, rate) |
| `messages` | Chat messages between customers and workers |
| `feedback` | Customer ratings and reviews |

---


## 👨‍💻 Author

**Your Name**
- Email: harrmharrm786@gmail.com

---

## 📄 License

This project is for educational purposes. Feel free to use and modify.

---

> Built with ❤️ as a university project — Home Amenity, Pakistan 🇵🇰

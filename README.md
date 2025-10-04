# 🏠 Rental Platform – Laravel Project

## 📘 Overview
**Rental Platform** is a full-stack web application built with **Laravel (PHP)** that connects **students** seeking rentals with **landlords** offering properties, under the supervision of an **admin**.  
It provides a streamlined workflow for property listings, rental requests, approvals, and management, using role-based access control and a modern UI.

---

## 🧰 Tech Stack

| Category | Technology |
|-----------|-------------|
| **Backend** | Laravel 11 (PHP 8.2) |
| **Frontend** | Blade Templates + TailwindCSS |
| **Database** | MySQL |
| **Authentication** | Laravel Breeze |
| **Version Control** | Git + GitHub |
| **Deployment** | VPS / Nginx / GitHub Actions |
| **Testing** | PHPUnit / Laravel Test Suite |
| **Architecture** | MVC (Model–View–Controller) |
| **Project Management** | GitHub Projects (Scrum) |

---

## 🧠 System Architecture

**Overview**

The system follows a classic **three-tier architecture** — separating presentation, business logic, and data layers for scalability and maintainability.
```
Frontend (Presentation Layer)
│
├── Built with Blade Templates + TailwindCSS
│ ├── Handles user interface and form input
│ ├── Displays data from controllers
│ └── Provides responsive, mobile-friendly layouts
│
Backend (Application Layer)
│
├── Laravel Controllers & Models
│ ├── Contains application logic
│ ├── Applies role-based authentication and middleware
│ └── Interacts with the database using Eloquent ORM
│
Database (Data Layer)
│
└── MySQL Database
├── Tables: users, rentals, rental_requests, activities
├── Enforces relational integrity and constraints
└── Stores all persistent application data
```
**Data Flow**
1. **Frontend** sends HTTP requests (form submissions, page loads).
2. **Backend** processes requests, validates data, applies business logic.
3. **Database** stores or retrieves the required data.
4. **Backend** returns responses which are rendered by the **Frontend**.


---

## 👥 User Roles and Permissions

| Role | Access | Features |
|------|---------|-----------|
| **Student** | Authenticated | Browse rentals, send requests, view request status |
| **Landlord** | Authenticated | Post rentals, view requests, approve/reject |
| **Admin** | Authenticated (role=admin) | Manage users, rentals, requests, logs, reports |

---

## 🚀 Key Features

### 👨‍🎓 Student
- Registration & Login
- View available rentals with filters
- Send rental requests
- Track request status

### 🏠 Landlord
- Post new rental listings (with images)
- Manage rentals (edit/delete)
- Approve or reject student requests
- View request history

### 🛠️ Admin
- Manage users and listings
- Moderate rental content
- View reports and statistics
- Review system logs and activities

---

## ⚙️ Installation & Setup

### 🧾 Requirements
- PHP ≥ 8.2
- Composer ≥ 2.6
- MySQL ≥ 8.0
- Node.js + npm (for frontend assets)

---

### 🪜 Step 1: Clone Repository
```bash
git clone https://github.com/imuzaffaar/SDM2025FALLRENTAL.git
cd SDM2025FALLRENTAL
``` 
### 🪜 Step 2: Install Dependencies
```bash
composer install
npm install
npm run dev
```
### 🪜 Step 3: Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

### 🪜 Step 4: Database Migration & Seeding
```bash
php artisan migrate --seed

This seeds initial users:

Student → student@example.com / password

Landlord → landlord@example.com / password

Admin → admin@example.com / password
```

### 🪜 Step 5: Run the Application
```bash
php artisan serve
Visit → http://localhost:8000
```

### 🧱 Folder Structure (Simplified)
```bash
rental-platform-laravel/
│
├── app/              # Controllers, Models, Middleware
├── resources/views/  # Blade templates
├── routes/web.php    # Web routes
├── database/migrations/
├── public/           # Public assets & uploads
├── .env              # Environment config
└── README.md
```
---
## 🧩 Testing

### Run automated tests:
```
php artisan test
```

### Run specific test:
```
php artisan test --filter=AuthTest


✅ All critical features (auth, roles, rental management, requests) are covered.
```
## 🚦 Deployment Guide

### 🪜 Step 1: Upload to Server
```
git clone https://github.com/<username>/rental-platform-laravel.git
cd rental-platform-laravel
composer install --no-dev
```

### 🪜 Step 2: Configure Environment

#### Update production .env:
```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

### 🪜 Step 3: Migrate & Optimize
```
php artisan migrate --force
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan storage:link
```

### 🪜 Step 4: Set Permissions
```
chmod -R 775 storage bootstrap/cache
```

## ⚙️ CI/CD (GitHub Actions)

#### GitHub Actions workflow file:
```
.github/workflows/deploy.yml
```

#### Triggers on push to main branch and:

Installs dependencies

Runs tests

Deploys automatically to server via SSH

## 🧩 Scrum Sprint Structure

| Sprint | Duration | Goal | Major Deliverables |
|--------|-----------|------|--------------------|
| **Sprint 1** | Oct 5 – Oct 12 | Setup & Authentication | Laravel setup, roles, dashboard |
| **Sprint 2** | Oct 13 – Oct 20 | Student & Landlord Features | CRUD + rental requests + filters |
| **Sprint 3** | Oct 21 – Oct 28 | Admin Dashboard & Management | User management, reports, logs |
| **Sprint 4** | Oct 29 – Nov 5 | Testing & Deployment | Unit tests, optimization, CI/CD deployment |


Each sprint contains 8–10 GitHub Issues linked via Milestones.

## 🧠 Database Schema Overview

| Table              | Key Columns                                                          | Description              |
|--------------------|----------------------------------------------------------------------|--------------------------|
| `users`            | `id`, `name`, `email`, `password`, `role`                            | Stores all user data.    |
| `rentals`          | `id`, `title`, `landlord_id`, `price`, `location`, `status`, `image_path` | Rental listings.         |
| `rental_requests`  | `id`, `rental_id`, `student_id`, `status`, `message`                 | Student rental requests. |
| `activities`       | `id`, `user_id`, `action`, `details`, `created_at`                   | System activity logs.    |


## 🧩 API Endpoints (for Future Extension)

| Method | Endpoint                      | Role      | Description                         |
|-------:|-------------------------------|-----------|-------------------------------------|
|   GET  | `/rentals`                    | Student   | View all rentals.                   |
|   GET  | `/rentals/{id}`               | Student   | View a single rental.               |
|  POST  | `/rentals/{id}/request`       | Student   | Create a rental request.            |
|  POST  | `/landlord/rentals`           | Landlord  | Create a new rental listing.        |
| PATCH  | `/landlord/requests/{id}`     | Landlord  | Approve or reject a request.        |
|   GET  | `/admin/users`                | Admin     | List/manage users.                  |
|   GET  | `/admin/rentals`              | Admin     | List/manage all rentals.            |
|   GET  | `/admin/requests`             | Admin     | List/manage all requests.           |


## 💡 Future Enhancements

- Real-time chat between students & landlords
- Payment integration (Stripe or PayPal)
- Email verification & password recovery
- ReactJS frontend version
- Multi-language support (English, Hungarian, Uzbek)
- Image CDN & caching for faster loads


## 🤝 Contributing

1. **Fork** the repository.
2. Create a feature branch:
   ```bash
   git checkout -b feature/<short-descriptor>
   ```

## 🪪 License

* This project is open-sourced under the MIT License.

## 👨‍💻 Authors

* ***Muzaffar Tursunov***
* ***Kirtan Ramwani***
* ***Ghadi Dababneh***
* ***Hussain***
* 📍 University of Debrecen, Faculty of Informatics Hungary
* 💻 Software Engineer & Full-Stack Developer


---

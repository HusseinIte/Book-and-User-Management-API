# Book and User Management API

## Overview
This project is a combined system for managing books, categories, users, roles, and permissions using Laravel. It features two main sections: a **Book and Category Management API** and a **User Management System** with Roles and Permissions.

### Features:

#### Book and Category Management:
- Add a new category.
- Add a book with its associated category.
- View a list of books by category.
- Update book details and its category.
- Delete a book or a category.

#### User Management System:
- Add a new user with a role and permissions.
- Update user details, role, and permissions.
- View a list of users with their roles and permissions.
- Delete a user.
- Create new roles and permissions.
- Assign specific permissions to a role.
- Restrict certain actions based on assigned permissions.

## Technologies Used:
- **Laravel**: PHP framework for backend development.
- **MySQL**: Database management system.
- **Laravel Jwt**: Used for API authentication.
- **Custom Role and Permission Management**: Simulating the functionality of the Spatie Laravel-Permission package.

### Steps to Run the System


- [Installation](#installation)
 1. **Clone the repository:**
 
     ```bash
     git clone https://github.com/HusseinIte/Book-and-User-Management-API.git
     cd Book-and-User-Management-API
     ```
 
 2. **Install dependencies:**
 
     ```bash
     composer install
     npm install
     ```
 
 3. **Copy the `.env` file:**
 
     ```bash
     cp .env.example .env
     ```
 
 4. **Generate an application key:**
 
     ```bash
     php artisan key:generate
     ```
 
 5. **Configure the database:**
 
     Update your `.env` file with your database credentials.
 
 6. **Run the migrations:**
 
     ```bash
     php artisan migrate --seed
     ```
 7. **Run the seeders (Optional):**
 
     If you want to populate the database with sample data, use the seeder command:
 
     ```bash
     php artisan db:seed
     ```
 8. **Serve the application:**
 
     ```bash
     php artisan serve
     ```

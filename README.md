# Easybooking.com - Travel Booking Website

A comprehensive travel booking website built with PHP, MySQL, HTML, CSS, and JavaScript.

## Features

- User registration and authentication
- Hotel search and booking
- Flight search and booking
- Car rental search and booking
- User profile management
- Booking management (view, cancel)
- Property listing for hotel owners
- Contact form
- Responsive design

## Installation

1. Clone the repository:
   \`\`\`
   git clone https://github.com/yourusername/easybooking.git
   \`\`\`

2. Import the database:
   - Create a MySQL database named `easybooking`
   - Import the `database/db_setup.sql` file

3. Configure the database connection:
   - Open `includes/db_connect.php`
   - Update the database credentials:
     \`\`\`php
     $host = 'localhost';
     $dbname = 'easybooking';
     $username = 'your_username';
     $password = 'your_password';
     \`\`\`

4. Upload the files to your web server or run locally using PHP's built-in server:
   \`\`\`
   php -S localhost:8000
   \`\`\`

5. Access the website:
   - If using a local server: http://localhost:8000
   - If using a web server: http://yourdomain.com

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache, Nginx, etc.)

## Directory Structure

- `css/` - CSS stylesheets
- `js/` - JavaScript files
- `images/` - Image files
- `includes/` - PHP include files
- `uploads/` - User uploaded files
- `database/` - Database setup files

## License

This project is licensed under the MIT License - see the LICENSE file for details.

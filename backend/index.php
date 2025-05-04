<?php
require __DIR__ . '/../vendor/autoload.php';

// DAO files
require 'dao/ProductDAO.php';
require 'dao/CategoryDAO.php';
require 'dao/UserDAO.php';
require 'dao/ReviewDAO.php';
require 'dao/ContactDAO.php';

// Service files
require 'services/ProductService.php';
require 'services/CategoryService.php';
require 'services/UserService.php';
require 'services/ReviewService.php';
require 'services/ContactService.php';

// Route files
require 'routes/products.php';
require 'routes/categories.php';
require 'routes/users.php';
require 'routes/reviews.php';
require 'routes/contacts.php';

// Database connection
Flight::set('pdo', new PDO('mysql:host=localhost;dbname=your_db', 'username', 'password'));

// Start the application
Flight::start();



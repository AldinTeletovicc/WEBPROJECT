<?php
require 'vendor/autoload.php';
require 'dao/ProductDAO.php';
require 'dao/CategoryDAO.php';
require 'dao/UserDAO.php';
require 'dao/ReviewDAO.php';
require 'dao/ContactDAO.php';

require 'services/ProductService.php';
require 'services/CategoryService.php';     
require 'services/UserService.php';
require 'services/ReviewService.php';
require 'services/ContactService.php';

require 'routes/products.php';
require 'routes/categories.php';
require 'routes/users.php';
require 'routes/reviews.php';
require 'routes/contacts.php';


require 'dao/UserDAO.php';
require 'services/UserService.php';
require 'routes/users.php';

require 'dao/ProductDAO.php';
require 'services/ProductService.php';
require 'routes/products.php';

require 'dao/CategoryDAO.php';
require 'services/CategoryService.php';
require 'routes/categories.php';

require 'dao/ReviewDAO.php';
require 'services/ReviewService.php';
require 'routes/reviews.php';

require 'dao/ContactDAO.php';
require 'services/ContactService.php';
require 'routes/contacts.php';

require_once 'middlewares/AuthMiddleware.php';




Flight::set('pdo', new PDO('mysql:host=localhost;dbname=your_db', 'username', 'password'));

Flight::start();
require 'vendor/autoload.php';
require 'rest/services/AuthService.php';
require 'rest/services/RestaurantService.php';
require "middleware/AuthMiddleware.php";


use Firebase\JWT\JWT;
use Firebase\JWT\Key;


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);




Flight::register('restaurantService', 'RestaurantService');
Flight::register('auth_service', "AuthService");
Flight::register('auth_middleware', "AuthMiddleware");


Flight::route('/*', function() {
   if(
       strpos(Flight::request()->url, '/auth/login') === 0 ||
       strpos(Flight::request()->url, '/auth/register') === 0
   ) {
       return TRUE;
   } else {
       try {
           $token = Flight::request()->getHeader("Authentication");
           if(Flight::auth_middleware()->verifyToken($token))
               return TRUE;
       } catch (\Exception $e) {
           Flight::halt(401, $e->getMessage());
       }
   }
});
require_once __DIR__ .'/rest/routes/AuthRoutes.php';
require_once __DIR__ . '/rest/routes/RestaurantRoutes.php';
Flight::start();




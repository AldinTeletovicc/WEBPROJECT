<?php
class Middleware {

    public function before($params) {
        if(isset($_SESSION['user']) === false) {
            return false;
        }
    }
}
// i used return false example from lab 
class AuthMiddleware {
    public static function requireLogin() {
        Flight::route('*', function() {
            session_start();
            if (!isset($_SESSION['user'])) {
                Flight::halt(401, 'Unauthorized');
            }
        });
    }
    

    public static function requireRole($role) {
        return function() use ($role) {
            if ($_SESSION['user']['role'] !== $role) {
                Flight::halt(403, 'Forbidden');
            }
        };
    }
}

?>
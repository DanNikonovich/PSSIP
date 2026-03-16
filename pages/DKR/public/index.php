<?php
session_start();

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/app/Core/Router.php';

require_once BASE_PATH . '/app/Controllers/HomeController.php';
require_once BASE_PATH . '/app/Controllers/BookingController.php';
require_once BASE_PATH . '/app/Controllers/PromoController.php';
require_once BASE_PATH . '/app/Controllers/AuthController.php';
require_once BASE_PATH . '/app/Controllers/TelegramController.php';
require_once BASE_PATH . '/app/Controllers/AdminController.php';
require_once BASE_PATH . '/app/Controllers/CommentController.php';
require_once BASE_PATH . '/app/Models/BookingSlot.php';
require_once BASE_PATH . '/app/Core/AdminAuth.php';
require_once BASE_PATH . '/app/Core/DB.php';

$pdo = DB::connect();

$router = new Router();

// роуты
$router->get('/', [HomeController::class, 'index']);
$router->get('/rules', [HomeController::class, 'rules']);
$router->get('/promo', [PromoController::class, 'index']);
$router->get('/booking', [BookingController::class, 'form']);
$router->get('/booking/slots', [BookingController::class, 'getSlots']);
$router->get('/login', [AuthController::class, 'loginForm']);
$router->get('/register', [AuthController::class, 'registerForm']);
$router->get('/logout', [AuthController::class, 'logout']);
$router->get('/admin/login',  [AdminController::class, 'loginForm']);
$router->get('/booking/success', [BookingController::class, 'success']);
$router->get('/admin',                [AdminController::class, 'dashboard']);
$router->get('/admin/comments',       [AdminController::class, 'comments']);
$router->get('/admin/logout', [AdminController::class, 'logout']);
$router->get('/admin/bookings',       [AdminController::class, 'bookings']);
$router->get('/admin/bookings/export-week', [AdminController::class, 'exportWeekCsv']);
$router->get('/admin/faq',            [AdminController::class, 'faq']);
$router->get('/comments/after-login', [CommentController::class, 'afterLogin']);

// POST маршруты (если твой Router пока только get — ниже дам как расширить)
$router->post('/login', [AuthController::class, 'login']);
$router->post('/register', [AuthController::class, 'register']);
$router->post('/booking', [BookingController::class, 'store']);
$router->post('/tg/webhook', [TelegramController::class, 'webhook']);
$router->post('/admin/login', [AdminController::class, 'login']);
$router->post('/admin/comments/approve', [AdminController::class, 'commentApprove']);
$router->post('/admin/comments/delete',  [AdminController::class, 'commentDelete']);
$router->post('/admin/faq/create',    [AdminController::class, 'faqCreate']);
$router->post('/admin/faq/update',    [AdminController::class, 'faqUpdate']);
$router->post('/admin/faq/delete',    [AdminController::class, 'faqDelete']);
$router->post('/admin/faq/toggle',    [AdminController::class, 'faqToggle']);
$router->post('/comments/store', [CommentController::class, 'store']);


$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);




<?php
require_once BASE_PATH . '/app/Core/Controller.php';
require_once BASE_PATH . '/app/Models/User.php';

class AuthController extends Controller
{
    public function loginForm(): void
    {
        $this->view('login');
    }

    public function registerForm(): void
    {
        $this->view('register');
    }

    public function register(): void
    {
        $name  = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $pass  = $_POST['password'] ?? '';

        if ($name === '' || $email === '' || $pass === '') {
            http_response_code(400);
            echo "Заполните имя, email и пароль.";
            return;
        }

        if (User::findByEmail($email)) {
            http_response_code(409);
            echo "Пользователь с таким email уже существует.";
            return;
        }

        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $id = User::create($name, $email, $phone, $hash);

        $_SESSION['user'] = [
            'id_user' => $id,
            'name'    => $name,
            'email'   => $email,
            'phone'   => $phone,
            'role'    => 'user',
        ];

        header('Location: /');
        exit;
    }

    public function login(): void
    {
        $email = trim($_POST['email'] ?? '');
        $pass  = $_POST['password'] ?? '';

        $user = User::findByEmail($email);
        if (!$user || !password_verify($pass, $user['password_hash'])) {
            http_response_code(401);
            echo "Неверный email или пароль.";
            return;
        }

        $_SESSION['user'] = [
            'id_user' => (int)$user['id_user'],
            'name'    => $user['name'],
            'email'   => $user['email'],
            'phone'   => $user['phone'],
            'role'    => $user['role'],
        ];

        header('Location: /');
        exit;
    }

    public function logout(): void
    {
        unset($_SESSION['user']);
        session_destroy();
        header('Location: /');
        exit;
    }
}
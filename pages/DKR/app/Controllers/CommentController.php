<?php

require_once BASE_PATH . '/app/Core/Controller.php';
require_once BASE_PATH . '/app/Core/Auth.php';
require_once BASE_PATH . '/app/Models/Comment.php';

class CommentController extends Controller
{
    public function store(): void
    {
        $name   = trim($_POST['author_name'] ?? '');
        $text   = trim($_POST['text_review'] ?? '');
        $rating = (int)($_POST['rating'] ?? 0);

        if ($name === '' || $text === '' || $rating < 1 || $rating > 5) {
            http_response_code(400);
            echo "Заполните имя, отзыв и оценку.";
            return;
        }

        // гость — сохраняем в сессию и ведём на логин
        if (!Auth::check()) {
            $_SESSION['pending_comment'] = [
                'author_name' => $name,
                'text_review' => $text,
                'rating' => $rating,
            ];

            $_SESSION['redirect_after_login'] = '/comments/after-login';
            header("Location: /login");
            exit;
        }

        // залогинен — создаём pending
        $user = Auth::user();

        Comment::createPending([
            'id_user' => (int)$user['id_user'],
            'text_review' => $text,
            'rating' => $rating,
        ]);

        $_SESSION['flash_ok'] = 'Отзыв отправлен и ожидает одобрения администратора.';
        header("Location: /#reviews");
        exit;
    }

    public function afterLogin(): void
    {
        Auth::requireLogin();

        $pending = $_SESSION['pending_comment'] ?? null;
        unset($_SESSION['pending_comment']);

        if (!$pending) {
            header("Location: /#reviews");
            exit;
        }

        $user = Auth::user();

        Comment::createPending([
            'id_user' => (int)$user['id_user'],
            'text_review' => $pending['text_review'],
            'rating' => (int)$pending['rating'],
        ]);

        $_SESSION['flash_ok'] = 'Отзыв отправлен и ожидает одобрения администратора.';
        header("Location: /#reviews");
        exit;
    }

    // OPTIONAL helper (синхронизировать имя)
    private function syncUserName(int $idUser, string $name): void
    {
        $pdo = DB::connect();
        $stmt = $pdo->prepare("UPDATE users SET name=? WHERE id_user=?");
        $stmt->execute([$name, $idUser]);
    }
}
<?php

class TelegramController
{
    public function webhook(): void
    {
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);

        if (!$data || !isset($data['message'])) {
            http_response_code(200);
            echo "ok";
            return;
        }

        $chatId = $data['message']['chat']['id'] ?? null;
        $text   = trim($data['message']['text'] ?? '');

        if (!$chatId) {
            http_response_code(200);
            echo "ok";
            return;
        }

        // ожидаем команду вида: /link 6
        if (preg_match('~^/link\s+(\d+)$~u', $text, $m)) {
            $userId = (int)$m[1];

            $pdo = DB::connect();
            $stmt = $pdo->prepare("UPDATE users SET tg_chat_id = ? WHERE id_user = ?");
            $stmt->execute([$chatId, $userId]);

            $this->sendMessage($chatId, "✅ Telegram привязан! Теперь вы будете получать уведомления о бронировании.");
        } else {
            $this->sendMessage($chatId, "Привет! Чтобы привязать аккаунт, отправьте:\n/link <ваш ID>\nНапример: /link 6");
        }

        http_response_code(200);
        echo "ok";
    }

    private function sendMessage(int $chatId, string $text): void
    {
        $cfg = require BASE_PATH . '/config/telegram.php';
        $token = $cfg['bot_token'];

        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        $payload = [
            'chat_id' => $chatId,
            'text' => $text,
        ];

        // простая отправка через curl
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($payload),
            CURLOPT_TIMEOUT => 10,
        ]);
        curl_exec($ch);
        curl_close($ch);
    }
}
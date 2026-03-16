<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <link rel="icon" type="image/png" href="/assets/components/E.png">
  <title><?= htmlspecialchars($title ?? 'Админ — E-RIDE') ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body class="admin">
  <div class="admin-bg"></div>

  <header class="admin-top">
    <a class="admin-brand" href="/admin">
      <img src="/assets/components/logo.png" alt="E-RIDE">
      <span>Admin</span>
    </a>

    <nav class="admin-nav">
      <a href="/admin" class="<?= ($active ?? '')==='dash'?'is-active':'' ?>">Панель</a>
      <a href="/admin/comments" class="<?= ($active ?? '')==='comments'?'is-active':'' ?>">Комментарии</a>
      <a href="/admin/faq" class="<?= ($active ?? '')==='faq'?'is-active':'' ?>">FAQ</a>
      <a href="/admin/bookings" class="<?= ($active ?? '')==='bookings'?'is-active':'' ?>">Брони</a>
    </nav>

    <div class="admin-user">
      <div class="admin-user__name"><?= htmlspecialchars($admin['name'] ?? 'Admin') ?></div>
      <a class="admin-logout" href="/admin/logout">Выйти</a>
    </div>
  </header>

  <main class="admin-main">
    <?= $content ?? '' ?>
  </main>
</body>
</html>
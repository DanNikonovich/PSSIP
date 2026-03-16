<?php
$title = 'Админ панель — E-RIDE';
$active = 'dash';
ob_start();
?>
<section class="grid">
  <a class="tile" href="/admin/comments">
    <div class="tile__k">Комментарии на модерации</div>
    <div class="tile__v"><?= (int)($counts['pending_comments'] ?? 0) ?></div>
    <div class="tile__hint">Открыть модерацию →</div>
  </a>

  <a class="tile" href="/admin/faq">
    <div class="tile__k">Активных FAQ</div>
    <div class="tile__v"><?= (int)($counts['active_faq'] ?? 0) ?></div>
    <div class="tile__hint">Управлять FAQ →</div>
  </a>

  <a class="tile" href="/admin/bookings">
    <div class="tile__k">Бронирований на 7 дней</div>
    <div class="tile__v"><?= (int)($counts['week_bookings'] ?? 0) ?></div>
    <div class="tile__hint">Открыть календарь →</div>
  </a>
</section>
<?php
$content = ob_get_clean();
require BASE_PATH . '/app/Views/admin/layout.php';
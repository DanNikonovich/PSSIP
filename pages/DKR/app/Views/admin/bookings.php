<?php
$title = 'Бронирования — Admin E-RIDE';
$active = 'bookings';
ob_start();
?>

<section class="card">
  <div class="card__head">
    <div>
      <div class="card__title">Бронирования</div>
      <div class="card__sub">Просмотр + отчёт на неделю (CSV для Excel)</div>
    </div>
  </div>

  <form class="filters" method="get" action="/admin/bookings">
    <label class="field">
      <span class="field__label">С</span>
      <span class="field__input"><input type="date" name="from" value="<?= htmlspecialchars($from ?? '') ?>"></span>
    </label>
    <label class="field">
      <span class="field__label">По</span>
      <span class="field__input"><input type="date" name="to" value="<?= htmlspecialchars($to ?? '') ?>"></span>
    </label>
    <button class="btn btn--mini" type="submit">Показать</button>

    <a class="btn btn--mini btn--glow"
       href="/admin/bookings/export-week?from=<?= urlencode($from ?? '') ?>&to=<?= urlencode($to ?? '') ?>">
      Скачать отчёт (CSV)
    </a>
  </form>

  <div class="table">
    <div class="tr th">
      <div>#</div><div>Дата</div><div>Время</div><div>Байки</div><div>Оплата</div>
      <div>Итого</div><div>Внесено</div><div>Осталось</div><div>Скидка</div>
      <div>Мероприятие</div><div>Акция</div><div>Пользователь</div><div>Телефон</div><div>Email</div>
    </div>

    <?php foreach (($rows ?? []) as $r): ?>
      <div class="tr">
        <div><?= (int)$r['id_booking'] ?></div>
        <div><?= htmlspecialchars($r['date_booking']) ?></div>
        <div><?= htmlspecialchars($r['time_booking']) ?></div>
        <div><?= (int)$r['bikes_count'] ?></div>
        <div><?= htmlspecialchars($r['payment_type']) ?></div>
        <div><?= htmlspecialchars($r['total_amount']) ?></div>
        <div><?= htmlspecialchars($r['paid_amount']) ?></div>
        <div><?= htmlspecialchars($r['left_amount']) ?></div>
        <div><?= htmlspecialchars($r['discount_amount']) ?></div>
        <div><?= htmlspecialchars($r['event_title'] ?? '') ?></div>
        <div><?= htmlspecialchars($r['promo_title'] ?? '') ?></div>
        <div><?= htmlspecialchars($r['user_name'] ?? '') ?></div>
        <div><?= htmlspecialchars($r['user_phone'] ?? '') ?></div>
        <div><?= htmlspecialchars($r['user_email'] ?? '') ?></div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php
$content = ob_get_clean();
require BASE_PATH . '/app/Views/admin/layout.php';
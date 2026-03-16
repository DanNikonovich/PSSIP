<?php
$title = 'Вход администратора — E-RIDE';
$active = '';
$admin = $admin ?? ['name'=>''];
ob_start();
?>
<section class="card">
  <div class="card__head">
    <div class="card__title">Вход администратора</div>
    <div class="card__sub">Только для сотрудников E-RIDE</div>
  </div>

  <?php if (!empty($error)): ?>
    <div class="alert"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form class="form" method="post" action="/admin/login">
    <label class="field">
      <span class="field__label">Email</span>
      <span class="field__input">
        <input name="email" type="email" placeholder="admin@e-ride.by" required>
      </span>
    </label>

    <label class="field">
      <span class="field__label">Пароль</span>
      <span class="field__input">
        <input name="password" type="password" placeholder="••••••••" required>
      </span>
    </label>

    <button class="btn btn--glow" type="submit">Войти</button>
  </form>
</section>
<?php
$content = ob_get_clean();
require BASE_PATH . '/app/Views/admin/layout.php';
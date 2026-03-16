<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>E-RIDE — Бронь подтверждена</title>

  <link rel="icon" type="image/png" href="/assets/components/E.png">
  <link rel="stylesheet" href="/assets/css/stylebooking.css?v=4">
  <link rel="stylesheet" href="/assets/css/booking-success.css?v=1">
</head>
<body class="page">

<main class="success">

  <div class="success__card">
    
    <div class="success__icon">
      <svg viewBox="0 0 52 52">
        <circle cx="26" cy="26" r="25" fill="none"/>
        <path fill="none" d="M14 27l7 7 17-17"/>
      </svg>
    </div>

    <h1 class="success__title">Бронирование подтверждено!</h1>

    <p class="success__text">
      Спасибо за выбор <b>E-RIDE</b> 🔥<br>
      Номер вашей заявки:
    </p>

    <div class="success__id">#<?= (int)($id ?? 0) ?></div>

    <p class="success__sub">
      Детали бронирования отправлены в Telegram.<br>
      Мы свяжемся с вами в ближайшее время.
    </p>

    <div class="success__actions">
      <a href="/" class="btn-main">На главную</a>
      <a href="/booking" class="btn-ghost">Создать ещё бронь</a>
    </div>

  </div>

</main>

</body>
</html>
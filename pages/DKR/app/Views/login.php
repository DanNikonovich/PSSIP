<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>E-RIDE — Вход</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">

  <link rel="icon" type="image/png" href="/assets/components/E.png">
  <link rel="stylesheet" href="/assets/css/auth.css?v=1">
</head>
<body>
  <main class="auth">
    <div class="auth__wrap2">
      <section class="card">
        <div class="brand">
          <a class="brand__logo" href="/" aria-label="На главную">
            <img src="/assets/components/E.png" alt="">
          </a>
          <div class="brand__txt">
            <b>E-RIDE</b>
            <span>Вход в личный кабинет</span>
          </div>
        </div>

        <div class="card__inner">
          <h1 class="h1">Вход</h1>
          <p class="p">Войдите, чтобы продолжить свои действия.</p>

          <form class="form" method="post" action="/login" autocomplete="on">
            <div class="field">
              <div class="field__label">
                <span>Email</span>
              </div>
              <input class="field__input" name="email" type="email" placeholder="name@mail.com" required>
            </div>

            <div class="field">
              <div class="field__label">
                <span>Пароль</span>
              </div>
              <input class="field__input" name="password" type="password" placeholder="••••••••" required>
            </div>

            <button class="btn btn--primary" type="submit">Войти</button>

            <div class="row">
              <a class="link" href="/register">Нет аккаунта? Регистрация</a>
              <a class="link" href="/">На главную</a>
            </div>
          </form>

          <div class="notice">Данные защищены. </div>
        </div>
      </section>      
    </div>
  </main>
</body>
</html>
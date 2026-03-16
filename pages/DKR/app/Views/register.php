<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>E-RIDE — Регистрация</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">

  <link rel="icon" type="image/png" href="/assets/components/E.png">
  <link rel="stylesheet" href="/assets/css/auth.css?v=1">
</head>
<body>
  <main class="auth">
    <div class="auth__wrap">
      <section class="card">
        <div class="brand">
          <a class="brand__logo" href="/" aria-label="На главную">
            <img src="/assets/components/E.png" alt="">
          </a>
          <div class="brand__txt">
            <b>E-RIDE</b>
            <span>Создание аккаунта</span>
          </div>
        </div>

        <div class="card__inner">
          <h1 class="h1">Регистрация</h1>
          <p class="p">Создайте аккаунт — бронирование и отзывы станут доступны.</p>

          <form class="form" method="post" action="/register" autocomplete="on">
            <div class="field">
              <div class="field__label">
                <span>Имя</span>
              </div>
              <input class="field__input" name="name" placeholder="Например, Алексей" required>
            </div>

            <div class="field">
              <div class="field__label">
                <span>Email</span>
              </div>
              <input class="field__input" name="email" type="email" placeholder="name@mail.com" required>
            </div>

            <div class="field">
              <div class="field__label">
                <span>Телефон</span>
              </div>
              <input class="field__input" name="phone" placeholder="+375...">
            </div>

            <div class="field">
              <div class="field__label">
                <span>Пароль</span>
              </div>
              <input class="field__input" name="password" type="password" placeholder="••••••••" required>
            </div>

            <button class="btn btn--primary" type="submit">Создать аккаунт</button>

            <div class="row">
              <a class="link" href="/login">Уже есть аккаунт? Войти</a>
              <a class="link" href="/">На главную</a>
            </div>
          </form>

          <div class="notice">После регистрации ваши данные будут подставляться в бронирование автоматически.</div>
        </div>
      </section>

      <aside class="side">
        <div class="side__inner">
          <div class="badge">Что даёт аккаунт</div>
          <ul class="ul">
            <li><span class="dot"></span><span>Бронирование доступно только зарегистрированным пользователям.</span></li>
            <li><span class="dot"></span><span>Автозаполнение имени, телефона и почты в форме бронирования.</span></li>
            <li><span class="dot"></span><span>Возможность оставлять комментарии и рейтинг.</span></li>
            <li><span class="dot"></span><span>В будущем — уведомления о брони в Telegram.</span></li>
          </ul>
        </div>
      </aside>
    </div>
  </main>
</body>
</html>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <link rel="icon" type="image/png" href="/assets/components/E.png">
  <title>E-RIDE — Бронь</title>

  <!-- Inter (если у тебя уже подключён глобально — можно убрать) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="/assets/css/stylebooking.css?v=3">
</head>
<body class="page">
  <main class="book" data-booking>
    <!--------------------------------------------- HEADER --------------------------------------------->
    <header class="site-header">
      <div class="header-bar">
        <nav class="nav left" aria-label="Навигация слева">
          <a class="nav-link" href="/promo">Акции</a>
          <a class="nav-link" href="/rules">Правила</a>
        </nav>
        <a class="logo" href="/" aria-label="На главную">
          <img src="/assets/components/logo.png" alt="E-RIDE">
        </a>
        <nav class="nav right" aria-label="Навигация справа">
          <div class="contacts" data-contacts>
            <a class="contacts__trigger" href="#contacts" aria-label="Контакты">
              <span class="nav-link">Контакты</span>
              <span class="contacts__arrow" aria-hidden="true"></span>
            </a>
          
            <div class="contacts__hint" role="tooltip" aria-hidden="true">
              <div class="contacts__row contacts__season-row">
                <span class="contacts__season">Апрель → Октябрь</span>
                <span></span>
              </div>

              <div class="contacts__row">
                <span class="contacts__badge">Пн</span>
                <span class="contacts__value">Выходной</span>
              </div>
            
              <div class="contacts__row">
                <span class="contacts__badge">Вт–Вс</span>
                <span class="contacts__value">10:00 – 20:00</span>
              </div>
            </div>
          </div>
          <a class="nav-link is-active" href="#booking">Бронь</a>
        </nav>
        <button class="burger"
                type="button"
                aria-label="Открыть меню"
                aria-expanded="false"
                aria-controls="mobileMenu">
          <span></span>
          <span></span>
          <span></span>
        </button>
      </div>
    </header>

    <!--------------------------------------------- Menu --------------------------------------------->
    <div class="mnav" id="mobileMenu" aria-hidden="true">
      <div class="mnav__panel" role="dialog" aria-modal="true" aria-label="Меню">
        <button class="mnav__close" type="button" aria-label="Закрыть меню">×</button>
        <div class="mnav__grid">
          <nav class="mnav__col" aria-label="Разделы">
            <a href="/promo">АКЦИИ</a>
            <a href="/rules">ПРАВИЛА</a>
            <a href="/booking">БРОНЬ</a>
            <a href="#contacts">КОНТАКТЫ</a>
          </nav>
          <div class="mnav__col mnav__info" aria-label="Информация">
            <div class="mnav__phone">+375 (29) 77-87-397</div>
            <div class="mnav__social">
              <a class="mnav__soc" href="#" aria-label="Telegram">T</a>
              <a class="mnav__soc" href="#" aria-label="Instagram">I</a>
              <a class="mnav__soc" href="#" aria-label="TikTok">D</a>
            </div>
            <div class="mnav__work">
              <div class="mnav__work-title">ВРЕМЯ РАБОТЫ</div>
              <div class="mnav__work-row">
                <span class="mnav__badge">Пн</span>
                <span>Выходной</span>
              </div>
              <div class="mnav__work-row">
                <span class="mnav__badge">Вт–Вс</span>
                <span>10:00 – 20:00</span>
              </div>
            </div>
            <div class="mnav__address">
              ул. Максима Горького, 101
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <form method="post" action="/booking">
    <!-- Заголовок секции -->
    <div class="booking-pill">
      <img  src="/assets/components/svg/calendar.svg" >
      <span>Забронируйте свой заезд</span>
    </div>

    <!-- CARD: DATE -->
    <section class="card">
      <div class="card__head">
        <span class="card__icon"><img src="/assets/components/svg/calendar.svg" alt="" aria-hidden="true"></span>
        <div>
          <div class="card__title">Выберите дату</div>
          <div class="card__sub">Доступные даты на ближайшие 30 дней</div>
        </div>
      </div>

      <label class="input input--date">
        <input type="date" data-date />
        <span class="input__icon">
          <img src="/assets/components/svg/calendar_small.svg" alt="" aria-hidden="true">
        </span>
      </label>
    </section>

    <!-- CARD: TIME -->
    <section class="card">
      <div class="card__head">
        <span class="card__icon"><img src="/assets/components/svg/clockb.svg" alt="" aria-hidden="true"></span>
        <div>
          <div class="card__title">Выберите время</div>
          <div class="card__sub">Доступные временные слоты для заездов</div>
        </div>
      </div>

      <div class="legend">
        <span class="legend__item"><i class="dot dot--sel"></i>Выбрано</span>
        <span class="legend__item"><i class="dot dot--free"></i>Свободно</span>
        <span class="legend__item"><i class="dot dot--busy"></i>Занято</span>
      </div>

      <div class="slots" data-slots></div>

      <input type="hidden" name="date_booking" id="formDate">
      <input type="hidden" name="time_booking" id="formTime">
      <input type="hidden" name="bikes_count" id="formBikes">
      <input type="hidden" name="payment_type" id="formPayment">

      <div class="hint">
        <span class="hint__k">Длительность:</span>
        <span class="hint__v"><b data-hours>1</b> час(а)</span>
        <span class="hint__k">Выбрано:</span>
        <span class="hint__v"><b data-start>—</b> → <b data-end>—</b></span>
      </div>
    </section>

    <a class="hero__to-top" href="#top" aria-label="Наверх страницы">
      <img src="/assets/components/svg/Upper.svg" alt="" aria-hidden="true">
    </a>

    <!-- CARD: BIKES -->
    <section class="card">
      <div class="card__head">
        <span class="card__icon"><img src="/assets/components/svg/bike_small.svg" alt="" aria-hidden="true"></span>
        <div>
          <div class="card__title">Количество электромотоциклов</div>
          <div class="card__sub">От 1 до 4 электромотоциклов на группу</div>
        </div>
      </div>

      <div class="bikes" data-bikes>
        <!-- Логика как звёзды: кликаешь по N → выделяются 1..N -->
        <button class="bike" type="button" data-bike="1">
          <img src="/assets/components/svg/bike_count.svg" alt="" aria-hidden="true">
          <div class="bike__n">1</div>
        </button>
        <button class="bike" type="button" data-bike="2">
          <img src="/assets/components/svg/bike_count.svg" alt="" aria-hidden="true">
          <div class="bike__n">2</div>
        </button>
        <button class="bike" type="button" data-bike="3">
          <img src="/assets/components/svg/bike_count.svg" alt="" aria-hidden="true">
          <div class="bike__n">3</div>
        </button>
        <button class="bike" type="button" data-bike="4">
          <img src="/assets/components/svg/bike_count.svg" alt="" aria-hidden="true">
          <div class="bike__n">4</div>
        </button>
      </div>

      <div class="sumline">
        <div class="sumline__left">Стоимость за час</div>
        <div class="sumline__right">
          <div class="sumline__mini"><span data-rate>80</span> BYN × <span data-bikes-count>1</span></div>
          <div class="sumline__big"><span data-hour-sum>80</span> BYN</div>
        </div>
      </div>
    </section>

    <div class="form-grid">
      <!-- Мероприятие -->
      <div class="field">
        <label class="field__label" for="eventSelect">Мероприятие</label>
    
        <div class="select">
          <select id="eventSelect" name="id_event" required>
            <?php foreach (($events ?? []) as $e): ?>
              <option value="<?= (int)$e['id_event'] ?>"
                <?= (!empty($selectedEventId) && (int)$e['id_event'] === (int)$selectedEventId) ? 'selected' : '' ?>>
                <?= htmlspecialchars($e['title']) ?>
              </option>
            <?php endforeach; ?>
          </select>
          <span class="select__chev" aria-hidden="true"></span>
        </div>
            
        <div class="field__hint">Выберите формат мероприятия из списка.</div>
      </div>
            
      <!-- Акция -->
      <div class="field">
        <label class="field__label" for="promoSelect">Акция</label>
            
        <div class="select">
          <select name="id_promo" id="promoSelect">
            <?php foreach (($promos ?? []) as $p): ?>
              <option
                value="<?= (int)$p['id_promo'] ?>"
                data-discount-percent="<?= (float)($p['discount_percent'] ?? 0) ?>"
                data-discount-amount="<?= (float)($p['discount_amount'] ?? 0) ?>"
                <?= (!empty($selectedPromoId) && (int)$p['id_promo'] === (int)$selectedPromoId) ? 'selected' : '' ?>
              >
                <?= htmlspecialchars($p['title']) ?>
                <?= !empty($p['promo_code']) ? ' (' . htmlspecialchars($p['promo_code']) . ')' : '' ?>
              </option>
            <?php endforeach; ?>
          </select>
          <span class="select__chev" aria-hidden="true"></span>
        </div>
            
        <div class="field__hint">Если вы переходили со страницы “Акции”, она подставится автоматически.</div>
      </div>
    </div>

    <!-- CARD: PAY -->
    <section class="card">
      <div class="card__head">
        <span class="card__icon"><img src="/assets/components/svg/wallet.svg" alt="" aria-hidden="true"></span>
        <div>
          <div class="card__title">Вариант оплаты</div>
          <div class="card__sub">Выберите удобный способ предоплаты</div>
        </div>
      </div>

      <div class="pay" data-pay>
        <label class="payopt">
          <input type="radio" name="pay" value="full" checked />
          <span class="payopt__box"></span>
          <div class="payopt__text">
            <div class="payopt__t">Полная предоплата</div>
            <div class="payopt__d">Оплатите 100% стоимости сейчас и получите бронирование без дополнительных платежей</div>
          </div>
          <div class="payopt__price"><span data-pay-full>0</span> BYN</div>
        </label>

        <label class="payopt is-active">
          <input type="radio" name="pay" value="part" />
          <span class="payopt__box"></span>
          <div class="payopt__text">
            <div class="payopt__t">Частичная предоплата (30%)</div>
            <div class="payopt__d">Оплатите 30% для подтверждения брони, остальное — на месте</div>

            <div class="progress">
              <div class="progress__top">
                <span>Прогресс оплаты</span>
              </div>
              <div class="bar">
                <div class="bar__fill" style="width:30%"></div>
              </div>
              <div class="progress__bottom">
                <div class="progress__bottom_to">
                  <span>30% сейчас</span>
                </div>
                <span>70% на месте</span>
              </div>
            </div>
          </div>
          <div class="payopt__price"><span data-pay-part>0</span> BYN</div>
        </label>

        <label class="payopt">
          <input type="radio" name="pay" value="none" />
          <span class="payopt__box"></span>
          <div class="payopt__text">
            <div class="payopt__t">Без предоплаты</div>
            <div class="payopt__d">Оплата полной стоимости на месте при получении мотоциклов</div>
            <div class="payopt__warn">
              <img src="/assets/components/svg/infor.svg" alt="" aria-hidden="true">
              Бронь может быть отменена без подтверждения. Рекомендуем выбрать предоплату.
            </div>
          </div>
          <div class="payopt__price"><span data-pay-none>0</span> BYN</div>
        </label>
      </div>
    </section>

    <!-- CARD: CONTACTS -->
    <section class="card">
      <div class="card__head">
        <span class="card__icon"><img src="/assets/components/svg/user1.svg" alt="" aria-hidden="true"></span>
        <div>
          <div class="card__title">Контактная информация</div>
          <div class="card__sub">Укажите ваши данные для связи</div>
        </div>
      </div>

      <div class="form">
        <label class="field">
          <span class="field__label">Ваше имя и фамилия</span>
          <span class="field__input">
            <img src="/assets/components/svg/user2.svg" alt="" aria-hidden="true">
            <input name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" <?= $user ? 'readonly' : '' ?> type="text" placeholder="Иван Иванов" required />
          </span>
        </label>

        <label class="field">
          <span class="field__label">Email</span>
          <span class="field__input">
            <img src="/assets/components/svg/mail-outline.svg" alt="" aria-hidden="true">
            <input name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" <?= $user ? 'readonly' : '' ?> type="email" placeholder="email@example.com" required />
          </span>
        </label>

        <label class="field">
          <span class="field__label">Телефон</span>
          <span class="field__input">
            <img src="/assets/components/svg/phone1.svg" alt="" aria-hidden="true">
            <input name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" <?= $user ? 'readonly' : '' ?> type="tel" placeholder="+375 (33) 765-43-21" required />
          </span>
        </label>
      </div>
    </section>

    
    <!-- Sticky pay button -->
    <div class="paybar">
      <button class="paybar__btn" type="submit" data-submit>
        Оплатить <span data-pay-now>0</span> BYN и забронировать
      </button>
      <div class="paybar__note">
        <img src="/assets/components/svg/check.svg" alt="" aria-hidden="true">
        После обработки заявки Вы получите сообщение с деталями заезда в Telegram
      </div>
    </div>
    </form>
  </main>

  <!--------------------------------------------- Footer --------------------------------------------->
  <footer class="footer" id="contacts">
    <div class="footer__inner">
      <!-- left -->
      <div class="footer__brand">
        <img class="footer__logo" src="/assets/components/logo.png" alt="E-RIDE">
        <p class="footer__text">
          Поездка с нами — это экстремально,<br>
          живописно, незабываемо!
        </p>

        <div class="footer__item">
          <img class="footer__ico" src="/assets/components/svg/adres.svg" alt="" aria-hidden="true">
          <div class="footer__text">
            г.Гродно, ул.Санаторная,16<br>
            (в районе Гродненского КСМ)
          </div>
        </div>
      </div>

      <!-- contacts -->
      <div class="footer__col">
        <h3 class="footer__title">Контакты</h3>

        <a class="footer__item footer__link" href="tel:+375298882764">
          <img class="footer__ico" src="/assets/components/svg/phone.svg" alt="" aria-hidden="true">
          <span class="footer__text">+375 (29) 888-27-64</span>
        </a>

        <a class="footer__item footer__link" href="mailto:karting.grodno@gmail.com">
          <img class="footer__ico" src="/assets/components/svg/mail.svg" alt="" aria-hidden="true">
          <span class="footer__text">karting.grodno@gmail.com</span>
        </a>
      </div>

      <!-- schedule -->
      <div class="footer__col">
        <h3 class="footer__title">Режим работы</h3>

        <div class="footer__item footer__item--top">
          <img class="footer__ico" src="/assets/components/svg/work_time.svg" alt="" aria-hidden="true">
          <div class="footer__text">
            С 1 ноября по 31 марта (зимний период)<br>
            С 1 апреля по 31 октября (летний период)<br>
            Понедельник: выходной<br>
            Вторник - воскресенье: с 10.00 до 20.00<br>
            Уточнять по телефону
          </div>
        </div>
      </div>

      <!-- socials -->
      <div class="footer__col">
        <h3 class="footer__title">Социальные сети</h3>

        <div class="footer__socials">
          <a class="footer__social" href="https://www.instagram.com/e_ride_grodno/" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
            <img src="/assets/components/svg/instagram.svg" alt="">
          </a>

          <a class="footer__social" href="https://www.facebook.com/sergey.sheronov.2025/" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
            <img src="/assets/components/svg/facebook.svg" alt="">
          </a>

          <a class="footer__social" href="https://api.whatsapp.com/message/WKIGN25URJ76C1?autoload=1&app_absent=0&utm_source=ig" target="_blank" rel="noopener noreferrer" aria-label="VK/WhatsApp link">
            <img src="/assets/components/svg/vk.svg" alt="">
          </a>
        </div>
      </div>
    </div>

    <div class="footer__line"></div>

    <div class="footer__copy">
      © 2025. Прокат внедорожных электромотоциклов "E-ride". Все права защищены.
    </div>
  </footer>
  <script src="/assets/js/booking.js"></script>
  <script src="/assets/js/footer.js" defer></script>
  <script src="/assets/js/bg.js" defer></script>
  <script src="/assets/js/scroll-top.js" defer></script>
</body>
</html>

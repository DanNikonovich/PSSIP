<?php
// $promos приходит из контроллера
$promoByCode = [];
foreach (($promos ?? []) as $p) {
  if (!empty($p['promo_code'])) {
    $promoByCode[$p['promo_code']] = (int)$p['id_promo'];
  }
}

// удобные переменные (если кода нет — будет 0)
$FIRST20    = $promoByCode['FIRST20']    ?? 0;
$GROUP15    = $promoByCode['GROUP15']    ?? 0;
$WEEKDAY10  = $promoByCode['WEEKDAY10']  ?? 0;
$LONG15     = $promoByCode['LONG15']     ?? 0;
$BDAYPLUS1H = $promoByCode['BDAYPLUS1H'] ?? 0;
?>

<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <link rel="icon" type="image/png" href="/assets/components/E.png">
  <title>E-RIDE — Акции</title>

  <!-- Inter (если у тебя уже подключён глобально — можно убрать) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="/assets/css/stylepromo.css">
</head>
<body class="page">
    <!--------------------------------------------- HEADER --------------------------------------------->
    <header class="site-header">
      <div class="header-bar">
        <nav class="nav left" aria-label="Навигация слева">
          <a class="nav-link is-active" href="#promo">Акции</a>
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
          <a class="nav-link" href="/booking">Бронь</a>
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

  <!-- ================= PAGE ================= -->
  <main class="sales">
    <!-- pill сверху -->
    <div class="sales__pill">
      <img src="/assets/components/svg/sale.svg" alt="">
      <span>Специальные предложения</span>
    </div>

    <!-- ===== HOT OFFER ===== -->
    <section class="hot">
      <div class="hot__wrap">
        <div class="hot__chip">
          <span class="hot__tag">ГОРЯЧЕЕ ПРЕДЛОЖЕНИЕ</span>
          <span class="hot__dot" aria-hidden="true"></span>
        </div>

        <h1 class="hot__title">Скидка 20% на первый заезд</h1>

        <p class="hot__text">
          Успейте забронировать свой первый заезд со скидкой 20%!
          Попробуйте SUR-RON Light Bee 2025 Sage и почувствуйте настоящую мощь электромотоцикла.
        </p>

        <div class="hot__sub">Предложение заканчивается через:</div>

        <div class="hot__timer" data-countdown>
          <div class="tbox">
            <div class="tbox__num" data-dd>02</div>
            <div class="tbox__label">Дней</div>
          </div>
          <div class="tbox">
            <div class="tbox__num" data-hh>15</div>
            <div class="tbox__label">Часов</div>
          </div>
          <div class="tbox">
            <div class="tbox__num" data-mm>36</div>
            <div class="tbox__label">Минут</div>
          </div>
          <div class="tbox">
            <div class="tbox__num" data-ss>16</div>
            <div class="tbox__label">Секунд</div>
          </div>
        </div>

        <div class="hot__bottom">
          <a class="hot__btn" href="/booking<?= $FIRST20 ? ('?promo_id=' . $FIRST20) : '' ?>">Забронировать со скидкой</a>

          <div class="hot__used">
            <img src="/assets/components/svg/Stargreen.svg">
            <span>Уже воспользовались <b>247</b> человек</span>
          </div>
        </div>
      </div>
    </section>

    <a class="hero__to-top" href="#top" aria-label="Наверх страницы">
      <img src="/assets/components/svg/Upper.svg" alt="" aria-hidden="true">
    </a>

    <!-- ===== GRID OFFERS ===== -->
    <section class="offers">
      <h2 class="offers__title">Актуальные акции</h2>
      <div class="offers__subtitle">Выбирайте подходящее предложение и экономьте</div>

      <div class="offers__grid">
        <!-- card 1 -->
        <article class="offer-card">
          <div class="offer-card__head">
            <div class="offer-card__icon">
              <img src="/assets/components/svg/group.svg" alt="">
            </div>
            <div class="offer-card__h">
              <div class="offer-card__title">
                Групповая скидка <span class="badge badge--soft">ПОПУЛЯРНО</span>
              </div>
              <div class="offer-card__big">до 15%</div>
            </div>
          </div>

          <div class="offer-card__desc">
            Приезжайте компанией от 3 человек и получите скидку 10%, от 4 человек — 15% на весь заказ!
          </div>

          <ul class="offer-card__list">
            <li>3 мотоцикла: скидка 10%</li>
            <li>4 мотоцикла: скидка 15%</li>
            <li>Действует на заезды от 2 часов</li>
          </ul>

          <a class="offer-card__btn" href="/booking<?= $GROUP15 ? ('?promo_id=' . $GROUP15) : '' ?>">Забронировать</a>
        </article>

        <!-- card 2 -->
        <article class="offer-card">
          <div class="offer-card__head">
            <div class="offer-card__icon">
              <img src="/assets/components/svg/calendar.svg" alt="">
            </div>
            <div class="offer-card__h">
              <div class="offer-card__title">В будние дни</div>
              <div class="offer-card__big">-10%</div>
            </div>
          </div>

          <div class="offer-card__desc">
            Бронируйте заезды на будние дни (Пн–Чт) и экономьте 10% от стоимости!
          </div>

          <ul class="offer-card__list">
            <li>Понедельник – Четверг</li>
            <li>Любая продолжительность</li>
            <li>Бронирование за 24 часа</li>
          </ul>

          <a class="offer-card__btn" href="/booking<?= $WEEKDAY10 ? ('?promo_id=' . $WEEKDAY10) : '' ?>">Забронировать</a>
        </article>

        <!-- card 3 -->
        <article class="offer-card">
          <div class="offer-card__head">
            <div class="offer-card__icon">
              <img src="/assets/components/svg/clockb.svg" alt="">
            </div>
            <div class="offer-card__h">
              <div class="offer-card__title">Длительный заезд</div>
              <div class="offer-card__big">-15%</div>
            </div>
          </div>

          <div class="offer-card__desc">
            Арендуйте мотоциклы на 5+ часов и получите скидку 15% на всё время!
          </div>

          <ul class="offer-card__list">
            <li>От 5 часов: скидка 15%</li>
            <li>Полный день: скидка 30%</li>
            <li>Включён комплект экипировки</li>
          </ul>

          <a class="offer-card__btn offer-card__btn--fill" href="/booking<?= $LONG15 ? ('?promo_id=' . $LONG15) : '' ?>">Забронировать</a>
        </article>

        <!-- card 4 -->
        <article class="offer-card">
          <div class="offer-card__head">
            <div class="offer-card__icon">
              <img src="/assets/components/svg/sale.svg" alt="">
            </div>
            <div class="offer-card__h">
              <div class="offer-card__title">
                День рождения <span class="badge badge--soft">ПОДАРОК</span>
              </div>
              <div class="offer-card__big">+1 час</div>
            </div>
          </div>

          <div class="offer-card__desc">
            Празднуете день рождения? Получите дополнительный час аренды в подарок!
          </div>

          <ul class="offer-card__list">
            <li>Действует в день ДР ± 3 дня</li>
            <li>При заказе от 2 часов</li>
            <li>Документ, подтверждающий ДР</li>
          </ul>

          <a class="offer-card__btn" href="/booking<?= $BDAYPLUS1H ? ('?promo_id=' . $BDAYPLUS1H) : '' ?>">Забронировать</a>
        </article>
      </div>
    </section>

    <!-- ===== LOYALTY ===== -->
    <section class="loyalty">
      <div class="loyalty__wrap">
        <div class="loyalty__left">
          <div class="loyalty__head">
            <img src="/assets/components/svg/prize_act.svg" alt="">
            <div>
              <div class="loyalty__title">Программа лояльности</div>
              <div class="loyalty__sub">Накапливайте баллы с каждого заезда и обменивайте их на скидки и бесплатные часы!</div>
            </div>
          </div>

          <div class="loyalty__stats">
            <div class="lstat">
              <div class="lstat__num">1%</div>
              <div class="lstat__txt">Кэшбэк баллами</div>
            </div>
            <div class="lstat">
              <div class="lstat__num">10%</div>
              <div class="lstat__txt">На день рождения</div>
            </div>
            <div class="lstat">
              <div class="lstat__num">VIP</div>
              <div class="lstat__txt">Статус от 10 заездов</div>
            </div>
          </div>

          <a class="loyalty__btn" href="/booking">Начать копить баллы</a>
        </div>

        <div class="loyalty__right">
          <div class="loyalty__box">
            <div class="loyalty__box-title">Пример накопления</div>
            <div class="loyalty__box-row">
              <span>5 заездов</span><b>+2500 ₽</b>
            </div>
            <div class="loyalty__box-row">
              <span>10 заездов</span><b>+5000 ₽ + VIP</b>
            </div>
            <div class="loyalty__box-row">
              <span>20 заездов</span><b>+10000 ₽ + бонусы</b>
            </div>
            <div class="loyalty__box-note">1 балл = 1 рубль<br>Баллы не сгорают</div>
          </div>
        </div>
      </div>
    </section>

    <!-- ===== CONDITIONS ===== -->
    <section class="cond">
      <div class="cond__title">Условия акций</div>

      <div class="cond__box">
        <ul class="cond__list">
          <li>Акции не суммируются друг с другом, применяется наибольшая скидка</li>
          <li>Скидка применяется на базовую стоимость аренды мотоцикла</li>
          <li>Для активации акции необходимо указать промокод при бронировании</li>
          <li>Организатор оставляет за собой право изменить условия акций</li>
          <li>Предложения действительны при наличии свободных мотоциклов</li>
          <li>Баллы программы лояльности начисляются в течение 24 часов после заезда</li>
        </ul>
      </div>
    </section>

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
  <script src="/assets/js/footer.js" defer></script>
  <script src="/assets/js/bg.js" defer></script>
  <script src="/assets/js/scroll-top.js" defer></script>
</body>
</html>

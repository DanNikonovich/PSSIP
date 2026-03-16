<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <link rel="icon" type="image/png" href="/assets/components/E.png">
  <title>E-RIDE — Правила</title>

  <!-- Inter (если у тебя уже подключён глобально — можно убрать) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="/assets/css/stylerules.css">
</head>
<body class="page">
    <!--------------------------------------------- HEADER --------------------------------------------->
    <header class="site-header">
      <div class="header-bar">
        <nav class="nav left" aria-label="Навигация слева">
          <a class="nav-link" href="/promo">Акции</a>
          <a class="nav-link is-active" href="/rules">Правила</a>
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
  <main class="rules-page">
    <div class="rules-wrap">

      <!-- pill как на макете -->
      <div class="rules-pill">
        <img src="/assets/components/svg/shield.svg" alt="">
        <span>Безопасность превыше всего</span>
      </div>

      <!-- заголовок -->
      <h1 class="rules-h1">Правила безопасности</h1>
      <p class="rules-sub">Соблюдение этих правил обязательно для всех участников</p>

      <!-- ======= BLOCK 1: cards ======= -->
      <section class="rules-grid">
        <article class="r-card">
          <div class="r-card__icon">
            <img src="/assets/components/svg/warn.svg" alt="">
          </div>
          <div class="r-card__body">
            <h3 class="r-card__title">Общие требования безопасности</h3>
            <ul class="r-list">
              <li>Обязательное использование защитной экипировки: шлем, перчатки, наколенники, налокотники, защита спины</li>
              <li>Минимальный возраст для управления — 18 лет</li>
              <li>Запрещено управление в состоянии алкогольного или наркотического опьянения</li>
              <li>Запрещено управление при плохом самочувствии, усталости или приеме медикаментов, влияющих на реакцию</li>
            </ul>
          </div>
        </article>

        <article class="r-card">
          <div class="r-card__icon">
            <img src="/assets/components/svg/triangle.svg" alt="">
          </div>
          <div class="r-card__body">
            <h3 class="r-card__title">Правила во время катания</h3>
            <ul class="r-list">
              <li>Соблюдайте безопасную дистанцию от других райдеров (минимум 10 метров)</li>
              <li>Всегда держите обе руки на руле, ноги на подножках</li>
              <li>Не превышайте скорость, соответствующую вашему уровню подготовки</li>
              <li>Следуйте указаниям инструктора и маркировке трасс</li>
              <li>При обгоне обязательно предупредите звуковым сигналом</li>
              <li>В случае падения немедленно освободите трассу</li>
            </ul>
          </div>
        </article>
        <a class="hero__to-top" href="#top" aria-label="Наверх страницы">
          <img src="/assets/components/svg/Upper.svg" alt="" aria-hidden="true">
        </a>
        <article class="r-card">
          <div class="r-card__icon">
            <img src="/assets/components/svg/eye.svg" alt="">
          </div>
          <div class="r-card__body">
            <h3 class="r-card__title">Осмотрительность и окружающая среда</h3>
            <ul class="r-list">
              <li>Будьте внимательны к диким животным и другим участникам трассы</li>
              <li>Запрещено движение по заповедным зонам и частной собственности</li>
              <li>Не оставляйте мусор на трассе — забирайте все с собой</li>
              <li>Уважайте природу — не повреждайте растительность без необходимости</li>
            </ul>
          </div>
        </article>

        <article class="r-card">
          <div class="r-card__icon">
            <img src="/assets/components/svg/group.svg" alt="">
          </div>
          <div class="r-card__body">
            <h3 class="r-card__title">Групповые выезды</h3>
            <ul class="r-list">
              <li>Всегда держите в поле зрения байк впереди и сзади вас</li>
              <li>Используйте систему сигналов руками для коммуникации</li>
              <li>При технических проблемах остановитесь и сообщите гиду</li>
              <li>Не отставайте от группы и не уезжайте вперед без разрешения</li>
            </ul>
          </div>
        </article>

        <article class="r-card">
          <div class="r-card__icon">
            <img src="/assets/components/svg/bikegreen.svg" alt="">
          </div>
          <div class="r-card__body">
            <h3 class="r-card__title">Техника вождения</h3>
            <ul class="r-list">
              <li>Положение тела: держите локти согнутыми, колени прижаты к баку, вес тела над подножками</li>
              <li>На подъемах: переместите вес вперед, активно работайте газом</li>
              <li>На спусках: вес назад, контролируйте скорость задним тормозом</li>
              <li>В поворотах: смотрите в точку выхода, наклоняйте байк, не тело</li>
              <li>Рекуперация: при отпускании газа двигатель работает как тормоз и заряжает батарею</li>
            </ul>
          </div>
        </article>

        <article class="r-card">
          <div class="r-card__icon">
            <img src="/assets/components/svg/finish.svg" alt="">
          </div>
          <div class="r-card__body">
            <h3 class="r-card__title">После поездки</h3>
            <ul class="r-list">
              <li>Выключите мотоцикл и извлеките ключ</li>
              <li>Сообщите о любых замеченных неисправностях или странных звуках</li>
              <li>При необходимости очистите мотоцикл от грязи (не используйте мойку высокого давления)</li>
              <li>Поставьте мотоцикл на зарядку, если уровень батареи ниже 20%</li>
            </ul>
          </div>
        </article>
      </section>

      <!-- ======= BLOCK 2: instruction ======= -->
      <section class="rules-instr">
        <h2 class="rules-h2">Инструкция: SUR-RON Light Bee 2025 Sage</h2>
        <p class="rules-sub2">Электромотоцикл нового поколения для бездорожья</p>

        <article class="r-card r-card--lite">
          <div class="r-card__icon">
            <img src="/assets/components/svg/lightning.svg" alt="">
          </div>
          <div class="r-card__body">
            <h3 class="r-card__title">Органы управления</h3>
            <div class="r-kv">
              <div><b>Правая ручка:</b> газ (плавное вращение на себя)</div>
              <div><b>Правый рычаг:</b> передний тормоз</div>
              <div><b>Левый рычаг:</b> задний тормоз</div>
              <div><b>Дисплей:</b> показывает уровень заряда, скорость, пробег, режим мощности</div>
              <div><b>Кнопка MODE:</b> переключение режимов ECO / SPORT / RACE</div>
              <div><b>Кнопка питания:</b> удерживайте 3 секунды для включения/выключения</div>
            </div>
          </div>
        </article>

        <article class="r-card r-card--lite">
          <div class="r-card__icon">
            <img src="/assets/components/svg/batteryrule.svg" alt="">
          </div>
          <div class="r-card__body">
            <h3 class="r-card__title">Режимы работы</h3>
            <div class="r-modes">
              <div class="mode">
                <div class="mode__name">ECO (Экономичный)</div>
                <div class="mode__desc">Ограничение скорости до 30 км/ч, плавная подача мощности, максимальный запас хода. Идеален для обучения и неспешных прогулок.</div>
              </div>
              <div class="mode">
                <div class="mode__name">SPORT (Спортивный)</div>
                <div class="mode__desc">Скорость до 55 км/ч, сбалансированная мощность и запас хода. Оптимален для трасс средней сложности.</div>
              </div>
              <div class="mode">
                <div class="mode__name">RACE (Гоночный)</div>
                <div class="mode__desc">Полная мощность, скорость до 75 км/ч, максимальная отзывчивость. Только для опытных райдеров на открытых трассах.</div>
              </div>
            </div>
          </div>
        </article>

        <article class="r-card r-card--lite">
          <div class="r-card__icon">
            <img src="/assets/components/svg/warn.svg" alt="">
          </div>
          <div class="r-card__body">
            <h3 class="r-card__title">Важные предупреждения</h3>
            <ul class="r-list">
              <li>Никогда не погружайте мотоцикл в воду и не мойте под сильным напором</li>
              <li>Не пытайтесь самостоятельно ремонтировать электрические компоненты</li>
              <li>В случае аварии или серьезного падения обязательно пройдите техосмотр</li>
              <li>Храните вдали от источников огня и прямых солнечных лучей</li>
            </ul>
          </div>
        </article>
      </section>

    </div>
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

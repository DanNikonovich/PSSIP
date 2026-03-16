<!doctype html>
<html lang="ru" id="top">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <link rel="icon" type="image/png" href="/assets/components/E.png">
  <title>E-RIDE</title>
  <link rel="stylesheet" href="/assets/css/style.css?v=3">
</head>

<body>
  <!--------------------------------------------- HEADER --------------------------------------------->
  <header class="site-header">
    <div class="header-bar">
      <nav class="nav left" aria-label="Навигация слева">
        <a class="nav-link" href="/promo">Акции</a>
        <a class="nav-link" href="/rules">Правила</a>
      </nav>

      <a class="logo" href="#top" aria-label="На главную">
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

  <!--------------------------------------------- HERO --------------------------------------------->
  <section class="hero" aria-label="Герой секция">
    <div class="hero__bg" aria-hidden="true"></div>

    <div class="hero__content">
      <h1 class="hero__title">
        БЕЗ ДОРОГ.<br>БЕЗ ОГРАНИЧЕНИЙ.<br>ТОЛЬКО АДРЕНАЛИН.
      </h1>
      <p class="hero__subtitle">
        Арендуй мощный электробайк и открой для себя дикие трассы, созданные для настоящих экстремалов.
      </p>
    </div>

    <a class="hero__to-top" href="#top" aria-label="Наверх страницы">
      <img src="/assets/components/svg/Upper.svg" alt="" aria-hidden="true">
    </a>
  </section>

  <!--------------------------------------------- Bikes --------------------------------------------->
  <section class="bikes" id="bikes">
    <div class="bikes__head">
      <img class="bikes__head-ico" src="/assets/components/svg/biker.svg" alt="" aria-hidden="true">
      <h2 class="bikes__head-title">Наш парк байков</h2>
    </div>

    <div class="bikes__grid">
      <!-- LEFT: info cards -->
      <div class="bikes__left">

        <article class="info-card">
          <h3 class="info-card__title">ХАРАКТЕРИСТИКИ</h3>

          <div class="info-card__rows">
            <?php foreach (($bikeSpecs ?? []) as $row): ?>
              <div class="info-row">
                <span class="info-row__icon">
                  <img src="<?= htmlspecialchars($row['icon']) ?>" alt="" aria-hidden="true">
                </span>
                <div class="info-row__text">
                  <div class="info-row__desc"><?= htmlspecialchars($row['desc']) ?></div>
                  <div class="info-row__value"><?= htmlspecialchars($row['value']) ?></div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </article>
            
        <article class="info-card">
          <h3 class="info-card__title">КОГДА АРЕНДА НЕВОЗМОЖНА</h3>
            
          <div class="info-card__rows">
            <?php foreach (($bikeLimits ?? []) as $row): ?>
              <div class="info-row">
                <span class="info-row__icon">
                  <img src="<?= htmlspecialchars($row['icon']) ?>" alt="" aria-hidden="true">
                </span>
                <div class="info-row__text">
                  <div class="info-row__desc"><?= htmlspecialchars($row['desc']) ?></div>
                  <div class="info-row__value"><?= htmlspecialchars($row['value']) ?></div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </article>
            
      </div>
            
      <!-- RIGHT: slider -->
      <div class="bikes__right">
        <div class="slider" data-slider>
          <div class="slider__stage">
            <div class="slider__track" data-track>
              <?php foreach (($bikeSlides ?? []) as $s): ?>
                <div class="slide" 
                data-color="<?= htmlspecialchars($s['color']) ?>"
                data-price="<?= htmlspecialchars($s['price_per_hour']) ?>">
                  <img src="<?= htmlspecialchars($s['image']) ?>" alt="Bike">
                </div>
              <?php endforeach; ?>
            </div>
              
            <!-- ОДНА плашка -->
            <?php
              $firstPrice = !empty($bikeSlides[0]['price_per_hour']) ? $bikeSlides[0]['price_per_hour'] : 80;
            ?>
            <div class="price-tag" id="priceTag"><?= htmlspecialchars($firstPrice) ?> BYN</div>
          </div>
              
          <div class="slider__controls">
            <button class="ctrl ctrl--prev" type="button" data-prev>
              <span class="ctrl__arrow">‹</span>
              <span class="ctrl__label">REVERSE</span>
            </button>

            <button class="ctrl ctrl--next" type="button" data-next>
              <span class="ctrl__label">DRIVE</span>
              <span class="ctrl__arrow">›</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!--------------------------------------------- Legendary Tracks --------------------------------------------->
  <section class="tracks" id="tracks" aria-label="Легендарные трассы">
    <!-- Заголовок как раньше -->
    <div class="tracks__head">
      <img class="tracks__head-ico" src="/assets/components/svg/biker.svg" alt="" aria-hidden="true">
      <h2 class="tracks__head-title">Легендарные трассы</h2>
    </div>

    <!-- Tabs -->
    <div class="tracks__tabs" role="tablist" aria-label="Выбор типа трасс">
      <button class="tracks__tab is-active" type="button" role="tab"
              aria-selected="true" data-tab="routes">
        Маршруты
        <span class="tracks__underline" aria-hidden="true"></span>
      </button>

      <button class="tracks__tab" type="button" role="tab"
              aria-selected="false" data-tab="training">
        Тренировочная трасса
        <span class="tracks__underline" aria-hidden="true"></span>
      </button>
    </div>

    <!-- ===== PANEL: ROUTES ===== -->
    <div class="tracks__panel is-active" data-panel="routes">
      <div class="routes-grid" data-routes-grid>
        <!-- EASY -->
        <article class="route-card" data-route="easy">
          <h3 class="route-card__lvl">Лёгкий</h3>

          <div class="route-card__media">
            <img src="/assets/components/map/EASY.jpg" alt="Маршрут: лёгкий">
            <div class="route-card__fade" aria-hidden="true"></div>
            <div class="route-card__hint">Нажмите для подробностей</div>

            <!-- видео (скрыто пока не раскрыто) -->
            <video class="route-card__video" preload="metadata" muted playsinline>
              <source src="/assets/components/map/EASY.mp4" type="video/mp4">
            </video>
          </div>
        </article>

        <!-- HARD -->
        <article class="route-card" data-route="hard">
          <h3 class="route-card__lvl">Сложный</h3>

          <div class="route-card__media">
            <img src="/assets/components/map/HARD.jpg" alt="Маршрут: сложный">
            <div class="route-card__fade" aria-hidden="true"></div>
            <div class="route-card__hint">Нажмите для подробностей</div>

            <video class="route-card__video" preload="metadata" muted playsinline>
              <source src="/assets/components/map/HARD.mp4" type="video/mp4">
            </video>
          </div>
        </article>

        <!-- MEDIUM -->
        <article class="route-card" data-route="medium">
          <h3 class="route-card__lvl">Средний</h3>

          <div class="route-card__media">
            <img src="/assets/components/map/MEDIUM.jpg" alt="Маршрут: средний">
            <div class="route-card__fade" aria-hidden="true"></div>
            <div class="route-card__hint">Нажмите для подробностей</div>

            <video class="route-card__video" preload="metadata" muted playsinline>
              <source src="/assets/components/map/MEDIUM.mp4" type="video/mp4">
            </video>
          </div>
        </article>
      </div>

      <!-- общая плашка снизу -->
      <div class="tracks-info">
        <div class="tracks-info__top">
          <span class="dot dot--easy" aria-hidden="true"></span>
          <span class="dot dot--hard" aria-hidden="true"></span>
          <span class="dot dot--med" aria-hidden="true"></span>
          <div class="tracks-info__title">Характеристики всех трасс</div>
        </div>

        <div class="tracks-info__line" aria-hidden="true"></div>

        <div class="tracks-info__grid">
          <div class="ti-row">
            <span class="ti-ico"><img src="/assets/components/svg/length.svg" alt="" aria-hidden="true"></span>
            <div>
              <div class="ti-desc">Размеры маршрутов</div>
              <div class="ti-val">От 15 до 25 км</div>
            </div>
          </div>

          <div class="ti-row">
            <span class="ti-ico"><img src="/assets/components/svg/clock.svg" alt="" aria-hidden="true"></span>
            <div>
              <div class="ti-desc">Время заезда</div>
              <div class="ti-val">Ориентировочно 2 часа</div>
            </div>
          </div>

          <div class="ti-row">
            <span class="ti-ico"><img src="/assets/components/svg/car.svg" alt="" aria-hidden="true"></span>
            <div>
              <div class="ti-desc">Байков в заезде</div>
              <div class="ti-val">4 райдера и инструктор</div>
            </div>
          </div>

          <div class="ti-row">
            <span class="ti-ico"><img src="/assets/components/svg/speed.svg" alt="" aria-hidden="true"></span>
            <div>
              <div class="ti-desc">Оптимальная скорость</div>
              <div class="ti-val">~ 45–55 км/ч</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ===== PANEL: TRAINING ===== -->
    <div class="tracks__panel" data-panel="training">
      <div class="training-layout">
        <!-- left cards -->
        <div class="training-cards">
          <div class="tcard">
            <span class="tcard__ico"><img src="/assets/components/svg/clock.svg" alt="" aria-hidden="true"></span>
            <div>
              <div class="tcard__desc">Длительность заезда</div>
              <div class="tcard__val">10 минуты</div>
            </div>
            <span class="tcard__ico"><img src="/assets/components/svg/car.svg" alt="" aria-hidden="true"></span>
            <div>
              <div class="tcard__desc">Машин в заезде</div>
              <div class="tcard__val">8 картов</div>
            </div>
          </div>
        </div>

        <!-- center image -->
        <div class="training-track">
          <img src="/assets/css/img/track.png" alt="Тренировочная трасса">
        </div>

        <!-- right cards -->
        <div class="training-cards">
          <div class="tcard">
            <span class="tcard__ico"><img src="/assets/components/svg/length.svg" alt="" aria-hidden="true"></span>
            <div>
              <div class="tcard__desc">Длина трассы</div>
              <div class="tcard__val">550 метров</div>
            </div>
            <span class="tcard__ico"><img src="/assets/components/svg/speed.svg" alt="" aria-hidden="true"></span>
            <div>
              <div class="tcard__desc">Прохождения круга</div>
              <div class="tcard__val">~ 1,15 минуты</div>
            </div>
            <span class="tcard__ico"><img src="/assets/components/svg/turn.svg" alt="" aria-hidden="true"></span>
            <div>
              <div class="tcard__desc">Поворотов на трассе</div>
              <div class="tcard__val">16</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!--------------------------------------------- Why we --------------------------------------------->
  <section class="why" id="why">
    <!-- верх: заголовок + текст -->
    <div class="why__top">
      <div class="section-title">
        <img class="section-title__icon" src="/assets/components/svg/biker.svg" alt="" aria-hidden="true">
        <h2 class="section-title__text">Почему мы</h2>
      </div>

      <p class="why__lead">
        <span class="why__brand">E-RIDE</span>
        — это адреналин, умноженный на мощь электричества!<br>
        Наши современные электробайки, профессиональная экипировка и продуманные внедорожные трассы созданы для того, чтобы дарить вам уверенность
        на каждом повороте и полную свободу на бездорожье. Мы тщательно поддерживаем технику и маршруты в идеальном состоянии, чтобы ваши впечатления
        от скорости были по-настоящему яркими и безопасными. Неважно, впервые вы за рулем электровнедорожника или опытный райдер — у нас вы найдете
        идеальную технику для уверенного старта, захватывающих приключений с друзьями или настоящих экстремальных миссий.
      </p>
    </div>

    <!-- блок, который “пинится” и скроллит текст поверх картинки -->
    <div class="why-scroll" data-why>
      <div class="why-scroll__sticky">
        <img class="why-scroll__img" src="/assets/css/img/ScrollImage.png" alt="E-RIDE">

        <div class="why-scroll__overlay" aria-hidden="true">
          <div class="why-scroll__words" data-words>
            <div class="why-scroll__words" data-words>
              <div class="why-slide is-big" data-slide>
                <div class="why-big">5</div>
                <div class="why-sub">электромотоциклов</div>
              </div>
            
              <div class="why-slide is-big" data-slide>
                <div class="why-big">GoPro</div>
                <div class="why-sub">запечатлит весь экшен</div>
              </div>
            
              <div class="why-slide is-big" data-slide>
                <div class="why-big">3</div>
                <div class="why-sub">типа маршрутов</div>
              </div>
            
              <div class="why-slide is-big is-last" data-slide>
                <div class="why-big">100%</div>
                <div class="why-sub">подготовка к каждому<br>заезду</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- спейсер: высота скролла внутри “пина” -->
      <div class="why-scroll__spacer" data-spacer></div>
    </div>
  </section>

  <!--------------------------------------------- Events --------------------------------------------->
  <section class="events" id="events" data-events>
    <!-- заголовок как раньше (иконка + текст) -->
    <div class="section-head">
      <img class="section-head__ico" src="/assets/components/svg/biker.svg" alt="" aria-hidden="true">
      <h2 class="section-head__title">Мероприятия и туры</h2>
    </div>

    <!-- 3 вида мероприятий -->
    <div class="events-tabs" role="tablist" aria-label="Виды мероприятий">
      <button class="event-tab is-active" type="button" role="tab" aria-selected="true"
        data-type="learn"
        data-icon="/assets/components/svg/teach.svg"
        data-icon-act="/assets/components/svg/teach_act.svg"
        data-event-id="1">
        <img class="event-tab__ico" src="/assets/components/svg/teach_act.svg" alt="" aria-hidden="true">
        <div class="event-tab__txt">
          <div class="event-tab__title">Обучающие занятия</div>
          <div class="event-tab__sub">Организуем обучение и адреналиновые заезды для сплочения вашей команды.</div>
        </div>
      </button>

      <button class="event-tab" type="button" role="tab" aria-selected="false"
        data-type="friends"
        data-icon="/assets/components/svg/present.svg"
        data-icon-act="/assets/components/svg/present_act.svg"
        data-event-id="2">
        <img class="event-tab__ico" src="/assets/components/svg/present.svg" alt="" aria-hidden="true">
        <div class="event-tab__txt">
          <div class="event-tab__title">Дни рождения</div>
          <div class="event-tab__sub">Отметьте день рождения вместе с друзьями, прокатитесь на электромотоциклах</div>
        </div>
      </button>

      <button class="event-tab" type="button" role="tab" aria-selected="false"
        data-type="turnir"
        data-icon="/assets/components/svg/prize.svg"
        data-icon-act="/assets/components/svg/prize_act.svg"
        data-event-id="3">
        <img class="event-tab__ico" src="/assets/components/svg/prize.svg" alt="" aria-hidden="true">
        <div class="event-tab__txt">
          <div class="event-tab__title">Турниры и чемпионаты</div>
          <div class="event-tab__sub">Участвуйте в регулярных соревнованиях и докажите своё мастерство</div>
        </div>
      </button>
    </div>

    <!-- контент -->
    <div class="events-body">
      <!-- слева картинка -->
      <div class="events-visual">
        <img class="events-visual__img" data-events-img src="/assets/components/actions/learn.jpg" alt="Обучающие занятия">
        <div class="events-visual__label" data-events-label>Обучающие занятия</div>
      </div>

      <!-- справа текст/список/плашка -->
      <div class="events-info">
        <div class="events-program">
          <div class="events-program__title">Что входит в программу:</div>

          <ol class="events-program__list" data-events-list>
            <li><span class="num">01</span><span class="txt">Знакомство с байком и техникой безопасности</span></li>
            <li><span class="num">02</span><span class="txt">Пробный заезд на картодроме</span></li>
            <li><span class="num">03</span><span class="txt">Сопровождение инструктора</span></li>
            <li><span class="num">04</span><span class="txt">Экшн-съёмка</span></li>
          </ol>
        </div>

        <div class="events-offer">
          <div class="events-offer__title">Специальное предложение</div>
          <div class="events-offer__desc">
            После поездки на наших электромотоциклах — получите скидку 15% на заезд в картинг-клубе “Вираж”
          </div>
          <a class="events-offer__link" href="/booking" data-booking-link>Забронировать мероприятие →</a>
        </div>
      </div>
    </div>

    <!-- нижний двойной авто-слайдер -->
    <div class="events-marquee" data-marquee>
      <div class="marquee-row" data-row="1">
        <div class="marquee-track" data-track="1">
          <img src="/assets/components/slider1/1.png" alt="">
          <img src="/assets/components/slider1/2.png" alt="">
          <img src="/assets/components/slider1/3.png" alt="">
          <img src="/assets/components/slider1/4.png" alt="">
          <img src="/assets/components/slider1/5.png" alt="">
          <img src="/assets/components/slider1/6.png" alt="">
          <img src="/assets/components/slider1/7.png" alt="">
          <img src="/assets/components/slider1/8.png" alt="">
        </div>
      </div>

      <div class="marquee-row" data-row="2">
        <div class="marquee-track" data-track="2">
          <img src="/assets/components/slider2/1.png" alt="">
          <img src="/assets/components/slider2/2.png" alt="">
          <img src="/assets/components/slider2/3.png" alt="">
          <img src="/assets/components/slider2/4.png" alt="">
          <img src="/assets/components/slider2/5.png" alt="">
          <img src="/assets/components/slider2/6.png" alt="">
          <img src="/assets/components/slider2/7.png" alt="">
          <img src="/assets/components/slider2/8.png" alt="">
        </div>
      </div>
    </div>
  </section>

  <!--------------------------------------------- Visitors --------------------------------------------->
  <section class="guests" id="guests">
    <!-- Заголовок как в прошлых секциях -->
    <div class="section-title">
      <img src="/assets/components/svg/biker.svg" alt="" aria-hidden="true">
      <h2>Наши знаменитые посетители</h2>
    </div>

    <div class="guests__main">
      <!-- 1/3: текст + плашки -->
      <div class="guests__left">
        <h3 class="guests__name">Дмитрий Нагул</h3>

        <p class="guests__desc">
          Чемпион Беларуси по автоспорту, многократный победитель соревнований.
          Дмитрий регулярно посещает наш картинг клуб для тренировок и проведения мастер-классов.
        </p>

        <div class="guests__quote">
          <img class="guests__quote-ico" src="/assets/components/svg/quote.svg" alt="" aria-hidden="true">
          <p class="guests__quote-text">
            "Как гонщик, ценю, когда техника работает идеально. Здесь именно так: мощно, надежно,
            предсказуемо. Трассы подготовлены грамотно, экипировка на уровне. Отличный формат
            для заряда на час!"
          </p>
          <div class="guests__quote-author">— Дмитрий Нагул</div>
        </div>

        <div class="guests__stats">
          <div class="gstat">
            <div class="gstat__num">15+</div>
            <div class="gstat__label">Побед в чемпионатах</div>
          </div>
          <div class="gstat">
            <div class="gstat__num">8</div>
            <div class="gstat__label">Рекордов трассы</div>
          </div>
          <div class="gstat">
            <div class="gstat__num">20</div>
            <div class="gstat__label">Мастер-классов</div>
          </div>
        </div>
      </div>

      <!-- 2/3: мозаика 5x4 из одного изображения -->
      <div class="guests__mosaic" aria-label="Фотогалерея">
        <!-- 20 плиток -->
        <!-- важное: src один и тот же, а “окно” делаем через background-position -->
        <div class="tile" style="--c:0; --r:0"></div>
        <div class="tile" style="--c:1; --r:0"></div>
        <div class="tile" style="--c:2; --r:0"></div>
        <div class="tile" style="--c:3; --r:0"></div>
        <div class="tile" style="--c:4; --r:0"></div>

        <div class="tile" style="--c:0; --r:1"></div>
        <div class="tile" style="--c:1; --r:1"></div>
        <div class="tile" style="--c:2; --r:1"></div>
        <div class="tile" style="--c:3; --r:1"></div>
        <div class="tile" style="--c:4; --r:1"></div>

        <div class="tile" style="--c:0; --r:2"></div>
        <div class="tile" style="--c:1; --r:2"></div>
        <div class="tile" style="--c:2; --r:2"></div>
        <div class="tile" style="--c:3; --r:2"></div>
        <div class="tile" style="--c:4; --r:2"></div>

        <div class="tile" style="--c:0; --r:3"></div>
        <div class="tile" style="--c:1; --r:3"></div>
        <div class="tile" style="--c:2; --r:3"></div>
        <div class="tile" style="--c:3; --r:3"></div>
        <div class="tile" style="--c:4; --r:3"></div>
      </div>
    </div>

    <!-- Нижняя плашка -->
    <div class="guests__footer">
      <h4 class="guests__footer-title">Другие известные посетители</h4>

      <div class="guests__footer-list">
        <div class="mini">
          <div class="mini__icon"><img src="/assets/components/svg/prizeblack.svg" alt=""></div>
          <div class="mini__name">Алексей Сидоров</div>
          <div class="mini__role">Автогонщик, DTM</div>
        </div>

        <div class="mini">
          <div class="mini__icon"><img src="/assets/components/svg/prizeblack.svg" alt=""></div>
          <div class="mini__name">Максим Петров</div>
          <div class="mini__role">Чемпион Rally</div>
        </div>

        <div class="mini">
          <div class="mini__icon"><img src="/assets/components/svg/prizeblack.svg" alt=""></div>
          <div class="mini__name">Иван Королев</div>
          <div class="mini__role">Мотоспорт</div>
        </div>
      </div>
    </div>
  </section>

  <!--------------------------------------------- ECO --------------------------------------------->
  <section class="eco" id="eco" aria-label="Экологическая ответственность">
    <div class="container eco__container">
      <!-- title (как в прошлых секциях) -->
      <div class="section-title">
        <img class="section-title__ico" src="/assets/components/svg/biker.svg" alt="" aria-hidden="true">
        <h2 class="section-title__text">Экологическая ответственность</h2>
      </div>

      <div class="eco__grid">
        <article class="eco-card">
          <div class="eco-card__icon eco-card__icon--green1">
            <img src="/assets/components/svg/eco_battery.svg" alt="" aria-hidden="true">
          </div>
          <div class="eco-card__content">
            <h3 class="eco-card__title">Нулевые выбросы</h3>
            <p class="eco-card__text">
              Наши электробайки работают на 100% электрической энергии без выброса CO2 и вредных веществ в атмосферу
            </p>
          </div>
        </article>

        <article class="eco-card">
          <div class="eco-card__icon eco-card__icon--blue">
            <img src="/assets/components/svg/tree.svg" alt="" aria-hidden="true">
          </div>
          <div class="eco-card__content">
            <h3 class="eco-card__title">Сохранение природы</h3>
            <p class="eco-card__text">
              Все маршруты проложены с учетом защиты экосистемы. Мы избегаем заповедных зон и мест обитания редких видов
            </p>
          </div>
        </article>

        <article class="eco-card">
          <div class="eco-wide__icon">
            <img src="/assets/components/svg/leaves.svg" alt="" aria-hidden="true">
          </div>
          <div class="eco-card__content">
            <h3 class="eco-card__title">Минимальный след</h3>
            <p class="eco-card__text">
              Электробайки создают минимальный шум, не нарушая покой дикой природы. Покрышки разработаны для минимального воздействия на почву
            </p>
          </div>
        </article>

        <article class="eco-card">
          <div class="eco-card__icon eco-card__icon--blue2">
            <img src="/assets/components/svg/recycling.svg" alt="" aria-hidden="true">
          </div>
          <div class="eco-card__content">
            <h3 class="eco-card__title">Переработка и уход</h3>
            <p class="eco-card__text">
              Все расходные материалы и аккумуляторы утилизируются экологически безопасным способом. Используем биоразлагаемые масла
            </p>
          </div>
        </article>
      </div>

      <!-- last wide card -->
      <article class="eco-wide">
        <div class="eco-card__icon">
          <img src="/assets/components/svg/eco_leaves.svg" alt="" aria-hidden="true">
        </div>

        <div class="eco-wide__content">
          <h3 class="eco-wide__title">Программа “Зелёный маршрут”</h3>

          <p class="eco-wide__text">
            За каждую поездку мы высаживаем одно дерево в партнерстве с экологическими организациями. Уже более 500 деревьев посажено нашими клиентами!
          </p>

          <p class="eco-wide__accent">Вместе мы делаем планету чище и зеленее</p>
        </div>
      </article>
    </div>
  </section>

  <!--------------------------------------------- Comments --------------------------------------------->
  <section class="reviews" id="reviews">
    <div class="reviews__inner">
      <div class="section-title">
        <img class="section-title__ico" src="/assets/components/svg/biker.svg" alt="" aria-hidden="true">
        <h2 class="section-title__text">Отзывы наших гостей</h2>
      </div>

      <div class="reviews__grid">
        <!-- LEFT: comments -->
        <div class="reviews__feed" aria-label="Отзывы" data-feed>
          <div class="reviews__list" data-list>
        
            <?php foreach (($comments ?? []) as $c): ?>
              <?php
                $name = $c['author_name'] ?? 'Гость';
                $date = $c['date_created'] ?? '';
                $text = $c['text_review'] ?? '';
                $rating = (int)($c['rating'] ?? 5);
                $rating = max(1, min(5, $rating));
              ?>
              <article class="review-card">
                <div class="review-card__head">
                  <div class="review-card__user">
                    <span class="review-card__avatar">
                      <img src="/assets/components/svg/user.svg" alt="" aria-hidden="true">
                    </span>
                    <div class="review-card__meta">
                      <div class="review-card__name"><?= htmlspecialchars($name) ?></div>
                      <div class="review-card__date"><?= htmlspecialchars($date) ?></div>
                    </div>
                  </div>
            
                  <div class="review-card__stars" aria-label="Оценка <?= $rating ?> из 5">
                    <?php for ($i=1; $i<=5; $i++): ?>
                      <img src="/assets/components/svg/<?= $i <= (int)$c['rating'] ? 'star_fill' : 'star_stroke' ?>.svg" alt="" aria-hidden="true">
                    <?php endfor; ?>
                  </div>
                </div>
                    
                <div class="review-card__text"><?= nl2br(htmlspecialchars($c['text_review'])) ?></div>
              </article>
            <?php endforeach; ?>      
          </div>
        </div>

        <!-- RIGHT: form -->
        <aside class="reviews__form" aria-label="Оставить отзыв">
          <div class="form-card">
            <div class="form-card__title">Оставьте отзыв</div>

            <?php if (!empty($_SESSION['flash_ok'])): ?>
              <div class="form-card__msg form-card__msg--ok">
                <?= htmlspecialchars($_SESSION['flash_ok']) ?>
              </div>
              <?php unset($_SESSION['flash_ok']); ?>
            <?php endif; ?>
            
            <form method="post" action="/comments/store" data-review-form>
              <label class="form-card__label" for="revName">Ваше имя</label>
              <input class="form-card__input" id="revName" name="author_name" type="text"
                     placeholder="Введите имя"
                     value="<?= htmlspecialchars($_SESSION['pending_comment']['author_name'] ?? '') ?>">
            
              <label class="form-card__label" for="revText">Ваш отзыв</label>
              <textarea class="form-card__textarea" id="revText" name="text_review" rows="5"
                        placeholder="Поделитесь своими впечатлениями..."><?= htmlspecialchars($_SESSION['pending_comment']['text_review'] ?? '') ?></textarea>
            
              <input type="hidden" name="rating" value="<?= (int)($_SESSION['pending_comment']['rating'] ?? 0) ?>" data-rating-value>
            
              <div class="form-card__label">Оценка</div>
              <div class="rate" data-rate>
                <?php for ($i=1; $i<=5; $i++): ?>
                  <button class="rate__star" type="button" data-star="<?= $i ?>" aria-label="<?= $i ?> звезда">
                    <img src="/assets/components/svg/star_stroke.svg" alt="" aria-hidden="true">
                  </button>
                <?php endfor; ?>
              </div>
                
              <button class="form-card__btn" type="submit">Отправить отзыв</button>
            </form>
                
            <div class="form-card__hr"></div>
                
            <div class="form-card__rating">
              <img src="/assets/components/svg/star_fill.svg" alt="" aria-hidden="true">
              <span><b>4.6</b> из 5 на основе <b>196</b> отзывов</span>
            </div>
          </div>
        </aside>
      </div>
    </div>
  </section>

  <!--------------------------------------------- FAQ --------------------------------------------->
  <section class="faq" id="faq" aria-label="Часто задаваемые вопросы">
    <div class="faq__container">
      <!-- Заголовок как в прошлых секциях -->
      <div class="section-title">
        <img class="section-title__icon" src="/assets/components/svg/biker.svg" alt="" aria-hidden="true">
        <h2 class="section-title__text">Часто задаваемые вопросы</h2>
      </div>

      <div class="faq__list" data-faq>
        <?php foreach (($faq ?? []) as $row): ?>
          <article class="faq-item">
            <button class="faq-q" type="button" aria-expanded="false">
              <span class="faq-q__text"><?= htmlspecialchars($row['question']) ?></span>
              <span class="faq-q__chev" aria-hidden="true"></span>
            </button>
            <div class="faq-a" role="region">
              <p><?= nl2br(htmlspecialchars($row['answer'])) ?></p>
            </div>
          </article>
        <?php endforeach; ?>
      </div>

      <div class="faq__footer">
        <div class="faq__hint">Не нашли ответ на свой вопрос?</div>
        <a class="faq__link" href="#contacts">Свяжитесь с нами →</a>
      </div>
    </div>
  </section>

  <!--------------------------------------------- Map --------------------------------------------->
  <section class="findus" id="findus" aria-label="Как нас найти">
    <div class="findus__container">
      <!-- Заголовок как в прошлых секциях -->
      <div class="section-title">
        <img class="section-title__icon" src="/assets/components/svg/biker.svg" alt="" aria-hidden="true">
        <h2 class="section-title__text">Как нас найти</h2>
      </div>

      <!-- Карта -->
      <a class="findus__map" href="https://yandex.by/maps/org/e_ride/239944247734/?ll=23.812518%2C53.720054&z=14.7" target="_blank" rel="noopener noreferrer" aria-label="Открыть на Яндекс Картах">
        <iframe
          class="findus__iframe"
          src="https://yandex.by/map-widget/v1/?ll=23.812518%2C53.720054&z=14.7&pt=23.812518,53.720054,pm2rdm"
          frameborder="0"
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
          aria-hidden="true"
          tabindex="-1"
        ></iframe>

        <!-- затемнение/виньетка как в макете -->
        <span class="findus__mapfx" aria-hidden="true"></span>

        <!-- маркер по центру (как на скрине) -->
        <span class="findus__pin" aria-hidden="true"></span>
      </a>

      <!-- Адрес под картой -->
      <a class="findus__addr"
         href="https://yandex.by/maps/org/e_ride/239944247734/?ll=23.812518%2C53.720054&z=14.7"
         target="_blank" rel="noopener noreferrer">
        <img class="findus__addr-ico" src="/assets/components/svg/map_point.svg" alt="" aria-hidden="true">
        <span class="findus__addr-text">г. Гродно, ул. Санаторная, 16</span>
        <span class="findus__addr-arrow" aria-hidden="true">↗</span>
      </a>
    </div>
  </section>

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

  <!-- JS отдельным файлом -->
  <script src="/assets/js/menu.js" defer></script>
  <script src="/assets/js/hero.js" defer></script>
  <script src="/assets/js/scroll-top.js" defer></script>
  <script src="/assets/js/bikes-slider.js" defer></script>
  <script src="/assets/js/tracks.js" defer></script>
  <script src="/assets/js/why-scroll.js" defer></script>
  <script>
    window.EVENTS = <?= json_encode($events ?? [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
  </script>
  <script src="/assets/js/events.js" defer></script>
  <script src="/assets/js/marquee.js" defer></script>
  <script src="/assets/js/comments.js" defer></script>
  <script src="/assets/js/reviews.js" defer></script>
  <script src="/assets/js/faq.js" defer></script>
  <script src="/assets/js/footer.js" defer></script>
  <script src="/assets/js/bg.js" defer></script>
</body>
</html>
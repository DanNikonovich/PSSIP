-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Хост: MySQL-8.4:3306
-- Время создания: Мар 16 2026 г., 20:06
-- Версия сервера: 8.4.6
-- Версия PHP: 8.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `e_ride`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bikes_slider`
--

CREATE TABLE `bikes_slider` (
  `id_slide` int NOT NULL,
  `image` varchar(255) NOT NULL,
  `color` varchar(32) NOT NULL DEFAULT '#000000',
  `price_per_hour` decimal(10,2) NOT NULL DEFAULT '80.00',
  `display_order` int NOT NULL DEFAULT '0',
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `bikes_slider`
--

INSERT INTO `bikes_slider` (`id_slide`, `image`, `color`, `price_per_hour`, `display_order`, `visible`, `created_at`) VALUES
(1, '/assets/components/bikes/1.png', '#908F4A', 80.00, 1, 1, '2026-03-05 20:43:22'),
(2, '/assets/components/bikes/2.png', '#000000', 80.00, 2, 1, '2026-03-05 20:43:22'),
(3, '/assets/components/bikes/3.png', '#003A96', 80.00, 3, 1, '2026-03-05 20:43:22'),
(4, '/assets/components/bikes/4.png', '#895FCD', 80.00, 4, 1, '2026-03-05 20:43:22');

-- --------------------------------------------------------

--
-- Структура таблицы `bike_info_items`
--

CREATE TABLE `bike_info_items` (
  `id_item` int NOT NULL,
  `section` enum('specs','limits') NOT NULL,
  `icon` varchar(255) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `display_order` int NOT NULL DEFAULT '0',
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `bike_info_items`
--

INSERT INTO `bike_info_items` (`id_item`, `section`, `icon`, `desc`, `value`, `display_order`, `visible`, `created_at`) VALUES
(1, 'specs', '/assets/components/svg/speed.svg', 'Максимальная скорость', '~60–70 км/ч', 1, 1, '2026-03-05 20:43:21'),
(2, 'specs', '/assets/components/svg/battery.svg', 'Размер аккумулятора', '60V/40AH', 2, 1, '2026-03-05 20:43:21'),
(3, 'specs', '/assets/components/svg/wheel.svg', 'Крутящий момент', '250 n.m', 3, 1, '2026-03-05 20:43:21'),
(4, 'specs', '/assets/components/svg/engine.svg', 'Мощность', '8000 W', 4, 1, '2026-03-05 20:43:21'),
(5, 'specs', '/assets/components/svg/weight.svg', 'Вес байка', '56 кг', 5, 1, '2026-03-05 20:43:21'),
(6, 'limits', '/assets/components/svg/alcogole.svg', 'Алкогольное опьянение', 'присутствует', 1, 1, '2026-03-05 20:43:22'),
(7, 'limits', '/assets/components/svg/heart.svg', 'Проблемы с сердцем', 'имеются', 2, 1, '2026-03-05 20:43:22'),
(8, 'limits', '/assets/components/svg/age.svg', 'Возраст', 'до 18 лет', 3, 1, '2026-03-05 20:43:22'),
(9, 'limits', '/assets/components/svg/height.svg', 'Рост райдера', '< 160 см', 4, 1, '2026-03-05 20:43:22'),
(10, 'limits', '/assets/components/svg/weight.svg', 'Вес райдера', 'до 100 кг', 5, 1, '2026-03-05 20:43:22');

-- --------------------------------------------------------

--
-- Структура таблицы `bookings`
--

CREATE TABLE `bookings` (
  `id_booking` int NOT NULL,
  `date_booking` date NOT NULL,
  `time_booking` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `bikes_count` int NOT NULL,
  `payment_type` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `paid_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `left_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `id_user` int NOT NULL,
  `id_event` int NOT NULL,
  `id_promo` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `bookings`
--

INSERT INTO `bookings` (`id_booking`, `date_booking`, `time_booking`, `bikes_count`, `payment_type`, `total_amount`, `paid_amount`, `left_amount`, `discount_amount`, `id_user`, `id_event`, `id_promo`, `created_at`) VALUES
(5, '2026-03-07', '11:00,12:00', 3, 'part', 480.00, 144.00, 336.00, 0.00, 6, 2, 6, '2026-03-04 10:56:01'),
(6, '2026-03-06', '11:00,12:00,13:00', 4, 'part', 960.00, 288.00, 672.00, 0.00, 6, 2, 8, '2026-03-04 11:40:16'),
(7, '2026-03-07', '11:00,12:00', 1, 'part', 160.00, 48.00, 112.00, 0.00, 6, 3, 9, '2026-03-04 12:57:55'),
(8, '2026-03-07', '13:00', 1, 'full', 80.00, 80.00, 0.00, 0.00, 6, 3, 9, '2026-03-04 13:21:35'),
(9, '2026-03-08', '10:00', 1, 'full', 80.00, 80.00, 0.00, 0.00, 6, 1, 10, '2026-03-04 13:31:50'),
(10, '2026-03-04', '11:00,12:00', 4, 'part', 640.00, 192.00, 448.00, 0.00, 6, 2, 8, '2026-03-04 14:17:35'),
(11, '2026-03-27', '16:00,17:00', 2, 'part', 320.00, 96.00, 224.00, 0.00, 6, 3, 8, '2026-03-05 11:08:41'),
(12, '2026-03-23', '10:00,11:00,12:00', 3, 'part', 720.00, 216.00, 504.00, 0.00, 6, 1, 8, '2026-03-05 16:48:52'),
(13, '2026-03-15', '11:00,12:00', 2, 'full', 320.00, 320.00, 0.00, 0.00, 6, 3, 8, '2026-03-06 07:47:45'),
(14, '2026-03-07', '16:00,17:00', 4, 'part', 640.00, 192.00, 448.00, 0.00, 6, 2, 7, '2026-03-06 10:48:28');

-- --------------------------------------------------------

--
-- Структура таблицы `booking_slots`
--

CREATE TABLE `booking_slots` (
  `id_slot` int NOT NULL,
  `id_booking` int NOT NULL,
  `date_booking` date NOT NULL,
  `time_slot` time NOT NULL,
  `bikes_count` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `booking_slots`
--

INSERT INTO `booking_slots` (`id_slot`, `id_booking`, `date_booking`, `time_slot`, `bikes_count`) VALUES
(6, 5, '2026-03-07', '11:00:00', 3),
(7, 5, '2026-03-07', '12:00:00', 3),
(8, 6, '2026-03-06', '11:00:00', 4),
(9, 6, '2026-03-06', '12:00:00', 4),
(10, 6, '2026-03-06', '13:00:00', 4),
(11, 7, '2026-03-07', '11:00:00', 1),
(12, 7, '2026-03-07', '12:00:00', 1),
(13, 8, '2026-03-07', '13:00:00', 1),
(14, 9, '2026-03-08', '10:00:00', 1),
(15, 10, '2026-03-04', '11:00:00', 4),
(16, 10, '2026-03-04', '12:00:00', 4),
(17, 11, '2026-03-27', '16:00:00', 2),
(18, 11, '2026-03-27', '17:00:00', 2),
(19, 12, '2026-03-23', '10:00:00', 3),
(20, 12, '2026-03-23', '11:00:00', 3),
(21, 12, '2026-03-23', '12:00:00', 3),
(22, 13, '2026-03-15', '11:00:00', 2),
(23, 13, '2026-03-15', '12:00:00', 2),
(24, 14, '2026-03-07', '16:00:00', 4),
(25, 14, '2026-03-07', '17:00:00', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id_comment` int NOT NULL,
  `id_user` int NOT NULL,
  `text_review` text COLLATE utf8mb4_general_ci NOT NULL,
  `rating` int NOT NULL,
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `visible` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id_comment`, `id_user`, `text_review`, `rating`, `date_created`, `visible`) VALUES
(1, 1, 'Потрясающее место! Устроили встречу друзей, все остались в восторге. Профессиональные инструкторы, отличные карты. Обязательно вернемся!', 5, '2024-10-14 21:00:00', 1),
(2, 2, 'Праздновали день рождения сына. Дети были в восторге! Безопасно, интересно, персонал очень внимательный. Спасибо за праздник!', 5, '2024-10-07 21:00:00', 1),
(3, 3, 'Хожу регулярно, участвую в турнирах. Трасса отличная, техника в идеальном состоянии. Лучшие электромотоциклы в городе!', 5, '2024-10-04 21:00:00', 1),
(4, 4, 'Очень понравилось! Первый раз на таком каталась, немного волновалась, но инструктор все подробно объяснил. Эмоции незабываемые!', 5, '2024-09-24 21:00:00', 1),
(5, 5, 'Сам не водитель, после второго разворота вокруг собственной оси, подошли и сказали, ещё раз и будешь стоять на бровке, эти машины не для дрифта! И не в компетентной форме, а угрожающей. Другу сказали тоже самое. Может я чего не понимаю, но для чего они вообще? После этого инцидента настроение вообще пропало, бред какой-то, асфальт мокрый был чуть что! Так норм ощущения, и трек нормальный, двойка за данную ситуацию.', 2, '2024-09-18 21:00:00', 1),
(8, 6, 'цйкуерн', 4, '2026-03-06 07:50:11', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `events`
--

CREATE TABLE `events` (
  `id_event` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `program_points` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `events`
--

INSERT INTO `events` (`id_event`, `title`, `description`, `image`, `program_points`) VALUES
(1, 'Обучающие занятия', 'Организуем обучение и адреналиновые заезды для сплочения вашей команды.', '/assets/components/actions/learn.jpg', 'Знакомство с байком и техникой безопасности\nПробный заезд на картодроме\nСопровождение инструктора\nЭкшн-съёмка'),
(2, 'Дни рождения', 'Отметьте день рождения вместе с друзьями, прокатитесь на электромотоциклах.', '/assets/components/actions/friends.jpg', 'Праздничное оформление\r\nКонкурсная программа\r\nБанкетная зона\r\nЭкшн-съёмка'),
(3, 'Турниры и чемпионаты', 'Участвуйте в регулярных соревнованиях и докажите своё мастерство.', '/assets/components/actions/turnir.jpg', 'Ежемесячные гонки\r\nСистема рейтинга\r\nКубки и медали\r\nЭкшн-съёмка');

-- --------------------------------------------------------

--
-- Структура таблицы `faq`
--

CREATE TABLE `faq` (
  `id_faq` int NOT NULL,
  `question` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `answer` text COLLATE utf8mb4_general_ci NOT NULL,
  `display_order` int NOT NULL DEFAULT '0',
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `faq`
--

INSERT INTO `faq` (`id_faq`, `question`, `answer`, `display_order`, `visible`, `created_at`, `updated_at`) VALUES
(1, 'Нужны ли права?', 'Для управления нашими электробайками права не требуются! Однако вам должно быть не менее 18 лет для проката байков. Мы проводим обязательный инструктаж перед каждой поездкой.', 1, 1, '2026-03-02 18:42:11', NULL),
(2, 'Что если я никогда не ездил?', 'Не переживайте! Большинство наших клиентов - новички. Мы предоставляем полный инструктаж по управлению байком, технике безопасности и особенностям маршрута. Навыков управления велосипедом достаточно для быстрого и лёгкого старта.', 2, 1, '2026-03-02 18:42:11', '2026-03-05 05:22:38'),
(3, 'Что входит в стоимость?', 'В стоимость аренды входит: сам электробайк, полный комплект защитной экипировки (шлем, перчатки, наколенники), базовая страховка, инструктаж, техническая поддержка на трассе. Также в стоимость входит сопровождение гида, фото и видео съемка на камеры GoPro.', 3, 1, '2026-03-02 18:42:11', NULL),
(4, 'Что надеть и взять с собой?', 'Рекомендуем: удобную спортивную одежду (джинсы, толстовка), закрытую обувь на плоской подошве (кроссовки, ботинки), солнцезащитный крем, воду. Всю защитную экипировку мы предоставляем. Не забудьте документ, удостоверяющий личность, и денежные средства для оплаты.', 4, 1, '2026-03-02 18:42:11', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `promos`
--

CREATE TABLE `promos` (
  `id_promo` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `promo_code` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `promos`
--

INSERT INTO `promos` (`id_promo`, `title`, `promo_code`, `date_start`, `date_end`, `description`) VALUES
(6, 'Скидка 20% на первый заезд', 'FIRST20', '2024-01-01', '2026-12-31', 'Успейте забронировать свой первый заезд со скидкой 20%! Попробуйте SUR-RON Light Bee 2025 Sage и почувствуйте настоящую мощь электромотоцикла.'),
(7, 'Групповая скидка до 15%', 'GROUP15', '2024-01-01', '2026-12-31', 'Приезжайте компанией от 3 человек и получите скидку на весь заказ! 3 мотоцикла — скидка 10%. 4 мотоцикла — скидка 15%. Действует на заезды от 2 часов.'),
(8, 'В будние дни -10%', 'WEEKDAY10', '2024-01-01', '2026-12-31', 'Бронируйте заезды на будние дни (Пн–Чт) и экономьте 10% от стоимости! Любая продолжительность. Бронирование за 24 часа.'),
(9, 'Длительный заезд -15%', 'LONG15', '2024-01-01', '2026-12-31', 'Арендуйте мотоциклы на 5+ часов и получите скидку 15% на всё время! Полный день: скидка 30%. Включён комплект экипировки.'),
(10, 'День рождения +1 час', 'BDAYPLUS1H', '2024-01-01', '2026-12-31', 'Празднуете день рождения? Получите дополнительный час аренды в подарок! Действует в день ДР ± 3 дня. При заказе от 2 часов. Нужен документ, подтверждающий ДР.');

-- --------------------------------------------------------

--
-- Структура таблицы `schedule`
--

CREATE TABLE `schedule` (
  `id` int NOT NULL,
  `day_of_week` tinyint NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_working` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `schedule`
--

INSERT INTO `schedule` (`id`, `day_of_week`, `start_time`, `end_time`, `is_working`) VALUES
(1, 1, '00:00:00', '00:00:00', 0),
(2, 2, '10:00:00', '20:00:00', 1),
(3, 3, '10:00:00', '20:00:00', 1),
(4, 4, '10:00:00', '20:00:00', 1),
(5, 5, '10:00:00', '20:00:00', 1),
(6, 6, '10:00:00', '20:00:00', 1),
(7, 7, '10:00:00', '20:00:00', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('user','admin') COLLATE utf8mb4_general_ci DEFAULT 'user',
  `telegram_chat_id` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id_user`, `name`, `email`, `phone`, `password_hash`, `role`, `telegram_chat_id`, `created_at`) VALUES
(1, 'Александр М.', 'alex@example.com', '0000000000', 'testhash', 'user', NULL, '2026-03-02 18:50:32'),
(2, 'Елена С.', 'elena@example.com', '0000000000', 'testhash', 'user', NULL, '2026-03-02 18:50:32'),
(3, 'Игорь В.', 'igor@example.com', '0000000000', 'testhash', 'user', NULL, '2026-03-02 18:50:32'),
(4, 'Мария К.', 'maria@example.com', '0000000000', 'testhash', 'user', NULL, '2026-03-02 18:50:32'),
(5, 'Андрей Ш.', 'andrey@example.com', '0000000000', 'testhash', 'user', NULL, '2026-03-02 18:50:32'),
(6, 'Даниил Никонович', 'dania25092006@gmail.com', '+375292520235', '$2y$12$ykZgLKtkr/fpE8kWPV5WK.UrTx0EGs6s4YW9qxh8Di0mTIMjNJVFK', 'user', 1240509892, '2026-03-03 04:36:57'),
(7, 'Админ', 'admine_ride@gmail.com', '+37585687421246', '$2y$12$ykZgLKtkr/fpE8kWPV5WK.UrTx0EGs6s4YW9qxh8Di0mTIMjNJVFK', 'admin', NULL, '2026-03-04 14:01:18'),
(8, 'Ivan', 'erret@mail.com', '+375292520555', '$2y$12$K11wq8sypwiNu1BILq7XxegfIj258UJbNQ9XnNq82Q.NQiqtrN.iC', 'user', NULL, '2026-03-05 17:26:00');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `bikes_slider`
--
ALTER TABLE `bikes_slider`
  ADD PRIMARY KEY (`id_slide`);

--
-- Индексы таблицы `bike_info_items`
--
ALTER TABLE `bike_info_items`
  ADD PRIMARY KEY (`id_item`);

--
-- Индексы таблицы `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id_booking`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_event` (`id_event`),
  ADD KEY `id_promo` (`id_promo`);

--
-- Индексы таблицы `booking_slots`
--
ALTER TABLE `booking_slots`
  ADD PRIMARY KEY (`id_slot`),
  ADD KEY `idx_date_time` (`date_booking`,`time_slot`),
  ADD KEY `fk_slot_booking` (`id_booking`);

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id_comment`),
  ADD KEY `id_user` (`id_user`);

--
-- Индексы таблицы `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id_event`);

--
-- Индексы таблицы `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id_faq`);

--
-- Индексы таблицы `promos`
--
ALTER TABLE `promos`
  ADD PRIMARY KEY (`id_promo`);

--
-- Индексы таблицы `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `bikes_slider`
--
ALTER TABLE `bikes_slider`
  MODIFY `id_slide` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `bike_info_items`
--
ALTER TABLE `bike_info_items`
  MODIFY `id_item` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id_booking` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `booking_slots`
--
ALTER TABLE `booking_slots`
  MODIFY `id_slot` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id_comment` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `events`
--
ALTER TABLE `events`
  MODIFY `id_event` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `faq`
--
ALTER TABLE `faq`
  MODIFY `id_faq` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `promos`
--
ALTER TABLE `promos`
  MODIFY `id_promo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`id_event`) REFERENCES `events` (`id_event`) ON DELETE RESTRICT,
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`id_promo`) REFERENCES `promos` (`id_promo`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `booking_slots`
--
ALTER TABLE `booking_slots`
  ADD CONSTRAINT `fk_slot_booking` FOREIGN KEY (`id_booking`) REFERENCES `bookings` (`id_booking`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

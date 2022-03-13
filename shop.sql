-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 14 2022 г., 00:43
-- Версия сервера: 8.0.19
-- Версия PHP: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `title`) VALUES
(1, 'women'),
(2, 'men'),
(3, 'kids'),
(4, 'accessories'),
(5, 'new'),
(6, 'sale');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'Не выполнено',
  `price` bigint UNSIGNED NOT NULL,
  `delivery_info` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `product_id`, `status`, `price`, `delivery_info`) VALUES
(1, 1, 'Выполнено', 1500, '{\"client\": {\"name\": \"Иван\", \"email\": \"user1@gmail.com\", \"phone\": \"+79012396262\", \"surname\": \"Николаев\", \"thirdName\": \"Иванович\"}, \"address\": {\"aprt\": \"5\", \"city\": \"Москва\", \"home\": \"3\", \"street\": \"Львовская\"}, \"comment\": \"\", \"needDelivery\": true, \"paymentMethod\": \"Наличные\"}'),
(2, 2, 'Выполнено', 1300, '{\"client\": {\"name\": \"Дмитрий\", \"email\": \"user@gmail.com\", \"phone\": \"+79222392263\", \"surname\": \"Абрашкин\", \"thirdName\": \"Евгеньевич\"}, \"address\": {\"city\": \"Москва\", \"home\": \"5\", \"street\": \"Пушкина\"}, \"comment\": \"\", \"needDelivery\": false, \"paymentMethod\": \"Карта\"}'),
(3, 3, 'Не выполнено', 600, '{\"client\": {\"name\": \"Иван\", \"email\": \"user1@gmail.com\", \"phone\": \"+79012396262\", \"surname\": \"Николаев\", \"thirdName\": \"Иванович\"}, \"address\": {\"aprt\": \"5\", \"city\": \"Москва\", \"home\": \"3\", \"street\": \"Львовская\"}, \"comment\": \"\", \"needDelivery\": true, \"paymentMethod\": \"Наличные\"}'),
(4, 4, 'Не выполнено', 2000, '{\"client\": {\"name\": \"Дмитрий\", \"email\": \"user@gmail.com\", \"phone\": \"+79222392263\", \"surname\": \"Абрашкин\", \"thirdName\": \"Евгеньевич\"}, \"address\": {\"city\": \"Москва\", \"home\": \"5\", \"street\": \"Пушкина\"}, \"comment\": \"\", \"needDelivery\": false, \"paymentMethod\": \"Карта\"}'),
(5, 11, 'Не выполнено', 1500, '{\"client\": {\"name\": \"Иван\", \"email\": \"user1@gmail.com\", \"phone\": \"+79012396262\", \"surname\": \"Николаев\", \"thirdName\": \"Иванович\"}, \"address\": {\"aprt\": \"5\", \"city\": \"Москва\", \"home\": \"3\", \"street\": \"Львовская\"}, \"comment\": \"\", \"needDelivery\": true, \"paymentMethod\": \"Наличные\"}'),
(6, 12, 'Не выполнено', 1500, '{\"client\": {\"name\": \"Дмитрий\", \"email\": \"user@gmail.com\", \"phone\": \"+79222392263\", \"surname\": \"Абрашкин\", \"thirdName\": \"Евгеньевич\"}, \"address\": {\"city\": \"Москва\", \"home\": \"5\", \"street\": \"Пушкина\"}, \"comment\": \"\", \"needDelivery\": false, \"paymentMethod\": \"Карта\"}'),
(7, 14, 'Не выполнено', 1600, '{\"client\": {\"name\": \"Иван\", \"email\": \"user1@gmail.com\", \"phone\": \"+79012396262\", \"surname\": \"Николаев\", \"thirdName\": \"Иванович\"}, \"address\": {\"aprt\": \"5\", \"city\": \"Москва\", \"home\": \"3\", \"street\": \"Львовская\"}, \"comment\": \"\", \"needDelivery\": true, \"paymentMethod\": \"Наличные\"}'),
(8, 2, 'Выполнено', 1300, '{\"client\": {\"name\": \"Дмитрий\", \"email\": \"user@gmail.com\", \"phone\": \"+79222392263\", \"surname\": \"Абрашкин\", \"thirdName\": \"Евгеньевич\"}, \"address\": {\"city\": \"Москва\", \"home\": \"5\", \"street\": \"Пушкина\"}, \"comment\": \"\", \"needDelivery\": false, \"paymentMethod\": \"Карта\"}'),
(9, 10, 'Выполнено', 1500, '{\"client\": {\"name\": \"Светлана\", \"email\": \"moreey1974@gmail.com\", \"phone\": \"+79022396264\", \"surname\": \"Иванова-Дмитриева\", \"thirdName\": \"Бактыр оглы\"}, \"address\": {\"aprt\": \"2\", \"city\": \"Городец\", \"home\": \"4\", \"street\": \"Героя\"}, \"comment\": \"\", \"needDelivery\": true, \"paymentMethod\": \"Карта\"}');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int NOT NULL,
  `pic_source` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `pic_source`) VALUES
(1, 'Новое платье', 2000, 'Новое платье-1.jpg'),
(2, 'рубашка', 1300, 'product-2.jpg'),
(3, 'часы', 600, 'product-3.jpg'),
(4, 'штаны', 2000, 'product-4.jpg'),
(5, 'сумка', 10000, 'product-5.jpg'),
(6, 'платье', 8000, 'product-6.jpg'),
(7, 'пальто', 12000, 'product-7.jpg'),
(8, 'джинсы', 2000, 'product-8.jpg'),
(9, 'платье', 1500, 'product-1.jpg'),
(10, 'рубашка', 1500, 'product-2.jpg'),
(11, 'часы', 1500, 'product-3.jpg'),
(12, 'штаны', 1500, 'product-4.jpg'),
(13, 'сумка', 31999, 'product-5.jpg'),
(14, 'платье', 1600, 'product-6.jpg'),
(15, 'пальто', 1800, 'product-7.jpg'),
(16, 'джинсы', 2000, 'product-8.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `product_category`
--

CREATE TABLE `product_category` (
  `product_id` bigint UNSIGNED DEFAULT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `product_category`
--

INSERT INTO `product_category` (`product_id`, `category_id`) VALUES
(2, 1),
(3, 3),
(3, 6),
(4, 3),
(4, 6),
(5, 5),
(6, 5),
(7, 5),
(8, 5),
(9, 5),
(10, 5),
(11, 5),
(12, 5),
(13, 5),
(14, 2),
(15, 5),
(16, 5),
(10, 2),
(NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `role` varchar(45) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` tinytext NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `role`, `email`, `password`, `name`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$zJA0iOx3WE80Mi1JdvYLnenO2gdApo06qm1srZCOiY.DuqvvU54X.', 'admin'),
(11, 'operator', 'operator@gmail.com', '$2y$10$mXS46BRBFtYR7wsGbG7.KuOaHk4elOWuqpbzSgK7jSq/v9m3D3gw2', 'operator'),
(12, 'user', 'user@gmail.com', '$2y$10$mcYHpkf3x.vi7vSHjLfrseTz6YS5M4.3PxSSWhwd3fWtpavUnhrj.', 'user');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_id_uindex` (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_id_uindex` (`id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_id_uindex` (`id`);

--
-- Индексы таблицы `product_category`
--
ALTER TABLE `product_category`
  ADD KEY `category_id___fk` (`category_id`),
  ADD KEY `product_id___fk` (`product_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_login_uindex` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2572;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `product_category`
--
ALTER TABLE `product_category`
  ADD CONSTRAINT `category_id___fk` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `product_id___fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

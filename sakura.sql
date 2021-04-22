-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Апр 17 2021 г., 08:25
-- Версия сервера: 8.0.21-0ubuntu0.20.04.4
-- Версия PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `sakura`
--

-- --------------------------------------------------------

--
-- Структура таблицы `article`
--

CREATE TABLE `article` (
  `id` int NOT NULL,
  `type` smallint DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `text` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `article`
--

INSERT INTO `article` (`id`, `type`, `title`, `text`, `created_at`, `updated_at`) VALUES
(1, 2, 'Asus claims the ZenBook 13 UX331UN is currently the world\'s thinnest laptop with discrete graphics.', '<p>Asus claims the ZenBook 13 UX331UN is currently the world\'s thinnest laptop with discrete graphics.\n\nIf you\'re not sure why you should care about that, it\'s because it shows we\'ve finally reached a point where you can get an ultraportable laptop with long battery life without sacrificing graphics performance or spending a ton of money. \n\nWIth laptops that are half an inch (12.7 mm) thick like the ZenBook 13 ($979.05 at Amazon.com), you\'d typically get integrated graphics that are more power efficient, run cooler and cost less than a standalone discrete graphics chip. The downsides are integrated graphics also eat into your system memory and just can\'t handle more demanding graphics tasks or gaming. Though the Nvidia GeForce MX150 chip used here is entry level, it has 2GB of its own memory, and Nvidia says it can deliver up to four times faster performance over integrated graphics for photo and video editing as well as deliver better gaming performance.</p>\n', '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(2, 2, 'MacBook Pro 2018 release date, price, features, specs', 'The MacBook Pro lineup was updated on 7 June 2017 at WWDC 2017. At the time, Apple\'s Pro laptops gained faster Kaby Lake processors, but not everyone was happy with the update. Read on to find out people were disappointed, and how Apple could be addressing the complaints with new features in the 2018 update to the MacBook Pro range.\n\nOne thing we know for sure is that Apple is aware of the complaints: In November 2017 Apple\'s head of design Jony Ive admitted to being aware of the disappointment and criticism regarding the MacBook models.', '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(3, 1, 'New iPhone 2018 release date, price & specs rumours', 'Apple\'s iPhone update in the autumn of 2018 could see three or even four new iPhones launched at the same time, and fans can\'t wait to see what\'s in store.\n\nIn this article we look at all the rumours concerning the successor to the iPhone X, and the expected larger iPhone X Plus: their release date, prices (which may be lower than expected, if Apple releases the rumoured iPhone X Lite), design changes, tech specs and new features. We\'ve also got the latest leaked photos, including what is believed to be a prototype iPhone X Plus display.\n\nWe also think Apple is likely to update the iPhone SE in the spring of 2018, and we have a separate article addressing those rumours here: iPhone SE 2 news. And for advice related to the current lineup, you may prefer to read our iPhone buying guide and roundup of the best iPhone deals.', '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(4, 2, 'Asus’ new ZenBook 13 is the world’s thinnest laptop with a dedicated GPU', 'Asus has unleashed a new spin on its ultraportable ZenBook 13, which the company is claiming is the world’s thinnest notebook with a discrete graphics card (in other words, a more powerful separate GPU as opposed to integrated graphics).\n    \n    The Asus ZenBook 13 UX331 was revealed at CES back at the start of the year, weighing just 985g, and this new model adds in a discrete GeForce MX150 for extra pixel-pushing power.\n    \n    Naturally enough, this means it’s slightly heftier, but still very trim at just 1.12kg, with a thickness of 14mm, meaning that it still easily qualifies as an Ultrabook.', '2021-04-17 02:45:58', '2021-04-17 02:45:58');

-- --------------------------------------------------------

--
-- Структура таблицы `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('30', '1', 1597499924);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` int NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('1', 1, 'Guest', NULL, NULL, 1597499924, 1597499924),
('10', 1, 'Buyer', NULL, NULL, 1597499924, 1597499924),
('20', 1, 'Seller', NULL, NULL, 1597499924, 1597499924),
('30', 1, 'Administrator', NULL, NULL, 1597499924, 1597499924),
('copyProduct', 2, NULL, 'productRule', NULL, 1597499924, 1597499924),
('createArticle', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('createCategory', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('createCity', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('createComment', 2, NULL, 'commentRule', NULL, 1597499925, 1597499925),
('createCountry', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('createFavorite', 2, NULL, 'favoriteRule', NULL, 1597499925, 1597499925),
('createLike', 2, NULL, 'likeRule', NULL, 1597499925, 1597499925),
('createOrder', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('createPage', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('createProduct', 2, NULL, NULL, NULL, 1597499924, 1597499924),
('createRegion', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('createShop', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('createTag', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('createUser', 2, NULL, NULL, NULL, 1597499924, 1597499924),
('deleteArticle', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('deleteCategory', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('deleteCity', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('deleteComment', 2, NULL, 'commentRule', NULL, 1597499925, 1597499925),
('deleteCountry', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('deleteFavorite', 2, NULL, 'favoriteRule', NULL, 1597499925, 1597499925),
('deleteLike', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('deleteOrder', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('deletePage', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('deleteProduct', 2, NULL, 'productRule', NULL, 1597499924, 1597499924),
('deleteRegion', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('deleteShop', 2, NULL, 'shopRule', NULL, 1597499925, 1597499925),
('deleteTag', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('deleteUser', 2, NULL, 'userRule', NULL, 1597499924, 1597499924),
('exportInstagram', 2, NULL, 'productRule', NULL, 1597499924, 1597499924),
('indexArticle', 2, 'The list of categories to manage', NULL, NULL, 1597499925, 1597499925),
('indexCategory', 2, 'The list of categories to manage', NULL, NULL, 1597499925, 1597499925),
('indexCity', 2, 'The list of city to manage', NULL, NULL, 1597499925, 1597499925),
('indexComment', 2, 'The list of categories to manage', NULL, NULL, 1597499925, 1597499925),
('indexCountry', 2, 'The list of countries to manage', NULL, NULL, 1597499925, 1597499925),
('indexLike', 2, 'The list of Likes to manage', NULL, NULL, 1597499925, 1597499925),
('indexOrder', 2, 'The list of orders to manage', NULL, NULL, 1597499925, 1597499925),
('indexPage', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('indexProduct', 2, 'The list of products to manage', NULL, NULL, 1597499924, 1597499924),
('indexRegion', 2, 'The list of regions to manage', NULL, NULL, 1597499925, 1597499925),
('indexShop', 2, 'The list of Shops to manage', NULL, NULL, 1597499925, 1597499925),
('indexTag', 2, 'The list of categories to manage', NULL, NULL, 1597499925, 1597499925),
('indexUser', 2, 'The list of users to manage', NULL, NULL, 1597499924, 1597499924),
('listArticle', 2, 'The list of categories to view', NULL, NULL, 1597499925, 1597499925),
('listCategory', 2, 'The list of categories to view', NULL, NULL, 1597499925, 1597499925),
('listComment', 2, 'The list of categories to view', NULL, NULL, 1597499925, 1597499925),
('listOrder', 2, 'The list of orders to view', NULL, NULL, 1597499925, 1597499925),
('listProduct', 2, 'The list of products to view', NULL, NULL, 1597499924, 1597499924),
('listShop', 2, 'The list of Shops', NULL, NULL, 1597499925, 1597499925),
('listUser', 2, 'The list of users', NULL, NULL, 1597499924, 1597499924),
('removeInstagram', 2, NULL, 'productRule', NULL, 1597499925, 1597499925),
('updateArticle', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('updateCategory', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('updateCity', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('updateComment', 2, NULL, 'commentRule', NULL, 1597499925, 1597499925),
('updateCountry', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('updateDataInstagram', 2, NULL, 'productRule', NULL, 1597499925, 1597499925),
('updateInstagram', 2, NULL, 'productRule', NULL, 1597499924, 1597499924),
('updateLike', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('updateOrder', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('updatePage', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('updateProduct', 2, NULL, 'productRule', NULL, 1597499924, 1597499924),
('updateRegion', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('updateShop', 2, NULL, 'shopRule', NULL, 1597499925, 1597499925),
('updateTag', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('updateUser', 2, NULL, 'userRule', NULL, 1597499924, 1597499924),
('viewArticle', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('viewCategory', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('viewCity', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('viewComment', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('viewCountry', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('viewLike', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('viewOrder', 2, NULL, 'orderRule', NULL, 1597499925, 1597499925),
('viewPage', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('viewProduct', 2, NULL, NULL, NULL, 1597499924, 1597499924),
('viewRegion', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('viewShop', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('viewTag', 2, NULL, NULL, NULL, 1597499925, 1597499925),
('viewUser', 2, NULL, 'userRule', NULL, 1597499924, 1597499924);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('10', '1'),
('20', '10'),
('30', '20'),
('10', 'copyProduct'),
('30', 'createArticle'),
('30', 'createCategory'),
('30', 'createCity'),
('1', 'createComment'),
('30', 'createCountry'),
('1', 'createFavorite'),
('1', 'createLike'),
('10', 'createLike'),
('1', 'createOrder'),
('30', 'createPage'),
('10', 'createProduct'),
('30', 'createRegion'),
('10', 'createShop'),
('30', 'createTag'),
('10', 'createUser'),
('30', 'deleteArticle'),
('30', 'deleteCategory'),
('30', 'deleteCity'),
('1', 'deleteComment'),
('30', 'deleteCountry'),
('1', 'deleteFavorite'),
('1', 'deleteLike'),
('10', 'deleteLike'),
('20', 'deleteOrder'),
('30', 'deletePage'),
('10', 'deleteProduct'),
('30', 'deleteRegion'),
('10', 'deleteShop'),
('30', 'deleteTag'),
('10', 'deleteUser'),
('10', 'exportInstagram'),
('30', 'indexArticle'),
('30', 'indexCategory'),
('30', 'indexCity'),
('30', 'indexComment'),
('30', 'indexCountry'),
('30', 'indexLike'),
('20', 'indexOrder'),
('30', 'indexPage'),
('20', 'indexProduct'),
('30', 'indexRegion'),
('10', 'indexShop'),
('30', 'indexTag'),
('20', 'indexUser'),
('1', 'listArticle'),
('10', 'listCategory'),
('1', 'listComment'),
('1', 'listOrder'),
('1', 'listProduct'),
('1', 'listShop'),
('1', 'listUser'),
('10', 'removeInstagram'),
('30', 'updateArticle'),
('30', 'updateCategory'),
('30', 'updateCity'),
('1', 'updateComment'),
('30', 'updateCountry'),
('10', 'updateDataInstagram'),
('10', 'updateInstagram'),
('20', 'updateOrder'),
('30', 'updatePage'),
('10', 'updateProduct'),
('30', 'updateRegion'),
('10', 'updateShop'),
('30', 'updateTag'),
('10', 'updateUser'),
('1', 'viewArticle'),
('10', 'viewCategory'),
('30', 'viewCity'),
('1', 'viewComment'),
('30', 'viewCountry'),
('1', 'viewOrder'),
('1', 'viewPage'),
('1', 'viewProduct'),
('30', 'viewRegion'),
('1', 'viewShop'),
('30', 'viewTag'),
('1', 'viewUser');

-- --------------------------------------------------------

--
-- Структура таблицы `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_rule`
--

INSERT INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
('commentRule', 'O:18:\"comment\\rules\\Rule\":3:{s:4:\"name\";s:11:\"commentRule\";s:9:\"createdAt\";i:1597499925;s:9:\"updatedAt\";i:1597499925;}', 1597499925, 1597499925),
('favoriteRule', 'O:19:\"favorite\\rules\\Rule\":3:{s:4:\"name\";s:12:\"favoriteRule\";s:9:\"createdAt\";i:1597499925;s:9:\"updatedAt\";i:1597499925;}', 1597499925, 1597499925),
('likeRule', 'O:15:\"like\\rules\\Rule\":3:{s:4:\"name\";s:8:\"likeRule\";s:9:\"createdAt\";i:1597499925;s:9:\"updatedAt\";i:1597499925;}', 1597499925, 1597499925),
('orderRule', 'O:16:\"order\\rules\\Rule\":3:{s:4:\"name\";s:9:\"orderRule\";s:9:\"createdAt\";i:1597499925;s:9:\"updatedAt\";i:1597499925;}', 1597499925, 1597499925),
('productRule', 'O:18:\"product\\rules\\Rule\":3:{s:4:\"name\";s:11:\"productRule\";s:9:\"createdAt\";i:1597499924;s:9:\"updatedAt\";i:1597499924;}', 1597499924, 1597499924),
('shopRule', 'O:15:\"shop\\rules\\Rule\":3:{s:4:\"name\";s:8:\"shopRule\";s:9:\"createdAt\";i:1597499925;s:9:\"updatedAt\";i:1597499925;}', 1597499925, 1597499925),
('userRule', 'O:19:\"user\\rules\\UserRule\":3:{s:4:\"name\";s:8:\"userRule\";s:9:\"createdAt\";i:1597499924;s:9:\"updatedAt\";i:1597499924;}', 1597499924, 1597499924);

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `tree` int DEFAULT NULL,
  `lft` int NOT NULL,
  `rgt` int NOT NULL,
  `depth` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `title_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `text` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `tree_position` float NOT NULL,
  `product_count` int NOT NULL,
  `enabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `tree`, `lft`, `rgt`, `depth`, `title`, `title_url`, `text`, `data`, `tree_position`, `product_count`, `enabled`) VALUES
(1, 1, 1, 24, 0, 'Electronics', 'electronics', '', NULL, 1, 6, 1),
(2, 1, 2, 11, 1, 'Computers', 'electronics/computers', '', NULL, 1, 4, 1),
(3, 1, 12, 23, 1, 'Phones', 'electronics/phones', '', NULL, 1, 1, 1),
(4, 1, 3, 4, 2, 'Notebooks', 'electronics/computers/notebooks', '', NULL, 1, 2, 1),
(5, 1, 5, 6, 2, 'Desktop computers', 'electronics/computers/desktop-computers', '', NULL, 1, 0, 1),
(6, 1, 7, 8, 2, 'Tablets', 'electronics/computers/tablets', '', NULL, 1, 0, 1),
(7, 1, 13, 14, 2, 'Smartphones', 'electronics/phones/smartphones', '', NULL, 1, 1, 1),
(8, 1, 15, 16, 2, 'Mobile phones', 'elektronika/phones/mobile-phones', '', NULL, 1, 0, 1),
(9, 1, 17, 22, 2, 'Accessories for smartphones', 'electronics/phones/accessories-for-smartphones', '', NULL, 1, 0, 1),
(10, 1, 18, 19, 3, 'Mobile phone case', 'electronics/phones/accessories-for-smartphones/mobile-phone-case', '', NULL, 1, 0, 1),
(11, 1, 20, 21, 3, 'Chargers', 'electronics/phones/accessories-for-smartphones/chargers', '', NULL, 1, 0, 1),
(12, 12, 1, 6, 0, 'Foodstuffs', 'foodstuffs', '', NULL, 2, 2, 1),
(13, 12, 2, 3, 1, 'Soda drinks', 'foodstuffs/soda-drinks', '', NULL, 2, 2, 1),
(14, 12, 4, 5, 1, 'Juice', 'foodstuffs/juice', '', NULL, 2, 0, 1),
(15, 15, 1, 2, 0, 'Women\'s underwear', 'womens-underwear', '', NULL, 3, 4, 1),
(16, 16, 1, 6, 0, 'Glasses', 'glasses', '', NULL, 4, 3, 1),
(17, 16, 2, 3, 1, 'Glasses for sight', 'glasses/glasses-for-sight', '', NULL, 4, 2, 1),
(18, 16, 4, 5, 1, 'Sunglasses', 'glasses/sunglasses', '', NULL, 4, 1, 1),
(19, 1, 9, 10, 2, 'Accessories for computers', 'electronics/computers/accessories-for-computers', '', NULL, 1, 2, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `comment`
--

CREATE TABLE `comment` (
  `id` int NOT NULL,
  `model_id` int NOT NULL,
  `model_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int DEFAULT NULL,
  `ip` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `text` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `enabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `comment`
--

INSERT INTO `comment` (`id`, `model_id`, `model_name`, `user_id`, `ip`, `name`, `text`, `created_at`, `updated_at`, `enabled`) VALUES
(1, 1, 'product\\models\\Product', NULL, '127.0.0.1', 'Adam Smith', 'One of the best laptop values around, Asus\' 13-inch ZenBook UX330UA provides premium specs -- such as a lightweight aluminum chassis, a vibrant 1080p screen and a 256GB solid-state drive -- for well under $800. A successor to last year\'s identically named model, the late-2017 version of the UX330UA upgrades the processor to a zippy Intel 8th-Gen Core i5 CPU while keeping everything else the same. Unfortunately, the added performance means 1.5 hours less battery life. But with its colorful screen, sweet audio and 2.7-pound chassis, the ZenBook UX330UA is still a great choice for anyone who needs a lightweight Ultrabook at an affordable price.', '2021-04-17 02:45:58', '2021-04-17 02:45:58', 1),
(2, 1, 'product\\models\\Product', NULL, '127.0.0.2', 'Danma Musa Williams', 'A student of Liberia. I have been suffering too long now with laptops I buy but don\'t last. poor battery life, crashing of hard drive and screen, poor wifi connection have been among the problems. I will appreciate your advice on my purchase of a laptop preventing these previous experiences.', '2021-04-17 02:45:58', '2021-04-17 02:45:58', 1),
(3, 1, 'product\\models\\Product', NULL, '127.0.0.3', 'Johny', 'Thanks for the review. What I miss from most laptop/ultrabook reviews, including this one, is a test with external monitors (2560x1440 and up). I want to replace my desktop workstation with an ultrabook but the Ultrabook must support my 2560x1440 external monitor but surprisingly few does! (HDMI single link bandwidth is not enough for 2560x1440@60Hz).', '2021-04-17 02:45:58', '2021-04-17 02:45:58', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `coupon`
--

CREATE TABLE `coupon` (
  `id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `discount` int NOT NULL,
  `interval_from` date NOT NULL,
  `interval_to` date NOT NULL,
  `used` tinyint(1) NOT NULL,
  `reusable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `coupon`
--

INSERT INTO `coupon` (`id`, `title`, `code`, `discount`, `interval_from`, `interval_to`, `used`, `reusable`) VALUES
(1, 'Акция на новый год', '111-xxx', 20, '2016-12-01', '2017-01-07', 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `cron_email_message`
--

CREATE TABLE `cron_email_message` (
  `id` int NOT NULL,
  `created_date` datetime NOT NULL,
  `recipient_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `recipient_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sender_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sender_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `body` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `sent_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `cron_email_message`
--

INSERT INTO `cron_email_message` (`id`, `created_date`, `recipient_email`, `recipient_name`, `sender_email`, `sender_name`, `subject`, `body`, `status`, `sent_date`) VALUES
(2, '2016-08-27 17:47:28', 'admin@mail.ru', 'Nurbek Nurjanov', 'support@example.com', 'E-commerce', 'qwe', 'asdasd', 1, '2016-08-27 18:06:27'),
(3, '2016-08-27 17:47:28', 'test@mail.ru', 'Test Testov', 'support@example.com', 'E-commerce', 'qwe', 'asdasd', 1, '2016-08-27 18:06:28'),
(4, '2016-08-27 18:23:50', 'admin@mail.ru', 'Nurbek Nurjanov', 'support@example.com', 'E-commerce', 'asdasd', 'asdasd', 1, '2016-08-27 18:24:26'),
(5, '2016-08-27 18:23:50', 'test@mail.ru', 'Test Testov', 'support@example.com', 'E-commerce', 'asdasd', 'asdasd', 1, '2016-08-27 18:24:26');

-- --------------------------------------------------------

--
-- Структура таблицы `dynamic_field`
--

CREATE TABLE `dynamic_field` (
  `id` int NOT NULL,
  `label` varchar(200) NOT NULL,
  `key` varchar(100) NOT NULL,
  `type` smallint NOT NULL,
  `json_values` text NOT NULL,
  `rule` text,
  `default_value` text,
  `enabled` tinyint(1) NOT NULL,
  `category_id` int DEFAULT NULL,
  `position` float NOT NULL,
  `section` smallint DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `with_label` tinyint(1) NOT NULL,
  `clickable` tinyint(1) NOT NULL,
  `data` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `dynamic_field`
--

INSERT INTO `dynamic_field` (`id`, `label`, `key`, `type`, `json_values`, `rule`, `default_value`, `enabled`, `category_id`, `position`, `section`, `unit`, `with_label`, `clickable`, `data`) VALUES
(1, 'Brand', 'brand', 3, '{\n\"asus\":\"Asus\",\n\"apple\":\"Apple\",\n\"samsung\":\"Samsung\"\n}', '', '', 1, 1, 1, 1, '', 0, 1, NULL),
(2, 'Processor', 'processor', 3, '{\n\"i3\":\"i3\",\n\"i5\":\"i5\",\n\"i7\":\"i7\"\n}', '', '', 1, 2, 2, 1, '', 1, 1, NULL),
(3, 'OS', 'os', 5, '{\n    \"android\":\"Android\",\n    \"iphone os\":\"iPhone OS\"\n}', '', '', 1, 3, 3, 1, '', 0, 1, NULL),
(4, 'Size', 'size', 6, '{\n\"xs\":\"xs\",\n\"s\":\"s\",\n\"m\":\"m\",\n\"l\":\"l\",\n\"xl\":\"xl\",\n\"xxl\":\"xxl\",\n\"xxxl\":\"xxxl\"\n}', '', '', 1, 15, 4, 1, '', 1, 0, NULL),
(5, 'Battery charge time', 'battery_charge_time', 1, '', 'number', '', 1, 4, 5, 1, 'hours', 1, 0, '{\n        \"slider\":\"1\",\n        \"input_fields\":\"1\",\n        \"min\":\"1\",\n        \"max\":\"12\"\n        }');

-- --------------------------------------------------------

--
-- Структура таблицы `dynamic_value`
--

CREATE TABLE `dynamic_value` (
  `id` int NOT NULL,
  `object_id` int NOT NULL,
  `field_id` int NOT NULL,
  `value` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `dynamic_value`
--

INSERT INTO `dynamic_value` (`id`, `object_id`, `field_id`, `value`) VALUES
(1, 1, 1, 'asus'),
(2, 1, 2, 'i7'),
(3, 2, 1, 'apple'),
(4, 2, 2, 'i3'),
(5, 3, 1, 'samsung'),
(6, 3, 3, 'android'),
(7, 4, 1, 'samsung'),
(8, 10, 4, 'xs,s,m,l,xl,xxl,xxxl'),
(9, 11, 4, 'xs,s,m,xxl,xxxl'),
(10, 12, 4, 'xs,s,m,l,xl'),
(11, 13, 4, 'xs,s,m'),
(12, 1, 5, '6'),
(13, 2, 5, '6');

-- --------------------------------------------------------

--
-- Структура таблицы `file`
--

CREATE TABLE `file` (
  `id` int NOT NULL,
  `model_id` int NOT NULL,
  `model_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `file`
--

INSERT INTO `file` (`id`, `model_id`, `model_name`, `file_name`, `title`, `type`, `created_at`, `updated_at`) VALUES
(1, 2, 'article\\models\\Article', 'pgERwf8tqwc', 'Mac book video', 50, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(2, 4, 'article\\models\\Article', '45fbc6d3e05ebd93369ce542e8f2322d.jpg', 'asus zenbook ux303u nw g05', 11, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(3, 4, 'article\\models\\Article', '6cfe0e6127fa25df2a0ef2ae1067d915.jpg', 'zenbook-ux31-profile', 12, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(4, 4, 'article\\models\\Article', '85fc37b18c57097425b52fc7afbb6969.jpg', 'asus zenbook ux303u', 12, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(5, 4, 'article\\models\\Article', '5737034557ef5b8c02c0e46513b98f90.jpg', 'zenbook-ux31', 12, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(6, 1, 'user\\models\\User', 'dd8eb9f23fbd362da0e3f4e70b878c16.jpg', 'large.jpg', 10, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(7, 1, 'page\\models\\Page', '1ce927f875864094e3906a4a0b5ece68.jpg', 'Internet-magazin2.jpg', 11, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(8, 2, 'category\\models\\Category', '218a0aefd1d1a4be65601cc6ddc1520e.png', 'f57a2f557b098c43f11ab969efe1504b.png', 10, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(9, 3, 'category\\models\\Category', '555d6702c950ecb729a966504af0a635.png', 'e8c0653fea13f91bf3c48159f7c24f78.png', 10, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(10, 13, 'category\\models\\Category', 'eeb69a3cb92300456b6a5f4162093851.png', 'a67f096809415ca1c9f112d96d27689b.png', 10, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(11, 14, 'category\\models\\Category', '8c6744c9d42ec2cb9e8885b54ff744d0.png', 'ccc0aa1b81bf81e16c676ddb977c5881.png', 10, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(12, 1, 'comment\\models\\Comment', 'c4015b7f368e6b4871809f49debe0579.jpg', '443cb001c138b2561a0d90720d6ce111.jpg', 11, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(13, 1, 'comment\\models\\Comment', 'e56954b4f6347e897f954495eab16a88.jpg', 'a8abb4bb284b5b27aa7cb790dc20f80b.jpg', 12, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(14, 1, 'comment\\models\\Comment', 'TTTGiUi9Jfw', '', 50, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(15, 1, 'product\\models\\Product', '846c260d715e5b854ffad5f70a516c88.jpg', 'asus-zenbook-3-ux390ua-01.jpg', 12, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(16, 1, 'product\\models\\Product', '4a47d2983c8bd392b120b627e0e1cab4.jpg', 'asus-zenbook-nx500.jpg', 11, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(17, 1, 'product\\models\\Product', 'bf8229696f7a3bb4700cfddef19fa23f.jpg', 'Zenbook+3+handson+gallery+1+2.jpg', 12, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(18, 1, 'product\\models\\Product', '08c5433a60135c32e34f46a71175850c.jpg', 'c4015b7f368e6b4871809f49debe0579.jpg', 12, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(19, 2, 'product\\models\\Product', 'a8baa56554f96369ab93e4f3bb068c22.jpg', 'MACBOOKPRO.jpg', 11, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(20, 3, 'product\\models\\Product', '9c838d2e45b2ad1094d42f4ef36764f6.jpg', '75fc093c0ee742f6dddaa13fff98f104.jpg', 11, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(21, 5, 'product\\models\\Product', 'd96409bf894217686ba124d7356686c9.jpg', 'safe_image.jpg', 11, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(22, 6, 'product\\models\\Product', 'f770b62bc8f42a0b66751fe636fc6eb0.jpg', 'p8482c.jpg', 11, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(23, 7, 'product\\models\\Product', '1fc214004c9481e4c8073e85323bfd4b.jpg', 'p8225a.jpg', 11, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(24, 8, 'product\\models\\Product', '1141938ba2c2b13f5505d7c424ebae5f.jpg', 'Fanta_1500ml.jpg', 11, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(25, 9, 'product\\models\\Product', 'f9b902fc3289af4dd08de5d1de54f68f.jpg', 'copy-Fanta_1500ml.jpg', 11, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(26, 10, 'product\\models\\Product', '1700002963a49da13542e0726b7bb758.jpg', '95eed8_38d15dc82acc42ea92bd621141c91199_mv2_d_1500_2000_s_2.jpg', 11, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(27, 10, 'product\\models\\Product', 'a597e50502f5ff68e3e25b9114205d4a.jpg', '95eed8_c05104474cd843f799a3fb1b990af1e5_mv2_d_1500_2000_s_2.jpg', 12, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(28, 11, 'product\\models\\Product', 'd7a728a67d909e714c0774e22cb806f2.jpg', 'Agent-Provocateur-Korset-Stevie.jpg', 11, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(29, 12, 'product\\models\\Product', '1fc214004c9481e4c8073e85323bfd4b.jpg', '99.970.jpg', 11, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(30, 13, 'product\\models\\Product', '8e6b42f1644ecb1327dc03ab345e618b.jpg', 'card_003780_7pml.jpg', 11, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(31, 15, 'product\\models\\Product', '7f100b7b36092fb9b06dfb4fac360931.jpeg', 'images.jpeg', 11, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(32, 16, 'product\\models\\Product', 'df877f3865752637daa540ea9cbc474f.jpg', 'copy_hp_k0b38aa_585a5de83acf9_images_1810131309.jpg', 11, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(33, 2, 'shop\\models\\Shop', '3a066bda8c96b9478bb0512f0a43028c.jpg', 'mango', 11, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(34, 4, 'shop\\models\\Shop', '3621f1454cacf995530ea53652ddf8fb.png', 'mcdonald', 11, '2021-04-17 02:45:58', '2021-04-17 02:45:58');

-- --------------------------------------------------------

--
-- Структура таблицы `i18n_message`
--

CREATE TABLE `i18n_message` (
  `id` int NOT NULL,
  `language` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `translation` text CHARACTER SET utf8 COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `i18n_message`
--

INSERT INTO `i18n_message` (`id`, `language`, `translation`) VALUES
(1, 'ru', 'Тема сообщения'),
(2, 'en-US', 'Terms and Conditions are a set of rules and guidelines that a user must agree to in order to use your website or mobile app. It acts as a legal contract between you (the company) who has the website or mobile app and the user who access your website and mobile app.\n\nIt’s up to you to set the rules and guidelines that the user must agree to. You can think of your Terms and Conditions agreement as the legal agreement where you maintain your rights to exclude users from your app in the event that they abuse your app, and where you maintain your legal rights against potential app abusers, and so on.\n\nTerms and Conditions are also known as Terms of Service or Terms of Use.\n\nThis type of legal agreement can be used for both your website and your mobile app. It’s not required (it’s not recommended actually) to have separate Terms and Conditions agreements: one for your website and one for your mobile app.\n\n'),
(2, 'ru', 'Настоящее Соглашение определяет условия использования Пользователями материалов и сервисов сайта www.        (далее — «Сайт»).\r\n1.Общие условия\r\n1.1. Использование материалов и сервисов Сайта регулируется нормами действующего законодательства Российской Федерации.\r\n1.2. Настоящее Соглашение является публичной офертой. Получая доступ к материалам Сайта Пользователь считается присоединившимся к настоящему Соглашению.\r\n1.3. Администрация Сайта вправе в любое время в одностороннем порядке изменять условия настоящего Соглашения. Такие изменения вступают в силу по истечении 3 (Трех) дней с момента размещения новой версии Соглашения на сайте. При несогласии Пользователя с внесенными изменениями он обязан отказаться от доступа к Сайту, прекратить использование материалов и сервисов Сайта.\r\n2. Обязательства Пользователя\r\n2.1. Пользователь соглашается не предпринимать действий, которые могут рассматриваться как нарушающие российское законодательство или нормы международного права, в том числе в сфере интеллектуальной собственности, авторских и/или смежных правах, а также любых действий, которые приводят или могут привести к нарушению нормальной работы Сайта и сервисов Сайта.\r\n2.2. Использование материалов Сайта без согласия правообладателей не допускается (статья 1270 Г.К РФ). Для правомерного использования материалов Сайта необходимо заключение лицензионных договоров (получение лицензий) от Правообладателей.\r\n2.3. При цитировании материалов Сайта, включая охраняемые авторские произведения, ссылка на Сайт обязательна (подпункт 1 пункта 1 статьи 1274 Г.К РФ).\r\n2.4. Комментарии и иные записи Пользователя на Сайте не должны вступать в противоречие с требованиями законодательства Российской Федерации и общепринятых норм морали и нравственности.\r\n2.5. Пользователь предупрежден о том, что Администрация Сайта не несет ответственности за посещение и использование им внешних ресурсов, ссылки на которые могут содержаться на сайте.\r\n2.6. Пользователь согласен с тем, что Администрация Сайта не несет ответственности и не имеет прямых или косвенных обязательств перед Пользователем в связи с любыми возможными или возникшими потерями или убытками, связанными с любым содержанием Сайта, регистрацией авторских прав и сведениями о такой регистрации, товарами или услугами, доступными на или полученными через внешние сайты или ресурсы либо иные контакты Пользователя, в которые он вступил, используя размещенную на Сайте информацию или ссылки на внешние ресурсы.\r\n2.7. Пользователь принимает положение о том, что все материалы и сервисы Сайта или любая их часть могут сопровождаться рекламой. Пользователь согласен с тем, что Администрация Сайта не несет какой-либо ответственности и не имеет каких-либо обязательств в связи с такой рекламой.'),
(3, 'ru', 'Все категории'),
(4, 'ru', 'Назад ко всем категориям'),
(5, 'ru', 'Электроника'),
(6, 'ru', 'Компьютеры'),
(7, 'ru', 'Телефоны'),
(8, 'ru', 'Ноутбуки'),
(9, 'ru', 'Стационарные компьютеры'),
(10, 'ru', 'Планшеты'),
(11, 'ru', 'Аксессуары для компьютеров'),
(12, 'ru', 'Смартфоны'),
(13, 'ru', 'Мобильные телефоны'),
(14, 'ru', 'Аксессуары для смартфонов'),
(15, 'ru', 'Чехлы для телефонов'),
(16, 'ru', 'Зарядные устройства'),
(17, 'ru', 'Продовольственные товары'),
(18, 'ru', 'Газированные напитки'),
(19, 'ru', 'Соки'),
(20, 'ru', 'Женское нижнее белье'),
(21, 'ru', 'Очки, оптика'),
(22, 'ru', 'Очки для зрения'),
(23, 'ru', 'Солнцезащитные очки'),
(24, 'ru', 'Назад к электроникам'),
(25, 'ru', 'Назад к компьютерам'),
(26, 'ru', 'Назад к телефонам'),
(27, 'ru', 'Назад к аксессуарам для смартфонов'),
(28, 'ru', 'Назад к продовольственным товарам'),
(29, 'ru', 'Назад к очкам, оптике'),
(30, 'ru', 'Все в электрониках'),
(31, 'ru', 'Все в компьютерах'),
(32, 'ru', 'Все в телефонах'),
(33, 'ru', 'Все в аксессуарах для смартфонов'),
(34, 'ru', 'Все в продовольственных товарах'),
(35, 'ru', 'Все в очках, оптике');

-- --------------------------------------------------------

--
-- Структура таблицы `i18n_source_message`
--

CREATE TABLE `i18n_source_message` (
  `id` int NOT NULL,
  `category` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` text CHARACTER SET utf8 COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `i18n_source_message`
--

INSERT INTO `i18n_source_message` (`id`, `category`, `message`) VALUES
(1, 'db_frontend', 'Subject'),
(2, 'db_frontend', 'Agreement_text'),
(3, 'db_category', 'All categories'),
(4, 'db_category', 'Back to all categories'),
(5, 'db_category', 'Electronics'),
(6, 'db_category', 'Computers'),
(7, 'db_category', 'Phones'),
(8, 'db_category', 'Notebooks'),
(9, 'db_category', 'Desktop computers'),
(10, 'db_category', 'Tablets'),
(11, 'db_category', 'Accessories for computers'),
(12, 'db_category', 'Smartphones'),
(13, 'db_category', 'Mobile phones'),
(14, 'db_category', 'Accessories for smartphones'),
(15, 'db_category', 'Mobile phone case'),
(16, 'db_category', 'Chargers'),
(17, 'db_category', 'Foodstuffs'),
(18, 'db_category', 'Soda drinks'),
(19, 'db_category', 'Juice'),
(20, 'db_category', 'Women\'s underwear'),
(21, 'db_category', 'Glasses'),
(22, 'db_category', 'Glasses for sight'),
(23, 'db_category', 'Sunglasses'),
(24, 'db_category', 'Back to electronics'),
(25, 'db_category', 'Back to computers'),
(26, 'db_category', 'Back to phones'),
(27, 'db_category', 'Back to accessories for smartphones'),
(28, 'db_category', 'Back to foodstuffs'),
(29, 'db_category', 'Back to glasses'),
(30, 'db_category', 'All in electronics'),
(31, 'db_category', 'All in computers'),
(32, 'db_category', 'All in phones'),
(33, 'db_category', 'All in accessories for smartphones'),
(34, 'db_category', 'All in foodstuffs'),
(35, 'db_category', 'All in glasses');

-- --------------------------------------------------------

--
-- Структура таблицы `like`
--

CREATE TABLE `like` (
  `id` int NOT NULL,
  `model_id` int NOT NULL,
  `model_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int DEFAULT NULL,
  `ip` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mark` smallint NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `like`
--

INSERT INTO `like` (`id`, `model_id`, `model_name`, `user_id`, `ip`, `mark`, `created_at`, `updated_at`) VALUES
(1, 1, 'comment\\models\\Comment', NULL, '127.0.0.1', 1, '2021-04-17 02:45:58', '2021-04-17 02:45:58'),
(3, 2, 'comment\\models\\Comment', NULL, '127.0.0.2', -1, '2021-04-17 02:45:58', '2021-04-17 02:45:58');

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `apply_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m180309_095051_add_fields_into_comment_table', 1520589274),
('m180316_082441_add_index_into_file_table', 1521189101),
('m180316_082452_add_index_into_comment_table', 1521189106),
('m180316_082500_add_index_into_like_table', 1521189108),
('m180316_104731_add_index_into_object_tag_table', 1521197337),
('m180323_072739_alter_eav_table', 1521868376),
('m180324_071113_add_enabled_field_to_category', 1521876047),
('m180324_092123_add_data_field_into_eav_table', 1521883381),
('m180325_133634_alter_eav_table3', 1521985625),
('m180414_150438_alter_foreign_keys_in_buy_with_products_table', 1523965615),
('m180724_130148_city_empty_value_to_delete', 1536141574),
('m181107_084354_online_payment', 1541580953),
('m181208_135152_remove_title_ru_from_category_table', 1544277189),
('m181209_073009_add_instagram_product', 1544341048),
('m181220_063726_add_full_text', 1545630755),
('m181222_045704_product_network', 1545630755),
('m190406_101951_alter_eav_table', 1589009779),
('m200509_073800_create_shop_table', 1589019326),
('m200615_062323_remove_user_id_from_shop_table', 1597485232),
('m200615_065023_create_user_shop_table', 1597485232),
('m200621_055157_alter_user_module', 1597485232),
('m200621_162918_add_zip_code_field', 1597485232);

-- --------------------------------------------------------

--
-- Структура таблицы `object_tag`
--

CREATE TABLE `object_tag` (
  `id` int NOT NULL,
  `model_id` int NOT NULL,
  `model_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tag_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `object_tag`
--

INSERT INTO `object_tag` (`id`, `model_id`, `model_name`, `tag_id`) VALUES
(1, 1, 'article\\models\\Article', 1),
(2, 1, 'article\\models\\Article', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `order`
--

CREATE TABLE `order` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `ip` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_id` int NOT NULL,
  `region_id` int NOT NULL,
  `city_id` int DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `delivery_id` smallint NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `amount` float NOT NULL,
  `payment_type` smallint NOT NULL,
  `status` smallint NOT NULL,
  `coupon_id` int DEFAULT NULL,
  `online_payment_type` smallint DEFAULT NULL,
  `online_payment_status` smallint DEFAULT NULL,
  `zip_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `order`
--

INSERT INTO `order` (`id`, `user_id`, `ip`, `name`, `email`, `phone`, `country_id`, `region_id`, `city_id`, `address`, `description`, `delivery_id`, `created_at`, `updated_at`, `amount`, `payment_type`, `status`, `coupon_id`, `online_payment_type`, `online_payment_status`, `zip_code`) VALUES
(1, NULL, '127.0.0.1', 'Adam Smith', 'adam.smith@mail.ru', '+996558011477', 231, 3956, 48019, 'Lincoln street, building 7, apartment 8', '', 2, '2018-01-01 12:00:00', '2018-01-01 12:00:00', 1500, 1, 3, NULL, NULL, NULL, NULL),
(2, NULL, '127.0.0.1', 'Donald Trump', 'trump@mail.ru', '+996558011477', 231, 3956, 48019, 'Gorkiy street, building 143, apartment 45', '', 2, '2018-02-02 13:00:00', '2018-02-02 13:00:00', 250, 1, 3, NULL, NULL, NULL, NULL),
(3, NULL, '127.0.0.1', 'Jim Carry', 'carry@mail.ru', '+996558011477', 231, 3956, 48019, 'Mark Twain street, building 54, apartment 76', '', 2, '2018-03-03 14:00:00', '2018-03-03 14:00:00', 725, 1, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `order_product`
--

CREATE TABLE `order_product` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `price` float NOT NULL,
  `count` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `order_product`
--

INSERT INTO `order_product` (`id`, `order_id`, `product_id`, `price`, `count`) VALUES
(1, 1, 1, 700, 1),
(2, 1, 2, 1200, 1),
(3, 2, 3, 250, 1),
(4, 3, 1, 700, 1),
(5, 3, 15, 10, 1),
(6, 3, 16, 15, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `page`
--

CREATE TABLE `page` (
  `id` int NOT NULL,
  `title_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `text` text CHARACTER SET utf8 COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `page`
--

INSERT INTO `page` (`id`, `title_url`, `title`, `text`) VALUES
(1, 'about_us', 'About us', 'E-commerce is the activity of buying or selling online. Electronic commerce draws on technologies such as mobile commerce, electronic funds transfer, supply chain management, Internet marketing, online transaction processing, electronic data interchange (EDI), inventory management systems, and automated data collection systems.\n        Modern electronic commerce typically uses the World Wide Web for at least one part of the transaction\'s life cycle \n        although it may also use other technologies such as e-mail.\n         Typical e-commerce transactions include the purchase of online books (such as Amazon) and music purchases\n          (music download in the form of digital distribution such as iTunes Store), and to a less extent,\n           customized/personalized online liquor store inventory services.\n           \n        There are three areas of e-commerce: online retailing, electric markets, and online auctions. E-commerce is supported by electronic business.'),
(2, 'delivery', 'Payment and delivery', '<div class=\"about-us-wrap pay-delivery\">\n						<div class=\"about-us-block\">\n							<h4 class=\"about-us-title\">Payment methods</h4>\n							<p>We supply premium ceramic tile and porcelain stoneware by virtually all Italian and Spanish brands. Holding ourselves as an Online store with low operational expenses, we are proud of being able to offer unprecedentedly low prices for the majority of goods in our portfolio. Moreover, we have implemented user-friendly selection and ordering procedures, which is essential when it comes to ceramic tile and porcelain stoneware, challenging products for e-commerce. We keep improving the services on the ongoing basis.</p>\n						</div>\n						<div class=\"about-us-block\">\n							<h4 class=\"about-us-title\">Delivery</h4>\n							<p>Nowadays our website features one of the largest online Catalogues of ceramic tile and porcelain stoneware collections with high-quality interior photos (as it is advised by the manufacturers), as well as comprehensive parameters and technical data, e.g. prices, thickness, non-slip ratings, packing, installation and maintenance recommendations, etc.</p>\n						</div>\n					</div>'),
(3, 'guarantee', 'Guarantee', '<p>\nGuarantees and returns are crucial to your ecommerce business because it helps build trust and loyalty among your customers. With an easy to accomplish Return Policy and a Money Back Guarantee in place, you’re eliminating last-second hesitation and sense of risk that may abort the sale, while letting customers know that you got their back.\n\nImplementing a return policy and money back guarantee also shows that you’re confident in your products, which leads to consumer confidence in your brand. Companies who have adopted a no-questions-asked return policy have experienced tremendous growth in such a short amount of time. Zappos is the perfect example of a company that offers a no-frills return policy that puts the customer first, that’s why millions of people are loyal to them.\n</p>\n');

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE `product` (
  `id` int NOT NULL,
  `category_id` int DEFAULT NULL,
  `user_id` int NOT NULL,
  `sku` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `title_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` smallint NOT NULL,
  `price` float NOT NULL,
  `discount` int DEFAULT NULL,
  `group_id` int DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `rating_count` int NOT NULL,
  `enabled` tinyint NOT NULL,
  `shop_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `category_id`, `user_id`, `sku`, `title`, `title_url`, `description`, `created_at`, `updated_at`, `status`, `price`, `discount`, `group_id`, `type`, `rating`, `rating_count`, `enabled`, `shop_id`) VALUES
(1, 4, 1, '1001', 'Asus', 'electronics/computers/noutbooks/asus', '<p>Asus knows what it&#39;s doing. It knows that the MacBook Air laptops are old news,\n		 deliberately left to tread water to make way for the all-singing,\n		 (mostly) all-dancing 12in. Asus thinks there&#39;s life left for a 13in &#39;ultrabook&#39; still. The Asus ZenBook UX305 is pretty much everything the 13in should be at this point,\n		 but isn&#39;t. What do I mean? Well,\n		 it&#39;s pretty affordable at &pound;650 and has a really rather good screen,\n		 while still looking and feeling fantastic. Of course,\n		 as it runs Windows 8.1 rather than it&#39;s not going to convert many obsessives. But if you&#39;re on the cusp of being swayed,\n		 let the Asus ZenBook UX305 sway you.</p>\n', '2021-04-17 02:45:58', '2021-04-17 02:45:58', 1, 700, 30, NULL, '1,2,3', 5, 3, 1, 1),
(2, 4, 1, '1002', 'MacBook', 'electronics/computers/noutbooks/macbook', 'MacBook Air is nice computer', '2021-04-17 02:45:58', '2021-04-17 02:45:58', 1, 1200, 20, NULL, '1,2,3', 4, 0, 1, 1),
(3, 7, 1, '1003', 'Samsung J5', 'electronics/phones/smartphones/samsung-j5', '', '2021-04-17 02:45:58', '2021-04-17 02:45:58', 1, 250, NULL, NULL, '1,2,3', NULL, 0, 1, 1),
(4, 1, 1, '1004', 'TV', 'electronics/tv', '', '2021-04-17 02:45:58', '2021-04-17 02:45:58', 1, 200, NULL, NULL, NULL, NULL, 0, 1, 1),
(5, 17, 1, '1005', 'Porshe design', 'glasses/glasses-for-sight/porshe-design', '', '2021-04-17 02:45:58', '2021-04-17 02:45:58', 1, 100, NULL, NULL, '1,2', NULL, 0, 1, 3),
(6, 18, 1, '1006', 'EMPORIO ARMANI', 'glasses/sunglasses/emporio-armani', '', '2021-04-17 02:45:58', '2021-04-17 02:45:58', 1, 100, NULL, NULL, '1,2', NULL, 0, 1, 3),
(7, 17, 1, '1007', 'PRADA', 'glasses/glasses-for-sight/prada', '', '2021-04-17 02:45:58', '2021-04-17 02:45:58', 1, 90, NULL, NULL, '2', NULL, 0, 1, 3),
(8, 13, 1, '1008', 'Fanta', 'foodstuffs/soda-drinks/fanta', '', '2021-04-17 02:45:58', '2021-04-17 02:45:58', 1, 0.75, NULL, 8, '2', NULL, 0, 1, 4),
(9, 13, 1, '1009', 'Fanta 1.5 L', 'foodstuffs/soda-drinks/fanta-15-l', '', '2021-04-17 02:45:58', '2021-04-17 02:45:58', 1, 0.95, NULL, 8, NULL, NULL, 0, 1, 4),
(10, 15, 1, '1010', 'Milavitsa', 'womens-underwear/milavitsa', '', '2021-04-17 02:45:58', '2021-04-17 02:45:58', 1, 100, NULL, NULL, '1,2', NULL, 0, 1, 2),
(11, 15, 1, '1011', 'Victoria\'s secret', 'womens-underwear/victorias-secret', '', '2021-04-17 02:45:58', '2021-04-17 02:45:58', 1, 90, NULL, NULL, '1,2', NULL, 0, 1, 2),
(12, 15, 1, '1012', 'Clovia', 'womens-underwear/clovia', '', '2021-04-17 02:45:58', '2021-04-17 02:45:58', 1, 90, NULL, NULL, '1,2', NULL, 0, 1, 2),
(13, 15, 1, '1013', 'Amante', 'womens-underwear/amante', '', '2021-04-17 02:45:58', '2021-04-17 02:45:58', 1, 90, NULL, NULL, '1,2', NULL, 0, 1, 2),
(15, 19, 1, '1015', 'Mouse', 'electronics/phones/accessories-for-smartphones/mouse', '', '2021-04-17 02:45:58', '2021-04-17 02:45:58', 1, 10, NULL, NULL, '3', NULL, 0, 1, 1),
(16, 19, 1, '1016', 'Bag', 'electronics/phones/accessories-for-smartphones/bag', '', '2021-04-17 02:45:58', '2021-04-17 02:45:58', 1, 15, NULL, NULL, NULL, NULL, 0, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `product_buy_with_this`
--

CREATE TABLE `product_buy_with_this` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `buy_product_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `product_buy_with_this`
--

INSERT INTO `product_buy_with_this` (`id`, `product_id`, `buy_product_id`) VALUES
(1, 1, 15),
(2, 1, 16),
(3, 2, 15),
(4, 2, 16);

-- --------------------------------------------------------

--
-- Структура таблицы `product_category`
--

CREATE TABLE `product_category` (
  `id` int NOT NULL,
  `category_id` int NOT NULL,
  `product_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `product_network`
--

CREATE TABLE `product_network` (
  `id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `network_type` smallint DEFAULT NULL,
  `network_id` varchar(255) DEFAULT NULL,
  `network_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `product_network`
--

-- --------------------------------------------------------

--
-- Структура таблицы `product_rating`
--

CREATE TABLE `product_rating` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `ip` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `product_id` int NOT NULL,
  `mark` smallint NOT NULL,
  `factor` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `product_rating`
--

INSERT INTO `product_rating` (`id`, `user_id`, `ip`, `product_id`, `mark`, `factor`) VALUES
(1, NULL, '127.0.0.1', 1, 5, 2),
(2, NULL, '127.0.0.2', 1, 4, 0),
(3, NULL, '127.0.0.3', 1, 5, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `shop`
--

CREATE TABLE `shop` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `title_url` varchar(255) NOT NULL,
  `description` text,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `shop`
--

INSERT INTO `shop` (`id`, `title`, `title_url`, `description`, `address`) VALUES
(1, 'Central Computers', 'central-computers', 'We sell computers', 'Aiden street, 40, California, US'),
(2, 'Mango', 'mango', 'We sell lingeries', 'Wall street, 50, New-York, US'),
(3, 'Modern Optics', 'modern-optics', 'We sell glasses', 'Twain street, 41, Las-Vegas, US'),
(4, 'McDonald\'s', 'mc-donalds', 'We sell foods', 'Hemingway street, 12, Los Angeles, US');

-- --------------------------------------------------------

--
-- Структура таблицы `tag`
--

CREATE TABLE `tag` (
  `id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tag`
--

INSERT INTO `tag` (`id`, `title`) VALUES
(1, 'Asus'),
(2, 'Computer'),
(3, 'Apple');

-- --------------------------------------------------------

--
-- Структура таблицы `upwork`
--

CREATE TABLE `upwork` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `description` text NOT NULL,
  `link` text NOT NULL,
  `guid` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `upwork`
--

INSERT INTO `upwork` (`id`, `title`, `date`, `description`, `link`, `guid`) VALUES
(2, 'ShareTribe Flex Marketplace API Integration', '2018-08-30 10:47:45', 'We&#039;ve been in talks with the ShareTribe CEO, Juho about integrating their marketplace into our HumHub-based community platform and he recommended that we use ShareTribe Flex for customization purposes. <br /><br />\nAre you familiar with customizing ShareTribe Flex? Can you build an API that allows ShareTribe to seamlessly integrate with HumHub ( https://humhub.org/ )? We need ShareTribe Flex to be embedded into the HumHub community platform. That is, it can&#039;t link out to a separate page. It must be within! <br /><br />\nEssentially, we&#039;re building a marketplace (like eBay) into a social media platform &amp;amp; information must be able to communicate between both!<br /><br />\nIf this is something you think you can handle can you please tell me about your team &amp;amp; the amount of time you can allocate on our project? I&#039;d love to brief you over a skpe call, send you a list of our features, and get a timeline on how long it would take your team. We will be building the world&#039;s largest marketplace, with many different features (that can be rolled out in different versions). Our first version needs to be completed in a timely manner.<br /><br />\nAPI Integration &amp;amp; Customization must include feature add-ons, layout changes, UX/UI design changes, to name a few.<br /><br />\nLet&#039;s hop on a call today/tomorrow if you&#039;re available to talk more?<br /><br />\nLooking forward to speaking.<br /><br />\nBest,<br /><br /><br /><b>Posted On</b>: August 30, 2018 08:12 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Other - Software Development\n<br /><b>Skills</b>:        API Development,                     PHP,                     Ruby,                     Ruby on Rails,                     Sharetribe,                     Yii            <br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/ShareTribe-Flex-Marketplace-API-Integration_%7E018eefb5ed4c9e8269?source=rss', 'https://www.upwork.com/jobs/ShareTribe-Flex-Marketplace-API-Integration_%7E018eefb5ed4c9e8269?source...'),
(3, 'Yii Expert,  make Yii  index.php a Wordpress index.php, Make sure SSO works', '2018-08-30 00:25:01', 'Expert needed in htaccess, Yii, wordpress,&nbsp;&nbsp;to make my HOME PAGE ONLY&nbsp;&nbsp;from Yii&nbsp;&nbsp;to Wordpress.<br /><br />\nRest of site stays&nbsp;&nbsp;in&nbsp;&nbsp;Yii.<br /><br />\nThe home page needs to have the top header bar the same&nbsp;&nbsp;with the login.<br /><br /><br />\n Here is a PPT https://www.dropbox.com/s/qtesxzznbb3bj6f/YII%20%20home%20page.pptx?dl=0<br /><br />\nHere is a video. http://www.youtube.com/watch?v=PY3Vo-hQx5I<br /><br />\nHere are the exact steps&nbsp;&nbsp;and issues<br /><br />\nChange Index.php&nbsp;&nbsp;from&nbsp;&nbsp;yii&nbsp;&nbsp;to wordpress<br /><br />\nKeep the menu and SSO login on top as it is now &ndash; we have code for this at http://florida.com/blog&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a wordpress install<br /><br />\nAll urls must remain same.<br /><br />\nMust install on local server&nbsp;&nbsp;from bitbucket.<br /><br />\nSite&nbsp;&nbsp;has elastic search.<br /><br />\nI will give you the DB dump<br /><br />\nYou do NOT have to install a new wordpress or design the new index.php. It exists in http://florida.com/home&nbsp;&nbsp;that is a SAMPLE&nbsp;&nbsp;only. The menu is NON functional image placeholder.<br /><br />\nNeed to discuss how the new other pages that we create in WP, what will be the url structure, other than the home page<br /><br />\nFB&nbsp;&nbsp;signup and login&nbsp;&nbsp;doesn&rsquo;t work<br /><br /><b>Budget</b>: $299\n<br /><b>Posted On</b>: August 30, 2018 08:12 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/Yii-Expert-make-Yii-index-php-Wordpress-index-php-Make-sure-SSO-works_%7E01976814e168e4f918?source=rss', 'https://www.upwork.com/jobs/Yii-Expert-make-Yii-index-php-Wordpress-index-php-Make-sure-SSO-works_%7...'),
(4, 'Full Stack Yii2 Developer for Invoicing/Scheduling SAAS Application', '2018-08-29 19:53:37', 'We need an expert Full Stack Yii2 developer to help us with an ongoing project. This application has been built already.&nbsp;&nbsp;It is a responsive SAAS application that does quotes, invoking, scheduling, and accept payments.&nbsp;&nbsp;It also has a mobile app. We are working on phase 2.&nbsp;&nbsp;Developer DOES NOT have to have experience in Yii2 (though it is peferable), but they need to have experience with a PHP MVC framework and able to pick up Yii2 quickly. Developer needs to be smart, able to figure things out themselves with no hand holding, learn new, better ways to do things, meet deadlines and have good communication.&nbsp;&nbsp;Developer needs to be able to look at code and understand the system and what the business is trying to do.&nbsp;&nbsp;Developer needs to write high quality code.&nbsp;&nbsp;We do not want developers who write buggy code and do not take the time to test their own code. Our last developer couldn&#039;t do this, so if you can&#039;t also, do not apply. Developer needs to know Yii2/PHP standards and conventions.<br /><br />\nI am looking for both individuals and agencies.&nbsp;&nbsp;If this project goes well, I may have other projects also in other technologies.&nbsp;&nbsp;If I hire an agency, I need a good project manager that can manage the developers work, getting the work done according to requirements and handling deadlines.&nbsp;&nbsp;I am a coder myself, so I will be able to do code reviews myself and I know bad code when I see it.&nbsp;&nbsp;Also, I have a general idea of how long a task should take.<br /><br />\nInitial task is to fix our code deployments and code base.&nbsp;&nbsp;Right now on our server deployments is a mess.&nbsp;&nbsp;When we deploy there is issues.&nbsp;&nbsp;We use deployhq. This is because code on server does not match with our git, there is things hardcoded on server, there is things in code that is suppose to be set in environment/config variables, but isn&#039;t.<br /><br />\n2nd task is that we have a lot of code in different branches right now that need to tested, merged and then deployed.&nbsp;&nbsp;We haven&#039;t done this because our deployment process is broken so we need to do #1 first.<br /><br />\nAfter that, if this goes good, we will have other tasks.<br /><br />\nPreferred skills:<br />\nYii2<br />\nMySQL<br />\nAngularJS<br />\nJquery<br />\nPHPUnit<br />\nHTML/CSS/Bootstrap<br />\nSome NodeJS<br />\nGit<br />\nDeployHQ for Deployments<br /><br />\nPluses:<br />\nAWS<br />\nDesign<br />\nSystem Admin<br />\nTrello/Kanban<br />\n* Would be good if they knew a little dev ops also, so they can configure servers.<br /><br /><br />\nTo Apply:<br />\n1. Post top 3 of your best sites/applications that you have built, preferably in Yii2.<br />\n2. Are you a team our individual?<br />\n3. Do you currently have another job or are working on other projects?<br />\n4. How long have you been working with PHP?<br />\n5. Send code samples, preferably Yii2, of your own, custom code.<br /><br /><b>Budget</b>: $300\n<br /><b>Posted On</b>: August 30, 2018 08:12 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        Amazon Web Services,                     AngularJS,                     BitBucket,                     Bootstrap,                     CSS,                     CSS3,                     Git,                     HTML,                     HTML5,                     JavaScript,                     jQuery,                     Linux System Administration,                     MySQL Programming,                     Node.js,                     PHP,                     System Deployment,                     Trello,                     Unit Testing,                     Web Design,                     Website Development,                     Yii            <br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/Full-Stack-Yii2-Developer-for-Invoicing-Scheduling-SAAS-Application_%7E01902162409c25bc05?source=rss', 'https://www.upwork.com/jobs/Full-Stack-Yii2-Developer-for-Invoicing-Scheduling-SAAS-Application_%7E0...'),
(5, 'Create php unit tests using Yii2 php framework and codeception', '2018-08-29 16:27:44', 'PHP Unit Tests Developer (Yii 2)<br /><br />\nResponsibilities:<br /><br />\nUnit test development (Yii 2)<br />\nWrite &ldquo;clean&rdquo;, well-designed code<br />\nProduce detailed specifications<br />\nEnsuring high performance<br /><br />\nRequirements:<br /><br />\nFluent English or Russian languages<br />\nExcellent knowledge of Yii 2, php, mysql, migrations, codeception, composer, git<br />\nAnalytical mind and problem-solving aptitude<br />\nWell-organize, pro-activity, initiative, high workability, performance, responsibility, accuracy, pedantry<br />\nGood communication skills<br /><br /><br /><b>Posted On</b>: August 30, 2018 08:12 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        PHP,                     Unit Testing,                     Website Development            <br /><b>Country</b>: Thailand<br />click to apply', 'https://www.upwork.com/jobs/Create-php-unit-tests-using-Yii2-php-framework-and-codeception_%7E0100541ec118894efe?source=rss', 'https://www.upwork.com/jobs/Create-php-unit-tests-using-Yii2-php-framework-and-codeception_%7E010054...'),
(6, 'Medical Diary Mobile APP', '2018-08-28 22:08:06', 'I have developed the admin panel using Yii2 for my project.<br />\nThe API is yet to be created.<br />\nI want the app to be cross platform. Therefore it can deployed for Android as well as iOS.<br />\nYou can choose to develop the admin panel again. The panel should be in PHP/MySQL.<br />\nThe project is very much same as <br />\nhttps://play.google.com/store/apps/details?id=com.hyrax.mymedical<br /><br />\nProject Brief - <br />\nBesides login/register/push&nbsp;&nbsp;notifications/sms/payments, we need the following - <br /><br />\n1. User/admin can Upload prescriptions in structured way. For eg. Datewise, for which disease, etc..<br /><br />\n2. Admin can upload a digital documents having history of prescriptions, medicines, doctors name, etc... Means a place to upload a PDF document from the admin panel. However this document has to be purchased as a service for that particular individual. The payment will be through PayTM Payment Gateway.<br /><br />\n3. Blood Pressure Monitor, Blood Glucose Monitor and Pill Reminder is the additional features.<br /><br /><b>Budget</b>: $500\n<br /><b>Posted On</b>: August 30, 2018 08:12 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Mobile Development\n<br /><b>Skills</b>:        Mobile App Development,                     PHP            <br /><b>Country</b>: India<br />click to apply', 'https://www.upwork.com/jobs/Medical-Diary-Mobile-APP_%7E0184e22a8e45ba11e9?source=rss', 'https://www.upwork.com/jobs/Medical-Diary-Mobile-APP_%7E0184e22a8e45ba11e9?source=rss'),
(7, 'Loyalty program PHP Fox Upgrade and FIX or Recode Current points system', '2018-08-28 11:28:36', 'We currently have a phpfox platform using some add ons to support a community that register codes and this codes provide certain amount of points in the platform, then this points can be exchanged by products on a section of the platform. <br /><br />\nDue to the big amount of records and use base , the platform has suffer a bad performance creating some bugs on the day to day business process and products orders.<br /><br />\nInitial budget is to stabilise the platform with current functionalities or to create a new solution based on PHP fox or other framework that satisfy the same needs of this loyalty program. <br />\nAfter success deployment of this new solution a monthly bucket of support hours will be also needed to be hired.<br /><br />\nWe will hire the developer or agency with proven experience on php fox or loyalty programs that manage big amount of users data with fast performance on the platform.<br /><br />\nThis work might required to recode part of the solution or all the solution of the points system.<br /><br /><b>Budget</b>: $3,000\n<br /><b>Posted On</b>: August 30, 2018 08:12 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        Amazon EC2,                     CodeIgniter,                     Laravel Framework,                     PHP,                     phpFox,                     SQL,                     Yii            <br /><b>Country</b>: Mexico<br />click to apply', 'https://www.upwork.com/jobs/Loyalty-program-PHP-Fox-Upgrade-and-FIX-Recode-Current-points-system_%7E01ca891db70ed95fea?source=rss', 'https://www.upwork.com/jobs/Loyalty-program-PHP-Fox-Upgrade-and-FIX-Recode-Current-points-system_%7E...'),
(8, 'Business Developer Executive(BDE) for long term relationship', '2018-08-27 19:21:42', 'We need a Business Developer for long term relationship. We have great experience about following.<br /><br />\nBackend<br />\nPHP - Laravel, Yii, Symphony<br />\nMySQL, Sql, <br />\nAPI concepts <br />\nJavascript - Node JS<br /><br />\nFrontend<br />\nHTML5, CSS3<br />\nJavascript - Angular JS<br />\nSASS, LESS<br /><br />\nMobile Development<br />\niOS<br />\nAndroid<br /><br />\nOther skills<br />\nAdobe Photoshop, Adobe Illustrator, Corel Draw<br />\nWordpress, Woocommerce<br />\nMagento, Shopify<br /><br /><br /><b>Posted On</b>: August 30, 2018 08:12 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Other - Software Development\n<br /><b>Country</b>: India<br />click to apply', 'https://www.upwork.com/jobs/Business-Developer-Executive-BDE-for-long-term-relationship_%7E01d9a2e518c3790251?source=rss', 'https://www.upwork.com/jobs/Business-Developer-Executive-BDE-for-long-term-relationship_%7E01d9a2e51...'),
(9, 'Enterprise PHP / Yii developers (team of 2) help with existing system analysis and architecture review', '2018-08-27 17:33:41', 'My team is about to inherit an existing system/platform and i would like someone to help us for a couple weeks to do some analysis on the existing system while we free up resources. Ideally looking for someone with a lot of web experience as i understand it the site is built in php using Yii framework but when scanning with builtwith.com i notice a few ruby things as well. The site is a large scale content management and publishing system that manages content for a high traffic website. Several developers have worked on it over the years so during this analysis we will be on the lookout for technical debt that someone will need to resolve at some point. <br /><br />\nWe want someone that can work along side us in slack and communicate with us as a lot as we go through these few weeks. Its likely we will enlist your help as we move in to development in a future phase but for now we need a trusted partner to help us figure out what we got, what risks we have in this code, what is good, bad ugly. After fully figuring out what we have we then want to plan the future. We will go through some planning activities (backlog grooming) to see how we would go about doing some of the updates and improvements that we want to make to the system. We will follow a someone agile approach here in terms of thinking about the feature story and then breaking it down to details so we know how we would go about the change along with some ballpark estimations. <br /><br />\nLooking for 2 guys to be on this so we can split up the work a bit in to front end backend or user side, admin side etc... should be familiar with jira, agile, system review, scaleable architectures.<br /><br /><br /><b>Posted On</b>: August 30, 2018 08:12 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        API Development,                     MySQL Administration,                     PHP,                     Yii,                     Yii2            <br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/Enterprise-PHP-Yii-developers-team-help-with-existing-system-analysis-and-architecture-review_%7E01f4bd77b564166fe1?source=rss', 'https://www.upwork.com/jobs/Enterprise-PHP-Yii-developers-team-help-with-existing-system-analysis-an...'),
(10, 'Experienced Yii+HTML5 canvas Developer needed for a responsive website with e-cards (russian langv.)', '2018-08-27 16:36:11', 'It is necessary to make a new site with electronic postcards (the postcard editor should be developed in Javascript (you can Javascript frameworks), html5, css3) and store for other users on a new framework, for example, Laravel 5, Yii. Digital postcards will be edited from the interface of the store and then sent by email or printed. In the shops of other users you can buy their work and pay through our website.<br /><br />\nThe administrative part can be made on your own templates and besides the usual functions for the web-shop functions will also have to include the administrative part of the built-in editor (mentioned above) + newsletter.<br /><br />\nThere is a complete layout of the user part of the site (without the editor).<br /><br />\nWe will discuss the details in detail after a preliminary agreement. <br />\nThe price is namedfor the whole project, the remaining part will be negotiated by agreement. Payment in rubles. We work only on the approved estimate to the contract. The total amount for the whole project in rubles is 408.000. About half of the project is already finished on Yii, so it&#039;s about the &frac12; of the project, including the editor, the administrative part and part of the functionality have to be finished.<br /><br />\nPrepayments due to negative experience with previous developers will not be, but I guarantee 100% payment. We work only this way: we split the project into several stages, we will coordinate the terms and costs of each stage accordingly. At the end of a certain stage, we check it together, eliminate errors and I translate the payment, after which you give me the stage. Starting with the stage to demonstrate the work of the main page is not necessary, I&#039;m looking for serious developers.<br /><br />\nI&#039;m waiting for suggestions with examples of your work and the timing of this service.<br /><br />\nWork for qualified specialists. People with little work experience, please HE to leave applications.<br /><br /><b>Budget</b>: $6,000\n<br /><b>Posted On</b>: August 30, 2018 08:12 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        HTML5,                     HTML5 Canvas,                     JavaScript,                     Website Development,                     Yii2            <br /><b>Country</b>: Ukraine<br />click to apply', 'https://www.upwork.com/jobs/Experienced-Yii-HTML5-canvas-Developer-needed-for-responsive-website-with-cards-russian-langv_%7E01594c4ec794322d45?source=rss', 'https://www.upwork.com/jobs/Experienced-Yii-HTML5-canvas-Developer-needed-for-responsive-website-wit...'),
(11, 'Freelance PHP (Yii)  Developer needed for Immediate placement', '2018-08-27 12:48:09', 'We are looking to hire a Freelance Senior PHP web developer with good Knowledge in Yii and Codeigniter Frame works<br /><br />\n*Web developer responsibilities include building our website from concept all the way to <br />\n completion from the bottom up, fashioning everything from the home page to site layout and <br />\n function.<br />\n*Write well designed, testable, efficient code by using best software development practices<br />\n*Create website layout/user interface by using standard HTML5/CSS3 practices<br />\n*Integrate data from various back-end services and databases<br />\n*Gather and refine specifications and requirements based on technical needs<br />\n*Create and maintain software documentation<br />\n*Be responsible for maintaining, expanding, and scaling our site<br />\n*Stays plugged into emerging technologies/industry trends and apply them into operations and <br />\n activities<br />\n*Cooperate with web designers to match visual design intent<br /><br />\nRequired Experience, Skills and Qualifications<br /><br />\n*Proven working experience of 2 to 3 yrs in web programming<br />\n*Experience in working with Ticket Aggregator and E-commerce websites will be given more <br />\n preference. .<br />\n*Top-notch programming skills and in-depth knowledge of modern HTML5/CSS3<br />\n*Familiarity with the following programming languages: PHP, Yii, Laravel, Codeigniter, Frame <br />\n works, Javascript , Mysql, Payment gateway Integration.<br />\n*Experience in handling third part APIs<br /><br /><b>Budget</b>: $200\n<br /><b>Posted On</b>: August 30, 2018 08:12 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        CodeIgniter,                     CSS3,                     HTML5,                     JavaScript,                     jQuery,                     MySQL Administration,                     PHP,                     Website Development,                     Yii            <br /><b>Country</b>: India<br />click to apply', 'https://www.upwork.com/jobs/Freelance-PHP-Yii-Developer-needed-for-Immediate-placement_%7E017b05ab514407b0b6?source=rss', 'https://www.upwork.com/jobs/Freelance-PHP-Yii-Developer-needed-for-Immediate-placement_%7E017b05ab51...'),
(12, 'New bilingual coaching website', '2018-08-27 09:53:38', '* Build bilingual (English &amp;amp; Chinese) website using domain already bought on Godaddy with host that is accessible by both China and globally<br />\n* API should be compatible for China and global <br />\n* Design (web &amp;amp; mobile) is simple and clean - templates ok<br />\n* Site should be developed so that I can easily update blog posts, webinars (on zoom), videos, podcasts, etc&hellip; regularly (we can review this)<br />\n* Domain emails set-up + opt-in contacts to be captured on form<br />\n* SEO and registrations on Baidu, 360 Search, Google, Bing etc.. and registration of site on open directory and/or other applicable platforms (China &amp;amp; global)<br />\n* Plug-ins <br />\n* Testing<br /><br /><br /><b>Posted On</b>: August 30, 2018 08:12 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web &amp; Mobile Design\n<br /><b>Skills</b>:        CodeIgniter,                     Laravel Framework,                     PHP,                     SQL,                     Yii            <br /><b>Country</b>: Hong Kong<br />click to apply', 'https://www.upwork.com/jobs/New-bilingual-coaching-website_%7E0198f6037019696ad5?source=rss', 'https://www.upwork.com/jobs/New-bilingual-coaching-website_%7E0198f6037019696ad5?source=rss'),
(13, 'Update page layout on yii engine', '2018-08-27 01:15:08', 'Need to update layout for one page on the site<br />\nKnowledge of yii engine, the ability to work with github are obligatory.<br /><br />\nWhat looks like now:<br />\nhttps://fortrader.org/contests<br /><br />\nwhat need to do:<br />\nhttps://cdn.rawgit.com/webtask-eu/html/dev/fortrader.ru/fx_contest-table.html<br /><br />\nThe new css template is already integrated, for example https://fortrader.org/cryptocurrencies<br /><br /><b>Budget</b>: $20\n<br /><b>Posted On</b>: August 30, 2018 08:12 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        CSS,                     HTML,                     JavaScript,                     jQuery,                     PHP,                     Website Development,                     WordPress            <br /><b>Country</b>: Latvia<br />click to apply', 'https://www.upwork.com/jobs/Update-page-layout-yii-engine_%7E011915ec4d42dcf4f6?source=rss', 'https://www.upwork.com/jobs/Update-page-layout-yii-engine_%7E011915ec4d42dcf4f6?source=rss'),
(14, 'YII2 PHP Development  needed for developing SEO Functionality', '2018-08-25 17:17:30', 'Looking for a PHP, Yii2 Developer with 5 years + experience to Fix and add features to our SEO functionality part of our present website www.bombayproperty.com<br />\nYii2&nbsp;&nbsp;web framework <br />\nPHP Version:7.0.28<br />\nMySQL Version: 5.6.40<br />\nOperating System: Linux<br /><br />\nScope:<br />\n- Adding up the SEO meta tags+ sharing features for all the property pages and other static pages pertaining to relevant various social mediums / messaging platforms.<br />\n&nbsp;&nbsp;Social Medium-<br />\n&nbsp;&nbsp;&nbsp;&nbsp;Twitter<br />\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Facebook Open graph<br />\n&nbsp;&nbsp;&nbsp;&nbsp;Pinterest<br />\n&nbsp;&nbsp;&nbsp;&nbsp;Instagram<br />\n&nbsp;&nbsp;&nbsp;&nbsp;Linkedin<br />\n&nbsp;&nbsp;&nbsp;Whatsapp<br />\n-Sharing via email + through the above social medium/ messaging platforms.<br />\n-Fixing, Enabling and creating functionality for using analytics <br />\n&nbsp;&nbsp;Google analytics<br />\n&nbsp;&nbsp;Google Tag Manager<br />\n&nbsp;&nbsp;Facebook Open Graph + pixel<br /><br />\nIt is about enabling, fixing and creating functionality for all pages related to SEO meta tags, creating categories and tags for all the pages + web analytics.<br /><br />\nThere is ongoing work and We are looking for someone with the time and capability to work with speed and accuracy, which will prove economical for us<br /><br />\nThe project budget needs to be decided as per the work that will be undertaken by the developer.The Project will be ongoing to Fix issues and For Further Development<br /><br /><b>Budget</b>: $70\n<br /><b>Posted On</b>: August 30, 2018 08:12 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        AngularJS,                     CSS,                     CSS3,                     HTML,                     HTML5,                     JavaScript,                     jQuery,                     PHP            <br /><b>Country</b>: India<br />click to apply', 'https://www.upwork.com/jobs/YII2-PHP-Development-needed-for-developing-SEO-Functionality_%7E01fea11a16c4871fa8?source=rss', 'https://www.upwork.com/jobs/YII2-PHP-Development-needed-for-developing-SEO-Functionality_%7E01fea11a...'),
(15, 'Developer for yii framework project needed for project maintenace and product development', '2018-08-24 20:22:08', 'Looking for an experienced backend developer with existing and provable expereince in yii framework projects and knowledge about and experience with audio streaming. The job includes: understanding the functionality of existing audio streaming system, ongoing maintenance of existing audio streaming system, it-support for existing audio streaming system, further developement of existing audio streaming system.<br /><br /><br /><b>Posted On</b>: August 30, 2018 08:12 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        CSS,                     HTML,                     JavaScript,                     MySQL Administration,                     PHP            <br /><b>Country</b>: Germany<br />click to apply', 'https://www.upwork.com/jobs/Developer-for-yii-framework-project-needed-for-project-maintenace-and-product-development_%7E01114d27909d36cfe4?source=rss', 'https://www.upwork.com/jobs/Developer-for-yii-framework-project-needed-for-project-maintenace-and-pr...'),
(16, 'Back End Web Developer (Django/Php)', '2018-08-23 22:19:53', 'As a Back-end Web Developer at Tfonia Inc, you will create web services to facilitate new functionality and improve existing web services. We&#039;re looking for a dedicated Back-end Web Developer who stays up to date on the latest web development standards. You will ultimately be helping us create beautiful and engaging web and mobile experiences.&nbsp;&nbsp;&nbsp;<br /><br />\n TECHNICAL SKILLS<br />\n Object-Oriented Programming <br />\nStrong problem solving skills and ability to generate high quality code <br />\nExcellent written and verbal communications skills <br />\nWeb Frameworks - Python/Django, PHP/Yii&nbsp;&nbsp;<br />\nREST/JSON Knowledge of CSS/html, Javascript, jquery Bootsramp <br /><br /><br />\nQUALITIES <br /><br />\nFast learner <br />\nProactive <br />\nCurious <br />\nPassionate <br />\nCommitted<br /><br /><br /><b>Posted On</b>: August 30, 2018 08:12 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        Django,                     JavaScript,                     jQuery,                     PHP,                     Python            <br /><b>Country</b>: Canada<br />click to apply', 'https://www.upwork.com/jobs/Back-End-Web-Developer-Django-Php_%7E01e02397a27aef135b?source=rss', 'https://www.upwork.com/jobs/Back-End-Web-Developer-Django-Php_%7E01e02397a27aef135b?source=rss'),
(17, 'Программист для разработки кода для фриланс-биржи текстов и фото', '2018-08-23 15:43:48', 'Оплата поэтапная (за каждые полностью сделанные под ключ 3 блока), без АВАНСОВ !!! <br />\nТребуется написать программный код для онлайн-биржи контента на основании ТЗ и верстки. Работа ведется на сервере исполнителя. Цена не более 1000 $. Срок не более 30 календарных дней. Предпочтительные программы: Yii2 advanced, Meanstack, но возможны варианты. Ждем предложений. <br />\nОбязателен опыт работы (статус на сайте не &amp;quot;новый фрилансер&amp;quot;), наличие положительных отзывов.<br /><br />\nWrite the program code for the site for freelancing (buying and selling texts, photos, custom-made)<br />\nThe payment is step by step (the task is divided into parts (units, blocks), payment for every 3 functional blocks after their completion), without PREPAYMENT!!! We need program code for the site for freelancing. There is a ready-made layout (page-proofs), technical task (common and for each module (unit, block). The employee works on his server. The price is not more than 1000 $. The deadline is not more than 30 calendar days. Preferred programs: Yii2 advanced, Meanstack, but options are possible. We are waiting for offers. The employee must be experienced (the status on the site is not &amp;quot;a new freelancer&amp;quot;). The employee should have good feedback.<br /><br /><b>Budget</b>: $1,000\n<br /><b>Posted On</b>: August 30, 2018 08:12 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Other - Software Development\n<br /><b>Country</b>: Russia<br />click to apply', 'https://www.upwork.com/jobs/%7E01fb1f00bbc8d89025?source=rss', 'https://www.upwork.com/jobs/%7E01fb1f00bbc8d89025?source=rss'),
(18, 'Yii framework based site- functionality updates needed', '2018-08-23 01:42:37', 'Have a site taht needs further work / updates.&nbsp;&nbsp;Will need to interface with mysql db backend.<br /><br /><b>Budget</b>: $50\n<br /><b>Posted On</b>: August 30, 2018 08:12 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        CSS3,                     HTML5,                     jQuery,                     PHP,                     Website Development            <br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/Yii-framework-based-site-functionality-updates-needed_%7E01c3856a85872cab22?source=rss', 'https://www.upwork.com/jobs/Yii-framework-based-site-functionality-updates-needed_%7E01c3856a85872ca...'),
(19, 'Full Stack Web Developper', '2018-08-22 04:00:16', 'A propos de Outsmart Labs <br /><br />\nOutsmart Labs est une agence de marketing digital jeune et dynamique sp&eacute;cialis&eacute;e dans la gestion de campagne marketing pour tiers et le d&eacute;veloppement de solution B2B en France et aux Etats-Unis. Nous sommes &agrave; la recherche d&rsquo;un d&eacute;veloppeur full stack pour prendre en charge la maintenance et le d&eacute;veloppement de deux outils propri&eacute;taires.<br /><br />\nQualifications techniques:<br /><br />\nMa&icirc;trise parfaites des langues web :<br /><br />\n- HTML5.<br />\n- CSS3.<br />\n- Javascript.<br />\n- Ajax.<br /><br />\nD&eacute;veloppement en :<br />\n- PHP +5.<br />\n- Yii<br />\n- WordPress<br />\n- MYSQL.<br />\n- Integration des API google et Facebook<br />\n - Developpement responsive<br /><br />\nQualifications suppl&eacute;mentaires:<br /><br />\n- Vue.js<br />\n- Laravel<br />\n- Administration de serveurs Apache<br />\n- Ma&icirc;trise des syst&egrave;mes de d&eacute;ploiement de version GIT&nbsp;&nbsp;<br />\n- Ma&icirc;trise des standards de s&eacute;curit&eacute; pour les applications web, XSS, injection et extraction MySQL <br />\n- Communication en Anglais et Fran&ccedil;ais<br /><br /><br /><b>Posted On</b>: August 30, 2018 08:12 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        AngularJS,                     CSS,                     CSS3,                     HTML,                     HTML5,                     JavaScript,                     MySQL Administration,                     PHP,                     Web Design,                     Website Development,                     WordPress            <br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/Full-Stack-Web-Developper_%7E013e98cb31c6704ca5?source=rss', 'https://www.upwork.com/jobs/Full-Stack-Web-Developper_%7E013e98cb31c6704ca5?source=rss'),
(20, 'PHP Yii2 Framework (Sr. Developer)', '2018-08-22 02:25:01', 'Hello - We are looking to identify great new developer(s) to work with as we continue to grow our projects!<br /><br />\nOur current projects include a mobile payment ordering system (backend Yii application works with mobile application via API) in addition to a separate project that is for insurance companies.<br /><br />\nHow we Work:<br />\nWe are looking for developers who have 10+ hours per week (or more!) and can work from tasks we create on Asana.&nbsp;&nbsp;We use a &amp;quot;Kanban/Pull&amp;quot; methodology - we create tasks in the backlog, sort tasks by priority, you can pull in a new top-priority tasks to &amp;quot;to do&amp;quot; whenever you are ready.<br /><br />\nTechnical Requirements:<br />\n* Experience working with Yii and best practices of the Yii framework<br />\n* Yii Migrations<br />\n* Unit/Functional testing<br />\n* Git (we use GitHub.com) where all code changes get pushed to<br />\n* PHP 7.0+, MySQL, and knowledge of HTML/CSS, Javascript (even if not JS expert no worries!)<br /><br />\nCommunication:<br />\n* We require great communication - but promise it&#039;s easy to do!<br />\n* If you work on an issue we&#039;d like an very short update each day on the Asana task.&nbsp;&nbsp;2-3 sentences is usually fine!<br />\n* We expect frequent commits to our remote repo as part of the communication (we do not want many hours spent working on an issue without getting to see and review the code for feedback).&nbsp;&nbsp;We are not crazy here, but generally if you work more than a few hours on an issue we would like a commit pushed to the remote repo.<br />\n* A quick check in on our slack channel sometimes - you can work with other PHP developers, participate in code review, or ask anything you&#039;d like help on!<br /><br />\nIf you are interested in the above please let us know and we can start with some small projects together as a test/interview.<br /><br />\nThank you!<br />\nDan<br /><br /><br /><b>Posted On</b>: August 30, 2018 08:12 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        CSS,                     Functional Testing,                     HTML,                     JavaScript,                     MySQL Programming,                     PHP,                     Unit Testing            <br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/PHP-Yii2-Framework-Developer_%7E01247b3f82f05858a8?source=rss', 'https://www.upwork.com/jobs/PHP-Yii2-Framework-Developer_%7E01247b3f82f05858a8?source=rss'),
(21, 'Yii 2 Php Sphinx EXPERT required for website development and support. Must speak Russian', '2018-08-21 16:14:03', 'Hi, please only apply if you have proven experience with Yii 2 and sphinx search. I can&#039;t stress this enough! You must have relevant experience and feedbacks to be considered for this role.<br /><br />\nWanted - web developer with excellent track record to further develop and support real estate related website. Ability to understand russian is a must as the website&#039;s aimed at CIS market. Please note - sphinx search knowledge is essential for this role<br /><br />\nТребуется опытный специалист для постоянной удалённой (неполная занятость на старте) работы над проектом (сфера - недвижимость). Вашей задачей будет развитие/доработка портала (luxetra.ru). Почасовая оплата на начальном этапе. Перспектива фултайм трудоустройства в качестве ведущего специалиста.<br /><br />\nОбратите внимание - ОБЯЗАТЕЛЕН опыт с sphinx search engine и Yii 2.0 <br /><br />\nПожалуйста, отзывы только от ОТВЕТСТВЕННЫХ и ОПЫТНЫХ исполнителей <br />\nПреимущество кандидатам, имеющим опыт разработки в сфере &amp;quot;недвижимость&amp;quot;<br />\nexperts only need to apply please<br /><br />\nImmediate start needed!!!<br />\nPLEASE DO NOT APPLY IF YOU DON&#039;T MATCH THE CRITERIA.<br /><br /><br /><b>Posted On</b>: August 30, 2018 08:12 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        JavaScript,                     MySQL Administration,                     PHP,                     Sphinx,                     Website Development            <br /><b>Country</b>: United Kingdom<br />click to apply', 'https://www.upwork.com/jobs/Yii-Php-Sphinx-EXPERT-required-for-website-development-and-support-Must-speak-Russian_%7E01b0d53cb2b08a2769?source=rss', 'https://www.upwork.com/jobs/Yii-Php-Sphinx-EXPERT-required-for-website-development-and-support-Must-...'),
(22, 'We&#039;re looking for an experienced wordpress developer with Codeigniter and Yii2 experience', '2018-08-21 16:08:58', 'We want to enhance some of our current wordpress websites and link them with our invoice application that runs on Codeigniter. Besides that we want to make a new wordpress website from scratch that links to this invoice application.<br /><br /><br /><b>Posted On</b>: August 30, 2018 08:12 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        CSS,                     CSS3,                     HTML,                     HTML5,                     JavaScript,                     jQuery,                     MySQL Administration,                     PHP,                     Web Design,                     Website Development,                     WordPress            <br /><b>Country</b>: Netherlands<br />click to apply', 'https://www.upwork.com/jobs/looking-for-experienced-wordpress-developer-with-Codeigniter-and-Yii2-experience_%7E019a44168a1b31262e?source=rss', 'https://www.upwork.com/jobs/looking-for-experienced-wordpress-developer-with-Codeigniter-and-Yii2-ex...'),
(23, 'Fix Issue in Yii App', '2018-08-21 06:39:06', 'I&#039;ve an existing app with a small issue in upload.<br /><br />\nI need to fix<br /><br /><b>Budget</b>: $5\n<br /><b>Posted On</b>: August 30, 2018 08:12 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Country</b>: Italy<br />click to apply', 'https://www.upwork.com/jobs/Fix-Issue-Yii-App_%7E01a26548451ecac354?source=rss', 'https://www.upwork.com/jobs/Fix-Issue-Yii-App_%7E01a26548451ecac354?source=rss'),
(24, 'Add Google AdWords Code', '2018-08-21 04:55:18', 'This job is for someone who has had experience adding Google AdWords text to a website. There is more to this than putting code in the &amp;lt;head&amp;gt; area. In your proposal share the websites where you have done this. This will be done on a Yii framework site. In your proposal please confirm you have worked with Yii as well.<br /><br /><br /><b>Posted On</b>: August 30, 2018 08:12 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        Website Development,                     Yii2            <br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/Add-Google-AdWords-Code_%7E01675926c75023befc?source=rss', 'https://www.upwork.com/jobs/Add-Google-AdWords-Code_%7E01675926c75023befc?source=rss'),
(25, 'PHP Yii2 developer to remote team of social startup (UA only)', '2018-08-20 20:10:46', 'We are developing growing Social Startup. And need help with the creation of new modules.<br />\nOur platform based on php Yii2 Framework. So you must be good with it or similar one FWs. <br /><br />\nIt will require 10-20 hours per week of your time. No rush development.<br />\nBut need to provide replay during 24 hours. <br /><br />\nClear code and comments for easy modification by others devs. <br /><br />\nSuccess candidate will have more work from us on other projects.<br /><br /><br /><b>Posted On</b>: August 30, 2018 08:12 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        CSS3,                     Git,                     HTML5,                     JavaScript,                     jQuery,                     PHP,                     Vue.js,                     Website Development,                     Yii            <br /><b>Country</b>: Ukraine<br />click to apply', 'https://www.upwork.com/jobs/PHP-Yii2-developer-remote-team-social-startup-only_%7E010a01f5cea4aaef19?source=rss', 'https://www.upwork.com/jobs/PHP-Yii2-developer-remote-team-social-startup-only_%7E010a01f5cea4aaef19...'),
(26, 'PHP Project Completetion for a vehicle rental platform', '2018-08-20 18:15:23', 'I have a web project which is 70% complete. The previous developer met with an accident and is not in a position to complete the project. Its built-in YII- PHP Framework. <br /><br />\nWill you be able to do it. <br />\nIts a Vehicle Rental Platform.<br /><br />\nOnce this is completed successfully. More continuous work to follow including app development and feature enhancement etc.<br /><br /><b>Budget</b>: $250\n<br /><b>Posted On</b>: August 30, 2018 08:12 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        CSS,                     HTML5,                     JavaScript,                     PHP,                     Web Design,                     Website Development            <br /><b>Country</b>: India<br />click to apply', 'https://www.upwork.com/jobs/PHP-Project-Completetion-for-vehicle-rental-platform_%7E0120cd59a4fbf3d89c?source=rss', 'https://www.upwork.com/jobs/PHP-Project-Completetion-for-vehicle-rental-platform_%7E0120cd59a4fbf3d8...'),
(27, 'Need a Yii framwork developer  I need to fix a few items. Support by phone and teamviewer', '2018-08-19 21:35:37', 'ongoing Yii framework project where I could use an assist from time to time<br /><br /><br /><b>Posted On</b>: August 30, 2018 08:12 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        CSS,                     HTML,                     JavaScript,                     jQuery,                     PHP,                     Website Development            <br /><b>Country</b>: Hong Kong<br />click to apply', 'https://www.upwork.com/jobs/Need-Yii-framwork-developer-need-fix-few-items-Support-phone-and-teamviewer_%7E016ede49ee1f3197d0?source=rss', 'https://www.upwork.com/jobs/Need-Yii-framwork-developer-need-fix-few-items-Support-phone-and-teamvie...'),
(28, 'Web App Development Team', '2018-08-18 01:03:44', 'Current web application (music platform) requires redevelopment. The team will require a graphic designer, front-end developer, and back-end developer. Redevelopment time frame 3-4 weeks. Preference is given to established teams with excellent communication, skills, and commitment to deadlines. <br /><br />\nSkills:<br />\nPhp Frameworks<br />\nStripe Integration<br />\nQR Code integration<br />\nGraphic Design<br />\nSecurity <br /><br />\nRequirements:<br />\nQuality coding<br />\nHigh-end graphics and UI designs<br />\nAPI Integrations <br />\nCode &amp;amp; features improvements<br /><br /><b>Budget</b>: $1,500\n<br /><b>Posted On</b>: August 30, 2018 08:12 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        JavaScript,                     PHP,                     Yii            <br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/Web-App-Development-Team_%7E01d42929b2524ca728?source=rss', 'https://www.upwork.com/jobs/Web-App-Development-Team_%7E01d42929b2524ca728?source=rss'),
(29, 'Build a 1) CRM messaging platform &amp;amp; 2) Build a Hotel Booking Engine', '2018-08-16 04:46:52', 'I am looking for an experienced (10+ years) senior development team who can build two platforms for me.<br />\n1) A CRM platform with email, text, whatsapp and other messaging capabiities.&nbsp;&nbsp;Connect this into sources of data (via APIs), receive the data, database it, parse it and then build logic and decesion-making into the platform to send messages to the right people based on rules.&nbsp;&nbsp;I currently have this entirely built out. I want you to help manage our current development team grow faster.&nbsp;&nbsp;I want you to focus specifically on building the &amp;quot;brain&amp;quot; of the system. We need good logic and analytics to be built.<br /><br />\n2) A Travel Booking Portal (like Booking.com).&nbsp;&nbsp;We already have a basic connected to supplies of inventory (via API) but I want someone who specifically has expertise and experience in this world.<br /><br />\nI will only hire you if you can show me past examples of what you have done.&nbsp;&nbsp;That is a requirement.&nbsp;&nbsp;<br /><br />\nPlease send me demos or links to what you have done.<br /><br />\nOur CRM tech stack:<br />\nLAMP Stack <br />\nYii2 Framework for Server Side coding ( PHP)<br />\nMySQL Database.<br />\nAngularJS/Jquery/HTML5/CSS3 in client side.<br />\nHosted in Amazon Cloud<br />\nIntegrated to Amazon SES,<br /><br /><br /><b>Posted On</b>: August 30, 2018 08:12 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        AngularJS,                     CSS,                     HTML,                     HTML5,                     JavaScript,                     jQuery,                     LAMP Administration,                     MySQL Administration,                     PHP,                     Website Development,                     Yii2            <br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/Build-CRM-messaging-platform-amp-Build-Hotel-Booking-Engine_%7E0102057b695ec39e13?source=rss', 'https://www.upwork.com/jobs/Build-CRM-messaging-platform-amp-Build-Hotel-Booking-Engine_%7E0102057b6...'),
(34, 'Javascript developer to integrate intro.js into PHP app - should be mobile compatible too', '2018-08-30 10:56:54', 'We have web app developed using Yii2 and we&#039;d like to integrate intro.js to tour the key features. Integration is partially done but needs to be completed and make the entire tour compatible with mobile browsers.<br /><br />\nStrong knowledge of JavaScript is needed!<br /><br /><b>Budget</b>: $100\n<br /><b>Posted On</b>: August 30, 2018 08:40 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        CSS,                     HTML5,                     JavaScript,                     Responsive Web Design            <br /><b>Country</b>: Australia<br />click to apply', 'https://www.upwork.com/jobs/Javascript-developer-integrate-intro-into-PHP-app-should-mobile-compatible-too_%7E0179b09acc9e819c48?source=rss', 'https://www.upwork.com/jobs/Javascript-developer-integrate-intro-into-PHP-app-should-mobile-compatib...'),
(35, 'Yii Framework Edit project', '2018-08-16 03:25:05', 'I have a cutlist tool built on Yii Framework that I need some edits made to<br /><br />\n-It has a order and invoice print option --we need to create a packing list option so that it will print the order with Packing List title and no prices showing<br /><br />\n-We need to edit the Order item to add custom notes for product<br /><br />\n-Sticker printing for Products on each order ---&nbsp;&nbsp;Product # - Description - color - customer Name - Order # (ability to not include company name &amp;amp; Order #)<br /><br /><b>Budget</b>: $40\n<br /><b>Posted On</b>: August 30, 2018 08:40 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/Yii-Framework-Edit-project_%7E01e5e6b791df34dace?source=rss', 'https://www.upwork.com/jobs/Yii-Framework-Edit-project_%7E01e5e6b791df34dace?source=rss');
INSERT INTO `upwork` (`id`, `title`, `date`, `description`, `link`, `guid`) VALUES
(36, 'Property Portal Development', '2018-08-29 22:46:49', 'We are looking to develop a rental property portal. <br /><br />\nIt will be rental portal which will register Landlords and Tenants online Basic service only.<br /><br />\nThe developer should have :<br /><br />\n*&nbsp;&nbsp;&nbsp;A deep understanding of the language that the site will be written in. Preferably&nbsp;&nbsp;Php, Laravel Frame work, Ruby on Rails, Yii&nbsp;&nbsp;or&nbsp;&nbsp;Asp.net.<br /><br />\n*&nbsp;&nbsp;&nbsp;&nbsp;Has experience with property portals,&nbsp;&nbsp;have knowledge of plugins for importing properties from third parties, understands how automated feeds from third parties work. <br /><br />\n*&nbsp;&nbsp;&nbsp;Has experience at the server-level. Again, referring to the automated feeds, these things are not only confusing at first but will require sort of work be done on the server itself (changing settings, setting up FTP directories, maintaining and debugging feeds).<br /><br />\nNote:&nbsp;&nbsp;Please only those Developers contact us who have Previously developed rental property portals. GenuIne reference would be necessary.<br /><br />\nOnly contact with fixed pricing.&nbsp;&nbsp;No per hour price required.<br /><br /><b>Budget</b>: $1,000\n<br /><b>Posted On</b>: August 30, 2018 11:00 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        ASP.NET,                     CakePHP,                     CodeIgniter,                     Laravel Framework,                     PHP,                     Ruby on Rails,                     Website Development,                     Yii2            <br /><b>Country</b>: United Kingdom<br />click to apply', 'https://www.upwork.com/jobs/Property-Portal-Development_%7E012286ceba0e766112?source=rss', 'https://www.upwork.com/jobs/Property-Portal-Development_%7E012286ceba0e766112?source=rss'),
(37, 'PHP Developer (Yii) for changing admin part of the site (https://mynameis.travel)', '2018-08-29 20:27:17', 'For &amp;quot;Travel&amp;quot; model we need to develop new reflection in front-end, expanding model with new fields and create new model redactor based on the old version in the backend. (Ukraine, Kiev)<br /><br />\n1. Fix the model for a new display<br />\n2. Write controllers / forms for editing data for a new mapping.<br />\n3. Create a new map for &amp;quot;Travel&amp;quot; in the frontend.<br /><br /><br /><b>Posted On</b>: August 30, 2018 11:00 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web &amp; Mobile Design\n<br /><b>Skills</b>:        CSS3,                     HTML,                     HTML5,                     JavaScript,                     PHP,                     Website Development,                     Yii2            <br /><b>Country</b>: Ukraine<br />click to apply', 'https://www.upwork.com/jobs/PHP-Developer-Yii-for-changing-admin-part-the-site-https-mynameis-travel_%7E0168aa606f4c69df70?source=rss', 'https://www.upwork.com/jobs/PHP-Developer-Yii-for-changing-admin-part-the-site-https-mynameis-travel...'),
(38, 'Looking for Sr.PHP + Javascript(ES6) Developer for Long Term Project', '2018-08-28 22:13:25', 'I&#039;m looking an experienced full-stack developer to assist with complex project.<br />\nYou should have great experience in PHP(yil2, yil1), Javascript(ES6), MySQL, docker experience(currently using docker for developing), chrome extension.<br />\nYou will be required to work at least 40 hours per week.<br />\nPlease attach your code examples(php &amp;amp; js) before submit the proposal.<br /><br /><br /><b>Posted On</b>: August 30, 2018 11:00 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        AngularJS,                     CSS,                     MySQL Programming,                     PHP,                     Yii2            <br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/Looking-for-PHP-Javascript-ES6-Developer-for-Long-Term-Project_%7E0105b67313c1dd5962?source=rss', 'https://www.upwork.com/jobs/Looking-for-PHP-Javascript-ES6-Developer-for-Long-Term-Project_%7E0105b6...'),
(39, 'Yii1, Yii2 Full-stack Developer for Long Term Project', '2018-08-28 19:37:48', 'We are seeking an experienced full-stack developer to assist with a very large and complex project.<br /><br />\nThis is a long-term, full-time position. You must be able to dedicate all of your resources to this job, and ready to start immediately.<br /><br />\nYou will be required to work at least 40hrs / week. <br /><br />\nRequirements are: <br />\n- PHP, Javascript (ES6)<br />\n- Mysql<br />\n- yii2, yii1. (both Yii1 and Yii2 are MUST)<br />\n- docker experience is MUST (we are using docker for developing)<br />\n- experience with developing chrome extensions is HUGE PLUS<br />\n- experience with high load projects&nbsp;&nbsp;is HUGE PLUS<br /><br />\nTo apply for this job please attach your code examples (php &amp;amp; js). Candidates without code examples will not be considered.<br /><br /><br /><b>Posted On</b>: August 30, 2018 11:00 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        CSS3,                     HTML,                     HTML5,                     JavaScript,                     MySQL Administration,                     PHP            <br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/Yii1-Yii2-Full-stack-Developer-for-Long-Term-Project_%7E012197c3e04b9e7723?source=rss', 'https://www.upwork.com/jobs/Yii1-Yii2-Full-stack-Developer-for-Long-Term-Project_%7E012197c3e04b9e77...'),
(40, 'Excellent PHP Programmer', '2018-08-28 19:02:34', 'You are one of the best. <br /><br />\nYou have 10 years experience, have a &amp;quot;Can do&amp;quot; attitude and you get things done. <br />\nYou are delivering value to your clients. <br /><br />\nYou will work 1-2 hours per day. Monday to Friday at the time you want. <br /><br />\nYour skills: <br />\n1. PHP + Yii + MySQL + Javascript + CSS - front-end, back-end, console applications<br />\n2. CentOS/RHEL administration experience - LAMP, monitorix, ansible, bash scripting<br />\n3. Wordpress<br />\n4. Bitbucket + Mercurial as revision control system<br /><br /><br /><b>Posted On</b>: August 30, 2018 11:00 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Other - Software Development\n<br /><b>Skills</b>:        BitBucket,                     CSS,                     LAMP Administration,                     PHP,                     Yii            <br /><b>Country</b>: Switzerland<br />click to apply', 'https://www.upwork.com/jobs/Excellent-PHP-Programmer_%7E01bc17d93bd0b9d08a?source=rss', 'https://www.upwork.com/jobs/Excellent-PHP-Programmer_%7E01bc17d93bd0b9d08a?source=rss'),
(41, 'Framework Developer Needed with Angular Experience', '2018-08-28 18:26:25', 'Looking for YII&nbsp;&nbsp;OR laravel atleast 3 year Experiance Developer .<br /><br />\nEcommerce Experiance with payment gateway Integration <br /><br />\nGitHub Prefered<br /><br /><br /><b>Posted On</b>: August 30, 2018 11:00 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        AngularJS,                     CSS3,                     JavaScript,                     PHP,                     Website Development            <br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/Framework-Developer-Needed-with-Angular-Experience_%7E01d86fb6919f0503ab?source=rss', 'https://www.upwork.com/jobs/Framework-Developer-Needed-with-Angular-Experience_%7E01d86fb6919f0503ab...'),
(42, 'PHP Expert, WordPress Expert - Job Could Lead To USA', '2018-08-28 06:48:37', 'I am looking for an elite web developer.&nbsp;&nbsp;Qualifications are shown below:<br /><br />\n- 10+ Years of PHP of experience.&nbsp;&nbsp;<br />\n- 5+ Years of WordPress of experience.&nbsp;&nbsp;<br />\n- 5+ Years of Yii experience<br />\n- 3+ CakePHP years of experience<br /><br />\nThis job is a full time commitment.&nbsp;&nbsp;We are looking to have someone coincide and assist our onsite full time developer.&nbsp;&nbsp;This job could also eventually lead to a full time opportunity here in the USA.<br /><br />\nThanks.<br /><br /><br /><b>Posted On</b>: August 30, 2018 11:00 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        AngularJS,                     CSS,                     CSS3,                     HTML5,                     JavaScript,                     jQuery,                     MySQL Administration,                     PHP,                     Website Development,                     WordPress            <br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/PHP-Expert-WordPress-Expert-Job-Could-Lead-USA_%7E0102c035b98153dbe0?source=rss', 'https://www.upwork.com/jobs/PHP-Expert-WordPress-Expert-Job-Could-Lead-USA_%7E0102c035b98153dbe0?sou...'),
(43, 'Developer needed to code a simple website', '2018-08-25 10:27:27', 'Hello! I&rsquo;m looking for qualified developer (presumably full stack) to build a website with two pages on the front end and several pages in admin area. <br /><br />\nProject status - specs developed and confirmed, design created and confirmed <br /><br />\nTimeline - no rush for the release but the initial project stage has to be fast paced<br /><br />\nClient info - I will serve as a product owner, I&rsquo;m technically qualified and IT savvy person (there will be no issues with extra requirements or communication)<br />\n^please begin your proposal with phrase &ldquo;Smooth&rdquo; so I can be sure you read all the details^<br /><br />\nTechnology preference - any that would satisfy the functional requirements of the system.<br /><br />\nBudget - fixed; upon project/version completion developer will be provided with extra payment for any additional requirements or system features if above will take place <br /><br />\nOther - trello with specific tasks will be provided, developers showing good proficiency will definitely be appreciated for further cooperation on other projects of mine<br /><br />\nP.S I&rsquo;m Looking for a smooth operator with fluent English or Russian language skills, upon contact all the needed documents will be provided.<br /><br />\nThis job was posted from a mobile device, so please pardon any typos or any missing details.<br /><br /><b>Budget</b>: $300\n<br /><b>Posted On</b>: August 30, 2018 11:00 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        .NET Framework,                     CSS,                     CSS3,                     HTML,                     HTML5,                     JavaScript,                     jQuery,                     MVC Framework,                     PHP,                     Website Development,                     WordPress,                     Yii            <br /><b>Country</b>: China<br />click to apply', 'https://www.upwork.com/jobs/Developer-needed-code-simple-website_%7E01328fd878d392c601?source=rss', 'https://www.upwork.com/jobs/Developer-needed-code-simple-website_%7E01328fd878d392c601?source=rss'),
(44, 'Google Maps API fix for Yii2 Application', '2018-08-24 01:41:45', 'We are seeking a backend developer with experience in Google Places API to fixing an issue with our implementation of Google Places API - Radar Search.<br /><br /><b>Budget</b>: $100\n<br /><b>Posted On</b>: August 30, 2018 11:00 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        Google APIs,                     JavaScript,                     jQuery,                     JSON,                     Yii2            <br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/Google-Maps-API-fix-for-Yii2-Application_%7E014c00cf59111cdeb0?source=rss', 'https://www.upwork.com/jobs/Google-Maps-API-fix-for-Yii2-Application_%7E014c00cf59111cdeb0?source=rs...'),
(45, 'Yii PHP Framework developer', '2018-08-22 22:33:40', 'I&rsquo;m currently looking for experienced Yii PHP Framework developer to add fields to user signup and modify user profile on existing website built Yii PHP Framework (CMS). The modification need to be done at backend and frontend.<br /><br /><b>Budget</b>: $30\n<br /><b>Posted On</b>: August 30, 2018 11:00 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        JavaScript,                     jQuery,                     MySQL Administration,                     PHP,                     Website Development            <br /><b>Country</b>: Ireland<br />click to apply', 'https://www.upwork.com/jobs/Yii-PHP-Framework-developer_%7E013157ed9416dfdbf7?source=rss', 'https://www.upwork.com/jobs/Yii-PHP-Framework-developer_%7E013157ed9416dfdbf7?source=rss'),
(46, 'Developer needed to code a simple website', '2018-08-25 11:27:30', 'Hello! I&rsquo;m looking for qualified developer (presumably full stack) to build a website with two pages on the front end and several pages in admin area. <br /><br />\nProject status - specs developed and confirmed, design created and confirmed <br /><br />\nTimeline - no rush for the release but the initial project stage has to be fast paced<br /><br />\nClient info - I will serve as a product owner, I&rsquo;m technically qualified and IT savvy person (there will be no issues with extra requirements or communication)<br />\n^please begin your proposal with phrase &ldquo;Smooth&rdquo; so I can be sure you read all the details^<br /><br />\nTechnology preference - any that would satisfy the functional requirements of the system.<br /><br />\nBudget - fixed; upon project/version completion developer will be provided with extra payment for any additional requirements or system features if above will take place <br /><br />\nOther - trello with specific tasks will be provided, developers showing good proficiency will definitely be appreciated for further cooperation on other projects of mine<br /><br />\nP.S I&rsquo;m Looking for a smooth operator with fluent English or Russian language skills, upon contact all the needed documents will be provided.<br /><br />\nThis job was posted from a mobile device, so please pardon any typos or any missing details.<br /><br /><b>Budget</b>: $300\n<br /><b>Posted On</b>: August 30, 2018 13:40 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        .NET Framework,                     CSS,                     CSS3,                     HTML,                     HTML5,                     JavaScript,                     jQuery,                     MVC Framework,                     PHP,                     Website Development,                     WordPress,                     Yii            <br /><b>Country</b>: China<br />click to apply', 'https://www.upwork.com/jobs/Developer-needed-code-simple-website_%7E01328fd878d392c601?source=rss', 'https://www.upwork.com/jobs/Developer-needed-code-simple-website_%7E01328fd878d392c601?source=rss'),
(47, 'Strong Middle PHP Backend Developer for creating micro-service - integrating two systems via API', '2018-08-30 19:58:45', 'First stage <br />\n- create independent micro-service with own DB to integrate our system with Spika chat via RestAPI<br />\n- create time tracking module<br />\n- create simple billing system<br />\nFurther long-term partnership<br /><br />\nPreferred technology / experience needed<br />\n- Slim Framework (Yii2 or Laravel are also considered)<br />\n- MySQL<br />\n- AWS<br /><br />\nSuccessful candidate must have following<br />\n- Micro-service development experience<br />\n- Strong communication skills<br />\n- Availability during business hours (not working on other projects in same time)<br />\n- Familiar with Agile, git flow, accurate estimation<br /><br /><br /><b>Posted On</b>: August 30, 2018 14:10 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        Amazon Relational Database Service,                     AWS ECS,                     Docker,                     Microservices,                     MySQL Programming,                     PHP,                     REST,                     Scalable Transaction Processing,                     Swagger            <br /><b>Country</b>: Ukraine<br />click to apply', 'https://www.upwork.com/jobs/Strong-Middle-PHP-Backend-Developer-for-creating-micro-service-integrating-two-systems-via-API_%7E01a0232a385684803c?source=rss', 'https://www.upwork.com/jobs/Strong-Middle-PHP-Backend-Developer-for-creating-micro-service-integrati...'),
(48, 'Strong Middle PHP Backend Developer for creating micro-service - integrating two systems via API', '2018-08-30 20:58:25', 'First stage <br />\n- create independent micro-service with own DB to integrate our system with Spika chat via RestAPI<br />\n- create time tracking module<br />\n- create simple billing system<br />\nFurther long-term partnership<br /><br />\nPreferred technology / experience needed<br />\n- Slim Framework (Yii2 or Laravel are also considered)<br />\n- MySQL<br />\n- AWS<br /><br />\nSuccessful candidate must have following<br />\n- Micro-service development experience<br />\n- Strong communication skills<br />\n- Availability during business hours (not working on other projects in same time)<br />\n- Familiar with Agile, git flow, accurate estimation<br /><br /><br /><b>Posted On</b>: August 30, 2018 15:10 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        Amazon Relational Database Service,                     AWS ECS,                     Docker,                     Microservices,                     MySQL Programming,                     PHP,                     REST,                     Scalable Transaction Processing,                     Swagger            <br /><b>Country</b>: Ukraine<br />click to apply', 'https://www.upwork.com/jobs/Strong-Middle-PHP-Backend-Developer-for-creating-micro-service-integrating-two-systems-via-API_%7E01a0232a385684803c?source=rss', 'https://www.upwork.com/jobs/Strong-Middle-PHP-Backend-Developer-for-creating-micro-service-integrati...'),
(49, 'Rental Platform to Develop', '2018-08-31 16:39:27', 'We are looking to develop a rental platform.<br /><br />\nIt will be rental platform which will register Landlords and Tenants online.<br /><br />\nThe developer should have :<br /><br />\n*&nbsp;&nbsp;&nbsp;A deep understanding of the language that the site will be written in. Preferably&nbsp;&nbsp;Php, Laravel Frame work, Ruby on Rails, Yii&nbsp;&nbsp;or&nbsp;&nbsp;Asp.net.<br /><br />\n*&nbsp;&nbsp;&nbsp;&nbsp;Has experience with property portals,&nbsp;&nbsp;have knowledge of plugins for importing properties from third parties, understands how automated feeds from third parties work. <br /><br />\n*&nbsp;&nbsp;&nbsp;Has experience at the server-level. Again, referring to the automated feeds, these things are not only confusing at first but will require sort of work be done on the server itself (changing settings, setting up FTP directories, maintaining and debugging feeds).<br /><br />\nNote:&nbsp;&nbsp;Please only those Developers contact us who have Previously developed rental property portals. GenuIne reference of previous work in property portal development would be necessary.<br /><br />\nOnly contact with fixed pricing.&nbsp;&nbsp;No per hour price required.<br /><br /><b>Budget</b>: $1,000\n<br /><b>Posted On</b>: August 31, 2018 10:50 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        ASP.NET,                     CakePHP,                     CodeIgniter,                     Laravel Framework,                     PHP,                     Property Development,                     Ruby on Rails,                     Website Development,                     Yii2            <br /><b>Country</b>: United Kingdom<br />click to apply', 'https://www.upwork.com/jobs/Rental-Platform-Develop_%7E012286ceba0e766112?source=rss', 'https://www.upwork.com/jobs/Rental-Platform-Develop_%7E012286ceba0e766112?source=rss'),
(50, 'Need  developer Yii2', '2018-08-31 17:17:26', 'Our team designs and creates a large multifunctional CRM system for real estate agencies<br />\nLooking for a strong development<br /><br />\nRequirements:<br /><br />\n&amp;gt; High skills of php and Yii2<br />\n&amp;gt; sociability<br />\n&amp;gt; teamwork<br />\n&amp;gt; be in touch 8 hours a day<br /><br /><br /><b>Posted On</b>: August 31, 2018 11:30 UTC<br /><b>Category</b>: IT &amp; Networking &gt; ERP / CRM Software\n<br /><b>Skills</b>:        CRM,                     PHP            <br /><b>Country</b>: Russia<br />click to apply', 'https://www.upwork.com/jobs/Need-developer-Yii2_%7E017b2cf36dac848ce6?source=rss', 'https://www.upwork.com/jobs/Need-developer-Yii2_%7E017b2cf36dac848ce6?source=rss'),
(51, 'PHP Developer', '2018-08-31 18:16:45', 'Loading up to +-50 hours in a month;<br />\nSpecify the cost of workhour;<br />\nEnglish level <br />\nWork conditions&nbsp;&nbsp;(number of hours in a week, etc.)<br /><br />\nRequirements:<br />\nPHP 5.6 and above, YII2, MySQL,Javascript;<br />\nto be familiar with bootstrap <br />\nability to work with Linux <br />\nand control system of versions Git<br /><br /><br /><b>Posted On</b>: August 31, 2018 12:20 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        JavaScript,                     MySQL Administration,                     PHP,                     WordPress            <br /><b>Country</b>: Belarus<br />click to apply', 'https://www.upwork.com/jobs/PHP-Developer_%7E014d8fcdd6f268a6db?source=rss', 'https://www.upwork.com/jobs/PHP-Developer_%7E014d8fcdd6f268a6db?source=rss'),
(52, 'clone https://www.winprizesonline.com/', '2018-08-31 18:12:00', 'Hi, I&#039;m looking to clone this web site: https://www.winprizesonline.com/ <br />\nI need admin site to run the site also.<br /><br />\nThe frontend will be Angular 5 (or 6...) <br /><br />\nThe backend will be PHP (I&#039;m checking Yii2 but not sure yet) - open to suggestions <br /><br />\nDB - MySQL - already live in GoDaddy. <br /><br />\nThanks!<br /><br /><br /><b>Posted On</b>: August 31, 2018 12:20 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Ecommerce Development\n<br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/clone-https-www-winprizesonline-com_%7E012b53a23da6ac3939?source=rss', 'https://www.upwork.com/jobs/clone-https-www-winprizesonline-com_%7E012b53a23da6ac3939?source=rss'),
(53, 'Need  developer Yii2', '2018-08-31 18:17:17', 'Our team designs and creates a large multifunctional CRM system for real estate agencies<br />\nLooking for a strong development<br /><br />\nRequirements:<br /><br />\n&amp;gt; High skills of php and Yii2<br />\n&amp;gt; sociability<br />\n&amp;gt; teamwork<br />\n&amp;gt; be in touch 8 hours a day<br /><br /><br /><b>Posted On</b>: August 31, 2018 12:30 UTC<br /><b>Category</b>: IT &amp; Networking &gt; ERP / CRM Software\n<br /><b>Skills</b>:        CRM,                     PHP            <br /><b>Country</b>: Russia<br />click to apply', 'https://www.upwork.com/jobs/Need-developer-Yii2_%7E017b2cf36dac848ce6?source=rss', 'https://www.upwork.com/jobs/Need-developer-Yii2_%7E017b2cf36dac848ce6?source=rss'),
(54, 'Need developer Yii2', '2018-08-31 19:26:50', 'Our team designs and creates a large multifunctional CRM system for real estate agencies Looking for a strong development Requirements: &amp;gt; High skills of php and Yii2 &amp;gt; sociability &amp;gt; teamwork &amp;gt; be in touch 8 hours a day<br /><br /><br /><b>Posted On</b>: August 31, 2018 13:30 UTC<br /><b>Category</b>: IT &amp; Networking &gt; ERP / CRM Software\n<br /><b>Skills</b>:        CRM,                     JavaScript,                     PHP            <br /><b>Country</b>: Ukraine<br />click to apply', 'https://www.upwork.com/jobs/Need-developer-Yii2_%7E0151cdc2aa657f63fa?source=rss', 'https://www.upwork.com/jobs/Need-developer-Yii2_%7E0151cdc2aa657f63fa?source=rss'),
(55, 'PHP Developer', '2018-08-31 19:16:36', 'Loading up to +-50 hours in a month;<br />\nSpecify the cost of workhour;<br />\nEnglish level <br />\nWork conditions&nbsp;&nbsp;(number of hours in a week, etc.)<br /><br />\nRequirements:<br />\nPHP 5.6 and above, YII2, MySQL,Javascript;<br />\nto be familiar with bootstrap <br />\nability to work with Linux <br />\nand control system of versions Git<br /><br /><br /><b>Posted On</b>: August 31, 2018 13:30 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        JavaScript,                     MySQL Administration,                     PHP,                     WordPress            <br /><b>Country</b>: Belarus<br />click to apply', 'https://www.upwork.com/jobs/PHP-Developer_%7E014d8fcdd6f268a6db?source=rss', 'https://www.upwork.com/jobs/PHP-Developer_%7E014d8fcdd6f268a6db?source=rss'),
(56, 'Google Maps API fix for Yii2 Application', '2018-08-24 02:41:46', 'We are seeking a backend developer with experience in Google Places API to fixing an issue with our implementation of Google Places API - Radar Search.<br /><br /><b>Budget</b>: $100\n<br /><b>Posted On</b>: August 31, 2018 17:40 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        Google APIs,                     JavaScript,                     jQuery,                     JSON,                     Yii2            <br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/Google-Maps-API-fix-for-Yii2-Application_%7E014c00cf59111cdeb0?source=rss', 'https://www.upwork.com/jobs/Google-Maps-API-fix-for-Yii2-Application_%7E014c00cf59111cdeb0?source=rs...'),
(57, 'Convert an existing Yii2 system into SaaS/Multitenant along with recurrent billing/online payments', '2018-09-01 01:04:18', 'Hello,<br /><br />\nWe have a unique and powerful property management system that has been built with care &amp;amp; passion. We&#039;re currently expanding and looking to partner with a decent agency that can handle the project management and future technical development so we can focus on the business side.<br /><br />\nWe&#039;re looking to convert our existing (Yii2) system into a SaaS/Multitenant platform which will require:<br /><br />\n1- Online payment / recurrent billing: Configure the main (Drupal) website to display subscription plans, and accept online payments.<br /><br />\n2- Automate instance/subdomain creation: Configure the Yii2 system Database and Server to support multitenants or accounts, where each account has a unique subdomain.<br /><br />\n3- Update the existing mobile app to support multitenant customizations: mainly user custom logo and theme colors. <br /><br />\nSimilar sites to look at:<br />\nhttps://www.tenantcloud.com/landlord<br />\nhttps://www.buildium.com/<br /><br />\nIdeally, we&#039;re looking to have a long-term relationship with an agency that can provide the following:<br /><br />\n1- Outstanding UI/UX Design<br />\n2- Strong and proven experience with Yii2 and Drupal development<br />\n3- Customer Technical Support<br />\n4- iOS/Android development<br />\n5- Valuable technical suggestions and recommendations<br /><br />\n** Odoo experience is a huge plus, but not necessary!<br /><br />\nWe&#039;re looking to do the SaaS setup as fixed-price project and have the future project development and customer support per hour with an agreed upon flat rate.<br /><br />\nPlease make sure to provide us with your portfolio and your company information in order for us to evaluate and consider your application.<br /><br />\nThanks<br /><br /><b>Budget</b>: $2,500\n<br /><b>Posted On</b>: August 31, 2018 19:10 UTC<br /><b>Category</b>: IT &amp; Networking &gt; Network &amp; System Administration\n<br /><b>Skills</b>:        Android,                     Drupal,                     iOS Development,                     Linux System Administration,                     MySQL Administration,                     Network Security,                     PHP,                     System Administration,                     Yii2            <br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/Convert-existing-Yii2-system-into-SaaS-Multitenant-along-with-recurrent-billing-online-payments_%7E01b8786d3f387fa24e?source=rss', 'https://www.upwork.com/jobs/Convert-existing-Yii2-system-into-SaaS-Multitenant-along-with-recurrent-...'),
(58, 'Convert an existing Yii2 system into SaaS/Multitenant along with recurrent billing/online payments', '2018-09-01 01:13:23', 'Hello,<br /><br />\nWe have a unique and powerful property management system that has been built with care &amp;amp; passion. We&#039;re currently expanding and looking to hire a decent agency that can handle the project management and future technical development &amp;amp; design so we can focus on the business side.<br /><br />\nWe&#039;re looking to convert our existing (Yii2) system into a SaaS/Multitenant platform which will require:<br /><br />\n1- Online payment / recurrent billing: Configure the main (Drupal) website to display subscription plans, and accept online payments.<br /><br />\n2- Automate instance/subdomain creation: Configure the Yii2 system Database and Server to support multitenants or accounts, where each account has a unique subdomain.<br /><br />\n3- Update the existing mobile app to support multitenant customizations: mainly user custom logo and theme colors. <br /><br />\nSimilar sites to look at:<br />\nhttps://www.tenantcloud.com/landlord<br />\nhttps://www.buildium.com/<br /><br />\nIdeally, we&#039;re looking to have a long-term relationship with an agency that can provide the following:<br /><br />\n1- Outstanding UI/UX Design<br />\n2- Strong and proven experience with Yii2 and Drupal development<br />\n3- Customer Technical Support<br />\n4- iOS/Android development<br />\n5- Valuable technical suggestions and recommendations<br /><br />\n** Odoo experience is a huge plus, but not necessary!<br /><br />\nWe&#039;re looking to do the SaaS setup as fixed-price project and have the future project development and customer support per hour with an agreed upon flat rate.<br /><br />\nPlease make sure to provide us with your portfolio and your company information in order for us to evaluate and consider your application.<br /><br />\nThanks<br /><br /><b>Budget</b>: $2,500\n<br /><b>Posted On</b>: August 31, 2018 19:20 UTC<br /><b>Category</b>: IT &amp; Networking &gt; Network &amp; System Administration\n<br /><b>Skills</b>:        Android,                     Drupal,                     iOS Development,                     Linux System Administration,                     MySQL Administration,                     Network Security,                     PHP,                     System Administration,                     Yii2            <br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/Convert-existing-Yii2-system-into-SaaS-Multitenant-along-with-recurrent-billing-online-payments_%7E01b8786d3f387fa24e?source=rss', 'https://www.upwork.com/jobs/Convert-existing-Yii2-system-into-SaaS-Multitenant-along-with-recurrent-...'),
(59, 'Convert an existing Yii2 system into SaaS/Multitenant along with recurrent billing/online payments', '2018-09-01 01:16:05', 'Hello,<br /><br />\nWe have a unique and powerful property management system that has been built with care &amp;amp; passion. We&#039;re currently expanding and looking to hire a decent agency that can handle the project management and future technical development &amp;amp; design so we can focus on the business side.<br /><br />\nWe&#039;re looking to convert our existing (Yii2) system into a SaaS/Multitenant platform which will require:<br /><br />\n1- Online payment / recurrent billing: Configure the main (Drupal) website to display subscription plans, and accept online payments.<br /><br />\n2- Automate instance/subdomain creation: Configure the Yii2 system Database and Server to support multitenants or accounts, where each account has a unique subdomain.<br /><br />\n3- Update the existing mobile app to support multitenant customizations: mainly user custom logo and theme colors. <br /><br />\nSimilar sites to look at:<br />\nhttps://www.tenantcloud.com/landlord<br />\nhttps://www.buildium.com/<br /><br />\nIdeally, we&#039;re looking to have a long-term relationship with an agency that can provide the following:<br /><br />\n1- Outstanding UI/UX Design<br />\n2- Strong and proven experience with Yii2 and Drupal development<br />\n3- Customer Technical Support<br />\n4- iOS/Android development<br />\n5- Valuable technical suggestions and recommendations<br /><br />\n** Odoo experience is a huge plus, but not necessary!<br /><br />\nWe&#039;re looking to do the SaaS setup as fixed-price project and have the future project development and customer support per hour with an agreed upon flat rate.<br /><br />\nPlease make sure to provide us with your portfolio and your company information in order for us to evaluate and consider your application.<br /><br />\nThanks<br /><br /><b>Budget</b>: $2,500\n<br /><b>Posted On</b>: August 31, 2018 19:30 UTC<br /><b>Category</b>: IT &amp; Networking &gt; Network &amp; System Administration\n<br /><b>Skills</b>:        Android,                     Drupal,                     iOS Development,                     Linux System Administration,                     MySQL Administration,                     Network Security,                     PHP,                     System Administration,                     Yii2            <br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/Convert-existing-Yii2-system-into-SaaS-Multitenant-along-with-recurrent-billing-online-payments_%7E01b8786d3f387fa24e?source=rss', 'https://www.upwork.com/jobs/Convert-existing-Yii2-system-into-SaaS-Multitenant-along-with-recurrent-...'),
(60, 'Convert an existing Yii2 system into SaaS/Multitenant along with recurrent billing/online payments', '2018-09-01 02:03:56', 'Hello,<br /><br />\nWe have a unique and powerful property management system that has been built with care &amp;amp; passion. We&#039;re currently expanding and looking to hire a decent agency that can handle the project management and future technical development &amp;amp; design so we can focus on the business side.<br /><br />\nWe&#039;re looking to convert our existing (Yii2) system into a SaaS/Multitenant platform which will require:<br /><br />\n1- Online payment / recurrent billing: Configure the main (Drupal) website to display subscription plans, and accept online payments.<br /><br />\n2- Automate instance/subdomain creation: Configure the Yii2 system Database and Server to support multitenants or accounts, where each account has a unique subdomain.<br /><br />\n3- Update the existing mobile app to support multitenant customizations: mainly user custom logo and theme colors. <br /><br />\nSimilar sites to look at:<br />\nhttps://www.tenantcloud.com/landlord<br />\nhttps://www.buildium.com/<br /><br />\nIdeally, we&#039;re looking to have a long-term relationship with an agency that can provide the following:<br /><br />\n1- Outstanding UI/UX Design<br />\n2- Strong and proven experience with Yii2 and Drupal development<br />\n3- Customer Technical Support<br />\n4- iOS/Android development<br />\n5- Valuable technical suggestions and recommendations<br /><br />\n** Odoo experience is a huge plus, but not necessary!<br /><br />\nWe&#039;re looking to do the SaaS setup as fixed-price project and have the future project development and customer support per hour with an agreed upon flat rate.<br /><br />\nPlease make sure to provide us with your portfolio and your company information in order for us to evaluate and consider your application.<br /><br />\nThanks<br /><br /><b>Budget</b>: $2,500\n<br /><b>Posted On</b>: August 31, 2018 20:10 UTC<br /><b>Category</b>: IT &amp; Networking &gt; Network &amp; System Administration\n<br /><b>Skills</b>:        Android,                     Drupal,                     iOS Development,                     Linux System Administration,                     MySQL Administration,                     Network Security,                     PHP,                     System Administration,                     Yii2            <br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/Convert-existing-Yii2-system-into-SaaS-Multitenant-along-with-recurrent-billing-online-payments_%7E01b8786d3f387fa24e?source=rss', 'https://www.upwork.com/jobs/Convert-existing-Yii2-system-into-SaaS-Multitenant-along-with-recurrent-...'),
(61, 'Convert an existing Yii2 system into SaaS/Multitenant along with recurrent billing/online payments', '2018-09-01 02:52:53', 'Hello,<br /><br />\nWe have a unique and powerful property management system that has been built with care &amp;amp; passion. We&#039;re currently expanding and looking to hire a decent agency that can handle the project management and future technical development &amp;amp; design so we can focus on the business side.<br /><br />\nWe&#039;re looking to convert our existing (Yii2) system into a SaaS/Multitenant platform which will require:<br /><br />\n1- Online payment / recurrent billing: Configure the main (Drupal) website to display subscription plans, and accept online payments.<br /><br />\n2- Automate instance/subdomain creation: Configure the Yii2 system Database and Server to support multitenants or accounts, where each account has a unique subdomain.<br /><br />\n3- Update the existing mobile app to support multitenant customizations: mainly user custom logo and theme colors. <br /><br />\nSimilar sites to look at:<br />\nhttps://www.tenantcloud.com/landlord<br />\nhttps://www.buildium.com/<br /><br />\nIdeally, we&#039;re looking to have a long-term relationship with an agency that can provide the following:<br /><br />\n1- Outstanding UI/UX Design<br />\n2- Strong and proven experience with Yii2 and Drupal development<br />\n3- Customer Technical Support<br />\n4- iOS/Android development<br />\n5- Valuable technical suggestions and recommendations<br /><br />\n** Odoo experience is a huge plus, but not necessary!<br /><br />\nWe&#039;re looking to do the SaaS setup as fixed-price project and have the future project development and customer support per hour with an agreed upon flat rate.<br /><br />\nPlease make sure to provide us with your portfolio and your company information in order for us to evaluate and consider your application.<br /><br />\nThanks<br /><br /><b>Budget</b>: $2,500\n<br /><b>Posted On</b>: August 31, 2018 21:00 UTC<br /><b>Category</b>: IT &amp; Networking &gt; Network &amp; System Administration\n<br /><b>Skills</b>:        Android,                     Drupal,                     iOS Development,                     Linux System Administration,                     MySQL Administration,                     Network Security,                     PHP,                     System Administration,                     Yii2            <br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/Convert-existing-Yii2-system-into-SaaS-Multitenant-along-with-recurrent-billing-online-payments_%7E01b8786d3f387fa24e?source=rss', 'https://www.upwork.com/jobs/Convert-existing-Yii2-system-into-SaaS-Multitenant-along-with-recurrent-...'),
(62, 'YII Security Patches and Updates ...', '2018-09-02 21:23:39', 'I need my YII site security upgraded - its not secure right now and I need it patched up today and a few scripts changed so users do not get a message in their browser bar saying the site is not secure. Need to get it done in the next 24 hours - a simple job for a coder that has worked with YII before I think.<br /><br /><b>Budget</b>: $100\n<br /><b>Posted On</b>: September 02, 2018 15:30 UTC<br /><b>Category</b>: IT &amp; Networking &gt; Information Security\n<br /><b>Skills</b>:        Security Analysis            <br /><b>Country</b>: Ukraine<br />click to apply', 'https://www.upwork.com/jobs/YII-Security-Patches-and-Updates_%7E010a6f1dcc603ae389?source=rss', 'https://www.upwork.com/jobs/YII-Security-Patches-and-Updates_%7E010a6f1dcc603ae389?source=rss'),
(63, 'YII Security Patches and Updates ...', '2018-09-02 22:23:29', 'I need my YII site security upgraded - its not secure right now and I need it patched up today and a few scripts changed so users do not get a message in their browser bar saying the site is not secure. Need to get it done in the next 24 hours - a simple job for a coder that has worked with YII before I think.<br /><br /><b>Budget</b>: $100\n<br /><b>Posted On</b>: September 02, 2018 16:30 UTC<br /><b>Category</b>: IT &amp; Networking &gt; Information Security\n<br /><b>Skills</b>:        Security Analysis            <br /><b>Country</b>: Ukraine<br />click to apply', 'https://www.upwork.com/jobs/YII-Security-Patches-and-Updates_%7E010a6f1dcc603ae389?source=rss', 'https://www.upwork.com/jobs/YII-Security-Patches-and-Updates_%7E010a6f1dcc603ae389?source=rss'),
(64, 'Need Yii V1 &amp;amp; V2, Expert with AngularJS,AWS Experience to convert my website from existing WordPress', '2018-09-02 22:56:05', 'Looking for a expert Yii Full Stack developer with an ongoing project. with excellent knowledge of Yii V1/V2, PHP, MySQL, GIT, AWS, AngularJS 2/3,&nbsp;&nbsp;html5, css3<br />\nYou must have atleast 3 years experience, should be available to work 2-4 hours/day. I am looking for freelance individuals. Ecommerce payment gateway Integration Experiance with GitHub prefered.<br />\nStart up task is to fix some issues in design and deployment. Facebook and Google login, Need to discuss how the new pages structure and the home page will. We will discuss the details in detail after a preliminary agreement. After that, if this goes good will have some other tasks to set. We will follow a someone agile approach here in terms of thinking about the feature story and then breaking it down to details .<br /><br />\nRequired Experience, Skills &amp;amp; Qualifications :-<br />\n* Yii V1 &amp;amp; V2<br />\n* MySQL Programming<br />\n* AngularJS 3<br />\n* Javascript/Jquery<br />\n* HTML/CSS/Bootstrap<br />\n* AWS<br />\n* Rest API in&nbsp;&nbsp;Yii<br />\n* GIT<br />\n* Server Support<br />\n* SEO Skills<br />\n* Experience in handling third part APIs <br /><br />\nAdded Responsibility :-<br />\n* Good Communication Skills<br />\n* Pro-activity Responsibile<br />\n* Well-organize in Time deadlines<br />\n* Organized Code<br />\n* Available 4 hours a day<br />\n* Create and maintain software documentation<br /><br /><br /><b>Posted On</b>: September 02, 2018 17:00 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        AngularJS,                     AWS ECS,                     Bootstrap,                     CSS3,                     HTML,                     HTML5,                     JavaScript,                     jQuery,                     PHP,                     Yii,                     Yii2            <br /><b>Country</b>: Thailand<br />click to apply', 'https://www.upwork.com/jobs/Need-Yii-amp-Expert-with-AngularJS-AWS-Experience-convert-website-from-existing-WordPress_%7E01f9bee0f96a95e3c7?source=rss', 'https://www.upwork.com/jobs/Need-Yii-amp-Expert-with-AngularJS-AWS-Experience-convert-website-from-e...'),
(65, 'Yii Expert,  Convert  HOME LANDING PAGE to Wordpress, Only', '2018-09-02 22:55:33', 'Expert needed in htaccess, Yii, wordpress,&nbsp;&nbsp;to make my HOME PAGE ONLY&nbsp;&nbsp;from Yii&nbsp;&nbsp;to Wordpress.<br /><br />\nRest of site stays&nbsp;&nbsp;in&nbsp;&nbsp;Yii.<br /><br />\nThe home page needs to have the top header bar the same&nbsp;&nbsp;with the login.<br /><br />\nHere is a video. (link removed)<br /><br />\nAlso need a fix for Facebook login-- which does not work.<br /><br /><br /><b>Posted On</b>: September 02, 2018 17:00 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/Yii-Expert-Convert-HOME-LANDING-PAGE-Wordpress-Only_%7E01444a94805e66710f?source=rss', 'https://www.upwork.com/jobs/Yii-Expert-Convert-HOME-LANDING-PAGE-Wordpress-Only_%7E01444a94805e66710...'),
(66, 'Yii Expert Change Index.php  from  yii  to wordpress', '2018-09-02 23:33:42', 'Expert needed in htaccess, Yii, wordpress,&nbsp;&nbsp;to make my HOME PAGE ONLY&nbsp;&nbsp;from Yii&nbsp;&nbsp;to Wordpress.<br /><br />\nRest of site stays&nbsp;&nbsp;in&nbsp;&nbsp;Yii.<br /><br />\nThe home page needs to have the top header bar the same&nbsp;&nbsp;with the login.<br /><br />\nHere is a video.&nbsp;&nbsp;<br /><br />\nSee the PPT <br /><br />\nhttps://www.dropbox.com/s/qtesxzznbb3bj6f/YII%20%20home%20page.pptx?dl=0<br /><br /><br />\nChange Index.php&nbsp;&nbsp;from&nbsp;&nbsp;yii&nbsp;&nbsp;to wordpress<br />\nKeep the menu and SSO login on top as it is now &ndash; we have code for this at http://florida.com/blog&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a wordpress install<br />\nAll urls must remain same.<br />\nMust install on local server&nbsp;&nbsp;from bitbucket.<br />\nSite&nbsp;&nbsp;has elastic search.<br />\nI will give you the DB dump<br />\nYou do NOT have to install a new wordpress or design the new index.php. It exists in http://florida.com/home&nbsp;&nbsp;that is a SAMPLE&nbsp;&nbsp;only. The menu is NON functional image placeholder.<br />\nNeed to discuss how the new other pages that we create in WP, what will be the url structure, other than the home page. See # 10<br />\nFB&nbsp;&nbsp;signup and login&nbsp;&nbsp;doesn&rsquo;t work<br />\nNEW pages from BOTH WP&nbsp;&nbsp;and Yii,&nbsp;&nbsp;will be&nbsp;&nbsp;http://florida.com/new-wordpress-page and be&nbsp;&nbsp;http://florida.com/new-yii-page <br /><br /><br />\nChange Index.php from yii to wordpress Keep the menu and SSO login on top as it is now &ndash; we have code for this at http://florida.com/blog a wordpress install All urls must remain same. Must install on local server from bitbucket. Site has elastic search. I will give you the DB dump You do NOT have to install a new wordpress or design the new index.php. It exists in http://florida.com/home that is a SAMPLE only. The menu is NON functional image placeholder. Need to discuss how the new other pages that we create in WP, what will be the url structure, other than the home page. See # 10 FB signup and login doesn&rsquo;t work NEW pages from BOTH WP and Yii, will be http://florida.com/new-wordpress-page and be http://florida.com/new-yii-page<br /><br /><b>Budget</b>: $180\n<br /><b>Posted On</b>: September 02, 2018 17:40 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/Yii-Expert-Change-Index-php-from-yii-wordpress_%7E01adc11a9a90eb168c?source=rss', 'https://www.upwork.com/jobs/Yii-Expert-Change-Index-php-from-yii-wordpress_%7E01adc11a9a90eb168c?sou...'),
(67, 'Yii Expert Change Index.php  from  yii  to wordpress', '2018-09-02 23:40:58', 'Expert needed in htaccess, Yii, wordpress,&nbsp;&nbsp;to make my HOME PAGE ONLY&nbsp;&nbsp;from Yii&nbsp;&nbsp;to Wordpress.<br /><br />\nRest of site stays&nbsp;&nbsp;in&nbsp;&nbsp;Yii.<br /><br />\nThe home page needs to have the top header bar the same&nbsp;&nbsp;with the login.<br /><br /><br /><br />\nSee the PPT <br /><br />\nhttps://www.dropbox.com/s/qtesxzznbb3bj6f/YII%20%20home%20page.pptx?dl=0<br /><br /><br />\nChange Index.php&nbsp;&nbsp;from&nbsp;&nbsp;yii&nbsp;&nbsp;to wordpress<br /><br />\nKeep the menu and SSO login on top as it is now &ndash; we have code for this at http://florida.com/blog&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a wordpress install<br /><br />\nAll urls must remain same.<br /><br />\nMust install on local server&nbsp;&nbsp;from bitbucket. You must show me it working on your local server.<br /><br />\nSite&nbsp;&nbsp;has elastic search.<br /><br />\nI will give you the DB dump<br /><br />\nYou do NOT have to install a new wordpress or design the new index.php. It exists in http://florida.com/home&nbsp;&nbsp;that is a SAMPLE&nbsp;&nbsp;only. The menu is NON functional image placeholder.<br /><br />\nNeed to discuss how the new other pages that we create in WP, what will be the url structure, other than the home page. See below<br /><br />\nFB&nbsp;&nbsp;signup and login&nbsp;&nbsp;doesn&rsquo;t work<br /><br />\nNEW pages from BOTH WP&nbsp;&nbsp;and Yii,&nbsp;&nbsp;will be&nbsp;&nbsp;http://florida.com/new-wordpress-page and be&nbsp;&nbsp;http://florida.com/new-yii-page <br /><br /><br />\nDo not bid on this job unless you can do exactly&nbsp;&nbsp;like&nbsp;&nbsp;I wrote above, and exactly as depicted in&nbsp;&nbsp;PPT.<br /><br />\nIf you deviate from this then you will have to cancel the job on your own.<br /><br /><b>Budget</b>: $180\n<br /><b>Posted On</b>: September 02, 2018 17:50 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/Yii-Expert-Change-Index-php-from-yii-wordpress_%7E01adc11a9a90eb168c?source=rss', 'https://www.upwork.com/jobs/Yii-Expert-Change-Index-php-from-yii-wordpress_%7E01adc11a9a90eb168c?sou...');
INSERT INTO `upwork` (`id`, `title`, `date`, `description`, `link`, `guid`) VALUES
(68, 'Need Yii V1 &amp;amp; V2, Expert with AngularJS,AWS Experience to convert my website from existing WordPress', '2018-09-02 23:55:54', 'Looking for a expert Yii Full Stack developer with an ongoing project. with excellent knowledge of Yii V1/V2, PHP, MySQL, GIT, AWS, AngularJS 2/3,&nbsp;&nbsp;html5, css3<br />\nYou must have atleast 3 years experience, should be available to work 2-4 hours/day. I am looking for freelance individuals. Ecommerce payment gateway Integration Experiance with GitHub prefered.<br />\nStart up task is to fix some issues in design and deployment. Facebook and Google login, Need to discuss how the new pages structure and the home page will. We will discuss the details in detail after a preliminary agreement. After that, if this goes good will have some other tasks to set. We will follow a someone agile approach here in terms of thinking about the feature story and then breaking it down to details .<br /><br />\nRequired Experience, Skills &amp;amp; Qualifications :-<br />\n* Yii V1 &amp;amp; V2<br />\n* MySQL Programming<br />\n* AngularJS 3<br />\n* Javascript/Jquery<br />\n* HTML/CSS/Bootstrap<br />\n* AWS<br />\n* Rest API in&nbsp;&nbsp;Yii<br />\n* GIT<br />\n* Server Support<br />\n* SEO Skills<br />\n* Experience in handling third part APIs <br /><br />\nAdded Responsibility :-<br />\n* Good Communication Skills<br />\n* Pro-activity Responsibile<br />\n* Well-organize in Time deadlines<br />\n* Organized Code<br />\n* Available 4 hours a day<br />\n* Create and maintain software documentation<br /><br /><br /><b>Posted On</b>: September 02, 2018 18:10 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        AngularJS,                     AWS ECS,                     Bootstrap,                     CSS3,                     HTML,                     HTML5,                     JavaScript,                     jQuery,                     PHP,                     Yii,                     Yii2            <br /><b>Country</b>: Thailand<br />click to apply', 'https://www.upwork.com/jobs/Need-Yii-amp-Expert-with-AngularJS-AWS-Experience-convert-website-from-existing-WordPress_%7E01f9bee0f96a95e3c7?source=rss', 'https://www.upwork.com/jobs/Need-Yii-amp-Expert-with-AngularJS-AWS-Experience-convert-website-from-e...'),
(69, 'Yii Expert Change Index.php  from  yii  to wordpress', '2018-09-03 00:31:34', 'Expert needed in htaccess, Yii, wordpress,&nbsp;&nbsp;to make my HOME PAGE ONLY&nbsp;&nbsp;from Yii&nbsp;&nbsp;to Wordpress.<br /><br />\nRest of site stays&nbsp;&nbsp;in&nbsp;&nbsp;Yii.<br /><br />\nThe home page needs to have the top header bar the same&nbsp;&nbsp;with the login.<br /><br /><br /><br />\nSee the PPT <br /><br />\nhttps://www.dropbox.com/s/qtesxzznbb3bj6f/YII%20%20home%20page.pptx?dl=0<br /><br /><br />\nChange Index.php&nbsp;&nbsp;from&nbsp;&nbsp;yii&nbsp;&nbsp;to wordpress<br /><br />\nKeep the menu and SSO login on top as it is now &ndash; we have code for this at http://florida.com/blog&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a wordpress install<br /><br />\nAll urls must remain same.<br /><br />\nMust install on local server&nbsp;&nbsp;from bitbucket. You must show me it working on your local server.<br /><br />\nSite&nbsp;&nbsp;has elastic search.<br /><br />\nI will give you the DB dump<br /><br />\nYou do NOT have to install a new wordpress or design the new index.php. It exists in http://florida.com/home&nbsp;&nbsp;that is a SAMPLE&nbsp;&nbsp;only. The menu is NON functional image placeholder.<br /><br />\nNeed to discuss how the new other pages that we create in WP, what will be the url structure, other than the home page. See below<br /><br />\nFB&nbsp;&nbsp;signup and login&nbsp;&nbsp;doesn&rsquo;t work<br /><br />\nNEW pages from BOTH WP&nbsp;&nbsp;and Yii,&nbsp;&nbsp;will be&nbsp;&nbsp;http://florida.com/new-wordpress-page and be&nbsp;&nbsp;http://florida.com/new-yii-page <br /><br /><br />\nDo not bid on this job unless you can do exactly&nbsp;&nbsp;like&nbsp;&nbsp;I wrote above, and exactly as depicted in&nbsp;&nbsp;PPT.<br /><br />\nIf you deviate from this then you will have to cancel the job on your own.<br /><br /><b>Budget</b>: $180\n<br /><b>Posted On</b>: September 02, 2018 18:40 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/Yii-Expert-Change-Index-php-from-yii-wordpress_%7E01adc11a9a90eb168c?source=rss', 'https://www.upwork.com/jobs/Yii-Expert-Change-Index-php-from-yii-wordpress_%7E01adc11a9a90eb168c?sou...'),
(70, 'FullStack Developer', '2018-09-03 07:15:24', 'I have a programmer who gives me the source code as he develops. But<br />\nI need to ensure the code is patent (working). Since I do not program, I need someone else to do the verification portion.:)<br /><br />\nSo we are looking for a &amp;quot;Fullstack Developer&amp;quot; who can &amp;quot;review<br />\ncode&amp;quot; and install and host other programmer&#039;s packages (finished work), I<br />\nam looking for one of these.<br /><br />\n- Developed with Yii 2 framework. <br /><br />\nFeel free to ask more question.<br /><br /><br /><b>Posted On</b>: September 03, 2018 01:20 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Country</b>: Philippines<br />click to apply', 'https://www.upwork.com/jobs/FullStack-Developer_%7E019a642142f96d2a4b?source=rss', 'https://www.upwork.com/jobs/FullStack-Developer_%7E019a642142f96d2a4b?source=rss'),
(71, 'FullStack Developer', '2018-09-03 08:15:02', 'I have a programmer who gives me the source code as he develops. But<br />\nI need to ensure the code is patent (working). Since I do not program, I need someone else to do the verification portion.:)<br /><br />\nSo we are looking for a &amp;quot;Fullstack Developer&amp;quot; who can &amp;quot;review<br />\ncode&amp;quot; and install and host other programmer&#039;s packages (finished work), I<br />\nam looking for one of these.<br /><br />\n- Developed with Yii 2 framework. <br /><br />\nFeel free to ask more question.<br /><br /><br /><b>Posted On</b>: September 03, 2018 02:20 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Country</b>: Philippines<br />click to apply', 'https://www.upwork.com/jobs/FullStack-Developer_%7E019a642142f96d2a4b?source=rss', 'https://www.upwork.com/jobs/FullStack-Developer_%7E019a642142f96d2a4b?source=rss'),
(72, 'Junior on-site PHP Developer with Yii experience', '2018-09-03 10:28:50', 'We have been building an online project portfolio management suite over the past few years. It has been going well and now we need to add a number of modules in a short space of time and our head developer is a little over whelmed, so we would like to hire a junior developer to work very closely with him in order to get through the workload over the next two to three months.<br /><br />\nWe use PHP/MySQL, on the Yii framework and do a lot of hand-coding.<br /><br />\nExperience with web security or AWS hosting would be beneficial, but not required.<br /><br />\nIf you&#039;re up to it, please put forward a proposal and we can chat about it in more detail.<br /><br />\nNOTE: Must be available to work on-site in Manila, Philippines.<br /><br /><br /><b>Posted On</b>: September 03, 2018 04:40 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        MySQL Administration,                     PHP,                     Yii            <br /><b>Country</b>: Philippines<br />click to apply', 'https://www.upwork.com/jobs/Junior-site-PHP-Developer-with-Yii-experience_%7E017f68fc238066131a?source=rss', 'https://www.upwork.com/jobs/Junior-site-PHP-Developer-with-Yii-experience_%7E017f68fc238066131a?sour...'),
(73, 'Junior on-site PHP Developer with Yii experience', '2018-09-03 11:28:46', 'We have been building an online project portfolio management suite over the past few years. It has been going well and now we need to add a number of modules in a short space of time and our head developer is a little over whelmed, so we would like to hire a junior developer to work very closely with him in order to get through the workload over the next two to three months.<br /><br />\nWe use PHP/MySQL, on the Yii framework and do a lot of hand-coding.<br /><br />\nExperience with web security or AWS hosting would be beneficial, but not required.<br /><br />\nIf you&#039;re up to it, please put forward a proposal and we can chat about it in more detail.<br /><br />\nNOTE: Must be available to work on-site in Manila, Philippines.<br /><br /><br /><b>Posted On</b>: September 03, 2018 05:40 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        MySQL Administration,                     PHP,                     Yii            <br /><b>Country</b>: Philippines<br />click to apply', 'https://www.upwork.com/jobs/Junior-site-PHP-Developer-with-Yii-experience_%7E017f68fc238066131a?source=rss', 'https://www.upwork.com/jobs/Junior-site-PHP-Developer-with-Yii-experience_%7E017f68fc238066131a?sour...'),
(74, 'YII Security Patches and Updates ...', '2018-09-03 14:04:13', 'I need my YII site security upgraded - its not secure right now and I need it patched up today and a few scripts changed so users do not get a message in their browser bar saying the site is not secure. Need to get it done in the next 24 hours - a simple job for a coder that has worked with YII before I think.<br /><br /><b>Budget</b>: $100\n<br /><b>Posted On</b>: September 03, 2018 08:10 UTC<br /><b>Category</b>: IT &amp; Networking &gt; Information Security\n<br /><b>Skills</b>:        Security Analysis            <br /><b>Country</b>: Ukraine<br />click to apply', 'https://www.upwork.com/jobs/YII-Security-Patches-and-Updates_%7E0145d1ff9e264e1284?source=rss', 'https://www.upwork.com/jobs/YII-Security-Patches-and-Updates_%7E0145d1ff9e264e1284?source=rss'),
(75, 'YII Security Patches and Updates ...', '2018-09-03 15:04:06', 'I need my YII site security upgraded - its not secure right now and I need it patched up today and a few scripts changed so users do not get a message in their browser bar saying the site is not secure. Need to get it done in the next 24 hours - a simple job for a coder that has worked with YII before I think.<br /><br /><b>Budget</b>: $100\n<br /><b>Posted On</b>: September 03, 2018 09:10 UTC<br /><b>Category</b>: IT &amp; Networking &gt; Information Security\n<br /><b>Skills</b>:        Security Analysis            <br /><b>Country</b>: Ukraine<br />click to apply', 'https://www.upwork.com/jobs/YII-Security-Patches-and-Updates_%7E0145d1ff9e264e1284?source=rss', 'https://www.upwork.com/jobs/YII-Security-Patches-and-Updates_%7E0145d1ff9e264e1284?source=rss'),
(76, 'PHP developers wanted', '2018-09-03 17:20:55', 'Responsibilities<br />\nIntegration of user-facing elements developed by front-end developers<br />\nBuild efficient, testable, and reusable PHP modules<br />\nSolve complex performance problems and architectural challenges<br />\nIntegration of data storage solutions <br /><br /><br /><br />\nSkills And Qualifications<br /><br />\nStrong knowledge of PHP web frameworks {​{​such as Laravel, Yii, etc depending on your technology stack}​}​<br />\nUnderstanding the fully synchronous behavior of PHP<br />\nUnderstanding of MVC design patterns<br />\nBasic understanding of front-end technologies, such as JavaScript, HTML5, and CSS3<br />\nKnowledge of object oriented PHP programming<br />\nUnderstanding accessibility and security compliance {​{​Depending on the specific project}​}​<br />\nStrong knowledge of the common PHP or web server exploits and their solutions<br />\nUnderstanding fundamental design principles behind a scalable application<br />\nUser authentication and authorization between multiple systems, servers, and environments<br />\nIntegration of multiple data sources and databases into one system<br />\nFamiliarity with limitations of PHP as a platform and its workarounds<br />\nCreating database schemas that represent and support business processes<br />\nFamiliarity with SQL/NoSQL databases and their declarative query languages<br />\nProficient understanding of code versioning tools, such as Git<br /><br />\nI am planning on improving features in https://www.agilecareers.eu so i need a strong developer.<br /><br /><br /><b>Posted On</b>: September 03, 2018 11:30 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        AngularJS,                     HTML,                     HTML5,                     jQuery,                     MySQL Administration,                     PHP,                     Web Design,                     Website Development            <br /><b>Country</b>: Belgium<br />click to apply', 'https://www.upwork.com/jobs/PHP-developers-wanted_%7E01e02fdacf5227ec75?source=rss', 'https://www.upwork.com/jobs/PHP-developers-wanted_%7E01e02fdacf5227ec75?source=rss'),
(77, 'Developer needed to update and modify Online Electric Vehicle selection tool', '2018-09-03 18:22:50', 'Updating and updating an online tool from 2012 which selects potential electric alternatives for gasoline and diesel powered vehicles based on characteristics (number plate connection with Dutch national database RDW) given current usage patterns and requirements.<br /><br />\nWe seek a developer that can work with PHP in the Yii framework to (1) modify the tool in order to automatic search for electric alternatives for entire fleets (lists of number plates and usage patterns) and (2) to update the tool to the newest tax/subsidy schemes for electric vehicles as well as the vehicle databases. Goal is to help lease companies and large business electrifying their fleet.<br /><br />\nThe tool is well documented and in full working order (national vehicle database connection is temporarily disabled), yet written in an older php language which is not as common nowadays. The former developer is willing to help with transferring the project, but timewise not able to work on the project.<br /><br /><br /><b>Posted On</b>: September 03, 2018 12:30 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        PHP            <br /><b>Country</b>: Netherlands<br />click to apply', 'https://www.upwork.com/jobs/Developer-needed-update-and-modify-Online-Electric-Vehicle-selection-tool_%7E01e104fcd9132a40a9?source=rss', 'https://www.upwork.com/jobs/Developer-needed-update-and-modify-Online-Electric-Vehicle-selection-too...'),
(78, 'Developer needed to update and modify Online Electric Vehicle selection tool', '2018-09-03 19:22:37', 'Updating and updating an online tool from 2012 which selects potential electric alternatives for gasoline and diesel powered vehicles based on characteristics (number plate connection with Dutch national database RDW) given current usage patterns and requirements.<br /><br />\nWe seek a developer that can work with PHP in the Yii framework to (1) modify the tool in order to automatic search for electric alternatives for entire fleets (lists of number plates and usage patterns) and (2) to update the tool to the newest tax/subsidy schemes for electric vehicles as well as the vehicle databases. Goal is to help lease companies and large business electrifying their fleet.<br /><br />\nThe tool is well documented and in full working order (national vehicle database connection is temporarily disabled), yet written in an older php language which is not as common nowadays. The former developer is willing to help with transferring the project, but timewise not able to work on the project.<br /><br /><br /><b>Posted On</b>: September 03, 2018 13:30 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        PHP            <br /><b>Country</b>: Netherlands<br />click to apply', 'https://www.upwork.com/jobs/Developer-needed-update-and-modify-Online-Electric-Vehicle-selection-tool_%7E01e104fcd9132a40a9?source=rss', 'https://www.upwork.com/jobs/Developer-needed-update-and-modify-Online-Electric-Vehicle-selection-too...'),
(79, 'Experienced Yii+HTML5 canvas Developer needed for a responsive website with e-cards (russian langv.)', '2018-09-03 22:45:52', 'It is necessary to make a new site with electronic postcards (the postcard editor should be developed in Javascript (you can Javascript frameworks), html5, css3) and store for other users on a new framework, for example, Laravel 5, Yii. Digital postcards will be edited from the interface of the store and then sent by email or printed. In the shops of other users you can buy their work and pay through our website.<br /><br />\nThe administrative part can be made on your own templates and besides the usual functions for the web-shop functions will also have to include the administrative part of the built-in editor (mentioned above) + newsletter.<br /><br />\nThere is a complete layout of the user part of the site (without the editor).<br /><br />\nWe will discuss the details in detail after a preliminary agreement. <br />\nThe price is namedfor the whole project, the remaining part will be negotiated by agreement. Payment in rubles. We work only on the approved estimate to the contract. The total amount for the whole project in rubles is 408.000. About half of the project is already finished on Yii, so it&#039;s about the &frac12; of the project, including the editor, the administrative part and part of the functionality have to be finished.<br /><br />\nPrepayments due to negative experience with previous developers will not be, but I guarantee 100% payment. We work only this way: we split the project into several stages, we will coordinate the terms and costs of each stage accordingly. At the end of a certain stage, we check it together, eliminate errors and I translate the payment, after which you give me the stage. Starting with the stage to demonstrate the work of the main page is not necessary, I&#039;m looking for serious developers.<br /><br />\nI&#039;m waiting for suggestions with examples of your work and the timing of this service.<br /><br />\nWork for qualified specialists. People with little work experience, please HE to leave applications.<br /><br /><b>Budget</b>: $6,000\n<br /><b>Posted On</b>: September 03, 2018 16:50 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        HTML5,                     HTML5 Canvas,                     JavaScript,                     Website Development,                     Yii2            <br /><b>Country</b>: Ukraine<br />click to apply', 'https://www.upwork.com/jobs/Experienced-Yii-HTML5-canvas-Developer-needed-for-responsive-website-with-cards-russian-langv_%7E01594c4ec794322d45?source=rss', 'https://www.upwork.com/jobs/Experienced-Yii-HTML5-canvas-Developer-needed-for-responsive-website-wit...'),
(80, 'Looking for a Yii2/CodeIgniter expert', '2018-09-04 00:53:43', 'For the backend of a wholesale app we&#039;re looking for a Yii2 and CodeIgniter expert.<br /><br /><br /><b>Posted On</b>: September 03, 2018 19:00 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        CodeIgniter,                     MySQL Administration,                     PHP,                     Yii2            <br /><b>Country</b>: Netherlands<br />click to apply', 'https://www.upwork.com/jobs/Looking-for-Yii2-CodeIgniter-expert_%7E016abcf62c7ccf93f7?source=rss', 'https://www.upwork.com/jobs/Looking-for-Yii2-CodeIgniter-expert_%7E016abcf62c7ccf93f7?source=rss'),
(81, 'Looking for a Yii2/CodeIgniter expert', '2018-09-04 01:53:42', 'For the backend of a wholesale app we&#039;re looking for a Yii2 and CodeIgniter expert.<br /><br /><br /><b>Posted On</b>: September 03, 2018 20:00 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        CodeIgniter,                     MySQL Administration,                     PHP,                     Yii2            <br /><b>Country</b>: Netherlands<br />click to apply', 'https://www.upwork.com/jobs/Looking-for-Yii2-CodeIgniter-expert_%7E016abcf62c7ccf93f7?source=rss', 'https://www.upwork.com/jobs/Looking-for-Yii2-CodeIgniter-expert_%7E016abcf62c7ccf93f7?source=rss'),
(82, 'PHP Developers to work on various large and small PHP projects (ongoing)', '2018-09-04 03:48:07', 'Due to expansion and a high workload, we&#039;re looking for experienced PHP Developers to work on various large and small custom PHP projects (ongoing).<br /><br />\nIn order to apply you must have the following skills/experience:<br /><br />\n* Excellent grasp of the English language<br />\n* Several years of commercial PHP experience including OO PHP<br />\n* Full Stack experience - PHP, MySQL, HTML, Javascript and CSS<br />\n* Exposure to PHP frameworks, e.g. Symfony, Zend, Laravel, Codeigniter, Yii, CakePHP, ...<br />\n* Exposure to Javascript frameworks, e.g. jQuery, Node.js, React, Angular, ...<br />\n* Version control (ideally GIT)<br />\n* Understanding of software problems and conceiving and implementing great solutions<br />\n* Ability to quickly determine the root cause of bugs and squash them<br />\n* Able to work either on your own or in a team<br />\n* You must be comfortable discussing software concepts with others, regardless of their level of technical understanding<br />\n* Understanding of web software security exploits and how to prevent them<br />\n* Integration of third-party APIs using JSON/XML<br /><br />\nBonus points for:<br /><br />\n* Experience of the Symfony PHP framework<br />\n* Experience of Doctrine<br />\n* Knowing your way around a Linux web server<br />\n* Task management systems: Trello, JIRA, ...<br />\n* Mysql performance optimisation<br />\n* NoSQL experience<br />\n* Payment gateway integration: Paypal, Worldpay, Sagepay, Braintree, ...<br />\n* eCommerce platform experience: Magento, Shopify, ...<br />\n* Amazon MWS<br />\n* Experience working with custom Financial or Booking Management software<br /><br />\nApplicants may be required to complete a technical test to assess suitability. If successful you will be required to sign a non-disclosure and non-solicitation agreement.<br /><br />\nWrite yahoo++ at the top of your proposal so i&#039;ll get to know that you read it carefully<br /><br /><br /><b>Posted On</b>: September 03, 2018 22:00 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Country</b>: Austria<br />click to apply', 'https://www.upwork.com/jobs/PHP-Developers-work-various-large-and-small-PHP-projects-ongoing_%7E01c153a481329eca13?source=rss', 'https://www.upwork.com/jobs/PHP-Developers-work-various-large-and-small-PHP-projects-ongoing_%7E01c1...'),
(83, 'Update pages layout on yii 1.0 engine', '2018-09-04 06:15:32', 'The project is about update pages layout of 2 sites. galeriadepropiedades.com y gremolich.com. <br />\nThe design is already done and the sites are already running with the old templates.<br />\nBoth sites are very similar and them will be responsive.<br />\nOn Gremolich.com, the user will be able to choose different set of colors and fonts (from 5 different sets).<br />\nI attach&nbsp;&nbsp;part of the new layout.<br /><br /><b>Budget</b>: $600\n<br /><b>Posted On</b>: September 04, 2018 00:20 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        CSS,                     CSS3,                     HTML,                     HTML5,                     JavaScript,                     jQuery,                     Templates,                     Web Design,                     Yii            <br /><b>Country</b>: Chile<br />click to apply', 'https://www.upwork.com/jobs/Update-pages-layout-yii-engine_%7E0160b257a8496d7ade?source=rss', 'https://www.upwork.com/jobs/Update-pages-layout-yii-engine_%7E0160b257a8496d7ade?source=rss'),
(84, 'Update pages layout on yii 1.0 engine', '2018-09-04 07:15:25', 'The project is about update pages layout of 2 sites. galeriadepropiedades.com y gremolich.com. <br />\nThe design is already done and the sites are already running with the old templates.<br />\nBoth sites are very similar and them will be responsive.<br />\nOn Gremolich.com, the user will be able to choose different set of colors and fonts (from 5 different sets).<br />\nI attach&nbsp;&nbsp;part of the new layout.<br /><br /><b>Budget</b>: $600\n<br /><b>Posted On</b>: September 04, 2018 01:20 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        CSS,                     CSS3,                     HTML,                     HTML5,                     JavaScript,                     jQuery,                     Templates,                     Web Design,                     Yii            <br /><b>Country</b>: Chile<br />click to apply', 'https://www.upwork.com/jobs/Update-pages-layout-yii-engine_%7E0160b257a8496d7ade?source=rss', 'https://www.upwork.com/jobs/Update-pages-layout-yii-engine_%7E0160b257a8496d7ade?source=rss'),
(85, 'Change URL with htaccess for a Yii website', '2018-09-04 11:52:52', 'I need to remove a part of the URL &amp;quot;Amat/index.php&amp;quot; for this website http://www.amat.ro/Amat/index.php... and this should be done with htaccess. I can&#039;t move the files in the root folder. The website is created with Yii 1.1.16.<br /><br /><b>Budget</b>: $10\n<br /><b>Posted On</b>: September 04, 2018 06:00 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        .htaccess,                     PHP,                     Website Development,                     Yii            <br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/Change-URL-with-htaccess-for-Yii-website_%7E010ae45aae14324751?source=rss', 'https://www.upwork.com/jobs/Change-URL-with-htaccess-for-Yii-website_%7E010ae45aae14324751?source=rs...'),
(86, 'Change URL with htaccess for a Yii website', '2018-09-04 12:52:45', 'I need to remove a part of the URL &amp;quot;Amat/index.php&amp;quot; for this website http://www.amat.ro/Amat/index.php... and this should be done with htaccess. I can&#039;t move the files in the root folder. The website is created with Yii 1.1.16.<br /><br /><b>Budget</b>: $10\n<br /><b>Posted On</b>: September 04, 2018 07:00 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        .htaccess,                     PHP,                     Website Development,                     Yii            <br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/Change-URL-with-htaccess-for-Yii-website_%7E010ae45aae14324751?source=rss', 'https://www.upwork.com/jobs/Change-URL-with-htaccess-for-Yii-website_%7E010ae45aae14324751?source=rs...'),
(87, 'HTML layout for project based on YII-framework', '2018-09-04 15:04:11', 'I&#039;m looking for a developer who can apply existing menu animation similar to this - https://badassfilms.tv on my web page.<br /><br />\nWe have already created such animation but we can not apply it on our page.<br />\nAnimation which we created: http://strumer.mgcmedia.space<br />\nThe page on which the animation should be applied: http://strumer.com<br /><br />\nIt&#039;s okay if you create the layout of this page from scratch to prepare it for animation integration. The main requirement is to make the animation work smoothly without any lags. If user clicks on menu item then right bar should move smoothly, size of the menu will be changed but the menu should not jump, shake or so.<br />\nScrolling animation must be exactly the same as it is on the page which we already created (without freezes, lags, etc.)<br /><br />\nThe final layout must be integrated in existing project and deployed on hosting (the project is based on YII-framework).<br /><br /><b>Budget</b>: $200\n<br /><b>Posted On</b>: September 04, 2018 09:10 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        CSS,                     CSS3,                     HTML,                     HTML5,                     JavaScript,                     Website Development,                     Yii,                     Yii2            <br /><b>Country</b>: Ukraine<br />click to apply', 'https://www.upwork.com/jobs/HTML-layout-for-project-based-YII-framework_%7E014476cd1c1ec7ed18?source=rss', 'https://www.upwork.com/jobs/HTML-layout-for-project-based-YII-framework_%7E014476cd1c1ec7ed18?source...'),
(88, 'HTML layout for project based on YII-framework', '2018-09-04 16:03:53', 'I&#039;m looking for a developer who can apply existing menu animation similar to this - https://badassfilms.tv on my web page.<br /><br />\nWe have already created such animation but we can not apply it on our page.<br />\nAnimation which we created: http://strumer.mgcmedia.space<br />\nThe page on which the animation should be applied: http://strumer.com<br /><br />\nIt&#039;s okay if you create the layout of this page from scratch to prepare it for animation integration. The main requirement is to make the animation work smoothly without any lags. If user clicks on menu item then right bar should move smoothly, size of the menu will be changed but the menu should not jump, shake or so.<br />\nScrolling animation must be exactly the same as it is on the page which we already created (without freezes, lags, etc.)<br /><br />\nThe final layout must be integrated in existing project and deployed on hosting (the project is based on YII-framework).<br /><br /><b>Budget</b>: $200\n<br /><b>Posted On</b>: September 04, 2018 10:10 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        CSS,                     CSS3,                     HTML,                     HTML5,                     JavaScript,                     Website Development,                     Yii,                     Yii2            <br /><b>Country</b>: Ukraine<br />click to apply', 'https://www.upwork.com/jobs/HTML-layout-for-project-based-YII-framework_%7E014476cd1c1ec7ed18?source=rss', 'https://www.upwork.com/jobs/HTML-layout-for-project-based-YII-framework_%7E014476cd1c1ec7ed18?source...'),
(89, 'We need frontend and backend developers (or just a full-stack developer) for e-commerce website', '2018-09-04 16:38:57', 'Hello!<br /><br />\nWe created a Russian web service to sell eTickets to city events. Now we need frontend and backend developers (or full-stack developer) to help us implement new features.<br /><br />\nThe technology stack we use:<br /><br />\n## Server ##<br />\n1. MariaDb (Mysql compatible fork)<br />\n2. Sphinx<br />\n3. PHP-FPM<br />\n4. Nginx<br /><br />\n## Database ##<br />\n1. DB model made in [MySQL Workbench]<br /><br />\n## Backend ##<br />\n1. [Yii2 framework]<br /><br />\n## Frontend ##<br />\n1. [VueJs]<br />\n2. [Vuex]<br />\n3. jQuery<br /><br />\nWe have a small task right now. Please find it here on google doc: https://docs.google.com/document/d/19NzsO15JM9umpZu6CEZLvy6xs76XA5Z5z-hUPpifBFw/edit<br /><br />\nWe would be happy to have a long term relationship with a right developer/s.<br /><br />\nFeel free to apply and we will tell you more about the tasks we have.<br /><br />\nThanks!<br /><br /><br /><b>Posted On</b>: September 04, 2018 10:50 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        CSS,                     PHP,                     Yii2            <br /><b>Country</b>: Russia<br />click to apply', 'https://www.upwork.com/jobs/need-frontend-and-backend-developers-just-full-stack-developer-for-commerce-website_%7E01adc048b30ee75727?source=rss', 'https://www.upwork.com/jobs/need-frontend-and-backend-developers-just-full-stack-developer-for-comme...'),
(90, 'We need frontend and backend developers (or just a full-stack developer) for e-commerce website', '2018-09-04 17:38:30', 'Hello!<br /><br />\nWe created a Russian web service to sell eTickets to city events. Now we need frontend and backend developers (or full-stack developer) to help us implement new features.<br /><br />\nThe technology stack we use:<br /><br />\n## Server ##<br />\n1. MariaDb (Mysql compatible fork)<br />\n2. Sphinx<br />\n3. PHP-FPM<br />\n4. Nginx<br /><br />\n## Database ##<br />\n1. DB model made in [MySQL Workbench]<br /><br />\n## Backend ##<br />\n1. [Yii2 framework]<br /><br />\n## Frontend ##<br />\n1. [VueJs]<br />\n2. [Vuex]<br />\n3. jQuery<br /><br />\nWe have a small task right now. Please find it here on google doc: https://docs.google.com/document/d/19NzsO15JM9umpZu6CEZLvy6xs76XA5Z5z-hUPpifBFw/edit<br /><br />\nWe would be happy to have a long term relationship with a right developer/s.<br /><br />\nFeel free to apply and we will tell you more about the tasks we have.<br /><br />\nThanks!<br /><br /><br /><b>Posted On</b>: September 04, 2018 11:50 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        CSS,                     PHP,                     Yii2            <br /><b>Country</b>: Russia<br />click to apply', 'https://www.upwork.com/jobs/need-frontend-and-backend-developers-just-full-stack-developer-for-commerce-website_%7E01adc048b30ee75727?source=rss', 'https://www.upwork.com/jobs/need-frontend-and-backend-developers-just-full-stack-developer-for-comme...'),
(91, 'PHP backend developer based on Yii with payment integration', '2018-09-04 20:15:50', 'I&#039;m looking for back end developer for my dating mobile application.<br />\nBack end is based on Yii2 framework and need to integration payment method(Stripe&nbsp;&nbsp;or Paypal)<br />\nAlso there are more functions to integrate.<br /><br />\nPlease Contact me with past work done by you correctly.<br /><br /><br /><b>Posted On</b>: September 04, 2018 14:20 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        Payment Gateway Integration,                     PHP,                     Yii2            <br /><b>Country</b>: Hong Kong<br />click to apply', 'https://www.upwork.com/jobs/PHP-backend-developer-based-Yii-with-payment-integration_%7E01c3417cffa2724f32?source=rss', 'https://www.upwork.com/jobs/PHP-backend-developer-based-Yii-with-payment-integration_%7E01c3417cffa2...'),
(92, 'vuejs expert', '2018-09-04 23:17:41', 'We are looking for an accomplished and reliable Web Developer / Software Engineer to join our expanding team. This exciting role will involve developing innovative cloud-based software solutions in VueJS framework<br /><br />\nYou will be assigned a paid test task in order to qualify for the position.<br /><br />\nIn order to qualify for this job please include in your application:<br />\n1. Your vuejs experience and portfolio<br />\n2. Your public ssh key in OpenSSL rsa-ssh format<br />\n3. Link to your Github or Bitbucket account<br />\n4. Link to your StackOverflow account<br />\nApplications without the above data will not be considered!<br /><br />\nWe expect you to :<br />\n&amp;gt; Solid understanding of Git version control<br />\n&amp;gt; Ability to interacting with RESTful APIs<br />\n&amp;gt; Understanding of web architecture, security and session management<br />\n&amp;gt; Strong unit testing skills (added bonus would be some integration testing)<br />\n&amp;gt; Produce well commented, readable code<br />\n&amp;gt; Passion for software development and learning new skills<br />\n&amp;gt; Professional attitude with proactive time management skills<br /><br />\nKnowledge of material design is a plus.<br />\nKnowledge of Yii framework is a plus.<br /><br /><br /><b>Posted On</b>: September 04, 2018 17:20 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        CSS3,                     HTML5,                     JavaScript,                     Vue.js,                     Yii            <br /><b>Country</b>: India<br />click to apply', 'https://www.upwork.com/jobs/vuejs-expert_%7E017db1f0a9f5b4974b?source=rss', 'https://www.upwork.com/jobs/vuejs-expert_%7E017db1f0a9f5b4974b?source=rss'),
(93, 'vuejs expert', '2018-09-05 00:17:39', 'We are looking for an accomplished and reliable Web Developer / Software Engineer to join our expanding team. This exciting role will involve developing innovative cloud-based software solutions in VueJS framework<br /><br />\nYou will be assigned a paid test task in order to qualify for the position.<br /><br />\nIn order to qualify for this job please include in your application:<br />\n1. Your vuejs experience and portfolio<br />\n2. Your public ssh key in OpenSSL rsa-ssh format<br />\n3. Link to your Github or Bitbucket account<br />\n4. Link to your StackOverflow account<br />\nApplications without the above data will not be considered!<br /><br />\nWe expect you to :<br />\n&amp;gt; Solid understanding of Git version control<br />\n&amp;gt; Ability to interacting with RESTful APIs<br />\n&amp;gt; Understanding of web architecture, security and session management<br />\n&amp;gt; Strong unit testing skills (added bonus would be some integration testing)<br />\n&amp;gt; Produce well commented, readable code<br />\n&amp;gt; Passion for software development and learning new skills<br />\n&amp;gt; Professional attitude with proactive time management skills<br /><br />\nKnowledge of material design is a plus.<br />\nKnowledge of Yii framework is a plus.<br /><br /><br /><b>Posted On</b>: September 04, 2018 18:30 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        CSS3,                     HTML5,                     JavaScript,                     Vue.js,                     Yii            <br /><b>Country</b>: India<br />click to apply', 'https://www.upwork.com/jobs/vuejs-expert_%7E017db1f0a9f5b4974b?source=rss', 'https://www.upwork.com/jobs/vuejs-expert_%7E017db1f0a9f5b4974b?source=rss'),
(94, 'Search Engine and E-Commerce website', '2018-12-20 20:55:54', 'Search Engine of Service Providers<br />\nEach service provider will have their own service list and detail page<br />\nSearch engine integrates Google Map or other Map api that shows pins<br />\nCustomer can schedule, and pay online to service provider, admin takes commission<br />\nCustomer / Service provider will be able to view their own calendar, with appointment system<br />\nE-Commerce Website that enables service providers to upload their own products, admin takes commission<br />\nSeveral chron jobs (based on user registration data, will auto suggest different categories of service providers)<br />\nService Providers will have a main account, and sub account (branches)<br /><br />\nGeneral:<br />\nSupport Social Login / Registration / Like / Sharing + Traditional methods <br />\nMobile Responsive<br /><br /><br /><br /><br />\nRequirement: PHP framework (Yii2 / Laravel)<br /><br /><b>Budget</b>: $4,000\n<br /><b>Posted On</b>: December 21, 2018 11:43 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Ecommerce Development\n<br /><b>Skills</b>:        API Development,                     Google APIs,                     Laravel Framework,                     Yii2            <br /><b>Country</b>: Hong Kong<br />click to apply', 'https://www.upwork.com/jobs/Search-Engine-and-Commerce-website_%7E011e1348daa4932e3d?source=rss', 'https://www.upwork.com/jobs/Search-Engine-and-Commerce-website_%7E011e1348daa4932e3d?source=rss'),
(95, 'Android &amp;amp; iOS Mobile Application with Web Admin', '2018-12-20 19:34:54', 'Project Description: <br />\nClassified App include Social Media Features<br />\niOS &amp;amp; Android Mobile Application <br />\nFree and Premium Advertisement. <br />\nAttractive Look, Multi Language, Country Flag, Chat, Location <br />\nApp Looks wants to be like Instagram<br />\nClassified Features<br />\nOnly 4 Categories<br />\n1.	Luxury Cars<br />\n2.	Luxury Watches<br />\n3.	Classic Cars<br />\n4.	Vintages<br />\nOptions<br />\nFree Post &amp;amp; Paid Post<br />\nFeeds like Tweet, Insta, FB<br />\nMulti Language &ndash; Arabic &amp;amp; English<br />\nSignup by Either Mobile number or Email ID or Instagram<br />\nEach and Every Post Include Poster Country Flag<br />\nViewer can contact any poster directly by chat<br />\nPoster can Post Photos and Videos<br />\nEach and Every Register used need a Unique ID <br />\nFor premium users we need to give Fancy Unique ID<br />\nFriends, Following, Fans (both are followed each other means friends)<br />\nAdmin can give offer to post premium post without payment (silver badge)<br />\nIn-app Purchase <br />\nAny normal free user can upgrade to Premium User by Posting Premium Advertisement (Golden Badge)<br />\nPayment Method by Google Pay &amp;amp; iTunes payment methods<br /><br /><br /><br />\nUser App Features:<br />\nRegister, Login using password, Facebook, Instagram<br />\nMobile OTP Verification<br />\nUpdate profile with title, images, description, etc.<br />\nQuick Access Links of Categories<br />\nSearch Ads by Categories<br />\nSearch Ads by filters like location, category, product, etc.<br />\nPrice of Product, No of Views, Like and Give Comments for Post<br />\nShare Ads via social networks, email, etc.<br />\nCheck product details like image, description, price, etc.<br />\nChat with Seller, Contact Seller, Post Free Ads<br />\nManage Posted Ads, Manage Featured Ads<br />\nManage active ads, Manage pending ads<br />\nManager deleted ads, Wish list Ads, Favorite Sellers, Free Registration<br />\nReport Abuse to admin for fake ads<br />\nReceive Notifications from favorite seller whenever he updates new products or sells products in his profile<br />\nReceive notifications on product activity - sold, available, new price update, etc.<br />\nThere colors Notification &ndash; Red (Sold) Green (for Sale) Yellow (Just for Adv)<br />\nInvite Friends<br />\nUnsubscribe <br /><br />\nWeb back end Admin Features:<br />\nSuper Admin<br />\nManage Categories, Manage Users, Manage user Ads, Manager User Chats, Manage Filters<br />\nManage Features, Admin can Create Sub Users, Manage Posted Ads, Admin Can Post Ads<br />\nAdmin can check the payment of Premium Advertisement and make approval of adv <br />\nCan make offer free premium adv.<br />\nCan make offer of premium adv. without payment.<br />\nAdd Categories, Add Sub Categories, Edit or Delete Categories<br />\nAdd Categories Features, Assign Categories Features to specific Category<br />\nManage Filters, Manage FAQs, <br />\nManage Comments (If someone using any bad comments means?? We need to block the comments) <br />\nManage Google Ads<br />\nManage advertise ads<br /><br />\nSub Admin<br />\nAdmin can Assign ID<br />\nCan check the payment of Premium Advertisement and make approval of adv <br />\nCan make offer free premium adv.<br />\nManage Filters, Manage FAQs <br />\nManage Comments (If someone using any bad comments means?? We need to block the comments)<br />\nManage advertise ads<br /><br />\nProject Wireframe : https://invis.io/JYPPMK8ZXUC<br /><br /><b>Budget</b>: $1,500\n<br /><b>Posted On</b>: December 21, 2018 11:44 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Mobile Development\n<br /><b>Skills</b>:        Core PHP,                     DART,                     Flutter,                     Ionic Framework,                     Java,                     Laravel Framework,                     MongoDB,                     MySQL Administration,                     Yii2            <br /><b>Country</b>: Qatar<br />click to apply', 'https://www.upwork.com/jobs/Android-amp-iOS-Mobile-Application-with-Web-Admin_%7E010e1e2850c6e1f31d?source=rss', 'https://www.upwork.com/jobs/Android-amp-iOS-Mobile-Application-with-Web-Admin_%7E010e1e2850c6e1f31d?...'),
(96, 'Fulltime Experienced Yii2 Developer', '2018-12-19 22:36:26', 'Howdy,<br /><br />\nAre you an experienced Yii 2 developer looking for a full time role? If so I&#039;d like to hear from you!<br /><br />\nYou&#039;ll be joining myself &amp;amp; another full time developer to work on a collection of eCommerce related applications.<br /><br />\nHaving excellent spoken and written English, you&#039;ll be able to take clear instructions and create well documented, robust code (ie that doesn&#039;t throw an exception in silence). You&#039;ll be left to work on your assigned tasks, however if you get stuck or need clarification help is a click away.<br /><br />\nAs an experienced Yii 2 developer you&#039;ll have several previous projects to show off, please include these and see the &amp;quot;To Apply&amp;quot; section below.<br /><br />\nIf you have any eCommerce expereince or have worked with any of the eBay or Amazon API&#039;s, make sure you mention this and which ones in the your application.<br /><br />\nLooking forward to hearing from you,<br /><br />\nMatt<br /><br />\nRequired Skills/Attributes<br />\n- - - - - - - - - - - <br />\n- Excellent written and spoken English<br />\n- Proficient with Yii 2<br />\n- Able to use Skype as the primary form of communication (verbal and text)<br />\n- Experienced with Git<br />\n- Excellent pure JS &amp;amp; jQuery skills<br />\n- Able to test your own code before pushing<br />\n- Able to create, clear well documented code<br /><br />\nDesired Attributes<br />\n- - - - - - - - - - - <br />\n- eCommerce experience highly desirable <br />\n- Any experience of AWS beneficial <br />\n- Any experience of eBay or Amazon API&#039;s beneficial <br /><br /><br />\nTo Apply<br />\n- - - - - - - - - - - <br />\n- How long have you worked with Yii2 for?<br />\n- What was the last Yii2 project you worked on?<br />\n- What changes were made beyond the design brief for that project that had to be made as the project evolved?<br /><br /><br /><b>Posted On</b>: December 21, 2018 11:44 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        Bootstrap,                     CSS,                     CSS3,                     HTML,                     HTML5,                     JavaScript,                     jQuery,                     MySQL Programming,                     PHP,                     Web Design,                     Website Development,                     Yii,                     Yii2            <br /><b>Country</b>: United Kingdom<br />click to apply', 'https://www.upwork.com/jobs/Fulltime-Experienced-Yii2-Developer_%7E01a6115989c3869874?source=rss', 'https://www.upwork.com/jobs/Fulltime-Experienced-Yii2-Developer_%7E01a6115989c3869874?source=rss'),
(97, 'Russian speaking PHP developer (Yii, Symfony or Laravel) to build web app', '2018-12-19 20:16:15', 'No Agencies - Agencies will not be considered.<br /><br />\nWe are looking for Russian speaking developer to work full time on our project (web application for doctors) next few months.<br /><br />\nRequired skills/experience:<br />\n- Web development in PHP using PHP frameworks such as Yii, Symfony or Laravel<br />\n- Both frontend and backend development<br />\n- Development of APIs<br />\n- Integration with 3rd party libs/modules via SDK/API (in this project we are interested in integration with Twilio Video)<br />\n- Databases (MySQL, PostgreSQL)<br />\n- Spoken Russian and good written English<br /><br /><br /><b>Posted On</b>: December 21, 2018 11:45 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        HTML,                     Laravel Framework,                     PHP,                     Symfony,                     Yii            <br /><b>Country</b>: United Kingdom<br />click to apply', 'https://www.upwork.com/jobs/Russian-speaking-PHP-developer-Yii-Symfony-Laravel-build-web-app_%7E01b197286ad70db5fc?source=rss', 'https://www.upwork.com/jobs/Russian-speaking-PHP-developer-Yii-Symfony-Laravel-build-web-app_%7E01b1...'),
(98, 'Seeking Magento and PHP Developer', '2018-12-19 10:56:38', 'This will be general on-going work for Magento development and also other PHP work based on Laravel and Yii2. I am only looking for independent contractors, no agency workers or brokers. You will be required to Skype with me and prove you are actually working on my projects. I also want someone who can work morning, nights and/or weekends when necessary.<br /><br /><br /><b>Posted On</b>: December 21, 2018 11:45 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        Laravel Framework,                     Magento,                     Magento 2,                     PHP,                     Yii2            <br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/Seeking-Magento-and-PHP-Developer_%7E01de4eb80fbcb9b9f3?source=rss', 'https://www.upwork.com/jobs/Seeking-Magento-and-PHP-Developer_%7E01de4eb80fbcb9b9f3?source=rss');
INSERT INTO `upwork` (`id`, `title`, `date`, `description`, `link`, `guid`) VALUES
(99, 'Help Choose a payment system for the site', '2018-12-19 08:09:48', 'For website https://getbike.io/ Choose a payment system for the site.<br />\nit could be paypal or something else. <br />\nWe need a simple way to organize the reception of payments. With a simple connection and a simple implementation on Yii2<br /><br />\nThat important<br />\n1) low commission<br />\n2) easy setup with Yii2<br />\n3) low withdrawal fee<br /><br /><b>Budget</b>: $10\n<br /><b>Posted On</b>: December 21, 2018 11:45 UTC<br /><b>Category</b>: Design &amp; Creative &gt; physical_design\n<br /><b>Skills</b>:        Yii            <br /><b>Country</b>: Russia<br />click to apply', 'https://www.upwork.com/jobs/Help-Choose-payment-system-for-the-site_%7E01ee4c0226858b0bfb?source=rss', 'https://www.upwork.com/jobs/Help-Choose-payment-system-for-the-site_%7E01ee4c0226858b0bfb?source=rss'),
(100, 'Front-end API developer', '2018-12-19 01:09:16', 'Looking for a PHP developer to implement some API&#039;s and work on front-end UI adjustments. The task will be to optimize and improve an existing user dashboard.<br /><br /><br /><b>Posted On</b>: December 21, 2018 11:47 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        AJAX,                     API Development,                     Database Design,                     GUI Design,                     phpMyAdmin,                     Yii2            <br /><b>Country</b>: United States<br />click to apply', 'https://www.upwork.com/jobs/Front-end-API-developer_%7E0177a4ea6787606f5b?source=rss', 'https://www.upwork.com/jobs/Front-end-API-developer_%7E0177a4ea6787606f5b?source=rss'),
(101, 'Food Portal script layout and customisation', '2018-12-18 23:24:07', 'We have earlier developed a food portal script based on a popular online food ordering script . The enhancements and modifications we made to script were mostly backend and now we would like a new layout that has already been designed but it&rsquo;s without modifications . We would like to do the code merge to include modifications <br /><br />\nHere&rsquo;s what we need done <br /><br />\n1. Develop a Free Trial Script which creates an account for a limited period. <br />\n2. Develop new Layout for the Merchant Admin Portal for easy navigation and beautiful design. (Design can be provided)<br />\n3. Integrate with WooCommerce subscriptions plugin to check for a valid subscription for an account.<br /><br />\n&nbsp;&nbsp;4, We would also like to integrate the online ordering portal with UberEATS and Deliveroo. Currently Deliveroo has a documentation and API available but not sure about UberEATS. <br /><br /><br />\nThe use must be familiar with yii framework and have good command over php to complete this task as this is not an average script . It&rsquo;s an ongoing project and we would require someone on regular basis<br /><br />\nThis job was posted from a mobile device, so please pardon any typos or any missing details.<br /><br /><b>Budget</b>: $500\n<br /><b>Posted On</b>: December 21, 2018 11:48 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Web Development\n<br /><b>Skills</b>:        CSS3,                     HTML,                     JavaScript,                     jQuery,                     MySQL Administration,                     PHP,                     WordPress,                     Yii            <br /><b>Country</b>: Australia<br />click to apply', 'https://www.upwork.com/jobs/Food-Portal-script-layout-and-customisation_%7E01b356168636a62ce7?source=rss', 'https://www.upwork.com/jobs/Food-Portal-script-layout-and-customisation_%7E01b356168636a62ce7?source...'),
(102, 'PhP programmer', '2018-12-18 19:46:32', 'skill requirement:<br />\n- familiarity with ubuntu os<br />\n- familiarity with php 7.2<br />\n- familiarity with mariadb<br />\n- familiarity with yii 2.0.14<br /><br /><br />\njob scope:<br />\n- migrate the yii to 2.0.14 and solve its compatibility issue with php 7.2 for example Object entity resolution.<br />\n- update the features as requested to support business objectives such as user management and license management in the application<br /><br /><b>Budget</b>: $400\n<br /><b>Posted On</b>: December 21, 2018 11:48 UTC<br /><b>Category</b>: Web, Mobile &amp; Software Dev &gt; Desktop Software Development\n<br /><b>Country</b>: Saudi Arabia<br />click to apply', 'https://www.upwork.com/jobs/PhP-programmer_%7E018473fb9d3341252a?source=rss', 'https://www.upwork.com/jobs/PhP-programmer_%7E018473fb9d3341252a?source=rss');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint NOT NULL,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `subscribe` smallint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `name`, `email`, `phone`, `status`, `created_at`, `updated_at`, `description`, `subscribe`) VALUES
(1, 'admin', '_gOPydMje6EV9PR3IqAk5bK8h9BM6OLn', '$2y$13$g0Xj.0poxUBuFQzLjWKrFuHEgxmxPqMFbP.6BrOt5rJ3VLWKjySc2', 'Administrator', 'admin@mail.ru', NULL, 10, 1618641958, 1618641958, '<p>Yii developer</p>', 1),
(2, 'seller', '', '$2y$13$5HE.hbkpLjyLMsXXDAvDMOQBgO1TCoOJUah1U/bhnXnYUsLF7TN.q', 'Seller', 'seller@mail.ru', NULL, 10, 1618641958, 1618641958, '<p>Yii developer</p>', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `user_profile`
--

CREATE TABLE `user_profile` (
  `id` int NOT NULL,
  `address` varchar(255) NOT NULL,
  `country_id` int NOT NULL,
  `region_id` int NOT NULL,
  `city_id` int NOT NULL,
  `zip_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `user_shop`
--

CREATE TABLE `user_shop` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `shop_id` int NOT NULL,
  `position` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_shop`
--

INSERT INTO `user_shop` (`id`, `user_id`, `shop_id`, `position`) VALUES
(1, 1, 1, 'owner'),
(2, 1, 2, 'owner'),
(3, 1, 3, 'owner'),
(4, 2, 4, 'owner');

-- --------------------------------------------------------

--
-- Структура таблицы `user_token`
--

CREATE TABLE `user_token` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `expire_date` datetime DEFAULT NULL,
  `action` smallint NOT NULL,
  `run` smallint NOT NULL,
  `reusable` tinyint(1) NOT NULL,
  `data` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user_token`
--

INSERT INTO `user_token` (`id`, `user_id`, `token`, `ip_address`, `expire_date`, `action`, `run`, `reusable`, `data`, `created_at`, `updated_at`) VALUES
(1, 1, 'Imj6A5p07WKjGlGOUteB2hDNTBa1A6lg', '127.0.0.1', NULL, 40, 1, 0, NULL, '2018-03-15 09:46:05', '2018-04-17 20:54:36'),
(2, 4, 'NgZaOX_OIXfGP03TI1vVVdDhUPleQwCl', '127.0.0.1', '2018-03-22 12:12:30', 10, 1, 0, 'auto_login', '2018-03-15 12:12:30', '2018-03-15 12:13:44'),
(3, 2, 'QzOeALLgXWPgGwpR3GRfgYFWVqviF0CH', '127.0.0.1', '2018-03-26 10:03:26', 10, 0, 0, 'auto_login', '2018-03-19 10:03:26', '2018-03-19 10:03:26'),
(4, 3, 'xl7TAxur6C3SXJ3bEDpWKhdZK61zyLQY', '127.0.0.1', '2018-03-26 10:06:22', 10, 0, 0, 'auto_login', '2018-03-19 10:06:22', '2018-03-19 10:06:22'),
(5, 4, 'lEQyS260ONl966bRc5QGgQwj781rrDLv', '127.0.0.1', '2018-03-26 10:07:14', 10, 0, 0, 'auto_login', '2018-03-19 10:07:14', '2018-03-19 10:07:14'),
(6, NULL, 'qfOkZRBRwbL5Zov2s4Q9aPMu78OkLMrf', '127.0.0.1', '2018-03-26 10:08:58', 10, 0, 0, 'auto_login', '2018-03-19 10:08:15', '2018-03-19 10:08:15'),
(7, 5, 'nMD7-Eo0HJS8LzW5nisyRx-1EbRwPyZH', '127.0.0.1', '2018-03-26 10:09:17', 10, 0, 0, 'auto_login', '2018-03-19 10:09:17', '2018-03-19 10:09:17'),
(8, 6, 'cwMiaLIrrLsrgbz4Y1zbqACJ8pgDPt8E', '127.0.0.1', '2018-03-26 10:09:53', 10, 0, 0, 'auto_login', '2018-03-19 10:09:53', '2018-03-19 10:09:53'),
(9, 7, 'B1C-WOt_r_YXHbiUFE0yh_nuCvYQJ4zB', '127.0.0.1', '2018-03-26 10:10:29', 10, 0, 0, 'auto_login', '2018-03-19 10:10:29', '2018-03-19 10:10:29'),
(10, 8, 'RJloGbrJKqgHHTJ18bEK_l2HkzkZAyqP', '127.0.0.1', '2018-03-26 10:11:08', 10, 0, 0, 'auto_login', '2018-03-19 10:11:08', '2018-03-19 10:11:08'),
(11, 9, 'P5RU9r4UqgRi5qxiNUZMxQF02mP4q5Tq', '127.0.0.1', '2018-03-26 10:11:29', 10, 0, 0, 'auto_login', '2018-03-19 10:11:29', '2018-03-19 10:11:29'),
(12, 10, 'smnXkmzl1cURi-7TbVJtYjAeZCxYWUML', '127.0.0.1', '2018-03-26 10:15:44', 10, 0, 0, 'auto_login', '2018-03-19 10:15:44', '2018-03-19 10:15:44'),
(13, 2, '5_y-KsQZhlTMPR6aYNLTWJDe91WlL5Ez', '127.0.0.1', '2018-04-16 19:14:13', 10, 0, 0, 'auto_login', '2018-04-09 19:14:13', '2018-04-09 19:14:13'),
(14, 2, 'jA0pHFqwWiF8KafTgjACI34aRJa5J8el', '41.110.183.41', '2018-05-04 13:32:22', 10, 0, 0, 'auto_login', '2018-04-17 20:04:06', '2018-04-17 20:04:06'),
(15, 3, 'rR5RcvYDFkcT_DB2STYK6QTU4_IFnIf2', '37.105.167.220', '2018-05-03 01:12:33', 10, 0, 0, 'auto_login', '2018-04-17 20:09:51', '2018-04-17 20:09:51'),
(16, 4, 'hqlNGM_ogXgRy9TCGxSwfGYkPKr3t5wm', '213.180.113.251', '2018-04-28 03:17:37', 10, 1, 0, 'auto_login', '2018-04-17 20:10:22', '2018-04-21 03:18:48'),
(17, 1, 'DR_LcFh1udpu8ocwS0N6kB3AQUa1R1Ee', '84.206.29.113', '2018-04-28 03:13:44', 40, 1, 1, NULL, '2018-04-17 21:23:36', '2018-04-21 03:14:44'),
(18, 4, 'hA7mjkRlV33ah4klmC5DLM1zp96b555X', '123.231.125.171', '2018-04-28 03:21:01', 30, 0, 0, 'parehostom1@superrito.com', '2018-04-21 03:21:01', '2018-04-21 03:21:01'),
(19, 5, 'nAEMrNiJ5Dymzx-8wPlpt_minPw2wSAb', '185.229.36.125', '2018-04-28 14:29:55', 10, 0, 0, 'auto_login', '2018-04-21 14:29:55', '2018-04-21 14:29:55'),
(20, 2, 'M6g7Q9koNMDyhFYNgElkTYhQP9l4azOo', '122.169.79.224', '2018-05-15 11:57:00', 10, 0, 0, 'auto_login', '2018-05-07 13:11:49', '2018-05-07 13:11:49'),
(21, 2, 'd6Zl0QWl8FY8U7CQ6XLVORAfVdyEMNS9', '14.177.239.192', '2018-06-07 03:03:03', 10, 0, 0, 'auto_login', '2018-05-15 15:25:51', '2018-05-15 15:25:51'),
(22, 1, 'ABHGd4ZIOQCULfWn2QH3bYALJXPXWoRV', '195.246.107.26', NULL, 40, 0, 1, NULL, '2018-05-16 15:20:50', '2018-05-16 15:20:50'),
(23, 2, 'j-iQFDW9BlLviadhpfxgjOXAiGsBR1xT', '2.239.87.231', '2018-07-06 14:41:30', 10, 0, 0, 'auto_login', '2018-06-18 22:40:45', '2018-06-18 22:40:45'),
(24, 2, 'JDlO-VsEG0EBFng7w1u8HAoE0zhkI81W', '92.98.53.181', '2018-07-13 15:49:42', 10, 1, 0, 'auto_login', '2018-07-06 15:49:42', '2018-07-06 15:50:12'),
(25, 2, '1EXYC7ch_go2FsKesyfrUWeVGxnHeov1', '92.98.53.181', '2018-07-20 14:41:40', 10, 0, 0, 'auto_login', '2018-07-06 20:36:04', '2018-07-06 20:36:04'),
(26, 3, 'zo5TmutXCTwGv_f1EKlVnP2axuP2vYDh', '213.230.93.47', '2018-07-18 21:32:34', 10, 0, 0, 'auto_login', '2018-07-11 21:32:34', '2018-07-11 21:32:34'),
(27, 2, 'ELaM0s2c3epBvYImwjV0W98vMhsvcnqs', '185.248.47.167', '2018-08-06 13:47:04', 10, 0, 0, 'auto_login', '2018-07-30 13:47:04', '2018-07-30 13:47:04'),
(28, 2, 'V5CA-WiS-kBEFeJTQInJN3Na37BOiSFh', '178.204.166.85', '2018-08-17 18:46:23', 10, 0, 0, 'auto_login', '2018-08-10 18:46:23', '2018-08-10 18:46:23'),
(29, 2, 'OBLBGHjWcAxRVYbmdsuCxKHLqUMf1xdI', '188.163.96.8', '2018-08-30 01:04:47', 10, 0, 0, 'auto_login', '2018-08-23 01:04:47', '2018-08-23 01:04:47'),
(30, 2, 'k4n5NklCNMy4AW_C-JHx1B835E-QOLyu', '127.0.0.1', '2018-11-15 12:53:43', 10, 0, 0, 'auto_login', '2018-11-08 12:53:43', '2018-11-08 12:53:43'),
(31, 3, 'BCwVPzsGUCCvdY2lGDMIoEgLip3yySMy', '127.0.0.1', '2018-11-15 13:08:35', 10, 0, 0, 'auto_login', '2018-11-08 13:08:35', '2018-11-08 13:08:35'),
(32, 2, 'ROUyPxa0Y40kQda6-XTBaGY_viC_0gtA', '127.0.0.1', '2018-11-29 18:40:37', 10, 0, 0, 'auto_login', '2018-11-22 18:40:37', '2018-11-22 18:40:37'),
(39, 3, '3bm2bypiIfnFfYE4PmJEDwuOJVRkNo1M', '127.0.0.1', '2020-06-08 17:50:10', 10, 1, 0, 'auto_login', '2020-06-01 17:50:10', '2020-06-01 18:05:31'),
(40, 4, 'UZ746AZgQ-OcWR6orgLTEWJwgF-Hq7Hr', '127.0.0.1', '2020-06-08 17:55:04', 10, 0, 0, 'auto_login', '2020-06-01 17:55:04', '2020-06-01 17:55:04'),
(43, 5, 'H9U2XQROsUmHBxhbp1w1K1P0jVKD6xgg', '127.0.0.1', '2020-06-08 18:33:02', 10, 1, 0, 'auto_login', '2020-06-01 18:33:02', '2020-06-01 18:33:16'),
(45, 1, 'NOmeutkPw-Yj8bDTbIMcNdZRL38Vacfv', '127.0.0.1', '2020-06-08 19:42:21', 50, 0, 0, NULL, '2020-06-01 19:42:21', '2020-06-01 19:42:21'),
(46, 2, 'Dj3hzdjd2brHoa_vtfB0P9pmcKQ-5cqi', '127.0.0.1', '2020-06-08 23:57:46', 50, 0, 0, NULL, '2020-06-01 23:57:46', '2020-06-01 23:57:46'),
(48, 3, 'NnhfkK_8njoaECPzi2QXzQnfqpSdp2G7', '127.0.0.1', '2020-06-09 00:09:48', 50, 0, 0, NULL, '2020-06-02 00:09:48', '2020-06-02 00:09:48'),
(49, 4, '5oyqHUj3D3fpNNh_NQWAR0mDQRhjjDQw', '127.0.0.1', '2020-06-09 00:10:10', 50, 0, 0, NULL, '2020-06-02 00:10:10', '2020-06-02 00:10:10'),
(51, 2, '78z5MbAwIpU1MNc0p2z8g8YPpoJ0YXxR', '127.0.0.1', '2020-06-09 05:10:04', 10, 1, 0, 'auto_login', '2020-06-02 05:10:04', '2020-06-02 05:10:21');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`);

--
-- Индексы таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Индексы таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Индексы таблицы `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `category` ADD FULLTEXT KEY `title_index` (`title`);

--
-- Индексы таблицы `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `model_id_index` (`model_id`),
  ADD KEY `model_name_index` (`model_name`);

--
-- Индексы таблицы `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `cron_email_message`
--
ALTER TABLE `cron_email_message`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `dynamic_field`
--
ALTER TABLE `dynamic_field`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `dynamic_value`
--
ALTER TABLE `dynamic_value`
  ADD PRIMARY KEY (`id`),
  ADD KEY `field_id` (`field_id`),
  ADD KEY `object_id` (`object_id`),
  ADD KEY `dynamic_value_index` (`value`(255));
ALTER TABLE `dynamic_value` ADD FULLTEXT KEY `value_index` (`value`);

--
-- Индексы таблицы `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `model_id_index` (`model_id`),
  ADD KEY `model_name_index` (`model_name`);

--
-- Индексы таблицы `i18n_message`
--
ALTER TABLE `i18n_message`
  ADD PRIMARY KEY (`id`,`language`);
ALTER TABLE `i18n_message` ADD FULLTEXT KEY `translation_index` (`translation`);

--
-- Индексы таблицы `i18n_source_message`
--
ALTER TABLE `i18n_source_message`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `like`
--
ALTER TABLE `like`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `model_id_index` (`model_id`),
  ADD KEY `model_name_index` (`model_name`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `object_tag`
--
ALTER TABLE `object_tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tag_id` (`tag_id`),
  ADD KEY `model_id_index` (`model_id`),
  ADD KEY `model_name_index` (`model_name`);

--
-- Индексы таблицы `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `coupon_id` (`coupon_id`),
  ADD KEY `coupon_id_2` (`coupon_id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `country_id` (`country_id`),
  ADD KEY `state_id` (`region_id`);

--
-- Индексы таблицы `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `product_shop_id_index` (`shop_id`);
ALTER TABLE `product` ADD FULLTEXT KEY `product_title_index` (`title`,`description`);

--
-- Индексы таблицы `product_buy_with_this`
--
ALTER TABLE `product_buy_with_this`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `buy_id` (`buy_product_id`);

--
-- Индексы таблицы `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `product_network`
--
ALTER TABLE `product_network`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_network_index` (`product_id`);

--
-- Индексы таблицы `product_rating`
--
ALTER TABLE `product_rating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `upwork`
--
ALTER TABLE `upwork`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Индексы таблицы `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user_shop`
--
ALTER TABLE `user_shop`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_shop_user_id_index` (`user_id`),
  ADD KEY `user_shop_shop_id_index` (`shop_id`);

--
-- Индексы таблицы `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `article`
--
ALTER TABLE `article`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `coupon`
--
ALTER TABLE `coupon`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `cron_email_message`
--
ALTER TABLE `cron_email_message`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `dynamic_field`
--
ALTER TABLE `dynamic_field`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `dynamic_value`
--
ALTER TABLE `dynamic_value`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `file`
--
ALTER TABLE `file`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT для таблицы `i18n_source_message`
--
ALTER TABLE `i18n_source_message`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT для таблицы `like`
--
ALTER TABLE `like`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `object_tag`
--
ALTER TABLE `object_tag`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `order`
--
ALTER TABLE `order`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `order_product`
--
ALTER TABLE `order_product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `page`
--
ALTER TABLE `page`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `product`
--
ALTER TABLE `product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `product_buy_with_this`
--
ALTER TABLE `product_buy_with_this`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `product_network`
--
ALTER TABLE `product_network`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `product_rating`
--
ALTER TABLE `product_rating`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `shop`
--
ALTER TABLE `shop`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `upwork`
--
ALTER TABLE `upwork`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `user_shop`
--
ALTER TABLE `user_shop`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `dynamic_field`
--
ALTER TABLE `dynamic_field`
  ADD CONSTRAINT `dynamic_field_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Ограничения внешнего ключа таблицы `dynamic_value`
--
ALTER TABLE `dynamic_value`
  ADD CONSTRAINT `dynamic_value_ibfk_1` FOREIGN KEY (`field_id`) REFERENCES `dynamic_field` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dynamic_value_ibfk_2` FOREIGN KEY (`object_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `i18n_message`
--
ALTER TABLE `i18n_message`
  ADD CONSTRAINT `fk_message_source_message` FOREIGN KEY (`id`) REFERENCES `i18n_source_message` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `like`
--
ALTER TABLE `like`
  ADD CONSTRAINT `like_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `object_tag`
--
ALTER TABLE `object_tag`
  ADD CONSTRAINT `object_tag_ibfk_1` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`);

--
-- Ограничения внешнего ключа таблицы `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`coupon_id`) REFERENCES `coupon` (`id`);

--
-- Ограничения внешнего ключа таблицы `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `order_product_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`),
  ADD CONSTRAINT `order_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Ограничения внешнего ключа таблицы `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `product_ibfk_3` FOREIGN KEY (`group_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `product_shop_id_foreign_key` FOREIGN KEY (`shop_id`) REFERENCES `shop` (`id`);

--
-- Ограничения внешнего ключа таблицы `product_buy_with_this`
--
ALTER TABLE `product_buy_with_this`
  ADD CONSTRAINT `buy_product_id_foreign_key` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_id_foreign_key` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `product_category`
--
ALTER TABLE `product_category`
  ADD CONSTRAINT `product_category_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `product_category_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Ограничения внешнего ключа таблицы `product_network`
--
ALTER TABLE `product_network`
  ADD CONSTRAINT `product_network_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Ограничения внешнего ключа таблицы `product_rating`
--
ALTER TABLE `product_rating`
  ADD CONSTRAINT `product_rating_ibfk_1` FOREIGN KEY (`id`) REFERENCES `comment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_rating_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `product_rating_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Ограничения внешнего ключа таблицы `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `user_profile_id` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `user_shop`
--
ALTER TABLE `user_shop`
  ADD CONSTRAINT `user_shop_shop_id_key` FOREIGN KEY (`shop_id`) REFERENCES `shop` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `user_shop_user_id_key` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

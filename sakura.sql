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

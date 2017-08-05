-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 05 2017 г., 21:29
-- Версия сервера: 5.7.16-log
-- Версия PHP: 7.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `l_shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `lshop_activations`
--

CREATE TABLE `lshop_activations` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `lshop_activations`
--

INSERT INTO `lshop_activations` (`id`, `user_id`, `code`, `completed`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'tRkoAWg4pMOZrIjdrgrq0RpXx7J6JqF0', 1, '2017-08-05 15:28:51', '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(2, 2, 'u9zZslMD7lsiG7Zd5gpvhoqWBWqW7fq5', 1, '2017-08-05 15:28:51', '2017-08-05 15:28:51', '2017-08-05 15:28:51');

-- --------------------------------------------------------

--
-- Структура таблицы `lshop_bans`
--

CREATE TABLE `lshop_bans` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `until` datetime DEFAULT NULL,
  `reason` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `lshop_cart`
--

CREATE TABLE `lshop_cart` (
  `id` int(10) UNSIGNED NOT NULL,
  `server` int(11) NOT NULL,
  `player` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `extra` text COLLATE utf8mb4_unicode_ci,
  `item_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `lshop_categories`
--

CREATE TABLE `lshop_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `server_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `lshop_categories`
--

INSERT INTO `lshop_categories` (`id`, `name`, `server_id`, `created_at`, `updated_at`) VALUES
(1, 'Blocks', 1, '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(2, 'Items', 1, '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(3, 'Armor', 2, '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(4, 'Items', 3, '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(5, 'Privileges', 1, '2017-08-05 15:28:51', '2017-08-05 15:28:51');

-- --------------------------------------------------------

--
-- Структура таблицы `lshop_items`
--

CREATE TABLE `lshop_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extra` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `lshop_items`
--

INSERT INTO `lshop_items` (`id`, `name`, `description`, `type`, `item`, `image`, `extra`, `created_at`, `updated_at`) VALUES
(5, 'Block of grass', '', 'item', '2', NULL, NULL, '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(6, 'TNT', '', 'item', '46', '784a013771bdf825d1cf26b49897a605.png', NULL, '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(7, 'Chest', '', 'item', '54', 'd6c6adf53d0145708ec54a41e8a4e3d8.png', NULL, '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(8, 'Furnace', '', 'item', '61', '4a69519aa46ee6b5b15bab8abd5139f3.png', NULL, '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(9, 'Diamond sword', '', 'item', '276', '9d8feda602d70231f0297a3b7e436d4b.png', NULL, '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(10, 'Diamond helmet', '', 'item', '310', 'd2714c56c81bcc4ff35798832226967f.png', NULL, '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(11, 'VIP', '', 'permgroup', 'vip', 'f0c9755f2685d55b7540c941b6f29ff9.png', NULL, '2017-08-05 15:28:51', '2017-08-05 15:28:51');

-- --------------------------------------------------------

--
-- Структура таблицы `lshop_migrations`
--

CREATE TABLE `lshop_migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `lshop_migrations`
--

INSERT INTO `lshop_migrations` (`id`, `migration`, `batch`) VALUES
(2, '2015_08_25_172600_create_settings_table', 1),
(12, '2017_02_08_173801_create_products_table', 3),
(13, '2017_02_08_184940_create_items_table', 3),
(14, '2017_02_10_145425_create_categories_table', 4),
(25, '2017_02_15_193645_create_payments_table', 6),
(26, '2014_07_02_230147_migration_cartalyst_sentinel', 7),
(27, '2017_04_10_172343_create_users_uuid_trigger', 8),
(29, '2017_04_15_165207_create_pages_table', 9),
(30, '2017_04_26_143915_create_news_table', 10),
(34, '2017_06_16_162242_create_bans_table', 11),
(37, '2017_02_06_120639_create_servers_table', 12),
(38, '2017_02_08_171826_create_cart_table', 13);

-- --------------------------------------------------------

--
-- Структура таблицы `lshop_news`
--

CREATE TABLE `lshop_news` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `lshop_news`
--

INSERT INTO `lshop_news` (`id`, `title`, `content`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'News 532', 'Veniam vel exercitationem cupiditate placeat suscipit. Vitae reprehenderit non ipsum dolorem excepturi. Enim provident expedita officiis consequatur eius dolores vel. Ullam ut fuga modi ipsum quis sit.\nQuia nobis rerum dicta in officia illo recusandae. Doloribus placeat sunt nesciunt exercitationem soluta dolores cum. Odit cumque asperiores eligendi dolore.\nUt in dolor facilis aut similique ea. Aliquid dolores alias similique. Rerum sed veniam saepe qui quaerat nobis quo aut. Laborum tempore nobis eos esse.\nUt veritatis voluptatem eveniet necessitatibus qui. Rerum iusto qui autem. Porro doloremque quaerat non excepturi ut. Nostrum ut reprehenderit error sed est ut.\nCum incidunt non odit amet. Dicta autem rerum quasi earum nisi quam.\nEum atque saepe corporis vitae. Quas non velit distinctio quasi minima non vel.\nEos qui corrupti in libero voluptas autem facere. Ducimus quod tempora quia rerum. Cumque iure ducimus molestiae maxime consequuntur explicabo. Facere natus libero omnis suscipit minima quaerat porro.', 1, '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(2, 'News 84', 'Modi temporibus in sint commodi eaque quis repellendus. Quo rem delectus est impedit quos incidunt ut. Quia sequi eos est voluptas rerum aliquam aut impedit.\nAt doloremque est similique quo in repellat necessitatibus culpa. Ipsa et reiciendis ratione aut. Et sit ut reprehenderit et et ut eum. Saepe dolores et omnis quo.\nQuo qui aliquid minus sint et harum. Voluptas minus id ab molestiae ea est quo. Autem aperiam totam et voluptatem temporibus omnis.\nAdipisci explicabo quisquam quo aut id sed repellendus. Qui enim quasi corporis rem. Veniam est animi porro nostrum sed itaque inventore. Ut excepturi dolor cupiditate modi cum.\nDolores nesciunt mollitia repellendus iste commodi. Voluptatem labore voluptatem asperiores itaque. Eos laudantium fugit repellat in culpa amet. Ipsam aut perspiciatis sapiente quo.\nLabore at ut ullam error. Quis totam voluptas velit nam quae. Autem eaque eum voluptate sunt corporis inventore sequi et. Ea aut est molestiae molestiae suscipit.', 1, '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(3, 'News 273', 'Est voluptatum eos rem eligendi dignissimos voluptas rem sunt. Quia molestiae perferendis non aut dicta. Ab odio et officia vitae sint ea recusandae. Magnam iure excepturi quibusdam aspernatur.\nCum est laborum ullam eos sequi. Totam in possimus velit voluptatem quidem.\nSed quia quidem id voluptatem atque tempora. Eum iste reprehenderit vel.\nBeatae quo necessitatibus alias. Occaecati officia et alias et quo non. Dolores illo quod voluptatem. Consequatur vero voluptates delectus consequatur saepe.\nAsperiores quo consequatur omnis sit facere corrupti non dolor. Sint amet sed eligendi omnis et illum. Aperiam voluptas soluta est iusto. Dicta dolorem in at.\nAut sed culpa quo voluptates eum nam mollitia. Quam distinctio voluptas ipsa similique laborum. Cum ad occaecati enim quia et excepturi eum.\nEt ut consectetur cumque tenetur id. Aliquid accusantium sed quia saepe modi. In eos dolorem velit aut ex.', 1, '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(4, 'News 955', 'Et deserunt quia ut facilis. Dolorem voluptatem qui voluptatibus ut. Enim at quo fugiat deserunt at.\nConsequatur illum dolorem sint ipsa illum sint. Inventore consequatur quisquam qui enim velit quas. Laboriosam necessitatibus ea culpa sapiente possimus velit voluptates. Quia delectus et aut voluptatem nobis.\nConsequatur ut tempore esse natus eaque dolorem error. Molestias aut hic facere voluptatem accusantium aperiam.\nVoluptatem autem voluptatum quidem maxime rem dolor eum. Voluptatem at voluptatem ratione non nobis qui assumenda. Incidunt ut consequatur blanditiis dolor harum nihil qui non.\nCorporis dolorem dolorem et dolores corporis. Dolore quo aut laboriosam sint. Non vitae ipsum incidunt velit eligendi dolor aliquam. Alias inventore sit fugiat excepturi enim aspernatur.\nEius quaerat aut atque expedita aut voluptatibus in deleniti. Error eum dolore in autem. Quam sunt corrupti necessitatibus est.\nUt sed accusantium inventore natus beatae. Enim ipsam cum aperiam saepe nihil aspernatur.', 1, '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(5, 'News 728', 'Optio esse ipsa corporis. Et ut eius dolorem eum tempore ea assumenda. Qui laborum molestiae excepturi sint necessitatibus consectetur eos. Et sed repellat voluptas est.\nIncidunt distinctio corrupti placeat dolores. Consectetur doloremque aut enim ut.\nQuod earum labore ullam qui dolorem est vero. Necessitatibus id voluptatem iusto. Eum iste dolorum quod ea animi. Qui qui nostrum numquam ex voluptatem rerum debitis laudantium.\nOptio ratione similique officiis veniam. Quam quos minus voluptatum quaerat cum. Aperiam quo vitae vitae qui. Praesentium perspiciatis voluptatem autem adipisci enim aliquid nostrum.\nIpsa veniam reprehenderit optio. Doloremque quisquam adipisci aut illo vero delectus facere. Doloribus ducimus iste dicta consectetur ut.\nCommodi et illo culpa rerum possimus. Ex voluptatem magnam deleniti voluptates. Facere aut earum saepe voluptas. Sit sit beatae ut.', 1, '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(6, 'News 250', 'Fugiat earum unde ratione quasi est. Tempore eligendi aut voluptatem assumenda aut amet quo. Fugit consequatur officia mollitia eum pariatur. Eaque optio cum a accusantium impedit accusamus.\nEaque veniam ad nulla ipsa reiciendis dicta. Enim voluptatibus officiis in ipsum assumenda molestias.\nOccaecati voluptatem harum fugiat qui fugiat aut esse. Repellat vero natus commodi recusandae optio aut. Rem ut repellat incidunt quae ea. Aut ab eos sit.\nOfficiis est esse soluta aut. Ut eligendi autem non dolorum exercitationem deleniti. Quasi omnis iure iure repellat dolor modi.\nEst numquam dolores ipsa et rerum. Officia natus non temporibus aliquam quisquam sapiente blanditiis laudantium. Vero ad iste deserunt sed. Vel non in laborum repellendus totam iusto.\nEst dolore impedit soluta voluptatem. Deleniti vel quas aut tempore ad voluptatem iusto sequi. Magnam unde ut nesciunt.\nDolorem consequuntur voluptate est sed optio et perferendis. Amet consectetur inventore nobis voluptate esse.', 1, '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(7, 'News 248', 'Voluptatem ut officiis et sint vel quos aperiam. Inventore labore accusantium rerum ea dolor id ratione alias. At dolorum est adipisci magni dolor voluptatibus. Temporibus non eum sint omnis et provident expedita.\nDistinctio facilis dolorem aut nisi et. Accusantium placeat qui quae deserunt beatae. Ullam soluta officia assumenda nisi incidunt saepe. Laborum ipsum ut nobis ut.\nDolores fuga debitis asperiores explicabo non reprehenderit aut. Quas hic nam ea. Et non ea itaque est. Ullam quam sequi enim. Architecto in ad ut minima recusandae quaerat.\nCorporis veritatis doloribus dolor repellat tempora iure ut. Sunt omnis rerum tenetur quibusdam enim et. Aut deserunt et magnam rerum voluptas.\nEt minus eos aut non voluptatibus impedit. Qui vel accusamus quae. Tempore et occaecati non enim sit. Dignissimos harum aut labore eum. Vero accusantium ipsum perferendis quo beatae ducimus.\nFacilis repudiandae est aut et. Molestiae et sit ipsam facilis consequatur. Nulla magnam id voluptas deleniti fugiat.', 1, '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(8, 'News 37', 'Aliquam est nam deleniti reiciendis. Dolorem et qui illo suscipit qui enim earum. Corrupti minus dolores officiis provident architecto. Dolores animi fuga sit possimus ut tenetur similique.\nTotam et quaerat tenetur. Unde quo recusandae reiciendis sunt magnam molestias. Natus eos sit sint nisi in. Exercitationem natus quaerat voluptatem blanditiis sunt dolorem.\nExplicabo expedita molestias sed rerum ab et minus. Sed enim quod repellendus quo nam ut. Nihil voluptates perferendis enim quisquam distinctio adipisci et.\nExpedita cupiditate facilis ab soluta eum consectetur eaque. Alias saepe ipsa voluptatibus iure praesentium. Vel nesciunt consequatur libero autem sunt dicta unde.\nEt dolore ea dicta hic ab ducimus. Deserunt sunt magnam architecto illum qui. Laudantium inventore sunt laborum tenetur.\nId tenetur debitis ea sit. Enim impedit consequatur adipisci autem blanditiis. Cumque voluptas aliquid quis voluptatum alias est.', 1, '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(9, 'News 313', 'Quae eaque labore eos et. Dignissimos suscipit sequi sit similique qui in similique. Et occaecati iure maiores est. Ipsa autem vero harum consequatur.\nSit illum omnis exercitationem aut laudantium. Et a iure facere saepe non quidem iusto.\nSunt voluptatem sed esse laudantium aspernatur. Perferendis vel non dolorem nihil laudantium architecto. Rerum tempora ut numquam ut nemo minima.\nNobis minima enim eligendi dignissimos. Accusantium ut nihil error. Adipisci expedita qui dignissimos dolorem est et. Voluptas ut quae rem dolore ut harum. Esse eius enim voluptatem deserunt totam ipsa voluptas dolorem.\nIpsam aut unde dolores neque. Vel inventore velit itaque eum. Molestiae eligendi ipsam et repellendus reiciendis voluptate. Est qui molestiae temporibus est ullam alias ullam.\nSit ea reprehenderit animi nemo voluptatem sunt. Ad non rem eveniet et ipsa dolores itaque aut. Laboriosam illum ut natus quasi qui velit. Et deserunt rerum distinctio aut aliquid aspernatur.', 1, '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(10, 'News 725', 'Alias voluptas non veniam omnis ipsum aut a. Debitis qui placeat aliquid aut. Tempore laboriosam expedita aut quis.\nQuo accusamus iusto porro. Natus itaque porro reiciendis voluptatem praesentium quo officia. Nostrum et excepturi aut numquam rerum et.\nAmet commodi esse et excepturi. Recusandae autem ut molestiae tempore. Eos vero qui commodi facilis vel. Qui voluptas consequatur aut quo. Unde repellat repudiandae modi architecto corrupti atque voluptatum.\nArchitecto placeat aut enim veritatis at nemo. Quisquam nulla qui et quia asperiores maxime est. Eum ut animi iure doloremque.\nAtque alias autem est unde error ad. Libero aut qui hic soluta suscipit. Cupiditate est et id recusandae dolor.\nDelectus modi consequatur quod dolor. Et quia ipsum ratione iste harum non et adipisci. Autem ut aut minus doloremque ut consequatur in. Et occaecati dicta est rem.', 1, '2017-08-05 15:28:51', '2017-08-05 15:28:51');

-- --------------------------------------------------------

--
-- Структура таблицы `lshop_pages`
--

CREATE TABLE `lshop_pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `lshop_pages`
--

INSERT INTO `lshop_pages` (`id`, `title`, `content`, `url`, `created_at`, `updated_at`) VALUES
(1, 'Welcome to L-Shop!', '<h1 style=\"text-align: center;\">Modern trading system for Minecraft</h1><br><p style=\"text-align: center; \"><img src=\"http://i90.fastpic.ru/big/2017/0309/9c/1cebb8e0e70a432b71102bf20334459c.png\" alt=\"Логотип L-Shop\"><br></p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce condimentum nibh quis lorem malesuada, lobortis accumsan felis consequat. Fusce ac tortor gravida, dignissim quam sit amet, laoreet sapien. Nam ultricies libero in dignissim accumsan. Fusce ac lacinia quam. Integer convallis neque ac tortor sollicitudin, ac mollis erat malesuada. Suspendisse sapien turpis, mollis et nibh non, mollis venenatis augue. Aenean et leo sed mi tristique fringilla.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Donec in nibh turpis. Phasellus tincidunt tristique scelerisque. Sed aliquam pretium mauris a mattis. Sed ante magna, facilisis vel lorem eget, rhoncus ullamcorper ligula. Nunc venenatis dolor nec libero interdum, non lobortis libero molestie. Vivamus aliquet lacus non eros ullamcorper, quis convallis nisl aliquet. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nunc posuere ipsum quam, in commodo dui auctor nec.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Praesent dapibus velit eu leo aliquam, accumsan interdum ex laoreet. Etiam nec vehicula odio. Sed aliquam bibendum convallis. Proin sodales id ligula et pellentesque. Ut ullamcorper magna nec convallis pulvinar. Aenean nunc eros, consequat non nibh in, bibendum convallis eros. Vestibulum elit neque, elementum at egestas a, ultricies eget nisi. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed dapibus metus nec nisi semper, eu fringilla diam aliquam. Fusce accumsan gravida justo, sit amet sollicitudin erat suscipit ac. Nulla rhoncus non elit in tempor. Vestibulum at ligula vitae diam dapibus lobortis at a nulla.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Curabitur ac cursus tortor. Donec posuere magna sit amet felis condimentum cursus et vitae dolor. Curabitur vitae mauris a leo consequat sagittis at at tortor. Fusce dui mi, pretium ut tincidunt at, vestibulum et velit. Quisque posuere eleifend velit, nec mattis leo viverra non. Curabitur placerat, neque in sodales eleifend, nisi tortor lacinia nunc, in varius neque ipsum fringilla urna. Morbi nec ipsum diam. Vestibulum tincidunt augue eleifend dictum rutrum. Etiam vel nibh scelerisque, tincidunt mauris et, lacinia orci. Sed consectetur pellentesque malesuada. Suspendisse eget lectus velit.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Donec viverra vehicula nunc, eget fringilla justo rutrum eget. Duis convallis convallis dapibus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse placerat sagittis lacus. Mauris in aliquet urna, id posuere nisl. Phasellus accumsan in metus vel ullamcorper. Praesent pulvinar iaculis mauris vitae vehicula. Nunc vehicula risus massa, a accumsan turpis ornare in. Suspendisse non mauris eu diam convallis finibus ut et ex. Fusce ut dui massa.</p>', 'welcome-to-L-Shop', '2017-08-05 15:28:51', '2017-08-05 15:28:51');

-- --------------------------------------------------------

--
-- Структура таблицы `lshop_payments`
--

CREATE TABLE `lshop_payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `service` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `products` text COLLATE utf8mb4_unicode_ci,
  `cost` double DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `server_id` int(11) DEFAULT NULL,
  `ip` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `lshop_persistences`
--

CREATE TABLE `lshop_persistences` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `lshop_products`
--

CREATE TABLE `lshop_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `price` int(10) UNSIGNED NOT NULL,
  `item_id` int(11) NOT NULL,
  `server_id` int(11) NOT NULL,
  `stack` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `sort_priority` float DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `lshop_products`
--

INSERT INTO `lshop_products` (`id`, `price`, `item_id`, `server_id`, `stack`, `category_id`, `sort_priority`, `created_at`, `updated_at`) VALUES
(14, 2, 5, 1, 64, 1, 0, '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(15, 20, 6, 1, 16, 1, 0, '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(16, 15, 7, 1, 16, 1, 0, '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(17, 15, 8, 1, 32, 1, 0, '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(18, 67, 9, 1, 1, 2, 0, '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(19, 54, 10, 2, 1, 3, 0, '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(20, 15, 11, 1, 1, 5, 0, '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(21, 100, 11, 1, 0, 5, 0, '2017-08-05 15:28:51', '2017-08-05 15:28:51');

-- --------------------------------------------------------

--
-- Структура таблицы `lshop_reminders`
--

CREATE TABLE `lshop_reminders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `lshop_roles`
--

CREATE TABLE `lshop_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `lshop_roles`
--

INSERT INTO `lshop_roles` (`id`, `slug`, `name`, `permissions`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrator', '{\"user.admin\":true}', '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(2, 'user', 'User', '{\"user.admin\":false}', '2017-08-05 15:28:51', '2017-08-05 15:28:51');

-- --------------------------------------------------------

--
-- Структура таблицы `lshop_role_users`
--

CREATE TABLE `lshop_role_users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `lshop_role_users`
--

INSERT INTO `lshop_role_users` (`user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(2, 2, '2017-08-05 15:28:51', '2017-08-05 15:28:51');

-- --------------------------------------------------------

--
-- Структура таблицы `lshop_servers`
--

CREATE TABLE `lshop_servers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `port` int(11) DEFAULT NULL,
  `password` int(11) DEFAULT NULL,
  `monitoring_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `lshop_servers`
--

INSERT INTO `lshop_servers` (`id`, `name`, `enabled`, `ip`, `port`, `password`, `monitoring_enabled`, `created_at`, `updated_at`) VALUES
(1, 'MMO', 1, '127.0.0.1', 25575, 123456, 0, '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(2, 'Hi-Tech (PvP)', 1, '127.0.0.1', 25564, 123456, 0, '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(3, 'Hi-Tech (PvE)', 1, NULL, NULL, NULL, 0, '2017-08-05 15:28:51', '2017-08-05 15:28:51');

-- --------------------------------------------------------

--
-- Структура таблицы `lshop_settings`
--

CREATE TABLE `lshop_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `lshop_settings`
--

INSERT INTO `lshop_settings` (`id`, `key`, `value`) VALUES
(1, 'catalog.products_per_page', '30'),
(2, 'shop.currency', 'USD'),
(3, 'shop.currency_html', '<i class=\"fa fa-usd\"></i>'),
(4, 'shop.description', 'Modern trading system for Minecraft'),
(5, 'shop.keywords', 'L-Shop,shop,buy,store,minecraft'),
(6, 'shop.name', 'L - Shop'),
(7, 'shop.access_mode', 'any'),
(8, 'shop.enable_signup', '1'),
(9, 'shop.enable_password_reset', '1'),
(10, 'shop.sort', 'name'),
(11, 'cart.capacity', '12'),
(12, 'payment.method.robokassa.enabled', '1'),
(13, 'payment.method.robokassa.login', ''),
(14, 'payment.method.robokassa.password1', ''),
(15, 'payment.method.robokassa.algo', 'sha512'),
(16, 'payment.method.robokassa.password2', ''),
(17, 'payment.method.robokassa.test', '1'),
(18, 'payment.method.interkassa.key', ''),
(19, 'payment.method.interkassa.test', '0'),
(20, 'payment.method.interkassa.algo', 'sha256'),
(21, 'payment.method.interkassa.checkout_id', ''),
(22, 'payment.method.interkassa.test_key', ''),
(23, 'payment.method.interkassa.enabled', '1'),
(24, 'payment.method.interkassa.currency', ''),
(25, 'payment.fillupbalance.minsum', '25'),
(26, 'distributor.name', 'ShoppingCart'),
(27, 'recaptcha.public_key', ''),
(28, 'recaptcha.secret_key', ''),
(29, 'profile.payments_per_page', '25'),
(30, 'profile.cart_items_per_page', '25'),
(31, 'profile.character.skin.enabled', '1'),
(32, 'profile.character.skin.hd', '1'),
(33, 'profile.character.skin.max_size', '768'),
(34, 'profile.character.cloak.enabled', '1'),
(35, 'profile.character.cloak.hd', '1'),
(36, 'profile.character.cloak.max_size', '512'),
(37, 'auth.email_activation', '0'),
(38, 'auth.signup.redirect', '0'),
(39, 'auth.signup.redirect_url', 'http://l-shop.ru/servers'),
(40, 'user.enable_change_password', '1'),
(41, 'api.launcher.sashok.auth.error_message', 'User with this credentials not found'),
(42, 'api.launcher.sashok.auth.enabled', '1'),
(43, 'api.launcher.sashok.auth.ips_white_list', '[]'),
(44, 'api.launcher.sashok.auth.format', 'OK:{username}'),
(45, 'api.key', 'pIkHkipkTKhpeC$ZY)OlnFH$fZWUullL'),
(46, 'api.algo', 'sha512'),
(47, 'api.signin.remember_user', '1'),
(48, 'api.signin.enabled', '0'),
(49, 'api.enabled', '0'),
(50, 'api.separator', ':'),
(51, 'api.salt', '0'),
(52, 'api.signup.enabled', '1'),
(53, 'caching.statistic.ttl', '60'),
(54, 'caching.pages.ttl', '3600'),
(55, 'caching.news.ttl', '600'),
(56, 'caching.monitoring.ttl', '10'),
(57, 'news.first_portion', '15'),
(58, 'news.per_page', '15'),
(59, 'news.enabled', '1'),
(60, 'monitoring.rcon.timeout', '1'),
(61, 'monitoring.enabled', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `lshop_throttle`
--

CREATE TABLE `lshop_throttle` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `lshop_users`
--

CREATE TABLE `lshop_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8mb4_unicode_ci,
  `last_login` timestamp NULL DEFAULT NULL,
  `balance` double UNSIGNED NOT NULL DEFAULT '0',
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accessToken` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serverID` varchar(41) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `lshop_users`
--

INSERT INTO `lshop_users` (`id`, `username`, `email`, `password`, `permissions`, `last_login`, `balance`, `uuid`, `accessToken`, `serverID`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@example.com', '$2y$10$Is2kXKNLK4ggAiSwMYI1u.EwnpDmcSDyB402WKAw2WtSMDdkMlZSG', NULL, NULL, 1000, 'edfad55c-7a0b-11e7-8ca0-0a002700000e', NULL, NULL, '2017-08-05 15:28:51', '2017-08-05 15:28:51'),
(2, 'user', 'user@example.com', '$2y$10$nbn7tbH.a3Ak4Mxe45ozPeNVNBgDovHpNqG6Vo0ZwyA5c8QSoKYiC', NULL, NULL, 0, 'ee071b18-7a0b-11e7-8ca0-0a002700000e', NULL, NULL, '2017-08-05 15:28:51', '2017-08-05 15:28:51');

--
-- Триггеры `lshop_users`
--
DELIMITER $$
CREATE TRIGGER `setUUID` BEFORE INSERT ON `lshop_users` FOR EACH ROW BEGIN
  IF NEW.uuid IS NULL THEN
    SET NEW.uuid = UUID();
  END IF;
END
$$
DELIMITER ;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `lshop_activations`
--
ALTER TABLE `lshop_activations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `lshop_bans`
--
ALTER TABLE `lshop_bans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bans_user_id_unique` (`user_id`),
  ADD KEY `bans_user_id_index` (`user_id`);

--
-- Индексы таблицы `lshop_cart`
--
ALTER TABLE `lshop_cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_player_index` (`player`);

--
-- Индексы таблицы `lshop_categories`
--
ALTER TABLE `lshop_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lshop_categories_server_id_index` (`server_id`);

--
-- Индексы таблицы `lshop_items`
--
ALTER TABLE `lshop_items`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `lshop_migrations`
--
ALTER TABLE `lshop_migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `lshop_news`
--
ALTER TABLE `lshop_news`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `lshop_pages`
--
ALTER TABLE `lshop_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_url_unique` (`url`);

--
-- Индексы таблицы `lshop_payments`
--
ALTER TABLE `lshop_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_user_id_server_id_index` (`user_id`,`server_id`);

--
-- Индексы таблицы `lshop_persistences`
--
ALTER TABLE `lshop_persistences`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `persistences_code_unique` (`code`);

--
-- Индексы таблицы `lshop_products`
--
ALTER TABLE `lshop_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goods_item_id_server_id_index` (`item_id`,`server_id`);

--
-- Индексы таблицы `lshop_reminders`
--
ALTER TABLE `lshop_reminders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `lshop_roles`
--
ALTER TABLE `lshop_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Индексы таблицы `lshop_role_users`
--
ALTER TABLE `lshop_role_users`
  ADD PRIMARY KEY (`user_id`,`role_id`);

--
-- Индексы таблицы `lshop_servers`
--
ALTER TABLE `lshop_servers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `lshop_settings`
--
ALTER TABLE `lshop_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `settings_key_index` (`key`);

--
-- Индексы таблицы `lshop_throttle`
--
ALTER TABLE `lshop_throttle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `throttle_user_id_index` (`user_id`);

--
-- Индексы таблицы `lshop_users`
--
ALTER TABLE `lshop_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_uuid_unique` (`username`,`uuid`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `lshop_activations`
--
ALTER TABLE `lshop_activations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `lshop_bans`
--
ALTER TABLE `lshop_bans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `lshop_cart`
--
ALTER TABLE `lshop_cart`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `lshop_categories`
--
ALTER TABLE `lshop_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `lshop_items`
--
ALTER TABLE `lshop_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT для таблицы `lshop_migrations`
--
ALTER TABLE `lshop_migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT для таблицы `lshop_news`
--
ALTER TABLE `lshop_news`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT для таблицы `lshop_pages`
--
ALTER TABLE `lshop_pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `lshop_payments`
--
ALTER TABLE `lshop_payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `lshop_persistences`
--
ALTER TABLE `lshop_persistences`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `lshop_products`
--
ALTER TABLE `lshop_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT для таблицы `lshop_reminders`
--
ALTER TABLE `lshop_reminders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `lshop_roles`
--
ALTER TABLE `lshop_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `lshop_servers`
--
ALTER TABLE `lshop_servers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `lshop_settings`
--
ALTER TABLE `lshop_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT для таблицы `lshop_throttle`
--
ALTER TABLE `lshop_throttle`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `lshop_users`
--
ALTER TABLE `lshop_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

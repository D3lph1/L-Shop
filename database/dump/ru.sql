-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 08 2017 г., 22:34
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
(1, 1, 'YUuJN3AJABeDIIYOnQiFX8c8g4Vn06fl', 1, '2017-09-08 16:34:51', '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(2, 2, 'PtXGxMyWTsdMpUrNIdGiUbD7ytnSk2TM', 1, '2017-09-08 16:34:51', '2017-09-08 16:34:51', '2017-09-08 16:34:51');

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `lshop_categories`
--

INSERT INTO `lshop_categories` (`id`, `name`, `server_id`, `created_at`, `updated_at`) VALUES
(1, 'Блоки', 1, '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(2, 'Предметы', 1, '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(3, 'Броня', 2, '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(4, 'Предметы', 3, '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(5, 'Привилегии', 1, '2017-09-08 16:34:51', '2017-09-08 16:34:51');

-- --------------------------------------------------------

--
-- Структура таблицы `lshop_items`
--

CREATE TABLE `lshop_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extra` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `lshop_items`
--

INSERT INTO `lshop_items` (`id`, `name`, `description`, `type`, `item`, `image`, `extra`, `created_at`, `updated_at`) VALUES
(5, 'Блок травы', '', 'item', '2', NULL, NULL, '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(6, 'Динамит', '', 'item', '46', '784a013771bdf825d1cf26b49897a605.png', NULL, '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(7, 'Сундук', '', 'item', '54', 'd6c6adf53d0145708ec54a41e8a4e3d8.png', NULL, '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(8, 'Печь', '', 'item', '61', '4a69519aa46ee6b5b15bab8abd5139f3.png', NULL, '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(9, 'Алмазный меч', '', 'item', '276', '9d8feda602d70231f0297a3b7e436d4b.png', NULL, '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(10, 'Алмазный шлем', '', 'item', '310', 'd2714c56c81bcc4ff35798832226967f.png', NULL, '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(11, 'VIP', '', 'permgroup', 'vip', 'f0c9755f2685d55b7540c941b6f29ff9.png', NULL, '2017-09-08 16:34:51', '2017-09-08 16:34:51');

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
(1, '2014_07_02_230147_migration_cartalyst_sentinel', 1),
(2, '2015_08_25_172600_create_settings_table', 1),
(3, '2017_02_06_120639_create_servers_table', 1),
(4, '2017_02_08_171826_create_cart_table', 1),
(5, '2017_02_08_173801_create_products_table', 1),
(6, '2017_02_08_184940_create_items_table', 1),
(7, '2017_02_10_145425_create_categories_table', 1),
(8, '2017_02_15_193645_create_payments_table', 1),
(9, '2017_04_10_172343_create_users_uuid_trigger', 1),
(10, '2017_04_15_165207_create_pages_table', 1),
(11, '2017_04_26_143915_create_news_table', 1),
(12, '2017_06_16_162242_create_bans_table', 1);

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
(1, 'Новость 640', 'Modi sit vel fuga ea ut tempore nihil animi. Ex dolores dolores ea autem et vel a. Beatae et dolor nam.\nVel voluptates quia et dolor placeat id fugit. Facilis culpa accusantium quod omnis. Soluta sed expedita et culpa eum saepe. Et id dolorum occaecati mollitia natus natus.\nNon in totam blanditiis. Omnis nobis ipsa deleniti cumque.\nQuod ea nostrum eos fugit. Dolorem qui quia voluptatibus ex unde. Ipsam eos dolores et iusto pariatur.\nPerspiciatis error ea nam ullam. Cum incidunt quasi dignissimos voluptates at.\nProvident blanditiis ut eveniet cupiditate veritatis vel quod. Eum commodi dolorem dolorem consequuntur voluptas incidunt. Sequi hic non dolore laborum. Corporis aut nihil aliquam et molestias.\nVoluptates omnis voluptatem quis excepturi eveniet eligendi. Dignissimos et repellendus assumenda odit. Fugiat debitis odit magnam nihil voluptatibus mollitia sed. Aut placeat unde et quibusdam ratione.\nNobis et inventore cupiditate. Autem saepe velit amet ea accusamus cumque et.', 1, '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(2, 'Новость 945', 'Quaerat aut temporibus vero dignissimos numquam iusto. Ex quae eos sit consectetur autem sit eligendi. Tempora quas provident et atque id animi enim rem.\nQuam consequatur eius voluptatem corporis ratione asperiores est. Iusto aperiam tempora et ipsa. Qui deserunt nobis dolorem aperiam repudiandae modi. Debitis animi molestias optio voluptatibus voluptas.\nQui sequi voluptates nulla quia aut tempora. Vero blanditiis architecto corporis. Soluta quia nihil sit in enim autem quia. Voluptatem suscipit tempore dolore dolores ab quibusdam.\nSoluta non tenetur a repellendus. Nemo rerum illum ea et. Consequatur eaque nostrum itaque explicabo qui. Qui nobis iusto repudiandae dolorem sit vero adipisci sit.\nDoloribus officia ipsam reprehenderit voluptatum maxime aperiam suscipit. Expedita consequatur rem ipsa pariatur dolore. At dolores tempora aut consequatur recusandae quas rerum. Dignissimos dolores voluptas quia rerum fugit fugiat et. Est beatae placeat ipsam magnam eos voluptatibus.', 1, '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(3, 'Новость 930', 'Nihil accusamus voluptatem molestiae id. Cumque quia ea tempora fuga. Magni facilis saepe corrupti. Et laboriosam eligendi dolores iste qui.\nCulpa non aperiam ut totam est. Laborum molestiae necessitatibus assumenda laboriosam occaecati qui. Quidem corrupti sed saepe et porro debitis. Ratione fuga officia corporis qui doloremque et.\nQuod magnam quae laborum repellat eos et aliquid. Deserunt reprehenderit aut officia modi. Reiciendis perferendis delectus culpa consequatur culpa.\nOmnis ut nisi quia veniam officiis. Accusantium qui numquam quibusdam qui. Et iste vero eveniet perspiciatis eveniet. Iste aliquam repellat cupiditate nostrum asperiores.\nNostrum inventore quas minima ut quas autem. Sint eius ducimus aperiam nobis veniam harum.\nOmnis et voluptate non est. Perspiciatis sequi consequatur cumque fugit. Aspernatur iste dolor dignissimos accusamus qui nam. Mollitia quae sed labore officia officiis est porro.', 1, '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(4, 'Новость 882', 'Error ratione cumque quia est. Dolorum qui tenetur dolor nihil. Molestiae odio ut aut consequatur tenetur. In hic rerum quam aspernatur libero ut et. Et asperiores maxime aliquid sed quaerat labore quia.\nFacilis voluptatem est maxime velit. Optio quia ea dolore illo sed. Nobis quia non consequatur quasi. Reprehenderit excepturi vero vero et error.\nPossimus ut repellendus qui voluptatem et. Harum hic molestiae reiciendis. Aut quisquam suscipit non in.\nIusto rerum rerum facere voluptatem quas voluptates. Et deleniti dolorem accusamus similique asperiores. Officia aut ipsum unde voluptates distinctio non.\nFugit ea veniam architecto qui consequuntur rem adipisci. Aliquid corrupti ipsa est quam. Commodi libero quo autem aliquam totam. Quia unde nemo et consequatur ipsa quis animi.\nNumquam sunt corporis fugit qui consequuntur eveniet ullam. Itaque deleniti et eum illo aperiam ipsum. Possimus ea hic fugiat aspernatur necessitatibus aut nisi. Eaque dolores quia dolorem qui. Aut recusandae dolores voluptas aut est.', 1, '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(5, 'Новость 255', 'Dolore dolores pariatur eius. Aut eum ullam magni fugiat pariatur. Eos dolor corporis ratione fuga. Dolores quo aperiam facilis quibusdam aut. Cum id explicabo eaque qui.\nAtque ipsam facere sit dignissimos ab. Recusandae quia excepturi exercitationem quas vel. Nisi labore vero ipsam incidunt quo hic aperiam explicabo.\nQuasi consequatur sunt placeat quis sit quaerat. Et sint minus vel tempore aliquam. Tenetur nam numquam autem beatae sunt.\nQuo reprehenderit est quibusdam consequatur eos. Necessitatibus ut facilis id fuga laboriosam odit enim. Mollitia non aut esse tempora.\nAut iusto ut nam laboriosam. Exercitationem suscipit est perspiciatis provident rerum mollitia molestias. Consequatur explicabo eum inventore a ut ut.\nQui qui amet consequatur eligendi eum. Aut sint unde ut et dolore autem voluptas. In quo enim repellat commodi atque placeat inventore nobis.', 1, '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(6, 'Новость 246', 'Cum sed non sed magni. Est voluptate nihil ut est vel maxime a. Voluptatem voluptatem asperiores rerum vel voluptatem autem.\nMagnam necessitatibus quia rerum qui nulla. Blanditiis magnam explicabo aliquid necessitatibus veritatis inventore dolorem. Sint cum odio voluptatem rerum. Earum recusandae voluptatum aliquam est et quia.\nPraesentium perferendis et quis nisi quis nam sed esse. Et minima aperiam ea quo. Fugiat et a vero sint in. Libero at eum ut maiores aut iure.\nAut voluptas dolorem non veritatis et aperiam. Perspiciatis suscipit perferendis fuga quis temporibus a. Deserunt quam vel expedita corporis.\nIn facilis debitis maiores. Quod recusandae at et cumque iure qui. Explicabo et aut sunt ut ut. Similique molestiae doloribus veniam voluptas.\nNostrum eaque placeat architecto ullam. In eos adipisci sed ullam aperiam libero deserunt ab. Qui possimus sunt mollitia nihil.', 1, '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(7, 'Новость 669', 'Et sit cupiditate laboriosam ab perferendis nihil at. Ut omnis et fuga earum exercitationem dolore. Ducimus eaque eligendi error cumque nobis est. Tenetur rerum eum laborum.\nEt est voluptate et sed. Ipsam asperiores deleniti ipsum id aut nihil. Ipsam quia possimus esse sed sunt et officia.\nVel voluptatem laboriosam aut ipsa. Suscipit veritatis temporibus aliquam quasi ad vel ipsum. Autem quasi qui ut aut velit laboriosam quibusdam. Nihil labore eum tenetur animi nemo est.\nOccaecati reprehenderit dolore ratione non. Quia ea veniam consequatur. Itaque totam ea dolorum magni ducimus aliquam ducimus.\nConsequatur amet fuga dolores quo velit quod. Ad corrupti minima ducimus voluptas dicta nam aliquam libero. Aut dolor ut dignissimos cumque. A sit omnis quos vitae. Dolorum eum et tenetur beatae commodi fugit sit.\nVoluptas voluptatem nemo distinctio tempora ea. Qui est rerum ut vero expedita qui molestiae autem. Error unde ea minus quos. Nihil temporibus quas officiis ut.', 1, '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(8, 'Новость 614', 'Corporis beatae rem temporibus ut ea et quaerat. Necessitatibus officia est minus sint voluptatem. Asperiores quisquam qui non est impedit mollitia quia. Nostrum dicta consequuntur placeat facilis quia. Rem aut et eaque id.\nVelit quis similique est hic. Et aut consectetur suscipit eos occaecati consequuntur ea quam. Veniam omnis et quo et sint. Perferendis labore provident quo enim non rerum.\nVoluptatum veritatis quisquam consequatur voluptatum et. Quia quis dolorem quae dolores sit iste ab. Minima libero quis debitis odit facilis consequuntur.\nMaxime temporibus minima consequuntur ut est ad. Temporibus porro temporibus a error quis voluptatibus. Id et eum aliquid sunt. Est perspiciatis qui tempore sit magnam ut assumenda consequatur.\nSed enim atque assumenda. Natus harum nobis quo qui aliquam. Optio adipisci enim facilis neque voluptatem modi commodi.', 1, '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(9, 'Новость 265', 'Et nesciunt quia dolorem dolores quos provident cupiditate. Qui iste non ratione et voluptates ut. Est nesciunt odio quia aut iusto odit officiis. Optio suscipit et ea sed.\nAd veniam esse rem impedit. Autem id impedit quos reiciendis quibusdam.\nQui earum aliquam modi omnis et. Ut est neque quas eaque ea neque. Voluptas quod ea perferendis consequuntur. Et aperiam placeat voluptate sed.\nIste a consequuntur ex modi similique dolor et. Facilis veniam nostrum sapiente. Ipsam consequatur eum expedita ex.\nConsequatur harum quis esse repellat assumenda. Deserunt nulla voluptate animi.\nIusto tempore velit eius expedita nihil sit ipsum. Nobis nihil qui quia labore neque modi similique illum. Est quis culpa beatae odit totam neque.\nHarum modi consequatur accusantium asperiores voluptatem. Ex aut rerum eum exercitationem quibusdam porro. Distinctio voluptates voluptas amet veniam rerum dolorem. Eveniet praesentium voluptatem soluta quas voluptate.', 1, '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(10, 'Новость 797', 'Ducimus perferendis minus quidem qui laborum magnam. Dolorem mollitia consequatur dicta est ea et molestias. Aut perferendis dolore quaerat quisquam.\nEnim excepturi dolor repellat aut unde illo. Soluta et nesciunt consequatur autem. Eum et incidunt tempora.\nCum commodi non blanditiis. Rerum accusantium molestias facilis quaerat id consectetur fugiat.\nNesciunt quis et qui. Ea dolore modi accusamus aliquam. Deleniti fuga non doloremque et. Et consequatur aut inventore repellat ipsa assumenda labore.\nEt rerum placeat autem optio unde. Dolorum tenetur porro nisi aut laborum.\nEst quam perspiciatis ut molestiae iusto eum. Aut doloremque odit optio ut tempore. Mollitia delectus facilis id laborum magnam.\nOdit nemo ipsa cum soluta et rerum. Similique dolores voluptas consectetur cupiditate deserunt libero odit. Nihil ipsam impedit blanditiis ducimus animi pariatur.', 1, '2017-09-08 16:34:51', '2017-09-08 16:34:51');

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
(1, 'Добро пожаловать в L-Shop!', '<h1 style=\"text-align: center;\">Современная торговая система для Minecraft</h1><br><p style=\"text-align: center; \"><img src=\"http://i90.fastpic.ru/big/2017/0309/9c/1cebb8e0e70a432b71102bf20334459c.png\" alt=\"Логотип L-Shop\"><br></p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce condimentum nibh quis lorem malesuada, lobortis accumsan felis consequat. Fusce ac tortor gravida, dignissim quam sit amet, laoreet sapien. Nam ultricies libero in dignissim accumsan. Fusce ac lacinia quam. Integer convallis neque ac tortor sollicitudin, ac mollis erat malesuada. Suspendisse sapien turpis, mollis et nibh non, mollis venenatis augue. Aenean et leo sed mi tristique fringilla.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Donec in nibh turpis. Phasellus tincidunt tristique scelerisque. Sed aliquam pretium mauris a mattis. Sed ante magna, facilisis vel lorem eget, rhoncus ullamcorper ligula. Nunc venenatis dolor nec libero interdum, non lobortis libero molestie. Vivamus aliquet lacus non eros ullamcorper, quis convallis nisl aliquet. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nunc posuere ipsum quam, in commodo dui auctor nec.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Praesent dapibus velit eu leo aliquam, accumsan interdum ex laoreet. Etiam nec vehicula odio. Sed aliquam bibendum convallis. Proin sodales id ligula et pellentesque. Ut ullamcorper magna nec convallis pulvinar. Aenean nunc eros, consequat non nibh in, bibendum convallis eros. Vestibulum elit neque, elementum at egestas a, ultricies eget nisi. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed dapibus metus nec nisi semper, eu fringilla diam aliquam. Fusce accumsan gravida justo, sit amet sollicitudin erat suscipit ac. Nulla rhoncus non elit in tempor. Vestibulum at ligula vitae diam dapibus lobortis at a nulla.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Curabitur ac cursus tortor. Donec posuere magna sit amet felis condimentum cursus et vitae dolor. Curabitur vitae mauris a leo consequat sagittis at at tortor. Fusce dui mi, pretium ut tincidunt at, vestibulum et velit. Quisque posuere eleifend velit, nec mattis leo viverra non. Curabitur placerat, neque in sodales eleifend, nisi tortor lacinia nunc, in varius neque ipsum fringilla urna. Morbi nec ipsum diam. Vestibulum tincidunt augue eleifend dictum rutrum. Etiam vel nibh scelerisque, tincidunt mauris et, lacinia orci. Sed consectetur pellentesque malesuada. Suspendisse eget lectus velit.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Donec viverra vehicula nunc, eget fringilla justo rutrum eget. Duis convallis convallis dapibus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse placerat sagittis lacus. Mauris in aliquet urna, id posuere nisl. Phasellus accumsan in metus vel ullamcorper. Praesent pulvinar iaculis mauris vitae vehicula. Nunc vehicula risus massa, a accumsan turpis ornare in. Suspendisse non mauris eu diam convallis finibus ut et ex. Fusce ut dui massa.</p>', 'welcome-to-L-Shop', '2017-09-08 16:34:51', '2017-09-08 16:34:51');

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
  `stack` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sort_priority` double(8,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `lshop_products`
--

INSERT INTO `lshop_products` (`id`, `price`, `item_id`, `server_id`, `stack`, `category_id`, `sort_priority`, `created_at`, `updated_at`) VALUES
(14, 2, 5, 1, 64, 1, 0.00, '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(15, 20, 6, 1, 16, 1, 0.00, '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(16, 15, 7, 1, 16, 1, 0.00, '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(17, 15, 8, 1, 32, 1, 0.00, '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(18, 67, 9, 1, 1, 2, 0.00, '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(19, 54, 10, 2, 1, 3, 0.00, '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(20, 15, 11, 1, 1, 5, 0.00, '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(21, 100, 11, 1, 0, 5, 0.00, '2017-09-08 16:34:51', '2017-09-08 16:34:51');

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
(1, 'admin', 'Администратор', '{\"user.admin\":true}', '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(2, 'user', 'Пользователь', '{\"user.admin\":false}', '2017-09-08 16:34:51', '2017-09-08 16:34:51');

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
(1, 1, '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(2, 2, '2017-09-08 16:34:51', '2017-09-08 16:34:51');

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
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `monitoring_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `lshop_servers`
--

INSERT INTO `lshop_servers` (`id`, `name`, `enabled`, `ip`, `port`, `password`, `monitoring_enabled`, `created_at`, `updated_at`) VALUES
(1, 'MMO', 1, '127.0.0.1', 25575, '123456', 0, '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(2, 'Hi-Tech (PvP)', 1, '127.0.0.1', 25564, '123456', 0, '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(3, 'Hi-Tech (PvE)', 1, NULL, NULL, NULL, 0, '2017-09-08 16:34:51', '2017-09-08 16:34:51');

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
(1, 'api.algo', 'sha512'),
(2, 'api.enabled', '0'),
(3, 'api.key', 'pIkHkipkTKhpeC$ZY)OlnFH$fZWUullL'),
(4, 'api.launcher.sashok.auth.enabled', '1'),
(5, 'api.launcher.sashok.auth.error_message', 'Пользователь с такими данными не найден'),
(6, 'api.launcher.sashok.auth.format', 'OK:{username}'),
(7, 'api.launcher.sashok.auth.ips_white_list', '[]'),
(8, 'api.salt', '0'),
(9, 'api.separator', ':'),
(10, 'api.signin.enabled', '0'),
(11, 'api.signin.remember_user', '1'),
(12, 'api.signup.enabled', '1'),
(13, 'auth.email_activation', '0'),
(14, 'auth.signup.redirect', '0'),
(15, 'auth.signup.redirect_url', 'http://l-shop.ru/servers'),
(16, 'caching.monitoring.ttl', '10'),
(17, 'caching.news.ttl', '600'),
(18, 'caching.pages.ttl', '3600'),
(19, 'caching.statistic.ttl', '60'),
(20, 'cart.capacity', '12'),
(21, 'catalog.products_per_page', '30'),
(22, 'distributor.name', 'ShoppingCart'),
(23, 'monitoring.enabled', '1'),
(24, 'monitoring.rcon.timeout', '1'),
(25, 'news.enabled', '1'),
(26, 'news.first_portion', '15'),
(27, 'news.per_page', '15'),
(28, 'payment.fillupbalance.minsum', '25'),
(29, 'payment.method.interkassa.algo', 'sha256'),
(30, 'payment.method.interkassa.checkout_id', ''),
(31, 'payment.method.interkassa.currency', ''),
(32, 'payment.method.interkassa.enabled', '1'),
(33, 'payment.method.interkassa.key', ''),
(34, 'payment.method.interkassa.test', '0'),
(35, 'payment.method.interkassa.test_key', ''),
(36, 'payment.method.robokassa.algo', 'sha512'),
(37, 'payment.method.robokassa.enabled', '1'),
(38, 'payment.method.robokassa.login', ''),
(39, 'payment.method.robokassa.password1', ''),
(40, 'payment.method.robokassa.password2', ''),
(41, 'payment.method.robokassa.test', '1'),
(42, 'profile.cart_items_per_page', '25'),
(43, 'profile.character.cloak.enabled', '1'),
(44, 'profile.character.cloak.hd', '1'),
(45, 'profile.character.cloak.max_size', '512'),
(46, 'profile.character.skin.enabled', '1'),
(47, 'profile.character.skin.hd', '1'),
(48, 'profile.character.skin.max_size', '768'),
(49, 'profile.payments_per_page', '25'),
(50, 'recaptcha.public_key', ''),
(51, 'recaptcha.secret_key', ''),
(52, 'shop.access_mode', 'any'),
(53, 'shop.currency', 'Руб.'),
(54, 'shop.currency_html', '<i class=\"fa fa-rub\"></i>'),
(55, 'shop.description', 'Современная торговая система для Minecraft'),
(56, 'shop.enable_password_reset', '1'),
(57, 'shop.enable_signup', '1'),
(58, 'shop.keywords', 'L-Shop,магазин,купить,minecraft,майнкрафт'),
(59, 'shop.name', 'L - Shop'),
(60, 'shop.sort', 'name'),
(61, 'user.enable_change_password', '1');

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
(1, 'admin', 'admin@example.com', '$2y$10$c0cg78X1qL1jcwF4AMXwae1xB03w1Smxec.S5s7EIg1qpCscERvca', NULL, NULL, 1000, 'c8524c2e-94cc-11e7-ac5e-0a0027000010', NULL, NULL, '2017-09-08 16:34:51', '2017-09-08 16:34:51'),
(2, 'user', 'user@example.com', '$2y$10$YUAdXWa7AG96kvg.ZzSUv.vQ63vDWsdLwoTLPDodu.eFjm4.FTu.y', NULL, NULL, 0, 'c85eb40e-94cc-11e7-ac5e-0a0027000010', NULL, NULL, '2017-09-08 16:34:51', '2017-09-08 16:34:51');

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
  ADD KEY `categories_server_id_index` (`server_id`);

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
  ADD KEY `products_item_id_server_id_index` (`item_id`,`server_id`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
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

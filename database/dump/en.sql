-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 30 2017 г., 14:45
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
(1, 1, 'zy1GnvYLocrMGnBfq4PxzTXq5zo3oxue', 1, '2017-07-30 08:45:07', '2017-07-30 08:45:07', '2017-07-30 08:45:07'),
(2, 2, '9AGIgCpjwFiYizFGdZY5JRkguNh05PbS', 1, '2017-07-30 08:45:07', '2017-07-30 08:45:07', '2017-07-30 08:45:07');

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
(1, 'Blocks', 1, '2017-07-30 08:45:08', '2017-07-30 08:45:08'),
(2, 'Items', 1, '2017-07-30 08:45:08', '2017-07-30 08:45:08'),
(3, 'Armor', 2, '2017-07-30 08:45:08', '2017-07-30 08:45:08'),
(4, 'Items', 3, '2017-07-30 08:45:08', '2017-07-30 08:45:08'),
(5, 'Privileges', 1, '2017-07-30 08:45:08', '2017-07-30 08:45:08');

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
(5, 'Block of grass', '', 'item', '2', NULL, NULL, '2017-07-30 08:45:08', '2017-07-30 08:45:08'),
(6, 'TNT', '', 'item', '46', '784a013771bdf825d1cf26b49897a605.png', NULL, '2017-07-30 08:45:08', '2017-07-30 08:45:08'),
(7, 'Chest', '', 'item', '54', 'd6c6adf53d0145708ec54a41e8a4e3d8.png', NULL, '2017-07-30 08:45:08', '2017-07-30 08:45:08'),
(8, 'Furnace', '', 'item', '61', '4a69519aa46ee6b5b15bab8abd5139f3.png', NULL, '2017-07-30 08:45:08', '2017-07-30 08:45:08'),
(9, 'Diamond sword', '', 'item', '276', '9d8feda602d70231f0297a3b7e436d4b.png', NULL, '2017-07-30 08:45:08', '2017-07-30 08:45:08'),
(10, 'Diamond helmet', '', 'item', '310', 'd2714c56c81bcc4ff35798832226967f.png', NULL, '2017-07-30 08:45:08', '2017-07-30 08:45:08'),
(11, 'VIP', '', 'permgroup', 'vip', 'f0c9755f2685d55b7540c941b6f29ff9.png', NULL, '2017-07-30 08:45:08', '2017-07-30 08:45:08');

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
(1, 'News 846', 'Quidem sunt optio numquam aspernatur. Tempora voluptates et eos beatae. Veritatis voluptatem voluptates laboriosam.\nBeatae non occaecati architecto et similique rerum vel. Rem autem et cupiditate enim non. Ut nam et iusto voluptates. Aut debitis velit enim laborum iste velit voluptatem minus. Eos aspernatur quia exercitationem quia provident.\nUnde commodi corporis ipsam numquam recusandae delectus est dolore. Rerum est nisi temporibus.\nAdipisci perspiciatis cupiditate accusamus. Veniam aut quia adipisci omnis quisquam architecto voluptate. Cumque minus aut debitis iure.\nEnim quam non aut corporis repudiandae id soluta sit. Ipsum omnis saepe eum qui architecto neque consequuntur eos. Eum nesciunt architecto nobis hic voluptatem.\nQuis aut nisi est illo perspiciatis quas. Magnam necessitatibus vero consequuntur odit. Est sunt corrupti accusantium saepe sed consequatur et. Aut possimus quae totam non labore repellat aliquid aperiam.', 1, '2017-07-30 08:45:08', '2017-07-30 08:45:08'),
(2, 'News 514', 'Illo aspernatur dolores sapiente dolorem aut soluta. Aut recusandae harum similique asperiores reprehenderit fugiat.\nEos aut qui qui magnam error nihil. Ea et similique in aperiam itaque qui iure blanditiis. Temporibus excepturi veniam deserunt blanditiis molestiae.\nOfficia consectetur voluptatum doloremque. Qui impedit voluptas aut non nam. Harum sed tempora numquam numquam maxime odio ducimus.\nHic saepe voluptatem deleniti ipsa quo dolores dolorem. Magnam nihil est architecto modi dolor. Eius est ut quia iure quisquam quaerat. Soluta sit nobis sed beatae.\nVoluptates consequatur molestias aut veritatis. Maiores voluptatem dolorem minus earum odio ut quia. Ipsum cupiditate aut corporis et quae.\nNihil ducimus rem distinctio et sit. Consequatur cupiditate ducimus et pariatur ab ad error. Eum minima soluta aut voluptatibus minus doloremque omnis.', 1, '2017-07-30 08:45:08', '2017-07-30 08:45:08'),
(3, 'News 702', 'Unde dolor enim ab. Iste rerum iure et eum quia molestiae explicabo. Voluptas nisi ut dolorum consectetur aut.\nSunt inventore molestias id. Enim fuga nemo in qui et rerum. Omnis et et consequuntur. Eum dolor deleniti repudiandae aut.\nDoloremque illum ratione ea pariatur eveniet illo voluptatem odio. Qui accusantium vero soluta nesciunt. Voluptatum beatae nulla aut tempore.\nNisi et corrupti neque saepe enim itaque. Ut impedit velit fuga eos expedita pariatur ducimus. Vitae rerum ducimus libero voluptas est culpa quis. Labore corporis at consequatur culpa et.\nSed minus tempore hic cum explicabo voluptas quis. Cumque consectetur sit fuga modi pariatur culpa.\nVoluptatem iusto omnis ex earum maiores corporis. Nulla eveniet natus corrupti et vel. Autem ratione sint sint aut sapiente adipisci illo. Non et eos id corrupti.\nOdio ratione reiciendis quia est. Ea perferendis nesciunt id ut. Dolorum nemo autem porro.', 1, '2017-07-30 08:45:08', '2017-07-30 08:45:08'),
(4, 'News 607', 'Id odio velit omnis labore quis placeat magnam. Et explicabo veritatis voluptate dolor nihil iusto. Explicabo velit consequatur voluptate reprehenderit sed. Veritatis ut vero fuga consequatur esse.\nVoluptatum eveniet omnis qui assumenda saepe. Dolorem est et quia et aut sed aliquam. Quaerat minima dignissimos debitis harum rerum totam voluptatem veniam. Voluptas quibusdam sit blanditiis quis porro occaecati quos.\nPlaceat ut nihil est eligendi. Consequatur exercitationem nihil illo velit cum. Est itaque maxime nulla accusamus unde. Ipsum sit nihil provident nam voluptas.\nCumque aspernatur quibusdam officia iusto sunt eligendi est quas. Nostrum possimus repellat quaerat ut illo quidem porro. A et vel qui suscipit omnis maxime. Aut voluptates aperiam et.\nAut rem ipsum iure aliquam. Dolorum voluptas occaecati illo vitae at et. Voluptatum accusamus nostrum et. Hic ad eligendi nam quo. Officiis beatae modi mollitia eum nobis quam aut.', 1, '2017-07-30 08:45:08', '2017-07-30 08:45:08'),
(5, 'News 892', 'Ut temporibus tempora nam praesentium velit labore nihil. Id fugit et eveniet hic voluptatem suscipit. Modi aliquid corporis facere reprehenderit qui quia adipisci. Quos et porro quas est. Libero odio et beatae perferendis.\nOfficiis quaerat rerum aspernatur dicta voluptatibus id magnam. Quas sint occaecati voluptatem amet. Et distinctio tempora distinctio. Aut cumque omnis deleniti praesentium tempora cumque dicta. Nulla dolor et aut velit expedita quis est.\nOptio exercitationem sapiente praesentium. Ea et sint quia qui beatae quibusdam sequi. Cumque voluptates est voluptatum numquam ex. Eius quos aut doloremque dolorum aut porro dicta.\nAut libero pariatur ut fugit nostrum suscipit. Deserunt a enim repellat fugit non.\nIpsa est nulla suscipit. Ipsam voluptate maxime molestias beatae. Error ea voluptatum sit esse saepe animi.\nEa ut alias quod iusto quasi sit enim. Nobis non ex debitis distinctio. Doloribus velit molestiae sint commodi enim. Quas nisi exercitationem voluptates.', 1, '2017-07-30 08:45:08', '2017-07-30 08:45:08'),
(6, 'News 402', 'Debitis aut sit perspiciatis est et voluptatum accusantium. Accusamus incidunt dolor modi dignissimos et et quaerat. Labore magnam quia impedit reiciendis aspernatur occaecati et.\nEt consectetur iusto aperiam qui porro ut natus. Possimus unde iure perferendis blanditiis modi sint autem. Nulla sint quibusdam est error non aut ut.\nAccusantium qui minus sit illum molestias. Voluptates ipsam tempora voluptatum praesentium unde vero sunt. Non officiis consequuntur illo voluptate porro consequatur maxime.\nNulla quibusdam voluptas possimus cupiditate animi incidunt. Aliquam doloribus rerum ipsam sit ut qui. Et vel nobis cumque facere doloremque sit officiis.\nDistinctio et ea corrupti non fugiat quo ut. Perspiciatis consequuntur sit eligendi amet rerum dolorum rerum. Aut quos sed ut officia sint fuga.', 1, '2017-07-30 08:45:08', '2017-07-30 08:45:08'),
(7, 'News 177', 'Et id sunt aut. Dolores quas non expedita voluptas a. Animi veritatis eligendi porro non.\nIpsum velit nam repudiandae qui sit. Esse nisi corporis quia modi nulla ullam dolorem. Aspernatur consequatur ducimus sint quae rerum sed. Eligendi dolorem consequuntur eaque sit quae sint.\nBlanditiis et ut quam expedita suscipit. Impedit nihil omnis quo. Mollitia et architecto dolorem omnis maiores quis. Fugiat dolorem officiis aspernatur quia.\nDolore omnis est eveniet dignissimos sed dolores aut omnis. Accusantium nulla voluptas a aut. Reiciendis voluptatibus quasi ut doloribus magnam et.\nEt et iste enim sed omnis saepe soluta. Autem ea vel dolores. Suscipit eligendi aliquam est qui dolorum.\nTotam ut repudiandae aliquid voluptatum omnis est. Ab excepturi voluptas nobis aperiam accusantium. Ratione aut non cupiditate nihil tempore quibusdam.\nAmet suscipit at commodi tenetur. Tenetur facilis aut est quia cupiditate. Non vel sint dolores ipsum.', 1, '2017-07-30 08:45:08', '2017-07-30 08:45:08'),
(8, 'News 623', 'Quis eum inventore ipsa in assumenda et sed. Hic recusandae iure quidem natus doloribus. Doloribus maxime cum reiciendis nulla ducimus odit.\nNam ut sint in inventore. Aut vel voluptatem officia et sed in et. In incidunt voluptatem veniam labore.\nDeleniti nisi accusantium ut error. Ea veritatis odit consequatur necessitatibus eligendi. Cupiditate non excepturi velit neque autem sint vitae.\nSequi eius molestias soluta eos numquam reprehenderit. Numquam ea enim autem dolores. Sed eaque distinctio laborum repellat dolorem harum. Corporis quas eos alias at et odio voluptatem.\nInventore possimus accusantium vero dolores. Est fugiat explicabo velit facere dicta et et. Cupiditate necessitatibus animi qui iste voluptatem aliquid nesciunt.\nPorro similique asperiores sed aut nulla. Provident ipsum voluptate eos.\nBeatae aut quidem et. Soluta exercitationem voluptas tenetur vero sit. Aut occaecati accusamus ullam et facilis placeat ducimus.', 1, '2017-07-30 08:45:08', '2017-07-30 08:45:08'),
(9, 'News 327', 'Nam soluta sequi animi optio commodi. Omnis quo sed qui qui perferendis odio. Assumenda voluptas placeat recusandae commodi omnis. Repellendus et ea pariatur illo dolorem eum sunt.\nProvident ratione ab similique nostrum sunt. Ipsum error pariatur eos deleniti. In atque non doloremque quos.\nPerferendis amet voluptates autem architecto ut non omnis. Dolores nisi eum autem veritatis. Molestiae totam unde quo molestiae cumque et.\nOmnis est aut magni. Id vel earum minima unde fugit eos quaerat. Praesentium eum porro maiores sapiente.\nEst voluptatem vero sit consectetur eos aut sit. Et porro vitae reprehenderit sit quos dolorem fugiat. Minima quia neque et odit laudantium. Laboriosam explicabo non repellat maiores natus omnis ut. Pariatur quis aut incidunt minus.\nSaepe repellendus qui repudiandae. Est minus ratione minus molestiae sint voluptatem ullam. Qui neque cumque et temporibus.', 1, '2017-07-30 08:45:08', '2017-07-30 08:45:08'),
(10, 'News 731', 'Ipsum pariatur totam ut perferendis. Qui assumenda dolorem eum soluta aliquid eos consectetur.\nQui non et dolorem voluptatem iusto facere et. Nam aspernatur minus qui quos occaecati. Laborum provident quia aut veritatis quia omnis perspiciatis. Eum odio ut magni est eaque.\nExplicabo omnis odit mollitia et ab. Qui ea id rerum optio ducimus molestias. Harum minima unde deserunt iste et magnam non.\nEx minus omnis vero suscipit repellat minima vitae accusamus. Enim soluta blanditiis at inventore. Nam commodi ducimus porro aut porro voluptas.\nHic aut adipisci consectetur delectus est. Est ut ad quasi eos. Ut sed fuga voluptatem voluptate dolorem praesentium asperiores. Corrupti in voluptatum aut sunt.\nDebitis ut illum assumenda voluptatem perspiciatis voluptas. Quo consequatur hic sed. Commodi mollitia pariatur sit nihil sint voluptate aut.', 1, '2017-07-30 08:45:08', '2017-07-30 08:45:08');

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
(1, 'Welcome to L-Shop!', '<h1 style=\"text-align: center;\">Modern trading system for Minecraft</h1><br><p style=\"text-align: center; \"><img src=\"http://i90.fastpic.ru/big/2017/0309/9c/1cebb8e0e70a432b71102bf20334459c.png\" alt=\"Логотип L-Shop\"><br></p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce condimentum nibh quis lorem malesuada, lobortis accumsan felis consequat. Fusce ac tortor gravida, dignissim quam sit amet, laoreet sapien. Nam ultricies libero in dignissim accumsan. Fusce ac lacinia quam. Integer convallis neque ac tortor sollicitudin, ac mollis erat malesuada. Suspendisse sapien turpis, mollis et nibh non, mollis venenatis augue. Aenean et leo sed mi tristique fringilla.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Donec in nibh turpis. Phasellus tincidunt tristique scelerisque. Sed aliquam pretium mauris a mattis. Sed ante magna, facilisis vel lorem eget, rhoncus ullamcorper ligula. Nunc venenatis dolor nec libero interdum, non lobortis libero molestie. Vivamus aliquet lacus non eros ullamcorper, quis convallis nisl aliquet. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nunc posuere ipsum quam, in commodo dui auctor nec.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Praesent dapibus velit eu leo aliquam, accumsan interdum ex laoreet. Etiam nec vehicula odio. Sed aliquam bibendum convallis. Proin sodales id ligula et pellentesque. Ut ullamcorper magna nec convallis pulvinar. Aenean nunc eros, consequat non nibh in, bibendum convallis eros. Vestibulum elit neque, elementum at egestas a, ultricies eget nisi. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed dapibus metus nec nisi semper, eu fringilla diam aliquam. Fusce accumsan gravida justo, sit amet sollicitudin erat suscipit ac. Nulla rhoncus non elit in tempor. Vestibulum at ligula vitae diam dapibus lobortis at a nulla.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Curabitur ac cursus tortor. Donec posuere magna sit amet felis condimentum cursus et vitae dolor. Curabitur vitae mauris a leo consequat sagittis at at tortor. Fusce dui mi, pretium ut tincidunt at, vestibulum et velit. Quisque posuere eleifend velit, nec mattis leo viverra non. Curabitur placerat, neque in sodales eleifend, nisi tortor lacinia nunc, in varius neque ipsum fringilla urna. Morbi nec ipsum diam. Vestibulum tincidunt augue eleifend dictum rutrum. Etiam vel nibh scelerisque, tincidunt mauris et, lacinia orci. Sed consectetur pellentesque malesuada. Suspendisse eget lectus velit.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Donec viverra vehicula nunc, eget fringilla justo rutrum eget. Duis convallis convallis dapibus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse placerat sagittis lacus. Mauris in aliquet urna, id posuere nisl. Phasellus accumsan in metus vel ullamcorper. Praesent pulvinar iaculis mauris vitae vehicula. Nunc vehicula risus massa, a accumsan turpis ornare in. Suspendisse non mauris eu diam convallis finibus ut et ex. Fusce ut dui massa.</p>', 'welcome-to-L-Shop', '2017-07-30 08:45:08', '2017-07-30 08:45:08');

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
(14, 2, 5, 1, 64, 1, 0, '2017-07-30 08:45:08', '2017-07-30 08:45:08'),
(15, 20, 6, 1, 16, 1, 0, '2017-07-30 08:45:08', '2017-07-30 08:45:08'),
(16, 15, 7, 1, 16, 1, 0, '2017-07-30 08:45:08', '2017-07-30 08:45:08'),
(17, 15, 8, 1, 32, 1, 0, '2017-07-30 08:45:08', '2017-07-30 08:45:08'),
(18, 67, 9, 1, 1, 2, 0, '2017-07-30 08:45:08', '2017-07-30 08:45:08'),
(19, 54, 10, 2, 1, 3, 0, '2017-07-30 08:45:08', '2017-07-30 08:45:08'),
(20, 15, 11, 1, 1, 5, 0, '2017-07-30 08:45:08', '2017-07-30 08:45:08'),
(21, 100, 11, 1, 0, 5, 0, '2017-07-30 08:45:08', '2017-07-30 08:45:08');

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
(1, 'admin', 'Администратор', '{\"user.admin\":true}', '2017-07-30 08:45:07', '2017-07-30 08:45:07'),
(2, 'user', 'Пользователь', '{\"user.admin\":false}', '2017-07-30 08:45:07', '2017-07-30 08:45:07');

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
(1, 1, '2017-07-30 08:45:07', '2017-07-30 08:45:07'),
(2, 2, '2017-07-30 08:45:07', '2017-07-30 08:45:07');

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
(1, 'MMO', 1, '127.0.0.1', 25575, 123456, 0, '2017-07-30 08:45:08', '2017-07-30 08:45:08'),
(2, 'Hi-Tech (PvP)', 1, '127.0.0.1', 25564, 123456, 0, '2017-07-30 08:45:08', '2017-07-30 08:45:08'),
(3, 'Hi-Tech (PvE)', 1, NULL, NULL, NULL, 0, '2017-07-30 08:45:08', '2017-07-30 08:45:08');

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
(18, 'payment.fillupbalance.minsum', '25'),
(19, 'distributor.name', 'ShoppingCart'),
(20, 'recaptcha.public_key', ''),
(21, 'recaptcha.secret_key', ''),
(22, 'profile.payments_per_page', '25'),
(23, 'profile.cart_items_per_page', '25'),
(24, 'profile.character.skin.enabled', '1'),
(25, 'profile.character.skin.hd', '1'),
(26, 'profile.character.skin.max_size', '768'),
(27, 'profile.character.cloak.enabled', '1'),
(28, 'profile.character.cloak.hd', '1'),
(29, 'profile.character.cloak.max_size', '512'),
(30, 'auth.email_activation', '0'),
(31, 'auth.signup.redirect', '0'),
(32, 'auth.signup.redirect_url', 'http://l-shop.ru/servers'),
(33, 'user.enable_change_password', '1'),
(34, 'api.launcher.sashok.auth.error_message', 'User with this credentials not found'),
(35, 'api.launcher.sashok.auth.enabled', '1'),
(36, 'api.launcher.sashok.auth.ips_white_list', '[]'),
(37, 'api.launcher.sashok.auth.format', 'OK:{username}'),
(38, 'api.key', 'pIkHkipkTKhpeC$ZY)OlnFH$fZWUullL'),
(39, 'api.algo', 'sha512'),
(40, 'api.signin.remember_user', '1'),
(41, 'api.signin.enabled', '0'),
(42, 'api.enabled', '0'),
(43, 'api.separator', ':'),
(44, 'api.salt', '0'),
(45, 'api.signup.enabled', '1'),
(46, 'caching.statistic.ttl', '60'),
(47, 'caching.pages.ttl', '3600'),
(48, 'caching.news.ttl', '600'),
(49, 'caching.monitoring.ttl', '10'),
(50, 'news.first_portion', '15'),
(51, 'news.per_page', '15'),
(52, 'news.enabled', '1'),
(53, 'monitoring.rcon.timeout', '1'),
(54, 'monitoring.enabled', '1');

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
(1, 'admin', 'admin@example.com', '$2y$10$OzoH6VZeIQg7O6FwFmWepu3qncGF2J/tnw/noklJrJ/MEONL0lDne', NULL, NULL, 1000, '892e1f70-751c-11e7-b05c-0a0027000016', NULL, NULL, '2017-07-30 08:45:07', '2017-07-30 08:45:07'),
(2, 'user', 'user@example.com', '$2y$10$j/mgVF2MlYsuXCtIx9bVCOZK7XHnguPXLjl.Ck9ISxLuf48L5XL0e', NULL, NULL, 0, '893a5616-751c-11e7-b05c-0a0027000016', NULL, NULL, '2017-07-30 08:45:07', '2017-07-30 08:45:07');

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
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

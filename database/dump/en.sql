-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 30 2017 г., 01:00
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
(1, 1, '0och0oRd3ByWkKBBYHIJkPWI0T5NIp8e', 1, '2017-07-29 19:00:04', '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(2, 2, 'BO10VQVwazAAcWXQWn4yFs49N6pRFLPZ', 1, '2017-07-29 19:00:04', '2017-07-29 19:00:04', '2017-07-29 19:00:04');

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
(1, 'Blocks', 1, '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(2, 'Items', 1, '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(3, 'Armor', 2, '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(4, 'Items', 3, '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(5, 'Privileges', 1, '2017-07-29 19:00:04', '2017-07-29 19:00:04');

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
(5, 'Block of grass', '', 'item', '2', NULL, NULL, '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(6, 'TNT', '', 'item', '46', '784a013771bdf825d1cf26b49897a605.png', NULL, '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(7, 'Chest', '', 'item', '54', 'd6c6adf53d0145708ec54a41e8a4e3d8.png', NULL, '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(8, 'Furnace', '', 'item', '61', '4a69519aa46ee6b5b15bab8abd5139f3.png', NULL, '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(9, 'Diamond sword', '', 'item', '276', '9d8feda602d70231f0297a3b7e436d4b.png', NULL, '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(10, 'Diamond helmet', '', 'item', '310', 'd2714c56c81bcc4ff35798832226967f.png', NULL, '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(11, 'VIP', '', 'permgroup', 'vip', 'f0c9755f2685d55b7540c941b6f29ff9.png', NULL, '2017-07-29 19:00:04', '2017-07-29 19:00:04');

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
(1, 'News 676', 'Alias sit libero nostrum quibusdam consequuntur labore debitis. Voluptatem sit dicta iure laborum voluptatum. Earum et quidem quo nam nulla.\nFacilis nihil quaerat modi amet reiciendis aliquam sunt. Placeat nisi laborum libero sint cumque et quod libero. Harum et tempore adipisci. Dolorem voluptatem fuga quasi voluptas. Qui ut laboriosam ullam voluptates repellendus expedita eum.\nRerum odio ipsam et. Perspiciatis quis necessitatibus optio beatae. Ab maiores ex accusantium perspiciatis consequatur pariatur.\nConsequatur sed dolor expedita nemo temporibus. Corrupti iste iure adipisci enim. Ad qui optio eius ea dolorem.\nDignissimos consectetur culpa commodi sint. Exercitationem quia suscipit optio earum ipsa quidem recusandae. Id vitae culpa nostrum voluptatum rerum similique. Est quibusdam tempore a et sit architecto deleniti.\nVoluptatibus voluptas eum ab nesciunt et. Dolores amet voluptatem itaque dolorum ipsam est. Voluptas est aperiam aliquid et tempora porro est.', 1, '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(2, 'News 262', 'Animi facilis facere dolore aliquid similique nihil delectus. Aliquid aut repellendus nostrum ut. Unde illo placeat illum molestiae quisquam reiciendis. Sit dolorem nihil labore minus deserunt iusto.\nSequi nobis aut quia sunt. At perferendis natus in dolores aut omnis. Molestias aliquid veritatis veniam totam enim voluptas sit architecto. Aut recusandae dolorum a praesentium.\nPlaceat possimus cupiditate delectus est consequatur modi. Optio sint veniam quisquam nesciunt. Et ut ut iusto reprehenderit.\nRepellat asperiores nam officiis harum quis consequuntur eligendi. Aspernatur commodi quis nemo blanditiis voluptas et. Sed minima quia autem iure. Cum architecto voluptatem dicta quisquam autem quia quasi aliquam.\nQuis amet at qui voluptas et et sit. Perspiciatis beatae doloremque qui facilis magni tenetur recusandae.\nVoluptatum accusamus doloremque illum magni non. Rerum ab dolorem quos. Incidunt et voluptate sunt autem eos sit sed. Aut accusantium maxime aut earum consequatur est reiciendis.', 1, '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(3, 'News 454', 'Rerum sint laboriosam quia minima. Quia eius quisquam rerum inventore fuga labore velit. Aut necessitatibus numquam assumenda occaecati. Laborum quas atque aut velit recusandae voluptas ipsa.\nLaboriosam et omnis ea autem et laborum. Aut autem amet magni dolores assumenda odio qui. Tenetur exercitationem cupiditate et omnis at. Velit culpa consequatur et debitis tempora voluptatibus laborum.\nSuscipit nihil consequatur nostrum voluptatem quis aut. Repudiandae veritatis voluptas laudantium. Et ipsum aut error velit neque et. Ipsum incidunt quia sint consequatur.\nEt incidunt architecto error et doloribus voluptas. Commodi aut aliquam ut modi. Eius laudantium laboriosam illo aliquid. Omnis quasi perferendis velit. Et consectetur eos nihil soluta consequatur.\nAlias quis non et unde. Fugit ipsum itaque aliquid et sed.\nCulpa exercitationem nesciunt totam quis. Hic fuga est quibusdam et velit. In qui qui commodi est sed consequatur. Non exercitationem similique velit saepe sunt deleniti hic.', 1, '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(4, 'News 930', 'Quo vitae inventore voluptatibus voluptate error est sapiente. Architecto itaque recusandae impedit cupiditate. Iure quo iure et porro eaque. Laboriosam placeat earum non ut cum. Nihil cum quasi sapiente id nobis veniam.\nEnim a omnis aut sit. Non ipsa nemo omnis. Voluptatem excepturi quaerat vero.\nDelectus ipsum numquam repellat quas. Necessitatibus sapiente aut officiis sed. Molestias consequatur architecto omnis vero id quia repellendus.\nSint quae asperiores eos quia quae voluptatem iure. Voluptatem quia quia quo ad. Rem aut cupiditate non voluptas officiis.\nMolestiae facere reiciendis aut soluta odit ut repudiandae. Non magnam minima et quis. Est mollitia nobis aut aut. Explicabo in sint quo iste eum eligendi similique.\nEt exercitationem non perspiciatis porro illo explicabo eligendi. Id unde perferendis est beatae sunt recusandae voluptatum. Omnis est possimus molestiae non at.', 1, '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(5, 'News 980', 'Dolorem enim officiis quam explicabo ipsum eaque. Quis consectetur earum molestias sint.\nDoloremque corporis sed amet dolores. Eum ea modi aperiam dolorem fugit. Nisi accusamus aut qui blanditiis. Eaque exercitationem autem et rerum et pariatur.\nFugiat magni voluptate similique suscipit quasi ratione. Iure ipsa tempore ut sed pariatur. Nisi voluptas explicabo blanditiis vitae dicta quos architecto.\nOmnis dolorum sunt esse in velit. Similique vel necessitatibus qui tempore et sed. Beatae et molestiae minus perspiciatis qui dolor natus. Consequatur et facilis voluptate dolorem. Et inventore doloribus quidem nobis debitis.\nAnimi qui adipisci quaerat qui quis architecto. Temporibus impedit omnis provident itaque quae quia. Fugit fugit quasi sit ratione officia optio. Vitae ut nihil distinctio voluptatum dolorem voluptas quas.\nIn illo et eligendi magni suscipit amet possimus. Non est qui hic et ipsum est.', 1, '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(6, 'News 142', 'Ratione sunt mollitia explicabo voluptas. Et hic ut est laborum rerum ipsam molestiae. Voluptatem labore tenetur delectus nisi inventore dolores. Laborum dolorem et rem quisquam id molestiae est quia.\nDolores doloribus quibusdam aut unde. Quis aut eos ea qui nihil ut. Culpa ipsa consequatur earum. Consequuntur explicabo aut dolores vero et est.\nQuia aut rerum nemo qui. Et eum dolores unde qui. Est et earum nostrum.\nEa corrupti impedit omnis exercitationem dolorem asperiores. Reiciendis animi non possimus rerum. Qui velit aliquid dolor ut sed. Doloribus et sed qui esse.\nAutem et natus sit facilis et. Et sit numquam sunt illum. Et qui eos rem pariatur odio qui. Non odit ut dolorum animi totam eum molestias.\nCum nostrum ducimus recusandae occaecati occaecati incidunt suscipit. Voluptatem itaque earum tempore a eos soluta laborum. Porro consequatur sit sapiente. Totam modi et praesentium occaecati.', 1, '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(7, 'News 517', 'Placeat voluptas sed explicabo commodi occaecati quos eos. Numquam aut perspiciatis nemo earum explicabo. Blanditiis consequatur placeat voluptatem possimus amet fugiat consectetur.\nAperiam in aut quis alias ipsam dolor. Delectus odio voluptas asperiores ea unde. Corrupti consectetur consequatur explicabo voluptatem recusandae.\nQuis iste sunt ut earum est dolor qui qui. Est recusandae repellat minima sit blanditiis repudiandae. Illo molestias laborum voluptas dolorum omnis.\nNobis porro consequuntur distinctio ducimus fugit et. Autem esse eligendi tempora corrupti quasi. Ut sapiente maiores consequuntur distinctio eum et. Inventore eaque dolorem nam id quas iusto.\nQui occaecati quia quod perspiciatis nihil officiis. Aliquid et quia sed optio. Id occaecati iure id ipsam omnis aut repudiandae inventore.\nAut et sit placeat doloremque voluptatem. Dignissimos excepturi magnam asperiores excepturi unde tenetur illo. Possimus eligendi enim libero quae qui. Similique id nihil tempora quos.', 1, '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(8, 'News 423', 'Corrupti maiores sit quam autem. Voluptatum veritatis praesentium enim error est mollitia eligendi. Temporibus voluptatem velit sunt.\nEst a occaecati libero nemo et repudiandae quis. Asperiores ex sit in quod inventore recusandae inventore sed. Reprehenderit ut quas qui non commodi explicabo suscipit. Rem aspernatur voluptas et nulla. Accusantium est sed non voluptatibus quae asperiores sed dolores.\nEum ullam sint velit odio voluptatem. Ut quaerat nihil quod. Rerum explicabo deleniti expedita eveniet exercitationem consequatur. Dolorum laboriosam quod aut explicabo dolorum totam labore.\nEarum consequatur veniam beatae placeat illo dolor. Eum dolor tempora labore. Et voluptas eaque saepe qui.\nOmnis minima ea sed est repudiandae. Ut facilis atque deserunt dolores eum reprehenderit delectus. Aliquid dicta enim sit illo molestiae praesentium. Sint reiciendis id deleniti eos.', 1, '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(9, 'News 239', 'Et voluptatem voluptatem eveniet quia voluptas. Qui quasi est sunt nostrum eum et et. Quae odio quia aut aperiam rem tempore.\nTempora asperiores tempora quos dolore. Autem fuga ut ea et. Aut quos rerum quae impedit consequatur et. Itaque et et accusamus minus eos. Eaque soluta debitis sunt non adipisci molestias assumenda.\nCommodi et ut vero officia non tempora. Optio quis ipsum accusantium eum. Omnis ut qui dolor et quia quos nostrum.\nRepudiandae amet laboriosam et. Perferendis est nulla porro modi. Porro libero consectetur blanditiis. Iusto ad reiciendis dolorum sed temporibus aut quasi veniam. Qui qui aut voluptas voluptas harum neque voluptatibus.\nEos unde cupiditate laudantium ut amet necessitatibus. Ipsum dolore voluptatibus consequatur sed maiores aliquam. Impedit enim dolores voluptas explicabo debitis qui eveniet.\nAut sit et repellendus laudantium a. Sed odit eveniet sunt. Neque eius asperiores itaque aut minus. Beatae voluptas blanditiis et et nostrum voluptas.', 1, '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(10, 'News 526', 'Impedit quis natus sit veritatis et commodi. Consequatur non laboriosam odit quae. Quis id saepe quia harum.\nQui est repellat sit. Quis aut aperiam nisi quasi et. Omnis sequi soluta molestiae dolor.\nVoluptas et unde quasi veniam facere iusto. Eos totam ullam reprehenderit explicabo. Et qui est molestias eos. Omnis totam eius sit voluptate quis. Blanditiis non et quis rerum iure.\nOmnis nam totam est natus non pariatur quia. Debitis vel doloremque minus recusandae ex voluptas et. Dicta officiis in et et. Repellendus quod nesciunt vel molestiae commodi. Et dolorem praesentium repellat illum.\nSuscipit mollitia reiciendis impedit voluptas placeat a dolores. Dolorem et placeat ullam quisquam. Ut magni enim vero in assumenda quia. Et aut cum omnis dolores asperiores.\nQuia aut explicabo voluptatem. Doloremque in et illum in praesentium dolores cum. Ut id quas alias accusamus. Et ducimus aspernatur autem est rerum laborum placeat aut.', 1, '2017-07-29 19:00:04', '2017-07-29 19:00:04');

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
(1, 'Welcome to L-Shop!', '<h1 style=\"text-align: center;\">Modern trading system for Minecraft</h1><br><p style=\"text-align: center; \"><img src=\"http://i90.fastpic.ru/big/2017/0309/9c/1cebb8e0e70a432b71102bf20334459c.png\" alt=\"Логотип L-Shop\"><br></p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce condimentum nibh quis lorem malesuada, lobortis accumsan felis consequat. Fusce ac tortor gravida, dignissim quam sit amet, laoreet sapien. Nam ultricies libero in dignissim accumsan. Fusce ac lacinia quam. Integer convallis neque ac tortor sollicitudin, ac mollis erat malesuada. Suspendisse sapien turpis, mollis et nibh non, mollis venenatis augue. Aenean et leo sed mi tristique fringilla.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Donec in nibh turpis. Phasellus tincidunt tristique scelerisque. Sed aliquam pretium mauris a mattis. Sed ante magna, facilisis vel lorem eget, rhoncus ullamcorper ligula. Nunc venenatis dolor nec libero interdum, non lobortis libero molestie. Vivamus aliquet lacus non eros ullamcorper, quis convallis nisl aliquet. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nunc posuere ipsum quam, in commodo dui auctor nec.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Praesent dapibus velit eu leo aliquam, accumsan interdum ex laoreet. Etiam nec vehicula odio. Sed aliquam bibendum convallis. Proin sodales id ligula et pellentesque. Ut ullamcorper magna nec convallis pulvinar. Aenean nunc eros, consequat non nibh in, bibendum convallis eros. Vestibulum elit neque, elementum at egestas a, ultricies eget nisi. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed dapibus metus nec nisi semper, eu fringilla diam aliquam. Fusce accumsan gravida justo, sit amet sollicitudin erat suscipit ac. Nulla rhoncus non elit in tempor. Vestibulum at ligula vitae diam dapibus lobortis at a nulla.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Curabitur ac cursus tortor. Donec posuere magna sit amet felis condimentum cursus et vitae dolor. Curabitur vitae mauris a leo consequat sagittis at at tortor. Fusce dui mi, pretium ut tincidunt at, vestibulum et velit. Quisque posuere eleifend velit, nec mattis leo viverra non. Curabitur placerat, neque in sodales eleifend, nisi tortor lacinia nunc, in varius neque ipsum fringilla urna. Morbi nec ipsum diam. Vestibulum tincidunt augue eleifend dictum rutrum. Etiam vel nibh scelerisque, tincidunt mauris et, lacinia orci. Sed consectetur pellentesque malesuada. Suspendisse eget lectus velit.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Donec viverra vehicula nunc, eget fringilla justo rutrum eget. Duis convallis convallis dapibus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse placerat sagittis lacus. Mauris in aliquet urna, id posuere nisl. Phasellus accumsan in metus vel ullamcorper. Praesent pulvinar iaculis mauris vitae vehicula. Nunc vehicula risus massa, a accumsan turpis ornare in. Suspendisse non mauris eu diam convallis finibus ut et ex. Fusce ut dui massa.</p>', 'welcome-to-L-Shop', '2017-07-29 19:00:04', '2017-07-29 19:00:04');

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
(14, 2, 5, 1, 64, 1, 0, '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(15, 20, 6, 1, 16, 1, 0, '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(16, 15, 7, 1, 16, 1, 0, '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(17, 15, 8, 1, 32, 1, 0, '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(18, 67, 9, 1, 1, 2, 0, '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(19, 54, 10, 2, 1, 3, 0, '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(20, 15, 11, 1, 1, 5, 0, '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(21, 100, 11, 1, 0, 5, 0, '2017-07-29 19:00:04', '2017-07-29 19:00:04');

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
(1, 'admin', 'Администратор', '{\"user.admin\":true}', '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(2, 'user', 'Пользователь', '{\"user.admin\":false}', '2017-07-29 19:00:04', '2017-07-29 19:00:04');

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
(1, 1, '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(2, 2, '2017-07-29 19:00:04', '2017-07-29 19:00:04');

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
(1, 'MMO', 1, '127.0.0.1', 25575, 123456, 0, '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(2, 'Hi-Tech (PvP)', 1, '127.0.0.1', 25564, 123456, 0, '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(3, 'Hi-Tech (PvE)', 1, NULL, NULL, NULL, 0, '2017-07-29 19:00:04', '2017-07-29 19:00:04');

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
(9, 'shop.enable_password_reset', '0'),
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
(31, 'auth.signup.redirect', '1'),
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
(1, 'admin', 'admin@example.com', '$2y$10$EkD/LDW90mdnxtW.cEbBIufyl9SDWdOcPF0e64f1fl23bC/Zb7x6C', NULL, NULL, 1000, '46954a5f-74a9-11e7-b1a5-0a0027000016', NULL, NULL, '2017-07-29 19:00:04', '2017-07-29 19:00:04'),
(2, 'user', 'user@example.com', '$2y$10$FHzcc4WKeQ87uwTepTGPtuIhu7zYYuvGaM2YeqaZpYxsH6jCrYchW', NULL, NULL, 0, '46a1a7ac-74a9-11e7-b1a5-0a0027000016', NULL, NULL, '2017-07-29 19:00:04', '2017-07-29 19:00:04');

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

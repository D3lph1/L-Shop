-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 28 2017 г., 15:05
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
(1, 1, 'bEqrEO1RKHw5C6oxfiR4CKFYoFIWatIg', 1, '2017-10-28 09:05:40', '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(2, 2, 'ffHPGlLfuSu62Pc8FoEa3qeG8tQCcZbG', 1, '2017-10-28 09:05:40', '2017-10-28 09:05:40', '2017-10-28 09:05:40');

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
(1, 'Blocks', 1, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(2, 'Items', 1, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(3, 'Armor', 2, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(4, 'Items', 3, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(5, 'Privileges', 1, '2017-10-28 09:05:40', '2017-10-28 09:05:40');

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
(5, 'Block of grass', '', 'item', '2', NULL, NULL, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(6, 'TNT', '', 'item', '46', '784a013771bdf825d1cf26b49897a605.png', NULL, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(7, 'Chest', '', 'item', '54', 'd6c6adf53d0145708ec54a41e8a4e3d8.png', NULL, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(8, 'Furnace', '', 'item', '61', '4a69519aa46ee6b5b15bab8abd5139f3.png', NULL, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(9, 'Diamond sword', '', 'item', '276', '9d8feda602d70231f0297a3b7e436d4b.png', NULL, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(10, 'Diamond helmet', '', 'item', '310', 'd2714c56c81bcc4ff35798832226967f.png', NULL, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(11, 'VIP', '', 'permgroup', 'vip', 'f0c9755f2685d55b7540c941b6f29ff9.png', NULL, '2017-10-28 09:05:40', '2017-10-28 09:05:40');

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
(1, 'News 48', 'Neque ipsam iste facilis officiis sint et. Omnis sed qui atque nam qui nam. Eveniet est totam est voluptatem nesciunt ex rerum. Qui dolorum illum eum dolores. Delectus maxime qui temporibus odit illo nesciunt reprehenderit nisi. Accusantium doloremque unde blanditiis quia voluptatem non consequatur. Et dolore quia earum eveniet ullam quod consequatur. Qui illum ex qui non quis. Esse qui ad minus sint et ipsa. Asperiores officiis sunt perferendis a expedita. Culpa exercitationem odit quae ipsum sit repellat doloremque. Culpa ut autem sit suscipit consectetur voluptatum. Odio veniam assumenda similique magnam facere qui. Quaerat nobis non iste pariatur animi. Natus quis voluptate iste et ipsam nam voluptas possimus. Porro occaecati cumque rem fuga dignissimos sed voluptatem. Consequuntur eaque voluptatem et placeat nulla quis. Assumenda voluptatem officiis sint culpa dolores in sed. Voluptatem maxime magni nobis voluptas. Maxime aliquid quibusdam non dicta. Et aut magnam dicta.', 1, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(2, 'News 185', 'Quia molestiae maxime exercitationem consectetur. Qui odio vel labore harum ipsa. Voluptas qui tempore velit nobis. Veritatis sint voluptas facilis repudiandae culpa illo voluptas. Cupiditate nam officiis in. Tenetur aut assumenda et illo consequatur et et. Quo odit omnis similique. Et est dolor in optio. Iste repellat rerum ab et sit. Dignissimos in incidunt voluptatibus nihil ratione et. Ut sunt voluptatibus adipisci suscipit est. Delectus nam ipsum qui et praesentium quae pariatur a. Aut et tenetur quos ipsa non beatae. At molestias exercitationem distinctio et amet. Ea ad tempora dolor voluptatem. Praesentium consequatur officia incidunt. Qui recusandae nostrum est veritatis. Quod delectus et nesciunt harum cupiditate quod recusandae. Accusamus vero libero et vel nesciunt magni magnam. Omnis tempore ea reiciendis vel temporibus cum. Dolorem velit consequatur dolores vel. Libero quos inventore repellat consequuntur natus. Culpa impedit libero qui aliquid aut eius voluptas.', 1, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(3, 'News 897', 'Quo libero sed quaerat sit aut temporibus minus. Expedita sapiente nisi ea officiis nostrum qui placeat sequi. Voluptatum dolore debitis eveniet. Vel eos blanditiis tempora eaque alias. Et vel modi ipsa delectus libero nemo. Velit laborum officiis in. Qui veritatis accusantium non corporis sint odio recusandae vitae. Nisi optio ea sit consequatur quo assumenda odit ea. Cumque quis accusamus et. Quasi rerum eligendi exercitationem. Dolorem molestias optio recusandae non ipsa voluptatem assumenda. Esse aut eius quia veritatis iste perferendis. Odit quaerat et et animi neque atque in. Eaque molestiae dignissimos omnis et. Rem est reprehenderit id voluptatum rem et earum. Delectus quos magnam necessitatibus maxime inventore. Amet laborum dignissimos magnam dignissimos cumque ab soluta. Pariatur quia nulla deserunt non beatae. Excepturi suscipit qui quod error qui. Expedita iusto et culpa. Quia placeat sint animi odit in. Dicta quos id dolores enim exercitationem ut vel.', 1, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(4, 'News 600', 'Et blanditiis et provident voluptatum autem alias. Possimus veniam libero ratione. Et hic ullam adipisci quisquam qui exercitationem omnis. Nisi unde minima nihil sint nihil a et reiciendis. Ut eos ipsam omnis quo omnis est qui. Velit corrupti iste nihil. Ut consequuntur quia aut odit iure. Sint ex numquam est sit numquam. Ea dolorem sunt voluptas dolore saepe nesciunt odio. Exercitationem odio quasi voluptatem vitae tenetur delectus. Omnis consequatur aut sit voluptas. Recusandae repellat doloribus aut est ad soluta. Placeat eum aperiam dolorem id quod. Odit omnis laudantium nisi sequi quia distinctio doloribus. At velit ab suscipit aliquam rerum impedit. Totam accusamus voluptatem qui mollitia est ab. Ad doloribus quia est excepturi. Placeat qui et eos dignissimos error. Dolorum laborum omnis qui eos deserunt. Quasi eos officiis delectus corporis. Optio quaerat praesentium ducimus dolores est. Et eos pariatur doloremque minus temporibus. Modi cupiditate tenetur nisi.', 1, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(5, 'News 962', 'Adipisci aut architecto qui maiores enim sapiente. Eum voluptas odit quam. Omnis suscipit nesciunt itaque. Libero delectus eum rem reiciendis quis doloribus veniam. Provident ex debitis praesentium. Laborum non sit similique distinctio. Qui ut rerum impedit aliquam fugit impedit. Qui tenetur quaerat deleniti expedita illum est quo. Rerum non et optio et et occaecati. Assumenda repellat consequatur quibusdam eos et. Quas harum possimus voluptate qui. Illum consequatur consequatur consequatur rerum ut ut nihil. Quod inventore illum et. Eum expedita harum vel similique. Officiis quasi ex aut vel dolorum adipisci qui. Dolor aut placeat amet commodi molestias consequatur aut. Nobis consectetur et id autem est at. Sunt quis sed labore enim ut deserunt. Aut quam qui quos eos. Ut aspernatur sit perspiciatis. Sunt occaecati qui illum aut velit eligendi. Harum pariatur aut possimus nesciunt. Est velit rerum inventore quis omnis. In vel est voluptatem dolorum a. Velit eveniet sit consequatur perferendis neque.', 1, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(6, 'News 258', 'Quas consequatur quae a culpa libero delectus. Veniam dolor aut quia consequatur aut. Maxime dicta illo natus quo quo voluptas tempora. Ea harum possimus aut consectetur. Ut occaecati ut consequuntur consequuntur. Enim soluta mollitia expedita eum totam. Et est est a cupiditate maiores laudantium illum. Asperiores quibusdam consequatur doloremque error ut ipsa vero facere. Laboriosam consequatur odit omnis veniam. Accusantium laborum corporis eius hic. Odit doloremque et error velit repellat quaerat. Iste debitis aperiam ullam illo ut dolorum officiis. Id et assumenda natus aut voluptas quis dolorem. Fugiat animi dolore inventore sed ea. Nam quos fugiat voluptatibus temporibus eligendi molestiae voluptas. Debitis numquam quaerat nobis deleniti. Eveniet impedit ipsam soluta. Quas est tempora eaque rerum. Ratione maxime eius asperiores. Dolores esse asperiores ad nihil.', 1, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(7, 'News 948', 'Vitae quidem eos sit autem nesciunt nam amet. Sed et est et consequuntur labore. Porro rerum consectetur voluptatum harum excepturi veritatis. Laborum neque aliquid nostrum iste exercitationem. Inventore magni sint quos et. Repellat quisquam unde omnis sed ut. Nostrum esse voluptates dolorum id id. Vitae laborum architecto iure minus vel cupiditate earum omnis. Quas aut eos ex. Reprehenderit deleniti eligendi error. Consequatur quaerat et voluptatem labore expedita quos error voluptatem. Blanditiis nihil et voluptatem veritatis eos dolor corrupti. Nam a optio eligendi eum corporis veritatis. Sint neque nihil possimus est vel ea. Neque eveniet in et ipsa ipsum molestias doloremque aliquid. Quas ab quae quia sint ullam cum. Inventore porro provident molestias facere quas et placeat et. Animi sit ex id sed debitis saepe consectetur. Quo labore debitis sed est provident. Labore et laboriosam quibusdam dolores esse. Atque autem unde facilis et.', 1, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(8, 'News 637', 'Dolores omnis exercitationem id animi necessitatibus hic fugit sunt. Placeat eum recusandae quidem amet voluptatem. Repellendus reiciendis officia ducimus deleniti laborum aperiam. Quisquam dignissimos alias dolore quia. Nihil optio quos error quas tenetur doloremque. In sint velit nesciunt sit cupiditate aut rerum. At libero doloremque iure dolorum quos. Deleniti maiores sapiente accusantium qui. Consequuntur reprehenderit recusandae assumenda sunt tempora ab occaecati. Consequatur sunt aut et rerum sed. Optio id quisquam debitis aut non. Illum nihil consectetur dolores quia aut ut eos. Quia id eos voluptatem enim. Ea est eum et molestiae repellat iusto facilis quo. Et rerum voluptatem quaerat. Sequi necessitatibus pariatur possimus ad error. Eveniet culpa illo qui aut enim. Voluptate quos laudantium architecto in. Velit iure consequuntur qui nihil dignissimos. Perferendis sit dignissimos et. Perspiciatis consequatur rerum autem cumque et. Nisi aut quo et quis.', 1, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(9, 'News 265', 'Inventore corrupti provident qui placeat mollitia architecto hic quo. Nihil veritatis animi molestiae repellat temporibus. Et voluptatum sed laborum. Laudantium error ut aliquid sit. Molestias earum esse qui aut aut non. Minima expedita iure autem rem nesciunt fugit. Veniam veniam saepe optio quod voluptas. Et minus debitis saepe adipisci nostrum. Harum laborum dicta doloremque nesciunt voluptates tempore deserunt. Quo ea at voluptatem quasi quos iste accusamus corrupti. Eum rerum eos tenetur sequi sit ex neque. Sequi nesciunt numquam et eum. Officiis architecto quo qui et deserunt doloremque ducimus. Alias consequatur vitae eligendi exercitationem officiis. Sit veniam officia fugiat autem possimus eos temporibus. Et voluptate a et quaerat. Dolorum sint quo est. Autem quam impedit exercitationem.', 1, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(10, 'News 468', 'At repellendus corrupti quae laudantium repellendus minima nihil. Distinctio quasi est voluptas mollitia architecto. Corrupti minus optio vitae perspiciatis. Et harum quia dicta vitae fugit. Soluta non id officia et distinctio sunt non qui. Odio non ut accusamus ea fuga amet impedit. Facere cumque ea officia magni. Facilis maxime sed sed et sit dolore totam. Adipisci dicta quidem aspernatur tempore minus. Quia aspernatur vero eum ut est. Placeat necessitatibus eveniet quisquam. Aut debitis quisquam numquam sit omnis. Officia numquam consequatur dolores error maxime adipisci et. Qui voluptatem maiores eius vel et rerum. Suscipit aut provident eveniet id dolor quaerat commodi et. Eveniet id eos nihil iusto aut aliquam sunt. Dicta molestias dolores suscipit. Explicabo consequatur maiores velit voluptatem. Ut soluta consectetur enim. Ipsa velit iure nostrum rem. Facilis sed aut fugit qui sint. Non aut facilis qui sed voluptatibus. Assumenda hic cum provident facilis est facere.', 1, '2017-10-28 09:05:40', '2017-10-28 09:05:40');

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
(1, 'Welcome to L-Shop!', '<h1 style=\"text-align: center;\">Modern trading system for Minecraft</h1><br><p style=\"text-align: center; \"><img src=\"http://i90.fastpic.ru/big/2017/0309/9c/1cebb8e0e70a432b71102bf20334459c.png\" alt=\"Логотип L-Shop\"><br></p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce condimentum nibh quis lorem malesuada, lobortis accumsan felis consequat. Fusce ac tortor gravida, dignissim quam sit amet, laoreet sapien. Nam ultricies libero in dignissim accumsan. Fusce ac lacinia quam. Integer convallis neque ac tortor sollicitudin, ac mollis erat malesuada. Suspendisse sapien turpis, mollis et nibh non, mollis venenatis augue. Aenean et leo sed mi tristique fringilla.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Donec in nibh turpis. Phasellus tincidunt tristique scelerisque. Sed aliquam pretium mauris a mattis. Sed ante magna, facilisis vel lorem eget, rhoncus ullamcorper ligula. Nunc venenatis dolor nec libero interdum, non lobortis libero molestie. Vivamus aliquet lacus non eros ullamcorper, quis convallis nisl aliquet. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nunc posuere ipsum quam, in commodo dui auctor nec.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Praesent dapibus velit eu leo aliquam, accumsan interdum ex laoreet. Etiam nec vehicula odio. Sed aliquam bibendum convallis. Proin sodales id ligula et pellentesque. Ut ullamcorper magna nec convallis pulvinar. Aenean nunc eros, consequat non nibh in, bibendum convallis eros. Vestibulum elit neque, elementum at egestas a, ultricies eget nisi. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed dapibus metus nec nisi semper, eu fringilla diam aliquam. Fusce accumsan gravida justo, sit amet sollicitudin erat suscipit ac. Nulla rhoncus non elit in tempor. Vestibulum at ligula vitae diam dapibus lobortis at a nulla.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Curabitur ac cursus tortor. Donec posuere magna sit amet felis condimentum cursus et vitae dolor. Curabitur vitae mauris a leo consequat sagittis at at tortor. Fusce dui mi, pretium ut tincidunt at, vestibulum et velit. Quisque posuere eleifend velit, nec mattis leo viverra non. Curabitur placerat, neque in sodales eleifend, nisi tortor lacinia nunc, in varius neque ipsum fringilla urna. Morbi nec ipsum diam. Vestibulum tincidunt augue eleifend dictum rutrum. Etiam vel nibh scelerisque, tincidunt mauris et, lacinia orci. Sed consectetur pellentesque malesuada. Suspendisse eget lectus velit.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Donec viverra vehicula nunc, eget fringilla justo rutrum eget. Duis convallis convallis dapibus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse placerat sagittis lacus. Mauris in aliquet urna, id posuere nisl. Phasellus accumsan in metus vel ullamcorper. Praesent pulvinar iaculis mauris vitae vehicula. Nunc vehicula risus massa, a accumsan turpis ornare in. Suspendisse non mauris eu diam convallis finibus ut et ex. Fusce ut dui massa.</p>', 'welcome-to-L-Shop', '2017-10-28 09:05:40', '2017-10-28 09:05:40');

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

--
-- Дамп данных таблицы `lshop_payments`
--

INSERT INTO `lshop_payments` (`id`, `service`, `products`, `cost`, `user_id`, `username`, `server_id`, `ip`, `completed`, `created_at`, `updated_at`) VALUES
(1, 'Database seeder', '{\"14\":64,\"15\":32}', 42, 1, NULL, 1, '127.0.0.1', 1, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(2, 'Database seeder', '{\"14\":64,\"15\":128,\"17\":64}', 192, 1, NULL, 1, '127.0.0.1', 1, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(3, NULL, '{\"20\":365,\"21\":0}', 5575, 2, NULL, 3, '127.0.0.1', 0, '2017-10-28 09:05:40', '2017-10-28 09:05:40');

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
  `price` double(8,2) UNSIGNED NOT NULL,
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
(14, 2.00, 5, 1, 64, 1, 0.00, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(15, 20.00, 6, 1, 16, 1, 0.00, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(16, 15.00, 7, 1, 16, 1, 0.00, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(17, 15.00, 8, 1, 32, 1, 0.00, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(18, 67.00, 9, 1, 1, 2, 0.00, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(19, 54.00, 10, 2, 1, 3, 0.00, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(20, 15.00, 11, 1, 1, 5, 0.00, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(21, 100.00, 11, 1, 0, 5, 0.00, '2017-10-28 09:05:40', '2017-10-28 09:05:40');

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
(1, 'admin', 'Administrator', '{\"user.admin\":true}', '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(2, 'user', 'User', '{\"user.admin\":false}', '2017-10-28 09:05:40', '2017-10-28 09:05:40');

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
(1, 1, NULL, NULL),
(2, 2, NULL, NULL);

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
(1, 'MMO', 1, '127.0.0.1', 25575, '123456', 0, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(2, 'Hi-Tech (PvP)', 1, '127.0.0.1', 25564, '123456', 0, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(3, 'Hi-Tech (PvE)', 1, NULL, NULL, NULL, 0, '2017-10-28 09:05:40', '2017-10-28 09:05:40');

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
(5, 'api.launcher.sashok.auth.error_message', 'User with this credentials not found'),
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
(24, 'monitoring.rcon.pattern', '/^.*(?<now>\\d+)\\sиз\\s(?<total>\\d+).*$/ui'),
(25, 'monitoring.rcon.timeout', '1'),
(26, 'news.enabled', '1'),
(27, 'news.first_portion', '15'),
(28, 'news.per_page', '15'),
(29, 'payment.fillupbalance.minsum', '25'),
(30, 'payment.method.interkassa.algo', 'sha256'),
(31, 'payment.method.interkassa.checkout_id', ''),
(32, 'payment.method.interkassa.currency', ''),
(33, 'payment.method.interkassa.enabled', '1'),
(34, 'payment.method.interkassa.key', ''),
(35, 'payment.method.interkassa.test', '0'),
(36, 'payment.method.interkassa.test_key', ''),
(37, 'payment.method.robokassa.algo', 'sha512'),
(38, 'payment.method.robokassa.enabled', '1'),
(39, 'payment.method.robokassa.login', ''),
(40, 'payment.method.robokassa.password1', ''),
(41, 'payment.method.robokassa.password2', ''),
(42, 'payment.method.robokassa.test', '1'),
(43, 'profile.cart_items_per_page', '25'),
(44, 'profile.character.cloak.enabled', '1'),
(45, 'profile.character.cloak.hd', '1'),
(46, 'profile.character.cloak.max_size', '512'),
(47, 'profile.character.skin.enabled', '1'),
(48, 'profile.character.skin.hd', '1'),
(49, 'profile.character.skin.max_size', '768'),
(50, 'profile.payments_per_page', '25'),
(51, 'recaptcha.public_key', ''),
(52, 'recaptcha.secret_key', ''),
(53, 'shop.access_mode', 'any'),
(54, 'shop.currency', 'USD'),
(55, 'shop.currency_html', '<i class=\"fa fa-usd\"></i>'),
(56, 'shop.description', 'Modern trading system for Minecraft'),
(57, 'shop.enable_password_reset', '1'),
(58, 'shop.enable_signup', '1'),
(59, 'shop.keywords', 'L-Shop,shop,buy,store,minecraft'),
(60, 'shop.name', 'L - Shop'),
(61, 'shop.sort', 'name'),
(62, 'user.enable_change_password', '1');

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
(1, 'admin', 'admin@example.com', '$2y$08$6yi/c.4FvEZbnmzyaVzFGetZswOEpiMsJsmjgv6n2YIcxl9rRk5KS', NULL, NULL, 1000, '5128ad73-bbd8-11e7-aed0-0a0027000010', NULL, NULL, '2017-10-28 09:05:40', '2017-10-28 09:05:40'),
(2, 'user', 'user@example.com', '$2y$08$iOzccOYaf5KziQZBoeoB5OwZZKMqsmenYarwgAgQDA9pD7gbVSH.m', NULL, NULL, 0, '512cdf03-bbd8-11e7-aed0-0a0027000010', NULL, NULL, '2017-10-28 09:05:40', '2017-10-28 09:05:40');

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
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

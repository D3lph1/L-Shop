-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 05 2017 г., 21:28
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
(1, 1, 'cS8VMRnkKcY1I0tla1J3XSuIYbS1MZbX', 1, '2017-08-05 15:27:48', '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(2, 2, 'wW8GYgrxsAngvi7EbFYfDhX8idU13vYf', 1, '2017-08-05 15:27:48', '2017-08-05 15:27:48', '2017-08-05 15:27:48');

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
(1, 'Блоки', 1, '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(2, 'Предметы', 1, '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(3, 'Броня', 2, '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(4, 'Предметы', 3, '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(5, 'Привилегии', 1, '2017-08-05 15:27:48', '2017-08-05 15:27:48');

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
(5, 'Блок травы', '', 'item', '2', NULL, NULL, '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(6, 'Динамит', '', 'item', '46', '784a013771bdf825d1cf26b49897a605.png', NULL, '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(7, 'Сундук', '', 'item', '54', 'd6c6adf53d0145708ec54a41e8a4e3d8.png', NULL, '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(8, 'Печь', '', 'item', '61', '4a69519aa46ee6b5b15bab8abd5139f3.png', NULL, '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(9, 'Алмазный меч', '', 'item', '276', '9d8feda602d70231f0297a3b7e436d4b.png', NULL, '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(10, 'Алмазный шлем', '', 'item', '310', 'd2714c56c81bcc4ff35798832226967f.png', NULL, '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(11, 'VIP', '', 'permgroup', 'vip', 'f0c9755f2685d55b7540c941b6f29ff9.png', NULL, '2017-08-05 15:27:48', '2017-08-05 15:27:48');

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
(1, 'Новость 967', 'Voluptatem quaerat provident et et ullam qui labore. Quo amet aperiam voluptates voluptas possimus aperiam qui. Aliquid ducimus eligendi aut ut quia et expedita.\nPossimus nesciunt laudantium et porro provident adipisci veniam. Dolor consequatur sint omnis voluptas porro. Laboriosam suscipit temporibus praesentium fuga quo accusamus hic. Repudiandae aliquid consequuntur optio.\nOmnis esse sit alias nobis voluptates delectus. Molestias enim aut vel iusto sed. Est sed quis suscipit exercitationem non explicabo quo. Dolorum reiciendis adipisci sapiente corrupti non voluptas eius et.\nQuidem rerum in architecto doloremque dolorum laborum quis ad. Minima nisi ipsum est repellendus provident nulla aspernatur. Voluptatibus aut illo in consequuntur quod.\nAliquam similique amet esse in. Hic omnis tempora expedita eaque hic laudantium quis. Et quia molestiae explicabo. Sit ea deserunt qui corporis.', 1, '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(2, 'Новость 583', 'Qui debitis nihil eligendi repellat error enim magnam. Voluptatibus debitis sit numquam quis enim laboriosam.\nHic sed error architecto neque molestias et quisquam. Ullam cumque fuga ullam quia et. Est ex officia vel hic a itaque non. Cumque dolorem voluptatibus enim dolorem ut veniam.\nAb id enim iusto commodi rerum iusto. Libero voluptas recusandae vero et laborum aut magni. Dolorum explicabo eum itaque praesentium. Assumenda dolor dolorem ad non rerum.\nOdit amet aut itaque recusandae. Ut eligendi quibusdam deserunt. Consequatur ducimus reprehenderit occaecati dolores fuga. Ut optio non deleniti et sint voluptas.\nDicta suscipit dolorum expedita optio. Sunt cupiditate qui veniam quod. Omnis est sed optio.\nEum itaque impedit dolorem omnis cupiditate nesciunt odio. Sequi vitae animi quos aut aut culpa praesentium. Beatae ducimus aliquid corporis occaecati et explicabo velit.\nIure hic fugit sit deserunt. Repudiandae ut fuga maiores iusto autem et. Architecto est explicabo eius ipsam at consequuntur.', 1, '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(3, 'Новость 70', 'Dolorum fuga libero iusto in. Unde totam beatae aperiam enim id saepe. Ut deleniti ut temporibus architecto.\nAliquam quod quia qui earum quidem voluptas reprehenderit. Inventore inventore quia ad eaque eaque culpa in. Totam libero sed occaecati repellat vitae.\nOdit repudiandae quibusdam omnis assumenda reiciendis inventore. Expedita sed animi minima pariatur quos. Ipsum non dignissimos dolores dolorum qui eum ipsa.\nSequi porro perspiciatis aut beatae eaque ex. Modi eius quisquam ullam et. Maxime non nesciunt labore placeat quia sed ut quisquam. Vero fuga veniam hic omnis alias doloremque.\nPossimus dolores nihil dolores facilis. Velit recusandae in voluptatem temporibus delectus veniam alias. Et enim occaecati dolorum. Aut commodi debitis animi sit.\nAut facilis numquam et dolores aliquam quas sit. Sed aut quasi recusandae minus et.\nUnde incidunt quis illo nobis ea. Omnis ut aut est. Veniam quas aperiam voluptas et consectetur laborum. Nam aut et dignissimos.', 1, '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(4, 'Новость 465', 'Et reprehenderit et et recusandae rem recusandae voluptatem. Impedit ipsum vel id vitae quasi iure non. Eum nisi voluptas voluptates vitae. Ab blanditiis reprehenderit fuga rerum quisquam.\nAccusantium voluptatem harum voluptas provident. Distinctio molestias sunt culpa quisquam voluptatem sed. Unde nihil quo vel tempora fugiat et aut tenetur. Esse expedita et ullam nam ipsa aliquid magni.\nSint autem consequuntur eius veritatis. Saepe id voluptas cum vero ipsum aut dolores recusandae. Quibusdam itaque ipsum quia. Quod voluptatem asperiores nihil accusantium. Sed occaecati distinctio possimus voluptatem.\nMaiores qui aut facere eveniet mollitia ut sunt. Corrupti et facilis similique impedit voluptatem rerum quia. Quia vel at modi omnis autem eos. Quae similique cupiditate neque aliquam.\nFugiat dolor sint iure et a consectetur voluptatem. Nulla iusto et dolorem quibusdam qui molestiae.\nOmnis qui expedita natus temporibus. Laboriosam nihil aut sit soluta non. Incidunt tempora et libero.', 1, '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(5, 'Новость 272', 'Eaque officiis quae iure nihil quisquam id. Impedit minima eaque eos porro optio.\nDebitis quae sit delectus dolor aut doloribus. Exercitationem voluptatem aut nemo reprehenderit. Et laboriosam consequuntur modi consequatur et dolorem repellendus molestiae. Non consectetur ullam rem.\nCulpa commodi molestiae beatae qui. Quo aut repellendus non aut. Nobis facere qui dolorem hic maxime quia.\nDelectus numquam dolor et ut. Quis et in distinctio quod doloremque doloremque et. Doloremque cum mollitia sunt possimus a eius eos necessitatibus. Est magni qui explicabo reprehenderit nulla non.\nLaudantium et maiores illo quis repudiandae sed tempore amet. Molestiae voluptatem qui sequi rerum a est. Consequatur ut quaerat omnis explicabo et recusandae.\nRepellendus deserunt delectus eum quia. Rerum minima aut vitae est voluptate. Rerum nihil illo consequuntur est sunt.\nAutem quia praesentium aut et velit. Dolore earum consectetur dolor. Deserunt maxime consectetur aut quis quo non et iusto.', 1, '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(6, 'Новость 371', 'Amet eligendi dolor assumenda. Accusamus autem voluptas pariatur asperiores ut quia perferendis dicta. Molestiae corrupti nemo a voluptas. Est consequatur et eum sapiente accusantium nesciunt iste voluptas.\nEt quibusdam incidunt amet occaecati mollitia rerum necessitatibus accusamus. Ipsum ex rerum consequatur eum quisquam debitis impedit. Molestiae eos esse minima magni fuga quo. Esse necessitatibus eum soluta nesciunt omnis praesentium cumque. Et et fugiat dolor natus sit.\nDolorum qui minima quo. Sint iusto corporis debitis similique. Aperiam quam eos dignissimos qui. Dolor amet quia maxime deserunt.\nQuo voluptatem occaecati deleniti corrupti velit non. Officia quisquam quia a aperiam animi porro. Reprehenderit in omnis tempore doloremque soluta sed quidem.\nRerum consequatur enim necessitatibus ea. Laboriosam at ad sed architecto totam repellat. Dolorem unde et deleniti esse commodi. Nostrum est et maxime quos.', 1, '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(7, 'Новость 920', 'At cumque ad eveniet ut voluptas eum et sit. Aut temporibus occaecati fugit. Voluptas aut accusantium aspernatur nobis consequatur accusantium sit.\nRerum ducimus voluptatem optio consequuntur harum laboriosam possimus. Ut voluptatem magni consequatur eum. Eos a est et sunt error aut.\nEt maxime esse et. Sed asperiores qui dicta. Rerum nihil repudiandae consectetur itaque ducimus.\nRem eveniet quasi quisquam magni veritatis. Non perspiciatis ex provident aut ut blanditiis. Ut aperiam quis consequatur est aliquam.\nEa temporibus placeat explicabo earum maxime rerum veniam. Doloremque eos qui repellat natus consequatur totam. Illo atque labore atque nulla veniam repellendus.\nQuod laboriosam ut ipsa. Ab aliquid delectus reiciendis nemo magnam et et asperiores. Facilis officia nobis dolorem non ut.\nSint dolore enim iste odit non suscipit architecto. Ut doloremque unde laborum eius est nostrum. Qui necessitatibus explicabo et voluptas. A a assumenda minus culpa quis voluptatibus.', 1, '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(8, 'Новость 702', 'Nobis natus ut quia harum. Minus consectetur veniam ut tenetur. Ut corporis officiis quia explicabo ipsam modi. Aliquid ratione sed cupiditate earum porro atque sapiente.\nQuis non corporis dolorum numquam non. Tenetur ipsum suscipit tempore aliquam veniam et officiis. Sint in in consectetur in dolorem officia. Ullam pariatur quibusdam repellendus possimus dolor est atque.\nMolestias inventore distinctio quae provident amet nostrum assumenda. Repudiandae aut est omnis illum hic sit commodi. Temporibus rem et ut delectus.\nExercitationem eos accusamus officiis exercitationem qui rerum et. Aliquam facilis fuga voluptas a. Veritatis consequatur dolore quia corrupti.\nNecessitatibus veritatis quia aliquam ad architecto facere. Aut praesentium exercitationem porro officiis quis necessitatibus voluptatem.\nConsequatur itaque sed illum sed totam et sapiente. Eius commodi eius quod saepe rerum adipisci. Quidem et omnis corrupti harum.', 1, '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(9, 'Новость 279', 'Ipsum voluptas voluptate quas aut quo est at. Assumenda excepturi mollitia hic assumenda sapiente possimus quo. Et suscipit sequi sed accusamus.\nEt non sit eaque esse in. Quia sunt libero provident quia animi. Qui harum ipsam aliquam eum hic voluptates dolores corporis. Non culpa eos accusamus in. Consectetur non doloribus sint.\nNesciunt repellat praesentium porro reprehenderit eos natus. Eveniet et vitae consequatur voluptate eveniet velit. Iste fugiat qui vel assumenda non esse. Aut inventore debitis consequatur voluptatem.\nQuas dolorum fuga quis aut vitae. Ea voluptatem non asperiores optio et illum aut. Possimus repellat nobis nam commodi ad dolorem laudantium.\nLabore occaecati et possimus rem. Porro qui minima ex cupiditate libero. Facere est voluptate aut rem. Omnis fuga est repudiandae suscipit.\nMollitia repellat non praesentium provident. Labore ab eos facilis unde rerum. Eveniet explicabo eos vel corrupti sit. Tenetur aut ipsa necessitatibus reprehenderit magni qui sed.', 1, '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(10, 'Новость 336', 'Eligendi debitis quo assumenda corrupti modi. Nemo aut impedit non velit reprehenderit iure. Repudiandae aut ut qui consequatur. Est aut voluptas mollitia mollitia quia qui.\nDoloribus iste vel eaque et quaerat atque dolore possimus. Impedit facilis modi rerum eveniet. Non earum hic harum eos expedita aut.\nIusto mollitia pariatur odit sed. Quae voluptatum velit est cupiditate similique laboriosam praesentium. Amet sed aut pariatur consectetur iusto expedita qui. Aperiam molestiae eum fugiat aliquam inventore deserunt ea.\nEt sapiente consequuntur sint voluptatibus iusto. Aliquid modi ut veniam culpa delectus. Ipsum vitae molestiae perspiciatis et et sit.\nEveniet non aut et voluptas minima. Ut explicabo dicta nisi. Repellat corporis nemo qui.\nVel dolor ut esse quo laborum animi adipisci. Ut dolore molestiae doloremque et. Rem alias eos culpa dolores asperiores et. Dolorem totam ullam enim iste sit iure voluptatem delectus.', 1, '2017-08-05 15:27:48', '2017-08-05 15:27:48');

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
(1, 'Добро пожаловать в L-Shop!', '<h1 style=\"text-align: center;\">Современная торговая система для Minecraft</h1><br><p style=\"text-align: center; \"><img src=\"http://i90.fastpic.ru/big/2017/0309/9c/1cebb8e0e70a432b71102bf20334459c.png\" alt=\"Логотип L-Shop\"><br></p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce condimentum nibh quis lorem malesuada, lobortis accumsan felis consequat. Fusce ac tortor gravida, dignissim quam sit amet, laoreet sapien. Nam ultricies libero in dignissim accumsan. Fusce ac lacinia quam. Integer convallis neque ac tortor sollicitudin, ac mollis erat malesuada. Suspendisse sapien turpis, mollis et nibh non, mollis venenatis augue. Aenean et leo sed mi tristique fringilla.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Donec in nibh turpis. Phasellus tincidunt tristique scelerisque. Sed aliquam pretium mauris a mattis. Sed ante magna, facilisis vel lorem eget, rhoncus ullamcorper ligula. Nunc venenatis dolor nec libero interdum, non lobortis libero molestie. Vivamus aliquet lacus non eros ullamcorper, quis convallis nisl aliquet. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nunc posuere ipsum quam, in commodo dui auctor nec.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Praesent dapibus velit eu leo aliquam, accumsan interdum ex laoreet. Etiam nec vehicula odio. Sed aliquam bibendum convallis. Proin sodales id ligula et pellentesque. Ut ullamcorper magna nec convallis pulvinar. Aenean nunc eros, consequat non nibh in, bibendum convallis eros. Vestibulum elit neque, elementum at egestas a, ultricies eget nisi. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed dapibus metus nec nisi semper, eu fringilla diam aliquam. Fusce accumsan gravida justo, sit amet sollicitudin erat suscipit ac. Nulla rhoncus non elit in tempor. Vestibulum at ligula vitae diam dapibus lobortis at a nulla.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Curabitur ac cursus tortor. Donec posuere magna sit amet felis condimentum cursus et vitae dolor. Curabitur vitae mauris a leo consequat sagittis at at tortor. Fusce dui mi, pretium ut tincidunt at, vestibulum et velit. Quisque posuere eleifend velit, nec mattis leo viverra non. Curabitur placerat, neque in sodales eleifend, nisi tortor lacinia nunc, in varius neque ipsum fringilla urna. Morbi nec ipsum diam. Vestibulum tincidunt augue eleifend dictum rutrum. Etiam vel nibh scelerisque, tincidunt mauris et, lacinia orci. Sed consectetur pellentesque malesuada. Suspendisse eget lectus velit.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Donec viverra vehicula nunc, eget fringilla justo rutrum eget. Duis convallis convallis dapibus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse placerat sagittis lacus. Mauris in aliquet urna, id posuere nisl. Phasellus accumsan in metus vel ullamcorper. Praesent pulvinar iaculis mauris vitae vehicula. Nunc vehicula risus massa, a accumsan turpis ornare in. Suspendisse non mauris eu diam convallis finibus ut et ex. Fusce ut dui massa.</p>', 'welcome-to-L-Shop', '2017-08-05 15:27:48', '2017-08-05 15:27:48');

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
(14, 2, 5, 1, 64, 1, 0, '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(15, 20, 6, 1, 16, 1, 0, '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(16, 15, 7, 1, 16, 1, 0, '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(17, 15, 8, 1, 32, 1, 0, '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(18, 67, 9, 1, 1, 2, 0, '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(19, 54, 10, 2, 1, 3, 0, '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(20, 15, 11, 1, 1, 5, 0, '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(21, 100, 11, 1, 0, 5, 0, '2017-08-05 15:27:48', '2017-08-05 15:27:48');

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
(1, 'admin', 'Администратор', '{\"user.admin\":true}', '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(2, 'user', 'Пользователь', '{\"user.admin\":false}', '2017-08-05 15:27:48', '2017-08-05 15:27:48');

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
(1, 1, '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(2, 2, '2017-08-05 15:27:48', '2017-08-05 15:27:48');

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
(1, 'MMO', 1, '127.0.0.1', 25575, 123456, 0, '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(2, 'Hi-Tech (PvP)', 1, '127.0.0.1', 25564, 123456, 0, '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(3, 'Hi-Tech (PvE)', 1, NULL, NULL, NULL, 0, '2017-08-05 15:27:48', '2017-08-05 15:27:48');

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
(2, 'shop.currency', 'Руб.'),
(3, 'shop.currency_html', '<i class=\"fa fa-rub\"></i>'),
(4, 'shop.description', 'Современная торговая система для Minecraft'),
(5, 'shop.keywords', 'L-Shop,магазин,купить,minecraft,майнкрафт'),
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
(41, 'api.launcher.sashok.auth.error_message', 'Пользователь с такими данными не найден'),
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
(1, 'admin', 'admin@example.com', '$2y$10$RSrmH753PUV30v2wd1TqeuJlsK4GSk/y3cPqyfdoxS1ptDA6pphIC', NULL, NULL, 1000, 'c89062cf-7a0b-11e7-8ca0-0a002700000e', NULL, NULL, '2017-08-05 15:27:48', '2017-08-05 15:27:48'),
(2, 'user', 'user@example.com', '$2y$10$qHX2IJo3Au4bIfWXzMtmvu58epcagQHtHhEKC5Wraj8gxTvB4MOse', NULL, NULL, 0, 'c89ca36d-7a0b-11e7-8ca0-0a002700000e', NULL, NULL, '2017-08-05 15:27:48', '2017-08-05 15:27:48');

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

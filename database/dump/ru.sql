-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 30 2017 г., 14:44
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
(1, 1, 'ZOCQzhCUP97bbiPzBDQpTxHJ1BrR2ADg', 1, '2017-07-30 08:43:50', '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(2, 2, 'xu8qlzHJ2tMvi7xdRxg1lWLb4cW0FGVr', 1, '2017-07-30 08:43:50', '2017-07-30 08:43:50', '2017-07-30 08:43:50');

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
(1, 'Блоки', 1, '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(2, 'Предметы', 1, '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(3, 'Броня', 2, '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(4, 'Предметы', 3, '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(5, 'Привилегии', 1, '2017-07-30 08:43:50', '2017-07-30 08:43:50');

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
(5, 'Блок травы', '', 'item', '2', NULL, NULL, '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(6, 'Динамит', '', 'item', '46', '784a013771bdf825d1cf26b49897a605.png', NULL, '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(7, 'Сундук', '', 'item', '54', 'd6c6adf53d0145708ec54a41e8a4e3d8.png', NULL, '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(8, 'Печь', '', 'item', '61', '4a69519aa46ee6b5b15bab8abd5139f3.png', NULL, '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(9, 'Алмазный меч', '', 'item', '276', '9d8feda602d70231f0297a3b7e436d4b.png', NULL, '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(10, 'Алмазный шлем', '', 'item', '310', 'd2714c56c81bcc4ff35798832226967f.png', NULL, '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(11, 'VIP', '', 'permgroup', 'vip', 'f0c9755f2685d55b7540c941b6f29ff9.png', NULL, '2017-07-30 08:43:50', '2017-07-30 08:43:50');

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
(1, 'Новость 130', 'Omnis quaerat voluptatum beatae enim maiores qui aut. Aut nihil sint adipisci. Consequatur tenetur eum quo quod ipsam. Est quos alias ipsa dicta.\nAutem vitae illum est autem. Dolor et vero minima quo voluptate tempore. Non alias in laborum maxime veritatis adipisci molestias.\nExpedita non ut quasi aliquid et quia. Velit omnis est ab sapiente odit tempora quia. Nemo aperiam labore molestias assumenda id quaerat.\nMolestiae eum et temporibus sunt. Quidem amet eveniet illo tempore quia et velit. Harum sint porro accusantium. Quaerat magni dignissimos quibusdam molestiae molestias est rerum.\nMaxime sit et modi possimus praesentium delectus. Nulla ipsum sunt velit itaque temporibus. Et placeat provident nobis non dolorem maiores accusamus. Nesciunt et quo similique nihil porro voluptatem ipsam.\nUnde ipsum ut provident voluptas dolorem provident. Reiciendis veritatis distinctio esse adipisci sequi.', 1, '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(2, 'Новость 189', 'Et iste quos vero ut ex deserunt provident. Architecto voluptates accusantium non facere aut voluptatem non. Vel odio nemo animi nostrum. Facilis dicta iusto voluptas cumque quasi dicta eos.\nItaque similique pariatur velit temporibus iusto. Corrupti aut ducimus et quasi. Rerum distinctio molestiae quisquam nisi excepturi esse repellendus.\nEos possimus corrupti dolorum in dolorem assumenda rerum. Vitae ullam et enim pariatur quaerat id non. Accusantium qui magnam eos. Aut rerum consequatur accusantium qui esse ad.\nSit sapiente ipsam et. Ab corporis quis animi at consequatur. Et laboriosam officia laudantium corrupti.\nNostrum maiores et repellat voluptas nostrum sit. Aut aspernatur sit ea nam reiciendis quia eum. Voluptas omnis veritatis eum aut numquam voluptatum quis.\nEum iure eum voluptatum illo culpa quod aut. Voluptates inventore sint iusto. Architecto quia quasi expedita in doloremque qui.', 1, '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(3, 'Новость 358', 'Odit pariatur facere omnis nulla. Et recusandae illum numquam iure fugit. Sit iure voluptatem mollitia illum. Facilis distinctio eos rem.\nVel ducimus corporis esse officiis aliquam accusamus officia. Dolor voluptatem blanditiis a et ea natus iusto.\nVel nostrum aliquid fuga voluptate quia. Laboriosam repellendus a maiores magnam temporibus. Et dolore praesentium unde autem fugiat numquam reiciendis sunt. Qui ea quidem aut sint voluptatum.\nModi molestiae placeat consectetur non totam. Eum earum cum voluptatem esse exercitationem. Alias exercitationem et et sit nemo et repellat. Id dolorem accusantium dignissimos vitae atque quis temporibus veniam.\nEligendi illo dicta doloribus. Natus tempora et minima quo est. In dicta autem dicta et itaque est similique quis.\nEst eius magni ut recusandae non perferendis tenetur. Quaerat nobis in illo. Iusto impedit velit et natus voluptatum sed sint aut.', 1, '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(4, 'Новость 219', 'Sit itaque atque dolores quis pariatur. Qui maiores voluptatem aliquid mollitia. Blanditiis aut eos fugiat similique quo in magni.\nUt iste hic voluptate hic a. Distinctio quibusdam et nulla voluptatum. Nisi voluptatum est aut explicabo.\nEt in placeat ea. Maxime et voluptatum magnam aut laudantium saepe similique at. Eos voluptatem suscipit velit minima aut non. Quaerat voluptatem placeat aut recusandae nam placeat quidem.\nAccusantium eveniet voluptates aut dolores facere. Non alias minima iure blanditiis. Accusantium consectetur exercitationem magnam similique veniam. Eius voluptas voluptas et rerum possimus.\nSimilique voluptatem minus facilis atque. Voluptate in iste et mollitia assumenda totam. Necessitatibus optio sapiente provident quas officia consequatur.\nAutem iste architecto ut saepe qui sit vel quis. Nemo aperiam aut necessitatibus placeat. Suscipit porro assumenda consequuntur dolores et consequatur rerum.', 1, '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(5, 'Новость 598', 'Architecto voluptatem consequuntur voluptatum aperiam. Voluptas deserunt veritatis occaecati. Facere numquam debitis aut aut assumenda.\nEx voluptatem in placeat pariatur quo hic. Eaque possimus delectus vel iure. Quisquam deserunt ratione nihil consequatur veritatis magnam qui.\nQuas rerum et et mollitia. Amet ullam sed voluptas ut.\nAliquid magni at nihil placeat et tempore quia. Quisquam consequatur autem est voluptate nam doloremque commodi recusandae.\nA saepe non sapiente officia eius non optio. Enim consequuntur quis ab iste. Voluptatem reprehenderit culpa dolor quam id.\nVoluptates vel sapiente omnis deserunt sunt. Quia accusantium perspiciatis enim quasi sapiente. Perspiciatis laudantium sed quos et dignissimos ipsum. Repellendus blanditiis reprehenderit tempore temporibus sequi.\nIn id nostrum optio ut. Enim sit nihil laudantium sit voluptatibus. Recusandae tempora saepe voluptatem et voluptas quae. Nulla distinctio ullam velit et non et a.', 1, '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(6, 'Новость 16', 'Sapiente ex molestiae provident consequatur eveniet dolor rerum. Ut est distinctio qui eum. Quia voluptatem sequi esse omnis incidunt ut.\nDistinctio enim porro laboriosam incidunt ea molestiae. Omnis sit rerum asperiores reprehenderit quisquam. Voluptatem accusamus illo est incidunt deserunt maiores magnam.\nQuo qui praesentium tenetur similique voluptates. Eligendi facilis qui praesentium consequatur autem omnis delectus. Odit eius saepe ex itaque vero deleniti.\nVel sed eveniet aut excepturi. Commodi eum facere et reprehenderit neque et et. Quia ut autem eum natus vel ut ut.\nIllum magni nostrum ex magni ut et. Aut eligendi architecto assumenda ullam deleniti reiciendis unde. Ut reiciendis architecto exercitationem tempore.\nExercitationem illum et possimus asperiores. Ea consectetur molestias hic repellat modi. Autem quis nemo ex a est dolor.\nDolor saepe molestiae illo dolorum deleniti veniam impedit. Explicabo laboriosam voluptas eum culpa fugiat. Corporis debitis harum aut aut repellat.', 1, '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(7, 'Новость 677', 'Nostrum non neque id voluptatem corrupti magni sequi. Aut quia quasi similique enim facilis ducimus. Impedit vel consequuntur architecto in. Inventore laudantium debitis est molestiae molestiae et fuga.\nAt blanditiis et commodi. Blanditiis hic eaque et sint perspiciatis. Adipisci voluptates voluptatem fugiat aut omnis nemo.\nSint id nihil et corporis consequatur. Est pariatur molestias eius asperiores ratione. Minima neque numquam hic qui. Repellendus est veritatis consequatur neque.\nAut commodi et et qui iusto sint suscipit. Velit nisi et doloremque ex maiores veniam earum. Natus non quibusdam qui ipsam est vitae.\nMolestiae odio maxime aut dicta placeat voluptatibus quam. Qui reprehenderit laudantium aut. Sed qui et temporibus dolorem. Consequuntur nam sunt est sit veritatis officiis hic.\nHarum adipisci repellat ullam aperiam non aperiam ullam deserunt. Esse ut aut ut sed nihil enim. Vero voluptatibus et quis inventore velit ad.', 1, '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(8, 'Новость 608', 'Placeat natus explicabo est voluptas rerum officiis doloribus. Quod cupiditate sed enim dignissimos quidem laborum. Quaerat eum vitae et reiciendis qui mollitia similique. Quis recusandae ut reiciendis eius dolorem.\nQuia minima voluptates magni et rem ea aut distinctio. Et cumque vitae tempora suscipit architecto a. Voluptates fugit et suscipit laudantium.\nVitae et laboriosam enim repudiandae. Harum sint aliquid ut. Exercitationem ratione repudiandae id molestiae natus eos doloremque.\nQui accusantium quaerat praesentium excepturi voluptatem. Suscipit dolorem quis ipsum itaque. Sed magnam fugiat voluptatum facilis deserunt. Aut aut sit atque dolores. Omnis ut velit dolor dolorum.\nReprehenderit autem sed nisi quo. Itaque doloribus nam est debitis sed. Dolor eos neque et modi et. Qui est consectetur impedit voluptatibus voluptatem.\nEt officiis dolore consequatur. Inventore officiis et iste quos deserunt rerum. Harum provident et ratione modi corrupti fugit.', 1, '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(9, 'Новость 776', 'Hic aut quasi aut deserunt repellendus ut odit et. Sint aspernatur corporis numquam consequatur enim. Ut deserunt omnis voluptatem iusto quia aut fuga.\nVoluptatem omnis veritatis neque aut vel harum. Neque aut et dicta voluptas molestias. Nobis dignissimos ratione laborum molestiae cumque qui nihil nihil.\nFugiat laboriosam quia sunt. Expedita ipsam et dolorum nisi. Aliquam non aut eum nisi. Quisquam reprehenderit quisquam explicabo odit aut blanditiis accusamus.\nEa enim iste reiciendis est quod aspernatur. Quisquam assumenda aut quia non. Sequi magni consequatur perferendis aut consequatur.\nEum saepe voluptate aut officiis accusamus. Culpa quidem quisquam eos natus. Praesentium voluptatem voluptate quas saepe.\nRem eum excepturi sapiente non laudantium beatae. Sit non amet totam consequuntur deserunt aut blanditiis. Ab cumque qui velit sed nobis. Ad suscipit et non esse dolore ipsum beatae.', 1, '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(10, 'Новость 783', 'Nostrum qui pariatur nihil non autem et iure commodi. Dolor et qui cupiditate. Sint est autem deleniti in unde consequatur blanditiis. Omnis porro molestias non fugit.\nEum et ut voluptate suscipit doloremque voluptatum. Neque nisi similique doloremque inventore. Alias doloribus necessitatibus qui ad. Eos delectus et et sit.\nDeleniti quasi fugit modi ut nesciunt facilis. Ipsa ad harum aut temporibus facilis repellat beatae. Voluptas nesciunt atque velit possimus dolorum voluptatem est. Accusamus quo voluptatibus qui tenetur autem.\nId sit est eveniet. Rerum necessitatibus maxime reprehenderit.\nFacere quia eligendi voluptas odit architecto nisi. Assumenda eos aut voluptatibus quasi totam. Voluptatem minus iusto ab et reprehenderit amet.\nBlanditiis sed quaerat aut unde a omnis. Vitae repellendus occaecati est quis aperiam quam eos. Adipisci eius autem ullam cumque.', 1, '2017-07-30 08:43:50', '2017-07-30 08:43:50');

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
(1, 'Добро пожаловать в L-Shop!', '<h1 style=\"text-align: center;\">Современная торговая система для Minecraft</h1><br><p style=\"text-align: center; \"><img src=\"http://i90.fastpic.ru/big/2017/0309/9c/1cebb8e0e70a432b71102bf20334459c.png\" alt=\"Логотип L-Shop\"><br></p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce condimentum nibh quis lorem malesuada, lobortis accumsan felis consequat. Fusce ac tortor gravida, dignissim quam sit amet, laoreet sapien. Nam ultricies libero in dignissim accumsan. Fusce ac lacinia quam. Integer convallis neque ac tortor sollicitudin, ac mollis erat malesuada. Suspendisse sapien turpis, mollis et nibh non, mollis venenatis augue. Aenean et leo sed mi tristique fringilla.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Donec in nibh turpis. Phasellus tincidunt tristique scelerisque. Sed aliquam pretium mauris a mattis. Sed ante magna, facilisis vel lorem eget, rhoncus ullamcorper ligula. Nunc venenatis dolor nec libero interdum, non lobortis libero molestie. Vivamus aliquet lacus non eros ullamcorper, quis convallis nisl aliquet. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nunc posuere ipsum quam, in commodo dui auctor nec.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Praesent dapibus velit eu leo aliquam, accumsan interdum ex laoreet. Etiam nec vehicula odio. Sed aliquam bibendum convallis. Proin sodales id ligula et pellentesque. Ut ullamcorper magna nec convallis pulvinar. Aenean nunc eros, consequat non nibh in, bibendum convallis eros. Vestibulum elit neque, elementum at egestas a, ultricies eget nisi. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed dapibus metus nec nisi semper, eu fringilla diam aliquam. Fusce accumsan gravida justo, sit amet sollicitudin erat suscipit ac. Nulla rhoncus non elit in tempor. Vestibulum at ligula vitae diam dapibus lobortis at a nulla.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Curabitur ac cursus tortor. Donec posuere magna sit amet felis condimentum cursus et vitae dolor. Curabitur vitae mauris a leo consequat sagittis at at tortor. Fusce dui mi, pretium ut tincidunt at, vestibulum et velit. Quisque posuere eleifend velit, nec mattis leo viverra non. Curabitur placerat, neque in sodales eleifend, nisi tortor lacinia nunc, in varius neque ipsum fringilla urna. Morbi nec ipsum diam. Vestibulum tincidunt augue eleifend dictum rutrum. Etiam vel nibh scelerisque, tincidunt mauris et, lacinia orci. Sed consectetur pellentesque malesuada. Suspendisse eget lectus velit.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Donec viverra vehicula nunc, eget fringilla justo rutrum eget. Duis convallis convallis dapibus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse placerat sagittis lacus. Mauris in aliquet urna, id posuere nisl. Phasellus accumsan in metus vel ullamcorper. Praesent pulvinar iaculis mauris vitae vehicula. Nunc vehicula risus massa, a accumsan turpis ornare in. Suspendisse non mauris eu diam convallis finibus ut et ex. Fusce ut dui massa.</p>', 'welcome-to-L-Shop', '2017-07-30 08:43:50', '2017-07-30 08:43:50');

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
(14, 2, 5, 1, 64, 1, 0, '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(15, 20, 6, 1, 16, 1, 0, '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(16, 15, 7, 1, 16, 1, 0, '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(17, 15, 8, 1, 32, 1, 0, '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(18, 67, 9, 1, 1, 2, 0, '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(19, 54, 10, 2, 1, 3, 0, '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(20, 15, 11, 1, 1, 5, 0, '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(21, 100, 11, 1, 0, 5, 0, '2017-07-30 08:43:50', '2017-07-30 08:43:50');

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
(1, 'admin', 'Администратор', '{\"user.admin\":true}', '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(2, 'user', 'Пользователь', '{\"user.admin\":false}', '2017-07-30 08:43:50', '2017-07-30 08:43:50');

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
(1, 1, '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(2, 2, '2017-07-30 08:43:50', '2017-07-30 08:43:50');

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
(1, 'MMO', 1, '127.0.0.1', 25575, 123456, 0, '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(2, 'Hi-Tech (PvP)', 1, '127.0.0.1', 25564, 123456, 0, '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(3, 'Hi-Tech (PvE)', 1, NULL, NULL, NULL, 0, '2017-07-30 08:43:50', '2017-07-30 08:43:50');

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
(34, 'api.launcher.sashok.auth.error_message', 'Пользователь с такими данными не найден'),
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
(1, 'admin', 'admin@example.com', '$2y$10$wxgHJ1rTzp4uh9pVrMoU1.pv6KoFezEQ.wKRR6SNqlVsa02jkGWMy', NULL, NULL, 1000, '5b247d97-751c-11e7-b05c-0a0027000016', NULL, NULL, '2017-07-30 08:43:50', '2017-07-30 08:43:50'),
(2, 'user', 'user@example.com', '$2y$10$DdoyMNXGN.I4XMLcxbC3LOWivOdpF6VdzBLIJ1URFKo6FS7KGcLyG', NULL, NULL, 0, '5b30f3a1-751c-11e7-b05c-0a0027000016', NULL, NULL, '2017-07-30 08:43:50', '2017-07-30 08:43:50');

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

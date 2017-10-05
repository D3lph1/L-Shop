-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 05 2017 г., 19:14
-- Версия сервера: 5.7.19-log
-- Версия PHP: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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
(1, 1, 'XURSqwz68PXqgQxMUfccc0OjJbMmzBPF', 1, '2017-10-05 12:14:15', '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(2, 2, 'NeQkDPyCEDvfrUUL1ReN3WDaYaMxIIjS', 1, '2017-10-05 12:14:15', '2017-10-05 12:14:15', '2017-10-05 12:14:15');

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
(1, 'Блоки', 1, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(2, 'Предметы', 1, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(3, 'Привилегии', 1, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(4, 'Броня', 2, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(5, 'Предметы', 3, '2017-10-05 12:14:15', '2017-10-05 12:14:15');

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
(1, 'Блок травы', '', 'item', '2', NULL, NULL, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(2, 'Динамит', '', 'item', '46', '784a013771bdf825d1cf26b49897a605.png', NULL, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(3, 'Сундук', '', 'item', '54', 'd6c6adf53d0145708ec54a41e8a4e3d8.png', NULL, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(4, 'Печь', '', 'item', '61', '4a69519aa46ee6b5b15bab8abd5139f3.png', NULL, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(5, 'Алмазный меч', '', 'item', '276', '9d8feda602d70231f0297a3b7e436d4b.png', NULL, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(6, 'Алмазный шлем', '', 'item', '310', 'd2714c56c81bcc4ff35798832226967f.png', NULL, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(7, 'VIP', '', 'permgroup', 'vip', 'f0c9755f2685d55b7540c941b6f29ff9.png', NULL, '2017-10-05 12:14:15', '2017-10-05 12:14:15');

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
(1, 'Новость 849', 'Quod quo aut ullam vel qui. Est fugit ut maiores dolorem aut. Praesentium dolorem quisquam omnis officiis voluptas tempora. Similique est sequi quo aut esse. Enim suscipit eos eos ut quibusdam ad aut. Dolores sit maxime ex totam cupiditate ut. Suscipit praesentium aut facilis odit repellat rem explicabo. Sit itaque recusandae suscipit sapiente. Unde accusamus est ea et quis sint eveniet. Sit alias quia deserunt aperiam sequi corporis consequatur. Nulla natus recusandae cum ipsam sed. Consequuntur ipsam eos accusamus et tempora reiciendis. Sint quia molestiae ducimus hic. Et tenetur autem eveniet voluptatem deserunt. Ducimus est magnam corrupti inventore reprehenderit. Fugiat ex recusandae dolores. Eligendi nostrum porro aut ipsum quaerat. Dicta iure voluptas et beatae. Nobis voluptatem culpa voluptatem fuga incidunt non. Tempore molestiae delectus ducimus facere quisquam est. Placeat aut iusto eligendi enim quam et eius. Qui est quaerat repudiandae in hic aut minima. Tempora quibusdam provident quia porro.', 1, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(2, 'Новость 534', 'Aperiam praesentium nam a quam. Ipsam expedita et et ut molestiae rerum et et. Nihil similique repudiandae suscipit et ut. Quasi veritatis explicabo dolorem velit. Minima adipisci et blanditiis rerum. Ducimus ad cupiditate velit aspernatur. Ad non repellat quasi voluptatibus debitis. Nulla omnis commodi praesentium voluptate ut reiciendis. Aliquid a dolores inventore commodi expedita. Placeat praesentium omnis autem aliquid non fuga quidem. Nihil voluptatem at autem rerum maiores. Recusandae temporibus hic quo animi et ducimus est. Rem quia id et omnis architecto rerum. Voluptatibus velit cupiditate deserunt sit dolore maiores vel. Praesentium ab suscipit quasi cum deleniti ut commodi. Consequatur dolore totam qui reiciendis aut suscipit. Ullam harum consequatur voluptate. Ipsa inventore eaque voluptas odit rerum voluptatibus. Aut aliquid quia esse unde quia et sit. Vel id totam non eveniet. Quae aut expedita qui non. Qui explicabo nisi dolorem esse ex animi nam. Neque beatae blanditiis quaerat.', 1, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(3, 'Новость 255', 'Non excepturi vel ipsam. Tempora pariatur provident tempore. Nihil asperiores occaecati facere placeat voluptatibus sequi repudiandae sed. Sit in odio hic vero quaerat vero. Et mollitia voluptatum iste sit neque rem. Eveniet blanditiis aperiam aut exercitationem non sint dolorem. Dolores rerum rerum enim nostrum corrupti. Eius rerum autem voluptatem. Ad nesciunt aliquid blanditiis pariatur dolore eius. Et id praesentium odio cum occaecati velit illo non. Voluptas beatae autem ad facere quos quo. Quis quia ipsum quis et. Excepturi qui laudantium itaque voluptates. Hic commodi minus accusantium harum nesciunt vero. Eos aperiam in at ipsum. Porro autem voluptas illo est. Dolor id quaerat soluta et architecto debitis provident. Autem fuga perferendis voluptatem et. Quia dicta molestiae adipisci et perferendis repellendus eius ea. Quis reiciendis ut dolorem ea non sed.', 1, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(4, 'Новость 953', 'Eum quia saepe perferendis eligendi sequi ipsum nulla commodi. Ipsum inventore fugit omnis nihil. Fugiat ratione voluptatum dolore accusamus nihil molestiae. Blanditiis eos qui omnis quae labore doloribus dolore. Officia non voluptas temporibus aperiam. Exercitationem odit numquam et consequatur sequi. Itaque nulla corrupti aut similique eius. Aliquid ea maiores ducimus omnis perferendis tempore. Quibusdam voluptate et qui asperiores facilis aperiam quo. Veritatis ut dolor at consequatur. Ut molestiae voluptatibus minus eum laboriosam est quibusdam. Et reiciendis porro et voluptatum in ut. Vel qui vel necessitatibus quaerat rerum occaecati. Ipsam in quas facilis omnis et. Quia eos cumque quo. Accusantium sed excepturi laudantium odit quos excepturi. Sit ratione totam praesentium ut iste. Iusto neque quia est commodi quia ut et magnam. Reprehenderit incidunt esse et eveniet ratione. Ut praesentium reiciendis eligendi facere. Velit nulla quod ut dolores quae sint. Harum vitae officiis esse et rerum dolor.', 1, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(5, 'Новость 209', 'Sunt accusantium totam vel rerum molestias maxime eligendi. Voluptatum velit in illum aperiam corporis exercitationem unde. Nulla nihil molestias nulla voluptatem. Facere iste dolores cum quasi in. Aut ipsa libero a amet aliquam maiores. Ipsa nesciunt nihil et voluptas. Adipisci quidem et temporibus aut minima. Est voluptatum rem ut quis et laborum. Aperiam voluptatum dignissimos provident laboriosam natus. Provident maiores numquam est eveniet. Dolore id omnis accusamus sint tempora adipisci. Atque sed perferendis aut aut doloribus. Tempora id magni hic veniam aspernatur harum. Sed molestias cumque a accusantium sunt. Vero voluptatibus qui possimus maxime. Illo accusantium voluptas voluptatem rerum reprehenderit dolor occaecati neque. Porro est eos sint hic at et consectetur. Sapiente voluptatibus autem facilis deserunt. Expedita sit qui id ab accusamus. Nobis enim sequi sunt repellendus. Quae neque quia numquam voluptatem ipsa est quia sed. Consectetur ut id ipsa voluptatum.', 1, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(6, 'Новость 567', 'Ab a nesciunt dicta repellat. Exercitationem rerum nemo sunt quidem laudantium sequi. Est possimus voluptate esse ad dolores iste. Enim rerum nisi dicta impedit officia. Odit ex minus consequuntur consequatur sed dolorem suscipit maiores. Modi provident dolores voluptatem quod quis ut. Inventore accusantium velit quod quam qui est. Doloribus nesciunt id autem ad suscipit at. Qui nobis quia consequatur nemo ipsam velit est et. Tenetur quae et consequuntur ut tempora reiciendis qui. Veniam ad dolorem ullam nobis. Provident explicabo placeat consectetur est facilis. Nesciunt eos neque temporibus quis dignissimos voluptatem est. Hic voluptas ea minima deleniti in. Eos modi omnis expedita repudiandae. Voluptates officiis totam aliquam rem consequatur et nihil in. Accusamus ratione fugit in. Nihil et quae labore soluta modi accusamus. Non expedita voluptatem accusamus in distinctio neque. Similique consequatur natus est magnam.', 1, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(7, 'Новость 227', 'Magni et aperiam porro quia id omnis. Omnis labore asperiores mollitia ut tempora corporis laboriosam. Modi dolorem laborum et. Ut ab sequi dicta autem officia consequatur. Doloribus voluptate velit inventore perferendis. Quia unde et qui officia velit. Qui enim et possimus harum qui dignissimos architecto. Autem provident rerum laboriosam velit. Suscipit dignissimos earum quaerat est natus eius. Earum repellendus fugiat enim dolore. Enim eum eos neque ducimus sit aut. Deleniti cupiditate nihil cupiditate. Aut voluptatem enim voluptatem praesentium non. Debitis facilis atque eligendi tenetur dignissimos maiores et. Recusandae omnis hic quos consequuntur ut expedita id. Itaque at et odio enim non. Mollitia inventore qui ut quae accusamus autem est. Error tenetur non tempore doloremque debitis error. Quia sint corporis consectetur enim ratione earum explicabo in. Et ea quis sunt. Ipsum dolorem asperiores et ea tempore. Eos in sequi enim reprehenderit numquam numquam ex eveniet.', 1, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(8, 'Новость 844', 'Amet error qui sit odit asperiores. Assumenda voluptates exercitationem sit ea. Quia eos aut magnam consequatur. Eos quia voluptas nihil qui maiores et aut. Voluptas ut et provident eaque natus facilis. Est voluptatum voluptate qui ex eligendi deleniti. Dignissimos perferendis provident maiores non. Vel molestiae est in cumque voluptate ipsam rem. Culpa odit natus aspernatur sunt tempora nulla quod. Beatae repellat et id consequatur. Et omnis dicta suscipit facere eos adipisci. Alias molestiae nihil cumque assumenda et. Dolor voluptatibus ut magnam molestiae iure enim. Aliquam in non porro accusamus. Et libero ut provident tempore quos veniam est. Blanditiis ea officia qui eos aut. Maiores quasi id sit corrupti et praesentium. Eum est iure voluptatibus at in. Soluta ipsam vero cupiditate qui aperiam quod in. Sint cumque qui voluptatem officia. Natus error quasi dolores placeat totam corrupti. Optio totam voluptatem minima hic dolores quas occaecati.', 1, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(9, 'Новость 233', 'Reprehenderit dolor velit dolores sit qui animi rerum. Saepe molestias quae explicabo sed qui qui laudantium. Atque qui cumque quasi atque. Et enim voluptates eligendi perspiciatis. Aperiam dolores aliquam dolor eum vero fugit et. Velit nostrum aut commodi quia magni. Mollitia quos hic officiis sit deserunt fugiat dolores beatae. Quam quo aliquam sit ullam provident officia enim. Aut sunt eos est laudantium atque deleniti nesciunt eum. Ducimus culpa repellat ut sunt. Soluta voluptas qui pariatur culpa. Veniam et sapiente architecto. Veritatis animi delectus eligendi veniam placeat. Tempore unde necessitatibus et ullam voluptas repudiandae. Nihil eum neque rerum harum sunt enim enim sequi. Dolores eum a qui quia nisi. Optio tempora veniam suscipit ut nihil. Quaerat fugiat velit eum ut aspernatur sit. Nesciunt aut recusandae ipsum dolor qui deleniti voluptatem. Ipsam aut porro accusamus unde voluptate quos ut. Aut sapiente doloremque similique nemo commodi in.', 1, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(10, 'Новость 514', 'Consequatur illo sint impedit qui ut vero blanditiis minus. Omnis et et beatae in cum dolorum sit. Vel cupiditate nihil quia magni ut expedita esse. Est quo aut ipsam exercitationem suscipit alias. Quasi optio optio velit at quia placeat. Incidunt fuga deserunt sed repellendus. Similique omnis sed esse error sed illum. Saepe et exercitationem similique officiis provident. Dolorem repudiandae nihil recusandae in vero. Rerum nesciunt et enim. Dolorum ducimus eum deleniti ex optio. Qui quisquam sunt aperiam. Nemo eum sed iure occaecati nemo fuga tenetur. Unde aut molestiae voluptatibus labore et. Enim ut ut impedit aut et nesciunt nesciunt. Rerum dolor aliquam maiores aliquid et sequi. Aliquam iure et accusamus enim laudantium delectus. Quibusdam asperiores ea ab consectetur neque recusandae. Aut accusantium sequi alias quas. Ea distinctio rerum qui aut. Libero est odio eligendi neque quos.', 1, '2017-10-05 12:14:15', '2017-10-05 12:14:15');

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
(1, 'Добро пожаловать в L-Shop!', '<h1 style=\"text-align: center;\">Современная торговая система для Minecraft</h1><br><p style=\"text-align: center; \"><img src=\"http://i90.fastpic.ru/big/2017/0309/9c/1cebb8e0e70a432b71102bf20334459c.png\" alt=\"Логотип L-Shop\"><br></p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce condimentum nibh quis lorem malesuada, lobortis accumsan felis consequat. Fusce ac tortor gravida, dignissim quam sit amet, laoreet sapien. Nam ultricies libero in dignissim accumsan. Fusce ac lacinia quam. Integer convallis neque ac tortor sollicitudin, ac mollis erat malesuada. Suspendisse sapien turpis, mollis et nibh non, mollis venenatis augue. Aenean et leo sed mi tristique fringilla.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Donec in nibh turpis. Phasellus tincidunt tristique scelerisque. Sed aliquam pretium mauris a mattis. Sed ante magna, facilisis vel lorem eget, rhoncus ullamcorper ligula. Nunc venenatis dolor nec libero interdum, non lobortis libero molestie. Vivamus aliquet lacus non eros ullamcorper, quis convallis nisl aliquet. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nunc posuere ipsum quam, in commodo dui auctor nec.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Praesent dapibus velit eu leo aliquam, accumsan interdum ex laoreet. Etiam nec vehicula odio. Sed aliquam bibendum convallis. Proin sodales id ligula et pellentesque. Ut ullamcorper magna nec convallis pulvinar. Aenean nunc eros, consequat non nibh in, bibendum convallis eros. Vestibulum elit neque, elementum at egestas a, ultricies eget nisi. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed dapibus metus nec nisi semper, eu fringilla diam aliquam. Fusce accumsan gravida justo, sit amet sollicitudin erat suscipit ac. Nulla rhoncus non elit in tempor. Vestibulum at ligula vitae diam dapibus lobortis at a nulla.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Curabitur ac cursus tortor. Donec posuere magna sit amet felis condimentum cursus et vitae dolor. Curabitur vitae mauris a leo consequat sagittis at at tortor. Fusce dui mi, pretium ut tincidunt at, vestibulum et velit. Quisque posuere eleifend velit, nec mattis leo viverra non. Curabitur placerat, neque in sodales eleifend, nisi tortor lacinia nunc, in varius neque ipsum fringilla urna. Morbi nec ipsum diam. Vestibulum tincidunt augue eleifend dictum rutrum. Etiam vel nibh scelerisque, tincidunt mauris et, lacinia orci. Sed consectetur pellentesque malesuada. Suspendisse eget lectus velit.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Donec viverra vehicula nunc, eget fringilla justo rutrum eget. Duis convallis convallis dapibus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse placerat sagittis lacus. Mauris in aliquet urna, id posuere nisl. Phasellus accumsan in metus vel ullamcorper. Praesent pulvinar iaculis mauris vitae vehicula. Nunc vehicula risus massa, a accumsan turpis ornare in. Suspendisse non mauris eu diam convallis finibus ut et ex. Fusce ut dui massa.</p>', 'welcome-to-L-Shop', '2017-10-05 12:14:15', '2017-10-05 12:14:15');

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
(1, 'Database seeder', '{\"14\":64,\"15\":32}', 42, 1, NULL, 1, '127.0.0.1', 1, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(2, 'Database seeder', '{\"14\":64,\"15\":128,\"17\":64}', 192, 1, NULL, 1, '127.0.0.1', 1, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(3, NULL, '{\"20\":365,\"21\":0}', 5575, 2, NULL, 3, '127.0.0.1', 0, '2017-10-05 12:14:15', '2017-10-05 12:14:15');

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
(14, 2, 1, 1, 64, 1, 0.00, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(15, 20, 2, 1, 16, 1, 0.00, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(16, 15, 3, 1, 16, 1, 0.00, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(17, 15, 4, 1, 32, 1, 0.00, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(18, 67, 5, 1, 1, 2, 0.00, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(19, 54, 6, 2, 1, 3, 0.00, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(20, 15, 7, 1, 1, 5, 0.00, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(21, 100, 7, 1, 0, 5, 0.00, '2017-10-05 12:14:15', '2017-10-05 12:14:15');

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
(1, 'admin', 'Администратор', '{\"user.admin\":true}', '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(2, 'user', 'Пользователь', '{\"user.admin\":false}', '2017-10-05 12:14:15', '2017-10-05 12:14:15');

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
(1, 1, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(2, 2, '2017-10-05 12:14:15', '2017-10-05 12:14:15');

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
(1, 'MMO', 1, '127.0.0.1', 25575, '123456', 0, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(2, 'Hi-Tech (PvP)', 1, '127.0.0.1', 25564, '123456', 0, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(3, 'Hi-Tech (PvE)', 1, NULL, NULL, NULL, 0, '2017-10-05 12:14:15', '2017-10-05 12:14:15');

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
(25, 'monitoring.rcon.pattern', '/^.*(?<now>\\d+)\\sиз\\s(?<total>\\d+).*$/ui'),
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
(54, 'shop.currency', 'Руб.'),
(55, 'shop.currency_html', '<i class=\"fa fa-rub\"></i>'),
(56, 'shop.description', 'Современная торговая система для Minecraft'),
(57, 'shop.enable_password_reset', '1'),
(58, 'shop.enable_signup', '1'),
(59, 'shop.keywords', 'L-Shop,магазин,купить,minecraft,майнкрафт'),
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
(1, 'admin', 'admin@example.com', '$2y$08$gXXWHLNcCZ/MbHCbz84wUe6Se2B13BlqiNgcbhgfYPMbS0jYNJsxO', NULL, NULL, 1000, '3b8fd4ae-a9e8-11e7-bf0c-7054d2aedb4b', NULL, NULL, '2017-10-05 12:14:15', '2017-10-05 12:14:15'),
(2, 'user', 'user@example.com', '$2y$08$dZ/9tx3BJdaySMxADsWn..zqwBXtygGL1hSGxr7AkTsmjEQSuoC.y', NULL, NULL, 0, '3b95b93d-a9e8-11e7-bf0c-7054d2aedb4b', NULL, NULL, '2017-10-05 12:14:15', '2017-10-05 12:14:15');

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

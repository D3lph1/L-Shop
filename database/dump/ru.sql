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
(1, 1, '3PpAmhtXaHcWiRt3EksmcDnNdoQ45eQE', 1, '2017-07-29 19:00:55', '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(2, 2, 'O2xdh4zEakeaq7JqZZkASzWPIsPzzqRP', 1, '2017-07-29 19:00:55', '2017-07-29 19:00:55', '2017-07-29 19:00:55');

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
(1, 'Блоки', 1, '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(2, 'Предметы', 1, '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(3, 'Броня', 2, '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(4, 'Предметы', 3, '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(5, 'Привилегии', 1, '2017-07-29 19:00:55', '2017-07-29 19:00:55');

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
(5, 'Блок травы', '', 'item', '2', NULL, NULL, '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(6, 'Динамит', '', 'item', '46', '784a013771bdf825d1cf26b49897a605.png', NULL, '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(7, 'Сундук', '', 'item', '54', 'd6c6adf53d0145708ec54a41e8a4e3d8.png', NULL, '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(8, 'Печь', '', 'item', '61', '4a69519aa46ee6b5b15bab8abd5139f3.png', NULL, '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(9, 'Алмазный меч', '', 'item', '276', '9d8feda602d70231f0297a3b7e436d4b.png', NULL, '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(10, 'Алмазный шлем', '', 'item', '310', 'd2714c56c81bcc4ff35798832226967f.png', NULL, '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(11, 'VIP', '', 'permgroup', 'vip', 'f0c9755f2685d55b7540c941b6f29ff9.png', NULL, '2017-07-29 19:00:55', '2017-07-29 19:00:55');

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
(1, 'Новость 3', 'Sequi qui tenetur quod tempora laborum sit nostrum. Autem quia magnam fuga iusto officia. Est sunt eveniet ipsam.\nAut et natus repellendus at omnis magnam animi facere. Quis aut amet labore soluta dolorem. Autem eius amet quia. Minus repellendus quaerat atque excepturi quae.\nAut sunt doloremque voluptas magni sequi. Quia nesciunt quisquam eum modi. Reprehenderit architecto sed aperiam sint a voluptas quis. Aspernatur quisquam mollitia aut sed voluptate.\nAccusamus quas voluptatum sunt. Et quia illo eum aspernatur nobis consequatur. Earum voluptatem pariatur et. Aut fuga earum dolor quia ut iusto vel.\nUt iure id suscipit aut. Et est et aut. Sed voluptatem quas sequi pariatur sapiente nulla.\nNon repudiandae cupiditate dolores est blanditiis. Et quae suscipit sit et. Sunt et fugiat tempore debitis quo consequatur.', 1, '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(2, 'Новость 107', 'Ab necessitatibus nisi assumenda. Culpa laudantium aut nemo aut.\nDolore voluptatem qui molestiae quasi esse pariatur ullam. Nam necessitatibus dolorem qui cum nisi amet. Est voluptatem placeat consequuntur et dolor debitis earum ut. Fugiat atque sit ipsam saepe voluptatibus.\nSapiente a dolores vitae optio. Iusto eos voluptas dolor laboriosam corrupti debitis. Similique fugit nostrum nemo reprehenderit blanditiis. Error iure dolor velit placeat cumque.\nNesciunt consectetur omnis non ea pariatur id. Tenetur sit ipsam ratione fugiat sunt quam. Eum qui officia et accusantium cum. Sapiente quos maiores dolor illum quod officiis.\nQuibusdam aliquam ut voluptatum quo voluptatem. Est sint earum voluptatem fugiat nam delectus.\nNobis fugiat ut commodi quia. Impedit et enim et suscipit. Illo qui eaque omnis sapiente quidem qui. Nemo aut eos sequi.\nA molestias quis doloribus totam. Officia soluta voluptate et cupiditate iste adipisci. Deleniti illo laudantium architecto sed.', 1, '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(3, 'Новость 189', 'Exercitationem nam et quod saepe maxime consequatur quas. Perferendis et quisquam pariatur possimus. Et aperiam alias illo reiciendis et natus. Voluptas quia placeat nostrum esse illum.\nRerum velit eligendi ipsam debitis expedita. Architecto facere minus qui ut blanditiis quis. Pariatur quibusdam et in doloremque voluptatem earum quia ullam. Qui ducimus est occaecati quisquam modi vero nulla.\nAspernatur unde dolorem reprehenderit laboriosam. Accusantium nostrum et qui. Debitis et et accusamus consequatur qui. At fugiat omnis quaerat sint libero blanditiis.\nUt reprehenderit aut vel rem nulla ullam quidem. Eos et sit optio et. Similique soluta aut rem vitae suscipit.\nProvident cupiditate provident numquam. Ea nihil sed sed enim repudiandae voluptatem tempora quae. Unde eum quos quas placeat iusto corrupti.\nQuo sunt eos ab ut. Sit voluptas id molestiae. Qui aut adipisci culpa itaque consequuntur officiis deserunt. Aut aperiam blanditiis aut aut autem.', 1, '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(4, 'Новость 968', 'Incidunt et iusto est. Doloribus voluptas quia et. Voluptas consectetur laborum sit dolorem recusandae similique. Sit et non cum dolore. Magni ipsa aliquam cumque quis accusantium.\nTotam laborum aut quasi aperiam velit. Quod tempore sunt quasi porro corporis quisquam odio. Hic consequatur libero dolor velit occaecati esse. Fugit praesentium provident vel rem expedita et voluptatem rerum.\nRecusandae quis ut nam tenetur ullam consectetur. Totam adipisci harum et error officia. Corporis eveniet aut consequatur similique qui eius accusamus. Molestiae pariatur ducimus nemo mollitia.\nEum rem eos occaecati eos enim ratione aut. Officiis sed reiciendis molestiae molestias excepturi et occaecati. Voluptates quia voluptas et non. Eos ut cupiditate aut aut mollitia odit tempora.\nIusto quia facilis tenetur sit officiis aut qui eveniet. Provident quaerat dolor quibusdam id. Enim et illo similique consequatur.\nQuis esse ipsa nesciunt. Asperiores et ut adipisci voluptas. Ut corrupti quisquam voluptatum.', 1, '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(5, 'Новость 893', 'Voluptates eum impedit aut ipsam. Ut dolores deleniti harum consequatur unde quasi. Illo dolorem ut nobis et nesciunt veritatis qui autem. Cum dolore et incidunt at deserunt.\nOfficiis eos eos enim ut. Nihil est et sit ad. Quia autem repellendus et sit molestias. Qui consequatur sed in eum molestiae enim.\nAnimi sapiente at ullam ducimus. Quidem rerum dolorem vero fugit. Et quod velit error est ut nihil.\nNumquam quidem consequatur corporis eveniet. Quam enim maiores quod possimus eum ut.\nAperiam fugit aut temporibus dignissimos. Quisquam tempore tenetur ut dignissimos. Ut et sequi dolor veritatis omnis eligendi. Aut modi voluptatibus non est officia facilis.\nLabore nesciunt velit et magnam. Et similique ut cum non tenetur sint repudiandae. Dolor inventore sed et amet tenetur esse possimus. Harum velit provident debitis soluta fugit voluptatibus rerum. Voluptate rerum quia sequi voluptas hic consequatur.', 1, '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(6, 'Новость 381', 'Autem reiciendis doloremque enim rerum. Odit inventore sunt placeat optio. Animi harum ipsa repellat quasi. Occaecati eos et accusamus eligendi et consequatur autem aut.\nEaque sint ullam in necessitatibus. Labore et velit aut dolores in vel. Omnis omnis iure sit quis.\nQuam provident quia eos qui dolore sit. Eum tenetur maxime rem eius nostrum. Explicabo amet rerum quia repellat deleniti voluptates. Error autem qui quas quam id quo. Quo qui numquam veniam ut.\nRepudiandae quis necessitatibus sequi sint sapiente. Ipsam aut deleniti hic enim similique exercitationem. Qui consequatur cupiditate dolores iure.\nDolore deserunt facilis quos dolor. Est voluptas architecto vel atque cumque rerum.\nOmnis rem enim quo harum. Similique quia ipsam et alias voluptatem dolor soluta.\nItaque iure et aliquid dolore. Quod et nihil rerum sed. Repellendus qui unde incidunt optio dolore rem tempore. Eos sunt voluptatem non dicta assumenda error iste et.', 1, '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(7, 'Новость 112', 'Magni iusto quasi iste. Corrupti suscipit mollitia quis et numquam sit voluptates. Quo quia consequatur commodi deserunt omnis assumenda quia cum. Sit amet est earum nam consequatur assumenda recusandae explicabo. Quam repellendus vero eum quas fuga corporis.\nQui quia impedit minus impedit culpa. Excepturi neque nihil sit ratione. Vel dignissimos quia repudiandae esse. Dolorem fuga aut blanditiis tenetur.\nNemo fugit omnis nemo rerum possimus eum sed. Iste iste tenetur dolor quia autem incidunt. Dolor consequatur dolor dolor distinctio est voluptatem. Non esse quae consequatur facere.\nQuae tempore tenetur minus deleniti veritatis minima. Quo ipsa sapiente alias ex provident tempora veritatis. Distinctio doloremque rerum corporis quia eum voluptatem quam. Fugit ut ducimus labore in voluptates omnis recusandae.\nDolorum rerum id sint sed voluptatem neque sit. Rerum est voluptatem ad qui adipisci eum nostrum. Voluptatum aut dolore placeat esse dolore.', 1, '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(8, 'Новость 894', 'Nesciunt ullam aperiam reprehenderit ut nihil. Quis pariatur modi blanditiis voluptatibus ducimus.\nVoluptates corporis beatae minus nostrum accusantium suscipit. Nam aut voluptatem cum debitis commodi adipisci. Inventore quia repudiandae ab et rerum quam est.\nNam corporis sed quidem exercitationem enim et autem provident. Cum excepturi ea soluta velit optio sed. Voluptatum ad ut aut doloribus qui.\nNesciunt atque at fuga animi atque et. Et repellendus soluta est reiciendis ut sit in repellat. Dolores quae vel voluptatibus repellat asperiores.\nEst dolorem amet non eveniet in laboriosam. Qui neque in amet harum. Provident dolorem totam voluptas repudiandae eum sed.\nInventore doloremque recusandae exercitationem itaque est at sequi. Placeat aut similique nesciunt tempore alias. Dolorem et animi recusandae veniam. Cumque sunt labore quo.\nAutem rem sapiente quis omnis rerum inventore sit. Ut consectetur mollitia ut qui reiciendis. Ut debitis dolores maiores totam et quia.', 1, '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(9, 'Новость 10', 'Molestiae eveniet doloribus explicabo qui alias qui praesentium consequatur. Quisquam eos excepturi aspernatur laudantium. Quas voluptas aperiam hic distinctio provident quam. Illo ratione id magnam illum sit.\nAut laboriosam assumenda rerum. Et necessitatibus quae harum cupiditate iste possimus est. Iusto ut cum molestias illo veniam cum tempora facere. Distinctio quidem aut blanditiis sit. Tenetur illo natus corrupti unde.\nVoluptatem molestias laboriosam tenetur. Et et ut saepe qui quasi. Accusamus nulla dicta quod vel est officiis sed voluptate. Id in repellendus ut facere atque.\nIncidunt culpa unde dolor ipsa magnam expedita esse. Reiciendis voluptas voluptatem molestiae quibusdam error maxime. Explicabo id vitae quis voluptas iste. Quis quam alias dolor officiis facilis natus.\nConsequatur praesentium cupiditate deserunt dolores inventore rerum aut. Commodi laudantium qui nisi earum amet cum. Consequatur est ipsum dolores repudiandae sed atque debitis. Consectetur iure dolorum iste.', 1, '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(10, 'Новость 211', 'Eius tempora dicta tempora voluptatum id. Possimus expedita nulla provident dolorem consequatur voluptatem. Consequatur sed dolores voluptatem error. Ut autem sed fuga aut.\nAdipisci similique laudantium perspiciatis molestiae nisi tempora repellendus. Nisi dicta aperiam et est qui. Placeat tempore similique cumque sint. Quia sint laboriosam veritatis magnam commodi ipsum vitae rem.\nAccusamus maiores est atque. Voluptatem quis blanditiis earum eaque et culpa dolores. Nemo similique temporibus quia hic impedit accusantium. Ab sunt ipsa eligendi et placeat minus.\nVeritatis doloremque nostrum impedit. Cumque ut explicabo dolorum et qui.\nEum quos in quo est culpa. Quod aliquid repellat quia quaerat beatae adipisci laboriosam. Reprehenderit quis alias aliquid vel quibusdam.\nIn rerum nihil fugiat accusamus ut. Officia amet commodi fuga dolor pariatur. Rerum provident eum aut et et. Voluptatem expedita id magnam dolorem velit veritatis.', 1, '2017-07-29 19:00:55', '2017-07-29 19:00:55');

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
(1, 'Добро пожаловать в L-Shop!', '<h1 style=\"text-align: center;\">Современная торговая система для Minecraft</h1><br><p style=\"text-align: center; \"><img src=\"http://i90.fastpic.ru/big/2017/0309/9c/1cebb8e0e70a432b71102bf20334459c.png\" alt=\"Логотип L-Shop\"><br></p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce condimentum nibh quis lorem malesuada, lobortis accumsan felis consequat. Fusce ac tortor gravida, dignissim quam sit amet, laoreet sapien. Nam ultricies libero in dignissim accumsan. Fusce ac lacinia quam. Integer convallis neque ac tortor sollicitudin, ac mollis erat malesuada. Suspendisse sapien turpis, mollis et nibh non, mollis venenatis augue. Aenean et leo sed mi tristique fringilla.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Donec in nibh turpis. Phasellus tincidunt tristique scelerisque. Sed aliquam pretium mauris a mattis. Sed ante magna, facilisis vel lorem eget, rhoncus ullamcorper ligula. Nunc venenatis dolor nec libero interdum, non lobortis libero molestie. Vivamus aliquet lacus non eros ullamcorper, quis convallis nisl aliquet. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nunc posuere ipsum quam, in commodo dui auctor nec.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Praesent dapibus velit eu leo aliquam, accumsan interdum ex laoreet. Etiam nec vehicula odio. Sed aliquam bibendum convallis. Proin sodales id ligula et pellentesque. Ut ullamcorper magna nec convallis pulvinar. Aenean nunc eros, consequat non nibh in, bibendum convallis eros. Vestibulum elit neque, elementum at egestas a, ultricies eget nisi. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed dapibus metus nec nisi semper, eu fringilla diam aliquam. Fusce accumsan gravida justo, sit amet sollicitudin erat suscipit ac. Nulla rhoncus non elit in tempor. Vestibulum at ligula vitae diam dapibus lobortis at a nulla.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Curabitur ac cursus tortor. Donec posuere magna sit amet felis condimentum cursus et vitae dolor. Curabitur vitae mauris a leo consequat sagittis at at tortor. Fusce dui mi, pretium ut tincidunt at, vestibulum et velit. Quisque posuere eleifend velit, nec mattis leo viverra non. Curabitur placerat, neque in sodales eleifend, nisi tortor lacinia nunc, in varius neque ipsum fringilla urna. Morbi nec ipsum diam. Vestibulum tincidunt augue eleifend dictum rutrum. Etiam vel nibh scelerisque, tincidunt mauris et, lacinia orci. Sed consectetur pellentesque malesuada. Suspendisse eget lectus velit.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Donec viverra vehicula nunc, eget fringilla justo rutrum eget. Duis convallis convallis dapibus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse placerat sagittis lacus. Mauris in aliquet urna, id posuere nisl. Phasellus accumsan in metus vel ullamcorper. Praesent pulvinar iaculis mauris vitae vehicula. Nunc vehicula risus massa, a accumsan turpis ornare in. Suspendisse non mauris eu diam convallis finibus ut et ex. Fusce ut dui massa.</p>', 'welcome-to-L-Shop', '2017-07-29 19:00:55', '2017-07-29 19:00:55');

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
(14, 2, 5, 1, 64, 1, 0, '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(15, 20, 6, 1, 16, 1, 0, '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(16, 15, 7, 1, 16, 1, 0, '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(17, 15, 8, 1, 32, 1, 0, '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(18, 67, 9, 1, 1, 2, 0, '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(19, 54, 10, 2, 1, 3, 0, '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(20, 15, 11, 1, 1, 5, 0, '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(21, 100, 11, 1, 0, 5, 0, '2017-07-29 19:00:55', '2017-07-29 19:00:55');

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
(1, 'admin', 'Администратор', '{\"user.admin\":true}', '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(2, 'user', 'Пользователь', '{\"user.admin\":false}', '2017-07-29 19:00:55', '2017-07-29 19:00:55');

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
(1, 1, '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(2, 2, '2017-07-29 19:00:55', '2017-07-29 19:00:55');

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
(1, 'MMO', 1, '127.0.0.1', 25575, 123456, 0, '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(2, 'Hi-Tech (PvP)', 1, '127.0.0.1', 25564, 123456, 0, '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(3, 'Hi-Tech (PvE)', 1, NULL, NULL, NULL, 0, '2017-07-29 19:00:55', '2017-07-29 19:00:55');

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
(1, 'admin', 'admin@example.com', '$2y$10$Ub2bmH7w3SpD3rnwzOy4N.kbB0NBip7Jw448YSFNrBsL8kmPFIO9m', NULL, NULL, 1000, '656e785f-74a9-11e7-b1a5-0a0027000016', NULL, NULL, '2017-07-29 19:00:55', '2017-07-29 19:00:55'),
(2, 'user', 'user@example.com', '$2y$10$DgjEnuGNyS8BXupz4sB3vOBY7dgIwq6lAs0eyBx2JR6Rmlbpgjo.K', NULL, NULL, 0, '657ac805-74a9-11e7-b1a5-0a0027000016', NULL, NULL, '2017-07-29 19:00:55', '2017-07-29 19:00:55');

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

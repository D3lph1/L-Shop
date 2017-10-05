-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 05 2017 г., 19:15
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
(1, 1, '4eYVXycwKb9bkv41oT5nkiYOzj5Zd33q', 1, '2017-10-05 12:15:29', '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(2, 2, 'ePwNaz4ZEDuJ0DSrBfu88cz4XuVPdhsm', 1, '2017-10-05 12:15:29', '2017-10-05 12:15:29', '2017-10-05 12:15:29');

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
(1, 'Blocks', 1, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(2, 'Items', 1, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(3, 'Privileges', 1, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(4, 'Armor', 2, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(5, 'Items', 3, '2017-10-05 12:15:29', '2017-10-05 12:15:29');

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
(1, 'Block of grass', '', 'item', '2', NULL, NULL, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(2, 'TNT', '', 'item', '46', '784a013771bdf825d1cf26b49897a605.png', NULL, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(3, 'Chest', '', 'item', '54', 'd6c6adf53d0145708ec54a41e8a4e3d8.png', NULL, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(4, 'Furnace', '', 'item', '61', '4a69519aa46ee6b5b15bab8abd5139f3.png', NULL, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(5, 'Diamond sword', '', 'item', '276', '9d8feda602d70231f0297a3b7e436d4b.png', NULL, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(6, 'Diamond helmet', '', 'item', '310', 'd2714c56c81bcc4ff35798832226967f.png', NULL, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(7, 'VIP', '', 'permgroup', 'vip', 'f0c9755f2685d55b7540c941b6f29ff9.png', NULL, '2017-10-05 12:15:29', '2017-10-05 12:15:29');

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
(1, 'News 766', 'Eaque repudiandae molestias nihil asperiores qui et sit. Assumenda dolor esse fugiat est. Dolores accusamus alias iusto quod. Eveniet voluptate omnis in et dolorem sequi. Dolorem ea magnam ea aspernatur. Est laboriosam eos eligendi iste beatae. Quae iusto minus sit et illo doloribus ex. A minus inventore excepturi et libero quibusdam. Illum quaerat ab maxime et eos unde. Molestiae voluptatem quam non aut. Quaerat ad nostrum id commodi itaque. Inventore est possimus velit ut id labore fugiat. Illum excepturi qui qui mollitia sunt sint. Totam animi quis officiis nihil quo a repudiandae. Dolor recusandae velit sit id est a. Velit odio vel ipsam minima. Rerum voluptas nesciunt odit at molestias. Veritatis ut aliquam reprehenderit veritatis ducimus sequi magni. Illum quia perspiciatis neque debitis ipsum harum. Et alias sit in quos. Ad enim et qui voluptatem atque corrupti. Autem velit saepe ullam.', 1, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(2, 'News 619', 'Esse necessitatibus dolores aut quis est. Nostrum iusto quidem corporis qui quia iure. Modi eos ut temporibus ex expedita. Odio aut perspiciatis cum commodi perferendis hic animi. Magni voluptas voluptatem aut qui. Officia omnis aut qui sequi officiis. Molestiae eaque eum quas ipsum. Et dolor aut natus voluptas. Eum assumenda quaerat eius porro dolorem eveniet amet. Commodi aut molestiae laboriosam in magnam. Qui molestiae quo ipsam molestiae tenetur dolor expedita. Non fugiat aliquid ad doloremque quia placeat dolorum cupiditate. Eos et laborum quod voluptas. Deserunt qui voluptate eligendi pariatur mollitia. Quis et quisquam cumque sed inventore. Velit autem repellendus non sit voluptate rerum. Aut iusto quia nulla quisquam eum qui aut aut. Qui veniam expedita explicabo impedit ad nostrum dolore. Qui tempore qui aut ut id et. Suscipit iusto ea quo est recusandae sit vero.', 1, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(3, 'News 396', 'Ullam consectetur quae minus vitae molestiae. Expedita quasi et qui molestiae. Voluptatem voluptatem possimus corporis voluptatem. Magnam laborum qui voluptas saepe. Doloremque perferendis mollitia doloribus molestiae quos at molestiae. In quo laborum nobis eum nesciunt perspiciatis. Quia ullam soluta labore aliquid. Ut commodi molestias cupiditate dolores numquam id. Esse sit ex repellat error non at sint. In quo nisi dolores quod. Aut repellat dolores velit quia. Modi dolore earum et aliquam cupiditate dicta aliquam. Dolorem aut sunt omnis est itaque sunt assumenda. Rerum distinctio ex vitae maiores molestiae. Qui officiis ullam a et labore. Placeat porro sunt aut quas et libero. Porro dolorem magni cum dignissimos ipsam eaque excepturi impedit. Fugiat sint alias ut at harum. Fugit voluptates est accusamus et ea. Necessitatibus tempore perferendis sequi sit est eum ducimus et. Accusantium cum vel assumenda minus incidunt. Non blanditiis quia assumenda veniam incidunt id voluptas.', 1, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(4, 'News 580', 'Id accusantium est tenetur provident. Cumque qui iste suscipit et ut nesciunt reprehenderit. Ut quis et sunt quaerat et incidunt. Optio fugit ex ut. Nulla voluptas illo consequatur officiis omnis reiciendis. Veritatis cum velit voluptatem et eos quibusdam illum. Sequi non rem sequi doloribus sunt hic. Harum laborum rerum et numquam inventore necessitatibus. Quia deserunt quod inventore autem reiciendis dolores voluptate. Asperiores beatae sunt est impedit vel. Aliquam praesentium dolore nam. Repudiandae velit fugit voluptas. Quia voluptates eos illo et cupiditate. Sit et quasi sunt voluptatem eum. Sit voluptatibus quos qui dolor id rerum. Labore explicabo temporibus ducimus placeat blanditiis. Veniam inventore voluptas cupiditate et. Vel aut suscipit minus vel magni eius non. Pariatur quasi ex enim pariatur dolor ut. Corrupti non et non nihil ut quasi. Perspiciatis perspiciatis sit eum saepe repellat a nesciunt. Modi et et autem temporibus fugit.', 1, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(5, 'News 782', 'Ipsum animi non similique qui corrupti exercitationem quis aut. Dolores saepe voluptate vitae eius mollitia voluptas et nisi. Iure deserunt totam corporis dolorem quidem nihil qui. Impedit nulla libero inventore ut ipsam. Asperiores quaerat aperiam aut rem necessitatibus modi voluptatum ullam. Ut inventore officiis aliquid incidunt vel eaque. Ea rerum officiis amet possimus nemo ducimus dolores. Consequatur harum rem nostrum rerum aut sequi eveniet reprehenderit. Rem autem dignissimos delectus laudantium vel. Sit magni eius quas labore dignissimos. Exercitationem corrupti praesentium non veritatis vitae non fugit. Ut enim et voluptatibus eveniet repellat dolor aut. Deleniti aut quas placeat sed praesentium. At veniam totam non facere unde iure accusantium. Qui excepturi quaerat quia enim sint exercitationem sit. Eos qui dicta sed. Quia vitae consectetur autem id consequatur inventore porro.', 1, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(6, 'News 723', 'Eligendi quibusdam rerum architecto minima. Et qui iste et ut eum accusamus. Ducimus iusto laborum maxime debitis ea odio ea esse. Voluptatem est nihil quo odit dolore molestias. Ad et voluptatem illo hic iure ipsum voluptatem. Ratione inventore sit nostrum quia. Mollitia id quia officia sapiente aspernatur totam voluptas. Id omnis molestiae error minus et consectetur. Esse nulla unde exercitationem ab dicta. Numquam sint aut corporis. Adipisci quia itaque blanditiis rerum dignissimos. Sunt in molestiae quidem quibusdam voluptatum iure. Natus voluptatum ipsa odio aperiam. Ut ut rerum asperiores odit illo. Et excepturi consequatur ut omnis tempora minus quos. Consectetur assumenda repellat voluptas et. Quas modi provident deleniti delectus eaque aliquam tempore debitis. Voluptatem autem iure quos consectetur dolor. Reiciendis beatae molestias vel totam quo non et ut. Iure sunt quia ipsum rerum eum rerum omnis. Cumque aspernatur qui qui alias impedit aut voluptatem.', 1, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(7, 'News 8', 'Delectus et itaque iure aut atque sapiente aliquid. Et delectus a unde officiis. Quasi repellendus quos et ut nemo minus. Sit omnis reiciendis aut totam laboriosam iure. Et asperiores voluptatem quae atque architecto. Placeat voluptatum ab quo sunt. Perferendis autem voluptatem dolorem quaerat neque qui. Iste eos omnis libero voluptatem et aut accusantium. Nulla est inventore soluta temporibus. Voluptatem assumenda aut quis iste quasi. Aliquam quo nam incidunt sint libero eaque. Soluta officia quis adipisci tenetur porro quis. Et nostrum asperiores nobis error labore. Omnis quia distinctio velit numquam. Eveniet illum accusantium enim in alias. Iure nemo vel sed. Exercitationem recusandae maiores maxime pariatur commodi. Sapiente aut vitae dolor. Iusto qui ea minus temporibus. Ut iusto et dignissimos eveniet molestiae.', 1, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(8, 'News 665', 'Id voluptas molestiae voluptatem tenetur ex itaque quam. Quis rerum atque sunt corrupti. Aliquam cupiditate enim adipisci odit alias ipsam. Quis quam aut incidunt illo saepe inventore. Fuga distinctio tempora doloribus sint aliquam vel. Provident ipsum aliquam maxime saepe ex. Dolor rerum qui corporis corporis ipsum nihil qui. Ut consequatur id doloremque. Numquam quidem eum quaerat ipsa aut. Iure rerum voluptatem iste asperiores odio. Beatae qui quam itaque ipsa quae. Mollitia in qui veniam harum impedit doloremque velit. Sequi quia quia nesciunt blanditiis qui ullam. Similique fuga quidem eos aut. Sequi mollitia at ut iure non dolorem incidunt. Quis quia ut nihil soluta qui. Reprehenderit perferendis velit aspernatur omnis ut. Repudiandae aperiam rem tempora corrupti at cumque consequatur. Totam quis deleniti voluptatem vel alias. Ea quo quod architecto omnis ipsam temporibus aut laudantium.', 1, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(9, 'News 386', 'Necessitatibus aut dolores maxime aperiam deleniti. Sunt veniam earum at adipisci perspiciatis rerum sint. Et ut amet placeat nemo sit assumenda soluta consequatur. Similique est similique eos est incidunt. Quidem ut vel tempore magnam qui. Commodi accusamus delectus maxime iusto aut. Ipsum esse atque dolorum eos. Laudantium sunt similique in dolore voluptate nulla eveniet. Voluptatem et ullam molestiae delectus. Totam facilis ea voluptatem veniam vitae soluta molestias eum. In consequatur possimus nam exercitationem neque sint id. Quos fugit magnam facere nam qui. Modi ab quaerat iste. Facilis laborum nihil autem sit exercitationem numquam distinctio. Deleniti aperiam numquam unde iusto doloremque voluptas. Provident consequatur velit tempora itaque rerum at. Nostrum pariatur expedita repellat saepe. Quo iste asperiores laudantium. Repudiandae pariatur minus corporis perspiciatis. Aut dolorem delectus tempora corrupti cum.', 1, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(10, 'News 6', 'Odio enim doloribus in rerum. Ut provident impedit nihil ut. Consequuntur laborum ipsam itaque rem mollitia vel. Sunt doloremque culpa et et reprehenderit aut amet. Maxime laborum inventore delectus. Et quis illo suscipit excepturi et dolores. Architecto sed et id repellendus qui doloribus. Blanditiis placeat quos recusandae vero autem sunt perferendis ex. Mollitia corrupti repudiandae aspernatur ullam est. Et sunt molestiae cum autem non id. Mollitia iure est aspernatur eum alias. Laborum non et reprehenderit quia occaecati totam. Doloremque perspiciatis quisquam maiores ut. Nam facilis molestias quae molestiae. Voluptatibus voluptas earum omnis ullam. Sunt labore et quidem ut nihil illum. Aut accusamus voluptas reiciendis dolores. Pariatur voluptas architecto sint eaque. Laborum sit est et tenetur nihil autem. Voluptatem voluptate tempore doloribus autem et. Mollitia corrupti voluptas provident dolore ut. Quo eius adipisci aut.', 1, '2017-10-05 12:15:29', '2017-10-05 12:15:29');

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
(1, 'Welcome to L-Shop!', '<h1 style=\"text-align: center;\">Modern trading system for Minecraft</h1><br><p style=\"text-align: center; \"><img src=\"http://i90.fastpic.ru/big/2017/0309/9c/1cebb8e0e70a432b71102bf20334459c.png\" alt=\"Логотип L-Shop\"><br></p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce condimentum nibh quis lorem malesuada, lobortis accumsan felis consequat. Fusce ac tortor gravida, dignissim quam sit amet, laoreet sapien. Nam ultricies libero in dignissim accumsan. Fusce ac lacinia quam. Integer convallis neque ac tortor sollicitudin, ac mollis erat malesuada. Suspendisse sapien turpis, mollis et nibh non, mollis venenatis augue. Aenean et leo sed mi tristique fringilla.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Donec in nibh turpis. Phasellus tincidunt tristique scelerisque. Sed aliquam pretium mauris a mattis. Sed ante magna, facilisis vel lorem eget, rhoncus ullamcorper ligula. Nunc venenatis dolor nec libero interdum, non lobortis libero molestie. Vivamus aliquet lacus non eros ullamcorper, quis convallis nisl aliquet. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nunc posuere ipsum quam, in commodo dui auctor nec.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Praesent dapibus velit eu leo aliquam, accumsan interdum ex laoreet. Etiam nec vehicula odio. Sed aliquam bibendum convallis. Proin sodales id ligula et pellentesque. Ut ullamcorper magna nec convallis pulvinar. Aenean nunc eros, consequat non nibh in, bibendum convallis eros. Vestibulum elit neque, elementum at egestas a, ultricies eget nisi. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed dapibus metus nec nisi semper, eu fringilla diam aliquam. Fusce accumsan gravida justo, sit amet sollicitudin erat suscipit ac. Nulla rhoncus non elit in tempor. Vestibulum at ligula vitae diam dapibus lobortis at a nulla.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Curabitur ac cursus tortor. Donec posuere magna sit amet felis condimentum cursus et vitae dolor. Curabitur vitae mauris a leo consequat sagittis at at tortor. Fusce dui mi, pretium ut tincidunt at, vestibulum et velit. Quisque posuere eleifend velit, nec mattis leo viverra non. Curabitur placerat, neque in sodales eleifend, nisi tortor lacinia nunc, in varius neque ipsum fringilla urna. Morbi nec ipsum diam. Vestibulum tincidunt augue eleifend dictum rutrum. Etiam vel nibh scelerisque, tincidunt mauris et, lacinia orci. Sed consectetur pellentesque malesuada. Suspendisse eget lectus velit.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Donec viverra vehicula nunc, eget fringilla justo rutrum eget. Duis convallis convallis dapibus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse placerat sagittis lacus. Mauris in aliquet urna, id posuere nisl. Phasellus accumsan in metus vel ullamcorper. Praesent pulvinar iaculis mauris vitae vehicula. Nunc vehicula risus massa, a accumsan turpis ornare in. Suspendisse non mauris eu diam convallis finibus ut et ex. Fusce ut dui massa.</p>', 'welcome-to-L-Shop', '2017-10-05 12:15:29', '2017-10-05 12:15:29');

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
(1, 'Database seeder', '{\"14\":64,\"15\":32}', 42, 1, NULL, 1, '127.0.0.1', 1, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(2, 'Database seeder', '{\"14\":64,\"15\":128,\"17\":64}', 192, 1, NULL, 1, '127.0.0.1', 1, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(3, NULL, '{\"20\":365,\"21\":0}', 5575, 2, NULL, 3, '127.0.0.1', 0, '2017-10-05 12:15:29', '2017-10-05 12:15:29');

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
(14, 2, 1, 1, 64, 1, 0.00, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(15, 20, 2, 1, 16, 1, 0.00, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(16, 15, 3, 1, 16, 1, 0.00, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(17, 15, 4, 1, 32, 1, 0.00, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(18, 67, 5, 1, 1, 2, 0.00, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(19, 54, 6, 2, 1, 3, 0.00, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(20, 15, 7, 1, 1, 5, 0.00, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(21, 100, 7, 1, 0, 5, 0.00, '2017-10-05 12:15:29', '2017-10-05 12:15:29');

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
(1, 'admin', 'Administrator', '{\"user.admin\":true}', '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(2, 'user', 'User', '{\"user.admin\":false}', '2017-10-05 12:15:29', '2017-10-05 12:15:29');

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
(1, 1, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(2, 2, '2017-10-05 12:15:29', '2017-10-05 12:15:29');

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
(1, 'MMO', 1, '127.0.0.1', 25575, '123456', 0, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(2, 'Hi-Tech (PvP)', 1, '127.0.0.1', 25564, '123456', 0, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(3, 'Hi-Tech (PvE)', 1, NULL, NULL, NULL, 0, '2017-10-05 12:15:29', '2017-10-05 12:15:29');

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
(1, 'admin', 'admin@example.com', '$2y$08$x4EHSomHi/GKWqNuu.edLOqPKef8.3rA8OdovaljILSw97cvwXJgK', NULL, NULL, 1000, '678aef7f-a9e8-11e7-bf0c-7054d2aedb4b', NULL, NULL, '2017-10-05 12:15:29', '2017-10-05 12:15:29'),
(2, 'user', 'user@example.com', '$2y$08$I.7fV6ZzFSWErGYEdu43Ae3E0Mu/18/15wfmAmoFXP1SMlOyZUAuK', NULL, NULL, 0, '679124b3-a9e8-11e7-bf0c-7054d2aedb4b', NULL, NULL, '2017-10-05 12:15:29', '2017-10-05 12:15:29');

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

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
(1, 1, 'cBdG79Gji8BwJQZbCHIGMZ7Xup3HuzzV', 1, '2017-09-08 16:33:50', '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(2, 2, '7LfYzrHjrcwUs9447ooppzDUXk8cld7m', 1, '2017-09-08 16:33:50', '2017-09-08 16:33:50', '2017-09-08 16:33:50');

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
(1, 'Blocks', 1, '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(2, 'Items', 1, '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(3, 'Armor', 2, '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(4, 'Items', 3, '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(5, 'Privileges', 1, '2017-09-08 16:33:50', '2017-09-08 16:33:50');

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
(5, 'Block of grass', '', 'item', '2', NULL, NULL, '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(6, 'TNT', '', 'item', '46', '784a013771bdf825d1cf26b49897a605.png', NULL, '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(7, 'Chest', '', 'item', '54', 'd6c6adf53d0145708ec54a41e8a4e3d8.png', NULL, '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(8, 'Furnace', '', 'item', '61', '4a69519aa46ee6b5b15bab8abd5139f3.png', NULL, '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(9, 'Diamond sword', '', 'item', '276', '9d8feda602d70231f0297a3b7e436d4b.png', NULL, '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(10, 'Diamond helmet', '', 'item', '310', 'd2714c56c81bcc4ff35798832226967f.png', NULL, '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(11, 'VIP', '', 'permgroup', 'vip', 'f0c9755f2685d55b7540c941b6f29ff9.png', NULL, '2017-09-08 16:33:50', '2017-09-08 16:33:50');

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
(1, 'News 63', 'Omnis error dicta et. Sit voluptatum iste earum rerum expedita tempore deserunt. Ea quis dolor alias molestias deleniti consequatur.\nMaxime animi reprehenderit non dolorem. Accusamus aspernatur dolores soluta facere.\nMagnam quia architecto voluptas dolor fuga. Totam consequuntur quia possimus esse sit laudantium. Et quo voluptatem odit. Recusandae consectetur alias occaecati.\nDistinctio repellendus sint aut. Qui placeat quo sit eum omnis commodi dolorem pariatur. Dolorem nisi saepe nemo qui sit. Nobis dicta aut hic quia quaerat eligendi.\nDicta dolores officiis error eos. Error et atque dolores sint animi tempora quis ut.\nAut exercitationem omnis veritatis. Quaerat veniam minima pariatur molestiae. Ea a quia nostrum quisquam sapiente ipsum sunt. Officia ea aut dolorem quas rem in.\nVitae blanditiis deserunt facere id. Dignissimos labore qui accusamus quis molestiae saepe velit.\nProvident a similique praesentium sed. Quia eaque et rerum molestiae.', 1, '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(2, 'News 576', 'Ut quo eligendi ab dolores. Quisquam fuga qui similique. Voluptates alias quis ut culpa suscipit labore iste.\nUt eveniet rerum quia distinctio. Vel sit culpa fugiat ratione deleniti culpa aut. Esse numquam eum vero ut. Molestiae optio omnis accusantium quidem.\nQuo esse autem dolores sequi cupiditate. Consequatur rem doloribus quia non ex ipsum et nemo. Placeat porro id sit ipsum. Quisquam culpa soluta qui sequi iure temporibus pariatur.\nNam qui nulla pariatur et deleniti accusantium qui. Quaerat sit adipisci quo quam. Sed non aut ea repudiandae itaque dolorum minima est.\nNobis non aliquid quod repellat. Est illum exercitationem repellat qui omnis.\nIn adipisci inventore iste. Aut quidem tempore quisquam alias. Quis vel sed sit rerum nulla et autem. Commodi non illum sunt. Qui quia voluptas est ea non delectus.', 1, '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(3, 'News 515', 'Optio magnam et aspernatur qui. Doloribus voluptates non eum maiores repellat consequatur. Earum occaecati officia dolores magnam.\nAb perferendis necessitatibus deserunt provident explicabo earum. Vero ut provident explicabo ipsa aut voluptates. Fuga modi aut eaque rerum nemo velit tempora.\nImpedit iure porro possimus voluptatem. Sit optio illo voluptas. Architecto quas nisi error reiciendis ut. Voluptate voluptatibus sit ut ut odit repellat.\nDolores mollitia nobis deserunt cum eaque optio qui. Non rerum dolor magnam suscipit eum libero et. Quae iure veniam praesentium est debitis et inventore. Rerum et sint et repudiandae voluptatem. Repudiandae doloribus quam officiis.\nVitae tempore exercitationem iure natus voluptatibus exercitationem dolores earum. Iusto animi optio vero omnis ipsum non laudantium. Dolorum eos voluptate molestiae amet qui et.', 1, '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(4, 'News 181', 'Iusto quis vel assumenda dolorum molestias et. Sint sunt adipisci quis praesentium maxime sequi adipisci. Molestias quia nostrum quia voluptas quae et minus.\nQui dolorem hic quaerat nisi tempore. Culpa sequi magni quasi excepturi recusandae ut. Consequatur aut dolor sunt.\nDolore autem debitis rerum architecto. Fugit ut sit quia debitis possimus. Voluptatum officiis recusandae est ut ab voluptate. Est quia earum dolorem reprehenderit voluptas incidunt aut numquam.\nMaiores quia natus error. Nisi quia id architecto est. Fugit cum voluptatibus deleniti vel.\nAutem assumenda quos illo expedita distinctio voluptatibus. Saepe corrupti neque beatae ipsam. Dolorum ut dicta eius quas beatae recusandae et. Id ab cumque aut.\nIpsa ratione eius et unde minus. Nobis et ab est sunt. Magnam enim laboriosam quo sunt qui officia sequi quidem.\nQuae nam sit perspiciatis fugiat doloremque illo modi molestiae. Reiciendis dolores aliquam qui dolorem quo aut. Qui ut mollitia iste eos qui sed a ut. Nesciunt vitae eaque et earum.', 1, '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(5, 'News 697', 'Sit dolor iure nulla mollitia dolorum quas et. Soluta amet voluptatem aut pariatur consequatur repudiandae. Corporis est aliquid reiciendis labore eum omnis consequatur in. Eum qui quos explicabo maxime aperiam. Nihil in et error magni at molestiae.\nNihil quis et ut quasi unde et. Eaque aut officiis voluptatem. Enim animi sed dolorum eaque perferendis.\nConsectetur culpa reprehenderit beatae optio ullam at libero provident. Ut assumenda delectus corporis ut quos beatae exercitationem. Sit id quas et ab debitis non id consequatur.\nRepellat sunt officiis nobis perspiciatis consequatur consequatur suscipit magnam. Amet iusto optio tenetur doloremque eveniet non.\nQui porro et deleniti non. Nemo magni earum nihil consequatur. Explicabo commodi natus in commodi nisi animi aut. Alias repellendus voluptatum quae molestiae est.\nHarum doloremque consequatur deleniti quaerat. Ex aperiam cupiditate deleniti enim reiciendis voluptates. Sunt veritatis temporibus in deleniti ut.', 1, '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(6, 'News 783', 'Quis eligendi libero autem consequatur tenetur et. Velit adipisci vero beatae provident. Voluptate dolore similique necessitatibus aut sed dolore cum. Totam illo quos numquam.\nId numquam nostrum est repellat eum. Libero cumque sint odio sint qui. Hic dignissimos et aliquam officiis dolores.\nPariatur sunt velit corrupti animi doloremque enim eum non. Quibusdam laboriosam excepturi vero cumque ut. Consequuntur ratione et et similique blanditiis eaque. Omnis architecto exercitationem et exercitationem et aspernatur ullam sit. Voluptas repellat voluptas est a sed animi.\nEst dignissimos sed tenetur molestiae rem. Ipsum similique a dolorem tenetur. Illo minima vero sit aut fugit sed occaecati.\nExpedita et vitae iste voluptatem et. Odit ipsum et dignissimos aliquam quia odit in qui. Dolores cupiditate omnis in atque. Asperiores fugit quae dignissimos quis et ex assumenda eos.\nNemo corporis doloribus qui laborum quaerat aut. Sed officia distinctio odio illo saepe dolor repellat.', 1, '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(7, 'News 26', 'Quia enim dicta et qui. Voluptatem animi rem excepturi similique provident quo. Doloribus quia sint aut cumque distinctio.\nAut similique veritatis placeat earum atque velit est. Voluptates hic quibusdam nemo est dignissimos sapiente. Est nihil autem tempore quaerat.\nTempora sit natus et. Cumque deserunt ducimus eos at ut est earum. Beatae voluptas necessitatibus optio non. Et eveniet quae dolor sit aut nihil dignissimos.\nQuo nihil eos libero maiores eius. Quia qui enim officia consequatur quas est. Rerum quo harum debitis vel. Consequatur a et aperiam reprehenderit ipsum rerum. Doloribus excepturi modi minima officia et est.\nUt maxime quod doloremque qui quia dolorem minus. Expedita consequatur quis nam aut accusantium mollitia hic. Voluptas rem sunt eum tempora sapiente laudantium. Quas sunt accusamus eum reprehenderit ipsam.', 1, '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(8, 'News 374', 'Tenetur deleniti ad qui nostrum aut excepturi magnam. Et et in et nesciunt quos consectetur reiciendis.\nRerum officiis quidem iste ipsam est. Earum et in animi at ut nihil. Earum eos blanditiis consequatur sunt voluptatem laudantium minima. Doloremque quis rerum sit.\nMolestiae esse laboriosam molestias quas tempora. Illo quis voluptatem eligendi ut similique et ut. Sunt tempora maiores odio culpa.\nQuia est voluptates voluptas a ut. Officiis magni consequuntur minima nihil. Nihil aut eius molestiae.\nNobis assumenda velit est. Nihil vel sed dolorum rerum. Tenetur dolorem sequi velit repellendus doloribus.\nEsse quia omnis ut culpa ut sequi quo. Et totam eaque ut autem. Quis eum inventore quos iste. Voluptatem ducimus officia in repellat aspernatur quasi.\nProvident fuga illum iure fuga. Quo non a harum unde. Qui est ut neque hic consequuntur eum ducimus.\nQuidem illum consequatur molestias consequatur sequi esse. Temporibus et esse delectus quos aut ut sit.', 1, '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(9, 'News 555', 'Sint omnis consequatur aliquam ad quia non. Fuga quam ut qui odio rerum amet et. Provident molestiae repellendus aliquam at non magnam id.\nIure laudantium perspiciatis est inventore in. Ad voluptates aliquam dignissimos perspiciatis. Quia incidunt fugiat odio quod non.\nEt eum voluptatem qui qui nulla. Est blanditiis temporibus ex enim eveniet praesentium architecto amet. Voluptatum quo eligendi doloribus aut itaque. A ut eos alias dicta vero eos omnis. Quo sed cum ea sint.\nFugiat maxime necessitatibus dicta quisquam praesentium. Ea voluptatem enim vel ipsam at aliquid. Omnis adipisci pariatur error enim hic rerum nihil temporibus. Voluptatem vitae eum autem voluptatem.\nNulla sunt ducimus cum. Modi nam nesciunt quas sapiente. Repellendus sint magnam magni sed eos.\nRerum sint quisquam alias tempore et aut iste. Officiis eligendi eos sunt eius alias libero iste. Ea odio ducimus quia quis voluptatem.', 1, '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(10, 'News 360', 'Et voluptate sapiente aut sint quas. Nihil et natus voluptas omnis rerum at. Doloremque praesentium molestiae earum harum consequatur nesciunt. Accusamus laudantium qui autem nostrum. Doloribus odio rerum in velit qui et.\nAt quo perferendis omnis atque veritatis. Nemo minus nihil quia non ipsa. Veritatis ex et id iste natus asperiores. Possimus explicabo magnam numquam excepturi dolor non rem.\nQuia amet magnam occaecati rerum nisi. Quia nihil et quam saepe qui dolor tempora. Aut suscipit maxime dolor quod aut.\nSed eum laboriosam reiciendis ipsa ab nam non blanditiis. Perferendis nemo culpa eos earum voluptatum aut. Modi cupiditate omnis sint optio sit. Et asperiores incidunt eos delectus.\nSed praesentium aspernatur possimus quam voluptas. Et et consequuntur autem nihil quisquam in. Sed voluptas qui est quia.', 1, '2017-09-08 16:33:50', '2017-09-08 16:33:50');

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
(1, 'Welcome to L-Shop!', '<h1 style=\"text-align: center;\">Modern trading system for Minecraft</h1><br><p style=\"text-align: center; \"><img src=\"http://i90.fastpic.ru/big/2017/0309/9c/1cebb8e0e70a432b71102bf20334459c.png\" alt=\"Логотип L-Shop\"><br></p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce condimentum nibh quis lorem malesuada, lobortis accumsan felis consequat. Fusce ac tortor gravida, dignissim quam sit amet, laoreet sapien. Nam ultricies libero in dignissim accumsan. Fusce ac lacinia quam. Integer convallis neque ac tortor sollicitudin, ac mollis erat malesuada. Suspendisse sapien turpis, mollis et nibh non, mollis venenatis augue. Aenean et leo sed mi tristique fringilla.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Donec in nibh turpis. Phasellus tincidunt tristique scelerisque. Sed aliquam pretium mauris a mattis. Sed ante magna, facilisis vel lorem eget, rhoncus ullamcorper ligula. Nunc venenatis dolor nec libero interdum, non lobortis libero molestie. Vivamus aliquet lacus non eros ullamcorper, quis convallis nisl aliquet. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nunc posuere ipsum quam, in commodo dui auctor nec.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Praesent dapibus velit eu leo aliquam, accumsan interdum ex laoreet. Etiam nec vehicula odio. Sed aliquam bibendum convallis. Proin sodales id ligula et pellentesque. Ut ullamcorper magna nec convallis pulvinar. Aenean nunc eros, consequat non nibh in, bibendum convallis eros. Vestibulum elit neque, elementum at egestas a, ultricies eget nisi. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed dapibus metus nec nisi semper, eu fringilla diam aliquam. Fusce accumsan gravida justo, sit amet sollicitudin erat suscipit ac. Nulla rhoncus non elit in tempor. Vestibulum at ligula vitae diam dapibus lobortis at a nulla.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Curabitur ac cursus tortor. Donec posuere magna sit amet felis condimentum cursus et vitae dolor. Curabitur vitae mauris a leo consequat sagittis at at tortor. Fusce dui mi, pretium ut tincidunt at, vestibulum et velit. Quisque posuere eleifend velit, nec mattis leo viverra non. Curabitur placerat, neque in sodales eleifend, nisi tortor lacinia nunc, in varius neque ipsum fringilla urna. Morbi nec ipsum diam. Vestibulum tincidunt augue eleifend dictum rutrum. Etiam vel nibh scelerisque, tincidunt mauris et, lacinia orci. Sed consectetur pellentesque malesuada. Suspendisse eget lectus velit.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Donec viverra vehicula nunc, eget fringilla justo rutrum eget. Duis convallis convallis dapibus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse placerat sagittis lacus. Mauris in aliquet urna, id posuere nisl. Phasellus accumsan in metus vel ullamcorper. Praesent pulvinar iaculis mauris vitae vehicula. Nunc vehicula risus massa, a accumsan turpis ornare in. Suspendisse non mauris eu diam convallis finibus ut et ex. Fusce ut dui massa.</p>', 'welcome-to-L-Shop', '2017-09-08 16:33:50', '2017-09-08 16:33:50');

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
(14, 2, 5, 1, 64, 1, 0.00, '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(15, 20, 6, 1, 16, 1, 0.00, '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(16, 15, 7, 1, 16, 1, 0.00, '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(17, 15, 8, 1, 32, 1, 0.00, '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(18, 67, 9, 1, 1, 2, 0.00, '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(19, 54, 10, 2, 1, 3, 0.00, '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(20, 15, 11, 1, 1, 5, 0.00, '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(21, 100, 11, 1, 0, 5, 0.00, '2017-09-08 16:33:50', '2017-09-08 16:33:50');

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
(1, 'admin', 'Administrator', '{\"user.admin\":true}', '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(2, 'user', 'User', '{\"user.admin\":false}', '2017-09-08 16:33:50', '2017-09-08 16:33:50');

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
(1, 1, '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(2, 2, '2017-09-08 16:33:50', '2017-09-08 16:33:50');

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
(1, 'MMO', 1, '127.0.0.1', 25575, '123456', 0, '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(2, 'Hi-Tech (PvP)', 1, '127.0.0.1', 25564, '123456', 0, '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(3, 'Hi-Tech (PvE)', 1, NULL, NULL, NULL, 0, '2017-09-08 16:33:50', '2017-09-08 16:33:50');

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
(53, 'shop.currency', 'USD'),
(54, 'shop.currency_html', '<i class=\"fa fa-usd\"></i>'),
(55, 'shop.description', 'Modern trading system for Minecraft'),
(56, 'shop.enable_password_reset', '1'),
(57, 'shop.enable_signup', '1'),
(58, 'shop.keywords', 'L-Shop,shop,buy,store,minecraft'),
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
(1, 'admin', 'admin@example.com', '$2y$10$bNzP7NZ.eUPjxMchHgzydO8YP8OQ1rxIjnOErHf9UWkmGRUEpn0zW', NULL, NULL, 1000, 'a425ccf0-94cc-11e7-ac5e-0a0027000010', NULL, NULL, '2017-09-08 16:33:50', '2017-09-08 16:33:50'),
(2, 'user', 'user@example.com', '$2y$10$hhn43IY0132DWo90zuW1xOd6zfwsRpgmXN2pF5Pf0q/kWF1tPTOaq', NULL, NULL, 0, 'a4324dca-94cc-11e7-ac5e-0a0027000010', NULL, NULL, '2017-09-08 16:33:50', '2017-09-08 16:33:50');

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

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
(1, 1, '5KwqAT2MDllWmVSxErZ38jsKgGsrQDaR', 1, '2017-10-28 09:04:36', '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(2, 2, 'Pb2S7jeBSsirSlTtQpbBi9mtjvPmhAut', 1, '2017-10-28 09:04:36', '2017-10-28 09:04:36', '2017-10-28 09:04:36');

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
(1, 'Блоки', 1, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(2, 'Предметы', 1, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(3, 'Броня', 2, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(4, 'Предметы', 3, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(5, 'Привилегии', 1, '2017-10-28 09:04:36', '2017-10-28 09:04:36');

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
(5, 'Блок травы', '', 'item', '2', NULL, NULL, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(6, 'Динамит', '', 'item', '46', '784a013771bdf825d1cf26b49897a605.png', NULL, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(7, 'Сундук', '', 'item', '54', 'd6c6adf53d0145708ec54a41e8a4e3d8.png', NULL, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(8, 'Печь', '', 'item', '61', '4a69519aa46ee6b5b15bab8abd5139f3.png', NULL, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(9, 'Алмазный меч', '', 'item', '276', '9d8feda602d70231f0297a3b7e436d4b.png', NULL, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(10, 'Алмазный шлем', '', 'item', '310', 'd2714c56c81bcc4ff35798832226967f.png', NULL, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(11, 'VIP', '', 'permgroup', 'vip', 'f0c9755f2685d55b7540c941b6f29ff9.png', NULL, '2017-10-28 09:04:36', '2017-10-28 09:04:36');

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
(1, 'Новость 381', 'Et aut porro tempore beatae ipsum. Dolores dolores corporis alias quo. Sint ipsam voluptatem quia harum temporibus. Laudantium sit minus dolorem occaecati. Laboriosam omnis eum est in totam vel in. Nulla tempora eos dicta sed. Accusamus sed aut similique dolores. Enim in veniam excepturi qui error suscipit ut repudiandae. Non autem qui et aut maxime. Est et ipsum recusandae perferendis. Iste pariatur quo consequatur nulla magnam. Aliquam eos commodi eum et labore aut ipsa. Porro dolores sed velit et. Et voluptates itaque ipsam deserunt amet temporibus corrupti animi. Vitae qui maxime ut similique impedit dolorum rerum. Eveniet consequatur id qui quas ex repellendus. Consequatur sit pariatur illo at iure. Architecto sed nihil explicabo eos autem placeat. Quam nesciunt accusantium ullam fuga veritatis. Modi est earum consequuntur modi ducimus iure expedita. Ratione rerum molestiae deserunt omnis voluptatem.', 1, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(2, 'Новость 274', 'Et facere aut ea voluptate enim velit id. Vel omnis quae ducimus dolorem vero dignissimos. Aut fugit modi est pariatur voluptate amet enim. Omnis consectetur velit suscipit corporis. Quae rem est vel quisquam officiis dolores odit. Aut dolor voluptate sed ex repellendus saepe laboriosam. Odio possimus est omnis rem enim autem. Quia similique earum dolorem nisi ut veniam. Ut nesciunt voluptatem eius laudantium. Nihil est impedit quis. Maxime incidunt quam veritatis sit et amet possimus. Ex et facilis ea voluptates omnis pariatur laborum. Nesciunt repellendus amet rerum sed ut quis. Ut corporis quibusdam sed. Et a officia voluptatem earum sint dolorem cum non. Autem ratione quis quo quidem reprehenderit. Vel ut qui nobis nobis praesentium. Enim et molestias veritatis. Iure totam suscipit et. Qui est aliquam ut ut. Unde quo omnis perspiciatis ut sunt fugiat dolores. Cum saepe qui molestiae quia delectus. Consequatur sunt esse qui ut. Distinctio quisquam nam molestiae incidunt nulla eum.', 1, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(3, 'Новость 815', 'Ut nihil voluptatibus et quis et. Officiis quo sint accusamus ullam dolorem. Consequatur tempora nihil placeat. Facilis eos architecto dicta velit delectus repellendus. Sequi sed neque dolore quia. Veniam est eius et voluptates. Maxime doloribus est iste odio harum dolores dolorem. Unde perspiciatis est sit est minima. Sequi ut et quae cumque ratione eveniet omnis. Voluptatem consectetur rerum laboriosam dolorum. Vel ea aliquam qui. Atque aut et enim consequatur. Sit molestiae et et qui mollitia natus in. Repellat mollitia est deserunt. Omnis ullam voluptatem doloribus dicta enim sapiente et. Saepe sed nihil voluptatem sint reprehenderit. Voluptates placeat eveniet cumque repellat aut debitis est dolores. Vel quaerat quia deserunt placeat dicta rerum quaerat hic. Doloremque pariatur rerum unde enim dignissimos amet. Eius at suscipit delectus nisi atque culpa voluptas alias. Id sit eum nisi eaque quia. Reprehenderit quo ut aut. Non molestiae molestias velit sed rem autem aut.', 1, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(4, 'Новость 607', 'Atque qui voluptatibus qui sapiente necessitatibus aut est. Quaerat impedit ad similique deserunt consequatur. Cum at voluptatem a debitis. Ex explicabo repellendus assumenda modi rerum. Laboriosam voluptate laborum omnis. Molestias iure quas dolorum cum est. Enim quis porro minus eveniet assumenda delectus. Nisi consequatur qui voluptates praesentium laborum. Dignissimos dolores aut tempora voluptates. In alias vitae dolores saepe maxime sunt recusandae. Nulla deserunt ut inventore vitae adipisci aut soluta. Ducimus dolorum rem dicta quas iusto et. Enim dolor sed corporis ut. Vel sequi dolorum facilis tempore facilis et. Totam illo cupiditate quo est sit. Facilis debitis vel vitae qui fugiat ea aut. Numquam dolores molestiae ea accusantium provident. Totam quo nulla iure officiis est et corrupti. Ipsa modi sit deleniti repellendus soluta. Ut corrupti amet fuga exercitationem harum incidunt. Blanditiis sint et aut qui soluta dolores dolor.', 1, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(5, 'Новость 879', 'Molestiae nihil quibusdam non ad fugiat sed. Perferendis doloremque laborum sed molestiae voluptatem consectetur. Molestias aut sequi sit doloribus voluptatem. Doloremque maxime vitae distinctio consectetur non magnam. Officiis quasi dolorem nisi dolorem quis. Impedit itaque non magni beatae provident quisquam distinctio eaque. Porro voluptatem voluptatem ipsam harum molestiae autem. Ut temporibus necessitatibus illo vel assumenda pariatur. Illo illum non alias in sed libero sapiente. Rem aliquid porro numquam sed ratione fuga. Facere culpa et ratione aut ducimus. Adipisci quod laborum rerum. Reprehenderit ipsum ipsa ipsam voluptas. Consequatur quis consequatur quia nisi et nihil. Quae esse adipisci eos quo. Sequi dicta consequatur deserunt quaerat esse. Beatae quia velit vel sed id temporibus. Sint odio pariatur nemo dicta aut. Sit repellendus quam debitis repudiandae quo iusto id.', 1, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(6, 'Новость 338', 'Omnis et consequatur earum quis voluptatem. Temporibus alias harum ut sapiente est quidem reprehenderit. Alias fugiat dolorem aut repellat. Perferendis fugiat excepturi voluptatibus. Est nemo aut enim et est non est. Ullam quia quia architecto non facilis nesciunt alias. Aut repellat ex aliquid alias corporis. Rerum eos aspernatur quibusdam iusto earum. Quo officiis quasi aut itaque quia quibusdam nemo ducimus. Quia reprehenderit enim et ut excepturi expedita modi rerum. Architecto saepe quaerat veniam velit et. Tempora ea et unde eum nisi incidunt. Quod reprehenderit nihil et beatae ut officiis. Mollitia quidem ullam impedit eos consequatur fuga exercitationem. Neque quam illum earum explicabo magni. Ut est unde ipsam delectus ullam laudantium. Quas laborum libero mollitia qui asperiores aut. Est qui tenetur molestias consequatur voluptas. Doloribus excepturi sunt odit soluta et rerum.', 1, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(7, 'Новость 698', 'Perspiciatis reprehenderit nobis illo est vero sit. Aut natus ab sit dolore illo maxime officia. Qui impedit amet nihil sed corrupti voluptatem eaque qui. Recusandae nulla quis cupiditate ea. Voluptate omnis nihil aliquid commodi et. Ad quia atque vitae. Ducimus distinctio est voluptates aut quo. Fuga alias quia nostrum tempora fugit et pariatur. Quas ipsam dolores odio doloribus repudiandae id sapiente aliquam. Et aut qui inventore sit iste. Aut hic eum reprehenderit alias laudantium quo. Reprehenderit neque suscipit alias numquam magnam architecto provident. Rem minima hic voluptas quia. Nisi eum labore nihil non a molestias ex. Consequuntur deserunt ratione sed. Harum earum et voluptas dicta. Quia at odit est rem qui rerum. Incidunt id enim maiores alias culpa alias. Quae possimus assumenda ea ullam. Rem quis quia natus ex. Soluta tempora et consectetur commodi impedit necessitatibus autem.', 1, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(8, 'Новость 817', 'Sit est nobis maxime laboriosam incidunt ab. Aut est velit non assumenda possimus dolorem amet qui. Repudiandae vitae sapiente fugiat mollitia ad provident. Optio dolore ratione vero tempore et. Recusandae vel quod animi quae autem est. Sit dolorem non qui quia. Qui dolores impedit rerum nulla ex ex. Mollitia aliquid velit libero molestias quam iusto tempora. Et minus numquam magni autem soluta enim sequi. Soluta perspiciatis reiciendis sit inventore vel rerum magni sed. Expedita quis illum cumque odio. Fugit quae nulla facilis at libero. Nobis est maxime modi doloremque porro et laudantium omnis. Alias qui incidunt delectus quis. Nihil deleniti eum id sequi velit non. Modi dolorem et maxime et officia doloremque sit eum. Inventore ipsa optio nulla. Rerum minus eum odio quia. Vel repellat quam vel et mollitia cum. Molestiae consectetur itaque qui ut quia qui tempora.', 1, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(9, 'Новость 447', 'Voluptatem omnis qui consequatur. Dolores consequatur ea sunt delectus at dolorem ea. Deserunt reprehenderit sit fugit nisi cumque aut. Illum praesentium debitis repudiandae sit. Nihil enim qui ut est. Fugiat sit autem qui laboriosam. Officiis odio est accusamus rem doloremque. Error reiciendis ipsum voluptatem sapiente voluptas. Nesciunt saepe qui sit temporibus similique qui recusandae. Quas enim numquam iste similique iusto voluptatum voluptatum laboriosam. Omnis explicabo inventore repudiandae nemo. Tenetur eum vero repellendus dignissimos qui ut eaque facere. Soluta voluptas laboriosam mollitia autem. Ea consectetur fugit expedita. Aut iure quibusdam aliquam qui vitae rerum molestiae. Molestias numquam perferendis explicabo pariatur sunt. Qui quam incidunt unde cumque cupiditate ut est debitis. Aspernatur quasi repellendus omnis nisi et. In consequatur rerum sed pariatur. Consequatur quam voluptates dolores itaque ipsa nihil quis.', 1, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(10, 'Новость 689', 'Et reiciendis sint et aspernatur aspernatur molestiae. Molestias non sed blanditiis eum. Nobis rerum reiciendis odit veniam. Omnis et alias voluptatibus rerum officiis rerum exercitationem consequatur. Rerum eos ut temporibus necessitatibus est et eius. Repudiandae eum alias suscipit commodi quidem non illo. Inventore ea nemo qui sunt repudiandae. Sed accusamus libero accusamus non. Vel ducimus impedit soluta repellendus delectus voluptatem. At praesentium qui quia. Nulla aperiam quibusdam mollitia quia. Quis ex cum laborum voluptatem. Eos aut autem quas est ducimus id. Sint nesciunt qui nobis maiores sunt cumque. Aliquid quod tenetur commodi impedit explicabo repudiandae. Sit eos aut expedita debitis. Doloribus neque accusamus non nemo harum. Consectetur nemo aliquam aut quisquam ab ipsum. Est in nostrum libero adipisci ex qui ex. Adipisci natus vero odit laboriosam ut. Quas excepturi mollitia expedita voluptas tempore.', 1, '2017-10-28 09:04:36', '2017-10-28 09:04:36');

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
(1, 'Добро пожаловать в L-Shop!', '<h1 style=\"text-align: center;\">Современная торговая система для Minecraft</h1><br><p style=\"text-align: center; \"><img src=\"http://i90.fastpic.ru/big/2017/0309/9c/1cebb8e0e70a432b71102bf20334459c.png\" alt=\"Логотип L-Shop\"><br></p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce condimentum nibh quis lorem malesuada, lobortis accumsan felis consequat. Fusce ac tortor gravida, dignissim quam sit amet, laoreet sapien. Nam ultricies libero in dignissim accumsan. Fusce ac lacinia quam. Integer convallis neque ac tortor sollicitudin, ac mollis erat malesuada. Suspendisse sapien turpis, mollis et nibh non, mollis venenatis augue. Aenean et leo sed mi tristique fringilla.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Donec in nibh turpis. Phasellus tincidunt tristique scelerisque. Sed aliquam pretium mauris a mattis. Sed ante magna, facilisis vel lorem eget, rhoncus ullamcorper ligula. Nunc venenatis dolor nec libero interdum, non lobortis libero molestie. Vivamus aliquet lacus non eros ullamcorper, quis convallis nisl aliquet. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nunc posuere ipsum quam, in commodo dui auctor nec.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Praesent dapibus velit eu leo aliquam, accumsan interdum ex laoreet. Etiam nec vehicula odio. Sed aliquam bibendum convallis. Proin sodales id ligula et pellentesque. Ut ullamcorper magna nec convallis pulvinar. Aenean nunc eros, consequat non nibh in, bibendum convallis eros. Vestibulum elit neque, elementum at egestas a, ultricies eget nisi. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed dapibus metus nec nisi semper, eu fringilla diam aliquam. Fusce accumsan gravida justo, sit amet sollicitudin erat suscipit ac. Nulla rhoncus non elit in tempor. Vestibulum at ligula vitae diam dapibus lobortis at a nulla.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Curabitur ac cursus tortor. Donec posuere magna sit amet felis condimentum cursus et vitae dolor. Curabitur vitae mauris a leo consequat sagittis at at tortor. Fusce dui mi, pretium ut tincidunt at, vestibulum et velit. Quisque posuere eleifend velit, nec mattis leo viverra non. Curabitur placerat, neque in sodales eleifend, nisi tortor lacinia nunc, in varius neque ipsum fringilla urna. Morbi nec ipsum diam. Vestibulum tincidunt augue eleifend dictum rutrum. Etiam vel nibh scelerisque, tincidunt mauris et, lacinia orci. Sed consectetur pellentesque malesuada. Suspendisse eget lectus velit.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Donec viverra vehicula nunc, eget fringilla justo rutrum eget. Duis convallis convallis dapibus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse placerat sagittis lacus. Mauris in aliquet urna, id posuere nisl. Phasellus accumsan in metus vel ullamcorper. Praesent pulvinar iaculis mauris vitae vehicula. Nunc vehicula risus massa, a accumsan turpis ornare in. Suspendisse non mauris eu diam convallis finibus ut et ex. Fusce ut dui massa.</p>', 'welcome-to-L-Shop', '2017-10-28 09:04:36', '2017-10-28 09:04:36');

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
(1, 'Database seeder', '{\"14\":64,\"15\":32}', 42, 1, NULL, 1, '127.0.0.1', 1, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(2, 'Database seeder', '{\"14\":64,\"15\":128,\"17\":64}', 192, 1, NULL, 1, '127.0.0.1', 1, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(3, NULL, '{\"20\":365,\"21\":0}', 5575, 2, NULL, 3, '127.0.0.1', 0, '2017-10-28 09:04:36', '2017-10-28 09:04:36');

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
(14, 2.00, 5, 1, 64, 1, 0.00, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(15, 20.00, 6, 1, 16, 1, 0.00, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(16, 15.00, 7, 1, 16, 1, 0.00, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(17, 15.00, 8, 1, 32, 1, 0.00, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(18, 67.00, 9, 1, 1, 2, 0.00, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(19, 54.00, 10, 2, 1, 3, 0.00, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(20, 15.00, 11, 1, 1, 5, 0.00, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(21, 100.00, 11, 1, 0, 5, 0.00, '2017-10-28 09:04:36', '2017-10-28 09:04:36');

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
(1, 'admin', 'Администратор', '{\"user.admin\":true}', '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(2, 'user', 'Пользователь', '{\"user.admin\":false}', '2017-10-28 09:04:36', '2017-10-28 09:04:36');

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
(1, 'MMO', 1, '127.0.0.1', 25575, '123456', 0, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(2, 'Hi-Tech (PvP)', 1, '127.0.0.1', 25564, '123456', 0, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(3, 'Hi-Tech (PvE)', 1, NULL, NULL, NULL, 0, '2017-10-28 09:04:36', '2017-10-28 09:04:36');

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
(1, 'admin', 'admin@example.com', '$2y$08$HQnRemrIhDIBAB0UDs5zQeAqBOHGAaEtuawPDYeJYlta/Fc8HuQZe', NULL, NULL, 1000, '2ad6597f-bbd8-11e7-aed0-0a0027000010', NULL, NULL, '2017-10-28 09:04:36', '2017-10-28 09:04:36'),
(2, 'user', 'user@example.com', '$2y$08$uYThDBYaSI8zqVaQr8Q.Duwj5lXfZDAcyTLde7NqvABks/nPn4ylu', NULL, NULL, 0, '2ada7af3-bbd8-11e7-aed0-0a0027000010', NULL, NULL, '2017-10-28 09:04:36', '2017-10-28 09:04:36');

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

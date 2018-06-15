-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Час створення: Чрв 15 2018 р., 15:50
-- Версія сервера: 5.7.20
-- Версія PHP: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `poststream`
--
CREATE DATABASE IF NOT EXISTS `poststream` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `poststream`;

-- --------------------------------------------------------

--
-- Структура таблиці `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `undercat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `postcategory`
--

CREATE TABLE `postcategory` (
  `postid` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `posts`
--

CREATE TABLE `posts` (
  `id` int(24) NOT NULL,
  `post_date` datetime NOT NULL,
  `title` longtext NOT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` int(64) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `posts`
--

INSERT INTO `posts` (`id`, `post_date`, `title`, `text`, `author`) VALUES
(1, '2018-06-04 12:07:58', 'Where were you last night?', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nОТ ФІГНЯ!!!!!!!!!!', 2),
(2, '2018-06-04 12:15:06', 'Біда сталася (Оновлено)', 'Взяв та оновив!!!\r\nРахуй все в базі переписав нахрін.\r\nТак же не можна!!!', 1),
(3, '2018-06-04 14:13:33', 'Не робіть так люди, бо лихо Вам буде:', 'Крім мабуть авторів, бо вони не апдейтились...', 2),
(4, '2018-06-04 13:25:11', 'Шматок коду:', 'elseif (isset($_POST[\'post-title\'])&&isset($_POST[\'post-text\'])&&$_POST[\'addOrEdit-flag\']=\'1\')\r\n{\r\n	try\r\n	{\r\n		$sql = \'UPDATE wp_posts SET \r\n		post_date = NOW(), \r\n		post_title = :post_title,\r\n		post_text = :post_text WHERE id=:post_id\';\r\n		$requestObj = $pdo -> prepare($sql);\r\n		$requestObj -> bindValue(\':post_id\', $_POST[\'post-id\']);\r\n		$requestObj -> bindValue(\':post_title\', $_POST[\'post-title\']);\r\n		$requestObj -> bindValue(\':post_text\', $_POST[\'post-text\']);\r\n		$requestObj -> execute();\r\n	}\r\n	catch (PDOException $e)\r\n	{\r\n		$error = \'Помилка при оновленні поста: \'. $e->getMessage();\r\n		include $_SERVER[\'DOCUMENT_ROOT\'].\'/error.php\';\r\n		exit;		\r\n	}', 1),
(40, '2018-06-04 12:03:47', 'Where were you last night? (Оновлено)', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\n\r\nВзяв та оновив!!!', 2),
(42, '2018-06-04 12:03:47', 'Where were you last night? (Оновлено)', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\n\r\nВзяв та оновив!!!', 1),
(44, '2018-06-12 11:02:01', 'ще один тестовий пост', 'Тестування це гемор коли все працює аби як.', 1),
(49, '2018-06-12 11:12:38', 'от жопа', 'Що це за автор?1111щшщ', 1),
(55, '2018-06-12 11:36:18', '- Виправлено ', 'Відображення автора поста', 2),
(60, '2018-06-12 12:24:39', '- Виправлено', 'Помилку: Cannot modify header information - headers already sent by', 2),
(63, '2018-06-15 15:49:12', '-Додано', '- В адмінці можливість: додавати, редагувати, видаляти, змінювати пароль користувачів\r\n- Модальні вікна\r\n- Крихітні правки ', 2);

-- --------------------------------------------------------

--
-- Структура таблиці `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `roles`
--

INSERT INTO `roles` (`id`, `description`) VALUES
(1, 'Адмін'),
(2, 'Модер'),
(3, 'Дописувач');

-- --------------------------------------------------------

--
-- Структура таблиці `userrole`
--

CREATE TABLE `userrole` (
  `userid` int(11) NOT NULL,
  `roleid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `avatar` mediumblob NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `login` varchar(255) NOT NULL,
  `password` char(32) DEFAULT NULL,
  `role` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `users`
--

INSERT INTO `users` (`id`, `avatar`, `name`, `email`, `login`, `password`, `role`) VALUES
(1, '', 'Mr. T', 'tguy@wert.com', 'mr', '7363a0d0604902af7b70b271a0b96480', 0),
(2, '', 'Zenko', 'zenko@ex.ua', 'zenko', '2c216b1ba5e33a27eb6d3df7de7f8c36', 1);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `postcategory`
--
ALTER TABLE `postcategory`
  ADD PRIMARY KEY (`postid`,`categoryid`);

--
-- Індекси таблиці `posts`
--
ALTER TABLE `posts`
  ADD UNIQUE KEY `qaz` (`id`);

--
-- Індекси таблиці `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `userrole`
--
ALTER TABLE `userrole`
  ADD PRIMARY KEY (`userid`,`roleid`);

--
-- Індекси таблиці `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT для таблиці `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблиці `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Час створення: Трв 16 2018 р., 13:30
-- Версія сервера: 5.5.58
-- Версія PHP: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `wp_mysite.ua`
--

-- --------------------------------------------------------

--
-- Структура таблиці `wp_category`
--

CREATE TABLE `wp_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `undercat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `wp_postcategory`
--

CREATE TABLE `wp_postcategory` (
  `postid` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `wp_posts`
--

CREATE TABLE `wp_posts` (
  `ID` int(24) NOT NULL,
  `post_date` datetime NOT NULL,
  `post_title` text NOT NULL,
  `post_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `authorid` int(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `wp_posts`
--

INSERT INTO `wp_posts` (`ID`, `post_date`, `post_title`, `post_text`, `authorid`) VALUES
(1, '2018-04-23 00:00:00', 'This is my title', 'This is my text', 2),
(2, '2018-04-23 00:00:00', 'This is my title', 'This is my text', 1),
(3, '2018-04-23 00:00:00', 'gfg', 'der345fdfff', 2),
(4, '2018-04-23 00:00:00', 'Success', 'rere354', 1),
(40, '2018-05-02 00:00:00', 'Where were you last night?', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2),
(41, '2018-05-03 00:00:00', 'В\'ялена риба', 'Хто не знає історію про в\'ялену рибу, що її забув один продавець забрати з прилавку додому.', NULL),
(42, '2018-05-03 00:00:00', 'Story about D. O`Relly', 'The company began in 1978 as a private consulting firm doing technical writing, based in the Cambridge, Massachusetts area. In 1984, it began to retain publishing rights on manuals created for Unix vendors. A few 70-page \"Nutshell Handbooks\" were well-received, but the focus remained on the consulting business until 1988. After a conference displaying O\'Reilly\'s preliminary Xlib manuals attracted significant attention, the company began increasing production of manuals and books. The original cover art consisted of animal designs developed by Edie Freedman because she thought that Unix program names sounded like \"weird animals\".', NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `wp_role`
--

CREATE TABLE `wp_role` (
  `id` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `wp_user`
--

CREATE TABLE `wp_user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` char(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `wp_user`
--

INSERT INTO `wp_user` (`id`, `name`, `email`, `password`) VALUES
(1, 'Mr. T', 'tguy@wert.com', NULL),
(2, 'Zenko', 'zenko@ex.ua', NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `wp_userrole`
--

CREATE TABLE `wp_userrole` (
  `userid` int(11) NOT NULL,
  `roleid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `wp_category`
--
ALTER TABLE `wp_category`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `wp_postcategory`
--
ALTER TABLE `wp_postcategory`
  ADD PRIMARY KEY (`postid`,`categoryid`);

--
-- Індекси таблиці `wp_posts`
--
ALTER TABLE `wp_posts`
  ADD UNIQUE KEY `qaz` (`ID`);

--
-- Індекси таблиці `wp_role`
--
ALTER TABLE `wp_role`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `wp_user`
--
ALTER TABLE `wp_user`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `wp_userrole`
--
ALTER TABLE `wp_userrole`
  ADD PRIMARY KEY (`userid`,`roleid`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `wp_category`
--
ALTER TABLE `wp_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `wp_posts`
--
ALTER TABLE `wp_posts`
  MODIFY `ID` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT для таблиці `wp_user`
--
ALTER TABLE `wp_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

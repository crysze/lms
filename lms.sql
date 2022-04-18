-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 18. Apr 2022 um 20:24
-- Server-Version: 10.4.20-MariaDB
-- PHP-Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `lms`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `answer`
--

CREATE TABLE `answer` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `choice` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `correct` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `answer`
--

INSERT INTO `answer` (`id`, `question_id`, `choice`, `text`, `correct`) VALUES
(1, 1, 'a', 'virus[0] = \"Covid-19\";', 0),
(2, 1, 'b', '$virus[] = array(\"Covid-19\");', 0),
(3, 1, 'c', '$virus[0] = \"Covid-19\";', 1),
(4, 1, 'd', '$virus = array(Covid-19);', 0),
(5, 2, 'a', 'class NewClass { }', 1),
(6, 2, 'b', 'new class NewClass { }', 0),
(7, 2, 'c', 'new static class NewClass { }', 0),
(8, 3, 'a', 'A language for querying databases', 0),
(9, 3, 'b', 'An open source database product', 1),
(10, 4, 'a', 'The value \"Hello\" is assigned to the constant \"hi\"', 1),
(11, 4, 'b', 'The value \"Hello\" is assigned to the local variable \"hi\"', 0),
(12, 5, 'a', 'Methods tend to take more arguments', 0),
(13, 5, 'b', 'Methods tend to take less arguments', 1),
(14, 5, 'c', 'There are no differences in terms of arguments', 0),
(15, 6, 'a', 'Client', 0),
(16, 6, 'b', 'On its own', 0),
(17, 6, 'c', 'Server', 1),
(18, 7, 'a', '10 seconds', 1),
(19, 7, 'b', '2 seconds', 0),
(20, 7, 'c', '5 seconds', 0),
(21, 8, 'a', 'A group of running threads that are already busy with various tasks', 0),
(22, 8, 'b', 'A group of running threads that are available for incoming tasks', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `category`
--

INSERT INTO `category` (`category_id`, `category_title`) VALUES
(1, 'PHP / MySQL'),
(2, 'JavaScript');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `completion`
--

CREATE TABLE `completion` (
  `completion_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` int(11) NOT NULL,
  `img` int(11) NOT NULL,
  `description` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `course`
--

INSERT INTO `course` (`id`, `title`, `category`, `img`, `description`) VALUES
(1, 'PHP Fundamentals', 1, 4, 'In this course, you will learn the basics of PHP - the fundamental syntax, variables, functions and arrays. Instructional videos will be followed by a quiz testing the knowledge you\'ve acquired.'),
(2, 'PHP OOP', 1, 4, 'This course will teach you the basics of object-oriented programming. You will learn what classes, properties and methods are and how to make use of them.'),
(3, 'MySQL Fundamentals', 1, 2, 'Learn to install and configure the MySQL server and clients, use Structured Query Language (SQL) to build up a database and as well as query the data, and much more.'),
(4, 'JS Fundamentals', 2, 1, 'Here, you will be hearing about the basic data structures in JavaScript like variables, constants and their scope, arrays as well as objects. Functions and different loops will also be covered. '),
(5, 'JS OOP', 2, 1, 'This course teaches you how JavaScript can make use of object-oriented programming. As opposed to other programming languages, JavaScript is not a class-based, but a prototype-based language.'),
(6, 'Node JS', 2, 3, 'Learn about the runtime environment that makes it possible to execute JavaScript outside a web browser, on the backend. Node JS has become increasingly popular since its initial release in 2009.'),
(7, 'MySQL Advanced', 1, 2, 'Here, you will find out what the slow query log is and how you can make use of it in order to optimize queries. This is an advanced MySQL topic.'),
(8, 'Node JS Advanced', 2, 3, 'As part of this course focused on advanced Node JS concepts, you will learn about the basics of threads and the Node event loop. Additionally, the thread pool / multithreading is covered.');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `enrolment`
--

CREATE TABLE `enrolment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `progress` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `image`
--

CREATE TABLE `image` (
  `img_id` int(11) NOT NULL,
  `path` varchar(260) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `image`
--

INSERT INTO `image` (`img_id`, `path`) VALUES
(1, 'img/js.png'),
(2, 'img/mysql.svg'),
(3, 'img/node_js.png'),
(4, 'img/php.png');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `text` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `question`
--

INSERT INTO `question` (`id`, `course_id`, `text`) VALUES
(1, 1, 'Which of the following examples will correctly create an array?'),
(2, 2, 'Which is the correct syntax to create a new class in PHP?'),
(3, 3, 'What is MySQL?'),
(4, 4, 'What does the statement const hi = \'Hello\'; do?'),
(5, 5, 'What is an advantage of OOP over functional programming in terms of function / method parameters?'),
(6, 6, 'Where does Node JS run?'),
(7, 7, 'By default, how long does a query have to take for it to be stored in the slow query log?'),
(8, 8, 'What is a thread pool in Node JS?');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tag`
--

CREATE TABLE `tag` (
  `tag_id` int(11) NOT NULL,
  `tag_title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `tag`
--

INSERT INTO `tag` (`tag_id`, `tag_title`) VALUES
(7, 'Advanced'),
(10, 'Basics'),
(9, 'Databases'),
(6, 'Fundamentals'),
(1, 'JavaScript'),
(3, 'MySQL'),
(4, 'NodeJS'),
(5, 'Object-oriented Programming'),
(2, 'PHP');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tagging`
--

CREATE TABLE `tagging` (
  `tagging_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `tagging`
--

INSERT INTO `tagging` (`tagging_id`, `tag_id`, `course_id`) VALUES
(1, 1, 4),
(2, 1, 5),
(3, 1, 8),
(4, 1, 6),
(5, 2, 1),
(6, 2, 2),
(7, 3, 3),
(8, 3, 7),
(9, 4, 6),
(10, 4, 8),
(11, 5, 2),
(12, 5, 5),
(13, 6, 1),
(14, 6, 3),
(15, 6, 6),
(16, 6, 4),
(17, 7, 7),
(18, 7, 8),
(19, 10, 4),
(20, 10, 1),
(21, 10, 3),
(22, 10, 6);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `userid` int(11) NOT NULL,
  `firstname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `activation_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `activated_at` datetime DEFAULT NULL,
  `activation_expiry` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`userid`, `firstname`, `lastname`, `email`, `password`, `active`, `activation_code`, `activated_at`, `activation_expiry`) VALUES
(94, 'Christina', 'Stoll', 'christina.stoll@gmx.at', '$2y$10$PVd09cnGtOpjF9023RdpDOpTT8lrxtUBmzjYgftDjUe2bEu5YmY8e', 0, '$2y$10$hqMEtYQwSIy5pECG0jCZA.nUmgp./Gv1vtndaGsxdqXkv/s8zbEfC', NULL, '2022-04-18 18:40:29');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `video`
--

CREATE TABLE `video` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `hierarchy` int(11) NOT NULL,
  `title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `yt_id` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `video`
--

INSERT INTO `video` (`id`, `course_id`, `hierarchy`, `title`, `yt_id`) VALUES
(1, 1, 1, 'Variables', 'esCHWLYIusU'),
(2, 1, 2, 'Arrays', 'wLoPGWwMamc'),
(3, 2, 1, 'Introduction', 'Anz0ArcQ5kI'),
(4, 2, 2, 'The MVC Model', '3OKOe7CraGY'),
(5, 2, 3, 'Creating Classes', 'iEGUOE9RKqM'),
(6, 3, 1, 'The Basics', '2bW3HuaAUcY'),
(7, 4, 1, 'Variables & Data Types', 'edlFjlzxkSI'),
(8, 4, 2, 'Functions & Parameters', 'xjAu2Y2nJ34'),
(9, 5, 1, 'Object-oriented Programming', 'pTB0EiLXUC8'),
(10, 5, 2, 'Classes', 'Ug4ChzopcE4'),
(11, 6, 1, 'Beginner\'s Guide', 'ENrzD9HAZK4'),
(12, 7, 1, 'Slow Query Logging', 'noFn2sgQiNw'),
(13, 8, 1, 'Basics of Threads', 'S2bORfg5pX8'),
(14, 8, 2, 'Node Event Loop', 'DCTi1_nn4hU'),
(15, 8, 3, 'Thread Pool', 'kxBUtoflABc');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indizes für die Tabelle `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indizes für die Tabelle `completion`
--
ALTER TABLE `completion`
  ADD PRIMARY KEY (`completion_id`),
  ADD KEY `course_id_c` (`course_id`),
  ADD KEY `user_id_c` (`user_id`);

--
-- Indizes für die Tabelle `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category`),
  ADD KEY `img` (`img`);

--
-- Indizes für die Tabelle `enrolment`
--
ALTER TABLE `enrolment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indizes für die Tabelle `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`img_id`);

--
-- Indizes für die Tabelle `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id_q` (`course_id`);

--
-- Indizes für die Tabelle `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`tag_id`),
  ADD KEY `tag_title` (`tag_title`);

--
-- Indizes für die Tabelle `tagging`
--
ALTER TABLE `tagging`
  ADD PRIMARY KEY (`tagging_id`),
  ADD KEY `course_id_tagging` (`course_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indizes für die Tabelle `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id_v` (`course_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `answer`
--
ALTER TABLE `answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT für Tabelle `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `completion`
--
ALTER TABLE `completion`
  MODIFY `completion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT für Tabelle `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `enrolment`
--
ALTER TABLE `enrolment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT für Tabelle `image`
--
ALTER TABLE `image`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `tag`
--
ALTER TABLE `tag`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `tagging`
--
ALTER TABLE `tagging`
  MODIFY `tagging_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT für Tabelle `video`
--
ALTER TABLE `video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `question_id` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `completion`
--
ALTER TABLE `completion`
  ADD CONSTRAINT `course_id_c` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_id_c` FOREIGN KEY (`user_id`) REFERENCES `user` (`userid`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `category` FOREIGN KEY (`category`) REFERENCES `category` (`category_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `img` FOREIGN KEY (`img`) REFERENCES `image` (`img_id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `enrolment`
--
ALTER TABLE `enrolment`
  ADD CONSTRAINT `course_id` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`userid`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `course_id_q` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `tagging`
--
ALTER TABLE `tagging`
  ADD CONSTRAINT `course_id_tagging` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tag_id` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`tag_id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `course_id_v` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 07. Dez 2021 um 21:16
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
CREATE DATABASE IF NOT EXISTS `lms` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `lms`;

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

--
-- Daten für Tabelle `completion`
--

INSERT INTO `completion` (`completion_id`, `course_id`, `user_id`, `item_id`) VALUES
(45, 1, 29, 1),
(46, 1, 29, 2),
(47, 3, 29, 1),
(48, 8, 29, 3),
(49, 5, 29, 1),
(52, 1, 29, 3),
(53, 5, 29, 2),
(54, 5, 29, 3),
(55, 6, 29, 2),
(56, 8, 29, 4),
(57, 2, 29, 4),
(58, 4, 29, 1),
(59, 4, 29, 2),
(60, 4, 29, 3),
(61, 6, 29, 1);

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

--
-- Daten für Tabelle `enrolment`
--

INSERT INTO `enrolment` (`id`, `user_id`, `course_id`, `date`, `progress`) VALUES
(17, 29, 6, '2021-10-02', '100.00'),
(18, 29, 3, '2021-10-02', '50.00'),
(19, 29, 5, '2021-10-02', '100.00'),
(22, 29, 1, '2021-10-17', '100.00'),
(23, 29, 2, '2021-10-17', '25.00'),
(24, 29, 4, '2021-10-31', '100.00'),
(25, 29, 7, '2021-11-09', '0.00'),
(26, 29, 8, '2021-11-09', '50.00'),
(27, 55, 3, '2021-12-04', '0.00');

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
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `userid` int(11) NOT NULL,
  `firstname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`userid`, `firstname`, `lastname`, `email`, `password`) VALUES
(28, 'Christina', 'Stoll', 'chr@sto.at', '$2y$10$DPZDnb.hVyeFhy6L120.DuoreFdvSvoGsxF/8oTRky.wdtxR4waq6'),
(29, 'Christina', 'Stoll', 'christina.stoll@gmx.at', '$2y$10$cJ1154bdN4NzprTdq5LAiucFZiuz37RQX4doGCeRQx19Ek.IvS9Bu'),
(30, 'Christina', 'Stoll', 'christina@gmx.at', '$2y$10$.rEtTxI98sKCnfsftEOe.u8CkgSTExRDTbNm1iEzQtHGz.NZmvybi'),
(31, 'Christina', 'Stoll', 'quaist@gmx.net', '$2y$10$iO1UrBQNCdxzyFa0/NGtp.9nnz9PtjcvKpLsOBAmP0r5JCVL27kai'),
(32, 'Christina', 'Stoll', 'def@abc.de', '$2y$10$JIl2OJ7MLI0tzXu7AN4mhOo.vq8e5YvlXFop/GENUJcEbazSCKQM6'),
(33, 'Christina', 'Stoll', 'abc@de.com', '$2y$10$AIWc7Kq08JERYIfNFWyfNuEkHFkH2jGR1r6t4hRUnxLMKPY8s7U3u'),
(34, 'Christina', 'Stoll', 'asdfadf@wer.de', '$2y$10$j0GHeMEklEb2JMZjalFJ1e8Dh2mAxkY3Cpf4jRHJ6WkV.B1HjIz1.'),
(35, 'Christina', 'Stoll', 'quaist@gmx.com', '$2y$10$vtLLphIO2VZIZY5hCglBdez0lx4uAHcCGuqPby1J.EAqWt1Ygf3J6'),
(36, 'Christina', 'Stoll', 'quaist@gmx.at', '$2y$10$FZKzoFwSF6KEKRZ5URCvFeTrR5UvuH638tPib3t5zlHdg3LWUx5ru'),
(37, 'Christina', 'Stoll', 'quaist@gmx.co.uk', '$2y$10$3XZZLbSSdSedNqQbXYi0keTZvBHyS/lAMhTADkcA/7XaGImAviYny'),
(38, 'Christina', 'Stoll', 'cus@klsajfl.at', '$2y$10$Bgb/IUada0WoQydHb7yi1eHcMIDw9EmcWQWO0msgpFT13ZCOVVhFO'),
(39, 'Christina', 'Stoll', 'quaist@gmx.org', '$2y$10$AKwcK4ncpyU0HX.oGOCL/.Glwgafh8dEQcOJ0hGgRXwfpKxaPxvfC'),
(40, 'Christina', 'Stoll', 'quaist@gmx.ca', '$2y$10$5KcOEiGdvt4h7p/rkpgDb.cLPd4P/8tvgBvfB4FpUMiQ406oFwzti'),
(41, 'Christina', 'Stoll', 'ch@wlejw.at', '$2y$10$8IMZdNc20JOi/.N7kbSi5uYoaOwMQ2IbQ26fDCl2vGGJ8o/.1OZ0i'),
(42, 'Maximilian', 'Mustermann', 'm.mustermann@gmx.at', '$2y$10$/bRzabwkayUThXVq7a5qmei8FKRMza4F.Y77eAHglyN9QGPLpDcSe'),
(44, 'Test', 'Test', 'test@test3.de', '$2y$10$1OZWtd0.ZfRwZ/2fVU7V1ugPgdZwOdkCobFKMQo6bLqNKxPibOfKO'),
(45, 'Test', 'Test', 'test@test4.de', '$2y$10$oGYXZpbFdWoi4LWX2ytrNeWhD0i/FUxSqS/GfWgQKoo6BnTk7Fe1O'),
(46, 'Test', 'Test', 'test@test5.de', '$2y$10$OtOHPTJhMxFHKq4RtpizbebTZxZuRjJ4auj3bqmApiLVg1PH1db5a'),
(47, 'Test', 'Test', 'test@test6.de', '$2y$10$Fdl6VsHlJJJuZsSoTVB5Q.R2QxqHpShb02Mi519/Hw0OUnSJZ0k6i'),
(48, 'abc', 'def', 'at@cd.at', '$2y$10$QEyWeXr2Yv5WfVzm1AMOz.m9FgdMyJsye8ZpsvzSJCXQltzbHkZoC'),
(49, 'abc', 'def', 'a@b.c', '$2y$10$vS90lmYT.vdNE4EKL.rtdON7BvQjOBzYe/fXdLWH/62LqqTEHV1Fu'),
(50, 'abc', 'def', 'b@c.d', '$2y$10$vWpa9xWBrv4hpuUniFo9U.Oo2W1.OyNxZAymJ2FqmYykcUEbNSUvm'),
(51, 'abc', 'def', 'c@d.e', '$2y$10$mvBqxFXAeIyXCCkte8B0t.O8v0QSZgE4LWV6apSVB85ELLUOu4eBq'),
(52, 'John', 'Doe', 'j@doe.com', '$2y$10$mmYYouWdbfY9xjpHi3N8PONHTNcajf50lHl.oFp4sL1M0xiY6p7YS'),
(53, 'Charles', 'Test', 'c@test.com', '$2y$10$dpl7lMowuVr4OPh4yfq8RuMSkBg4.v2pGIZDa7HK9uR.0TvzgYkKm'),
(54, 'Christina', 'Stoll', 'ch@st.at', '$2y$10$fj8suK3k5Lrdd3T2dyzK1eLLPMGAfunYIaMjKv82GhvnLXSdS7nI2'),
(55, 'abc', 'def', 'abc@def.at', '$2y$10$ZiBW/vhLKW8oAQ6LXXiHpOfPiTlfKZrXSUVcY2ArH5K7K.SBRR4rS');

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
  MODIFY `completion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT für Tabelle `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `enrolment`
--
ALTER TABLE `enrolment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

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
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

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
-- Constraints der Tabelle `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `course_id_v` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 29 2024 г., 15:49
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `lb-1`
--

-- --------------------------------------------------------

--
-- Структура таблицы `direction`
--

CREATE TABLE `direction` (
  `id_direction` int(11) UNSIGNED NOT NULL,
  `name_direction` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `direction`
--

INSERT INTO `direction` (`id_direction`, `name_direction`) VALUES
(15, 'Магистратура'),
(33, 'Бакалавриат');

-- --------------------------------------------------------

--
-- Структура таблицы `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `img_student` varchar(200) NOT NULL,
  `name_student` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `course_direction` int(11) UNSIGNED DEFAULT NULL,
  `name_group` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `year` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `students`
--

INSERT INTO `students` (`id`, `img_student`, `name_student`, `course_direction`, `name_group`, `year`) VALUES
(52, '', 'Мухин Виталий Андреевич', 15, 'PIB', 2006),
(65, '', 'Антонов Антон Антонович', 33, 'PIB', 2002);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `direction`
--
ALTER TABLE `direction`
  ADD PRIMARY KEY (`id_direction`);

--
-- Индексы таблицы `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_direction` (`course_direction`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `direction`
--
ALTER TABLE `direction`
  MODIFY `id_direction` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT для таблицы `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`course_direction`) REFERENCES `direction` (`id_direction`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

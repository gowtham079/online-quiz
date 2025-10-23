-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2025 at 10:10 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `attempts`
--

CREATE TABLE `attempts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `total_questions` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attempts`
--

INSERT INTO `attempts` (`id`, `user_id`, `score`, `total_questions`, `created_at`) VALUES
(5, 3, 4, 40, '2025-09-14 16:32:34');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question` text DEFAULT NULL,
  `option_a` text DEFAULT NULL,
  `option_b` text DEFAULT NULL,
  `option_c` text DEFAULT NULL,
  `option_d` text DEFAULT NULL,
  `correct_answer` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_answer`) VALUES
(1, 'Who is known as the \"God of Football\"?', 'Lionel Messi', 'Cristiano Ronaldo', 'Diego Maradona', 'Pelé', 'D'),
(2, 'What is the capital of Japan?', 'Seoul', 'Beijing', 'Tokyo', 'Bangkok', 'C'),
(3, 'Which planet is known as the \"Red Planet\"?', 'Earth', 'Mars', 'Venus', 'Jupiter', 'B'),
(4, 'Who invented the telephone?', 'Nikola Tesla', 'Alexander Graham Bell', 'Albert Einstein', 'Thomas Edison', 'B'),
(5, 'Which team won the FIFA World Cup 2022?', 'Argentina', 'France', 'Brazil', 'Germany', 'A'),
(6, 'Which is the largest ocean on Earth?', 'Atlantic Ocean', 'Indian Ocean', 'Pacific Ocean', 'Arctic Ocean', 'C'),
(7, 'What does HTTP stand for?', 'Hyper Text Transfer Protocol', 'High Transfer Text Program', 'Hyper Tool Text Protocol', 'Hyperlink Transfer Protocol', 'A'),
(8, 'In which year did India get independence?', '1942', '1947', '1950', '1962', 'B'),
(9, 'Which gas do humans exhale during respiration?', 'Oxygen', 'Nitrogen', 'Carbon Dioxide', 'Hydrogen', 'C'),
(10, 'Who is the current CEO of Tesla?', 'Jeff Bezos', 'Tim Cook', 'Elon Musk', 'Sundar Pichai', 'C'),
(11, 'What is the national animal of India?', 'Elephant', 'Lion', 'Tiger', 'Peacock', 'C'),
(12, 'Which programming language is known as the \"mother of all languages\"?', 'C', 'Java', 'Python', 'Assembly', 'A'),
(13, 'Who painted the Mona Lisa?', 'Vincent Van Gogh', 'Pablo Picasso', 'Leonardo da Vinci', 'Michelangelo', 'C'),
(14, 'What is the boiling point of water?', '90°C', '95°C', '100°C', '110°C', 'C'),
(15, 'What does SQL stand for?', 'Structured Query Language', 'Simple Query List', 'System Question Language', 'Sequential Query Logic', 'A'),
(16, 'Which country is called the \"Land of the Rising Sun\"?', 'China', 'Japan', 'Thailand', 'Korea', 'B'),
(17, 'Who is known as the \"Father of Computers\"?', 'Charles Babbage', 'Alan Turing', 'Bill Gates', 'Steve Jobs', 'A'),
(18, 'Which is the smallest prime number?', '1', '2', '3', '5', 'B'),
(19, 'How many continents are there on Earth?', '5', '6', '7', '8', 'C'),
(20, 'What is the chemical symbol for gold?', 'Ag', 'Au', 'Gd', 'Go', 'B'),
(21, 'Who is known as the \"God of Football\"?', 'Lionel Messi', 'Cristiano Ronaldo', 'Diego Maradona', 'Pelé', 'D'),
(22, 'Which of the following is NOT an OOP concept in Java?', 'Encapsulation', 'Inheritance', 'Polymorphism', 'Compilation', 'D'),
(23, 'Which database is known for using the NoSQL model?', 'MySQL', 'MongoDB', 'Oracle', 'PostgreSQL', 'B'),
(24, 'Which of the following algorithms is used in Data Mining for clustering?', 'K-Means', 'Dijkstra', 'Merge Sort', 'Quick Sort', 'A'),
(25, 'Which protocol is used to send emails?', 'HTTP', 'SMTP', 'IMAP', 'FTP', 'B'),
(26, 'What does ACID stand for in database systems?', 'Atomicity, Consistency, Isolation, Durability', 'Access, Control, Integrity, Data', 'Algorithm, Code, Index, Database', 'Atomic, Consistent, Indexed, Dependent', 'A'),
(27, 'Which of these is NOT an Agile methodology?', 'Scrum', 'Kanban', 'Waterfall', 'Extreme Programming', 'C'),
(28, 'Which of the following Python libraries is best suited for Data Visualization?', 'NumPy', 'Matplotlib', 'Pandas', 'TensorFlow', 'B'),
(29, 'Which Indian player has scored the most international centuries in cricket?', 'Virat Kohli', 'Sachin Tendulkar', 'Rohit Sharma', 'MS Dhoni', 'B'),
(30, 'Which sorting algorithm has the best average-case time complexity?', 'Bubble Sort', 'Quick Sort', 'Merge Sort', 'Selection Sort', 'C'),
(31, 'Which layer of the OSI model handles data encryption?', 'Application Layer', 'Presentation Layer', 'Session Layer', 'Transport Layer', 'B'),
(32, 'Which of the following is NOT a type of JOIN in SQL?', 'INNER JOIN', 'LEFT JOIN', 'CROSS JOIN', 'TOP JOIN', 'D'),
(33, 'Which Indian state is called the \"Spice Garden of India\"?', 'Kerala', 'Tamil Nadu', 'Goa', 'Andhra Pradesh', 'A'),
(34, 'Which of these companies developed the ReactJS framework?', 'Google', 'Facebook', 'Microsoft', 'Amazon', 'B'),
(35, 'Which is the first Indian movie to win an Oscar for Best Original Song?', 'Lagaan', 'Slumdog Millionaire', 'RRR', 'Gully Boy', 'C'),
(36, 'In Machine Learning, which algorithm is mainly used for classification tasks?', 'KNN', 'Dijkstra', 'Prim’s Algorithm', 'Bellman-Ford', 'A'),
(37, 'Which of these is an example of cloud computing?', 'Google Drive', 'MS Paint', 'Notepad', 'VLC Media Player', 'A'),
(38, 'Which Indian city is known as the “Silicon Valley of India”?', 'Chennai', 'Hyderabad', 'Bengaluru', 'Pune', 'C'),
(39, 'What is the default port number for HTTPS?', '80', '21', '8080', '443', 'D'),
(40, 'Which of the following sorting algorithms is NOT stable?', 'Merge Sort', 'Bubble Sort', 'Insertion Sort', 'Quick Sort', 'D');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'Gowtham s', 'gowthamgg4248@gmail.com', '$2y$10$hfcDvsdpgV4rl2EmNeEhNe8biJ9g4tFhTLsGs5aIquiIy4n4sQATG'),
(3, 'Hemanth s', 'hemanth.s9269@gmail.com', '$2y$10$XaSgRaPCwLLanOF05r1RgeNCgxYFMzhWv/lXx9/gCI3JKAWmLObRK');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attempts`
--
ALTER TABLE `attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attempts`
--
ALTER TABLE `attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

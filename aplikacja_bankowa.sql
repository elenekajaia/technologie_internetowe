-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 17 Cze 2023, 22:33
-- Wersja serwera: 10.4.27-MariaDB
-- Wersja PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `aplikacja_bankowa`
--

-- --------------------------------------------------------

--
-- To Struktura tabeli dla tabeli `accounts`
--

CREATE TABLE `accounts` (
  `account_number` varchar(20) NOT NULL,
  `account_type` varchar(20) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `accounts`
--

INSERT INTO `accounts` (`account_number`, `account_type`, `balance`, `user_id`) VALUES
(' PL77783862819843776', 'biznesowe', '1298.00', 10),
('PL098814482734500383', 'osobiste', '3.00', 1),
('PL112628323442716937', 'biznesowe', '64985.00', 6),
('PL134683977576435545', 'biznesowe', '100000.00', 5),
('PL174269261527568031', 'osobiste', '58000.00', 7),
('PL206783744090241427', 'osobiste', '9430.00', 8),
('PL311346208914409825', 'osobiste', '45.00', 12),
('PL688337581709414354', 'osobiste', '6724.00', 11),
('PL792126029843474692', 'osobiste', '100.00', 9),
('PL898046107046583338', 'osobiste', '80.00', 22);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `pass` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `admins`
--

INSERT INTO `admins` (`id`, `name`, `pass`) VALUES
(1, 'Julka', 'zaq1@WSX'),
(2, 'Elena', '123456'),
(3, 'bezpieczenstwo_systemow_admin', 'zaq1@WSX');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `transaction_type_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `transaction_date` datetime DEFAULT NULL,
  `sender_account_number` varchar(20) DEFAULT NULL,
  `receiver_account_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `transactiontypes`
--

CREATE TABLE `transactiontypes` (
  `transaction_type_id` int(11) NOT NULL,
  `description` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `transactiontypes`
--

INSERT INTO `transactiontypes` (`transaction_type_id`, `description`) VALUES
(1, 'przelew'),
(2, 'wyplata'),
(3, 'wplata');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `transfers`
--

CREATE TABLE `transfers` (
  `transfer_id` int(11) NOT NULL,
  `sender_account_number` varchar(20) DEFAULT NULL,
  `receiver_account_number` varchar(20) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `transfer_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `role` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`user_id`, `name`, `phone`, `email`, `password`, `last_login`, `role`) VALUES
(1, 'Julia Kapica', 788378210, 'julietta.950@gmail.com', '$2y$10$jP7K8av0s5PmGoOhS5u.7ufP/PNWyr1Ej5iIvhSiGgD.zY2wuVHRS', NULL, 'client'),
(5, 'Anna Kowalska', 768214630, 'annakowalska@gmail.com', '$2y$10$NcrYpyLU4WLkAaPlw4VDTOzedJCx6A3areEtBF9YcLjc/UU9k8yjq', NULL, 'client'),
(6, 'Mateusz Szary', 504634210, 'szary.m@gmail.com', '$2y$10$V5PRekefAXUuukbx9sIDE.KWqYbI418u1MZs1fuNFty8chAEVgKG2', NULL, 'client'),
(7, 'Agnieszka Bąk', 621456789, 'agabak@wp.pl', '$2y$10$dWhXvisSKYwx0MKGOs/qYOPUJrTBUX/ld49t7Qi5J2MCQ1EPiO9dK', NULL, 'client'),
(8, 'Maria Sawicka', 541245365, 'sawmar@gmail.com', '$2y$10$e9WccMOEXewN6NGySFJTYuA51kg.lcMbxzFDLDvPVH.hkLx6gjzEq', NULL, 'client'),
(9, 'Rafał Krajewski', 648975210, 'krajewskirafal@wp.pl', '$2y$10$bgcdUOwSh3lKogrQjU7JYuQwMegEmx81E2fDExXhLU2LB22LEVOHK', NULL, 'client'),
(10, 'Monika Michalik', 623510249, 'michalik@wp.pl', '$2y$10$1fe0tq4yc.aayui2C/V6JexdebLrPhtSjb7yeoT5mEJSZSrH3SzfO', NULL, 'client'),
(11, 'Katarzyna Szara', 210345689, 'szara.kasia@gmail.com', '$2y$10$I09Bgiy9is1PY7Mtl3H7CO70/j.gfbtpTXEmfWY51MWbPE/fY8MeO', NULL, 'client'),
(12, 'Michał Nowak', 505404303, 'nowakmichal@gmail.com', '$2y$10$QGddKNozzqNzY9zVBpprMOG2vp/35KsjafIZX3F1dilGO6PRKys0K', NULL, 'client'),
(22, 'Test', 666777888, 'test@o2.pl', '$2y$10$eiG3/niUu8q4UYikvhyGQ.2/AaXOtn2FWYVND/tQ9NAvX/NduWIqC', NULL, 'client'),
(23, 'Test bezpieczenstwa', 222555888, 'admin@admin.pl', '$2y$10$2PWkUOIa2l3Tlqo0QmD11.aEBFoVUW8UDVRBkmfI9C6b4M36ntyj2', NULL, 'admin'),
(24, 'testpracownik', 777888999, 'test@pracownik.pl', '$2y$10$qEEx9Neo1A3z8SRbElaJXOqmv7DKerIpXufeXEhzzBzYbwgWnmpJ6', NULL, 'pracownik');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_number`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `transaction_type_id` (`transaction_type_id`),
  ADD KEY `sender_account_number` (`sender_account_number`),
  ADD KEY `receiver_account_number` (`receiver_account_number`);

--
-- Indeksy dla tabeli `transactiontypes`
--
ALTER TABLE `transactiontypes`
  ADD PRIMARY KEY (`transaction_type_id`);

--
-- Indeksy dla tabeli `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`transfer_id`),
  ADD KEY `sender_account_number` (`sender_account_number`),
  ADD KEY `receiver_account_number` (`receiver_account_number`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2147483648;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Ograniczenia dla tabeli `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`transaction_type_id`) REFERENCES `transactiontypes` (`transaction_type_id`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`sender_account_number`) REFERENCES `accounts` (`account_number`),
  ADD CONSTRAINT `transactions_ibfk_3` FOREIGN KEY (`receiver_account_number`) REFERENCES `accounts` (`account_number`);

--
-- Ograniczenia dla tabeli `transfers`
--
ALTER TABLE `transfers`
  ADD CONSTRAINT `transfers_ibfk_1` FOREIGN KEY (`sender_account_number`) REFERENCES `accounts` (`account_number`),
  ADD CONSTRAINT `transfers_ibfk_2` FOREIGN KEY (`receiver_account_number`) REFERENCES `accounts` (`account_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

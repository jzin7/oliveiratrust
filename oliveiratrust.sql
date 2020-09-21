-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2020 at 03:53 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oliveiratrust`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_cliente`
--

CREATE TABLE `tb_cliente` (
  `id_cliente` int(11) NOT NULL,
  `nm_cliente` varchar(200) NOT NULL,
  `tx_email` varchar(200) NOT NULL,
  `tx_senha` varchar(200) NOT NULL,
  `administrador` int(11) NOT NULL DEFAULT 0 COMMENT '0 usuario comum, 1 administrador\r\n',
  `id_status` int(11) NOT NULL DEFAULT 1,
  `dt_cadastro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_cliente`
--

INSERT INTO `tb_cliente` (`id_cliente`, `nm_cliente`, `tx_email`, `tx_senha`, `administrador`, `id_status`, `dt_cadastro`) VALUES
(11, 'Lululu', 'jzin7@sshotmail.com', 'iLsbQ6dwUJQ=', 0, 2, '2020-09-18 15:22:23'),
(12, 'José da Silvaa', 'fds@ds.com', 'CUbP9e4DyiDvMerKi2XUqw==', 0, 1, '2020-09-18 19:12:49'),
(13, 'Bibi', '', 'iLsbQ6dwUJQ=', 0, 2, '2020-09-19 15:13:22'),
(14, 'Roberto Marinho', 'dasd', 'iLsbQ6dwUJQ=', 0, 1, '2020-09-19 15:14:49'),
(15, 'dddddd', '123456789', 'ElP9pFJODiE=', 1, 2, '2020-09-19 15:44:32'),
(18, 'Luiz Antonio Jr', 'jzin7@hotmail.com', 'CUbP9e4DyiDvMerKi2XUqw==', 1, 1, '2020-09-19 18:30:29'),
(19, 'Fábio Romero', 'jss@ss.com', '2Jo/dE8aywQ=', 1, 1, '2020-09-19 21:56:30'),
(20, '11111', 'das@dsds.com', 'h8h1KPolxVM=', 1, 2, '2020-09-19 21:56:48'),
(21, 'Silvio Santos', 'jj2@sasa.com', 'h8h1KPolxVM=', 0, 1, '2020-09-20 15:41:46'),
(22, 'Testando', 'teste@teste.com.br', '2Jo/dE8aywQ=', 0, 1, '2020-09-21 10:39:28');

-- --------------------------------------------------------

--
-- Table structure for table `tb_cliente_status`
--

CREATE TABLE `tb_cliente_status` (
  `id_cliente_status` int(11) NOT NULL,
  `nm_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_cliente_status`
--

INSERT INTO `tb_cliente_status` (`id_cliente_status`, `nm_status`) VALUES
(1, 'Ativo'),
(2, 'Suspenso');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pedido_produto`
--

CREATE TABLE `tb_pedido_produto` (
  `id_pedido_produto` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `nr_quantidade` int(11) NOT NULL,
  `nr_valor_frete` decimal(10,2) NOT NULL,
  `nr_valor_total` decimal(10,2) NOT NULL,
  `id_status` int(11) NOT NULL DEFAULT 1,
  `dt_cadastro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_pedido_produto`
--

INSERT INTO `tb_pedido_produto` (`id_pedido_produto`, `id_produto`, `id_cliente`, `nr_quantidade`, `nr_valor_frete`, `nr_valor_total`, `id_status`, `dt_cadastro`) VALUES
(1, 1, 11, 2, '21.90', '0.00', 3, '2020-09-18 17:15:59'),
(2, 10, 12, 2, '69.00', '269.00', 2, '2020-09-18 19:11:30'),
(5, 1, 12, 2, '100.00', '200.00', 1, '2020-09-18 19:11:30'),
(6, 2, 18, 1, '35.00', '235.00', 1, '2020-09-21 10:07:41'),
(7, 10, 18, 2, '60.00', '2260.00', 1, '2020-09-21 10:07:57'),
(8, 2, 18, 2, '35.00', '435.00', 1, '2020-09-21 10:08:42'),
(9, 2, 22, 1, '35.00', '235.00', 1, '2020-09-21 10:43:19');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pedido_produto_status`
--

CREATE TABLE `tb_pedido_produto_status` (
  `id_pedido_produto_status` int(11) NOT NULL,
  `nm_pedido_produto_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_pedido_produto_status`
--

INSERT INTO `tb_pedido_produto_status` (`id_pedido_produto_status`, `nm_pedido_produto_status`) VALUES
(1, 'Em aberto'),
(2, 'Pago'),
(3, 'Cancelado');

-- --------------------------------------------------------

--
-- Table structure for table `tb_produto`
--

CREATE TABLE `tb_produto` (
  `id_produto` int(11) NOT NULL,
  `nm_produto` varchar(200) NOT NULL,
  `nr_valor` decimal(10,2) NOT NULL,
  `nr_frete` decimal(10,2) NOT NULL,
  `qt_unidades_disponiveis` int(11) NOT NULL DEFAULT 0,
  `id_status` int(11) NOT NULL DEFAULT 1,
  `dt_cadastro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_produto`
--

INSERT INTO `tb_produto` (`id_produto`, `nm_produto`, `nr_valor`, `nr_frete`, `qt_unidades_disponiveis`, `id_status`, `dt_cadastro`) VALUES
(1, 'Teste', '10.00', '0.00', 0, 2, '2020-09-18 17:15:34'),
(2, 'Carregador Notebook Samsung', '200.00', '35.00', 1, 1, '2020-09-20 15:19:11'),
(3, 'Sorvete', '10.00', '0.00', 0, 2, '2020-09-20 15:19:28'),
(5, 'Sorvete', '1.00', '11.00', 1, 2, '2020-09-20 15:25:24'),
(6, 'Teclado Notebook', '350.00', '11.00', 1, 1, '2020-09-20 15:25:25'),
(7, 'Mouse', '55.00', '22.00', 55, 1, '2020-09-20 15:25:28'),
(8, 'Monitor 42º', '2500.00', '100.00', 50, 1, '2020-09-20 16:02:22'),
(9, 'Notebook', '1500.00', '50.00', 10, 1, '2020-09-20 16:13:22'),
(10, 'HD SSD 1Tera', '1100.00', '60.00', 1, 1, '2020-09-20 16:14:05');

-- --------------------------------------------------------

--
-- Table structure for table `tb_produto_status`
--

CREATE TABLE `tb_produto_status` (
  `id_produto_status` int(11) NOT NULL,
  `nm_produto_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_produto_status`
--

INSERT INTO `tb_produto_status` (`id_produto_status`, `nm_produto_status`) VALUES
(1, 'Ativo'),
(2, 'Excluido');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_cliente`
--
ALTER TABLE `tb_cliente`
  ADD PRIMARY KEY (`id_cliente`),
  ADD KEY `id_status` (`id_status`);

--
-- Indexes for table `tb_cliente_status`
--
ALTER TABLE `tb_cliente_status`
  ADD PRIMARY KEY (`id_cliente_status`);

--
-- Indexes for table `tb_pedido_produto`
--
ALTER TABLE `tb_pedido_produto`
  ADD PRIMARY KEY (`id_pedido_produto`),
  ADD KEY `id_status` (`id_status`),
  ADD KEY `id_produto` (`id_produto`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indexes for table `tb_pedido_produto_status`
--
ALTER TABLE `tb_pedido_produto_status`
  ADD PRIMARY KEY (`id_pedido_produto_status`);

--
-- Indexes for table `tb_produto`
--
ALTER TABLE `tb_produto`
  ADD PRIMARY KEY (`id_produto`),
  ADD KEY `id_status` (`id_status`);

--
-- Indexes for table `tb_produto_status`
--
ALTER TABLE `tb_produto_status`
  ADD PRIMARY KEY (`id_produto_status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_cliente`
--
ALTER TABLE `tb_cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tb_cliente_status`
--
ALTER TABLE `tb_cliente_status`
  MODIFY `id_cliente_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_pedido_produto`
--
ALTER TABLE `tb_pedido_produto`
  MODIFY `id_pedido_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_pedido_produto_status`
--
ALTER TABLE `tb_pedido_produto_status`
  MODIFY `id_pedido_produto_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_produto`
--
ALTER TABLE `tb_produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_produto_status`
--
ALTER TABLE `tb_produto_status`
  MODIFY `id_produto_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_cliente`
--
ALTER TABLE `tb_cliente`
  ADD CONSTRAINT `tb_cliente_ibfk_1` FOREIGN KEY (`id_status`) REFERENCES `tb_cliente_status` (`id_cliente_status`);

--
-- Constraints for table `tb_pedido_produto`
--
ALTER TABLE `tb_pedido_produto`
  ADD CONSTRAINT `tb_pedido_produto_ibfk_1` FOREIGN KEY (`id_status`) REFERENCES `tb_pedido_produto_status` (`id_pedido_produto_status`),
  ADD CONSTRAINT `tb_pedido_produto_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `tb_cliente` (`id_cliente`),
  ADD CONSTRAINT `tb_pedido_produto_ibfk_3` FOREIGN KEY (`id_produto`) REFERENCES `tb_produto` (`id_produto`);

--
-- Constraints for table `tb_produto`
--
ALTER TABLE `tb_produto`
  ADD CONSTRAINT `tb_produto_ibfk_1` FOREIGN KEY (`id_status`) REFERENCES `tb_produto_status` (`id_produto_status`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

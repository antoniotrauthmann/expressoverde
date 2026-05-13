-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2026 at 05:47 PM
-- Server version: 12.2.2-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projetoes`
--

-- --------------------------------------------------------

--
-- Table structure for table `assinatura`
--

CREATE TABLE `assinatura` (
  `id_assinatura` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `inicio` date NOT NULL DEFAULT current_timestamp(),
  `fim` date NOT NULL,
  `planta_mensal` tinyint(1) NOT NULL DEFAULT 0,
  `assinatura_valor` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assinatura`
--

INSERT INTO `assinatura` (`id_assinatura`, `id_usuario`, `inicio`, `fim`, `planta_mensal`, `assinatura_valor`) VALUES
(1, 1, '2023-01-15', '2024-01-15', 1, 49.90),
(2, 2, '2023-02-20', '2024-02-20', 1, 29.90),
(3, 4, '2023-04-12', '2024-04-12', 1, 49.90),
(4, 5, '2023-05-22', '2024-05-22', 1, 29.90),
(5, 7, '2023-07-01', '2024-07-01', 1, 49.90),
(6, 1, '2022-01-15', '2023-01-14', 1, 45.00),
(7, 2, '2022-02-20', '2023-02-19', 1, 25.00),
(8, 4, '2022-04-12', '2023-04-11', 1, 45.00),
(9, 7, '2022-07-01', '2023-06-30', 1, 45.00),
(10, 1, '2021-01-15', '2022-01-14', 1, 40.00),
(11, 1, '2023-01-15', '2024-01-15', 1, 49.90),
(12, 2, '2023-02-20', '2024-02-20', 1, 29.90),
(13, 4, '2023-04-12', '2024-04-12', 1, 49.90),
(14, 5, '2023-05-22', '2024-05-22', 1, 29.90),
(15, 7, '2023-07-01', '2024-07-01', 1, 49.90),
(16, 1, '2022-01-15', '2023-01-14', 1, 45.00),
(17, 2, '2022-02-20', '2023-02-19', 1, 25.00),
(18, 4, '2022-04-12', '2023-04-11', 1, 45.00),
(19, 7, '2022-07-01', '2023-06-30', 1, 45.00),
(20, 1, '2021-01-15', '2022-01-14', 1, 40.00);

-- --------------------------------------------------------

--
-- Table structure for table `endereco`
--

CREATE TABLE `endereco` (
  `id_endereco` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `logradouro` varchar(200) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) NOT NULL,
  `cep` char(9) NOT NULL,
  `zona` enum('urbana','rural') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `endereco`
--

INSERT INTO `endereco` (`id_endereco`, `id_usuario`, `logradouro`, `bairro`, `cidade`, `cep`, `zona`) VALUES
(1, 1, 'Rua das Flores, 123', 'Jardim Botânico', 'São Paulo', '01234000', 'urbana'),
(2, 2, 'Av. Paulista, 1000', 'Bela Vista', 'São Paulo', '01310100', 'urbana'),
(3, 3, 'Rua Augusta, 500', 'Consolação', 'São Paulo', '01304000', 'urbana'),
(4, 4, 'Av. Brasil, 200', 'Jardins', 'São Paulo', '01430000', 'urbana'),
(5, 5, 'Rua da Mooca, 300', 'Mooca', 'São Paulo', '03103000', 'urbana'),
(6, 6, 'Av. Cruzeiro do Sul, 400', 'Santana', 'São Paulo', '02030000', 'urbana'),
(7, 7, 'Rua Teodoro Sampaio, 600', 'Pinheiros', 'São Paulo', '05406000', 'urbana'),
(8, 8, 'Rua Base Entregador 1', 'Centro', 'São Paulo', '01001000', 'urbana'),
(9, 9, 'Rua Base Entregador 2', 'Vila Mariana', 'São Paulo', '04018000', 'urbana'),
(10, 10, 'Rua Base Entregador 3', 'Tatuapé', 'São Paulo', '03301000', 'urbana'),
(11, 1, 'Rua das Flores, 123', 'Jardim Botânico', 'São Paulo', '01234000', 'urbana'),
(12, 2, 'Av. Paulista, 1000', 'Bela Vista', 'São Paulo', '01310100', 'urbana'),
(13, 3, 'Rua Augusta, 500', 'Consolação', 'São Paulo', '01304000', 'urbana'),
(14, 4, 'Av. Brasil, 200', 'Jardins', 'São Paulo', '01430000', 'urbana'),
(15, 5, 'Rua da Mooca, 300', 'Mooca', 'São Paulo', '03103000', 'urbana'),
(16, 6, 'Av. Cruzeiro do Sul, 400', 'Santana', 'São Paulo', '02030000', 'urbana'),
(17, 7, 'Rua Teodoro Sampaio, 600', 'Pinheiros', 'São Paulo', '05406000', 'rural'),
(18, 8, 'Rua Base Entregador 1', 'Centro', 'São Paulo', '01001000', 'urbana'),
(19, 9, 'Rua Base Entregador 2', 'Vila Mariana', 'São Paulo', '04018000', 'urbana'),
(20, 10, 'Rua Base Entregador 3', 'Tatuapé', 'São Paulo', '03301000', 'urbana');

-- --------------------------------------------------------

--
-- Table structure for table `entrega`
--

CREATE TABLE `entrega` (
  `id_entrega` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_entregador` int(11) NOT NULL,
  `entrega_status` enum('aguardando','coletado','em_rota','entregue') NOT NULL DEFAULT 'aguardando',
  `previsao` datetime DEFAULT NULL,
  `entregue_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `entrega`
--

INSERT INTO `entrega` (`id_entrega`, `id_pedido`, `id_entregador`, `entrega_status`, `previsao`, `entregue_em`) VALUES
(1, 1, 8, 'entregue', '2023-10-01 12:00:00', '2023-10-01 11:45:00'),
(2, 2, 9, 'entregue', '2023-10-02 14:00:00', '2023-10-02 13:30:00'),
(3, 3, 10, 'aguardando', '2023-10-04 10:00:00', NULL),
(4, 4, 8, 'em_rota', '2023-10-05 18:00:00', NULL),
(5, 5, 9, 'aguardando', '2023-10-06 12:00:00', NULL),
(6, 6, 10, 'entregue', '2023-10-06 14:00:00', '2023-10-06 14:10:00'),
(7, 7, 8, 'aguardando', '2023-10-08 10:00:00', NULL),
(8, 8, 9, 'entregue', '2023-10-08 18:00:00', '2023-10-08 17:50:00'),
(9, 9, 10, 'em_rota', '2023-10-10 12:00:00', NULL),
(10, 10, 8, 'aguardando', '2023-10-11 16:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `imagens_produto`
--

CREATE TABLE `imagens_produto` (
  `id_imagem` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `produto_caminho_imagem` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_pedido`
--

CREATE TABLE `item_pedido` (
  `id_item` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_pedido`
--

INSERT INTO `item_pedido` (`id_item`, `id_pedido`, `id_produto`, `quantidade`, `preco_unitario`) VALUES
(1, 1, 1, 1, 35.50),
(2, 1, 2, 1, 89.90),
(3, 2, 3, 2, 15.00),
(4, 3, 2, 1, 89.90),
(5, 4, 5, 1, 120.00),
(6, 4, 4, 1, 25.00),
(7, 5, 6, 1, 45.90),
(8, 6, 7, 1, 65.00),
(9, 7, 9, 1, 22.00),
(10, 8, 4, 1, 25.00);

-- --------------------------------------------------------

--
-- Table structure for table `loja_parceira`
--

CREATE TABLE `loja_parceira` (
  `id_loja` int(11) NOT NULL,
  `loja_nome` varchar(150) NOT NULL,
  `plataforma` varchar(60) DEFAULT NULL,
  `latitude` decimal(9,6) DEFAULT NULL,
  `longitude` decimal(9,6) DEFAULT NULL,
  `loja_telefone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loja_parceira`
--

INSERT INTO `loja_parceira` (`id_loja`, `loja_nome`, `plataforma`, `latitude`, `longitude`, `loja_telefone`) VALUES
(1, 'Flora Viva', 'App', -23.550500, -46.633300, '11999990001'),
(2, 'Jardim Encantado', 'Web', -23.561500, -46.655000, '11999990002'),
(3, 'Verde Vida', 'App', -23.572000, -46.641000, '11999990003'),
(4, 'Plantas & Cia', 'Ifood', -23.540000, -46.620000, '11999990004'),
(5, 'Boutique Botânica', 'App', -23.580500, -46.660100, '11999990005'),
(6, 'Raiz Forte', 'Web', -23.590000, -46.670000, '11999990006'),
(7, 'Folha Seca', 'Ifood', -23.530000, -46.610000, '11999990007'),
(8, 'Mundo Verde', 'App', -23.520000, -46.600000, '11999990008'),
(9, 'Cactos e Suculentas', 'Web', -23.510000, -46.590000, '11999990009'),
(10, 'Horta em Casa', 'App', -23.500000, -46.580000, '11999990010');

-- --------------------------------------------------------

--
-- Table structure for table `pedido`
--

CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_endereco` int(11) NOT NULL,
  `id_assinatura` int(11) DEFAULT NULL,
  `status` enum('pendente','confirmado','em_rota','entregue','cancelado') NOT NULL DEFAULT 'pendente',
  `total` decimal(10,2) NOT NULL,
  `criado_em` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pedido`
--

INSERT INTO `pedido` (`id_pedido`, `id_usuario`, `id_endereco`, `id_assinatura`, `status`, `total`, `criado_em`) VALUES
(1, 1, 1, 1, 'pendente', 125.40, '2023-10-01 09:00:00'),
(2, 2, 2, 2, 'pendente', 30.00, '2023-10-02 10:30:00'),
(3, 3, 3, NULL, 'pendente', 89.90, '2023-10-03 11:15:00'),
(4, 4, 4, 3, 'pendente', 145.00, '2023-10-04 14:20:00'),
(5, 5, 5, 4, 'cancelado', 45.90, '2023-10-05 16:45:00'),
(6, 6, 6, NULL, 'pendente', 65.00, '2023-10-06 08:30:00'),
(7, 7, 7, 5, 'pendente', 22.00, '2023-10-07 13:10:00'),
(8, 1, 1, 1, 'pendente', 25.00, '2023-10-08 15:00:00'),
(9, 2, 2, 2, 'pendente', 5.50, '2023-10-09 09:45:00'),
(10, 3, 3, NULL, 'pendente', 120.00, '2023-10-10 11:20:00');

-- --------------------------------------------------------

--
-- Table structure for table `post_comunidade`
--

CREATE TABLE `post_comunidade` (
  `id_post` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `conteudo` text NOT NULL,
  `curtidas` int(11) NOT NULL DEFAULT 0,
  `post_caminho_imagem` varchar(255) DEFAULT NULL,
  `criado_em` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_comunidade`
--

INSERT INTO `post_comunidade` (`id_post`, `id_usuario`, `titulo`, `conteudo`, `curtidas`, `post_caminho_imagem`, `criado_em`) VALUES
(2, 1, 'Post da Comunidade', 'teset', 2, NULL, '2026-04-15 00:30:45'),
(3, 1, 'Post da Comunidade', 'teste 2', 1, NULL, '2026-04-15 00:31:00'),
(6, 1, 'Post da Comunidade', 'br', 1, 'public/uploads/69e68652ca526.png', '2026-04-20 17:02:26'),
(7, 1, 'Post da Comunidade', 'aaa', 2, NULL, '2026-04-21 18:38:42'),
(8, 1, 'Post da Comunidade', 'e', 0, NULL, '2026-04-22 00:54:25'),
(9, 14, 'Post da Comunidade', 'a', 0, NULL, '2026-04-22 01:16:21'),
(10, 14, 'Post da Comunidade', 'oi', 0, NULL, '2026-04-22 09:31:49');

-- --------------------------------------------------------

--
-- Table structure for table `produto`
--

CREATE TABLE `produto` (
  `id_produto` int(11) NOT NULL,
  `id_loja` int(11) DEFAULT NULL,
  `produto_nome` varchar(150) NOT NULL,
  `categoria` enum('planta','kit_jardinagem','suplemento','semente','ferramenta','acessorio') NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `estoque` int(11) NOT NULL DEFAULT 0,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produto`
--

INSERT INTO `produto` (`id_produto`, `id_loja`, `produto_nome`, `categoria`, `preco`, `estoque`, `descricao`) VALUES
(1, 1, 'Samambaia Americana', 'planta', 35.50, 50, NULL),
(2, 2, 'Vaso de Cerâmica Grande', 'acessorio', 89.90, 20, NULL),
(3, 3, 'Suculenta Echeveria', 'planta', 15.00, 100, NULL),
(4, 4, 'Substrato Adubado 5kg', 'suplemento', 25.00, 80, NULL),
(5, 5, 'Ficus Lyrata', 'planta', 120.00, 15, NULL),
(6, 6, 'Kit Ferramentas Jardim', 'ferramenta', 45.90, 30, NULL),
(7, 7, 'Orquídea Phalaenopsis', 'planta', 65.00, 25, NULL),
(8, 8, 'Fertilizante Líquido NPK', 'suplemento', 18.50, 60, NULL),
(9, 9, 'Cacto Mandacaru Mini', 'planta', 22.00, 40, NULL),
(10, 10, 'Sementes de Manjericão', 'semente', 5.50, 200, NULL),
(11, 1, 'Samambaia Americana', 'planta', 35.50, 50, NULL),
(12, 2, 'Vaso de Cerâmica Grande', 'acessorio', 89.90, 20, NULL),
(13, 3, 'Suculenta Echeveria', 'planta', 15.00, 100, NULL),
(14, 4, 'Substrato Adubado 5kg', 'suplemento', 25.00, 80, NULL),
(15, 5, 'Ficus Lyrata', 'planta', 120.00, 15, NULL),
(16, 6, 'Kit Ferramentas Jardim', 'ferramenta', 45.90, 30, NULL),
(17, 7, 'Orquídea Phalaenopsis', 'planta', 65.00, 25, NULL),
(18, 8, 'Fertilizante Líquido NPK', 'suplemento', 18.50, 60, NULL),
(19, 9, 'Cacto Mandacaru Mini', 'planta', 22.00, 40, NULL),
(20, 10, 'Sementes de Manjericão', 'semente', 5.50, 200, NULL),
(21, NULL, 'esse produto', 'planta', 15.00, 50, NULL),
(22, 5, 'pá de jardinagem', 'ferramenta', 50.00, 200, 'pa de jardinagem mt util');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `usuario_nome` varchar(120) NOT NULL,
  `email` varchar(180) NOT NULL,
  `senha_hash` varchar(255) NOT NULL,
  `tipo` enum('cliente','profissional','admin') NOT NULL,
  `plano` enum('basico','premium') DEFAULT NULL,
  `data_cadastro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `usuario_nome`, `email`, `senha_hash`, `tipo`, `plano`, `data_cadastro`) VALUES
(1, 'Teste', 'teste@teste.com', '123', 'cliente', NULL, '2026-04-15 00:27:53'),
(2, 'ig', 'ig@gmail.com', '$2y$10$.EFtweF1VqhqUWVfwjhwae1FZjqKuMFJKZiDr2DRWrRBNyn33owYm', 'cliente', NULL, '2026-04-20 19:32:14'),
(3, 'igorj', 'joao@gmail.com', '$2y$10$lnHPrHBOcUhL4LuF.hDVtedWm774ETXD82hqqXDjxP9KbQwXELxEi', 'cliente', NULL, '2026-04-21 17:42:44'),
(4, 'igor', 'igor@gmail.com', '$2y$10$drxHNMxXNCZuHLO5jEDt9OANuXHXCtoZVvJL3GhkDcsvumJvVAfE2', 'cliente', NULL, '2026-04-21 17:54:36'),
(5, 'abc', 'abc@gmail.com', '$2y$10$wrX5168OhCmln4Xl8DWqLeb0DXmGTyt0PoAWHu/Rqcov3tPN2qYiK', 'cliente', NULL, '2026-04-21 18:23:29'),
(6, 'Elena Rocha', 'elena@email.com', 'hash123', 'cliente', 'basico', '2023-05-22 11:20:00'),
(7, 'Fabio Lima', 'fabio@email.com', 'hash123', 'cliente', NULL, '2023-06-10 08:00:00'),
(8, 'Gisele B', 'gisele@email.com', 'hash123', 'cliente', 'premium', '2023-07-01 13:10:00'),
(9, 'Hugo Entregas', 'hugo@log.com', 'hash123', 'profissional', NULL, '2022-11-01 07:30:00'),
(10, 'Igor Moto', 'igor@log.com', 'hash123', 'profissional', NULL, '2022-11-05 08:45:00'),
(11, 'Joao Express', 'joao@log.com', 'hash123', 'profissional', NULL, '2022-12-10 09:00:00'),
(12, 'Gabriel', 'email@email.com', '$2y$10$62RDVPFkZbRz8uLO.YrrTOvU7GTq.62RXARZgAkByRgTFaaR91udW', 'cliente', NULL, '2026-04-21 18:49:18'),
(13, 'Gabriel Henriq', 'gabriel@email.com', '$2y$10$5MJGD36Ua0vHbI0SliGuEeTSQ1FA3eNnC8ahh2qFI.f7C1LmiMIVG', 'cliente', NULL, '2026-04-21 18:49:49'),
(14, 'igor', 'igg@gmail.com', '$2y$10$mTS6Jx0oVS3aC/ymN6WOeek9CQN/A3HhwprFIi4liwS8XKFOvg.wS', 'cliente', NULL, '2026-04-22 00:54:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assinatura`
--
ALTER TABLE `assinatura`
  ADD PRIMARY KEY (`id_assinatura`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `endereco`
--
ALTER TABLE `endereco`
  ADD PRIMARY KEY (`id_endereco`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `entrega`
--
ALTER TABLE `entrega`
  ADD PRIMARY KEY (`id_entrega`),
  ADD UNIQUE KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_entregador` (`id_entregador`);

--
-- Indexes for table `imagens_produto`
--
ALTER TABLE `imagens_produto`
  ADD PRIMARY KEY (`id_imagem`),
  ADD KEY `idx_produto_imagem` (`id_produto`);

--
-- Indexes for table `item_pedido`
--
ALTER TABLE `item_pedido`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Indexes for table `loja_parceira`
--
ALTER TABLE `loja_parceira`
  ADD PRIMARY KEY (`id_loja`);

--
-- Indexes for table `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_endereco` (`id_endereco`),
  ADD KEY `id_assinatura` (`id_assinatura`);

--
-- Indexes for table `post_comunidade`
--
ALTER TABLE `post_comunidade`
  ADD PRIMARY KEY (`id_post`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id_produto`),
  ADD KEY `id_loja` (`id_loja`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assinatura`
--
ALTER TABLE `assinatura`
  MODIFY `id_assinatura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `endereco`
--
ALTER TABLE `endereco`
  MODIFY `id_endereco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `entrega`
--
ALTER TABLE `entrega`
  MODIFY `id_entrega` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `imagens_produto`
--
ALTER TABLE `imagens_produto`
  MODIFY `id_imagem` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_pedido`
--
ALTER TABLE `item_pedido`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `loja_parceira`
--
ALTER TABLE `loja_parceira`
  MODIFY `id_loja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `post_comunidade`
--
ALTER TABLE `post_comunidade`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `produto`
--
ALTER TABLE `produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assinatura`
--
ALTER TABLE `assinatura`
  ADD CONSTRAINT `1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Constraints for table `endereco`
--
ALTER TABLE `endereco`
  ADD CONSTRAINT `1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Constraints for table `entrega`
--
ALTER TABLE `entrega`
  ADD CONSTRAINT `1` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`),
  ADD CONSTRAINT `2` FOREIGN KEY (`id_entregador`) REFERENCES `usuario` (`id_usuario`);

--
-- Constraints for table `imagens_produto`
--
ALTER TABLE `imagens_produto`
  ADD CONSTRAINT `1` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`) ON DELETE CASCADE;

--
-- Constraints for table `item_pedido`
--
ALTER TABLE `item_pedido`
  ADD CONSTRAINT `1` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`),
  ADD CONSTRAINT `2` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`);

--
-- Constraints for table `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `2` FOREIGN KEY (`id_endereco`) REFERENCES `endereco` (`id_endereco`),
  ADD CONSTRAINT `3` FOREIGN KEY (`id_assinatura`) REFERENCES `assinatura` (`id_assinatura`);

--
-- Constraints for table `post_comunidade`
--
ALTER TABLE `post_comunidade`
  ADD CONSTRAINT `1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Constraints for table `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `1` FOREIGN KEY (`id_loja`) REFERENCES `loja_parceira` (`id_loja`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

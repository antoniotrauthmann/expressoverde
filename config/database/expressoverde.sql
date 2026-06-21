-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 21/06/2026 às 21:47
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projetoes`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `assinatura`
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
-- Despejando dados para a tabela `assinatura`
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
-- Estrutura para tabela `curtida_post`
--

CREATE TABLE `curtida_post` (
  `id_usuario` int(11) NOT NULL,
  `id_post` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `curtida_post`
--

INSERT INTO `curtida_post` (`id_usuario`, `id_post`) VALUES
(13, 71),
(30, 9),
(30, 10),
(31, 6),
(31, 9),
(31, 66),
(31, 73),
(31, 74);

-- --------------------------------------------------------

--
-- Estrutura para tabela `endereco`
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
-- Despejando dados para a tabela `endereco`
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
(20, 10, 'Rua Base Entregador 3', 'Tatuapé', 'São Paulo', '03301000', 'urbana'),
(21, 17, 'avenida juscelino kubischek', 'Centro', 'Palmas', '7777777', 'urbana'),
(22, 23, 'rua da uft', 'Centro', 'Palmas', '12345678', 'urbana'),
(23, 13, 'Rua curio', 'Jp', 'Paraiso', '77600000', 'urbana'),
(24, 31, 'Rua curio', 'Jp', 'Paraiso', '77600000', 'urbana');

-- --------------------------------------------------------

--
-- Estrutura para tabela `entrega`
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
-- Despejando dados para a tabela `entrega`
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
-- Estrutura para tabela `imagens_produto`
--

CREATE TABLE `imagens_produto` (
  `id_imagem` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `produto_caminho_imagem` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `imagens_produto`
--

INSERT INTO `imagens_produto` (`id_imagem`, `id_produto`, `produto_caminho_imagem`) VALUES
(1, 23, '69f204c472e74_OIP (1).webp'),
(2, 24, '69f208c640322_6b393975d1a421625b4e42aec4d5af92.webp'),
(3, 1, 'samambaia.png'),
(4, 25, '6a16367382e43_OIP (2).webp'),
(5, 26, '6a1638d134b2b_OIP (3).webp'),
(6, 27, '6a1639722a394_OIP (4).webp'),
(7, 28, '6a163a3d398e7_D_NQ_NP_968654-MLB73785770165_012024-O.webp'),
(8, 29, '6a163aa59ba9a_OIP (6).webp'),
(9, 30, '6a16df1894eef_baixados.webp'),
(10, 30, '6a16df1895b6d_baixados (1).webp'),
(11, 31, '6a1db520f18df_Captura de tela 2026-04-20 194027.png'),
(12, 32, '6a1db6488d5dd_Captura de tela 2026-04-20 194630.png'),
(13, 33, '6a3837a6705df_espada.webp'),
(14, 34, '6a38389983815_como-plantar-zamioculca-3.jpg'),
(15, 34, '6a38389983da0_zamioculca-1.webp'),
(16, 35, '6a38394512cf9_kit de ferramentas.jpg'),
(17, 36, '6a3839eab68f1_51kfly8+PkL._AC_SX466_.jpg'),
(18, 36, '6a3839eab6f22_61q5IOCfgTL._AC_SX450_.jpg'),
(19, 37, '6a383b5cae16b_br-11134207-7r98o-m3xen78v0aphb1.jpg'),
(20, 38, '6a383bf0a72c3_berberina_500mg_planta_phelodendron_amurense_c_60_capsulas_6792_1_9edd31c192d95ed3c6f74bf629acc580.webp'),
(21, 39, '6a383c3ff10ee_a15d94098e.webp'),
(22, 40, '6a383ceb26ad7_D_NQ_NP_972650-MLB70586912305_072023-O.webp');

-- --------------------------------------------------------

--
-- Estrutura para tabela `item_pedido`
--

CREATE TABLE `item_pedido` (
  `id_item` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `item_pedido`
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
(10, 8, 4, 1, 25.00),
(11, 11, 24, 2, 15.65),
(12, 11, 23, 1, 10.00),
(13, 12, 25, 1, 15.00),
(14, 13, 27, 5, 15.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `loja_parceira`
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
-- Despejando dados para a tabela `loja_parceira`
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
-- Estrutura para tabela `pedido`
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
-- Despejando dados para a tabela `pedido`
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
(10, 3, 3, NULL, 'pendente', 120.00, '2023-10-10 11:20:00'),
(11, 17, 21, NULL, 'pendente', 41.30, '2026-05-13 10:12:49'),
(12, 23, 22, NULL, 'pendente', 15.00, '2026-06-01 14:19:50'),
(13, 31, 24, NULL, 'cancelado', 75.00, '2026-06-19 18:39:26');

-- --------------------------------------------------------

--
-- Estrutura para tabela `post_comunidade`
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
-- Despejando dados para a tabela `post_comunidade`
--

INSERT INTO `post_comunidade` (`id_post`, `id_usuario`, `titulo`, `conteudo`, `curtidas`, `post_caminho_imagem`, `criado_em`) VALUES
(2, 1, 'Post da Comunidade', 'teset', 2, NULL, '2026-04-15 00:30:45'),
(3, 1, 'Post da Comunidade', 'teste 2', 1, NULL, '2026-04-15 00:31:00'),
(6, 1, 'Post da Comunidade', 'br', 2, 'public/uploads/69e68652ca526.png', '2026-04-20 17:02:26'),
(7, 1, 'Post da Comunidade', 'aaa', 2, NULL, '2026-04-21 18:38:42'),
(8, 1, 'Post da Comunidade', 'e', 0, NULL, '2026-04-22 00:54:25'),
(9, 14, 'Post da Comunidade', 'a', 2, NULL, '2026-04-22 01:16:21'),
(10, 14, 'Post da Comunidade', 'oi', 3, NULL, '2026-04-22 09:31:49'),
(12, 15, 'Post da Comunidade', 'sadasa', 0, NULL, '2026-04-28 21:50:03'),
(14, 17, 'Post da Comunidade', 'eu ', 2, NULL, '2026-04-29 10:31:23'),
(27, 17, 'Post da Comunidade', 'planta azul \r\n', 0, 'public/uploads/6a14c17fe37cc.webp', '2026-05-25 18:39:11'),
(36, 20, 'Post da Comunidade', 'Semente de abobora que comprei recentemente é incrivel!\r\n', 4, 'public/uploads/6a16e3fc543d4.webp', '2026-05-27 09:30:52'),
(37, 20, 'Post da Comunidade', 'Este produto é muito bom!', 8, 'public/uploads/6a16e413515a8.webp', '2026-05-27 09:31:15'),
(45, 29, 'Post da Comunidade', 'asa', 2, NULL, '2026-06-01 17:55:17'),
(55, 29, 'Post da Comunidade', 'sdada', 0, NULL, '2026-06-02 21:33:04'),
(58, 29, 'Post da Comunidade', 'aaa', 0, 'public/uploads/6a1f76adba703.webp', '2026-06-02 21:34:53'),
(63, 30, 'Post da Comunidade', 'dsada', 0, NULL, '2026-06-19 16:40:18'),
(66, 30, 'Post da Comunidade', 'dasa', 1, NULL, '2026-06-19 16:48:47'),
(71, 30, 'Post da Comunidade', 'asa', 1, NULL, '2026-06-19 17:09:53'),
(73, 31, 'Post da Comunidade', 'Foto', 1, 'public/uploads/6a382b936f000.png', '2026-06-21 15:21:07'),
(74, 31, 'Post da Comunidade', 'JKDJASLKJDLASKJDKLSAJ', 1, 'public/uploads/6a382ebf5a0a2.jpg', '2026-06-21 15:34:39');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `id_produto` int(11) NOT NULL,
  `id_loja` int(11) DEFAULT NULL,
  `produto_nome` varchar(150) NOT NULL,
  `categoria` enum('semente','planta','kit_jardinagem','suplemento','semente','ferramenta','acessorio') NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `estoque` int(11) NOT NULL DEFAULT 0,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`id_produto`, `id_loja`, `produto_nome`, `categoria`, `preco`, `estoque`, `descricao`) VALUES
(25, NULL, 'Samambaia', 'planta', 15.00, 5, 'Samambaia'),
(26, NULL, 'Vaso de Cerâmica Grande', 'acessorio', 89.00, 20, 'Transforme qualquer ambiente com este lindo vaso de cerâmica azul, perfeito para adicionar charme e modernidade à sua casa. Com acabamento refinado e design elegante, ele combina facilmente com salas, quartos, escritórios e áreas gourmet.'),
(27, NULL, 'Suculenta Echeveria', 'planta', 15.00, 5, 'A suculenta Echeveria é perfeita para quem deseja trazer delicadeza e charme para qualquer ambiente. Com suas folhas organizadas em formato de rosa e aparência elegante, ela é ideal para decorar mesas, estantes, escritórios e jardins.\r\n\r\nAlém de linda, a Echeveria é uma planta resistente e de fácil manutenção, sendo ótima tanto para iniciantes quanto para amantes de plantas. Precisa de pouca água e se adapta muito bem a ambientes iluminados.'),
(28, NULL, 'Substrato Adubado 5kg', 'suplemento', 25.65, 10, 'O Substrato Adubado 5kg é ideal para garantir o crescimento saudável e fortalecido das suas plantas. Rico em nutrientes essenciais, ele proporciona melhor desenvolvimento das raízes, maior retenção de umidade e mais vitalidade para flores, hortaliças, suculentas e plantas ornamentais.\r\n\r\nCom textura leve e pronta para uso, é perfeito para vasos, jardins, canteiros e replantios, ajudando suas plantas a crescerem mais bonitas e resistentes.'),
(29, NULL, 'Ficus Lyrata', 'planta', 120.00, 10, 'O Ficus Lyrata, também conhecido como Figueira-Lira, é uma planta ornamental elegante e moderna, perfeita para transformar qualquer espaço com um toque de natureza e sofisticação. Suas folhas grandes, verdes e brilhantes trazem destaque à decoração, sendo ideal para salas, escritórios, varandas e ambientes internos iluminados.\r\n\r\nAlém da beleza exuberante, o Ficus Lyrata ajuda a deixar o ambiente mais aconchegante e harmonioso, tornando-se uma excelente escolha para quem ama decoração com plantas.'),
(30, NULL, 'Semente de abóbora', 'semente', 5.00, 1000, 'A semente de abóbora é altamente nutritiva, oferecendo benefícios para o coração, ossos, sistema imunológico, digestão e saúde hormonal.\r\nBenefícios para a Saúde\r\nAs sementes de abóbora são ricas em magnésio, zinco, ferro, fósforo, potássio, proteínas, fibras e antioxidantes, como vitamina E e carotenoides, que ajudam a combater os radicais livres e reduzir inflamações no corpo. Entre os principais benefícios estão:'),
(33, 1, 'Espada-de-São-Jorge', 'planta', 500.00, 30, 'Ícone da decoração minimalista e também presente em projetos com referências afro-brasileiras, a Espada-de-São-Jorge é uma planta de porte ereto e folhas rígidas com bordas amareladas ou verde-escuro. Extremamente resistente, ela suporta ambientes com pouca luz e regas espaçadas, sendo ideal para quem não tem tempo para manutenções constantes. Também é bastante usada em entradas ou cantos de proteção simbólica. Contudo, é importante lembrar que se trata de uma planta tóxica para cães e gatos, devendo ser posicionada fora do alcance dos animais.'),
(34, 1, 'Zamioculca', 'planta', 213.00, 200, 'Com folhas brilhantes e formato escultural, a zamioculca é uma planta perfeita para quem busca uma decoração elegante e de baixa manutenção. Ela tolera bem ambientes com pouca luz natural e exige pouca rega, adaptando-se facilmente a salas, halls e escritórios. Sua aparência robusta combina com vasos modernos e neutros. Apesar da praticidade, vale destacar que é uma planta tóxica para pets e deve ser mantida longe de animais curiosos.'),
(35, 1, 'Tramontina Conjunto Para Jardinagem Metálico Com Cabo De Madeira 3 Peças', 'kit_jardinagem', 100.00, 540, '- As ferramentas são fabricadas em aço carbono especial de alta qualidade. - Recebem pintura eletrostática a pó, que tem uma melhor apresentação visual e maior proteção contra oxidação. - Os cabos destas ferramentas, além de possuírem ótima resistência, são produzidos com madeira de origem renovável. - Cabos com acabamento envernizado, para um melhor acabamento e apresentação do produto. A camada protetora em verniz incolor realça sua tonalidade, concedendo brilho e um toque mais liso ao produto. - Produtos leves, que geram menos esforço físico do usuário e tornam o trabalho mais prazeroso. - Contém 3 peças: 1 pazinha larga (77907/001), 1 pazinha estreita (77908/001) e 1 ancinho 3 dentes (77909/001). - A embalagem tem por finalidade facilitar a exposição do produto no ponto de venda.'),
(36, 1, 'Kit de Jardinagem com 10 Peças e Maleta', 'kit_jardinagem', 150.00, 300, 'Kit completo com 10 peças: inclui pás, sachos, tesouras, spray, mini rastelo, foice e pazinhas, ideal para todas as tarefas do jardim.'),
(37, 1, 'Suplemento Moringa Oleifera', 'suplemento', 50.00, 40, 'Suplemento Moringa Oleifera - 120 cápsulas'),
(38, 1, 'Berberina 500mg Planta Phelodendron Amurense c/ 60 cápsulas', 'suplemento', 30.00, 40, 'Berberina 500mg extraída da planta Phellodendron Amurense, com 60 cápsulas.'),
(39, 1, 'SuperThrive Original 3,79L', 'suplemento', 35.00, 50, 'SuperThrive Original 3,79L | GrowFert - GrowFert: Cultivo em primeiro lugar'),
(40, 1, 'Suplemento Vitamínico Maria Green', 'suplemento', 147.00, 100, 'Suplemento Vitamínico Plantas Maria Green Algax 1L | Growbacana - Cultivo Indoor e Hidroponiac');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `usuario_nome` varchar(120) NOT NULL,
  `email` varchar(180) NOT NULL,
  `senha_hash` varchar(255) NOT NULL,
  `tipo` enum('cliente','profissional','admin') NOT NULL,
  `plano` enum('basico','premium') DEFAULT NULL,
  `data_cadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `id_loja` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `usuario_nome`, `email`, `senha_hash`, `tipo`, `plano`, `data_cadastro`, `id_loja`) VALUES
(1, 'Teste', 'teste@teste.com', '123', 'cliente', NULL, '2026-04-15 00:27:53', NULL),
(2, 'ig', 'ig@gmail.com', '$2y$10$.EFtweF1VqhqUWVfwjhwae1FZjqKuMFJKZiDr2DRWrRBNyn33owYm', 'cliente', NULL, '2026-04-20 19:32:14', NULL),
(3, 'igorj', 'joao@gmail.com', '$2y$10$lnHPrHBOcUhL4LuF.hDVtedWm774ETXD82hqqXDjxP9KbQwXELxEi', 'cliente', NULL, '2026-04-21 17:42:44', NULL),
(4, 'igor', 'igor@gmail.com', '$2y$10$drxHNMxXNCZuHLO5jEDt9OANuXHXCtoZVvJL3GhkDcsvumJvVAfE2', 'cliente', NULL, '2026-04-21 17:54:36', NULL),
(5, 'abc', 'abc@gmail.com', '$2y$10$wrX5168OhCmln4Xl8DWqLeb0DXmGTyt0PoAWHu/Rqcov3tPN2qYiK', 'cliente', NULL, '2026-04-21 18:23:29', NULL),
(6, 'Elena Rocha', 'elena@email.com', 'hash123', 'cliente', 'basico', '2023-05-22 11:20:00', NULL),
(7, 'Fabio Lima', 'fabio@email.com', 'hash123', 'cliente', NULL, '2023-06-10 08:00:00', NULL),
(8, 'Gisele B', 'gisele@email.com', 'hash123', 'cliente', 'premium', '2023-07-01 13:10:00', NULL),
(9, 'Hugo Entregas', 'hugo@log.com', 'hash123', 'profissional', NULL, '2022-11-01 07:30:00', 1),
(10, 'Igor Moto', 'igor@log.com', 'hash123', 'profissional', NULL, '2022-11-05 08:45:00', 2),
(11, 'Joao Express', 'joao@log.com', 'hash123', 'profissional', NULL, '2022-12-10 09:00:00', 3),
(12, 'Gabriel', 'email@email.com', '$2y$10$62RDVPFkZbRz8uLO.YrrTOvU7GTq.62RXARZgAkByRgTFaaR91udW', 'cliente', NULL, '2026-04-21 18:49:18', NULL),
(13, 'Gabriel Henriq', 'gabriel@email.com', '$2y$10$5MJGD36Ua0vHbI0SliGuEeTSQ1FA3eNnC8ahh2qFI.f7C1LmiMIVG', 'cliente', NULL, '2026-04-21 18:49:49', NULL),
(14, 'igor', 'igg@gmail.com', '$2y$10$mTS6Jx0oVS3aC/ymN6WOeek9CQN/A3HhwprFIi4liwS8XKFOvg.wS', 'cliente', NULL, '2026-04-22 00:54:15', NULL),
(18, 'antõnio', 'antonio@gmail.com', '$2y$10$I2wW0pRTMpXwI7IdzXBiPO5dsku5HexvYCm5IkSs26TmWdttKUqUC', 'profissional', NULL, '2026-04-29 10:32:37', 4),
(21, 'teste', 't@gmail.com', '$2y$10$ti6qirdP9aioZa9THfhsSOy54xbW0UgRzi/ckob0PJzZ3PsHsVcBG', 'profissional', NULL, '2026-05-27 09:39:57', 6),
(22, 'joao', 'cliente@gmail.com', '$2y$10$WpbXA74mEUPO8SrXYjOH6unT7h8KlciGmBrnK4gZLE8FKnHbNShGa', 'cliente', NULL, '2026-05-31 15:37:17', NULL),
(23, 'profissional', 'profissional@gmail.com', '$2y$10$hPLaOifonV/AA7hbi5SUNuIgM2GpMCGVC5q57sXqwB83wLFA3mGLK', 'profissional', NULL, '2026-05-31 15:39:06', 7),
(24, 'sas', 'profissional2@gmail.com', '$2y$10$.fhEV2XAmfVAikT8XIGK4ubLOP5yEoQZY9ciwGjDs0PKh6lU./fdi', 'profissional', NULL, '2026-06-01 13:34:15', 2),
(25, 'sas', 'profissional3@gmail.com', '$2y$10$auBMhmKQfavj7bWlQnriNuJD2Smp0x6fVK8IqKLc728I66wMjdTP.', 'profissional', NULL, '2026-06-01 13:35:34', 1),
(26, 'sdsadasd', 'joaozinhogames@gmail.com', '$2y$10$24oJshEcTqOQcKN/MtYRqux8llr7FeFFpuYo4PSnGvNYvrB/nozzm', 'cliente', NULL, '2026-06-01 13:42:48', NULL),
(27, 'aaaaaaa', 'fffgg@gmail.com', '$2y$10$BSJQVIz1ZYMu3xyjkW2uiOaagv5uwzzARHAbjsLObZosYTKhxsRli', 'profissional', NULL, '2026-06-01 14:12:39', 3),
(28, 'zezinho', 'zezinho@gmail.com', '$2y$10$chM4ELb4YXaccIyvQhvr9u6avFGmpz2sZn2yweORjwaVX4NPwEOsq', 'profissional', NULL, '2026-06-01 14:13:16', 8),
(30, 'hiago', 'pudhhdhdy@gmail.com', '$2y$10$8RmHeUHR9mnwHrfhyJAlFu36zPx2FlXyFIbZ7AoES1yQZVv6SIjfy', 'profissional', NULL, '2026-06-09 11:41:36', 2),
(31, 'Gabriel Profissional', 'p@pr.com', '$2y$10$2MEk85RcYYgsIC1nwSsYUe0/v625ExT5Yq3JDJ5cd8jKke1xDLa1O', 'profissional', NULL, '2026-06-19 18:04:53', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `assinatura`
--
ALTER TABLE `assinatura`
  ADD PRIMARY KEY (`id_assinatura`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `curtida_post`
--
ALTER TABLE `curtida_post`
  ADD PRIMARY KEY (`id_usuario`,`id_post`);

--
-- Índices de tabela `endereco`
--
ALTER TABLE `endereco`
  ADD PRIMARY KEY (`id_endereco`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `entrega`
--
ALTER TABLE `entrega`
  ADD PRIMARY KEY (`id_entrega`),
  ADD UNIQUE KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_entregador` (`id_entregador`);

--
-- Índices de tabela `imagens_produto`
--
ALTER TABLE `imagens_produto`
  ADD PRIMARY KEY (`id_imagem`),
  ADD KEY `idx_produto_imagem` (`id_produto`);

--
-- Índices de tabela `item_pedido`
--
ALTER TABLE `item_pedido`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices de tabela `loja_parceira`
--
ALTER TABLE `loja_parceira`
  ADD PRIMARY KEY (`id_loja`);

--
-- Índices de tabela `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_endereco` (`id_endereco`),
  ADD KEY `id_assinatura` (`id_assinatura`);

--
-- Índices de tabela `post_comunidade`
--
ALTER TABLE `post_comunidade`
  ADD PRIMARY KEY (`id_post`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id_produto`),
  ADD KEY `id_loja` (`id_loja`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_usuario_loja` (`id_loja`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `assinatura`
--
ALTER TABLE `assinatura`
  MODIFY `id_assinatura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `endereco`
--
ALTER TABLE `endereco`
  MODIFY `id_endereco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `entrega`
--
ALTER TABLE `entrega`
  MODIFY `id_entrega` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `imagens_produto`
--
ALTER TABLE `imagens_produto`
  MODIFY `id_imagem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `item_pedido`
--
ALTER TABLE `item_pedido`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `loja_parceira`
--
ALTER TABLE `loja_parceira`
  MODIFY `id_loja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `post_comunidade`
--
ALTER TABLE `post_comunidade`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `assinatura`
--
ALTER TABLE `assinatura`
  ADD CONSTRAINT `1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Restrições para tabelas `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_loja` FOREIGN KEY (`id_loja`) REFERENCES `loja_parceira` (`id_loja`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 11/12/2025 às 00:32
-- Versão do servidor: 8.3.0
-- Versão do PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `loja_virtual`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci,
  `ativo` tinyint(1) DEFAULT '1',
  `data_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nome`, `slug`, `descricao`, `ativo`, `data_criacao`) VALUES
(1, 'Eletrônicos', 'eletronicos', 'Aparelhos eletrônicos em geral', 1, '2025-11-26 21:38:08'),
(2, 'Roupas', 'roupas', 'Moda masculina, feminina e infantil', 1, '2025-11-26 21:38:08'),
(3, 'Livros', 'livros', 'Livros físicos e digitais', 1, '2025-11-26 21:38:08'),
(4, 'Sapatos', 'sapatos', 'toda forma de sapatos, tênis e sandalias', 1, '2025-12-10 21:26:36');

-- --------------------------------------------------------

--
-- Estrutura para tabela `imagens_produto`
--

DROP TABLE IF EXISTS `imagens_produto`;
CREATE TABLE IF NOT EXISTS `imagens_produto` (
  `id_imagem` int NOT NULL AUTO_INCREMENT,
  `id_produto` int NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordem` int DEFAULT '1',
  `data_cadastro` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_imagem`),
  KEY `fk_imagens_produto_produtos` (`id_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `imagens_produto`
--

INSERT INTO `imagens_produto` (`id_imagem`, `id_produto`, `url`, `ordem`, `data_cadastro`) VALUES
(1, 1, 'img/produtos/smartphone_x_1.jpg', 1, '2025-11-26 21:38:08'),
(2, 1, 'img/produtos/smartphone_x_2.jpg', 2, '2025-11-26 21:38:08'),
(3, 2, 'img/produtos/camiseta_branca_1.jpg', 1, '2025-11-26 21:38:08'),
(4, 3, 'img/produtos/livro_sql_1.jpg', 1, '2025-11-26 21:38:08');

-- --------------------------------------------------------

--
-- Estrutura para tabela `marcas`
--

DROP TABLE IF EXISTS `marcas`;
CREATE TABLE IF NOT EXISTS `marcas` (
  `id_marca` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT '1',
  `data_cadastro` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_marca`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `marcas`
--

INSERT INTO `marcas` (`id_marca`, `nome`, `site`, `logo_url`, `ativo`, `data_cadastro`) VALUES
(1, 'TechMaster', 'https://www.techmaster.com', 'img/marcas/techmaster.png', 1, '2025-11-26 21:38:08'),
(2, 'ModaBrasil', 'https://www.modabrasil.com', 'img/marcas/modabrasil.png', 1, '2025-11-26 21:38:08'),
(3, 'Editora Saber', 'https://www.editorasaber.com', 'img/marcas/editorasaber.png', 1, '2025-11-26 21:38:08'),
(6, 'Nike', 'https://www.nike.com.br/', 'https://www.nike.com.br/images/meta/open-graph-main-image.jpg', 1, '2025-12-10 21:27:41');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `id_produto` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci,
  `preco` decimal(10,2) NOT NULL,
  `estoque` int DEFAULT '0',
  `id_categoria` int DEFAULT NULL,
  `id_marca` int DEFAULT NULL,
  `imagem_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT '1',
  `data_cadastro` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_produto`),
  KEY `idx_produtos_categoria` (`id_categoria`),
  KEY `idx_produtos_marca` (`id_marca`),
  KEY `idx_produtos_nome` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id_produto`, `nome`, `descricao`, `preco`, `estoque`, `id_categoria`, `id_marca`, `imagem_url`, `ativo`, `data_cadastro`, `data_atualizacao`) VALUES
(1, 'Smartphone X', 'Smartphone com 128GB de armazenamento', 1999.90, 10, 1, 1, 'img/produtos/smartphone_x.jpg', 1, '2025-11-26 21:38:08', '2025-11-26 21:38:08'),
(2, 'Camiseta Branca', 'Camiseta 100% algodão', 49.90, 50, 2, 2, 'img/produtos/camiseta_branca.jpg', 1, '2025-11-26 21:38:08', '2025-11-26 21:38:08'),
(3, 'Livro de SQL', 'Guia prático de SQL para iniciantes', 79.90, 20, 3, 3, 'img/produtos/livro_sql.jpg', 1, '2025-11-26 21:38:08', '2025-11-26 21:38:08'),
(5, 'O Pequeno Príncipe', '“O essencial é invisível aos olhos ...\" O Pequeno Príncipe é uma das obras literárias mais lidas no mundo e isto se deve à sua capacidade de relevar, a cada pessoa, significados diferentes, profundos, diante de uma história aparentemente simples. Nesta nova edição, você terá a chance de revisitar asteroides, planetas e baobás, encontrar uma certa raposa e admirar uma rosa muito especial.', 27.95, 10, 3, 3, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSH0aAG9EWkKU-3RUu3WJPfKE4_dcwuIQPbSA&s', 1, '2025-12-10 21:25:02', '2025-12-10 21:25:02'),
(6, 'Nike Tênis masculino Air Jordan 1 Mid', 'Sobre este item\r\nCabedal de couro durável: oferece estrutura e uma sensação premium\r\nAbsorção de impacto: a tecnologia Nike Air amortece cada passo\r\nAmortecimento leve: espuma macia na entressola\r\nTração durável: sola de borracha para aderência\r\nTamanho: listado nos tamanhos masculinos dos EUA', 1320.81, 10, 4, 6, 'https://images-cdn.ubuy.co.in/66190f8480afbb4dc6116c05-nike-air-jordan-1-mid-pollen-yellow.jpg', 1, '2025-12-10 21:30:40', '2025-12-10 21:30:40');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios_admin`
--

DROP TABLE IF EXISTS `usuarios_admin`;
CREATE TABLE IF NOT EXISTS `usuarios_admin` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `perfil` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'admin',
  `ativo` tinyint(1) DEFAULT '1',
  `data_cadastro` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios_admin`
--

INSERT INTO `usuarios_admin` (`id_usuario`, `nome`, `email`, `senha_hash`, `perfil`, `ativo`, `data_cadastro`) VALUES
(1, 'Admin Padrão', 'admin@admin', 'admin@admin', 'admin', 1, '2025-11-26 21:38:08');

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `imagens_produto`
--
ALTER TABLE `imagens_produto`
  ADD CONSTRAINT `fk_imagens_produto_produtos` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`);

--
-- Restrições para tabelas `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `fk_produtos_categorias` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`),
  ADD CONSTRAINT `fk_produtos_marcas` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id_marca`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

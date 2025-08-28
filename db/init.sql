-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Tempo de geração: 22/08/2025 às 22:54
-- Versão do servidor: 8.4.6
-- Versão do PHP: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `furia_chat`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int NOT NULL,
  `autor_id` int NOT NULL,
  `conteudo` text NOT NULL,
  `slug` varchar(255) NOT NULL,
  `data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name_autor` varchar(100) NOT NULL,
  `img_autor` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `comentarios`
--

INSERT INTO `comentarios` (`id`, `autor_id`, `conteudo`, `slug`, `data`, `name_autor`, `img_autor`) VALUES
(1, 1, 'Achei essa nova camisa sensacional! Muito melhor que a anterior.', 'nova-camisa-furia-2025', '2025-05-04 14:36:02', 'Caio Emanoel', '1745956717_perfil.jpg'),
(2, 1, 'Será que vai ter versão feminina também?', 'nova-camisa-furia-2025', '2025-05-04 14:36:02', 'Caio Emanoel', '1745956717_perfil.jpg'),
(3, 1, 'MUITO FODA', 'nova-camisa-furia-2025', '2025-05-04 16:26:14', 'Caio Emanoel', '1745956717_perfil.jpg'),
(7, 2, 'VAMOS FURIA', 'nova-camisa-furia-2025', '2025-05-04 16:41:07', 'Luiza Bueno', ''),
(8, 1, 'SHOW!!', 'nova-camisa-furia-2025', '2025-05-04 21:41:55', 'Caio Emanoel', '1745956717_perfil.jpg'),
(9, 1, 'VAMOOOO', 'nova-camisa-furia-2025', '2025-05-04 21:44:20', 'Caio Emanoel', '1745956717_perfil.jpg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `mensagens`
--

CREATE TABLE `mensagens` (
  `id` int NOT NULL,
  `remetente_id` int NOT NULL,
  `destinatario_id` int NOT NULL,
  `content` text NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `mensagens`
--

INSERT INTO `mensagens` (`id`, `remetente_id`, `destinatario_id`, `content`, `timestamp`) VALUES
(1, 3, 2, 'oi', '2025-08-22 21:54:48'),
(2, 3, 2, 'Oii, como vai a família', '2025-08-22 21:54:53'),
(3, 5, 1, 'oii', '2025-08-22 22:14:12'),
(4, 5, 1, 'Como vai?', '2025-08-22 22:14:16'),
(5, 1, 5, 'oii', '2025-08-22 22:14:36'),
(6, 1, 5, 'Tudo bem, e vc?', '2025-08-22 22:14:41');

-- --------------------------------------------------------

--
-- Estrutura para tabela `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `subtitulo` varchar(100) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `conteudo` text NOT NULL,
  `slug` varchar(255) NOT NULL,
  `autor_id` int NOT NULL,
  `data_publicacao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `imagem` varchar(255) DEFAULT NULL,
  `autor_nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `posts`
--

INSERT INTO `posts` (`id`, `titulo`, `subtitulo`, `categoria`, `conteudo`, `slug`, `autor_id`, `data_publicacao`, `imagem`, `autor_nome`) VALUES
(1, 'Nova Camisa da Fúria 2025 Revelada!', 'A organização Fúria eSports acaba...', 'furia', 'A Fúria acaba de lançar sua nova camisa para a temporada 2025. Com um design arrojado e novas tecnologias de tecido, a camisa promete ser um sucesso entre os torcedores.', 'nova-camisa-furia-2025', 1, '2025-05-04 14:35:00', 'http://127.0.0.1:8080/uploads/postsImg/camisa2025.png', ''),
(2, 'LTA Sul 2025 | FURIA, RED, paiN e Vivo Keyd dominam a MD3', 'As principais organizações brasileiras garantem vitórias sólidas na fase de grupos da LTA Sul 2025.', 'CS2', 'Na terceira rodada da LTA Sul 2025, as equipes brasileiras mostraram sua força. FURIA, RED Canids, paiN Gaming e Vivo Keyd conquistaram vitórias decisivas em suas séries melhor de três (MD3), consolidando-se como favoritas no torneio.\r\nOs resultados reforçam o domínio do cenário nacional na competição, deixando os torcedores animados para os próximos confrontos. Com atuações consistentes e estratégias bem executadas, as organizações brasileiras seguem firmes na busca pelo título sul-americano.', 'lta-sul-2025-furia-red-pain-vivo-keyd-dominam-md3', 1, '2025-08-22 22:51:21', 'http://127.0.0.1:8080/uploads/postsImg/1755903081_1746231479_LTA-Sul-2025-1024x576.webp', 'caio');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `img` varchar(100) DEFAULT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0',
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `img`, `isAdmin`, `password`) VALUES
(1, 'caio', 'caio@emanoel', NULL, 1, '$2y$10$s6dV2Kh.5Wdr8vpkRqe7EO6j8oL58GQajfQd7ypoMvyzGcmr7pu8.'),
(4, 'Giovanna Modesto', 'giovanna@modesto', NULL, 0, '$2y$10$A0Fz2pCXAx3biJVTS/PKo.p2BoMjvuz0dQ1egOb3o2YB98spzpIzu'),
(5, 'Cintia Rosana ', 'cintia@rosana', NULL, 0, '$2y$10$Jdsrt6niALXvcuG6C7m5zOu3mC0k3YT/m0LnGzNBSodRnRmZUAObq');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `mensagens`
--
ALTER TABLE `mensagens`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `mensagens`
--
ALTER TABLE `mensagens`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

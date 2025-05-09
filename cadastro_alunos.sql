-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 09/05/2025 às 21:50
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `cadastro_alunos`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `alunos`
--

CREATE TABLE `alunos` (
  `matricula` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `RG` varchar(20) NOT NULL,
  `CPF` varchar(14) NOT NULL,
  `foto_url` varchar(255) DEFAULT NULL,
  `data_nascimento` date NOT NULL,
  `sexo` enum('feminino','masculino','outro') NOT NULL,
  `responsavel` varchar(255) NOT NULL,
  `estado` enum('ativo','inativo') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `alunos`
--

INSERT INTO `alunos` (`matricula`, `nome`, `RG`, `CPF`, `foto_url`, `data_nascimento`, `sexo`, `responsavel`, `estado`) VALUES
(235301, 'Alicia Silva', '32.234.032-2', '523.812.283-23', '', '2007-05-23', 'feminino', 'Mariana Silva', 'ativo'),
(740338, 'Giovanna Alvez', '32.234.813-2', '523.389.923-23', '', '2007-08-04', 'masculino', 'Pedro Henrique', 'ativo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `contas`
--

CREATE TABLE `contas` (
  `id_contas` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `contas`
--

INSERT INTO `contas` (`id_contas`, `email`, `senha`) VALUES
(5, 'gustavo@gmail.com', '$2y$10$W24EZCbeIUOlYXKjwF/MCeAzJOja2J8qqUI/h1wTl1a65GsvImxz6'),
(7, 'lavinia@gmail.com', '$2y$10$vpED1lz45CSYq35.6sEIu.5CorYDMsrCz99aywY2E9RvRa41TpC2K'),
(9, 'nathalia@gmail.com', '$2y$10$vHqjmtIXtguYJP4rYLoVf./KQ.3u2TL9heB0YQ5yihex56qZxx7kC'),
(10, 'amanda@gmail.com', '$2y$10$00HS.Pki2fz/5lkiqV4MXO7ELKP0iIX.NLVaclaKuE5Sbmkb6cP/.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cursos`
--

CREATE TABLE `cursos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `carga_horaria` int(11) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cursos`
--

INSERT INTO `cursos` (`id`, `nome`, `carga_horaria`, `descricao`) VALUES
(1, 'Robotica II', 120, 'Desmontando Hardware');

-- --------------------------------------------------------

--
-- Estrutura para tabela `dados_matricula`
--

CREATE TABLE `dados_matricula` (
  `id` int(11) NOT NULL,
  `matricula` int(11) NOT NULL,
  `turma_id` int(11) NOT NULL,
  `inicio` date NOT NULL,
  `termino` date NOT NULL,
  `curso_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `dados_matricula`
--

INSERT INTO `dados_matricula` (`id`, `matricula`, `turma_id`, `inicio`, `termino`, `curso_id`) VALUES
(1, 235301, 1, '2024-02-14', '2024-11-02', NULL),
(3, 740338, 1, '2024-02-12', '2024-11-02', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `turmas`
--

CREATE TABLE `turmas` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `tipo_ensino` enum('fundamental','medio','curso') NOT NULL,
  `periodo` enum('manhã','tarde','noite') NOT NULL,
  `curso_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `turmas`
--

INSERT INTO `turmas` (`id`, `nome`, `tipo_ensino`, `periodo`, `curso_id`) VALUES
(1, '2 série C', 'medio', 'tarde', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `alunos`
--
ALTER TABLE `alunos`
  ADD PRIMARY KEY (`matricula`),
  ADD UNIQUE KEY `RG` (`RG`),
  ADD UNIQUE KEY `CPF` (`CPF`);

--
-- Índices de tabela `contas`
--
ALTER TABLE `contas`
  ADD PRIMARY KEY (`id_contas`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `dados_matricula`
--
ALTER TABLE `dados_matricula`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matricula` (`matricula`),
  ADD KEY `turma_id` (`turma_id`);

--
-- Índices de tabela `turmas`
--
ALTER TABLE `turmas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_curso_id` (`curso_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `contas`
--
ALTER TABLE `contas`
  MODIFY `id_contas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `dados_matricula`
--
ALTER TABLE `dados_matricula`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `turmas`
--
ALTER TABLE `turmas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `dados_matricula`
--
ALTER TABLE `dados_matricula`
  ADD CONSTRAINT `dados_matricula_ibfk_1` FOREIGN KEY (`matricula`) REFERENCES `alunos` (`matricula`),
  ADD CONSTRAINT `dados_matricula_ibfk_2` FOREIGN KEY (`turma_id`) REFERENCES `turmas` (`id`);

--
-- Restrições para tabelas `turmas`
--
ALTER TABLE `turmas`
  ADD CONSTRAINT `fk_curso_id` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

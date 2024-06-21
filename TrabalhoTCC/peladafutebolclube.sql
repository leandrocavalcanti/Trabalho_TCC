-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 09/12/2023 às 14:00
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `peladafutebolclube`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `dadosjogador`
--

CREATE TABLE `dadosjogador` (
  `idDadosJogador` int(11) NOT NULL,
  `vlrMedia` int(11) DEFAULT NULL,
  `qtdGols` int(11) DEFAULT NULL,
  `qtdVitoria` int(11) DEFAULT NULL,
  `qtdDerrotas` int(11) DEFAULT NULL,
  `jogador_idJogador` int(11) NOT NULL,
  `qtdPartida` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `dadosjogador`
--

INSERT INTO `dadosjogador` (`idDadosJogador`, `vlrMedia`, `qtdGols`, `qtdVitoria`, `qtdDerrotas`, `jogador_idJogador`, `qtdPartida`) VALUES
(25, 4, 6, 10, 11, 6, 21);

-- --------------------------------------------------------

--
-- Estrutura para tabela `grupo`
--

CREATE TABLE `grupo` (
  `idGrupo` int(11) NOT NULL,
  `nomeGrupo` varchar(45) NOT NULL,
  `diaSemana` varchar(20) NOT NULL,
  `horaJogo` time NOT NULL,
  `descricaoGrupo` varchar(300) NOT NULL,
  `idCriador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `grupo`
--

INSERT INTO `grupo` (`idGrupo`, `nomeGrupo`, `diaSemana`, `horaJogo`, `descricaoGrupo`, `idCriador`) VALUES
(1, 'Morgados F.C', 'Quinta-feira', '20:30:00', 'vamos animar!!!', 0),
(2, 'boleiros', 'Terça-feira', '19:10:00', 'joga y joga', 0),
(4, 'Boleiros', 'Quaerta-feira', '19:00:00', 'joga', 6);

-- --------------------------------------------------------

--
-- Estrutura para tabela `grupo_has_jogador`
--

CREATE TABLE `grupo_has_jogador` (
  `grupo_idGrupo` int(11) NOT NULL,
  `jogador_idJogador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `grupo_has_jogador`
--

INSERT INTO `grupo_has_jogador` (`grupo_idGrupo`, `jogador_idJogador`) VALUES
(1, 1),
(1, 5),
(1, 6),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(3, 6),
(4, 6),
(5, 6);

-- --------------------------------------------------------

--
-- Estrutura para tabela `jogador`
--

CREATE TABLE `jogador` (
  `idJogador` int(11) NOT NULL,
  `nomeJogador` varchar(50) DEFAULT NULL,
  `idadeJogador` int(11) DEFAULT NULL,
  `telefoneJogador` varchar(11) DEFAULT NULL,
  `emailJogador` varchar(45) DEFAULT NULL,
  `senhaJogador` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `jogador`
--

INSERT INTO `jogador` (`idJogador`, `nomeJogador`, `idadeJogador`, `telefoneJogador`, `emailJogador`, `senhaJogador`) VALUES
(1, 'ABELARDA', 8, '61991502146', 'BELARDA@GMAIL.COM', '1234'),
(5, 'poli', 29, '6133949914', 'poli@gmail.com', '123456'),
(6, 'leo', 28, '61991857078', 'leo@gmail.com', '1802'),
(9, 'Bito', 15, '61999999999', 'bito@gmail.com', '123456'),
(10, 'petim', 12, '61999998887', 'petim@gmail.com', '1234'),
(11, 'fonfon', 12, '61878945646', 'fonfon@gmail.com', '1234'),
(12, 'menina', 12, '2154875368', 'menina@gmail.com', '1234');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `dadosjogador`
--
ALTER TABLE `dadosjogador`
  ADD PRIMARY KEY (`idDadosJogador`,`jogador_idJogador`);

--
-- Índices de tabela `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`idGrupo`);

--
-- Índices de tabela `grupo_has_jogador`
--
ALTER TABLE `grupo_has_jogador`
  ADD PRIMARY KEY (`grupo_idGrupo`,`jogador_idJogador`);

--
-- Índices de tabela `jogador`
--
ALTER TABLE `jogador`
  ADD PRIMARY KEY (`idJogador`),
  ADD UNIQUE KEY `UNIQUE` (`emailJogador`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `dadosjogador`
--
ALTER TABLE `dadosjogador`
  MODIFY `idDadosJogador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `grupo`
--
ALTER TABLE `grupo`
  MODIFY `idGrupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `jogador`
--
ALTER TABLE `jogador`
  MODIFY `idJogador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

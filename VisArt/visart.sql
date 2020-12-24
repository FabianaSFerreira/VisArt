-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 25-Ago-2020 às 22:57
-- Versão do servidor: 10.1.38-MariaDB
-- versão do PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `visart`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `artes`
--

CREATE TABLE `artes` (
  `IdArte` int(11) NOT NULL,
  `IdTipo` int(11) NOT NULL,
  `IdUsuario` int(11) NOT NULL,
  `TituloArte` varchar(50) NOT NULL,
  `LocalArquivo` varchar(100) NOT NULL,
  `Descricao` varchar(500) NOT NULL,
  `Curtidas` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `artes`
--

INSERT INTO `artes` (`IdArte`, `IdTipo`, `IdUsuario`, `TituloArte`, `LocalArquivo`, `Descricao`, `Curtidas`) VALUES
(1, 1, 1, 'Arte 1', 'Arquivos/Pintura/5f277114ebf91.jpg', 'Teste - arte 1', 7),
(2, 2, 2, 'Arte 2', 'Arquivos/Escultura/5f277140e6d80.jpg', 'Teste - arte 2', 4),
(3, 3, 2, 'Arte 3', 'Arquivos/Fotografia/5f2771569c3bd.jpg', 'Teste - arte 3', 6),
(4, 4, 1, 'Arte 4', 'Arquivos/Audiovisual/5f27717148cae.jpg', 'Teste - arte 4', 9),
(5, 5, 1, 'Arte 5', 'Arquivos/Artes Graficas/5f2771876b96e.jpg', 'Teste - arte 5', 5),
(6, 6, 2, 'Arte 6', 'Arquivos/Historias em Quadrinhos/5f2771a5488a0.jpg', 'Teste - arte 6', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `artes_comentarios`
--

CREATE TABLE `artes_comentarios` (
  `IdComentario` int(11) NOT NULL,
  `IdUsuario` int(11) NOT NULL,
  `IdArte` int(11) NOT NULL,
  `Texto` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `artes_comentarios`
--

INSERT INTO `artes_comentarios` (`IdComentario`, `IdUsuario`, `IdArte`, `Texto`) VALUES
(2, 1, 1, 'comentario');

-- --------------------------------------------------------

--
-- Estrutura da tabela `artes_tipos`
--

CREATE TABLE `artes_tipos` (
  `IdTipo` int(11) NOT NULL,
  `Nome` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `artes_tipos`
--

INSERT INTO `artes_tipos` (`IdTipo`, `Nome`) VALUES
(1, 'Pintura'),
(2, 'Escultura'),
(3, 'Fotografia'),
(4, 'Audiovisual'),
(5, 'Artes Graficas'),
(6, 'Historias em Quadrinhos');

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupos`
--

CREATE TABLE `grupos` (
  `IdGrupo` int(11) NOT NULL,
  `Administrador` int(11) NOT NULL,
  `LocalImagem` varchar(100) NOT NULL,
  `TituloGrupo` varchar(20) NOT NULL,
  `Descricao` varchar(500) NOT NULL,
  `Status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `grupos`
--

INSERT INTO `grupos` (`IdGrupo`, `Administrador`, `LocalImagem`, `TituloGrupo`, `Descricao`, `Status`) VALUES
(1, 1, 'Arquivos/Grupos/5f2772476e3e3.jpg', 'Grupo 1', 'Teste - grupo 1', 'aberto'),
(2, 2, 'Arquivos/Grupos/5f27725b357d1.jpg', 'Grupo 2', 'Teste - grupo 2', 'fechado'),
(3, 1, 'Arquivos/Grupos/5f27726d6930c.jpg', 'Grupo 3', 'Teste - grupo 3', 'aberto'),
(4, 2, 'Arquivos/Grupos/5f27727f144dd.jpg', 'Grupo 4', 'Teste - grupo 4', 'fechado'),
(5, 1, 'Arquivos/Grupos/5f2772b0b86b0.jpg', 'Grupo 5', 'Teste - grupo 5', 'aberto'),
(6, 1, 'Arquivos/Grupos/5f2772c2b1f0a.jpg', 'Grupo 6', 'Teste - grupo 6', 'fechado'),
(7, 2, 'Arquivos/Grupos/5f277353aed87.jpg', 'Grupo 7', 'Teste - grupo 7', 'aberto');

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupos_mensagens`
--

CREATE TABLE `grupos_mensagens` (
  `IdMensagem` int(11) NOT NULL,
  `IdUsuario` int(11) NOT NULL,
  `IdGrupo` int(11) NOT NULL,
  `Texto` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `grupos_mensagens`
--

INSERT INTO `grupos_mensagens` (`IdMensagem`, `IdUsuario`, `IdGrupo`, `Texto`) VALUES
(1, 1, 1, 'mensagem');

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupos_usuarios`
--

CREATE TABLE `grupos_usuarios` (
  `IdGrupo` int(11) NOT NULL,
  `IdUsuario` int(11) NOT NULL,
  `Solicitacao` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `grupos_usuarios`
--

INSERT INTO `grupos_usuarios` (`IdGrupo`, `IdUsuario`, `Solicitacao`) VALUES
(1, 1, 0),
(1, 2, 0),
(2, 2, 0),
(3, 1, 0),
(4, 1, 1),
(4, 2, 0),
(5, 1, 0),
(6, 1, 0),
(7, 2, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `IdUsuario` int(11) NOT NULL,
  `Usuario` varchar(30) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Nome` varchar(30) NOT NULL,
  `Senha` varchar(10) NOT NULL,
  `LocalFoto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`IdUsuario`, `Usuario`, `Email`, `Nome`, `Senha`, `LocalFoto`) VALUES
(1, 'Fabi_Ferreira', 'fabiana.ferreira.ti@gmail.com', 'Fabiana Ferreira', 'VisArt2020', 'Arquivos/Perfil/5f243caf534f2.jpg'),
(2, 'Us_2', 'usuario2@gmail.com', 'Usuario 2', '123', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artes`
--
ALTER TABLE `artes`
  ADD PRIMARY KEY (`IdArte`),
  ADD KEY `IdUsuario` (`IdUsuario`) USING BTREE,
  ADD KEY `IdTipo` (`IdTipo`) USING BTREE;

--
-- Indexes for table `artes_comentarios`
--
ALTER TABLE `artes_comentarios`
  ADD PRIMARY KEY (`IdComentario`),
  ADD KEY `IdArte` (`IdArte`,`IdUsuario`),
  ADD KEY `IdUsuario` (`IdUsuario`) USING BTREE;

--
-- Indexes for table `artes_tipos`
--
ALTER TABLE `artes_tipos`
  ADD PRIMARY KEY (`IdTipo`);

--
-- Indexes for table `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`IdGrupo`),
  ADD KEY `Administrador` (`Administrador`);

--
-- Indexes for table `grupos_mensagens`
--
ALTER TABLE `grupos_mensagens`
  ADD PRIMARY KEY (`IdMensagem`),
  ADD KEY `IdGrupo` (`IdGrupo`),
  ADD KEY `IdUsuario` (`IdUsuario`) USING BTREE;

--
-- Indexes for table `grupos_usuarios`
--
ALTER TABLE `grupos_usuarios`
  ADD PRIMARY KEY (`IdGrupo`,`IdUsuario`),
  ADD KEY `IdGrupo` (`IdGrupo`,`IdUsuario`),
  ADD KEY `membros_grupo_ibfk_2` (`IdUsuario`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`IdUsuario`),
  ADD UNIQUE KEY `Usuario` (`Usuario`,`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artes`
--
ALTER TABLE `artes`
  MODIFY `IdArte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `artes_comentarios`
--
ALTER TABLE `artes_comentarios`
  MODIFY `IdComentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `artes_tipos`
--
ALTER TABLE `artes_tipos`
  MODIFY `IdTipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `grupos`
--
ALTER TABLE `grupos`
  MODIFY `IdGrupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `grupos_mensagens`
--
ALTER TABLE `grupos_mensagens`
  MODIFY `IdMensagem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `IdUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `artes`
--
ALTER TABLE `artes`
  ADD CONSTRAINT `artes_ibfk_1` FOREIGN KEY (`IdTipo`) REFERENCES `artes_tipos` (`IdTipo`),
  ADD CONSTRAINT `artes_ibfk_2` FOREIGN KEY (`IdUsuario`) REFERENCES `usuarios` (`IdUsuario`);

--
-- Limitadores para a tabela `artes_comentarios`
--
ALTER TABLE `artes_comentarios`
  ADD CONSTRAINT `artes_comentarios_ibfk_1` FOREIGN KEY (`IdArte`) REFERENCES `artes` (`IdArte`),
  ADD CONSTRAINT `artes_comentarios_ibfk_2` FOREIGN KEY (`IdUsuario`) REFERENCES `usuarios` (`IdUsuario`);

--
-- Limitadores para a tabela `grupos`
--
ALTER TABLE `grupos`
  ADD CONSTRAINT `grupos_ibfk_1` FOREIGN KEY (`Administrador`) REFERENCES `usuarios` (`IdUsuario`);

--
-- Limitadores para a tabela `grupos_mensagens`
--
ALTER TABLE `grupos_mensagens`
  ADD CONSTRAINT `grupos_mensagens_ibfk_1` FOREIGN KEY (`IdGrupo`) REFERENCES `grupos` (`IdGrupo`),
  ADD CONSTRAINT `grupos_mensagens_ibfk_2` FOREIGN KEY (`IdUsuario`) REFERENCES `usuarios` (`IdUsuario`);

--
-- Limitadores para a tabela `grupos_usuarios`
--
ALTER TABLE `grupos_usuarios`
  ADD CONSTRAINT `grupos_usuarios_ibfk_1` FOREIGN KEY (`IdGrupo`) REFERENCES `grupos` (`IdGrupo`),
  ADD CONSTRAINT `grupos_usuarios_ibfk_2` FOREIGN KEY (`IdUsuario`) REFERENCES `usuarios` (`IdUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
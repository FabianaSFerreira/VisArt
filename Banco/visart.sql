-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16-Mar-2021 às 04:23
-- Versão do servidor: 10.4.16-MariaDB
-- versão do PHP: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `visart`
--

DELIMITER $$
--
-- Funções
--
CREATE DEFINER=`root`@`localhost` FUNCTION `fun_valida_usuario` (`p_login` VARCHAR(20), `p_senha` VARCHAR(50)) RETURNS INT(1) BEGIN DECLARE l_ret INT(1) DEFAULT 0;  
                SET l_ret = IFNULL((SELECT DISTINCT 1 FROM usuarios WHERE usuario = p_usuario AND senha = MD5(p_senha)),0);                           
                RETURN l_ret; 
END$$

DELIMITER ;

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
  `Curtidas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `artes`
--

INSERT INTO `artes` (`IdArte`, `IdTipo`, `IdUsuario`, `TituloArte`, `LocalArquivo`, `Descricao`, `Curtidas`) VALUES
(1, 1, 1, 'Teste Pintura', 'Arquivos/Pintura/5f277114ebf91.jpg', 'Pintura a óleo', 0),
(2, 2, 2, 'Teste Escultura', 'Arquivos/Escultura/5f277140e6d80.jpg', 'Black Tie 8 cabeças, 2009 – 2011', 0),
(3, 3, 2, 'Teste Fotografia', 'Arquivos/Fotografia/5f2771569c3bd.jpg', 'Primavera no Japão - O espetáculo da flor de cerejeira', 0),
(4, 4, 1, 'Teste Video', 'Arquivos/Audiovisual/5f5cfc836699d.mp4', 'Teste - video ', 0),
(5, 5, 1, 'Teste Artes Graficas', 'Arquivos/Artes Graficas/5f2771876b96e.jpg', 'Hemisférios do cérebro', 1),
(6, 6, 2, 'Teste WebComic', 'Arquivos/HQs & WebComics/5f2771a5488a0.jpg', 'WebComic - Love Like Cherry Blossoms', 0),
(7, 3, 1, 'Teste 2 - Fotografia', 'Arquivos/Fotografia/60330d0bda427.jpg', 'teste - fotografia paisagem', 0),
(8, 1, 2, 'Teste 2 - Desenho', 'Arquivos/Pintura/60330d58e039f.jpg', 'teste - desenho manual', 0);

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
(1, 1, 1, 'comentario'),
(2, 2, 1, 'comentario 2'),
(3, 1, 1, 'comentario 3'),
(4, 2, 1, 'comentario 4');

-- --------------------------------------------------------

--
-- Estrutura da tabela `artes_curtidas`
--

CREATE TABLE `artes_curtidas` (
  `IdArte` int(11) NOT NULL,
  `IdUsuario` int(11) NOT NULL,
  `Curtida` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `artes_curtidas`
--

INSERT INTO `artes_curtidas` (`IdArte`, `IdUsuario`, `Curtida`) VALUES
(1, 1, 1),
(5, 1, 1);

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
(6, 'HQs & WebComics');

-- --------------------------------------------------------

--
-- Estrutura da tabela `evento`
--

CREATE TABLE `evento` (
  `IdEvento` int(11) NOT NULL,
  `IdUsuario` int(11) NOT NULL,
  `NomeEvento` varchar(50) NOT NULL,
  `Organizador` varchar(200) NOT NULL,
  `Endereco` varchar(200) NOT NULL,
  `Data` date NOT NULL,
  `Hora` time NOT NULL,
  `Descricao` varchar(500) NOT NULL,
  `LocalImagem` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `evento`
--

INSERT INTO `evento` (`IdEvento`, `IdUsuario`, `NomeEvento`, `Organizador`, `Endereco`, `Data`, `Hora`, `Descricao`, `LocalImagem`) VALUES
(1, 1, 'Evento - teste 1', 'Fabiana Ferreira e Sheila Silveira', 'Rua, 000 - Bairro, Cidade - RS, CEP', '2021-04-20', '20:00:00', 'teste teste teste', 'Arquivos/Eventos/5fdd497d7bd74.jpg'),
(2, 1, 'Evento - teste 2', 'Danielle da Silveira de Souza', 'Rua, 000 - Bairro, Cidade - RS, CEP', '2021-05-03', '18:30:00', 'teste teste teste', 'Arquivos/Eventos/f9441abc32574.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `eventos_usuarios`
--

CREATE TABLE `eventos_usuarios` (
  `IdEvento` int(11) NOT NULL,
  `IdUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `eventos_usuarios`
--

INSERT INTO `eventos_usuarios` (`IdEvento`, `IdUsuario`) VALUES
(1, 1),
(2, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupos`
--

CREATE TABLE `grupos` (
  `IdGrupo` int(11) NOT NULL,
  `TituloGrupo` varchar(20) NOT NULL,
  `Administrador` int(11) NOT NULL,
  `Descricao` varchar(500) NOT NULL,
  `Status` varchar(10) NOT NULL,
  `LocalImagem` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `grupos`
--

INSERT INTO `grupos` (`IdGrupo`, `TituloGrupo`, `Administrador`, `Descricao`, `Status`, `LocalImagem`) VALUES
(1, 'Grupo 1', 1, 'Teste - grupo 1', 'aberto', 'Arquivos/Grupos/5f2772476e3e3.jpg'),
(2, 'Grupo 2', 2, 'Teste - grupo 2', 'fechado', 'Arquivos/Grupos/5f27725b357d1.jpg'),
(3, 'Grupo 3', 1, 'Teste - grupo 3', 'aberto', 'Arquivos/Grupos/5f27726d6930c.jpg'),
(4, 'Grupo 4', 2, 'Teste - grupo 4', 'fechado', 'Arquivos/Grupos/5f27727f144dd.jpg'),
(5, 'Grupo 5', 1, 'Teste - grupo 5', 'aberto', 'Arquivos/Grupos/5f2772b0b86b0.jpg'),
(6, 'Grupo 6', 1, 'Teste - grupo 6', 'fechado', 'Arquivos/Grupos/5f2772c2b1f0a.jpg'),
(7, 'Grupo 7', 2, 'Teste - grupo 7', 'aberto', 'Arquivos/Grupos/5f277353aed87.jpg');

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
(1, 1, 1, 'mensagem - teste 1'),
(2, 2, 1, 'mensagem - teste 2'),
(3, 1, 1, 'mensagem - teste 3'),
(4, 1, 1, 'mensagem - teste 4');

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
(2, 1, 0),
(2, 2, 0),
(3, 1, 0),
(4, 2, 0),
(5, 1, 0),
(6, 1, 0),
(7, 1, 0),
(7, 2, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `IdUsuario` int(11) NOT NULL,
  `Usuario` varchar(30) NOT NULL,
  `Nome` varchar(30) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Senha` varchar(32) NOT NULL,
  `LocalFoto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`IdUsuario`, `Usuario`, `Nome`, `Email`, `Senha`, `LocalFoto`) VALUES
(1, 'Fabi_Ferreira', 'Fabiana Ferreira', 'fabiana.ferreira.ti@gmail.com', 'c6550818f6c2283e88311273d204b027', 'Arquivos/Perfil/5f2772b0b86b0.jpg'),
(2, 'Us_2', 'Usuario 2', 'usuario2@gmail.com', '202cb962ac59075b964b07152d234b70', 'Arquivos/Perfil/5fdd497d7bd74.jpg'),
(3, 'Us_3', 'Usuario 3', 'usuario3@gmail.com', '202cb962ac59075b964b07152d234b70', '');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `artes`
--
ALTER TABLE `artes`
  ADD PRIMARY KEY (`IdArte`),
  ADD KEY `IdUsuario` (`IdUsuario`) USING BTREE,
  ADD KEY `IdTipo` (`IdTipo`) USING BTREE;

--
-- Índices para tabela `artes_comentarios`
--
ALTER TABLE `artes_comentarios`
  ADD PRIMARY KEY (`IdComentario`),
  ADD KEY `IdArte` (`IdArte`,`IdUsuario`),
  ADD KEY `IdUsuario` (`IdUsuario`) USING BTREE;

--
-- Índices para tabela `artes_curtidas`
--
ALTER TABLE `artes_curtidas`
  ADD PRIMARY KEY (`IdArte`,`IdUsuario`),
  ADD KEY `INDEX` (`IdArte`,`IdUsuario`) USING BTREE;

--
-- Índices para tabela `artes_tipos`
--
ALTER TABLE `artes_tipos`
  ADD PRIMARY KEY (`IdTipo`);

--
-- Índices para tabela `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`IdEvento`),
  ADD KEY `IdUsuario` (`IdUsuario`);

--
-- Índices para tabela `eventos_usuarios`
--
ALTER TABLE `eventos_usuarios`
  ADD PRIMARY KEY (`IdEvento`,`IdUsuario`),
  ADD KEY `IdEvento` (`IdEvento`,`IdUsuario`),
  ADD KEY `IdUsuario` (`IdUsuario`);

--
-- Índices para tabela `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`IdGrupo`),
  ADD KEY `Administrador` (`Administrador`);

--
-- Índices para tabela `grupos_mensagens`
--
ALTER TABLE `grupos_mensagens`
  ADD PRIMARY KEY (`IdMensagem`),
  ADD KEY `IdGrupo` (`IdGrupo`),
  ADD KEY `IdUsuario` (`IdUsuario`) USING BTREE;

--
-- Índices para tabela `grupos_usuarios`
--
ALTER TABLE `grupos_usuarios`
  ADD PRIMARY KEY (`IdGrupo`,`IdUsuario`),
  ADD KEY `IdGrupo` (`IdGrupo`,`IdUsuario`),
  ADD KEY `membros_grupo_ibfk_2` (`IdUsuario`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`IdUsuario`),
  ADD UNIQUE KEY `Usuario` (`Usuario`,`Email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `artes`
--
ALTER TABLE `artes`
  MODIFY `IdArte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `artes_comentarios`
--
ALTER TABLE `artes_comentarios`
  MODIFY `IdComentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `artes_tipos`
--
ALTER TABLE `artes_tipos`
  MODIFY `IdTipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `evento`
--
ALTER TABLE `evento`
  MODIFY `IdEvento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `grupos`
--
ALTER TABLE `grupos`
  MODIFY `IdGrupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `grupos_mensagens`
--
ALTER TABLE `grupos_mensagens`
  MODIFY `IdMensagem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `IdUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para despejos de tabelas
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
-- Limitadores para a tabela `artes_curtidas`
--
ALTER TABLE `artes_curtidas`
  ADD CONSTRAINT `artes_curtidas_ibfk_1` FOREIGN KEY (`IdArte`) REFERENCES `artes` (`IdArte`),
  ADD CONSTRAINT `artes_curtidas_ibfk_2` FOREIGN KEY (`IdUsuario`) REFERENCES `usuarios` (`IdUsuario`);

--
-- Limitadores para a tabela `eventos_usuarios`
--
ALTER TABLE `eventos_usuarios`
  ADD CONSTRAINT `eventos_usuarios_ibfk_1` FOREIGN KEY (`IdEvento`) REFERENCES `evento` (`IdEvento`),
  ADD CONSTRAINT `eventos_usuarios_ibfk_2` FOREIGN KEY (`IdUsuario`) REFERENCES `usuarios` (`IdUsuario`);

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

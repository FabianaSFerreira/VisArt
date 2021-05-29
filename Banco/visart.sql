-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 29-Maio-2021 às 00:51
-- Versão do servidor: 10.3.16-MariaDB
-- versão do PHP: 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `visart`
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
  `Curtidas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `artes`
--

INSERT INTO `artes` (`IdArte`, `IdTipo`, `IdUsuario`, `TituloArte`, `LocalArquivo`, `Descricao`, `Curtidas`) VALUES
(1, 1, 1, 'Pintura a Óleo', '../../Arquivos/Pintura/5f277114ebf91.jpg', 'Imagem Disponível em: https://www.cpt.com.br/artigos/pintura-a-oleo-sobre-tela Acesso em: 12 fev. 2021', 0),
(2, 2, 2, 'Black Tie 8 cabeças', '../../Arquivos/Escultura/5f277140e6d80.jpg', 'Imagem Disponível em: http://josebechara.com/esculturas-graficas/ Acesso em: 12 fev. 2021', 0),
(3, 3, 3, 'O espetáculo da flor de cerejeira', '../../Arquivos/Fotografia/5f2771569c3bd.jpg', 'Imagem Disponível em: https://br.pinterest.com/pin/151785449925403874/ Acesso em: 12 fev. 2021', 0),
(4, 4, 1, 'Audiovisual', '../../Arquivos/Audiovisual/5f5cfc836699d.mp4', 'Autoria própria, 2020', 0),
(5, 5, 1, 'Áreas do cérebro', '../../Arquivos/Artes Graficas/5f2771876b96e.jpg', 'Imagem Disponível em: http://www.canalbigbag.com.br/2019/12/19/ative-varias-areas-do-seu-cerebro-para-ser-mais-criativo/ Acesso em: 12 fev. 2021', 0),
(6, 6, 2, 'Love like cherry blossoms', '../../Arquivos/HQs & WebComics/5f2771a5488a0.jpg', 'Imagem Disponível em: https://br.pinterest.com/pin/26106872827867057/ Acesso em: 12 fev. 2021', 0),
(7, 3, 3, 'My Happy Place', '../../Arquivos/Fotografia/60330d0bda427.jpg', 'Imagem Disponível em: https://br.pinterest.com/pin/765612005377859971/ Acesso em: 12 fev. 2021', 0),
(8, 1, 2, 'Beleza Natural', '../../Arquivos/Pintura/60330d58e039f.jpg', 'Imagem Disponível em: https://br.pinterest.com/pin/541206080219267826/ Acesso em: 12 fev. 2021', 0);

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
(1, 1, 1, 'Linda a pintura!!!'),
(2, 2, 3, 'Que flores mais lindas!!'),
(3, 1, 6, 'Amoooooo esse webtoon!!!'),
(4, 2, 1, 'Adorei a escolha de cores!! Simplesmente perfeito!');

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
(1, 1, 1);

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
(1, 1, 'A simbologia das cores na arte e na vida', 'Fabiana Ferreira e Sheila Silveira', 'Rua, 000 - Bairro, Cidade - RS, CEP', '2021-04-20', '20:00:00', 'Imagem disponível em: https://br.pinterest.com/pin/367887863301247092/ Acesso em: 12 fev. 2021', '../../Arquivos/Eventos/5fdd497d7bd74.jpg'),
(2, 1, '12º Evento de arte Contemporânea', 'Danielle da Silveira de Souza', 'Rua, 000 - Bairro, Cidade - RS, CEP', '2021-05-03', '18:30:00', 'Imagem Disponível em: https://br.pinterest.com/pin/86835099058489128/ Acesso em: 12 fev. 2021', '../../Arquivos/Eventos/f9441abc32574.jpg');

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
(2, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupos`
--

CREATE TABLE `grupos` (
  `IdGrupo` int(11) NOT NULL,
  `TituloGrupo` varchar(30) NOT NULL,
  `Administrador` int(11) NOT NULL,
  `Descricao` varchar(500) NOT NULL,
  `Status` varchar(10) NOT NULL,
  `LocalImagem` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `grupos`
--

INSERT INTO `grupos` (`IdGrupo`, `TituloGrupo`, `Administrador`, `Descricao`, `Status`, `LocalImagem`) VALUES
(1, 'Fotografia pelo mundo', 1, 'Imagem Disponível em: https://br.pinterest.com/pin/181058847498271320/ Acesso em: 12 fev. 2021', 'aberto', '../../Arquivos/Grupos/5f2772476e3e3.jpg'),
(2, 'A arte da animação', 2, 'Imagem Disponível em: https://br.pinterest.com/pin/872009546569228905/ Acesso em: 12 fev. 2021', 'fechado', '../../Arquivos/Grupos/5f27725b357d1.jpg'),
(3, 'Família amarela', 1, 'Imagem Disponível em: https://br.pinterest.com/pin/369084131968488513/ Acesso em: 12 fev. 2021', 'aberto', '../../Arquivos/Grupos/5f27726d6930c.jpg'),
(4, 'Arte digital', 2, 'Imagem Disponível em: https://br.pinterest.com/pin/616571005227937585/ Acesso em: 12 fev. 2021', 'fechado', '../../Arquivos/Grupos/5f27727f144dd.jpg'),
(5, 'Amor pela arte', 1, 'Imagem Disponível em: https://br.pinterest.com/pin/625437466996284249/ Acesso em: 12 fev. 2021', 'aberto', '../../Arquivos/Grupos/5f2772b0b86b0.jpg'),
(6, 'Lugares incríveis', 1, 'Imagem Disponível em: https://br.pinterest.com/pin/617978380093637159/ Acesso em: 12 fev. 2021', 'fechado', '../../Arquivos/Grupos/5f2772c2b1f0a.jpg'),
(7, 'Lápis, papel, Desenhar!', 2, 'Imagem Disponível em: https://br.pinterest.com/pin/7529524364450842/ Acesso em: 12 fev. 2021', 'aberto', '../../Arquivos/Grupos/5f277353aed87.jpg');

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
(1, 1, 1, 'Oii gente, fazendo tour pela França '),
(2, 1, 1, 'Recomendações de lugares para tirar fotos??'),
(3, 2, 1, 'UAU!! Recomendo ir no XX, da pra tirar ótimas fotos'),
(4, 3, 1, 'Já fui lá também, lugar lindo!! Super recomendo');

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
(1, 'Fabi_Ferreira', 'Fabiana Ferreira', 'fabiana.ferreira.ti@gmail.com', 'c6550818f6c2283e88311273d204b027', '../../Arquivos/Perfil/5f2772b0b86b0.jpg'),
(2, 'Dani_Souza', 'Danielle de Souza', 'dani_souza@gmail.com', '202cb962ac59075b964b07152d234b70', '../../Arquivos/Perfil/5fdd497d7bd74.jpg'),
(3, 'Sheila_SS', 'Sheila da Silveira', 'sheilass@gmail.com', '202cb962ac59075b964b07152d234b70', '');

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
  ADD KEY `INDEX` (`IdArte`,`IdUsuario`) USING BTREE,
  ADD KEY `artes_curtidas_ibfk_2` (`IdUsuario`);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

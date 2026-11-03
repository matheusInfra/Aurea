-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: db_aurea
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbl_categorias_cardapio`
--

DROP TABLE IF EXISTS `tbl_categorias_cardapio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_categorias_cardapio` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nome_categoria` varchar(100) NOT NULL,
  `descricao_categoria` text DEFAULT NULL,
  `icone_categoria` varchar(50) DEFAULT NULL COMMENT 'Nome do ícone Bootstrap Icons (ex: bi-egg-fried)',
  `ordem` int(11) NOT NULL DEFAULT 0 COMMENT 'Ordem de exibição no menu',
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_categoria`),
  KEY `idx_ordem_ativo` (`ordem`,`ativo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Categorias do cardápio do restaurante';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_categorias_cardapio`
--

LOCK TABLES `tbl_categorias_cardapio` WRITE;
/*!40000 ALTER TABLE `tbl_categorias_cardapio` DISABLE KEYS */;
INSERT INTO `tbl_categorias_cardapio` VALUES (1,'Entradas','Petiscos e aperitivos para começar a experiência com elegância.','bi-egg-fried',1,1,'2026-10-15 16:52:43'),(2,'Pratos Principais','Criações autorais do Chef executivo com ingredientes sazonais.','bi-fire',2,1,'2026-10-15 16:52:43'),(3,'Frutos do Mar','Seleção premium de pescados e frutos do mar frescos diariamente.','bi-water',3,1,'2026-10-15 16:52:43'),(4,'Vegetariano','Opções refinadas sem carne, ricas em sabor e criatividade.','bi-flower1',4,1,'2026-10-15 16:52:43'),(5,'Sobremesas','Doces e confeitaria artesanal para encerrar com sofisticação.','bi-cake2',5,1,'2026-10-15 16:52:43'),(6,'Bebidas','Carta de vinhos, drinques autorais e opções sem álcool.','bi-cup-straw',6,1,'2026-10-15 16:52:43');
/*!40000 ALTER TABLE `tbl_categorias_cardapio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_clientes`
--

DROP TABLE IF EXISTS `tbl_clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_clientes` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nome_cliente` varchar(150) NOT NULL,
  `email_cliente` varchar(150) NOT NULL,
  `telefone_cliente` varchar(20) DEFAULT NULL,
  `senha_cliente` varchar(255) NOT NULL COMMENT 'Hash bcrypt — NUNCA armazenar em texto puro',
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `uq_email_cliente` (`email_cliente`),
  KEY `idx_email_cliente` (`email_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Clientes cadastrados no portal de reservas';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_clientes`
--

LOCK TABLES `tbl_clientes` WRITE;
/*!40000 ALTER TABLE `tbl_clientes` DISABLE KEYS */;
INSERT INTO `tbl_clientes` VALUES (1,'Ana Beatriz Oliveira','ana.oliveira@email.com','(11) 98765-4321','123456',1,'2026-10-15 16:52:43'),(2,'Carlos Eduardo Mendes','carlos.mendes@email.com','(21) 91234-5678','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',1,'2026-10-15 16:52:43'),(3,'Evelyn Inacio','evelyninacio916@gmail.com','(55) 11949-9276','$2y$10$yugMz9p9X1KHzSNANKMe7uw1IhdWyi0o4pdAo6frB7FoHrYtrAcvi',1,'2026-10-15 17:20:13'),(4,'Felipe Moretzsohn','felipemor@gmail.com','(11) 98285-2065','$2y$10$mnDHmRT7Mn1jOLvmycddD.YMZ0ujIRR87dSSBCRXie.BE7SYB/96K',1,'2026-10-18 18:36:10');
/*!40000 ALTER TABLE `tbl_clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_feedbacks`
--

DROP TABLE IF EXISTS `tbl_feedbacks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_feedbacks` (
  `id_feedback` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `id_reserva` int(11) DEFAULT NULL COMMENT 'Reserva associada ao feedback (opcional)',
  `nota` int(11) NOT NULL COMMENT 'Nota de 1 a 5 estrelas',
  `comentario` text DEFAULT NULL,
  `aprovado` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = publicado no site',
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_feedback`),
  KEY `idx_aprovado_nota` (`aprovado`,`nota`),
  KEY `idx_cliente_feedback` (`id_cliente`),
  KEY `fk_feedbacks_reserva` (`id_reserva`),
  CONSTRAINT `fk_feedbacks_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `tbl_clientes` (`id_cliente`) ON UPDATE CASCADE,
  CONSTRAINT `fk_feedbacks_reserva` FOREIGN KEY (`id_reserva`) REFERENCES `tbl_reservas` (`id_reserva`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `chk_nota_estrelas` CHECK (`nota` between 1 and 5)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Feedbacks e avaliações dos clientes';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_feedbacks`
--

LOCK TABLES `tbl_feedbacks` WRITE;
/*!40000 ALTER TABLE `tbl_feedbacks` DISABLE KEYS */;
INSERT INTO `tbl_feedbacks` VALUES (1,1,1,5,'Uma experiência verdadeiramente inesquecível. O Carpaccio de Wagyu derreteu na boca e o Soufflé de Grand Marnier chegou perfeito à mesa. O serviço é refinado sem ser formal em excesso. Voltaremos com certeza!',1,'2026-10-15 16:52:43'),(2,2,2,5,'Realizamos um jantar de negócios e o Auréa superou todas as expectativas. Ambiente impecável, iluminação aconchegante e o sommelier foi extremamente atencioso na seleção dos vinhos. O Filet ao Périgueux é espetacular.',1,'2026-10-15 16:52:43'),(3,1,3,4,'O menu degustação de dezembro foi uma viagem gastronômica incrível. Cada prato contou uma história. Tiraria apenas meio ponto pelo tempo entre os pratos, que poderia ser um pouco menor. No geral, altamente recomendado!',1,'2026-10-15 16:52:43');
/*!40000 ALTER TABLE `tbl_feedbacks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_funcionarios`
--

DROP TABLE IF EXISTS `tbl_funcionarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_funcionarios` (
  `id_funcionario` int(11) NOT NULL AUTO_INCREMENT,
  `nome_funcionario` varchar(150) NOT NULL,
  `email_funcionario` varchar(150) NOT NULL,
  `senha_funcionario` varchar(255) NOT NULL COMMENT 'Hash bcrypt',
  `cargo` varchar(100) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_funcionario`),
  UNIQUE KEY `uq_email_funcionario` (`email_funcionario`),
  KEY `idx_cargo_ativo` (`cargo`,`ativo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Funcionários com acesso ao sistema interno';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_funcionarios`
--

LOCK TABLES `tbl_funcionarios` WRITE;
/*!40000 ALTER TABLE `tbl_funcionarios` DISABLE KEYS */;
INSERT INTO `tbl_funcionarios` VALUES (1,'Admin Auréa','admin@aurea.com.br','123456','Gerente',1,'2026-10-15 16:52:43');
/*!40000 ALTER TABLE `tbl_funcionarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_horarios_funcionamento`
--

DROP TABLE IF EXISTS `tbl_horarios_funcionamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_horarios_funcionamento` (
  `id_horario` int(11) NOT NULL AUTO_INCREMENT,
  `dia_semana` tinyint(1) NOT NULL COMMENT '0=Dom, 1=Seg, 2=Ter, 3=Qua, 4=Qui, 5=Sex, 6=Sáb',
  `hora_abertura` time NOT NULL,
  `hora_fechamento` time NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0 = fechado neste dia',
  PRIMARY KEY (`id_horario`),
  UNIQUE KEY `uq_dia_semana` (`dia_semana`),
  KEY `idx_dia_ativo` (`dia_semana`,`ativo`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Horários de funcionamento do restaurante por dia da semana';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_horarios_funcionamento`
--

LOCK TABLES `tbl_horarios_funcionamento` WRITE;
/*!40000 ALTER TABLE `tbl_horarios_funcionamento` DISABLE KEYS */;
INSERT INTO `tbl_horarios_funcionamento` VALUES (1,0,'12:00:00','00:00:00',1),(2,1,'12:00:00','23:00:00',0),(3,2,'12:00:00','23:00:00',1),(4,3,'12:00:00','23:00:00',1),(5,4,'12:00:00','23:00:00',1),(6,5,'12:00:00','23:00:00',1),(7,6,'12:00:00','00:00:00',1);
/*!40000 ALTER TABLE `tbl_horarios_funcionamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mesas`
--

DROP TABLE IF EXISTS `tbl_mesas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_mesas` (
  `id_mesa` int(11) NOT NULL AUTO_INCREMENT,
  `numero_mesa` int(11) NOT NULL,
  `capacidade` int(11) NOT NULL COMMENT 'Número máximo de pessoas',
  `localizacao` varchar(100) DEFAULT NULL COMMENT 'ex: Terraço, Salão Principal, Área VIP',
  `descricao` text DEFAULT NULL,
  `ativa` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_mesa`),
  UNIQUE KEY `uq_numero_mesa` (`numero_mesa`),
  KEY `idx_capacidade_ativa` (`capacidade`,`ativa`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Mesas disponíveis para reserva';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mesas`
--

LOCK TABLES `tbl_mesas` WRITE;
/*!40000 ALTER TABLE `tbl_mesas` DISABLE KEYS */;
INSERT INTO `tbl_mesas` VALUES (1,1,2,'Salão Principal','Mesa íntima junto à janela com vista para o jardim.',1),(2,2,2,'Salão Principal','Mesa íntima junto à janela, iluminação suave.',1),(3,3,4,'Salão Principal','Mesa central com cadeiras estofadas e lustre sobre a mesa.',1),(4,4,4,'Salão Principal','Mesa próxima ao piano, ideal para jantares românticos.',1),(5,5,4,'Terraço','Mesa ao ar livre com vista panorâmica da cidade.',1),(6,6,4,'Terraço','Mesa no canto do terraço, rodeada de plantas ornamentais.',1),(7,7,6,'Terraço','Mesa ampla para grupos pequenos com guarda-sol premium.',1),(8,8,6,'Jardim Interno','Mesa no jardim coberto, ambiente fresco e reservado.',1),(9,9,6,'Jardim Interno','Mesa próxima à fonte d\'água, trilha sonora natural.',1),(10,10,8,'Jardim Interno','Mesa longa para grupos, decoração floral exclusiva.',1),(11,11,8,'Área VIP','Sala semiprivativa com serviço dedicado e adega própria.',1),(12,12,8,'Área VIP','Suite gastronômica com chef interativo e sommelier exclusivo.',1);
/*!40000 ALTER TABLE `tbl_mesas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_pratos`
--

DROP TABLE IF EXISTS `tbl_pratos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_pratos` (
  `id_prato` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) NOT NULL,
  `nome_prato` varchar(150) NOT NULL,
  `descricao_prato` text DEFAULT NULL,
  `ingredientes` text DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL DEFAULT 0.00,
  `foto_prato` varchar(255) NOT NULL DEFAULT 'sem-foto.jpg',
  `restricoes` varchar(255) DEFAULT NULL COMMENT 'ex: vegetariano, sem glúten, vegano, etc.',
  `destaque` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = exibir na home como destaque',
  `disponivel` tinyint(1) NOT NULL DEFAULT 1,
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_prato`),
  KEY `idx_categoria` (`id_categoria`),
  KEY `idx_destaque` (`destaque`),
  KEY `idx_disponivel` (`disponivel`),
  CONSTRAINT `fk_pratos_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `tbl_categorias_cardapio` (`id_categoria`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Pratos e bebidas do cardápio';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_pratos`
--

LOCK TABLES `tbl_pratos` WRITE;
/*!40000 ALTER TABLE `tbl_pratos` DISABLE KEYS */;
INSERT INTO `tbl_pratos` VALUES (1,1,'Carpaccio de Wagyu','Finíssimas fatias de wagyu curadas, com azeite trufado, lascas de parmesão 36 meses e rúcula selvagem.','Wagyu, azeite de trufas, parmesão reggiano, rúcula, alcaparras, limão siciliano',89.00,'carpaccio-de-wagyu.jpg','sem glúten',1,1,'2026-10-15 16:52:43'),(2,1,'Ostras Frescas ao Natural','Meia dúzia de ostras Crassostrea cultivadas no litoral catarinense, servidas sobre gelo com molho mignonette e limão.','Ostras frescas, echalota, vinagre de champanhe, pimenta-do-reino, limão siciliano',74.00,'ostras-frescas-ao-natural.jpg','sem glúten',0,1,'2026-10-15 16:52:43'),(3,1,'Foie Gras Maison','Terrine de foie gras artesanal com brioche tostado, geleia de figo e redução de porto.','Foie gras, brioche, geleia de figo da índia, vinho do porto, flor de sal',98.00,'foie-gras-maison.jpg',NULL,1,1,'2026-10-15 16:52:43'),(4,2,'Filet Mignon ao Molho Périgueux','Medalhão de 300 g ao ponto certo, coberto com clássico molho Périgueux de trufas negras, acompanha purê de batata-baroa e aspargos grelhados.','Filet mignon, trufa negra, manteiga clarificada, batata-baroa, aspargos, demi-glace',185.00,'filé-mignon-pure-aspargo.jpg','sem glúten',1,1,'2026-10-15 16:52:43'),(5,2,'Pato Confit com Laranja Sanguínea','Coxa de pato confitada lentamente em sua própria gordura, laqueada com redução de laranja sanguínea, servida com lentilha du Puy.','Pato, laranja sanguínea, tomilho, alho, lentilha du Puy, cebola pérola',142.00,'pato-confit-com-laranja-sanguinea.jpg','sem glúten',0,1,'2026-10-15 16:52:43'),(6,2,'Risotto de Porcini e Trufas','Arroz arbóreo cremoso com cogumelos porcini reidratados, creme de trufas e parmesão fundido.','Arroz arbóreo, porcini, vinho branco seco, creme de trufas, parmesão, manteiga',128.00,'risotto-de-porcini-trufas.jpg','vegetariano',1,1,'2026-10-15 16:52:43'),(7,3,'Robalo ao Molho de Maracujá e Gengibre','Filé de robalo selvagem flambado, com emulsão de maracujá e gengibre, farofa de dendê e chips de mandioca.','Robalo, maracujá, gengibre, dendê, mandioca, coentro, limão-cravo',148.00,'robalo-ao-molho-maracujá.jpg','sem glúten',1,1,'2026-10-15 16:52:43'),(8,3,'Lagosta Grelhada com Manteiga de Ervas','Meia lagosta grelhada na brasa, finalizada com manteiga de ervas finas (estragão, salsa, cebolinha), acompanha batatas douradas.','Lagosta, manteiga, estragão, salsa, cebolinha, alho, azeite extra virgem',265.00,'lagosta-grelhada-manteiga.jpg','sem glúten',1,1,'2026-10-15 16:52:43'),(9,4,'Ravióli de Ricota e Espinafre ao Manteiga de Sálvia','Massa fresca artesanal recheada com ricota de ovelha e espinafre orgânico, ao molho de manteiga noisette com sálvia crocante.','Farinha 00, ovos, ricota de ovelha, espinafre, manteiga, sálvia, nozes pecã',96.00,'ravioli-de-ricota-e-espinafre-ao-manteiga-de-salvia.jpg','vegetariano',0,1,'2026-10-15 16:52:43'),(10,4,'Curry de Grão-de-Bico com Leite de Coco','Preparação indiana relida pelo Chef, com especiarias frescas, grão-de-bico orgânico e leite de coco, acompanha arroz basmati e naan de ervas.','Grão-de-bico, leite de coco, tomate, garam masala, cúrcuma, coentro, arroz basmati, naan',82.00,'curry-de-grao-de-bico-com-leite-de-coco.jpg','vegano, sem glúten',0,1,'2026-10-15 16:52:43'),(11,5,'Soufflé de Grand Marnier','Soufflé quentinho com licor Grand Marnier, servido imediatamente à mesa com creme crème anglaise baunilhada.','Ovos, açúcar, Grand Marnier, leite integral, baunilha Bourbon, manteiga',68.00,'souffle-de-grand-marnier.jpg','vegetariano',1,1,'2026-10-15 16:52:43'),(12,5,'Tarte Tatin de Peras com Sorvete de Cardamomo','Clássica torta invertida de peras Williams caramelizadas, acompanha sorvete artesanal de cardamomo e pistache.','Peras Williams, açúcar, manteiga, massa folhada, cardamomo, pistache',58.00,'tarte-tatin-de-peras-com-sorvete-de-cardamomo.jpg','vegetariano',0,1,'2026-10-15 16:52:43'),(13,6,'Coquetél Auréa','Drinque exclusivo da casa: gin premium, licor de violeta, xarope de lavanda, limão siciliano e espuma de clara.','Gin Hendricks, licor Crème de Violette, xarope de lavanda, limão siciliano, clara de ovo',48.00,'coquetel-aurea.jpg',NULL,1,1,'2026-10-15 16:52:43'),(14,6,'Seleção de Sucos Naturais','Suco de fruta da estação extraído na hora. Pergunte ao sommelier de bebidas a opção do dia.','Fruta da estação, água mineral ou sem adição de líquido (integral)',22.00,'selecao-de-sucos-naturais.jpg','vegano, sem glúten, sem álcool',0,1,'2026-10-15 16:52:43');
/*!40000 ALTER TABLE `tbl_pratos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_reservas`
--

DROP TABLE IF EXISTS `tbl_reservas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_reservas` (
  `id_reserva` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `id_mesa` int(11) NOT NULL,
  `codigo_reserva` varchar(20) NOT NULL COMMENT 'Código único exibido ao cliente (ex: AUR-20240915-001)',
  `data_reserva` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fim` time NOT NULL COMMENT 'Calculado como hora_inicio + 2 horas',
  `qtd_pessoas` int(11) NOT NULL,
  `status_reserva` enum('confirmada','cancelada','concluida','no_show') NOT NULL DEFAULT 'confirmada',
  `observacoes` text DEFAULT NULL,
  `cancelamento_motivo` text DEFAULT NULL,
  `cancelado_em` datetime DEFAULT NULL,
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_reserva`),
  UNIQUE KEY `uq_codigo_reserva` (`codigo_reserva`),
  UNIQUE KEY `uq_mesa_data_horario` (`id_mesa`,`data_reserva`,`hora_inicio`),
  KEY `idx_cliente_status` (`id_cliente`,`status_reserva`),
  KEY `idx_data_status` (`data_reserva`,`status_reserva`),
  CONSTRAINT `fk_reservas_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `tbl_clientes` (`id_cliente`) ON UPDATE CASCADE,
  CONSTRAINT `fk_reservas_mesa` FOREIGN KEY (`id_mesa`) REFERENCES `tbl_mesas` (`id_mesa`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Reservas de mesas — tabela central do sistema';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_reservas`
--

LOCK TABLES `tbl_reservas` WRITE;
/*!40000 ALTER TABLE `tbl_reservas` DISABLE KEYS */;
INSERT INTO `tbl_reservas` VALUES (1,1,4,'AUR-20241115-001','2024-11-15','20:00:00','22:00:00',2,'confirmada','Aniversário de casamento — solicitar decoração especial e champanhe na mesa.',NULL,NULL,'2026-10-15 16:52:43'),(2,2,7,'AUR-20241120-002','2024-11-20','19:30:00','21:30:00',5,'confirmada','Jantar de negócios. Preferência por mesa reservada e menor ruído possível.',NULL,NULL,'2026-10-15 16:52:43'),(3,1,11,'AUR-20241201-003','2024-12-01','21:00:00','23:00:00',4,'concluida','Confraternização de fim de ano. Menu degustação confirmado com sommelier.',NULL,NULL,'2026-10-15 16:52:43'),(4,3,2,'AUR-20261020-BA024','2026-10-20','13:00:00','15:00:00',2,'confirmada','',NULL,NULL,'2026-10-15 17:21:34'),(5,4,2,'AUR-20261028-6B1C0','2026-10-28','14:00:00','16:00:00',2,'confirmada','Pedido de casamento , quero uma surpresa ,a sobremesa.',NULL,NULL,'2026-10-18 18:38:44');
/*!40000 ALTER TABLE `tbl_reservas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-20 17:41:39

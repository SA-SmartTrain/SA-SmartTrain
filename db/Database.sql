CREATE DATABASE IF NOT EXISTS `smarttrain` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE `smarttrain`;

CREATE TABLE IF NOT EXISTS `usuarios` (
    `idusuarios` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `nome_usuarios` VARCHAR(87) NOT NULL,
    `email_usuarios` VARCHAR(87) NOT NULL UNIQUE,
    `senha_usuarios` VARCHAR(87) NOT NULL,
    `cpf_usuarios` CHAR(11) NOT NULL,
    `perfil` ENUM('Gestor', 'Usuario', 'Administrador') NOT NULL DEFAULT 'usuario',
    `foto_usuarios` VARCHAR(255) DEFAULT NULL,
    telefone_usuario VARCHAR(20) NULL,
	endereco_usuario VARCHAR(255) NULL
);

CREATE TABLE IF NOT EXISTS `notificacoes` (
    idnotificacoes INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    observacao_notificacoes VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS relatorios (
    idrelatorios INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    carga_relatorio VARCHAR(85) NOT NULL,
    data_relatorio DATE NOT NULL,
    quantidade_relatorio INT NOT NULL,
    idusuarios INT NOT NULL,
    FOREIGN KEY (idusuarios) REFERENCES usuarios(idusuarios)

);

CREATE TABLE IF NOT EXISTS manutencao (
    idmanutencao INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    horario_manutencao DECIMAL (10,2) NOT NULL,
    observacao_manutencao VARCHAR(255) NOT NULL,
    linha_manutencao INT NOT NULL,
    idusuarios INT NOT NULL,
    FOREIGN KEY (idusuarios) REFERENCES usuarios(idusuarios)
);

CREATE TABLE IF NOT EXISTS cargas (
    idcargas INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `tipo_carga` ENUM('Soja', 'Milho', 'Feijão', 'Ervilha', 'Carvão', 'Açucar','Barras de Aço', 'Minério', 'Cereais', 'Petróleo' ) NOT NULL,
   `tamanho_carga` ENUM('1-50 Toneladas', '50-100 Toneladas', '100-500 Toneladas', '500-1.000 Toneladas', '1.000-5.000 Toneladas',
    '5.000-10.000 Toneladas','10.000-15.000 Toneladas', 'Mais de 20 mil toneladas', 'Mais de 50 mil toneladas', 'Mais de 100 mil toneladas', 'Mais de 500 mil toneladas' ) NOT NULL,   
   `partida_carga` ENUM('Mafra', 'São Francisco do Sul', 'Guaramirim', 'Joinville', 'Araquari', 'Itapoá','Navegantes', 'Rio do Sul', 'Tubarão', 'Curitiba' ) NOT NULL,    
   `destino_carga` ENUM('Mafra', 'São Francisco do Sul', 'Guaramirim', 'Joinville', 'Araquari', 'Itapoá','Navegantes', 'Rio do Sul', 'Tubarão', 'Curitiba' ) NOT NULL,    
    envio_cargas DATE NOT NULL,
    chegada_cargas DATE NOT NULL,
    idusuarios INT NOT NULL,
    FOREIGN KEY (idusuarios) REFERENCES usuarios(idusuarios)

);

CREATE TABLE IF NOT EXISTS sensores (
    idsensores INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `tipo_sensor` ENUM('Ultrassonico', 'LDR (luminosidade)', 'Sensor DHT11') NOT NULL,
    `localizacao_sensor` ENUM('Trilho 1-Sul', 'Trilho 1-Norte', 'Trilho 2-Sul', 'Trilho 2-Norte', 'Trilho 3-Sul', 'Trilho 3-Norte', 'Trilho 4-Sul', 'Trilho 4-Norte', 
    'Trilho 5-Sul', 'Trilho 5-Norte', 'Trilho 6-Sul', 'Trilho 6-Norte')  NOT NULL,
   data_sensor DATE NOT NULL,
   observacao_sensor VARCHAR(87) NOT NULL
);

USE smarttrain;

ALTER TABLE sensores
ADD data_sensor_volta DATE;
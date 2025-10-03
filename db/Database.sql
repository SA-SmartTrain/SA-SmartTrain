CREATE DATABASE IF NOT EXISTS `smarttrain` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE `smarttrain`;

CREATE TABLE IF NOT EXISTS `usuarios` (
    `idusuarios` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `nome_usuarios` VARCHAR(87) NOT NULL,
    `email_usuarios` VARCHAR(87) NOT NULL UNIQUE,
    `senha_usuarios` VARCHAR(87) NOT NULL,
    `cpf_usuarios` CHAR(11) NOT NULL,
    `perfil` ENUM('Gestor', 'Usuario', 'Administrador') NOT NULL DEFAULT 'usuario',
    `foto_usuarios` VARCHAR(255) DEFAULT NULL
);

ALTER TABLE usuarios 
ADD COLUMN telefone_usuario VARCHAR(20) NULL,
ADD COLUMN endereco_usuario VARCHAR(255) NULL;

CREATE TABLE IF NOT EXISTS `notificacoes` (
    idnotificacoes INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    observacao_notificacoes VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS 'relatorios' (
    idrelatorios INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    carga_relatorio VARCHAR(85) NOT NULL,
    data_relatorio DATE NOT NULL,
    quantidade_relatorio INT NOT NULL,
    FOREIGN KEY (idusuarios) REFERENCES usuarios(idusuarios)

);
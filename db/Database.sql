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

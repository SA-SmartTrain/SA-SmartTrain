INSERT INTO `usuarios` (`nome_usuarios`, `email_usuarios`, `senha_usuarios`, `cpf_usuarios`, `perfil`)
VALUES
('SmartTrain Tester', 'smarttrain@senai.com', 'Admin@123', '41638481705', 'administrador'),
('Lucas Silva', 'lucas@gmail.com', 'senha123', '12345678901', 'gestor'),
('Ana Souza', 'ana@gmail.com', 'abc123', '98765432100', 'usuario'),
('Pedro Almeida', 'pedro@gmail.com', 'pedro2025', '45678912300', 'usuario'),
('Carla Mendes', 'carla@gmail.com', 'carla321', '32165498700', 'gestor'),

INSERT INTO notificacoes (observacao_notificacoes) VALUES
('Trem 01 chegou ao destino'),
('Sensor Ultrassônico detectou obstáculo'),
('Carga de soja finalizada'),
('Manutenção preventiva agendada'),
('Usuário administrador alterou permissões');

INSERT INTO relatorios (carga_relatorio, data_relatorio, quantidade_relatorio, idusuarios) VALUES
('Soja', '2025-01-10', 120, 1),
('Milho', '2025-01-11', 90, 2),
('Carvão', '2025-01-12', 300, 3),
('Minério', '2025-01-13', 450, 4),
('Petróleo', '2025-01-14', 600, 5);

INSERT INTO manutencao (horario_manutencao, observacao_manutencao, linha_manutencao, idusuarios) VALUES
(10.30, 'Revisão completa dos freios', 1, 1),
(14.45, 'Troca de componentes elétricos', 2, 2),
(08.15, 'Lubrificação dos eixos', 3, 3),
(16.00, 'Verificação das rodas', 4, 4),
(11.20, 'Ajuste no sistema de carga', 5, 5);

INSERT INTO cargas (tipo_carga, tamanho_carga, partida_carga, destino_carga, envio_cargas, chegada_cargas, idusuarios) VALUES
('Soja', '100-500 Toneladas', 'Mafra', 'Itapoá', '2025-02-01', '2025-02-03', 1),
('Milho', '50-100 Toneladas', 'Curitiba', 'Joinville', '2025-02-02', '2025-02-04', 2),
('Carvão', '500-1.000 Toneladas', 'Tubarão', 'São Francisco do Sul', '2025-02-05', '2025-02-08', 3),
('Petróleo', 'Mais de 20 mil Toneladas', 'Navegantes', 'Araquari', '2025-02-07', '2025-02-10', 4),
('Minério', '1.000-5.000 Toneladas', 'Rio do Sul', 'Guaramirim', '2025-02-09', '2025-02-12', 5);

INSERT INTO sensores (tipo_sensor, localizacao_sensor, data_sensor, observacao_sensor, data_sensor_volta) VALUES
('Ultrassonico', 'Trilho 1-Sul', '2025-01-10', 'Movimento detectado', '2025-01-11'),
('LDR (luminosidade)', 'Trilho 2-Norte', '2025-01-11', 'Baixa luminosidade', '2025-01-12'),
('Sensor DHT11', 'Trilho 3-Sul', '2025-01-12', 'Temperatura alta', '2025-01-13'),
('Ultrassonico', 'Trilho 4-Norte', '2025-01-13', 'Objeto detectado', '2025-01-14'),
('Sensor DHT11', 'Trilho 5-Sul', '2025-01-14', 'Umidade elevada', '2025-01-15');

INSERT INTO trens (carga_trem, capacidade_trem, vagoes_trem, estado_trem, velocidade_trem) VALUES
('Soja', '100-500 Toneladas', '20', 'Em rota', '80km/h'),
('Carvão', '500-1.000 Toneladas', '30', 'Parado', '60km/h'),
('Minério', '1.000-5.000 Toneladas', '40', 'Em manutenção', '100km/h'),
('Petróleo', 'Mais de 20 mil Toneladas', '50', 'Aguardando carga', '120km/h'),
('Cereais', '50-100 Toneladas', '10', 'Em carregamento', '60km/h');

INSERT INTO relatorios (carga, data, quantidade) VALUES
('Soja', '2025-03-01', 200),
('Carvão', '2025-03-02', 350),
('Milho', '2025-03-03', 120),
('Petróleo', '2025-03-04', 500),
('Minério', '2025-03-05', 800);

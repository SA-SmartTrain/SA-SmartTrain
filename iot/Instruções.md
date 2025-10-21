SA 4ª Entrega – Integração com Broker Oficial + Leitura de Sensores
JOAO LUIS CORREA BORNELLI
•
07:22 (editado: 07:52)
100 pontos
Data de entrega: 4 de nov.
Descrição: Nesta atividade, vocês vão integrar sensores reais (ex: temperatura, luminosidade ou distância) e enviar seus dados para o broker MQTT oficial da escola. O sistema deve ser capaz de enviar e receber dados em tempo real.

Objetivo: Implementar a coleta de dados de sensores e sua publicação no broker oficial, além de responder a comandos remotos via MQTT.

Escopo mínimo obrigatório:
Leitura periódica de pelo menos um sensor conectado ao ESP32.
Publicação dos valores lidos em tópicos adequados no broker oficial.
Recebimento de mensagens de controle (ex: ligar/desligar LED).

Fluxo esperado:
ESP32 conecta ao Wi-Fi e ao broker oficial.
Publica dados dos sensores a cada intervalo de tempo.
Recebe mensagens e aciona atuadores conforme o comando.

Critérios de aceite:
Sistema funcional com envio e recebimento de dados.
Organização e clareza nos tópicos e no código.
Broker oficial configurado corretamente.

Entrega: Link do repositório GitHub com o código atualizado e demonstrando a integração completa.
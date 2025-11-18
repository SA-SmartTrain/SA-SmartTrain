# MQTT Dashboard - TODO

## Funcionalidades Principais

- [ ] Integração com Broker MQTT (publicação e subscrição)
- [ ] Modelo de dados para sensores e atuadores no banco de dados
- [ ] Endpoints tRPC para listar sensores/atuadores
- [ ] Endpoints tRPC para publicar comandos no MQTT
- [ ] Interface web para exibir status de sensores (ligado/desligado)
- [ ] Botões interativos para controlar atuadores (LEDs)
- [ ] Polling em tempo real para atualizar status
- [ ] Testes unitários para lógica MQTT
- [ ] Testes unitários para endpoints tRPC

## Bugs Conhecidos

(Nenhum no momento)

## Notas de Implementação

- Usar a biblioteca `mqtt` do Node.js para comunicação MQTT
- Armazenar configuração do broker (host, porta, usuário, senha) em variáveis de ambiente
- Implementar cache de mensagens MQTT para evitar polling excessivo
- Usar Tailwind CSS para estilização responsiva

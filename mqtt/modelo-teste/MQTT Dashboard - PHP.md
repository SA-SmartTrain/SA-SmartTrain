# MQTT Dashboard - PHP

Uma aplicação web simples e poderosa para monitorar sensores e controlar atuadores via MQTT, desenvolvida em PHP puro com HTML, CSS e JavaScript.

## 🚀 Funcionalidades

- **Monitoramento de Sensores**: Exiba o status de sensores em tempo real (temperatura, umidade, movimento, luz, etc.)
- **Controle de Atuadores**: Botões para ligar/desligar LEDs, relés, bombas e outros dispositivos
- **Interface Responsiva**: Design moderno que funciona em desktop, tablet e mobile
- **Gerenciamento Dinâmico**: Adicione e remova sensores e atuadores sem reiniciar a aplicação
- **Atualização Automática**: Dados são atualizados automaticamente a cada 10 segundos
- **Cache Local**: Dados persistidos em arquivo JSON para funcionamento offline

## 📋 Requisitos

- PHP 7.4 ou superior
- Suporte a sockets (para conexão MQTT)
- Broker MQTT acessível (ex: test.mosquitto.org, Mosquitto local, etc.)

## 🔧 Instalação

### 1. Clonar ou baixar os arquivos

```bash
cd /home/ubuntu/mqtt_php_dashboard
```

### 2. Criar diretório de dados

```bash
mkdir -p data
chmod 755 data
```

### 3. Configurar variáveis de ambiente (opcional)

```bash
export MQTT_BROKER_HOST=seu-broker.com
export MQTT_BROKER_PORT=1883
export MQTT_USERNAME=seu_usuario
export MQTT_PASSWORD=sua_senha
```

### 4. Iniciar o servidor PHP

```bash
php -S 0.0.0.0:8080
```

Ou para rodar em background:

```bash
nohup php -S 0.0.0.0:8080 > /tmp/php_server.log 2>&1 &
```

### 5. Acessar a aplicação

Abra seu navegador e acesse:
```
http://localhost:8080
```

## 📖 Como Usar

### Adicionar um Sensor

1. Clique no botão **"+ Adicionar Sensor"**
2. Preencha os campos:
   - **Nome do Sensor**: Um nome descritivo (ex: "Temperatura Sala")
   - **Tópico MQTT**: O tópico onde o sensor publica (ex: "home/sala/temperatura")
   - **Tipo**: Selecione o tipo (Temperatura, Umidade, Movimento, Luz, Outro)
3. Clique em **"Adicionar"**

### Adicionar um Atuador

1. Clique no botão **"+ Adicionar Atuador"**
2. Preencha os campos:
   - **Nome do Atuador**: Um nome descritivo (ex: "LED Sala")
   - **Tópico MQTT**: O tópico para controlar o atuador (ex: "home/sala/led")
   - **Tipo**: Selecione o tipo (LED, Relé, Bomba, Outro)
3. Clique em **"Adicionar"**

### Controlar um Atuador

1. Localize o atuador na seção "⚡ Atuadores"
2. Clique em **"Ligar"** para enviar comando ON (1)
3. Clique em **"Desligar"** para enviar comando OFF (0)

### Atualizar Status dos Sensores

1. Clique no botão **"🔄 Atualizar Status"** para forçar uma atualização imediata
2. A aplicação se conectará ao broker e coletará as mensagens dos sensores por 2 segundos

### Deletar Sensores/Atuadores

1. Clique no botão **"Deletar"** no card do sensor/atuador
2. Confirme a exclusão

## 🏗️ Estrutura de Arquivos

```
mqtt_php_dashboard/
├── index.php          # Página principal (HTML + CSS + JavaScript)
├── api.php            # API para gerenciar sensores/atuadores
├── config.php         # Configurações da aplicação
├── phpMQTT.php        # Biblioteca MQTT para PHP
├── data/              # Diretório para cache (criado automaticamente)
│   └── cache.json     # Arquivo de cache dos sensores/atuadores
└── README.md          # Este arquivo
```

## 🔌 Protocolo MQTT

### Publicação de Sensores

Os sensores devem publicar seus valores nos tópicos configurados:

```
Tópico: home/sala/temperatura
Payload: 25.5

Tópico: home/sala/umidade
Payload: 60

Tópico: home/sala/movimento
Payload: 1 (ou "on")
```

### Controle de Atuadores

A aplicação publica comandos nos tópicos dos atuadores:

```
Tópico: home/sala/led
Payload: 1 (ligar) ou 0 (desligar)

Tópico: home/sala/relay
Payload: 1 (ligar) ou 0 (desligar)
```

## 🌐 Configuração do Broker MQTT

### Usando test.mosquitto.org (padrão)

Nenhuma configuração necessária. A aplicação já está configurada para usar o broker público.

### Usando um Broker Local

```bash
# Instalar Mosquitto
sudo apt-get install mosquitto mosquitto-clients

# Iniciar o serviço
sudo systemctl start mosquitto

# Configurar variáveis de ambiente
export MQTT_BROKER_HOST=localhost
export MQTT_BROKER_PORT=1883
```

### Usando um Broker Remoto

```bash
export MQTT_BROKER_HOST=seu-servidor.com
export MQTT_BROKER_PORT=1883
export MQTT_USERNAME=seu_usuario
export MQTT_PASSWORD=sua_senha
```

## 📱 Exemplo de Integração com Arduino/ESP8266

### Código Arduino para Sensor de Temperatura

```cpp
#include <PubSubClient.h>
#include <WiFi.h>

const char* ssid = "seu_wifi";
const char* password = "sua_senha";
const char* mqtt_server = "test.mosquitto.org";

WiFiClient espClient;
PubSubClient client(espClient);

void setup() {
  Serial.begin(115200);
  WiFi.begin(ssid, password);
  client.setServer(mqtt_server, 1883);
}

void loop() {
  if (!client.connected()) {
    reconnect();
  }
  client.loop();

  // Ler temperatura e publicar
  float temperature = readTemperature(); // Sua função de leitura
  char temp_str[8];
  dtostrf(temperature, 1, 2, temp_str);
  client.publish("home/sala/temperatura", temp_str);

  delay(5000); // Publicar a cada 5 segundos
}

void reconnect() {
  while (!client.connected()) {
    if (client.connect("arduino-client")) {
      Serial.println("Conectado ao MQTT");
    } else {
      delay(5000);
    }
  }
}
```

### Código Arduino para Controlar LED

```cpp
void setup() {
  pinMode(LED_PIN, OUTPUT);
  client.subscribe("home/sala/led");
  client.setCallback(callback);
}

void callback(char* topic, byte* payload, unsigned int length) {
  String message = "";
  for (int i = 0; i < length; i++) {
    message += (char)payload[i];
  }

  if (String(topic) == "home/sala/led") {
    if (message == "1") {
      digitalWrite(LED_PIN, HIGH);
    } else if (message == "0") {
      digitalWrite(LED_PIN, LOW);
    }
  }
}
```

## 🐛 Troubleshooting

### Erro: "Falha ao conectar ao broker MQTT"

- Verifique se o broker está online e acessível
- Confira o host e porta configurados
- Se usar autenticação, verifique usuário e senha
- Teste a conexão com: `mosquitto_sub -h seu-broker.com -t "#"`

### Sensores não recebem dados

- Verifique se os dispositivos estão publicando nos tópicos corretos
- Use `mosquitto_sub` para testar: `mosquitto_sub -h seu-broker.com -t "home/#"`
- Clique em "🔄 Atualizar Status" para forçar uma leitura

### Atuadores não respondem

- Verifique se os dispositivos estão inscritos nos tópicos corretos
- Teste publicando manualmente: `mosquitto_pub -h seu-broker.com -t "home/sala/led" -m "1"`
- Confirme se o dispositivo está ligado e conectado

## 📝 Licença

Esta aplicação utiliza a biblioteca phpMQTT, que é licenciada sob a MIT License.

## 🤝 Contribuições

Sinta-se livre para fazer fork, melhorar e enviar pull requests!

## 📞 Suporte

Para dúvidas ou problemas, consulte a documentação do MQTT ou entre em contato com o desenvolvedor.

---

**Desenvolvido com ❤️ para IoT**

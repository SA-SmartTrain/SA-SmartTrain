#include <WiFi.h>
#include <WiFiClientSecure.h>
#include <PubSubClient.h>
#include "env.h"

const int IN1 = 25;     // Direção (ponte H)
const int IN2 = 26;     // Direção (ponte H)
const int ENA = 27;     // PWM velocidade

const int LED_VERDE = 21;      // Frente
const int LED_VERMELHO = 18;   // Ré

WiFiClientSecure wifiClient;
PubSubClient mqtt(wifiClient);

void moverFrente(int velocidade);
void moverRe(int velocidade);
void pararTrem();
void callback(char* topic, byte* payload, unsigned long length);
void reconnect_mqtt();

void setup() {
  Serial.begin(115200);
  delay(500);

  // Segurança TLS desabilitada (para testes)
  wifiClient.setInsecure();

  // Pinos da ponte H
  pinMode(IN1, OUTPUT);
  pinMode(IN2, OUTPUT);
  pinMode(ENA, OUTPUT);

  // LEDs
  pinMode(LED_VERDE, OUTPUT);
  pinMode(LED_VERMELHO, OUTPUT);
  digitalWrite(LED_VERDE, LOW);
  digitalWrite(LED_VERMELHO, LOW);

  // Conectar WiFi
  Serial.println("Conectando ao WiFi...");
  WiFi.begin(WIFI_SSID, WIFI_PASS);

  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    delay(300);
  }
  Serial.println("\nWiFi conectado!");
  Serial.print("IP: ");
  Serial.println(WiFi.localIP());

  // Configuração MQTT
  mqtt.setServer(BROKER_URL, BROKER_PORT);
  mqtt.setCallback(callback);

  reconnect_mqtt();
}

void loop() {
  if (!mqtt.connected()) {
    reconnect_mqtt();
  }
  
  mqtt.loop();
}

void callback(char *topic, byte *payload, unsigned long length) {
  String msg = "";

  for (int i = 0; i < length; i++) msg += (char)payload[i];
  
  msg.trim();
  int valor = msg.toInt(); // transforma em número

  Serial.print("Valor recebido MQTT: ");
  Serial.println(valor);

  if (valor > 0) {
    moverFrente(valor);
    Serial.printf("Interpretado → FRENTE (%d)\n", valor);
  }
  else if (valor < 0) {
    moverRe(abs(valor));
    Serial.printf("Interpretado → RÉ (%d)\n", abs(valor));
  }
  else {
    pararTrem();
    Serial.println("Interpretado → PARAR");
  }
}

void reconnect_mqtt() {
  if (WiFi.status() != WL_CONNECTED) return;

  Serial.print("Conectando ao broker...");
  
  while (!mqtt.connected()) {
    if (mqtt.connect("ESP32_TremVel", BROKER_USR_ID, BROKER_USR_PASS)) {
      Serial.println("\nConectado ao MQTT!");
      mqtt.subscribe(TOPIC_TREMVEL);  
      Serial.print("Inscrito no tópico: ");
      Serial.println(TOPIC_TREMVEL);
    } else {
      Serial.print(".");
      delay(2000);
    }
  }
}

// Controles do trem
void moverFrente(int velocidade) {
  velocidade = constrain(velocidade, 0, 255);

  digitalWrite(IN1, HIGH);
  digitalWrite(IN2, LOW);
  analogWrite(ENA, velocidade);

  // LED conforme imagem
  digitalWrite(21, HIGH);   // Verde
  digitalWrite(18, LOW);    // Vermelho

  Serial.printf("Trem indo pra FRENTE | Vel: %d\n", velocidade);
}

void moverRe(int velocidade) {
  velocidade = constrain(velocidade, 0, 255);

  digitalWrite(IN1, LOW);
  digitalWrite(IN2, HIGH);
  analogWrite(ENA, velocidade);

  // LED conforme imagem
  digitalWrite(21, LOW);    // Verde
  digitalWrite(18, HIGH);   // Vermelho

  Serial.printf("Trem indo pra RÉ | Vel: %d\n", velocidade);
}

void pararTrem() {
  digitalWrite(IN1, LOW);
  digitalWrite(IN2, LOW);
  analogWrite(ENA, 0);

  // LED conforme imagem
  digitalWrite(21, LOW);   // Verde
  digitalWrite(18, LOW);   // Vermelho

  Serial.println("Trem PARADO!");
}

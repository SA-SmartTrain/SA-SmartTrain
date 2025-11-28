#include <WiFi.h>
#include <PubSubClient.h>
#include <WiFiClientSecure.h>
#include "env.h"
#include <DHT.h>

WiFiClientSecure wifi_client;
PubSubClient mqtt(wifi_client);

const int trigg = 22; //sensor ultrassônico
const int echo = 23;

int ldr = 34; //luminosidade
int valorldr = 0;
int pino_led = 19;

#define DHTPIN 4 //DHT
#define DHTTYPE DHT11
DHT dht(DHTPIN, DHTTYPE);


void setup() {
  // put your setup code here, to run once:
  Serial.begin(115200);
  dht.begin();
  wifi_client.setInsecure();
  pinMode(pino_led, OUTPUT);           
  digitalWrite(pino_led, LOW);        
  WiFi.begin(WIFI_SSID, WIFI_PASS);
  Serial.println("Conectando no WiFi");
  while(WiFi.status() != WL_CONNECTED){
    Serial.print(".");
    delay(200);
  }
  Serial.println("Conectado com sucesso!");
  mqtt.setServer(BROKER_URL,BROKER_PORT);
  String clientID = "S1";
  clientID += String(random(0xffff),HEX);
  while (mqtt.connect(clientID.c_str()) == 0){
    Serial.print(".");
    delay(200);
  }
  // mqtt.subscribe(topic.c_str());
  mqtt.subscribe(TOPIC_LUMINOSIDADE); //Inscrição no topico de luminosidade
  mqtt.setCallback(callback);
  Serial.println("\nConectado ao Broker!");

  pinMode(ldr,INPUT);
}

void loop() {
  long distancia = lerDistancia(trigg, echo);
    if (distancia < 10){
     mqtt.publish(TOPIC_ULTRASSONICO, "Apagar");
  } 

  //dht
  float h = dht.readHumidity(); //Ler umidade
  float t = dht.readTemperature(); //Ler temperatura

  if(isnan(h) || isnan(t)) { //Valida os dados recebidos
    Serial.println("Falha na leitura do sensor DHT11!");
    delay(2000);
    return;
    }
  Serial.print("Umidade: ");
  Serial.print(h);
  Serial.print("Temperatura: ");
  Serial.print(t);
  Serial.print(" °C");

  String strTemp = String(t, 1); //Converte os valores recebidos em uma string com uma casa decimal
  String strHum = String(h, 0); //Converte os valores recebidos sem casas decimais

  mqtt.publish(TOPIC_TEMPERATURA, strTemp.c_str()); //Publica uma mensagem no tópico de temperatura
  mqtt.publish(TOPIC_UMIDADE, strHum.c_str()); //Publica uma mensagem no tópico de umidade

  delay(2000);

  mqtt.loop();
}

//ldr
long valorldr(int ldr_pin){
  int luminance = analogRead(ldr_pin);
  if (luminance < 400){
     mqtt.publish(TOPIC_LUMINOSIDADE, "Apagar");
  } else {
    mqtt.publish(TOPIC_LUMINOSIDADE, "Acender")};
  return luminance;
}

//calcular distância
long lerDistancia(byte trigg, byte echo) {
  digitalWrite(trigg, LOW);
  delayMicroseconds(2);
  digitalWrite(trigg, HIGH);
  delayMicroseconds(10);
  digitalWrite(trigg, LOW);
  
  long duracao = pulseIn(echo, HIGH);
  long distancia = duracao * 349.24 / 2 / 10000;
  
  return distancia;
}

void callback(char* topic, byte* payload, unsigned long length) {
  String MensagemRecebida = "";
  for(int i = 0; i < length; i++){
    MensagemRecebida += (char) payload[i];
  }
  Serial.println(MensagemRecebida);

  if( topic == TOPIC_PRESENCE1){
    if(MensagemRecebida == "Acender"){
      digitalWrite(pino_led, HIGH);
    } else if(MensagemRecebida == "Apagar"){
      digitalWrite(pino_led, LOW);
  }
  }
  if (topic == TOPIC_LUMINOSIDADE){ 
    if(MensagemRecebida == "Acender"){
      digitalWrite(pino_led, HIGH);
    } else if(MensagemRecebida == "Apagar"){
      digitalWrite(pino_led, LOW);
  }
}
}
void connectToBrooker(){
  Serial.println("Conectado ao Brooker...");
}
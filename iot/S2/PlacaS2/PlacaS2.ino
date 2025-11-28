#include <WiFi.h>
#include <PubSubClient.h>
#include <WiFiClientSecure.h>
#include "env.h"

WiFiClientSecure wifi_client;
PubSubClient mqtt(wifi_client);

// const String WIFI_SSID = "FIESC_IOT_EDU";
// const String WIFI_PASS = "8120gv08";
// const String topic = "S2";

// const String brokerUser = "" ;
// const String brokerPass = "" ;

const int trig_1 = 12;
const int echo_1 = 13;

const int trig_2 = 14;
const int echo_2 = 15;
const byte LED_PIN = 18;
const byte led_r = 25;
const byte led_g = 26;
const byte led_b = 27;


void setup() {
  // put your setup code here, to run once:
  Serial.begin(115200);
  wifi_client.setInsecure();
  pinMode(LED_PIN, OUTPUT);           // Mudei isso
  digitalWrite(LED_PIN, LOW);         // Mudei isso
  WiFi.begin(WIFI_SSID, WIFI_PASS);
  Serial.println("Conectando no WiFi");
  while(WiFi.status() != WL_CONNECTED){
    Serial.print(".");
    delay(200);
  }
  Serial.println("Conectado com sucesso!");
  mqtt.setServer(BROKER_URL,BROKER_PORT);
  String clientID = "S2";
  clientID += String(random(0xffff),HEX);
  while (mqtt.connect(clientID.c_str(), BROKERUSR_ID, BROKER_PASS_USR_PASS) == 0){
    Serial.print(".");
    delay(200);
  }
  mqtt.subscribe(TOPIC_LUMINOSIDADE1);
  mqtt.setCallback(callback);
  Serial.println("\nConectado ao Broker!");
}

void loop() {
  long dist_1 = lerDistancia(trig_1, echo_1);
    if (dist_1 < 10){
     mqtt.publish(TOPIC_ULTRASSONICO1, "Presente");
  }
 

  long dist_2 = lerDistancia(trig_2, echo_2);
    if (dist_2 < 10){
     mqtt.publish(TOPIC_ULTRASSONICO2, "Presente");
  }
  Serial.println(dist_1, dist_2);
  mqtt.loop();
}

long lerDistancia(byte trig_pin, byte echo_pin) {
  digitalWrite(trig_pin, LOW);
  delayMicroseconds(2);
  digitalWrite(trig_pin, HIGH);
  delayMicroseconds(10);
  digitalWrite(trig_pin, LOW);
  
  long duracao = pulseIn(echo_pin, HIGH);
  long distancia = duracao * 349.24 / 2 / 10000;
  
  return distancia;
}


void callback(char* topic, byte* payload, unsigned long length) {
  String MensagemRecebida = "";
  for(int i = 0; i < length; i++){
    MensagemRecebida += (char) payload[i]; 
  }
  Serial.println(MensagemRecebida);

  if( topic == TOPIC_LUMINOSIDADE1){
    if(MensagemRecebida == "Acender"){
      digitalWrite(LED_PIN, HIGH);
    } else if(MensagemRecebida == "Apagar"){
      digitalWrite(LED_PIN, LOW);
  }
}
}
void connectToBrooker(){
  Serial.println("Conectado ao Brooker...");
}





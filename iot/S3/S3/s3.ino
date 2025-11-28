
#include <WiFi.h>
#include <PubSubClient.h>
#include <WiFiClientSecure.h> //Inclusão de Biblioteca (hivemq)
#include "env.h" //Variáveis, inseridas no gitignore
#include <ESP32Servo.h>// Inclusão de Biblioteca Servo Motor


WiFiClientSecure wifi_client; //Criando Cliente WIFI
PubSubClient mqtt(wifi_client); //Criando Cliente MQTT

const int LED = 14; //Definição de pino referente ao LED
const int pinoServo1 = 26; //Definição do Pino referente ao Servo Motor 1;
const int pinoServo2 = 27; //Definição do Pino referente ao Servo Motor 2;
const byte TRIGGER_PIN = 5; //Definição do Pino referente ao Sensor Ultrassônico;
const byte ECHO_PIN = 18; //Definição do Pino referente ao Sensor Ultrassônico;

Servo servo1; //Servo Motor 1
Servo servo2; //Servo Motor 2

//void statusLED(byte status) { //Função do LED RGB, referente ao status luminoso
    //turnOffLEDs();
    //switch (status) {
   // case 254:  //Caso Erro - Vermelho
       // setLEDColor(255, 0, 0);
       // break;
   // case 1:  //Conectando o WiFi - Amarelo
        //setLEDColor(150, 255, 0);
       // break;
    //case 2: //Conectando ao MQTT - Rosa
       // setLEDColor(150, 0, 255);
      //  break;
   // case 3:  //Movendo para frente - Verde
       // setLEDColor(0, 255, 0);
       // break;
  // case 4:  //Movendo para trás - Ciano
       // setLEDColor(0, 255, 255);
       // break;
   // default:
      //  for (byte i = 0; i < 4; i++) {
       //     setLEDColor(0, 0, 255);  //Possível erro - Azul piscando
        //    delay(100);
        //    turnOffLEDs();
        //    delay(100);
      //  }
      //  break;
   // }
//}
//void turnOffLEDs() { setLEDColor(0, 0, 0); }
//void setLEDColor(byte r, byte g, byte b) {
   // ledcWrite(PWM_CHANNEL_LED_R, r);
   // ledcWrite(PWM_CHANNEL_LED_G, g);
   // ledcWrite(PWM_CHANNEL_LED_B, b);
//}


//const String brokerUser = "";
//const String brokerPass = "";

void callback(char* topic, byte* payload, unsigned int length) {
  // Monta a mensagem completa a partir do payload
  String MensagemRecebida = "";
  for (unsigned int i = 0; i < length; i++){
    MensagemRecebida += (char) payload[i]; //Cada letra de payload e junta na mensagem
  }

  // Tratar LED (payload "Acender" / outro = desligar)
  String topicStr = String(topic);
  if (topicStr == TOPIC_LED) { //Condicional SE, conforme Tópico
    if (MensagemRecebida == "Acender"){ //Mensagem 
      digitalWrite(LED, HIGH); //LED Ligado
    } else{
      digitalWrite(LED, LOW); //LED Desligado
    }
    return;
  }

  // Servo 1
  if (topicStr == TOPIC_SERVO_1) { //Condicional referente ao Servo Motor 1;
    int angulo = MensagemRecebida.toInt(); //parsear ângulo enviado
    servo1.write(angulo);//Movimentação;
    mqtt.publish(TOPIC_SERVO_1, String(angulo).c_str()); //Publicação do estado do Servo Motor 1;
    return;
  }
  // Servo 2
  if (topicStr == TOPIC_SERVO_2) { //Condicional referente ao Servo Motor 2;
    int angulo = MensagemRecebida.toInt(); //parsear ângulo enviado
    servo2.write(angulo); //Movimentação;
    mqtt.publish(TOPIC_SERVO_2, String(angulo).c_str()); //Publicação do estado do Servo Motor 2;
    return;
  }
}

void setup() {
  Serial.begin(115200);
  servo1.attach(pinoServo1); //Definição do pino Servo Motor 1;
  servo2.attach(pinoServo2); //Definição do pino Servo Motor 2;
  servo1.write(0); //Posição inicial;
  servo2.write(0);//Posição inicial;
  pinMode(LED, OUTPUT);//Definição do pino de LED como saída;
  pinMode(TRIGGER_PIN, OUTPUT); //Saída
  pinMode(ECHO_PIN, INPUT);//Entrada

  wifi_client.setInsecure(); //Broker ignora o Certificado de Segurança/Autenticação
  WiFi.begin(WIFI_SSID, WIFI_PASS);  //tenta conectar na rede
  Serial.println("Conectando no WiFi");
  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    delay(200);
  }
  Serial.println("Conectado com sucesso!");//Mensagem exibida no Monitor Serial

  mqtt.setServer(BROKER_URL, BROKER_PORT);
  mqtt.setCallback(callback); // definir callback antes de subscribes/reconexões

  String clientID = "S3_beatrizcercal";
  clientID += String(random(0xffff), HEX);
  Serial.print("Conectando ao broker");
  while (!mqtt.connect(clientID.c_str())) {
    Serial.print(".");
    delay(200);
  }

  // Assinar tópicos
  //mqtt.subscribe(TOPIC_PRESENCE1);
  mqtt.subscribe(TOPIC_SERVO_1); 
  mqtt.subscribe(TOPIC_SERVO_2);
  mqtt.subscribe(TOPIC_LED);

  Serial.println("\nConectado ao broker!"); //Mensagem de confirmação exibida no Monitor Serial
}

void loop() {

  // put your main code here, to run repeatedly:
  //String mensagem = "";                       //Dentro do Loop, para recriá-la
  // if (Serial.available() > 0) {               //Caracteres disponíveis na "fila"
  //  mensagem = Serial.readStringUntil('\n');  //Leitura até "encontrar" o \n, palavra salva dentro da variável "mensagem"
  //  mensagem = "Beatriz: " + mensagem;       //exibição ao leitor
  //  mqtt.publish("Miguel",mensagem.c_str()); //enviar para o broker
  // }
  
  long distancia = lerDistancia(TRIGGER_PIN, ECHO_PIN); //Definição conforme os Pinos;
  if (distancia > 0 && distancia < 10){
    mqtt.publish(TOPIC_ULTRASSONICO, "Presente"); //enviar para o broker
  }

  mqtt.loop(); //Loop;
  delay(100);
}

long lerDistancia(byte TRIGGER_PIN, byte ECHO_PIN) { //Função de leitura de distância;
  digitalWrite(TRIGGER_PIN, LOW);
  delayMicroseconds(2);
  digitalWrite(TRIGGER_PIN, HIGH);
  delayMicroseconds(10);
  digitalWrite(TRIGGER_PIN, LOW);
  
  long duracao = pulseIn(ECHO_PIN, HIGH, 30000); //Tempo em microsegundos;
  

  long distancia = (duracao * 0.0343) / 2; //Cálculo da distância em cm;
  
  return distancia; //Retorno da distância, conforme calculado;
}

void connecttoBroker(){
  Serial.println("Conectando ao broker...");
}

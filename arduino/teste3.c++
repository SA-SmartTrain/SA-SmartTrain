#include  <DHT.h> // Biblioteca DHT
 
#define DHTPIN 18 // Pino onde o sensor está conectado
#define DHTTYPE DHT11 // Modelo do sensor DHT

DHT sensorTempUmd(DHTPIN, DHTTYPE); // Cria o objeto do sensor

float umidade = 0; // Variável para armazenar a umidade
float temperatura = 0; // Variável para armazenar a temperatura

void setup() {
  // put your setup code here, to run once:
  Serial.begin(9600); // Inicia a comunicação serial
  sensorTempUmd.begin();  // Inicia o sensor DHT
}

void loop() {
  // put your main code here, to run repeatedly:
  umidade = sensorTempUmd.readHumidity(); // Lê a umidade
  temperatura = sensorTempUmd.readTemperature(); // Lê a temperatura em Celsius

  Serial.println(umidade); // Imprime a umidade no monitor serial
  Serial.print(" | "); // Imprime um separador
  Serial.println(temperatura); // Imprime a temperatura no monitor serial
  delay(2000); // Aguarda 2 segundos antes da próxima leitura
}

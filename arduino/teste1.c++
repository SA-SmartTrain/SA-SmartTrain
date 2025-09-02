#include <Arduino.h> // Biblioteca principal do Arduino

const byte ldr_pin = 26; // Pino onde o LDR está conectado
int luz = 0; // Variável para armazenar o valor lido do LDR

void setup() {
  // put your setup code here, to run once:
pinMode(ldr_pin, INPUT); // Define o pino do LDR como entrada
Serial.begin(9600); //  Inicia a comunicação serial
}

void loop() {
  // put your main code here, to run repeatedly:
 luz = analogRead(ldr_pin); // Lê o valor do LDR
 Serial.println(luz); // Imprime o valor lido no monitor serial
 delay(100); // Aguarda 100 milissegundos antes da próxima leitura
}
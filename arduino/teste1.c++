#include <Arduino.h>

const byte ldr_pin = 26;
int luz = 0;

void setup() {
  // put your setup code here, to run once:
pinMode(ldr_pin, INPUT);
Serial.begin(9600);
}

void loop() {
  // put your main code here, to run repeatedly:
 luz = analogRead(ldr_pin);
 Serial.println(luz);
 delay(100);
}
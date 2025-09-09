#include <ESP32Servo.h>
const byte pino_servo = 21;
Servo servomotor;
void setup() {
  // put your setup code here, to run once:
servomotor.attach(pino_servo);
}

void loop() {
  // put your main code here, to run repeatedly:
servomotor.write(100); //ângulo
delay(500);
servomotor.write(10); //ângulo
delay(500);
}

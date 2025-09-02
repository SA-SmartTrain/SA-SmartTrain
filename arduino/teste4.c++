
const byte redPin = 33;
const byte greenPin = 35;
const byte bluePin = 32;

void setup() {
  // put your setup code here, to run once:
  // Only ESP32 ledcAttach(pino, freq, resolucao)
  ledcAttach(redPin, 5000, 8);
  ledcAttach(greenPin, 5000, 8);
  ledcAttach(bluePin, 5000, 8);
}

void loop() {
  // put your main code here, to run repeatedly:
  // Only ESP32
  ledcWrite(redPin, 255);
  ledcWrite(greenPin, 0);
  ledcWrite(bluePin, 0);
  delay(400);
  ledcWrite(redPin, 0);
  ledcWrite(greenPin, 255);
  ledcWrite(bluePin, 0);
  delay(400);
  ledcWrite(redPin, 0);
  ledcWrite(greenPin, 0);
  ledcWrite(bluePin, 255);
}

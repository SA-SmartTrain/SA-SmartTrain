const byte echo_pin = 32;
const byte trigg_pin = 33;
int distancia = 0;
unsigned long tempo = 0;


void setup() {
  // put your setup code here, to run once:
pinMode(echo_pin, INPUT);
pinMode(trigg_pin, OUTPUT);
Serial.begin(9600);
}

void loop() {
  // put your main code here, to run repeatedly:
 digitalWrite(trigg_pin, HIGH);
 delayMicroseconds(10);
 digitalWrite(trigg_pin, LOW);
 tempo = pulseIn(echo_pin, HIGH);
 distancia = (tempo * 340.29)/2/10000;
 “longe” se > 100;
“média” se > 50 e <100;
“perto” se < 10;

if (distancia > 100) {
  Printls("Longe");
 } else 

“média” se > 50 e <100;
“perto” se < 10;

}

}

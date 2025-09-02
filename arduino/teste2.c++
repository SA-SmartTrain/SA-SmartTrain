const byte echo_pin = 32; // Pino onde o Echo está conectado
const byte trigg_pin = 33; // Pino onde o Trigg está conectado
int distancia = 0; // Variável para armazenar a distância
unsigned long tempo = 0; // Variável para armazenar o tempo do pulso


void setup() {
  // put your setup code here, to run once:
pinMode(echo_pin, INPUT); // Define o pino do Echo como entrada
pinMode(trigg_pin, OUTPUT); // Define o pino do Trigg como saída
Serial.begin(9600);
} 

void loop() {
  // put your main code here, to run repeatedly:
 digitalWrite(trigg_pin, HIGH); // Envia um pulso HIGH
 delayMicroseconds(10); // Aguarda 10 microssegundos
 digitalWrite(trigg_pin, LOW); // Envia um pulso LOW
 tempo = pulseIn(echo_pin, HIGH); // Lê o tempo do pulso HIGH
 distancia = (tempo * 340.29)/2/10000;


 if(distancia > 100) {
  Printls("Longe");
 } else if (distancia > 50 && distancia <= 100) {
  Printls("Média");
 } else if (distancia <= 50) {
  Printls("Perto");
 }
  Serial.println(distancia); // Imprime a distância no monitor serial
}


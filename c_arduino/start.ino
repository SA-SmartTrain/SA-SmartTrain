// C++

//Funções padrões para inicialização
void setup(){
  //Ligar o Led L abaixo da ligação 13
  pinMode(13, OUTPUT);
}

void loop(){
	//Ação para deixar ligado o Led L
  	//Código Morse = --.-.-..-
  	digitalWrite(13,HIGH); // Uma piscada (-)
  	delay(500); 
  	digitalWrite(13,LOW); 
  
  	delay(300); // Espera
  	digitalWrite(13,HIGH); // Segunda piscada (-)
  	delay(500); 
  	digitalWrite(13,LOW); 
  
  	delay(300); // Espera
  	digitalWrite(13,HIGH); // Terceira piscada (.)
  	delay(200); 
  	digitalWrite(13,LOW);
  
  	delay(300); // Espera
  	digitalWrite(13,HIGH); // Quarta piscada (-)
  	delay(500); 
  	digitalWrite(13,LOW);
  
  	delay(300); // Espera
  	digitalWrite(13,HIGH); // Quinta piscada (.)
  	delay(200); 
  	digitalWrite(13,LOW);
  
  	delay(300);// Espera
  	digitalWrite(13,HIGH); // Sexta piscada (-)
  	delay(500);
  	digitalWrite(13,LOW);
  
  	delay(300);// Espera
  	digitalWrite(13,HIGH); // Sétima piscada (.)
  	delay(200);
  	digitalWrite(13,LOW);
  
  	delay(300);// Espera
  	digitalWrite(13,HIGH); // Oitava piscada (.)
  	delay(200);
  	digitalWrite(13,LOW);
  
  	delay(300);// Espera
  	digitalWrite(13, HIGH); // Nona piscada (-)
  	delay(500);
  	digitalWrite(13, LOW);
}
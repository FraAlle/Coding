#include <iostream>
#include <iomanip>    //setbase()
#include <cmath>

using namespace std;    //abstract container hold logical unique entities / using namespace is a C++ standard
                        //it's like import functions in python, or u import the namespace generally o u must call it in this way std::cout
                        //std é un oggetto
void pippo(int i){
  cout << i;
  cout << "\n50\n";     //print 50
  cout << '\50';        //print the value in ASCII this case (
  cout << "\nHex1:" << 0x10;    //the number 10 in HEX = 16
  cout << "\nHex2:" << hex << 10 << endl;//10 in HEX = a
  cout << setbase(16) << 10 << endl;
}

void String(){
  char character = 'X', minus = '-';
	float floating = 2.5;
	cout << "\n" << character << minus << floating;
}

void Converter(){
  char character = 'X';
	int integer = character;
	cout << character << " " << static_cast<int>(character);
	cout << " " << integer << " " << static_cast<char>(integer) << endl;
}

void AskNumber(){
  int value;
  cout << "Insert ur number: " << endl;
  cin >> value;
  cout << "U gave me this: " << value << endl;
  float square = sqrtf(value);     //radice quadrata
  cout << "His square is: "<< square << endl;
}

int main(void)
{
  int lightSpeed = 300'000'000;
  lightSpeed = 3E8;
  float f = 1E10;       // from E10 ahead the data is corrupted, too big from float to int
  int i = f;
  pippo(i);
  String();
  Converter();
  AskNumber();
  return 1;             //interrupt the function when the code return something
}


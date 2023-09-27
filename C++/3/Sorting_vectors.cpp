#include <iostream>
#include <string>
#include <vector>

using namespace std;

vector<int> numbers(5);

int main() {
  int value;
  cout<<"Insert how much values u want to insert: "<<endl;
  cin>>value;
  
  for (int i = 0; i < value; i++) {
    cout << endl << "Enter value #" << i + 1 << ": ";
    cin >> numbers[i];
  }
  
  // sort them 
  bool swapped;
  do {
    swapped = false;
    for (int i = 0; i < 4; i++) {
      if (numbers[i] > numbers[i + 1]) {
        swapped = true;
        int aux = numbers[i];
        numbers[i] = numbers[i + 1];
        numbers[i + 1] = aux;
      }
    }
  } while (swapped);
  
  // print results 
  cout << endl << "Sorted vector: " << endl;
  for (int i = 0; i < 5; i++)
    cout << numbers[i] << " ";
  cout << endl;
}
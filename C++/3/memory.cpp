#include <iostream>

using namespace std;

int main() {
    float *Array = new float[20];   //create new memory block
    int *count = new int;

    delete [] Array;                //delete the memory associated to Array
    delete count;

    
	float *arr = new float[5];

	for (int i = 0; i < 5; i++)     //see what's inside before the assign values
		cout << arr[i] << endl;

	for (int i = 0; i < 5; i++)     //assign values
		arr[i] = i * i;

	for (int i = 0; i < 5; i++)     //print the previous assign values
		cout << arr[i] << endl;

	delete[] arr;
}
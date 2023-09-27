#include <iostream>

using namespace std;

int main() {
    int valor1,valor2;

    cout<<"Pon dos valores: ";
    cin>>valor1;
    cin>>valor2;

    swap(valor1,valor2);
    cout<<valor1<<" "<<valor2;
    return 0;
}
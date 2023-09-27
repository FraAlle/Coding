#include <iostream>
#include <string>
#include <vector>

using namespace std;

int main(){
    int *p = nullptr;
    int i = 10;
    p = &i;
    cout<<p<<endl;      //0xsomething, where the variable i is located
    cout<<*p<<endl;     //10, the value of i
    *p=15;              //it change the value of the variable(or expression) that is located in that point
    cout<<i<<endl;

    int a;
    char c;
    a = sizeof(c);      //a=1 bc char can take only 1 letter

    int *ptr = nullptr;
    int x = sizeof ptr; //8 if is used an 64-bit system or 4 if is used an 32-bit system
    cout<<x<<endl;

    int j = sizeof 3.1415;
    cout<<j<<endl;      //always give 8
}
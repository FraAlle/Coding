#include <iostream>

using namespace std;

void can_i_change_my_argument(int& param) 
{
    cout << "----------" << endl;
    cout << "I have got: " << param << endl;
    param++;
    cout << "I'm about to give back: " << param << endl;
    cout << "----------" << endl;
}

int main() 
{
    int
    var = 1;

    cout << "var = " << var << endl;
    can_i_change_my_argument(var);
    cout << "var = " << var << endl;
}
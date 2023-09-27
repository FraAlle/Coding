#include <iostream>
#include <string>
#include <vector>

using namespace std;

int main(){
    vector<int> vect {1,2,3};
    int *ptr = vect.data();     //gives the pointers of the first value on the vector,ptr = &vect[0]; both goes well
    int *ptr2 = &vect[0];
    ptr2+=1;
    cout<<"Check values:"<<ptr<<endl<<ptr2<<endl<<(ptr==ptr2)<<endl;
    cout<<"Check substraction:"<<ptr2-ptr<<endl;       // the substraction will give us the difference from the both vectors positions
    cout<<"Check values for position and value of -1 vector position:"<<ptr-1<<endl<<*(ptr-1)<<endl;

    vector<int> numbers {1, 2, 3};
    int *pointer = numbers.data() + 1;      //adress of the second value of the array

    pointer[-1] = *pointer + pointer[1];    //put on the address of the first value of the array the sum of 2 + 3 = 5

    cout << numbers[0] << endl;
}
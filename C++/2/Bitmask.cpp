/*
LOGICAL OP
if a number has at least one bit true, the sentence is true
 int x = 2, y = 5;
    (x && y) ? printf("True ") : printf("False "); True


BITWISE OP
returns int
&: and with 2 numbers
|: or with 2 numbers
^: xor with 2 numbers
 int x = 2, y = 5;
    (x & y) ? printf("True ") : printf("False "); False

bitmask is a sequence of 0 or 1 that grabs value or to change the selected bits.
*/
#include <iostream>

using namespace std;

int main() {
    int i = 15, logneg = !i;    //logneg  = 0 bc i is true
    int bitneg = ~i;            //bitneg = -16(15's bits inverted)


    int flag_register = 8;          //0000000000000000000000000000x000  the X is the only bit I can change, position 3
    int the_mask = 8;               //0b1000    8 in binary 2^3
    if(flag_register & the_mask) {

    /* my bit is set */
    flag_register = flag_register | the_mask;
    cout << flag_register<<endl;          //returns 8

    /* my bit is negated */
    flag_register = flag_register ^ the_mask;
    cout <<flag_register;                  //return 0
    } else {

    /* my bit is reset */
    flag_register = flag_register & ~the_mask;
    cout << flag_register;          //returns 0
    }
}
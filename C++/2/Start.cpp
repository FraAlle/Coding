    /*
    long: more bits than int                    unsigned long x;            not usable in Strings
    short: less bits than int                   unsigned short x;           not usable in Strings
    unsigned: only with no negative numbers     unsigned x;

    float stores 32-bit long strings, this store only 8 digits
    Example: 1111111111111111111.111111111111111111111 is saves as 1111111131851653120.000000
    double stores 64-bit long strings, this store 15-17 digits
    long double stores 128 bits, this store 33-36 digits
    */
#include <iostream>

using namespace std;

int main()
{
	double a = 0.1;
	double b = 0.2;
	double c = 0.3;

	if(a + b != c)
		cout << "Your computer is out of order";    /*this comes out wich is not normal bc 0.1+0.2=0.3
    numbers stored as floating point can be differents from the real number
    if i change double with float no longer this happens*/
}
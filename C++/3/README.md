## FUNCTIONS
parameters passed by refer can be changed inside the functions.
U can use functions with pointers, in this case u will perform an parameter by value but it will be changeble bc we work with the posistion of the memory of that variable.
u can omit the parameters that are sets in the function definition. f.e. void new_greet(string greet, int repeats = 1) when the function in called there is no need to insert both values bc the second is already set as 1.

## INLINE
It's type of function that works differently. Normally the functions are stored and analized from the pc before the main, and each time we call it, the pc must go to the function pointer and get the result, this operation need time, for that, in case that function is called a lot of time it will take some time to be executed completly.
There is another way to avoid that, we can create little functions and make them work faster than a large one and make the code write it each time we invoke it. These kinda functions are called INLINE FUNCTIONS.
And is set just adding before the type the keywoard "inline".

## OVERLOADED
This happens when we want to create 2 differents function using the same name, in this case will be executed the little one first and then the largest utilizing this call max(max(a,b),c).
Another usage is depending on the chosing the best candidate by the data we pass to the function. If we have two function one that accept float and one that accept int and we pass an int variable, will be chose the function with the int variable, and viceversa.
void play_with_number(int x)        //this one will be the function selected
{
	...
}

void play_with_number(float x)
{
	...
}

play_with_number(1);

Another inside on the overloaded functions: the C++ code will try to promote the types if there isn't one exactly compatible, for example it will transform an float into double, but not a double into float. IT'S ONLY PROMOTION USAGE. But we can bypass that if we convince the compiler that the value we are passing is in the exact type we want by using this play_with_number(1.f); the f will tell the compiler that we are passing an float number type.

## POINTERS
"int *P" is not a int declaration, the * means that p is a pointer and it'll be used to store info about the location of the data type int.
p is an variable of type "pointer to int", the only values that it accepts are numbers.
U can assign 0 to a pointer(null pointer), for not be confused programmers use p = nullptr as p = 0.
to assign to p an true pointer we do this: p = &i. p will take the pointer of the i variable.

## DEFERENCE A POINTER
The pointer variable becomes synonymous with the value it points to. it can be also an expression.
Using "*p" we take the value assigned to that pointer, meanwhile using "p" we will take the pointer.
*p = 15 will assign at the pointer indicated the value 15.
ANY_TYPE *pointer means that pointer is ANY_TYPE type and the * pointer is of ANY_TYPE
if u try to give an variable the sizeof of an nullptr, it will have 8 if u use 64-bit or 4 if u use 34-bit.

## POINTERS && VECTORS
the method data() used with a vector returns the pointer pointing to the first element of the vector(vect.data()).

## OPERATIONS
-add int, gives an pointer
-substract int, gives an pointer
-substract a pointer from a pointer, gives an int. both pointers have to point to the same type, the addresses are substracted and then divided by the size of the type pointed to by the pointers
-comparing two pointers, gives a int
each time u sum or substract int to pointers, it will increase by 4 * int, bc the space for each int is 4 bytes
if we want to assigna to a variable the value of itself but in the next address we may use value = *(ptr+1) and can be written like this ptr[1].
We can create an pointer with the type of void (void *ptr;) this is called amorphous pointer bc it ca ne any value of any type.

## MEMORY USAGE C++
Is possible to control how much memory and when is used, is important when u don't know the size of the data to be processed is.
f.e. 
float *array = new float[20];
int *count = new int;

the new keyword returns a pointer of the type especificated, the new space will contain only garbage bc is nos initiated.

if we don't need more the memory we can erase it with delete
f.e.
delete [] array;
delete count;
is possible to relaese the whole memory but not part of it. after a delete all the pointers that point to that data becomes illegal.
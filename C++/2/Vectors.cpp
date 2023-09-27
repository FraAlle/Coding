/*
INVERT VALUES
int variable1 = 1, variable2 = 2, auxiliary;
auxiliary = variable1;
variable1 = variable2; 
variable2 = auxiliary;
*/
#include <vector>

using namespace std;

int main(){
    vector<int> numbers(5);     //int numbers[5];
    int sum,auxiliary;
    for (int i = 0;i<5;i++){
        sum = sum + numbers[i];
    }
    for(int i = 0; i < 5; i++){
        numbers[i] = 2012;
    }
    //Swap values 0-4 1-3
    for(int i = 0; i < 2; i++) {
        auxiliary = numbers[i];
        numbers[i] = numbers[4 - i];
        numbers[4 - i] = auxiliary;
    }

    vector<int> int_vector {0,1,2,3,4};     //int int_vector[] = {0,1,2,3,4,5,6};

    vector<vector<int>> chessboard(8, vector<int>(8));      //bi-dimensional array or matrix       the last declaration mean that each inner vector has space for 8 numbers
                                                            //or it could be like this: int chessboard[8][8];
    vector<vector<vector<int>>> guests(3, vector<vector<int>>(15, vector<int>(20))); //tri-dimensional array

    int current_size = chessboard.size();                   //ONLY AVAIABLE WITH NEW ARRAY DECLARATION

    vector<int> vect(0);
	
	vect.push_back(1);      //put one more space at the end of the arry with the value 1
	vect.push_back(-1);
	vect.push_back(0);
}

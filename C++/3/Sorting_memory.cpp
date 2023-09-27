#include <iostream>

using namespace std;

int main()
{
    //take value
    cout<<"How much numbers u want to sort?"<<endl;
    int n_sort;
    cin>>n_sort;
    //check value
    if(n_sort<=0 || n_sort>=100){
        cout<<"Not valuable number"<<endl;
        return 1;
    }
    //create memory
	int *tabptr = new int[n_sort], sum = 0;
    //insert values
    for(int i=0;i<n_sort;i++){
        cout<<"Enter the number: "<<i+1<<endl;
        cin>>tabptr[i];
    }
    //sort array
      bool swapped;
    do {
        swapped = false;
        for (int i = 0; i < n_sort; i++) {
        if (tabptr[i] > tabptr[i + 1]) {
            swapped = true;
            int aux = tabptr[i];
            tabptr[i] = tabptr[i + 1];
            tabptr[i + 1] = aux;
        }
        }
    } while (swapped);  
    //print sorted array
    cout<<"The sorted array is: "<<endl;
    for(int i =0;i<n_sort;i++){
        cout<<tabptr[i]<<endl;
    }
    //delete memory
    delete [] tabptr;
}
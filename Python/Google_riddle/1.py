from math import sqrt
from array import array

def solution(area):
    array_solution = []
    square = sqrt(area)
    for i in range(area+1,-1,-1):
        if(i>=9):
            #chekkare oppure fare in modo che se c'è un valore nell'array, deve riprendere dal valore dell'array
            sqrt_counter = sqrt(i)
            if sqrt_counter.is_integer():
                print("ok")
                array_solution.append(i)

    print(array_solution)



area = int(input("Introduce the area: "))
solution(area)
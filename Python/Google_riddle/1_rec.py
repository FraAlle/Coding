from math import sqrt
from array import array

def solution(area):
    area_int = int(area)
    square = sqrt(area_int)
    if(area_int>=9):
        if(square.is_integer):
            array_solution.append(area_int)
            area_int=-square
            solution(area_int)
        area_int=-1
        solution(area_int)
    print(array_solution)
    
array_solution = []
area = (input("Introduce the area: "))
solution(area)
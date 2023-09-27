/*
STRUCTURE contais any number of elements of any type, each one is called field
can be used inside vectors
*/

#include <iostream>
#include <string>
#include <vector>

using namespace std;

struct Student {
  string name;
  float time_spent;
  int recent_chapter;
};      //stdnt can be written here before ";" and his the same as the declaretion in main, u can create as much as u want

int main(){
    Student stdnt;       //stdnt.time_spent select time_Spent from stdnt, the variables are Student type(nor int,float, etc)
    stdnt.time_spent = 1.5;


    vector<Student> stdnts(100000);
    stdnts[0].name = "Bond";
    stdnts[0].time_spent = 3.5;
    stdnts[0].recent_chapter = 7;


    /*
    struct Date moon_landing = { 1969, 7, 20 };
    is the same as:
    date.year = 1969;
    date.month = 7;
    date.day = 20;

    Student she = { "Mata Hari", 12., 12, { 2012 }  };
    the blank spaces set the rest of the fields as 0----------->Student nobody = {};
    she.name= "Mata Hari";
    she.time_spent = 12.;
    she.recent_chapter = 12;
    she.last_visit.year = 2012;
    she.last_visit.month = 0;
    she.last_visit.day = 0;
    */
}
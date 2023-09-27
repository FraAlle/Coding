from random import *
import os
import string

user_pwd = input("Enter a password:")
pwd = list(string.digits + string.ascii_letters)

cracked_pw = ""
while(cracked_pw!=user_pwd):
    cracked_pw =""
    for letter in range(len(user_pwd)):
        guess_pwd = pwd[randint(0,9)]
        cracked_pw = str(guess_pwd) + str(cracked_pw)
        print(cracked_pw)
        print("Cracking password")
        os.system("cls")
print("Your password is: ",cracked_pw)

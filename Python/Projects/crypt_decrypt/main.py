#***********************************
#* script: cesare_encrypt.py       *
#* author: Francesco Allegrini     *
#***********************************
import random

encrypt = input("Metti cosa vuoi cifrare:")
alphabet = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0','1','2','3','4','5','6','7','8','9']
encrypt = encrypt.upper()
result = ""
for i in range(len(encrypt)):
    random_num = random.randint(0,5)                    # random number
    letter = encrypt[i]                                 # prende ogni singola lettera dell'input
    if(letter == " "):
        result += "."
    else:
        position = alphabet.index(letter)               # prende la posizione della lettera
        result += str(random_num)                       # aggiungi il numero random alla stringa finale
        new_letter = alphabet[position + random_num]    # 
        result += new_letter
print(result)
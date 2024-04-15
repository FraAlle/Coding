import secrets
import string

def main():    
    #make choices
    pwd_length = int(input("Insert ur pwd lenght: "))
    digits_F = str(input("Do u want numbers? Y/N "))
    digits_F = digits_F.upper()
    if ((digits_F == "Y") or (digits_F == "N")):
        if digits_F=='Y' or digits_F=='y':
            digits = string.digits
        else:
            digits = ''
    else:
        print("Wrong input")
        exit()
    chars_F = str(input("Do u want special characters? Y/N "))
    chars_F = chars_F.upper()
    if (chars_F == 'Y') or (chars_F == 'N'):
        if chars_F=='Y' or chars_F=='y':
            special_chars = string.punctuation
        else:
            special_chars = ''
    else:
        print("Wrong input")
        exit()

    # define the alphabet
    letters = string.ascii_letters
    alphabet = letters + digits + special_chars

    # generate a password string
    pwd = ''
    for i in range(pwd_length):
        pwd += ''.join(secrets.choice(alphabet))

    print(pwd)

if __name__ == "__main__":
    main()
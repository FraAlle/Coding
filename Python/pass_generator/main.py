import secrets
import string

#make choices
pwd_length = int(input("Insert ur pwd lenght: "))
digits_F = input("Do u want numbers? Y/N ")
chars_F = input("Do u want special characters? Y/N ")

# define the alphabet
letters = string.ascii_letters
if digits_F=='Y' or digits_F=='y':
    digits = string.digits
else:
    digits = ''
if chars_F=='Y' or chars_F=='y':
    special_chars = string.punctuation
else:
    special_chars = ''

alphabet = letters + digits + special_chars

# generate a password string
pwd = ''
for i in range(pwd_length):
  pwd += ''.join(secrets.choice(alphabet))

print(pwd)
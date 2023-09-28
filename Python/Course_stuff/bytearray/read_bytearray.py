#VERSIONE READ(INMUTABLE)

from os import strerror

try:
    binary_file = open('file.bin', 'rb')
    data = bytearray(binary_file.read(1))    #si puó mettere una larghezza fissa
    binary_file.close()

    for b in data:
        print(hex(b), end=' ')
except IOError as e:
    print("Se produjo un error de E/S:", strerror(e.errno))

#VERISIONE READINTO
data = bytearray(10)

try:
    binary_file = open('file.bin', 'rb')
    binary_file.readinto(data)
    binary_file.close()

    for b in data:
        print(hex(b), end=' ')
except IOError as e:
    print("Se produjo un error de E/S:", strerror(e.errno))


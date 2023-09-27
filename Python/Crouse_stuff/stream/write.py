from os import strerror

try:
    file = open('newtext.txt', 'wt')
    for i in range(10):
        file.write("linea #" + str(i+1) + "\n")
    file.close()
    print("File escrito")
except IOError as e:
    print("Se produjo un error de E/S:", strerror(e.errno))

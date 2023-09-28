try:
    stream = open("C:\\Users\\Predator\\Desktop\\DJ.txt", "r")
    counter = 0
    char = stream.read(1)
    while char != '':
        print(char, end='')
        counter += 1
        char = stream.read(1)
    stream.close()
    print("\n\nCaracteres en el archivo:", counter)
except IOError as exc:
    print(exc.errno)
except Exception as exc:
    print("No se puede abrir el archivo:", exc)


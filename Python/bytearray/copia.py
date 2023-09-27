from os import strerror

source_file_name = input("Pon el nombre del archivo:")
source_file_name = "txt\\"+source_file_name
try:
    source_file = open(source_file_name, 'rb')
    print("Abierto")
except IOError as e:
    print("No se puede abrir archivo fuente: ", strerror(e.errno))
    exit(e.errno)	

destination_file_name = input("Ingresa el nombre del archivo destino: ")
destination_file_name = "txt\\"+destination_file_name
try:
    destination_file = open(destination_file_name, 'wb')
    print("Archivo creado")
except Exception as e:
    print("No se puede crear el archivo de destino:", strerror(e.errno))
    source_file.close()
    exit(e.errno)	

buffer = bytearray(65536)
total  = 0
try:
    readin = source_file.readinto(buffer)
    while readin > 0:
        written = destination_file.write(buffer[:readin])
        total += written
        readin = source_file.readinto(buffer)
except IOError as e:
    print("No se puede crear el archivo de destino: ", strerror(e.errno))
    exit(e.errno)	
    
print(total,'byte(s) escritos con éxito')
source_file.close()
destination_file.close()

from os import strerror

data = bytearray(10)

for i in range(len(data)):
    data[i] = 10 + i
for x in range(len(data)):
    print(hex(data[x]))

try:
    binary_file = open('file.bin', 'wb')
    binary_file.write(data)
    binary_file.close()
except IOError as e:
    print("Se produjo un error de E/S:", strerror(e.errno))

# Ingresa aquí el código que lee los bytes del stream.

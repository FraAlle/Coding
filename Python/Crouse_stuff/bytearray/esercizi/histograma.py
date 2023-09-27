import os

source_file_name = input("Pon directorio y nombre del archivo:")
counters = {chr(ch):0 for ch in range(ord('a'),ord('z')+1)}

try:
    source_file = open(source_file_name,'rt')
    print("Texto abierto")
    for line in source_file:
        for char in line:
            if char.isalpha():
                counters[char.lower()]+=1
    source_file.close()

    destination_file_name = source_file_name.replace('.txt','.his')
    destination_file = open(destination_file_name,'wt')
    for i in sorted(counters.keys(),key=lambda x:counters[x],reverse=True):
        if counters[i]>0:
            print(i,'->',counters[i])
            destination_file.write(i + '->' + str(counters[i]) + '\n')

    
except IOError as e:
    print("No se puedo abrir el archivo",os.strerror(e.errno))


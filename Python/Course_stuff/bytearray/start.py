#datos amorfos: datos que no tienen una forma especifica
data = bytearray(10)
print(bytearray(3))
for i in range(len(data)):
    data[i] = 10 - i

print(hex(data[0]))     #0xa
print(data[0])          #10
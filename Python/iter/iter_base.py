#lista len() utilizzabile, return la lista intera
for v in [1 if x % 2 == 0 else 0 for x in range(10)]:
    print(v, end=" ")
print()

#generatore len() non utilizzabile. 
#I generatori return 1 elemento alla volta, preferibile nell'utilizzo di grandi liste
#Il generatore conserva in memoria le variabili locali anche dopo aver terminato l'esecuzione.
#Pertanto, se il generatore viene chiamato più volte, fornisce gli elementi in sequenza uno dopo l'altro
for v in (1 if x % 2 == 0 else 0 for x in range(10)):
    print(v, end=" ")
print()


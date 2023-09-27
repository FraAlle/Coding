def make_closure(par):
    loc = par           #viene preso loc dalla inizializzazione della variabile(quindi passa 2 e 3 e non cambiano)

    def power(p):       #mentre qui p é il valore del contatore i
        print("power: ",p)
        return p ** loc
    return power


fsqr = make_closure(2)      #sono come funzioni, se non invocate non fanno un cazzo
fcub = make_closure(3)

for i in range(5):
    print(i, fsqr(i), fcub(i))

#######################################################
def tag(tg):
    tg2 = tg
    tg2 = tg[0] + '/' + tg[1:]

    def inner(str):
        return tg + str + tg2
    return inner


b_tag = tag('<b>')
print(b_tag('Monty Python'))


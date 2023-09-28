# two = lambda: 2
# sqr = lambda x: x * x
# pwr = lambda x, y: x ** y

# for a in range(-2, 3):
#     print(sqr(a), end=" ")
#     print(pwr(a, two()))

############################################################################

def print_function(args, fun):
    for x in args:
        print('f(', x,')=', fun(x), sep='')

# def poly(x):
#     return 2 * x**2 - 4 * x + 2
#sostituisco poly per una funzione anonima lambda

print_function([x for x in range(-2, 3)], lambda x: 2 * x**2 - 4 * x + 2)

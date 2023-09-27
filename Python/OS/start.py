import platform,os

value = os.system("mkdir directory1\\directory2")
print(value)
value = os.system("rmdir -r directory1")
print(value)
print(os.listdir())
print(os.getcwd())
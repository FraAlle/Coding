from datetime import date,time,datetime
import time

d = date(1991, 2, 5)
print(d)
d = d.replace(year=1992, month=1, day=16)
print(d)

timestamp = time.time()         #secondi passati dal 1 gennaio 1970 ad adesso
print("Marca de tiempo:", timestamp)
d = date.fromtimestamp(timestamp)
print("Fecha:", d)

d = date.fromisoformat('2019-11-04')
print(d)

d = date(2023, 6, 22)
print(d.weekday())          #de 0 a 6


t = time(14, 53, 20, 1)
print("Tiempo:", t)
print("Hora:", t.hour)
print("Minuto:", t.minute)
print("Segundo:", t.second)
print("Microsegundo:", t.microsecond)

timestamp = 1572879180
print(time.ctime(timestamp))        #converte il time-stamp in una data reale 
print(time.gmtime(timestamp))       #returna l'oggetto time.struct_time in UTC
print(time.localtime(timestamp))    #returna la hora locale

timestamp = 1572879180
st = time.gmtime(timestamp)         #ottennere l'oggetto struct_time
print(time.asctime(st))             #converte struct_time in una catena
print(time.mktime((2019, 11, 4, 14, 53, 0, 0, 308, 0)))     #converte la data inserita in un numero di secondi dalla sequenza di Unix

dt = datetime(2019, 11, 4, 14, 53)
print("Fecha y Hora:", dt)
print("Fecha:", dt.date())
print("Hora:", dt.time())

print("hoy:", datetime.today())
print("ahora:", datetime.now())
print("utc_ahora:", datetime.utcnow())
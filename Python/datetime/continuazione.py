import datetime
import time

t = datetime.time(14, 53)
print(t.strftime("%H:%M:%S"))
dt = datetime.datetime(2020, 11, 4, 14, 53)
print(dt.strftime("%y/%B/%d %H:%M:%S"))

timestamp = 1572879180
st = time.gmtime(timestamp)     #crea la data usando il timestamp
print(time.strftime("%Y/%m/%d %H:%M:%S", st))   #stampa la data con il timestamp    
print(time.strftime("%Y/%m/%d %H:%M:%S"))       #stampa la data normale

print(datetime.datetime.strptime("2019/11/04 14:53:00", "%Y/%m/%d %H:%M:%S"))   #crea un oggetto datetime a partire dalla catena passata
print(time.strptime("2019/11/04 14:53:00", "%Y/%m/%d %H:%M:%S"))                #visualizzacione oggetto

d1 = datetime.date(2020, 11, 4)
d2 = datetime.date(2019, 11, 4)
print(d1 - d2)                      #differenza di due date senza contare ore e minuti
dt1 = datetime.datetime(2020, 11, 4, 0, 0, 0)
dt2 = datetime.datetime(2019, 11, 4, 14, 53, 0)
print(dt1 - dt2)                    #differenza di due date prendendo in conto ore e minuti

delta = datetime.timedelta(weeks=2, days=2, hours=3)        #oggetto per essere usato in differenza tra date
#cambia le 2 week in 14 giorni + 2 giorni + 3 ore = 16 days and 3:00:00
print("Timedelta: ",delta)
print("Días:", delta.days)
print("Segundos:", delta.seconds)                           #3 ore -> 60*60*3 = 10800
print("Microsegundos:", delta.microseconds)
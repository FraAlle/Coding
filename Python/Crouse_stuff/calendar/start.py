import calendar

#0 es lunes y 6 es domingo
print(calendar.calendar(2020,2,2,6,4))
print(calendar.month(2020,11))      #prmonth(2020,11)

calendar.setfirstweekday(calendar.MONDAY)   #setta la prima colonna al giorno indicato
calendar.prmonth(2020, 12)

print(calendar.weekday(2020, 12, 24))       #ritorna 3 quindi giovedí

a = calendar.weekheader(2)               #nome dei giorni con un massimo numero di caratteri indicato
print(a)

print(calendar.isleap(2020))            #returna true se l'anno é bisestile
print(calendar.leapdays(2010, 2021))    #returna el numero di anni bisestili dentro di un range

c = calendar.Calendar(calendar.SUNDAY)  #calendar.Calendar é un oggetto di calendar 
for weekday in c.iterweekdays():        #contatore giorni della settimana
    print(weekday, end=" ")

c = calendar.Calendar()
for date in c.itermonthdates(2019, 11): #motra tutti i giorni di novembre 2019
    print(date, end=" ")

for iter in c.itermonthdays(2019, 11):  
    print(iter, end=" ")

for data in c.monthdays2calendar(2020, 12): #returna una lista di settimane in un mese specifico
    print(data)

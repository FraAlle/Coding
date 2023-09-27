import datetime

delta = datetime.timedelta(weeks=2, days=2, hours=2)    #16 giorni e 2 ore
print(delta)

delta2 = delta * 2                                      #32 giorni e 4 ore
print(delta2)

d = datetime.date(2019, 10, 4) + delta2                 #04/10/2019 + 32 = 05/11/2019
print(d)

dt = datetime.datetime(2019, 10, 4, 14, 53) + delta2    #04/10/2019 14:53 + 32giorni e 4ore = 05/11/2019 18:53:00
print(dt)
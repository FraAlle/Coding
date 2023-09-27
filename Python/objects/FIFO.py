class QueueError(IndexError):  # Eligir la clase base para la nueva excepción.
    pass


class Queue:
    def __init__(self):
        self.__que = []


    def put(self, elem):
        self.__que.insert(0,elem)

    def get(self):
        if len(self.__que) > 0:
            elem = self.__que[-1]
            del self.__que[-1]
            return elem
        else:
            raise QueueError


que = Queue()
que.put(1)
que.put("perro")
que.put(False)
try:
    for i in range(4):
        print(que.get())
except:
    print("Error de Cola")

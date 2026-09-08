import threading

from backend.processing_server.src.models import State

class Service:

    actual_state: State = State.WAITING
    lock = threading.Lock()
    sensors = {}

    def __init__(self):
        pass

    def change_state(self):

        if (self.actual_state == State.WARNING):
            self.actual_state = State.PROCESSING

        elif (self.actual_state == State.PROCESSING):
            self.actual_state = State.WARNING
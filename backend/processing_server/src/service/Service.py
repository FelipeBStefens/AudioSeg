import threading

from backend.processing_server.src.models import State

class Service:

    actual_state: State = State.WAITING
    lock = threading.Lock()
    sensors = {}

    def __init__(self):
        pass
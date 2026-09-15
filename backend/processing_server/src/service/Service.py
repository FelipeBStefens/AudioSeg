import threading

from backend.processing_server.src.models import Sensor, State

class Service:

    actual_state: State = State.WAITING
    lock = threading.Lock()
    sensors = {}

    def __init__(self, sensors_used):

        for index in range(sensors_used):
            sensor = Sensor(index + 1, False, None, None)
            self.sensors[index + 1] = sensor
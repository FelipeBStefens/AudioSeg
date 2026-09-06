import src.models.Point as Point

class Sensor:

    toa: float = 0
    signal = []

    def __init__(self, toa, signal):
        self.toa = toa
        self.signal = signal

    @staticmethod
    def calculate_own_pos():
        ...

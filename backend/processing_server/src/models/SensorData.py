
class SensorData:

    toa: float = 0
    signal = []

    def __init__(self, toa, signal):
        self.toa = toa
        self.signal = signal

    
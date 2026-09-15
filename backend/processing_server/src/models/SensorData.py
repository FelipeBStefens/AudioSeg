
class SensorData:

    tdoa = 0
    signal = None

    def __init__(self, tdoa, signal):
        self.tdoa = tdoa
        self.signal = signal

    
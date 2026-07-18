
class ConnectionModeException(Exception):

    def __init__(self, connection_mode):
        super().__init__(f"Connection Mode {connection_mode} not identified...")


class ConnectionNotEstablished(Exception):

    def __init__(self, message):
        super().__init__(f"Cound not connect all Sensors: {message}")
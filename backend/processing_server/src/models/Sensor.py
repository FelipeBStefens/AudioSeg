from backend.processing_server.src.models import Point

class Sensor:

    point = None
    online = False
    last_seen = None

    def __init__(self, longitude, latitude, height, online, last_seen):

        self.point = Point(longitude, latitude, height)
        self.online = online
        self.last_seen = last_seen

    def __init__(self, point, online, last_seen):

        self.point = point
        self.online = online
        self.last_seen = last_seen

    # To work
    @staticmethod
    def calculate_own_pos():
        pass
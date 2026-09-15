from backend.processing_server.src.models import Point

class Sensor:

    sensor_id = 0
    online = False
    last_seen = None
    position = None

    def __init__(self, sensor_id, online, last_seen, longitude, latitude, height):

        self.sensor_id = sensor_id
        self.online = online
        self.last_seen = last_seen
        self.position = Point(longitude, latitude, height)
        
    def __init__(self, sensor_id, online, last_seen, position):

        self.sensor_id = sensor_id
        self.online = online
        self.last_seen = last_seen
        self.position = position

    # To work
    @staticmethod
    def calculate_own_pos():
        pass
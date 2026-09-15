import time

from backend.processing_server.src.connection.connection import open_heart_beat_server, receive_heart_beat
from backend.processing_server.src.models import Point, State

def heart_beat(connection_mode, sensors_used, key, time_to_close_sensor, service):

    server = open_heart_beat_server(connection_mode)

    while True:

        message = receive_heart_beat(connection_mode, server, key)

        longitude = message["longitude"]
        latitude = message["latitude"]
        height = message["height"]

        sensor_id = message["sensor_id"]
        now = time.time()
        sensor_position = Point(longitude, latitude, height)

        with service.lock:

            if (message is not None):

                sensor = service.sensors[sensor_id]
                sensor.online = True
                sensor.last_seen = now
                sensor.position = sensor_position

            online_sensors = 0
            for sensor in service.sensors.values():

                if (now - sensor.last_seen > time_to_close_sensor):
                    sensor.online = False

                elif (sensor.online == True):
                    online_sensors += 1

            if (online_sensors >= sensors_used):
                service.state = State.PROCESSING

            else:
                service.state = State.WAITING
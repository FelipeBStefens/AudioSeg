import time

from backend.processing_server.src.connection.connection import open_heart_beat_server, receive_heart_beat
from backend.processing_server.src.models import State

def heart_beat(sensors_used, service):

    server = open_heart_beat_server()
    while True:

        sensor_id = receive_heart_beat(server)
        now = time.time()

        with service.lock:

            if (sensor_id is not None):

                if (sensor_id not in service.sensors):
                    service.sensors[sensor_id] = {
                        "online": True,
                        "last_seen": now
                    }
                else:
                    service.sensors[sensor_id]["online"] = True
                    service.sensors[sensor_id]["last_seen"] = now

            for sensor in service.sensors.values():

                if (now - sensor["last_seen"] > 15):
                    sensor["online"] = False

            online = sum(
                sensor["online"]
                for sensor in service.sensors.values()
            )

            if (online >= sensors_used):
                service.state = State.PROCESSING

            else:
                service.state = State.WAITING
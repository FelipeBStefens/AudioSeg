import time

from backend.processing_server.src.connection.connection import open_heart_beat_server, receive_heart_beat

def heart_beat(sensors_used, service):

    open_heart_beat_server()

    while True:
        with service.lock:

            sensor = receive_heart_beat()

            # Not made yet...
            
            now = time.time()
    
            for sensor_id, sensor in service.sensors.items():
    
                if now - sensor["last_seen"] > 15:
                    sensor["online"] = False
    
            online = sum(
                sensor["online"]
                for sensor in service.sensors.values()
            )
    
            if online >= sensors_used:
                service.state = "PROCESSING"

            else:
                service.state = "WAITING"
    
        time.sleep(1)
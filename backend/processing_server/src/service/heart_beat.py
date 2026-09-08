import time

def heart_beat(sensors_used, service):

    while True:
        with service.lock:
    
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
import time

def process(service):

    while True:

        with service.lock:
            current_state = service.state

        if current_state == "PROCESSING":
            pass
            # Processing Data...

        else:
            pass

        time.sleep(2)
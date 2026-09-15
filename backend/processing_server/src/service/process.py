import time

from backend.processing_server.src.models import State

def process(service):

    while True:

        with service.lock:
            current_state = service.state

        if (current_state == State.PROCESSING):
            pass
            # Processing Data...
            
        else:
            pass

        time.sleep(2)
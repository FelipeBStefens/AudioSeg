import threading

from backend.processing_server.src.connection.connection import accept_connection, close_connection, open_receive_server, receive_data
from backend.processing_server.src.models import SensorData, State

def handle_sensor(connection_mode, connection, service, key):

    while True:

        message = receive_data(connection_mode, connection, key)

        if (message is None):
            break

        with service.lock:

            if (service.state == State.PROCESSING):

                tdoa = message["tdoa"]
                signal = message["signal"]

                sensor_data = SensorData(tdoa, signal)
                print(sensor_data)

    close_connection(connection_mode, connection)

def receiver(connection_mode, key, service):

    server = open_receive_server(connection_mode)

    while True:

        connection = accept_connection(connection_mode, server)

        thread = threading.Thread(
            target=handle_sensor,
            args=(connection_mode, connection, service, key),
            daemon=True
        )

        thread.start()
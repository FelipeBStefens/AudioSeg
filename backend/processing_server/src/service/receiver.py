import threading

from backend.processing_server.src.connection.connection import accept_connection, close_connection, open_receive_server, receive_data
from backend.processing_server.src.models import State

def handle_sensor(connection_mode, connection, service):

    while True:

        message = receive_data(connection_mode, connection)

        if (message is None):
            break

        with service.lock:

            if (service.state == State.PROCESSING):
                print(message)

    close_connection(connection_mode, connection)

def receiver(connection_mode, service):

    server = open_receive_server(connection_mode)

    while True:

        connection = accept_connection(connection_mode, server)

        thread = threading.Thread(
            target=handle_sensor,
            args=(connection_mode, connection, service),
            daemon=True
        )

        thread.start()
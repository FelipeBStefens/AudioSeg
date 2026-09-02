from backend.processing_server.src.config.dotenv_loader import load_dotenv_wifi_values
from backend.processing_server.src.exception.connection_exception import ConnectionModeException, ConnectionNotEstablished
from backend.processing_server.src.exception.wifi_exception import SSHException

def connect(connection_mode):

    # LoRa connection
    if (connection_mode == 0):
        pass

    # Wi-Fi connection
    elif (connection_mode == 1):
        
        server, sensors = load_dotenv_wifi_values()

        for sensor in sensors:

            try:
                # start_connection(sensor[0], sensor[1], sensor[2])
                pass

            except SSHException as exception:
                raise ConnectionNotEstablished(str(exception))
        
        return

    raise ConnectionModeException(connection_mode)

# Method to send values;
def send(connection_mode):

    if (connection_mode == 0):
        pass

    elif (connection_mode == 1):
        pass

# Method to receive values (If used);
def receive(connection_mode):

    if (connection_mode == 0):
        pass
    
    elif (connection_mode == 1):
        pass
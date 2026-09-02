from backend.processing_server.src.config.dotenv_loader import load_dotenv_wifi_values
from backend.processing_server.src.connection.wifi.wifi_connection import openServer, sendTo
from backend.processing_server.src.exception.connection_exception import ConnectionModeException, ConnectionNotEstablished

# Connect to all sensors;
def connect(connection_mode):

    # LoRa connection
    if (connection_mode == 0):
        pass

    # Wi-Fi connection
    elif (connection_mode == 1):

        server_door, sensors_ip = load_dotenv_wifi_values()
        # Terminar Conexão

    raise ConnectionModeException(connection_mode)

# Method to verify if all the connections are working;
def verifyConnect(connection_mode, key):

    if (connection_mode == 0):
        pass
    
    elif (connection_mode == 1):

        _, sensors_ip = load_dotenv_wifi_values()

        for sensor_ip in sensors_ip:
            sendTo(sensor_ip) 


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
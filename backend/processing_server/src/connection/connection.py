from backend.processing_server.src.config.dotenv_loader import load_dotenv_wifi_values
from backend.processing_server.src.connection.wifi.secure_shell_connection import start_connection

def connect(connection_mode):

    # LoRa connection
    if (connection_mode == 0):
        pass

    # Wi-Fi connection
    elif (connection_mode == 1):
        
        server, sensors = load_dotenv_wifi_values()

        # Testing Dotenv values
        print(server)
        print(sensors)

        # Testing SSH connection
        # HAVEN'T TESTED YET
        for sensor in sensors:

            start_connection(sensor[0], sensor[1], sensor[2])
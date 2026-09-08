from backend.processing_server.src.config.dotenv_loader import load_heart_beat_server
from backend.processing_server.src.connection.wifi.wifi_connection import open_server, receive_from

def open_heart_beat_server(connection_mode):

    if (connection_mode == 0):
        pass

    elif (connection_mode == 1):
        
        host, port = load_heart_beat_server()
        server = open_server(host, port)

        return server
    
def receive_heart_beat(connection_mode, server):

    if (connection_mode == 0):
        pass
    
    elif (connection_mode == 1):
            
        message = receive_from(server)
        return message
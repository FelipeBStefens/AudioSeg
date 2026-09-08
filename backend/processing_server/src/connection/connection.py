from backend.processing_server.src.config.dotenv_loader import load_heart_beat_server, load_receive_server
from backend.processing_server.src.connection.wifi.wifi_connection import open_server, receive_from

def open_heart_beat_server(connection_mode):

    if (connection_mode == 0):
        pass

    elif (connection_mode == 1):
        
        host, port = load_heart_beat_server()
        server = open_server(host, port)

        return server

def open_receive_server(connection_mode):

    if (connection_mode == 0):
        pass

    elif (connection_mode == 1):
        
        host, port = load_receive_server()
        server = open_server(host, port)

        return server
 
def receive_heart_beat(connection_mode, server):

    if (connection_mode == 0):
        pass
    
    elif (connection_mode == 1):
            
        message = receive_from(server)
        return message

def receive_data(connection_mode, connection):

    if (connection_mode == 0):
        pass
        
    elif (connection_mode == 1):
        data = connection.recv(1024)

        if not data:
            return None

        return data.decode().strip()

def accept_connection(connection_mode, server):

    if (connection_mode == 0):
        pass
        
    elif (connection_mode == 1):

        conn, _ = server.accept()
        return conn

def close_connection(connection_mode, connection):

    if (connection_mode == 0):
        pass
            
    elif (connection_mode == 1):
        connection.close()
import socket

def open_server(host, port):

    server = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    server.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
    
    server.bind((host, port))
    server.listen()
    
    return server

def receive_from(server):

    connection, address = server.accept()
    
    try:
        data = connection.recv(1024)
    
        if (not data):
            return None
    
        message = data.decode().strip()
        return message
            
    finally:
        connection.close()
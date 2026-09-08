import socket
import threading
import time

def handle_sensor(conn, addr, service):

    sensor_id = conn.recv(1024).decode().strip()

    with service.lock:
        service.sensors[sensor_id] = {
            "conn": conn,
            "last_seen": time.time(),
            "online": True
        }

    print(f"Sensor {sensor_id} conectado: {addr}")

    try:
        while True:

            data = conn.recv(1024)

            if not data:
                break

            message = data.decode().strip()

            with service.lock:
                service.sensors[sensor_id]["last_seen"] = time.time()

            print(f"Sensor {sensor_id}: {message}")

    except ConnectionError:
        pass

    finally:

        with service.lock:
            if sensor_id in service.sensors:
                service.sensors[sensor_id]["online"] = False

        print(f"Sensor {sensor_id} desconectou")

        conn.close()

def receiver(HOST, PORT, service):

    server = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

    server.bind((HOST, PORT))
    server.listen()

    print(f"Servidor ouvindo em {HOST}:{PORT}")

    while True:

        conn, addr = server.accept()

        thread = threading.Thread(
            target=handle_sensor,
            args=(conn, addr, service),
            daemon=True
        )

        thread.start()
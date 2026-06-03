from dotenv_loader import find_dotenv, load_dotenv_values
from connection.secure_shell_connection import start_connection

find_dotenv()
server, sensors = load_dotenv_values()

# Testing Dotenv values
print(server)
print(sensors)

# Testing SSH connection
# HAVEN'T TESTED YET
for sensor in sensors:

    start_connection(sensor[0], sensor[1], sensor[2])
from backend.processing_server.src.exception.dotenv_exception import LoadDotEnvException, LoadValueDotEnvException

from pathlib import Path
from dotenv import load_dotenv

import os

# Method to Load the values on dotenv file to the OS
def find_dotenv():

    current = Path(__file__).resolve()

    for parent in current.parents:
    
        env_path = parent / ".env"
        if env_path.exists():
            
            load_dotenv(env_path)
            return
    
    raise LoadDotEnvException()

# Method to get values on variables on dotenv file
def load_value(variable):

    value = os.getenv(variable)

    if (value is None):
        raise LoadValueDotEnvException(variable)

    else:
        return value

# Method to Load the special configurations 
def load_dotenv_config():

    key = load_value("SECURITY_SIMETRIC_KEY")
    connection_mode = int(load_value("CONNECTION_MODE"))

    return key, connection_mode

# Method to Load the Wi-Fi configurations
def load_dotenv_wifi_values():

    server_ip = load_value("IP_SERVER")
    server_door = load_value("DOOR_SERVER")

    SENSORS_NAME = ["ONE", "TWO", "THREE", "FOUR", "FIVE"]
    sensors_ip = []

    for sensor in SENSORS_NAME:

        ip = load_value(f"IP_SENSOR_{sensor}")
        sensors_ip.append(ip)
        
    return server_ip, server_door, sensors_ip
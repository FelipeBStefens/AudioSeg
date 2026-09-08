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

# Method to load Heart Beat Server Wi-Fi config
def load_heart_beat_server():

    host = load_value("IP_SERVER")
    port = load_value("PORT_HEART_BEAT_SERVER")

    return host, port
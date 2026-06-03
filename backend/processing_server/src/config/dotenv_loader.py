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
    
    raise FileNotFoundError("Not found the Dotenv File")

# Method to return the env values of the OS to the code
def load_dotenv_values():

    server = [os.getenv("IP_SERVER"), os.getenv("DOOR_SERVER")]

    sensors_name = ["ONE", "TWO", "THREE", "FOUR", "FIVE"]
    sensors = []

    for sensor in sensors_name:

        ip = os.getenv(f"IP_SENSOR_{sensor}")
        user = os.getenv(f"USER_SENSOR_{sensor}")
        password = os.getenv(f"PASSWORD_SENSOR_{sensor}")

        sensors.append([ip, user, password])
    
    return server, sensors
from backend.processing_server.src.config.dotenv_loader import find_dotenv, load_dotenv_config
from backend.processing_server.src.connection.connection import connect

find_dotenv()
connection_mode = load_dotenv_config()

connect()
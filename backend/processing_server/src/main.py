from backend.processing_server.src.config.dotenv_loader import find_dotenv, load_dotenv_config
from backend.processing_server.src.config.security_key import encode, decode
from backend.processing_server.src.connection.connection import connect

find_dotenv()
key, connection_mode = load_dotenv_config()

# connect(connection_mode)

# Realizar a conexão
# Mandar os sensores gravarem e pegar os valores
# Localizar qual ponto ocorreu o disparo
# Detectar qual a classificação do disparo 
# Enviar ao Data_Server
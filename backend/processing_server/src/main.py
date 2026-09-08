import threading
import time

from backend.processing_server.src.config.dotenv_loader import find_dotenv, load_dotenv_config
from backend.processing_server.src.service.Service import Service
from backend.processing_server.src.service import heart_beat, receiver, process

find_dotenv()
key, connection_mode = load_dotenv_config()

service = Service()

threading.Thread(
    target=receiver,
    args=("host", 5000, service),
    daemon=True
).start()

threading.Thread(
    target=heart_beat,
    args=(4, service),
    daemon=True
).start()

threading.Thread(
    target=process,
    args=(service),
    daemon=True
).start()

while True:
    time.sleep(1)

# Realizar a conexão
# Mandar os sensores gravarem e pegar os valores
# Localizar qual ponto ocorreu o disparo
# Detectar qual a classificação do disparo 
# Enviar ao Data_Server
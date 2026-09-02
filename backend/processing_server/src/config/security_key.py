import os
import base64
from cryptography.hazmat.primitives.ciphers.aead import AESGCM

from backend.processing_server.src.exception.security_exception import FailedDecodeMessage

def start_cryptography(key):

    binary_key = bytes.fromhex(key)
    return AESGCM(binary_key)

def encode(message, key):
    
    cryptography = start_cryptography(key)
    nonce = os.urandom(12)

    binary_message = message.encode('utf-8')
    
    cryptography_message = cryptography.encrypt(nonce, binary_message, None)
    cryptography_packet = nonce + cryptography_message
    
    return base64.b64encode(cryptography_packet).decode('utf-8')

def decode(encode_message, key):
    
    cryptography = start_cryptography(key)

    try:
        cryptography_packet = base64.b64decode(encode_message.encode('utf-8'))
        
        nonce = cryptography_packet[:12]
        cryptography_message = cryptography_packet[12:]
        
        binary_message = cryptography.decrypt(nonce, cryptography_message, None)
        
        return binary_message.decode('utf-8')
        
    except Exception:
        raise FailedDecodeMessage()

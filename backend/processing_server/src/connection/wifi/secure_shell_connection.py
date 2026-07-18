import paramiko
import socket

from backend.processing_server.src.exception.wifi_exception import AuthenticationException, BlockedException, ConnectCommandException, SSHException, UnreachbleClientException

def start_connection(ip, username, password):

    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())

    COMMAND = "nohup python3 Sensor1/Pasta_fodona/arquivo_fodao.py run > /dev/null 2>&1 &"

    try:
        
        ssh.connect(ip, username, password)
        stdin, stdout, stderr = ssh.exec_command(COMMAND)

        error = stderr.read().decode('utf-8')
        
        if (error):
            raise ConnectCommandException()

    except (paramiko.AuthenticationException):
        raise AuthenticationException() 

    except (paramiko.ssh_exception.NoValidConnectionsError):
        raise BlockedException()

    except (TimeoutError, socket.timeout):
        raise UnreachbleClientException()

    except (paramiko.SSHException):
        raise SSHException()

    finally:
        ssh.close()
    
    return True
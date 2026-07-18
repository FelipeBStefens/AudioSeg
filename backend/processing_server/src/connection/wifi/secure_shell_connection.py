import paramiko

# Method to start a connection with client
# HAVEN'T TESTED YET
def start_connection(ip, username, password):

    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())

    COMMAND = "nohup python3 Sensor1/Pasta_fodona/arquivo_fodao.py run > /dev/null 2>&1 &"

    try:
        
        ssh.connect(ip, username, password)
        stdin, stdout, stderr = ssh.exec_command(COMMAND)

        error = stderr.read().decode('utf-8')
        
        if (error):
            raise Exception("Failed to enter in path or run python file")

    except Exception as e:
        return False, str(e)

    finally:
        ssh.close()
    
    return True, "connected"
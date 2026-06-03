import paramiko

# Method to start a connection with client
# HAVEN'T TESTED YET
def start_connection(ip, username, password):

    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())

    ssh.connect(ip, username, password)

    # An example of how to implement SSH comands on clients
    stdin, stdout, stderr = ssh.exec_command("echo Test")
    print(stdout.read().decode())

    ssh.close()
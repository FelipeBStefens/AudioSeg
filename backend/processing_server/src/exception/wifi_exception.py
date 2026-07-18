class SSHException(Exception):

    def __init__(self, message="Could Not Connect on Client with SSH protocol..."):
        super().__init__(message)


class AuthenticationException(SSHException):

    def __init__(self):
        super().__init__("Incorrect Authentication...")

class BlockedException(SSHException):

    def __init__(self):
        super().__init__("SSH blocked...")

class UnreachbleClientException(SSHException):

    def __init__(self):
        super().__init__("Could Not reach Client...")

class ConnectCommandException(SSHException):

    def __init__(self):
        super().__init__("Could not enter in Path or Run Python File on Client...")
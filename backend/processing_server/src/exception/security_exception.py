
class FailedDecodeMessage(Exception):

    def __init__(self):
        super().__init__(f"Cound not decode the message using the key...")
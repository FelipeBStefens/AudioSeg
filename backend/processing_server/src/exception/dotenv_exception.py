
class LoadDotEnvException(Exception):

    def __init__(self):
        super().__init__("Cound not Load DotEnv File...")


class LoadValueDotEnvException(Exception):

    def __init__(self, variable=""):
        super().__init__(f"Cound not Load {variable} on DotEnv File...")
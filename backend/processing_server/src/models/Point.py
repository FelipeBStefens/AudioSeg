
class Point:
    
    x:float = 0
    y:float = 0
    z:float = 0

    def __init__(self, long:float, lat:float, alt:float):
        self.x = long
        self.y = lat
        self.z = alt
from backend.processing_server.src.models.Point import Point
from coordinates_transform import cartesian_coordinate, geographic_coordinate

# Test
point1 = Point(-51.2177, -30.0346, 15)
point2 = Point(-51.1836, -29.9177, 301)
point3 = Point(-50.9928, -29.9433, 0)
point4 = Point(-51.1497, -29.7544, 43)
point5 = Point(-51.1328, -29.6875, -5)

print(cartesian_coordinate(point1, point2, point3, point4, point5))

point_test = geographic_coordinate(point1, 8173.676846636606, 3787.198204682932, 286)
print(point_test.longitude, point_test.latitude, point_test.height)
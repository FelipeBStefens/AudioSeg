from pyproj import CRS, Transformer
from backend.processing_server.src.models.Point import Point

def get_center_reference(origin):

    system = (
        f"+proj=aeqd "
        f"+lat_0={origin.latitude} "
        f"+lon_0={origin.longitude} "
        "+datum=WGS84 "
        "+units=m"
    )

    return CRS.from_proj4(system)

# Get all coordinates by putting longitude, latitude and height points
# azimuthal equidistant position
def cartesian_coordinate(*points):

    origin = points[0]
    center_reference = get_center_reference(origin)
    transformer = Transformer.from_crs("EPSG:4326", center_reference, always_xy=True)

    positions = []
    for point in points:    

        x, y = transformer.transform(point.longitude, point.latitude)
        z = point.height - origin.height

        positions.append((x, y, z))

    return positions

# Getting the longitude, latitude and height posicion by origin point
def geographic_coordinate(origin, x, y, z):

    center_reference = get_center_reference(origin)
    transformer = Transformer.from_crs(center_reference, "EPSG:4326", always_xy=True)

    longitude, latitude = transformer.transform(x, y)
    height = z + origin.height

    return Point(longitude, latitude, height)
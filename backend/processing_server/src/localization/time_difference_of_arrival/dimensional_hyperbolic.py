import numpy as np

class Sensor():
    def __init__(self, x,y,z, toa):
        self.x = x
        self.y = y
        self.z = z
        self.toa = toa
        

SOUND_VELOCITY = 340

def hyperbolic_position(sensors):
    assert len(sensors) == 4

    r, x, y, z = [], [], [], []
    for i in range(4):
        x += [[]]
        y += [[]]
        z += [[]]
        r += [[]]
        for j in range(4):
            if i == j:
                x[i] += [sensors[i].x]
                y[i] += [sensors[i].y]
                z[i] += [sensors[i].z]
                r[i] += [0]
            else:
                x[i] += [sensors[i].x - sensors[j].x]
                y[i] += [sensors[i].y - sensors[j].y]
                z[i] += [sensors[i].z - sensors[j].z]
                r[i] += [sensors[i].toa - sensors[j].toa]
                r[i][j] *= SOUND_VELOCITY

    i, j, k, l = 0, 1, 2, 3

    a1 = r[i][k] * x[j][i] - r[i][j] * x[k][i]
    a2 = r[i][j] * y[k][i] - r[i][k] * y[j][i]

    A = a1 / a2

    # ----------> VERIFICAR a2 <----------

    b1 = r[i][k] * z[j][i] - r[i][j] * z[k][i]
    b2 = a2

    B = b1 / b2

    cn1aux = r[i][j]**2 + x[i][i]**2 - x[j][j]**2 + y[i][i]**2 - y[j][j]**2 + z[i][i]**2 - z[j][j]**2
    cn1 = r[i][k] * cn1aux
    cn2aux = r[i][k]**2 + x[i][i]**2 - x[k][k]**2 + y[i][i]**2 - y[k][k]**2 + z[i][i]**2 - z[k][k]**2
    cn2 = r[i][j] * cn2aux
    cd = 2 * a2

    C = (cn1 - cn2) / cd

    dn = r[k][l] * x[j][k] - r[k][j] * x[l][k]
    dd = r[k][j] * y[l][k] - r[k][l] * y[j][k]
    D = dn / dd

    # ----------> VERIFICAR  <----------

    en = r[k][l] * z[j][k] - r[k][j] * z[l][k]
    ed = dd
    E = en / ed

    fn1aux = r[k][j]**2 + x[k][k]**2 - x[j][j]**2 + y[k][k]**2 - y[j][j]**2 + z[k][k]**2 - z[j][j]**2
    fn1 = r[k][l] * fn1aux
    fn2aux = r[k][l]**2 + x[k][k]**2 - x[l][l]**2 + y[k][k]**2 - y[l][l]**2 + z[k][k]**2 - z[l][l]**2
    fn2 = r[k][j] * fn2aux
    fd = 2 * dd
    F = (fn1 - fn2) / fd

    gn = E - B
    gd = A - D
    G = gn / gd

    hn = F - C
    hd = A - D
    H = hn / hd

    I = A * G + B
    J = A * H + C

    kn1 = r[i][k]**2 + x[i][i]**2 - x[k][k]**2 + y[i][i]**2 - y[k][k]**2 + z[i][i]**2 - z[k][k]**2
    kn2 = x[k][i] * H + y[k][i] * J
    K = kn1 + 2 * kn2

    ln = x[k][i] * G + y[k][i] * I + z[k][i]
    L = 2*ln

    mn1aux = G**2 + I ** 2 + 1
    mn1 = 4 * r[i][k] ** 2 * mn1aux
    mn2 = L ** 2
    M = mn1 - mn2

    nn1aux = G * (x[i][i] - H) + I * (y[i][i] - J) + z[i][i]
    nn1 = 8 * r[i][k] ** 2 * nn1aux
    nn2 = 2 * L * K
    N = nn1 + nn2

    on1aux = (x[i][i] - H) ** 2 + (y[i][i] - J) ** 2 + z[i][i] ** 2
    on1 = 4 * r[i][k] ** 2 * on1aux
    on2 = K ** 2
    O = on1 - on2

    disc1 = N / (2 * M)
    disc2 = O / M
    disc = disc1 ** 2 - disc2

    if disc < 0:
        disc = 0
    else:
        disc = np.sqrt(disc)

    z1 = disc1 + disc
    z2 = disc1 - disc

    def make_y(_z):
        return I * _z + J

    y1 = make_y(z1)
    y2 = make_y(z2)

    def make_x(_z):
        return G * _z + H

    x1 = make_x(z1)
    x2 = make_x(z2)

    solutions = [(x1, y1, z1), (x2, y2, z2)]
    return solutions

s1 = Sensor(2, 3, 4, 0.0308)
s2 = Sensor(12, 5, 8, 0.0207)
s3 = Sensor(4, 15, 7, 0.0229)
s4 = Sensor(9, 8, 17, 0.0188)

sensores = [s1,s2,s3,s4]

print(hyperbolic_position(sensores))
class Keyframe {
  constructor(instant, tx, ty, tz, rx, ry, rz, sx, sy, sz) {
    this.instant = instant;
    this.translation = [tx, ty, tz];
    this.rotation = [rx, ry, rz];
    this.scale = [sx, sy, sz];
    this.nextKF = null;
  }
}

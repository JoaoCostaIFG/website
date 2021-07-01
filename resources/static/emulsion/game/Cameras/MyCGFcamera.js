/**
 * MyCGFcamera
 * @constructor
 * @param fov - fild of view
 * @param near - near component
 * @param far - far component
 * @param position - camera's position
 * @param target - camera's target
 */
class MyCGFcamera extends CGFcamera {
  constructor(name, fov, near, far, position, target) {
    super(fov, near, far, position, target);

    this.name = name;
    this.initPosition = vec4.fromValues(...position, 0);
    this.initTarget = vec4.fromValues(...target, 0);
    this.initUp = vec3.fromValues(0, 1, 0);
    this.initFov = fov;
    this.initNear = near;
    this.initFar = far;

    // animation end
    this.endPos = vec4.create();
    this.endTarget = vec4.create();
    this.endUp = vec3.create();
    this.endFov = 0;
    this.endNear = 0;
    this.endFar = 0;
    // animation current
    this.currPos = vec4.create();
    this.currTarget = vec4.create();
    this.currUp = vec3.create();
    this.currFov = 0;
    this.currNear = 0;
    this.currFar = 0;
    this.isAnimating = false;
  }

  /**
   * Reset camera to its initial state
   */
  reset() {
    vec4.copy(this.position, this.initPosition);
    vec4.copy(this.target, this.initTarget);
    vec3.copy(this._up, this.initUp);
    this.direction = this.calculateDirection();

    this.fov = this.initFov;
    this.near = this.initNear;
    this.far = this.initFar;

    this.isAnimating = false;
  }

  resetAnim() {
    this.startAnim(this);
  }

  startAnim(endCam) {
    // start
    vec4.copy(this.currPos, this.position);
    vec4.copy(this.currTarget, this.target);
    vec3.copy(this.currUp, this._up);
    this.currFov = this.fov;
    this.currNear = this.near;
    this.currFar = this.far;

    // end
    vec4.copy(this.endPos, endCam.initPosition);
    vec4.copy(this.endTarget, endCam.initTarget);
    vec3.copy(this.endUp, endCam.initUp);
    if (endCam.initFov) this.endFov = endCam.initFov;
    else this.endFov = null;
    this.endNear = endCam.initNear;
    this.endFar = endCam.initFar;

    this.isAnimating = true;
    this.lastTime = Date.now() / 1000.0;
    this.sumT = 0;
  }

  update(t) {
    if (!this.isAnimating) return;

    this.sumT += t - this.lastTime;
    this.lastTime = t;

    let timePerc = this.sumT; // divide by number of secs
    if (timePerc >= 1) {
      // animation is done
      timePerc = 1;
      this.isAnimating = false;
    }

    let lerpT = -(Math.cos(Math.PI * timePerc) - 1) / 2;

    vec4.lerp(this.position, this.currPos, this.endPos, lerpT);
    vec4.lerp(this.target, this.currTarget, this.endTarget, lerpT);
    vec3.lerp(this._up, this.currUp, this.endUp, lerpT);
    this.direction = this.calculateDirection();

    if (this.endFov)
      this.fov = this.currFov + (this.endFov - this.currFov) * lerpT;
    this.near = this.currNear + (this.endNear - this.currNear) * lerpT;
    this.far = this.currFar + (this.endFar - this.currFar) * lerpT;
  }
}

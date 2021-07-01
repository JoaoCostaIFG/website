class KeyframeAnimation extends Animation {
  constructor(scene, id, keyframes) {
    super(keyframes[0], keyframes[1]);
    this.keyframes = keyframes;

    this.scene = scene;
    this.id = id;

    this.reset();
  }

  genMatrix() {
    this.tgMatrix = mat4.create();
    mat4.translate(this.tgMatrix, this.tgMatrix, this.translation);
    mat4.rotateX(this.tgMatrix, this.tgMatrix, this.rotation[0]);
    mat4.rotateY(this.tgMatrix, this.tgMatrix, this.rotation[1]);
    mat4.rotateZ(this.tgMatrix, this.tgMatrix, this.rotation[2]);
    mat4.scale(this.tgMatrix, this.tgMatrix, this.scale);
  }

  reset() {
    super.reset();

    this.lastKF = this.keyframes[this.keyframes.length - 1];

    this.seg = 0;
    this.isDone = this.keyframes.length <= 0; // don't do anything if we don't have KF
    if (this.keyframeF != null && this.keyframeI != null)
      this.currKFDuration = this.keyframeF.instant - this.keyframeI.instant;

    // in case of animations that start immediatly, this preventes initial flickering
    if (this.keyframeI && this.keyframeI.instant == 0) {
      this.translation = vec3.fromValues(...this.keyframeI.translation);
      this.rotation = vec3.fromValues(...this.keyframeI.rotation);
      this.scale = vec3.fromValues(...this.keyframeI.scale);
    } else {
      this.translation = vec3.create();
      this.rotation = vec3.create();
      this.scale = vec3.create();
    }
    this.genMatrix();

    this.lastTime = Date.now() / 1000; // current time in seconds
    this.sumT = 0;
  }

  interpollateTgs(timePerc) {
    vec3.lerp(
      this.translation,
      this.keyframeI.translation,
      this.keyframeF.translation,
      timePerc
    );
    vec3.lerp(
      this.rotation,
      this.keyframeI.rotation,
      this.keyframeF.rotation,
      timePerc
    );
    vec3.lerp(this.scale, this.keyframeI.scale, this.keyframeF.scale, timePerc);
  }

  setFinalPos(finalKF) {
    this.isDone = true;
    // set final position (no more key frames)
    this.tgMatrix = mat4.create();
    mat4.translate(this.tgMatrix, this.tgMatrix, finalKF.translation);
    mat4.rotateX(this.tgMatrix, this.tgMatrix, finalKF.rotation[0]);
    mat4.rotateY(this.tgMatrix, this.tgMatrix, finalKF.rotation[1]);
    mat4.rotateZ(this.tgMatrix, this.tgMatrix, finalKF.rotation[2]);
    mat4.scale(this.tgMatrix, this.tgMatrix, finalKF.scale);
  }

  update(t) {
    // check if animation ended
    if (this.isDone) return;

    // update time values
    this.sumT += t - this.lastTime; // += deltaTime
    this.lastTime = t;
    // go away if animation hasn't started
    if (this.sumT < this.keyframeI.instant) return;
    if (this.keyframeF == null) {
      // reachable if there's only 1 keyframe
      this.setFinalPos(this.keyframeI);
      return;
    }

    // calculate segment
    if (this.sumT > this.keyframeF.instant) {
      // segment ended
      for (
        ;
        this.sumT > this.keyframeF.instant;
        this.keyframeF = this.keyframeF.nextKF
      ) {
        if (this.keyframeF.nextKF == null) {
          // animation ended
          this.setFinalPos(this.keyframeF);
          return;
        }
        this.keyframeI = this.keyframeF;
      }

      this.currKFDuration = this.keyframeF.instant - this.keyframeI.instant;
    }

    // time percentage
    let timePerc = (this.sumT - this.keyframeI.instant) / this.currKFDuration;
    // update transformation matrix
    this.interpollateTgs(timePerc);
    this.genMatrix();
  }

  apply() {
    this.scene.pushTransformation(this.tgMatrix);
  }
}

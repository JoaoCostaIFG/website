class Animation {
  /* abstract class */
  constructor(keyframeI, keyframeF) {
    if (this.constructor == Animation) {
      throw new Error("Can't instantiate abstract class!");
    }

    this.keyframeI = keyframeI == undefined ? null : keyframeI;
    this.keyframeF = keyframeF == undefined ? null : keyframeF;

    this.initKeyframeI = this.keyframeI;
    this.initKeyframeF = this.keyframeF;
  }

  reset() {
    this.keyframeI = this.initKeyframeI;
    this.keyframeF = this.initKeyframeF;
  }

  update(t) {
    throw new Error("Can't instantiate abstract class!");
  }

  apply() {
    throw new Error("Can't instantiate abstract class!");
  }
}

class MovePieceAnimation {
  static maxHeight = MyPiece.size * 2;

  constructor(scene, targetPos, isUp) {
    this.scene = scene;
    this.targetPos = targetPos;
    this.targetPos[0] *= MyPiece.size;
    this.targetPos[1] *= MyPiece.size;

    // the max height the pieces are elevated to
    this.maxHeight = MovePieceAnimation.maxHeight;
    if (isUp) this.maxHeight += MyPiece.size;

    this.sumT = 0;
    this.lastTime = Date.now() / 1000.0;
    this.stepTimes = [1, 1, 1];
    this.currStep = 0;

    this.isFinished = false;
    this.genMatrix([0, 0, 0]);
  }

  genMatrix(tgArray) {
    this.tgMatrix = mat4.create();
    mat4.translate(this.tgMatrix, this.tgMatrix, tgArray);
  }

  update(time) {
    if (this.isFinished) return;

    this.sumT += time - this.lastTime;
    this.lastTime = time;

    let totalTime = this.stepTimes[this.currStep];
    if (this.sumT >= totalTime) {
      this.sumT = 0;
      ++this.currStep;
    }

    let timePerc = this.sumT / totalTime;
    let tgArray = [0, 0, 0];
    switch (this.currStep) {
      case 0:
        tgArray = [
          0,
          (-(Math.cos(Math.PI * timePerc) - 1) / 2) * this.maxHeight,
          0,
        ];
        break;
      case 1:
        tgArray = [
          this.targetPos[0] * (1 - Math.pow(1 - timePerc, 5)),
          this.maxHeight,
          this.targetPos[1] * (1 - Math.pow(1 - timePerc, 5)),
        ];
        break;
      case 2:
        tgArray = [
          this.targetPos[0],
          (1 - Math.pow(timePerc, 5)) * this.maxHeight,
          this.targetPos[1],
        ];
        break;
      default:
        // finished last animation step
        // set final position
        tgArray = [this.targetPos[0], 0, this.targetPos[1]];
        this.isFinished = true;
        break;
    }

    this.genMatrix(tgArray);
  }

  display() {
    this.scene.pushTransformation(this.tgMatrix);
  }
}

class MySpriteAnimation {
  constructor(scene, spriteSheet, duration, startCell, endCell) {
    this.scene = scene;

    this.spriteSheet = spriteSheet;
    this.rect = new MyRectangle(this.scene, 0, 0, 1, 1);

    this.duration = duration;
    this.startCell = startCell;
    this.endCell = endCell;

    this.currCell = this.startCell;
    this.isForward = this.startCell <= this.endCell ? true : false;
    this.cellNum = Math.abs(this.endCell - this.startCell);
    this.stepDuration = this.duration / this.cellNum;
  }

  reset() {
    this.lastTime = Date.now() / 1000; // current time in seconds
    this.sumT = 0;

    this.currCell = this.startCell;
  }

  update(t) {
    // update time values
    let deltaT = t - this.lastTime;
    this.sumT += deltaT;
    this.lastTime = t;

    // check if it's time for a step
    if (this.sumT < this.stepDuration) return;

    // there can be more than 1 complete steps since the last update
    while (this.sumT > this.stepDuration) {
      // step in animation
      this.sumT -= this.stepDuration;
      if (this.isForward) ++this.currCell;
      else --this.currCell;
    }

    // reset animation
    // console.log(this.startCell - (this.currCell % this.cellNum));
    if (this.isForward) {
      this.currCell = this.startCell + (this.currCell % this.cellNum);
    } else {
      this.currCell = this.endCell + (this.currCell % this.cellNum);
      while (this.currCell < this.endCell)
        this.currCell = this.startCell + this.currCell;
    }
  }

  apply() {
    this.spriteSheet.activateCellP(this.currCell);
  }

  unapply() {
    this.spriteSheet.deactivate();
  }

  display() {
    this.apply();
    this.rect.display();
    this.unapply();
  }

  enableNormalViz() {
    this.rect.enableNormalViz();
  }

  disableNormalViz() {
    this.rect.disableNormalViz();
  }
}

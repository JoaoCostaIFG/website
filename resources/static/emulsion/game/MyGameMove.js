class MyGameMove {
  constructor(orch, pieceI, pieceF) {
    this.orch = orch;
    this.validMoves = this.orch.validMoves;

    this.pieceI = pieceI;
    this.tileI = pieceI.tile;
    this.pieceF = pieceF;
    this.tileF = pieceF.tile;

    this.isDone = false; // move finished animating or hasn't started
    this.isRunning = false; // move is not currently animation
  }

  isMoveDone() {
    /*
     * !isDone && !isRunning => not started
     * isDone && !isRunning => finished
     * !isDone && isRunning => currently animating
     */
    return this.isDone && !this.isRunning;
  }

  doMove() {
    // move needs to be "undone" before is "done" again
    if (this.isDone) return;

    let diffX = this.tileI.getCoords()[0] - this.tileF.getCoords()[0];
    let diffY = this.tileI.getCoords()[1] - this.tileF.getCoords()[1];

    // Create animations
    let animationI = new MovePieceAnimation(
      this.pieceI.scene,
      [-diffX, -diffY],
      true
    );
    this.pieceI.setAnimation(animationI);

    let animationF = new MovePieceAnimation(
      this.pieceI.scene,
      [diffX, diffY],
      false
    );
    this.pieceF.setAnimation(animationF);

    this.isRunning = true;
  }

  doMoveInstant() {
    this.pieceI.setAnimation(null);
    this.pieceF.setAnimation(null);
    this.tileI.setPiece(this.pieceF);
    this.tileF.setPiece(this.pieceI);
    this.isDone = true;
    this.isRunning = false;
  }

  forceFinish() {
    if (!this.isMoveDone()) {
      this.doMoveInstant();
      this.orch.onAnimationDone(false);
    }
  }

  undoMove() {
    this.tileI.setPiece(this.pieceI);
    this.tileF.setPiece(this.pieceF);

    this.pieceI.setAnimation(null);
    this.pieceF.setAnimation(null);

    this.isDone = false;
  }

  update(t, notifyOrchestrator = true) {
    if (this.isDone) return;

    this.pieceI.update(t);
    this.pieceF.update(t);

    // animations ended
    if (this.pieceI.animation == null && this.pieceF.animation == null) {
      // at the end, switch the initial tiles
      this.doMoveInstant(notifyOrchestrator);
      // notify orchestrator on finish
      if (notifyOrchestrator) this.orch.onAnimationDone();
    }
  }

  toString() {
    return "[" + this.tileI.toString() + "," + this.tileF.toString() + "]";
  }
}

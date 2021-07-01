class MyAnimator {
  constructor(gameOrchestrator, gameSequence) {
    this.gameOrchestrator = gameOrchestrator;
    this.gameSequence = gameSequence;

    // 0 => not running, 1 => running with game, 2 => replaying game (game movie)
    this.running = 0;
    this.reset();
  }

  reset(newGameSequence) {
    if (newGameSequence) this.gameSequence = newGameSequence;
    this.running = 0;
    this.sequenceIndex = 0;
  }

  startMovie() {
    this.reset();
    this.running = 2;
  }

  start() {
    this.running = 1;
  }

  pause() {
    this.running = 0;
  }

  update(t) {
    // check if running / there's anything to update
    if (!this.running || this.sequenceIndex >= this.gameSequence.length())
      return;

    if (this.running == 1) {
      // running with game
      let move = this.gameSequence.getLastMove();
      if (move) move.update(t);
    } else if (this.running == 2) {
      let move = this.gameSequence.getMoveByInd(this.sequenceIndex);
      // start move if not started yet
      if (!move.isDone && !move.isRunning) move.doMove();
      move.update(t, false); // don't notify orchestrator on finish
      // go to next move when the current one is over
      if (move.isDone && !move.isRunning) this.sequenceIndex++;
    }
  }
}

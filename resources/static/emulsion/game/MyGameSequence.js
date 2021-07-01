class MyGameSequence {
  constructor() {
    this.moves = [];
  }

  length() {
    return this.moves.length;
  }

  addMove(move) {
    this.moves.push(move);
  }

  canUndo() {
    return this.moves.length != 0;
  }

  getLastMove() {
    return this.moves[this.moves.length - 1];
  }

  undo() {
    // check if we can undo
    if (!this.canUndo()) return null;

    return this.moves.pop();
  }

  getMoveByInd(i) {
    return this.moves[i];
  }

  // || FOR REPLAY
  undoAll() {
    for (let i = this.moves.length - 1; i >= 0; --i) this.moves[i].undoMove();
  }

  doAll() {
    for (let i = 0; i < this.moves.length; ++i) this.moves[i].doMoveInstant();
  }
}

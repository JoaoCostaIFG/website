const GameState = {
  NOTSTARTED: 0,
  RUNNING: 1,
  PAUSED: 2,
  ENDED: 3,
};

class MyGameOrchestrator {
  static reservedUIPickIds = 100;

  /* || CONSTRUCTOR */
  constructor(scene) {
    this.scene = scene;
    scene.gameOrchestrator = this;
    this.state = GameState.NOTSTARTED;

    // debug option for showing game objects and scene objects normals
    this.showNormals = false;

    this.gameSequence = new MyGameSequence();
    this.animator = new MyAnimator(this, this.gameSequence);
    this.theme = scene.graphs[0];
    this.prolog = new MyPrologInterface("joaocosta.dev", 443);
    this.scoreBoard = new MyScoreBoard(this.scene, 0);
    this.genButtons();

    this.player = 0; // player 0 (Black) is always first
    this.selectedPieces = []; // list of picked pieces (max 2)
    this.validMoves = []; // the list of the game's valid moves

    // game options
    // turn time (in seconds)
    this.difficultyTimes = [30, 20, 10]; // easy, medium, hard
    this.selectedDifficulty = 0; // default difficulty: easy
    this.boardSize = 10; // default boardsize: 10
    // game mode options
    this.selectedPlayerOps = [0, 0];
    this.playerOps = [
      [0, 0], // PvP
      [0, 1], // PvAI
      [1, 0], // AIvP
      [1, 1], // AIvAI
    ];
    this.selectedPlayerOpsInd = 0; // used by the UI button
    // AI
    this.aiMoveReq = null; // current AI movement request (if any)
  }

  updateTheme(theme) {
    this.theme = theme;
    this.updateNormalViz();
  }

  /* || BUTTONS */
  genButtons() {
    this.scoreBoard.addButton(
      new MyButton(this.scene, "New Game", this.newGame.bind(this))
    );
    this.scoreBoard.addButton(
      new MyButton(this.scene, "Undo", this.undo.bind(this))
    );
    this.scoreBoard.addButton(
      new MyCheckboxButton(
        this.scene,
        "Start Replay",
        "Stop Replay",
        this.gameMovie.bind(this)
      )
    );
    this.scoreBoard.addButton(
      new MyComboButton(
        this.scene,
        ["PvP", "PvAI", "AIvP", "AIvAI"],
        0,
        this.onGameModeChange.bind(this)
      )
    );
    this.scoreBoard.addButton(
      new MyComboButton(
        this.scene,
        ["Easy", "Medium", "Hard"],
        0,
        this.onDifficultyChange.bind(this)
      )
    );
  }

  onGameModeChange(selectedGameMode) {
    this.selectedPlayerOpsInd = selectedGameMode;
  }

  onDifficultyChange(selectedDifficulty) {
    this.selectedDifficulty = selectedDifficulty;
  }

  /* || START */
  start() {
    // create or reset scoreBoard according to game options
    this.scoreBoard.reset(
      this.difficultyTimes[this.selectedDifficulty],
      this.boardSize
    );

    // create board according to game options
    this.gameboard = new MyGameBoard(this.scene, this.boardSize);
    this.updateNormalViz(); // for debugging purposes

    // initial valid moves
    this.prolog.requestValidMoves(
      this.gameboard,
      this.player,
      this.parseValidMoves.bind(this)
    );

    // start game
    this.state = GameState.RUNNING;

    this.selectedPlayerOps = this.playerOps[this.selectedPlayerOpsInd];
    // get first move (AI or player)
    this.getNextMove();
  }

  newGame() {
    if (this.state == GameState.NOTSTARTED) {
      this.start(); // start game
    } else {
      // restart
      this.cancelAIMove();

      this.gameSequence = new MyGameSequence();
      this.animator.reset(this.gameSequence);

      this.player = 0;
      this.selectedPieces = [];

      this.start();
    }
  }

  endGameMovie() {
    // restore state
    // stops replay
    this.scoreBoard.start();
    this.gameSequence.doAll();
    this.animator.reset();

    if (this.state != GameState.ENDED) {
      // we request the valid moves here because they might not
      // have been requested before the replay (replay started in middle of animation)
      this.prolog.requestValidMoves(
        this.gameboard,
        this.player,
        this.parseValidMoves.bind(this)
      );
    }

    // proceed with gameplay
    this.getNextMove();
  }

  gameMovie() {
    if (this.state == GameState.NOTSTARTED) return false;

    if (this.animator.running == 2) {
      console.log("Stop replay");
      this.endGameMovie();
    } else {
      // starts replay
      console.log("Start replay");

      // finish current move (if isn't finished it)
      let lastMove = this.gameSequence.getLastMove();
      if (lastMove) lastMove.forceFinish();

      // save state and cancel pending moves
      this.cancelAIMove();
      this.scoreBoard.pause();
      this.gameboard.togglePicking(false);
      this.togglePossibleMoveIndicators(false);

      this.gameSequence.undoAll();
      this.animator.startMovie();
    }

    return true;
  }

  /* || PICKING */
  handlePicking() {
    if (this.scene.pickMode == true) return;

    if (this.scene.pickResults != null && this.scene.pickResults.length > 0) {
      for (let i = 0; i < this.scene.pickResults.length; i++) {
        let obj = this.scene.pickResults[i][0];
        if (obj) {
          let id = this.scene.pickResults[i][1];
          this.onObjectSelected(obj, id);
        }
      }
      // clear results
      this.scene.pickResults.splice(0, this.scene.pickResults.length);
    }
  }

  onObjectSelected(obj, id) {
    console.log("Picked object: " + obj + ", with pick id " + id);

    if (obj instanceof MyTile) {
      // TODO togglePossibleMoveIndicators and check if is valid
      let p = obj.piece;
      if (this.selectedPieces.length > 0 && this.selectedPieces[0] == p) {
        // cleared all pieces
        this.selectedPieces = [];
        this.togglePossibleMoveIndForPiece(p, false); // clear possible moves on that piece
        this.togglePossibleMoveIndicators(true);
      } else {
        // add another selected piece
        this.selectedPieces.push(p);

        if (this.selectedPieces.length == 1) {
          // if first piece selected, we highlight possible move on that piece
          this.togglePossibleMoveIndicators(false);
          this.togglePossibleMoveIndForPiece(p, true); // show possible moves on that piece
        } else {
          // toggle possible moves on piece highlight (clearer animations)
          this.togglePossibleMoveIndForPiece(this.selectedPieces[0], false);
        }
      }
      obj.toggleHightlight();
    } else if (obj instanceof MyButton) {
      obj.onClick();
    } else {
      // error
    }
  }

  /* || INDICATORS */
  togglePossibleMoveIndForPiece(piece, isEnabled) {
    let moveFrom = piece.getTile().getCoords();

    for (let i = 0; i < this.validMoves.length; ++i) {
      let possibleMoveFrom = this.validMoves[i][0];
      if (
        moveFrom[1] == possibleMoveFrom[1] &&
        moveFrom[0] == possibleMoveFrom[0]
      ) {
        let possibleMoveTo = this.validMoves[i][1];
        this.gameboard
          .getTileByCoord(possibleMoveTo[0], possibleMoveTo[1])
          .toggleIsPossible(isEnabled);
      }
    }
  }

  togglePossibleMoveIndicators(isEnabled) {
    let previousFrom = [-1, -1]; // impossible coors
    for (let i = 0; i < this.validMoves.length; ++i) {
      let possibleMoveFrom = this.validMoves[i][0];
      if (
        previousFrom[1] != possibleMoveFrom[1] ||
        previousFrom[0] != possibleMoveFrom[0]
      ) {
        this.gameboard
          .getTileByCoord(possibleMoveFrom[0], possibleMoveFrom[1])
          .toggleIsPossible(isEnabled);
        previousFrom = possibleMoveFrom;
      }
    }
  }

  /* || MOVE */
  nextPlayer() {
    this.player = (this.player + 1) % 2;
  }

  undo() {
    if (this.state == GameState.ENDED) {
      console.log("Game ended. Can't undo.");
      return;
    }

    // finish current move (if isn't finished it)
    let lastMove = this.gameSequence.getLastMove();
    if (lastMove) lastMove.forceFinish();

    let move = this.gameSequence.undo();
    if (move == null) {
      console.log("No move to undo.");
    } else {
      console.log("Undo last move.");
      this.cancelAIMove();

      // clear current highlights
      this.togglePossibleMoveIndicators(false);
      if (this.selectedPieces.length > 0)
        this.selectedPieces[0].tile.toggleHightlight();
      this.selectedPieces.splice(0, this.selectedPieces.length);

      // change board and orchestrator to previous state
      move.undoMove();
      this.nextPlayer();

      // update score
      this.updateScoreboardInfo();

      // get previous valid moves and toggle indicators
      this.validMoves = move.validMoves;
      this.togglePossibleMoveIndicators(true);

      this.getNextMove();
    }
  }

  getNextMove() {
    if (this.state != GameState.RUNNING) return;

    if (this.selectedPlayerOps[this.player]) {
      // starts an AI move if it's the AI's turn
      this.aiMoveReq = this.prolog.requestAIMove(
        this.gameboard,
        this.player,
        1,
        this.onAIMove.bind(this)
      );
      this.gameboard.togglePicking(false);
    } else {
      // otherwise, wait for player input (toggle picking on)
      this.gameboard.togglePicking(true);
    }
  }

  cancelAIMove() {
    // cancel AI move request (if any)
    if (this.aiMoveReq) this.aiMoveReq.abort();
    this.aiMoveReq = null;
  }

  startMove(move) {
    this.togglePossibleMoveIndicators(false); // clear valid moves

    move.doMove();
    this.gameSequence.addMove(move);
    this.animator.start();

    // pause timer until animation is done
    this.scoreBoard.pause();
    this.gameboard.togglePicking(false);

    this.state = GameState.PAUSED; // pause until animation is done
  }

  /* || PROLOG REQUEST HANDLERS */
  parseValidMoves(data) {
    if (data.target.response == "Bad Request") {
      console.log("No more valid moves.");
      this.validMoves = [];
      this.gameEnded();
      return;
    }

    console.log("here:");
    console.log(data.target.response);
    this.validMoves = JSON.parse(data.target.response);
    if (this.validMoves.length == 0) this.gameEnded();
    else this.togglePossibleMoveIndicators(true); // active
  }

  /* called when we get an AI move */
  onAIMove(data) {
    // reset the state
    // TODO WAITINGFORAI game state?
    this.aiMoveReq = null;

    if (data.target.response == "Bad Request") {
      console.log("Couldn't get AI move");
      return;
    }

    let moveCoords = JSON.parse(data.target.response);
    if (moveCoords.length == 0) {
      console.log("AI: No more moves (waiting for game end)");
      return;
    }

    let pieceI = this.gameboard.getPieceByCoord(
      moveCoords[0][0],
      moveCoords[0][1]
    );
    let pieceF = this.gameboard.getPieceByCoord(
      moveCoords[1][0],
      moveCoords[1][1]
    );

    let move = this.gameboard.move(pieceI, pieceF);
    this.startMove(move);
  }

  /* called when we get a PLAYER move */
  onValidMove(move, data) {
    console.warn(data.target.response);
    if (
      data.target.response == "Bad Request" ||
      data.target.response == "Invalid Move"
    ) {
      console.log("Invalid move");
      this.togglePossibleMoveIndicators(true);
      return;
    }

    this.startMove(move);
  }

  /* called after every move */
  onAnimationDone(highlightMoves = true) {
    // next player
    this.nextPlayer();

    // new valid moves
    if (highlightMoves) {
      this.prolog.requestValidMoves(
        this.gameboard,
        this.player,
        this.parseValidMoves.bind(this)
      );
    }

    // update score
    this.updateScoreboardInfo();

    this.state = GameState.RUNNING;

    this.getNextMove();
  }

  /* || OTHER */
  updateNormalViz() {
    this.theme.toggleObjectNormals(this.showNormals);

    // gameboard
    if (this.gameboard) {
      if (this.showNormals) this.gameboard.enableNormalViz();
      else this.gameboard.disableNormalViz();
    }

    // scoreboard
    if (this.showNormals) this.scoreBoard.enableNormalViz();
    else this.scoreBoard.disableNormalViz();
  }

  updateScoreboardInfo() {
    // update score
    this.prolog.requestScore(
      this.gameboard,
      this.scoreBoard.parseScore.bind(this.scoreBoard)
    );
    this.scoreBoard.resetTimer(); // reset timer
  }

  gameEnded(isTimeout = false) {
    // only end once
    if (this.state == GameState.ENDED) return;

    this.cancelAIMove(); // for safety
    this.scoreBoard.end(this.player, isTimeout);
    this.gameboard.togglePicking(false);
    this.togglePossibleMoveIndicators(false);
    this.state = GameState.ENDED;
  }

  update(t) {
    this.theme.update(t);
    this.scoreBoard.update(t);

    if (this.state == GameState.PRESTART || this.state == GameState.NOTSTARTED)
      return;

    this.animator.update(t);

    if (this.selectedPieces.length == 2) {
      // 2 pieces selected
      let move = this.gameboard.move(...this.selectedPieces);
      this.prolog.requestValidMove(
        this.gameboard,
        this.player,
        move,
        this.onValidMove.bind(this, move)
      );

      // clear piece selection
      move.tileI.toggleHightlight();
      move.tileF.toggleHightlight();
      this.selectedPieces.splice(0, this.selectedPieces.length);
    } else if (this.scoreBoard.time <= 0) {
      // current player timed out
      this.gameEnded(true);
    }
  }

  display() {
    // scene graph is always drawn
    this.theme.display();

    // scoreboard is always drawn
    this.scene.pushMatrix();
    this.scene.translate(...this.theme.scorePos);
    this.scoreBoard.display();
    this.scene.popMatrix();

    if (this.state == GameState.PRESTART || this.state == GameState.NOTSTARTED)
      return;

    this.scene.pushMatrix();
    this.scene.translate(...this.theme.boardPos);
    this.gameboard.display();
    this.scene.popMatrix();
  }
}

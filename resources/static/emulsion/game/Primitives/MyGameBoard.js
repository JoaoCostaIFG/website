class MyGameBoard {
  static tex = "./scenes/images/wood.jpeg";

  constructor(scene, size) {
    this.scene = scene;
    this.size = size;

    this.primitive = new MyCube(scene, 0.5);
    this.border = new MyBorder(scene, size);
    this.tex = new CGFtexture(scene, MyGameBoard.tex);
    // this.genLinesIndexes();
    this.pickingEnabled = true;
    this.genTiles();
  }

  genLinesIndexes() {
    let indexes_string = Array(this.size)
      .fill()
      .map((v, i) => i.toString());
    this.indexes = new MySpriteText(this.scene, indexes_string);
  }

  togglePicking(isEnabled) {
    this.pickingEnabled = isEnabled;
  }

  genTiles() {
    this.tiles = [];

    for (let i = 0; i < this.size; ++i) {
      // even => white, odd => black
      let c = i % 2 == 0 ? Color.WHITE : Color.BLACK;
      for (let j = 0; j < this.size; ++j) {
        let currTile = new MyTile(this.scene, this, null);
        currTile.setPiece(new MyPiece(this.scene, c, currTile));
        currTile.setCoords(j, i);
        this.tiles.push(currTile);
        c = c == Color.WHITE ? Color.BLACK : Color.WHITE;
      }
    }
  }

  getTileByCoord(x, y) {
    return this.tiles[this.size * y + x]; // this is not flipped
  }

  getPieceByCoord(x, y) {
    return this.getTileByCoord(x, y).getPiece();
  }

  addPieceToTile(x, y, piece) {
    this.getTileByCoord(x, y).setPiece(piece);
  }

  removePieceFromTile(x, y) {
    this.getTileByCoord(x, y).unsetPiece();
  }

  getTileByPiece(piece) {
    return piece.tile;
  }

  move(pieceI, pieceF) {
    return new MyGameMove(this.scene.gameOrchestrator, pieceI, pieceF);
  }

  display() {
    this.scene.pushTexture(this.tex);
    this.displayBorder();
    this.displayBoardBottom();
    this.scene.popTexture();
    // this.displayIndexes();
    this.displayTiles();
  }

  displayBorder() {
    let halfPiece = MyPiece.size / 2.0;
    let aux = this.size * halfPiece;

    // Left
    this.scene.pushMatrix();
    this.scene.translate(
      -aux - MyPiece.size / 4.0,
      halfPiece,
      -aux - MyPiece.size / 4.0
    );
    this.border.display();
    this.scene.popMatrix();

    // Up
    this.scene.pushMatrix();
    this.scene.translate(-aux, halfPiece, -aux);
    this.scene.rotate(Math.PI / 2.0, 0, 1, 0);
    this.border.display();
    this.scene.popMatrix();

    // Right
    this.scene.pushMatrix();
    this.scene.translate(aux, halfPiece, -aux);
    this.border.display();
    this.scene.popMatrix();

    // Down
    this.scene.pushMatrix();
    this.scene.translate(
      -aux - MyPiece.size / 4.0,
      halfPiece,
      aux + MyPiece.size / 4.0
    );
    this.scene.rotate(Math.PI / 2.0, 0, 1, 0);
    this.border.display();
    this.scene.popMatrix();
  }

  displayBoardBottom() {
    this.scene.pushMatrix();

    let sideLen = MyPiece.size * this.size + MyPiece.size / 2.0;
    this.scene.translate(-sideLen / 2.0, -MyPiece.size / 8.0, -sideLen / 2.0);
    this.scene.scale(sideLen, MyPiece.size / 4.0, sideLen);
    this.primitive.display();

    this.scene.popMatrix();
  }

  displayTiles() {
    /* draw tiles (+ pieces) */
    this.scene.pushMatrix();

    // go to first column
    this.scene.translate(
      (-MyPiece.size * this.size) / 2,
      0.0,
      (-MyPiece.size * this.size) / 2
    );

    // displays all tile (they display all pieces)
    for (let i = 0; i < this.size; ++i) {
      for (let j = 0; j < this.size; ++j) {
        let tileIndex = i * this.size + j;
        // leave some ids reserved for UI objs
        if (this.pickingEnabled) {
          this.scene.registerForPick(
            MyGameOrchestrator.reservedUIPickIds + tileIndex + 1,
            this.tiles[tileIndex]
          );
        }

        this.tiles[tileIndex].display();
        this.scene.translate(MyPiece.size, 0.0, 0.0);
      }
      // go to next line start
      this.scene.translate(-MyPiece.size * this.size, 0.0, MyPiece.size);
    }

    if (this.pickingEnabled) this.scene.clearPickRegistration(); // stop picking
    this.scene.popMatrix();
  }

  displayIndexes() {
    this.scene.pushMatrix();
    this.scene.translate(0, 5, this.size * 2.2);
    this.scene.rotate(-Math.PI / 2, 1, 0, 0);
    this.scene.scale(this.size / 2.5, this.size / 2.5, this.size / 2.5);
    this.indexes.display();
    this.scene.popMatrix();

    this.scene.pushMatrix();
    this.scene.translate(0, 5, -this.size * 2.2);
    this.scene.rotate(Math.PI, 0, 1, 0);
    this.scene.rotate(-Math.PI / 2, 1, 0, 0);
    this.scene.scale(this.size / 2.5, this.size / 2.5, this.size / 2.5);
    this.indexes.display();
    this.scene.popMatrix();

    this.scene.pushMatrix();
    this.scene.translate(this.size / 2.0, 5, this.size * 1.8);
    this.scene.rotate(Math.PI, 0, 1, 0);
    this.scene.rotate(-Math.PI / 2, 1, 0, 0);
    this.scene.scale(this.size / 2.5, this.size / 2.5, this.size / 2.5);
    this.indexes.display(true);
    this.scene.popMatrix();

    this.scene.pushMatrix();
    this.scene.translate(-this.size / 2.0, 5, -this.size * 1.8);
    this.scene.rotate(-Math.PI / 2, 1, 0, 0);
    this.scene.scale(this.size / 2.5, this.size / 2.5, this.size / 2.5);
    this.indexes.display(true);
    this.scene.popMatrix();
  }

  toString() {
    let ret = "[";

    for (let i = 0; i < this.size; ++i) {
      ret += "[";
      let color = this.tiles[i * this.size].getPieceColor();
      if (color == Color.WHITE) ret += "1";
      else ret += "0";
      for (let j = 1; j < this.size; ++j) {
        let color = this.tiles[i * this.size + j].getPieceColor();
        if (color == Color.WHITE) ret += ",1";
        else ret += ",0";
      }
      ret += "],";
    }

    ret = ret.slice(0, -1);
    ret += "]";
    return ret;
  }

  enableNormalViz() {
    for (let i = 0; i < this.tiles.length; ++i) this.tiles[i].enableNormalViz();
  }

  disableNormalViz() {
    for (let i = 0; i < this.tiles.length; ++i)
      this.tiles[i].disableNormalViz();
  }
}

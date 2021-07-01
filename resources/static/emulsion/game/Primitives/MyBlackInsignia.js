class MyBlackInsignia extends MyInsignia {
  constructor(scene) {
    super(scene);
  }

  display() {
    super.display();

    // Cube
    this.scene.pushMatrix();

    this.scene.translate(MyPiece.size/2.50, MyPiece.size/1.65, MyPiece.size/3.3);
    this.scene.scale(MyPiece.size/11.0, MyPiece.size / 50.0, MyPiece.size/2.5);
    this.cube.display();
    
    this.scene.popMatrix();

    this.scene.pushMatrix();

    this.scene.translate(MyPiece.size/2.0, MyPiece.size/1.65, MyPiece.size/3.3);
    this.scene.scale(MyPiece.size/11.0, MyPiece.size / 50.0, MyPiece.size/2.5);
    this.cube.display();
    
    this.scene.popMatrix();

    // Circle
    this.scene.pushMatrix();

    this.scene.translate(MyPiece.size/3.25, MyPiece.size/1.60, MyPiece.size/2.0);
    this.scene.rotate(Math.PI / 2.0, 1, 0, 0);
    this.scene.scale(MyPiece.size/20.0, MyPiece.size /20.0, MyPiece.size/20.0);
    this.cylinder.display();

    this.scene.popMatrix();

    this.scene.pushMatrix();

    this.scene.translate(MyPiece.size/1.47, MyPiece.size/1.60, MyPiece.size/2.0);
    this.scene.rotate(Math.PI / 2.0, 1, 0, 0);
    this.scene.scale(MyPiece.size/20.0, MyPiece.size /20.0, MyPiece.size/20.0);
    this.cylinder.display();

    this.scene.popMatrix();
  }
}

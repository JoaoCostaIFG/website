class MyWhiteInsignia extends MyInsignia {
  constructor(scene) {
    super(scene);

    this.triangle = new MyCylinder(scene, 0.5, 0.5, 0.1, 3, 1);
  }

  display() {
    super.display();

    // Right
    this.scene.pushMatrix();

    this.scene.translate(
      MyPiece.size / 1.5,
      MyPiece.size / 1.6,
      MyPiece.size / 2.0
    );
    this.scene.rotate(Math.PI / 2.0, 1, 0, 0);
    this.triangle.display();

    this.scene.popMatrix();

    // Down
    this.scene.pushMatrix();

    this.scene.translate(
      MyPiece.size / 2.0,
      MyPiece.size / 1.6,
      MyPiece.size / 1.5
    );
    this.scene.rotate(Math.PI / 2.0, 1, 0, 0);
    this.scene.rotate(Math.PI / 2.0, 0, 0, 1);
    this.triangle.display();

    this.scene.popMatrix();

    // Left
    this.scene.pushMatrix();

    this.scene.translate(
      MyPiece.size / 3.0,
      MyPiece.size / 1.6,
      MyPiece.size / 2.0
    );
    this.scene.rotate(Math.PI / 2.0, 1, 0, 0);
    this.scene.rotate(Math.PI, 0, 0, 1);
    this.triangle.display();

    this.scene.popMatrix();

    // Up
    this.scene.pushMatrix();

    this.scene.translate(
      MyPiece.size / 2.0,
      MyPiece.size / 1.6,
      MyPiece.size / 3.0
    );
    this.scene.rotate(Math.PI / 2.0, 1, 0, 0);
    this.scene.rotate(-Math.PI / 2.0, 0, 0, 1);
    this.triangle.display();

    this.scene.popMatrix();
  }

  enableNormalViz() {
    super.enableNormalViz();
    this.triangle.enableNormalViz();
  }

  disableNormalViz() {
    super.disableNormalViz();
    this.triangle.disableNormalViz();
  }
}

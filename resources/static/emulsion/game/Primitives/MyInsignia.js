class MyInsignia extends CGFobject {
  constructor(scene) {
    super(scene);
    this.scene = scene;

    this.cube = new MyCube(scene, 0.5);
    this.cylinder = new MyCylinder(scene, 1.2, 1.2, 0.2, 20, 2);
    this.torus = new MyTorus(scene, 5, 20, 0.1, 1.3);
  }

  display() {
    // Top
    this.scene.pushMatrix();

    this.scene.translate(
      MyPiece.size / 10.0,
      MyPiece.size / 2.0,
      MyPiece.size / 10.0
    );
    this.scene.scale(
      MyPiece.size / 1.25,
      MyPiece.size / 6.0,
      MyPiece.size / 1.25
    );
    this.cube.display();

    this.scene.popMatrix();

    // Circle
    this.scene.pushMatrix();

    this.scene.translate(
      MyPiece.size / 2.0,
      MyPiece.size / 1.65,
      MyPiece.size / 2.0
    );
    this.scene.rotate(Math.PI / 2.0, 1, 0, 0);
    this.cylinder.display();

    this.scene.popMatrix();

    // Torus
    this.scene.pushMatrix();

    this.scene.translate(
      MyPiece.size / 2.0,
      MyPiece.size / 1.75,
      MyPiece.size / 2.0
    );
    this.scene.rotate(Math.PI / 2.0, 1, 0, 0);
    this.torus.display();

    this.scene.popMatrix();
  }

  enableNormalViz() {
    this.cube.enableNormalViz();
    this.cylinder.enableNormalViz();
    this.torus.enableNormalViz();
  }

  disableNormalViz() {
    this.cube.disableNormalViz();
    this.cylinder.disableNormalViz();
    this.torus.disableNormalViz();
  }
}

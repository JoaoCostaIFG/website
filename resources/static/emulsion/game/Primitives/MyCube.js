/**
 * MyCube
 * @constructor
 * @param scene - Reference to MyScene object
 */
class MyCube extends CGFobject {
  constructor(scene, side, afs=1.0, aft=1.0) {
    super(scene);
    this.scene = scene;
    this.side = side;
    this.rect = new MyRectangle(this.scene, this.side, -this.side, -this.side, this.side, afs, aft);
  }

  display() {
    this.scene.pushMatrix();
    this.scene.translate(this.side, 0, 0);

    // Back
    this.rect.display();

    // Front
    this.scene.pushMatrix();
    this.scene.translate(0, 0, this.side * 2);
    this.scene.rotate(Math.PI, 1, 0, 0);
    this.rect.display();
    this.scene.popMatrix();

    // Top
    this.scene.pushMatrix();
    this.scene.translate(0, this.side, this.side);
    this.scene.rotate(Math.PI / 2, 1, 0, 0);
    this.rect.display();
    this.scene.popMatrix();

    // Base
    this.scene.pushMatrix();
    this.scene.translate(0, -this.side, this.side);
    this.scene.rotate(-Math.PI / 2, 1, 0, 0);
    this.rect.display();
    this.scene.popMatrix();

    // Left
    this.scene.pushMatrix();
    this.scene.translate(this.side, 0, this.side);
    this.scene.rotate(-Math.PI / 2, 0, 1, 0);
    this.rect.display();
    this.scene.popMatrix();

    // Right
    this.scene.pushMatrix();
    this.scene.translate(-this.side, 0, this.side);
    this.scene.rotate(Math.PI / 2, 0, 1, 0);
    this.rect.display();
    this.scene.popMatrix();

    this.scene.popMatrix();
  }

  enableNormalViz() {
    this.rect.enableNormalViz();
  }

  disableNormalViz() {
    this.rect.disableNormalViz();
  }
}

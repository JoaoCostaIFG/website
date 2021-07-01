const Color = {
  BLACK: 0,
  WHITE: 1,
};

/**
 * MyPiece
 * @constructor
 * @param scene - Reference to MyScene object
 */
class MyPiece extends CGFobject {
  static size = 4.0;
  static white = "./scenes/images/whiteMarble.jpeg";
  static black = "./scenes/images/blackMarble.jpeg";

  constructor(scene, color, tile) {
    super(scene);
    this.scene = scene;
    this.color = color;
    this.tile = tile ? tile : null;
    this.animation = null;

    if (this.color == Color.BLACK) this.insignia = new MyBlackInsignia(scene);
    else this.insignia = new MyWhiteInsignia(scene);
  }

  setAnimation(animation) {
    this.animation = animation;
  }

  getTile() {
    return this.tile;
  }

  getColor() {
    return this.color;
  }

  applyColor() {
    this.scene.pushMaterial(this.scene.whiteMaterial);
    if (this.color == Color.BLACK) {
      this.scene.pushTexture(this.scene.blackTex);
    } else {
      this.scene.pushTexture(this.scene.whiteTex);
    }
  }

  update(t) {
    if (this.animation) {
      this.animation.update(t);
      if (this.animation.isFinished) this.animation = null;
    }
  }

  display() {
    if (this.animation) this.animation.display();
    this.applyColor();

    // Base
    this.scene.pushMatrix();
    this.scene.translate(0.0, MyPiece.size / 4.0, 0.0);
    this.scene.scale(MyPiece.size, MyPiece.size / 2.0, MyPiece.size);
    this.insignia.cube.display();
    this.scene.popMatrix();

    this.insignia.display();

    this.scene.popTexture();
    this.scene.popMaterial();
    if (this.animation) this.scene.popTransformation();
  }
  enableNormalViz() {
    this.insignia.enableNormalViz();
  }

  disableNormalViz() {
    this.insignia.disableNormalViz();
  }
}

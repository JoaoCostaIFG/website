class MyButton extends CGFobject {
  constructor(scene, text, onClickFunc) {
    super(scene);
    this.scene = scene;
    this.onClickFunc = onClickFunc;

    this.setButtonLenFromText(text);
    this.txt = new MySpriteText(this.scene, text, 0.5);
    this.body = new MyCube(this.scene, 1.0);
  }

  setButtonLen(len) {
    // text has half width (0.5 Hpadding)
    // and we start with a cube of side 1.0 (can have 2 chars)
    this.buttonSize = len / 4.0 + 1.0; // 1.0 is the padding
  }

  setButtonLenFromText(text) {
    this.setButtonLen(text.length);
  }

  startAnim() {
    if (!this.clickAnimation) {
      let kfs = [
        new Keyframe(0, 0, 0, 0, 0, 0, 0, 1, 1, 1),
        new Keyframe(0.2, 0, 0, 0, 0, 0, 0, 1, 1, 0.5),
        new Keyframe(0.4, 0, 0, 0, 0, 0, 0, 1, 1, 1),
      ];
      for (let i = 0; i < kfs.length - 1; ++i) kfs[i].nextKF = kfs[i + 1];
      this.clickAnimation = new KeyframeAnimation(
        this.scene,
        this.txt.text + "UIButton",
        kfs
      );
    } else {
      this.clickAnimation.reset();
    }
  }

  onClick(args = []) {
    // the ags argument is optional
    // it should contain arguments to be passed to the on click functions
    this.startAnim();
    return this.onClickFunc(...args);
  }

  update(t) {
    if (this.clickAnimation) this.clickAnimation.update(t);
  }

  display() {
    if (this.clickAnimation) this.clickAnimation.apply();

    this.scene.pushMatrix();
    this.scene.scale(this.buttonSize, 1, 0.5);
    this.body.display();
    this.scene.popMatrix();

    this.scene.pushMatrix();
    this.scene.translate(this.buttonSize - 0.25, 0, 1.01);
    this.txt.display();
    this.scene.popMatrix();

    if (this.clickAnimation) this.scene.popTransformation();
  }

  enableNormalViz() {
    this.txt.enableNormalViz();
    this.body.enableNormalViz();
  }

  disableNormalViz() {
    this.txt.disableNormalViz();
    this.body.disableNormalViz();
  }
}

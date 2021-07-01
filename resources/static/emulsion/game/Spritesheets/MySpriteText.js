class MySpriteText {
  constructor(scene, text, spacingH = 1.0, spacingV = 1.0) {
    this.scene = scene;
    this.spacing = [spacingH, spacingV];
    this.parseText(text);
    this.rect = new MyRectangle(this.scene, 0, 0, 1, 1);

    this.spriteSheet = new MySpritesheet(
      this.scene,
      this.scene.textSheet,
      ...this.scene.textSheetSize
    );
  }

  getCharacterPosition(character) {
    let asciiCode = character.charCodeAt(0);
    // in case of error, use space char index
    if (isNaN(asciiCode) || asciiCode > 255 || asciiCode < 0) return 32;
    else return asciiCode;
  }

  setText(text) {
    this.parseText(text);
  }

  parseText(text) {
    this.text = [];
    let line = [];
    for (let i = 0; i < text.length; ++i) {
      let newChar = this.getCharacterPosition(text[i]);
      if (newChar == 10) {
        this.text.push(line);
        line = [];
      } else {
        line.push(newChar);
      }
    }
    this.text.push(line);
  }

  displayLine(line, isVertical) {
    this.scene.pushMatrix();
    // center text
    this.scene.translate((-line.length * this.spacing[0]) / 2.0, -0.5, 0.0);

    // render text
    for (let i = 0; i < line.length; ++i) {
      this.spriteSheet.activateCellP(line[i]);
      this.rect.display();
      if (isVertical) this.scene.translate(0.0, -this.spacing[1], 0.0);
      else this.scene.translate(this.spacing[0], 0.0, 0.0);
    }
    this.spriteSheet.deactivate();

    this.scene.popMatrix();
  }

  display(isVertical = false) {
    this.scene.pushMatrix();
    for (let i = 0; i < this.text.length; ++i) {
      this.displayLine(this.text[i], isVertical);
      this.scene.translate(0.0, -this.spacing[1], 0.0);
    }
    this.scene.popMatrix();
  }

  enableNormalViz() {
    this.rect.enableNormalViz();
  }

  disableNormalViz() {
    this.rect.disableNormalViz();
  }
}

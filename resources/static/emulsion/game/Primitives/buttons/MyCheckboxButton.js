class MyCheckboxButton extends MyButton {
  constructor(scene, text, altText, onClickFunc) {
    super(scene, text, onClickFunc);

    this.text = text;
    this.altText = altText;
    this.clicked = false;

    // buttons should be sized around the largest element
    if (this.altText.length > this.text.length)
      this.setButtonLenFromText(altText);

    this.shader = new CGFshader(
      this.scene.gl,
      "./Shaders/GradientShader.vert",
      "./Shaders/GradientShader.frag"
    );
    this.updateColor();
  }

  updateColor() {
    this.scene.setActiveShaderSimple(this.shader);
    this.shader.setUniformsValues({
      perc: this.clicked ? 1.0 : 0.0,
    });
    this.scene.setActiveShader(this.scene.defaultShader);
  }

  onClick() {
    let ret = super.onClick();

    // only change state if call was successful
    if (ret) {
      this.clicked = !this.clicked;
      if (this.clicked) this.txt.setText(this.altText);
      else this.txt.setText(this.text);
    }
    this.updateColor();

    return ret;
  }

  isClicked() {
    return this.clicked;
  }

  display() {
    this.scene.setActiveShaderSimple(this.shader);
    super.display();
    this.scene.setActiveShader(this.scene.defaultShader);
  }
}

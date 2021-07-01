class MyComboButton extends MyButton {
  constructor(scene, items, selected, onClickFunc) {
    super(scene, items[0], onClickFunc);

    this.items = items;
    this.selected = selected; // TODO if out of range => exception
    this.txt.setText(this.items[this.selected]);

    // buttons should be sized around the largest element
    let max = 0;
    for (let i = 0; i < this.items.length; ++i) {
      if (max < this.items[i].length) max = this.items[i].length;
    }
    this.setButtonLen(max);

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
      perc: this.selected / (this.items.length - 1),
    });
    this.scene.setActiveShader(this.scene.defaultShader);
  }

  onClick() {
    ++this.selected;
    if (this.selected >= this.items.length) this.selected = 0;
    this.txt.setText(this.items[this.selected]);

    this.updateColor();
    return super.onClick([this.selected]);
  }

  getSelection() {
    return this.selected;
  }

  display() {
    this.scene.setActiveShaderSimple(this.shader);
    super.display();
    this.scene.setActiveShader(this.scene.defaultShader);
  }
}

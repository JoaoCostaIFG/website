class MySpritesheet {
  constructor(scene, texture, sizeM, sizeN) {
    this.scene = scene;
    this.tex = texture;
    this.texSize = [sizeM, sizeN];

    this.shader = new CGFshader(
      this.scene.gl,
      "./Shaders/MySpriteShader.vert",
      "./Shaders/MySpriteShader.frag"
    );

    // this.mat = new CGFappearance(this.scene);
    // this.mat.setTexture(texture); // default material with spritesheet as texture

    this.scene.setActiveShaderSimple(this.shader);
    this.shader.setUniformsValues({
      sheetSize: [sizeM, sizeN],
      charCoords: [0, 0],
    });
    this.scene.setActiveShader(this.scene.defaultShader);
  }

  activateCellMN(m, n) {
    this.scene.setActiveShaderSimple(this.shader);
    this.shader.setUniformsValues({ charCoords: [m, n] });

    // this.mat.apply();
    this.tex.bind();
  }

  activateCellP(p) {
    this.activateCellMN(p % this.texSize[0], Math.floor(p / this.texSize[0]));
  }

  deactivate() {
    // this.tex.unbind();
    // this.scene.applyLastMat();
    this.scene.applyLastTex();
    this.scene.setActiveShader(this.scene.defaultShader);
  }
}

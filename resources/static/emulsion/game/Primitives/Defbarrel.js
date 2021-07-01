class Defbarrel extends CGFobject {
  static weight = 1.0;

  constructor(scene, base, middle, height, slices, stacks) {
    super(scene);

    let nurbsSurf = new CGFnurbsSurface(
      3.0, // order
      3.0, // order
      this.genControlPoints(base, middle, height)
    );

    this.nurbsObj = new CGFnurbsObject(scene, slices, stacks, nurbsSurf);
  }

  genControlPoints(base, middle, height) {
    let h = (4.0 / 3) * base;
    let hMiddle = (4.0 / 3) * middle;
    let H = (4.0 / 3) * (middle - base);
    let tg30 = (1.0 / Math.sqrt(3));

    return [
      [
        [base,        0,        0,                  1],
        [base + H,    0,        H / tg30,           1],
        [base + H,    0,        height - H / tg30,  1],
        [base,        0,        height,             1],
      ],
      [
        [base,        h,        0,                  1],
        [base + H,    hMiddle,  H / tg30,           1],
        [base + H,    hMiddle,  height - H / tg30,  1],
        [base,        h,        height,             1],
      ],
      [
        [-base,       h,        0,                  1],
        [-base - H,   hMiddle,  H / tg30,           1],
        [-base - H,   hMiddle,  height - H / tg30,  1],
        [-base,       h,        height,             1],
      ],
      [
        [-base,       0,        0,                  1],
        [-base - H,   0,        H / tg30,           1],
        [-base - H,   0,        height - H / tg30,  1],
        [-base,       0,        height,             1],
      ],
    ];
  }

  display() {
    this.scene.pushMatrix();
    this.scene.rotate(Math.PI, 0, 0, 1);
    this.nurbsObj.display();
    this.scene.popMatrix();

    this.nurbsObj.display();
  }

  enableNormalViz() {
    this.nurbsObj.enableNormalViz();
  }

  disableNormalViz() {
    this.nurbsObj.disableNormalViz();
  }
}

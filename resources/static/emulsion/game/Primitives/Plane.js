class Plane extends CGFobject {
  static orderU = 1.0;
  static orderV = 1.0;
  static weight = 1.0;

  constructor(scene, npartsU = 1.0, npartsV = 1.0) {
    super(scene);

    let nurbsSurf = new CGFnurbsSurface(
      Plane.orderU,
      Plane.orderV,
      this.genControlPoints()
    );

    this.nurbsObj = new CGFnurbsObject(scene, npartsU, npartsV, nurbsSurf);
  }

  genControlPoints() {
    return [
      [
        [0.5, 0.0, -0.5, Plane.weight],
        [0.5, 0.0, 0.5, Plane.weight],
      ],
      [
        [-0.5, 0.0, -0.5, Plane.weight],
        [-0.5, 0.0, 0.5, Plane.weight],
      ],
    ];
  }

  display() {
    this.nurbsObj.display();
  }

  enableNormalViz() {
    this.nurbsObj.enableNormalViz();
  }

  disableNormalViz() {
    this.nurbsObj.disableNormalViz();
  }
}

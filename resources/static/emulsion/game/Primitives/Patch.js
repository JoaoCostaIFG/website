class Patch extends CGFobject {
  static weight = 1.0;

  constructor(scene, npointsU, npointsV, npartsU, npartsV, controlPoints) {
    super(scene);

    let nurbsSurf = new CGFnurbsSurface(
      npointsU - 1, // order
      npointsV - 1, // order
      this.genControlPoints(npointsU, npointsV, controlPoints)
    );

    this.nurbsObj = new CGFnurbsObject(scene, npartsU, npartsV, nurbsSurf);
  }

  genControlPoints(npointsU, npointsV, controlPoints) {
    var parsedPoints = [];

    for (let u = 0; u < npointsU; ++u) {
      parsedPoints[u] = [];
      for (let v = 0; v < npointsV; ++v) {
        parsedPoints[u][v] = [...controlPoints[u * npointsV + v], Patch.weight];
      }
    }

    return parsedPoints;
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

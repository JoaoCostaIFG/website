/**
 * MyCylinder
 * @constructor
 * @param scene - Reference to MyScene object
 * @param bottomRadius - radius of bottom base 
 * @param topRadius - radius of top base 
 * @param height - height of cylinder
 * @param slices - number of slices
 * @param stacks - number of stacks 
 */
class MyCylinder extends CGFobject {
  constructor(scene, bottomRadius, topRadius, height, slices, stacks) {
    super(scene);
    this.bottomRadius = bottomRadius;
    this.topRadius = topRadius;
    this.height = height;
    this.slices = slices;
    this.stacks = stacks;
    this.initBuffers();
  }

  initBuffers() {
    this.vertices = [];
    this.indices = [];
    this.normals = [];

    var ang = 0;
    var alphaAng = (2 * Math.PI) / this.slices;

    //For Texture Coords

    this.texCoords = [];
    var texCurr = 0, texYCurr = 1;
    var texStep = 1.0 / this.slices;
    var texYStep = 1.0 / this.stacks;

    /* think about a prism made of rectangles. Each rectangle like so:
     * 1----3
     * |\   |
     * | \  |
     * |  \ |
     * |   \|
     * 0----2
     *
     * We add the first 2 vertices outside the loop because they are
     * a special case (they don't 'link back' to anyone).
     */

    var heightStep = this.height / this.stacks;
    var currHeight = 0;

    // cilinders can be sloped => normals have to be sloped
    var normalSlopeZ = (this.bottomRadius - this.topRadius) / this.height;
    // cos(a)^2 + sin(a)^2 = 1
    var normalLen = Math.sqrt(1 + Math.pow(normalSlopeZ, 2));

    for (var stackN = 1; stackN <= this.stacks; ++stackN) {
      ang = 0;
      texCurr = 0;

      // linear interpolation
      /*
        ---- y2 (x2 = 1)
        |  |
        |  |
        ---- y1 (x1 = 0)

        y3 = ((x2 - x3) * y1 + (x3 - x1) * y2) / (x2 - x1)
      */
      var x3 = (stackN - 1) / this.stacks;
      var r1 = (1 - x3) * this.bottomRadius + x3 * this.topRadius;
      var x4 = stackN / this.stacks;
      var r2 = (1 - x4) * this.bottomRadius + x4 * this.topRadius;

      // this is vertice 0
      this.vertices.push(r1 * Math.cos(ang), r1 * Math.sin(ang), currHeight);
      this.normals.push(Math.cos(ang) / normalLen, Math.sin(ang) / normalLen, normalSlopeZ / normalLen);
      this.texCoords.push(texCurr, texYCurr);
      
      // this is vertice 1
      this.vertices.push(r2 * Math.cos(ang), r2 * Math.sin(ang), currHeight + heightStep);
      this.normals.push(Math.cos(ang) / normalLen, Math.sin(ang) / normalLen, normalSlopeZ / normalLen);
      this.texCoords.push(texCurr, texYCurr - texYStep);
      ang += alphaAng;
      texCurr += texStep;

      // do until we reach the number of vertices in current slice
      for (var i = (this.slices * 2 + 2) * (stackN - 1) + 2; i < (this.slices * 2 + 2) * stackN; i += 2) {
        
        // this is vertice 2
        this.vertices.push(r1 * Math.cos(ang), r1 * Math.sin(ang), currHeight);
        this.normals.push(Math.cos(ang) / normalLen, Math.sin(ang) / normalLen, normalSlopeZ / normalLen);
        this.texCoords.push(texCurr, texYCurr);

        // this is vertice 3
        this.vertices.push(r2 * Math.cos(ang), r2 * Math.sin(ang), currHeight + heightStep);
        this.normals.push(Math.cos(ang) / normalLen, Math.sin(ang) / normalLen, normalSlopeZ / normalLen);
        this.texCoords.push(texCurr, texYCurr - texYStep);

        // these are the triangles: 0-1-2 and 1-3-2
        this.indices.push(i - 2, i, i - 1);
        this.indices.push(i, i + 1, i - 1);
        ang += alphaAng;
        texCurr += texStep;
      }

      texYCurr -= texYStep;
      currHeight += heightStep;
    }

    /* bottom cap */

    /* center */
    ang = 0;
    this.vertices.push(0, 0, 0);
    this.normals.push(0, 0, -1);
    this.texCoords.push(0.5, 0.5);
    var centerInd = this.vertices.length / 3 - 1;

    /* other vertices */ 
    this.vertices.push(this.bottomRadius * Math.cos(ang), this.bottomRadius * Math.sin(ang), 0);
    this.normals.push(0, 0, -1);
    this.texCoords.push(Math.cos(ang) * 0.5 + 0.5, Math.sin(ang) * 0.5 + 0.5);
    ang += alphaAng;

    // do until we reach the number of vertices in current slice
    for (var i = 2; i <= this.slices + 1; ++i) {
      this.vertices.push(this.bottomRadius * Math.cos(ang), this.bottomRadius * Math.sin(ang), 0);
      this.normals.push(0, 0, -1);
      this.texCoords.push(Math.cos(ang) * 0.5 + 0.5, 1 - (Math.sin(ang) * 0.5 + 0.5));
      ang += alphaAng;

      this.indices.push(centerInd + i, centerInd + i - 1, centerInd);
    }

    /* top cap */
    /* center */
    ang = 0;
    this.vertices.push(0, 0, this.height);
    this.normals.push(0, 0, 1);
    this.texCoords.push(0.5, 0.5);
    centerInd = this.vertices.length / 3 - 1;

    /* other vertices  */
    this.vertices.push(this.topRadius * Math.cos(ang), this.topRadius * Math.sin(ang), this.height);
    this.normals.push(0, 0, 1);
    this.texCoords.push(Math.cos(ang) * 0.5 + 0.5, Math.sin(ang) * 0.5 + 0.5);
    ang += alphaAng;

    // do until we reach the number of vertices in current slice
    for (var i = 2; i <= this.slices + 1; ++i) {
      this.vertices.push(this.topRadius * Math.cos(ang), this.topRadius * Math.sin(ang), this.height);
      this.normals.push(0, 0, 1);
      this.texCoords.push(Math.cos(ang) * 0.5 + 0.5, 1 - (Math.sin(ang) * 0.5 + 0.5));
      ang += alphaAng;

      this.indices.push(centerInd + i - 1, centerInd + i, centerInd);
    }

    this.primitiveType = this.scene.gl.TRIANGLES;
    this.initGLBuffers();
  }

  updateBuffers(complexity) {
    this.slices = 3 + Math.round(9 * complexity); //complexity varies 0-1, so slices varies 3-12

    // reinitialize buffers
    this.initBuffers();
    this.initNormalVizBuffers();
  }
}

class MyTorus extends CGFobject {
    /**
     * @method constructor
     * @param  {CGFscene} scene - MyScene object
     * @param  {integer} slices - number of slices
     * @param  {integer} loops - number of loops
     * @param   {float} innerRadius - inner radius
     * @param   {float} outerRadius - outer radius
     */
    constructor(scene, slices, loops, innerRadius, outerRadius) {
      super(scene);
      this.latDivs = loops;
      this.longDivs = slices;
      this.innerRadius = innerRadius;
      this.outerRadius = outerRadius;
  
      this.initBuffers();
    }
  
    /**
     * @method initBuffers
     * Initializes the sphere buffers
     */
    initBuffers() {
      this.vertices = [];
      this.indices = [];
      this.normals = [];
      this.texCoords = [];
  
      var phiInc = (2 * Math.PI) / this.latDivs;
      var thetaInc = (2 * Math.PI) / this.longDivs;
      var latVertices = this.longDivs + 1;

      var phi = 0;
      var theta = 0;
      // build an all-around stack at a time, starting on "north pole" and proceeding "south"
      for (let latitude = 0; latitude <= this.latDivs; latitude++) {
        var sinPhi = Math.sin(phi);
        var cosPhi = Math.cos(phi);
  
        // in each stack, build all the slices around, starting on longitude 0
        theta = 0;
        for (let longitude = 0; longitude <= this.longDivs; longitude++) {
            //--- Vertices coordinates
            var x = (this.outerRadius + this.innerRadius * Math.cos(theta)) * cosPhi;
            var y = (this.outerRadius + this.innerRadius * Math.cos(theta)) * sinPhi;
            var z = this.innerRadius * Math.sin(theta);
            this.vertices.push(x, y, z);
  
            //--- Texture Coordinates
            this.texCoords.push(longitude/this.longDivs, latitude/this.latDivs);
      
            //--- Indices
            if (latitude < this.latDivs && longitude < this.longDivs) {
                var current = latitude * latVertices + longitude;
                var next = current + latVertices;
                // pushing two triangles using indices from this round (current, current+1)
                // and the ones directly south (next, next+1)
                // (i.e. one full round of slices ahead)
                
                this.indices.push(current + 1, current, next);
                this.indices.push(current + 1, next, next +1);
            }
      
            //--- Normals
            // at each vertex, the direction of the normal is equal to 
            // the vector from the center of the sphere to the vertex.
            // in a sphere of radius equal to one, the vector length is one.
            // therefore, the value of the normal is equal to the position vectro
            var nx = Math.cos(theta) * cosPhi;
            var ny = Math.cos(theta) * sinPhi;
            var nz = Math.sin(theta);
            var normalLen = Math.sqrt(Math.pow(nx, 2) + Math.pow(ny, 2) + Math.pow(nz, 2));
            this.normals.push(nx/normalLen, ny/normalLen, nz/normalLen);
            theta += thetaInc;
        }
        phi += phiInc;
      }

      this.primitiveType = this.scene.gl.TRIANGLES;
      this.initGLBuffers();
    }
}

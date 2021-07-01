/**
 * MyRectangle
 * @constructor
 * @param scene - Reference to MyScene object
 * @param x1 - x coordinate corner 1
 * @param y1 - y coordinate corner 1
 * @param x2 - x coordinate corner 2
 * @param y2 - y coordinate corner 2
 * @param afs - texture amplification in s axis 
 * @param aft - texture amplification in t axis
 */
class MyRectangle extends CGFobject {
	constructor(scene, x1, y1, x2, y2, afs=1.0, aft=1.0) {
		super(scene);
		this.x1 = x1;
		this.x2 = x2;
		this.y1 = y1;
		this.y2 = y2;
		this.afs = afs;
		this.aft = aft;

		this.initBuffers();
	}
	
	initBuffers() {
		this.vertices = [
			this.x1, this.y1, 0,	//0
			this.x2, this.y1, 0,	//1
			this.x1, this.y2, 0,	//2
			this.x2, this.y2, 0		//3
		];

		//Counter-clockwise reference of vertices
		this.indices = [
			0, 1, 2,
			1, 3, 2
		];

		//Normals

		// vector P1 -> P2. If components, have diferent signs, needs inverted normals
		var normalZ = (this.y2 - this.y1) * (this.x2 - this.x1) < 0 ? -1 : 1;
		
		this.normals = [
			0, 0, normalZ,
			0, 0, normalZ,
			0, 0, normalZ,
			0, 0, normalZ
		];
		
		/*
    Texture coords (s,t)
    +----------> s
    |
    |
    |
    v
    t
    */

		this.texCoords = [
			0, Math.abs(this.y2 - this.y1) / this.aft,
			Math.abs(this.x2 - this.x1) / this.afs, Math.abs(this.y2 - this.y1) / this.aft,
			0, 0,
			Math.abs(this.x2 - this.x1) / this.afs, 0
		]
		this.primitiveType = this.scene.gl.TRIANGLES;
		this.initGLBuffers();
	}

	/**
	 * @method updateTexCoords
	 * Updates the list of texture coordinates of the rectangle
	 * @param {Array} coords - Array of texture coordinates
	 */
	updateTexCoords(coords) {
		this.texCoords = [...coords];
		this.updateTexCoordsGLBuffers();
	}
}


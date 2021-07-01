const TexBehaviour = {
  CHANGE: 0,
  KEEP: 1,
  CLEAR: 2,
};

const MatBehaviour = {
  CHANGE: 0,
  KEEP: 1,
};

/**
 * MyNode
 * @constructor
 * @param scene - Scene's Graph
 * @param id - Node ID
 */
class MyNode {
  constructor(scene, id) {
    this.id = id;
    this.scene = scene;

    // tgs
    this.tgMatrix = mat4.create();

    // animation
    this.animId = null;
    this.anim = null;

    // texs
    this.texId = "null";
    this.tex = null;
    this.texBehaviour = TexBehaviour.KEEP;
    this.afs = 1.0;
    this.aft = 1.0;

    // mat
    this.matId = "null";
    this.mat = null;
    this.matBehaviour = MatBehaviour.KEEP;

    // descendants
    this.descendantsNode = [];
    this.descendantsLeaf = [];
  }

  /**
   * Multiplies matrix passed in function's arguments
   * @param tg - transformation matrix to multiply
   */
  addTgMatrix(tg) {
    mat4.multiply(this.tgMatrix, this.tgMatrix, tg);
  }

  /**
   * Defines texture, afs & aft of node. Defines Tex behaviour
   * @param texId - ID of texture to be set
   * @param afs - texture amplification in S axis
   * @param aft - texture amplification in T axis
   */
  setTexture(texId, afs, aft) {
    this.texId = texId;
    this.afs = afs;
    this.aft = aft;

    if (this.texId == "null") this.texBehaviour = TexBehaviour.KEEP;
    else if (this.texId == "clear") this.texBehaviour = TexBehaviour.CLEAR;
    else this.texBehaviour = TexBehaviour.CHANGE;
  }

  /**
   * Defines material of node & defines behaviour
   * @param matId - ID of material to be set
   */
  setMaterial(matId) {
    this.matId = matId;

    if (this.matId == "null") this.matBehaviour = MatBehaviour.KEEP;
    else this.matBehaviour = MatBehaviour.CHANGE;
  }

  /**
   * Adds descendants to node
   * @param desc - descendent(s) to be added to node
   */
  addDescendantNode(desc) {
    this.descendantsNode.push(desc);
  }

  /**
   * Adds descendants leaf to node
   * @param desc - leaf descendent(s) to be added to node
   */
  addDescendantLeaf(desc) {
    this.descendantsLeaf.push(desc);
  }

  /**
   * calls display on each CFGobject (leafs)
   */
  displayPrimitives() {
    // draw primitives
    // calls display on each CFGobject (leafs)
    this.descendantsLeaf.forEach((leaf) => leaf.display());
  }

  /**
   * Pushes transformations & materials & textures into scene's stacks
   */
  scenePushes() {
    // transformations
    this.scene.pushTransformation(this.tgMatrix);
    if (this.anim != null) this.anim.apply();

    // materials
    if (this.matBehaviour == MatBehaviour.CHANGE)
      this.scene.pushMaterial(this.mat);

    // textures
    if (this.texBehaviour == TexBehaviour.CHANGE)
      this.scene.pushTexture(this.tex);
    else if (this.texBehaviour == TexBehaviour.CLEAR)
      this.scene.unbindActiveTex();
  }

  /**
   * Pops transformations & materials & textures into scene's stacks
   */
  scenePops() {
    // textures
    if (this.texBehaviour == TexBehaviour.CHANGE) this.scene.popTexture();

    // materials
    if (this.matBehaviour == MatBehaviour.CHANGE) this.scene.popMaterial();

    // transformations
    if (this.anim != null) this.scene.popTransformation();
    this.scene.popTransformation();
  }

  /**
   * Displays node & its descendents
   */
  display() {
    this.scenePushes();
    this.displayPrimitives();
    // recursively process descendant MyNode objects
    for (var i = 0; i < this.descendantsNode.length; ++i)
      this.descendantsNode[i].display();
    this.scenePops();
  }

  /**
   * Enables normals visualization for each primitive
   */
  enableNormalViz() {
    this.descendantsLeaf.forEach((leaf) => leaf.enableNormalViz());
  }

  /**
   * Disables normals visualization for each primitive
   */
  disableNormalViz() {
    this.descendantsLeaf.forEach((leaf) => leaf.disableNormalViz());
  }
}

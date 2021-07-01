const DEGREE_TO_RAD = Math.PI / 180;

// Order of the groups in the XML document.
var INITIALS_INDEX = 0;
var VIEWS_INDEX = 1;
var ILLUMINATION_INDEX = 2;
var LIGHTS_INDEX = 3;
var TEXTURES_INDEX = 4;
var SPRITESHEETS_INDEX = 5;
var MATERIALS_INDEX = 6;
var ANIMATIONS_INDEX = 7;
var NODES_INDEX = 8;
var GAMEOPTS_INDEX = 9;

/**
 * MySceneGraph class, representing the scene graph.
 */
class MySceneGraph {
  /**
   * Constructor for MySceneGraph class.
   * Initializes necessary variables and starts the XML file reading process.
   * @param {string} filename - File that defines the 3D scene
   * @param {XMLScene} scene
   */
  constructor(filename, scene) {
    this.loadedOk = null;

    // Establish bidirectional references between scene and graph.
    this.scene = scene;
    this.sceneIndex = scene.addGraph(this);
    this.name = "Graph" + this.sceneIndex;

    this.nodes = [];
    this.idRoot = null; // The id of the root element.

    this.axisCoords = [];
    this.axisCoords["x"] = [1, 0, 0];
    this.axisCoords["y"] = [0, 1, 0];
    this.axisCoords["z"] = [0, 0, 1];

    // File reading
    this.reader = new CGFXMLreader();

    /*
     * Read the contents of the xml file, and refer to this class for loading and error handlers.
     * After the file is read, the reader calls onXMLReady on this object.
     * If any error occurs, the reader calls onXMLError on this object, with an error message
     */
    this.reader.open("scenes/" + filename, this);
    this.boardPos = [0, 0, 0];
    this.scorePos = [0, 0, 0];
    this.updatables = []; // the objects that need to be updated each frame
  }

  /*
   * Callback to be executed after successful reading
   */
  onXMLReady() {
    this.log("XML Loading finished.");
    var rootElement = this.reader.xmlDoc.documentElement;

    // Here should go the calls for different functions to parse the various blocks
    var error = this.parseXMLFile(rootElement);

    if (error != null) {
      this.onXMLError(error);
      return;
    }

    this.loadedOk = true;

    // As the graph loaded ok, signal the scene so that any additional initialization depending on the graph can take place
    this.scene.onGraphLoaded(this);
  }

  /*
   * Callback to be executed on any read error, showing an error on the console.
   * @param {string} message
   */
  onXMLError(message) {
    console.error("XML Loading Error: " + message);
    this.loadedOk = false;
  }

  /**
   * Callback to be executed on any minor error, showing a warning on the console.
   * @param {string} message
   */
  onXMLMinorError(message) {
    console.warn("Warning: " + message);
  }

  /**
   * Callback to be executed on any message.
   * @param {string} message
   */
  log(message) {
    console.log("   " + message);
  }

  /**
   * Parses the XML file, processing each block.
   * @param {XML root element} rootElement
   */
  parseXMLFile(rootElement) {
    if (rootElement.nodeName != "lsf") return "root tag <lsf> missing";

    var nodes = rootElement.children;

    // Reads the names of the nodes to an auxiliary buffer.
    var nodeNames = [];

    for (var i = 0; i < nodes.length; i++) {
      nodeNames.push(nodes[i].nodeName);
    }

    var error;

    // Processes each node, verifying errors.

    // <initials>
    var index;
    if ((index = nodeNames.indexOf("initials")) == -1)
      return "tag <initials> missing";
    else {
      if (index != INITIALS_INDEX)
        this.onXMLMinorError("tag <initials> out of order " + index);

      //Parse initials block
      if ((error = this.parseInitials(nodes[index])) != null) return error;
    }

    // <views>
    if ((index = nodeNames.indexOf("views")) == -1)
      return "tag <views> missing";
    else {
      if (index != VIEWS_INDEX)
        this.onXMLMinorError("tag <views> out of order");

      //Parse views block
      if ((error = this.parseViews(nodes[index])) != null) return error;
    }

    // <illumination>
    if ((index = nodeNames.indexOf("illumination")) == -1)
      return "tag <illumination> missing";
    else {
      if (index != ILLUMINATION_INDEX)
        this.onXMLMinorError("tag <illumination> out of order");

      //Parse illumination block
      if ((error = this.parseIllumination(nodes[index])) != null) return error;
    }

    // <lights>
    if ((index = nodeNames.indexOf("lights")) == -1)
      return "tag <lights> missing";
    else {
      if (index != LIGHTS_INDEX)
        this.onXMLMinorError("tag <lights> out of order");

      //Parse lights block
      if ((error = this.parseLights(nodes[index])) != null) return error;
    }

    // <textures>
    if ((index = nodeNames.indexOf("textures")) == -1)
      return "tag <textures> missing";
    else {
      if (index != TEXTURES_INDEX)
        this.onXMLMinorError("tag <textures> out of order");

      //Parse textures block
      if ((error = this.parseTextures(nodes[index])) != null) return error;
    }

    // <spritesheets>
    if ((index = nodeNames.indexOf("spritesheets")) == -1)
      return "tag <spritesheets> missing";
    else {
      if (index != SPRITESHEETS_INDEX)
        this.onXMLMinorError("tag <spritesheets> out of order");

      //Parse textures block
      if ((error = this.parseSpritesheets(nodes[index])) != null) return error;
    }

    // <materials>
    if ((index = nodeNames.indexOf("materials")) == -1)
      return "tag <materials> missing";
    else {
      if (index != MATERIALS_INDEX)
        this.onXMLMinorError("tag <materials> out of order");

      // Parse materials block
      if ((error = this.parseMaterials(nodes[index])) != null) return error;
    }

    // <animations>
    if ((index = nodeNames.indexOf("animations")) == -1)
      this.onXMLMinorError(
        "tag <animations> missing. Assuming that there are no animations"
      );
    else {
      if (index != ANIMATIONS_INDEX)
        this.onXMLMinorError("tag <animations> out of order");

      // Parse animations block
      if ((error = this.parseAnimations(nodes[index])) != null) return error;
    }

    // <nodes>
    if ((index = nodeNames.indexOf("nodes")) == -1)
      return "tag <nodes> missing";
    else {
      if (index != NODES_INDEX)
        this.onXMLMinorError("tag <nodes> out of order");

      // Parse nodes block
      if ((error = this.parseNodes(nodes[index])) != null) return error;
    }

    // <gameoptions>
    if ((index = nodeNames.indexOf("gameoptions")) == -1)
      return "tag <gameoptions> missing";
    else {
      if (index != GAMEOPTS_INDEX)
        this.onXMLMinorError("tag <gameoptions> out of order");

      // Parse gameoptions block
      if ((error = this.parseGameoptions(nodes[index])) != null) return error;
    }

    this.log("all parsed");
  }

  /**
   * Parses the <initials> block.
   * @param {initials block element} initialsNode
   */
  parseInitials(initialsNode) {
    var children = initialsNode.children;
    var nodeNames = [];

    for (let i = 0; i < children.length; i++)
      nodeNames.push(children[i].nodeName);

    let rootIndex = nodeNames.indexOf("root");
    let referenceIndex = nodeNames.indexOf("reference");

    // Get root of the scene.
    if (rootIndex == -1) return "No root id defined for scene.";

    let rootNode = children[rootIndex];
    let id = this.reader.getString(rootNode, "id");
    if (id == null) return "No root id defined for scene.";
    this.idRoot = id;

    // Get axis length
    if (referenceIndex == -1)
      this.onXMLMinorError(
        "no axis_length defined for scene; assuming 'length = 1'"
      );

    let refNode = children[referenceIndex];
    let axis_length = this.reader.getFloat(refNode, "length");
    if (axis_length == null)
      this.onXMLMinorError(
        "no axis_length defined for scene; assuming 'length = 1'"
      );

    this.referenceLength = axis_length || 1;

    // Get scene graph name
    let nameIndex = nodeNames.indexOf("name");
    if (nameIndex != -1) {
      let name = this.reader.getString(children[nameIndex], "name");
      if (name == null)
        this.onXMLMinorError(
          "Couldn't parse scene graph's name. Using default: " + this.name
        );
      else this.name = name;
    } else {
      this.onXMLMinorError(
        "No name defined for this scene graph. Using default: " + this.name
      );
    }

    this.log("Parsed initials");
    return null;
  }

  /**
   * Parses the <views> block.
   * @param {view block element} viewsNode
   */
  parseViews(viewsNode) {
    var children = viewsNode.children;

    this.cameras = [];
    // assume first camera if none given
    this.defaultCameraId = this.reader.getString(viewsNode, "default");
    if (this.defaultCameraId == null) return this.defaultCameraId;
    var numCameras = 0;

    var grandChildren = [];
    var nodeNames = [];

    for (var i = 0; i < children.length; i++) {
      // Storing camera information
      var global = [];
      var attributeNames = [];

      // Check type of camera
      if (children[i].nodeName == "perspective") {
        attributeNames = ["angle", "near", "far"];
        global = ["perspective"];
      } else if (children[i].nodeName == "ortho") {
        attributeNames = ["left", "right", "bottom", "top", "near", "far"];
        global = ["ortho"];
      } else {
        this.onXMLMinorError("unknown tag <" + children[i].nodeName + ">");
        continue;
      }

      // Get id of the current camera.
      var cameraId = this.reader.getString(children[i], "id");
      if (cameraId == null) return "no ID defined for camera";
      global.push(cameraId);

      // Checks for repeated IDs.
      if (this.cameras[cameraId] != null)
        return (
          "ID must be unique for each camera (conflict: ID = " + cameraId + ")"
        );

      // Specifications for the current light.

      // Parse remaining tag info
      nodeNames = [];
      for (var j = 0; j < children[i].attributes.length; j++) {
        nodeNames.push(children[i].attributes[j].nodeName);
      }
      for (var j = 0; j < attributeNames.length; j++) {
        var attributeIndex = nodeNames.indexOf(attributeNames[j]);

        if (attributeIndex != -1) {
          var aux = this.reader.getFloat(
            children[i],
            attributeNames[j],
            "camera float (" + attributeNames[j] + ") with ID " + cameraId
          );
          if (attributeNames[j] == "angle") aux *= DEGREE_TO_RAD; // need to convert to rad
          if (typeof aux === "string" || aux instanceof String) return aux;

          global.push(aux);
        } else
          return (
            "camera " + attributeNames[j] + " undefined for ID = " + cameraId
          );
      }

      // Parse other info
      if (children[i].nodeName == "perspective")
        attributeNames = ["from", "to"];
      else attributeNames = ["from", "to", "up"];

      nodeNames = [];
      grandChildren = children[i].children;
      for (var j = 0; j < grandChildren.length; j++) {
        nodeNames.push(grandChildren[j].nodeName);
      }

      for (var j = 0; j < attributeNames.length; j++) {
        var attributeIndex = nodeNames.indexOf(attributeNames[j]);

        if (attributeIndex != -1) {
          var aux = this.parseCoordinates3D(
            grandChildren[attributeIndex],
            attributeNames[j],
            "camera position (" + attributeNames[j] + ") with ID " + cameraId
          );
          if (typeof aux === "string" || aux instanceof String) return aux;

          global.push(aux);
        } else if (attributeNames[j] == "up") {
          // default value
          global.push([0, 1, 0]);
        } else {
          return (
            "camera " + attributeNames[j] + " undefined for ID = " + cameraId
          );
        }
      }

      this.cameras[cameraId] = global;
      ++numCameras;
    }

    if (numCameras == 0) return "at least one camera must be defined";
    if (this.cameras[this.defaultCameraId] == null)
      return "default camera (" + this.defaultCameraId + ") was not defined.";

    this.log("Parsed views");
    return null;
  }

  /**
   * Parses the <illumination> node.
   * @param {illumination block element} illuminationsNode
   */
  parseIllumination(illuminationsNode) {
    var children = illuminationsNode.children;

    this.ambient = [];
    this.background = [];

    var nodeNames = [];

    for (var i = 0; i < children.length; i++)
      nodeNames.push(children[i].nodeName);

    var ambientIndex = nodeNames.indexOf("ambient");
    var backgroundIndex = nodeNames.indexOf("background");

    var color = this.parseColor(children[ambientIndex], "ambient");
    if (!Array.isArray(color)) return color;
    else this.ambient = color;

    color = this.parseColor(children[backgroundIndex], "background");
    if (!Array.isArray(color)) return color;
    else this.background = color;

    this.log("Parsed Illumination.");

    return null;
  }

  /**
   * Parses the <light> node.
   * @param {lights block element} lightsNode
   */
  parseLights(lightsNode) {
    var children = lightsNode.children;

    this.lights = [];
    var numLights = 0;

    var grandChildren = [];
    var nodeNames = [];

    // Any number of lights.
    for (var i = 0; i < children.length; i++) {
      // Storing light information
      var global = [];
      var attributeNames = [];
      var attributeTypes = [];

      //Check type of light
      if (children[i].nodeName != "light") {
        this.onXMLMinorError("unknown tag <" + children[i].nodeName + ">");
        continue;
      } else {
        attributeNames.push(
          ...["enable", "position", "ambient", "diffuse", "specular"]
        );
        attributeTypes.push(
          ...["boolean", "position", "color", "color", "color"]
        );
      }

      // Get id of the current light.
      var lightId = this.reader.getString(children[i], "id");
      if (lightId == null) return "no ID defined for light";

      // Checks for repeated IDs.
      if (this.lights[lightId] != null)
        return (
          "ID must be unique for each light (conflict: ID = " + lightId + ")"
        );

      grandChildren = children[i].children;
      // Specifications for the current light.

      nodeNames = [];
      for (var j = 0; j < grandChildren.length; j++) {
        nodeNames.push(grandChildren[j].nodeName);
      }

      for (var j = 0; j < attributeNames.length; j++) {
        var attributeIndex = nodeNames.indexOf(attributeNames[j]);

        if (attributeIndex != -1) {
          if (attributeTypes[j] == "boolean")
            var aux = this.parseBoolean(
              grandChildren[attributeIndex],
              "value",
              "enabled attribute for light of ID " + lightId
            );
          else if (attributeTypes[j] == "position")
            var aux = this.parseCoordinates4D(
              grandChildren[attributeIndex],
              "light position for ID " + lightId
            );
          else
            var aux = this.parseColor(
              grandChildren[attributeIndex],
              attributeNames[j] + " illumination for ID " + lightId
            );

          if (typeof aux === "string" || aux instanceof String) return aux;

          global.push(aux);
        } else {
          if (attributeNames[j] == "enable") {
            this.onXMLMinorError(
              "light enable attribute undefined for ID = " +
                lightId +
                "; assuming true."
            );
            global.push(true);
          } else {
            return (
              "light " + attributeNames[j] + " undefined for ID = " + lightId
            );
          }
        }
      }

      global.push(lightId);
      this.lights[lightId] = global;
      numLights++;
    }

    if (numLights == 0) return "at least one light must be defined.";
    else if (numLights > 8)
      this.onXMLMinorError(
        "too many lights defined; WebGL imposes a limit of 8 lights."
      );

    this.log("Parsed lights.");
    return null;
  }

  /**
   * Parses the <textures> block.
   * @param {textures block element} texturesNode
   */
  parseTextures(texturesNode) {
    //For each texture in textures block, check ID and file URL
    //this.onXMLMinorError("To do: Parse textures.");

    var children = texturesNode.children;

    this.textures = [];

    // Any number of textures.
    for (var i = 0; i < children.length; i++) {
      if (children[i].nodeName != "texture") {
        this.onXMLMinorError("unknown tag <" + children[i].nodeName + ">");
        continue;
      }

      // Get id of the current texture.
      var textureID = this.reader.getString(children[i], "id");
      if (textureID == null) return "no ID defined for texture";

      // Checks for repeated IDs.
      if (this.textures[textureID] != null)
        return (
          "ID must be unique for each texture (conflict: ID = " +
          textureID +
          ")"
        );

      // Get path of the current texture.
      var texturePath = this.reader.getString(children[i], "path");
      if (texturePath == null) return "no Path defined for texture";

      this.textures[textureID] = new CGFtexture(this.scene, texturePath);
      // TODO this doesn't work
      /*
       * if (this.textures[textureID] == null)
       *   return (
       *     "texture with ID " +
       *     textureID +
       *     " failed loading. Given path is probably wrong."
       *   );
       */
    }

    this.log("Parsed textures");
    return null;
  }

  /**
   * Parses the <spritesheets> block.
   * @param {spritesheets block element} spritesheetsNode
   */
  parseSpritesheets(spritesheetsNode) {
    //For each spritesheet in spritesheets block, check ID and file URL
    let children = spritesheetsNode.children;

    this.spritesheets = [];

    // Any number of textures.
    for (var i = 0; i < children.length; i++) {
      if (children[i].nodeName != "spritesheet") {
        this.onXMLMinorError("unknown tag <" + children[i].nodeName + ">");
        continue;
      }

      // Get id of the current texture.
      let ssID = this.reader.getString(children[i], "id");
      if (ssID == null) return "no ID defined for spritesheet";

      // Checks for repeated IDs.
      if (this.spritesheets[ssID] != null)
        return (
          "ID must be unique for each spritesheet (conflict: ID = " + ssID + ")"
        );

      // Get path of the current spritesheet.
      let ssPath = this.reader.getString(children[i], "path");
      if (ssPath == null) return "no Path defined for spritesheet";

      let sizeM = this.parseInteger(children[i], "sizeM", "not defined.");
      if (typeof sizeM === "string" || sizeM instanceof String) return sizeM;
      let sizeN = this.parseInteger(children[i], "sizeN", "not defined.");
      if (typeof sizeN === "string" || sizeN instanceof String) return sizeN;

      let ssTex = new CGFtexture(this.scene, ssPath);
      if (ssTex == null)
        return (
          "texture with ID " +
          textureID +
          " failed loading. Given path is probably wrong."
        );

      this.spritesheets[ssID] = new MySpritesheet(
        this.scene,
        ssTex,
        sizeM,
        sizeN
      );
    }

    this.log("Parsed spritesheets");
    return null;
  }

  /**
   * Parses the <materials> node.
   * @param {materials block element} materialsNode
   */
  parseMaterials(materialsNode) {
    var children = materialsNode.children;

    this.materials = [];
    var numMaterials = 0;

    var grandChildren = [];
    var nodeNames = [];

    // Any number of materials.
    for (var i = 0; i < children.length; i++) {
      // Storing light information
      var global = [];
      var attributeNames = [];
      var attributeTypes = [];

      //Check type of material
      if (children[i].nodeName != "material") {
        this.onXMLMinorError("unknown tag <" + children[i].nodeName + ">");
        continue;
      } else {
        attributeNames = [
          "shininess",
          "ambient",
          "diffuse",
          "specular",
          "emissive",
        ];
        attributeTypes = ["float", "color", "color", "color", "color"];
      }

      // Get id of the current material.
      var materialID = this.reader.getString(children[i], "id");
      if (materialID == null) return "no ID defined for material";

      // Checks for repeated IDs.
      if (this.materials[materialID] != null)
        return (
          "ID must be unique for each material (conflict: ID = " +
          materialID +
          ")"
        );

      grandChildren = children[i].children;
      // Specifications for the current material.

      nodeNames = [];
      for (var j = 0; j < grandChildren.length; j++) {
        nodeNames.push(grandChildren[j].nodeName);
      }

      for (var j = 0; j < attributeNames.length; j++) {
        var attributeIndex = nodeNames.indexOf(attributeNames[j]);

        if (attributeIndex != -1) {
          if (attributeTypes[j] == "float")
            var aux = this.parseFloat(
              grandChildren[attributeIndex],
              "value",
              "shininess attribute for material of ID " + materialID
            );
          else
            var aux = this.parseColor(
              grandChildren[attributeIndex],
              attributeNames[j] + " illumination for ID " + materialID
            );

          if (typeof aux === "string" || aux instanceof String) return aux;

          global.push(aux);
        } else
          return (
            "material " +
            attributeNames[j] +
            " undefined for ID = " +
            materialID
          );
      }

      var mat = new CGFappearance(this.scene);
      mat.setShininess(global[0]);
      mat.setAmbient(...global[1]);
      mat.setDiffuse(...global[2]);
      mat.setSpecular(...global[3]);
      mat.setEmission(...global[4]);

      this.materials[materialID] = mat;

      numMaterials++;
    }

    if (numMaterials == 0) return "at least one material must be defined.";

    this.log("Parsed materials");
    return null;
  }

  checkTransformationIndex(tgNames, tg, expectedInd, animationID) {
    var ind;
    ind = tgNames.indexOf(tg);
    if (ind == -1)
      this.onXMLMinorError(
        "<" + tg + "> tag on animation " + animationID + " is missing."
      );
    else if (ind != expectedInd)
      this.onXMLMinorError(
        "<" +
          tg +
          "> tag on animation " +
          animationID +
          " isn't on the corect position."
      );
  }

  /**
   * Parses the <animationsNode> node.
   * @param {animations block element} animationsNode
   */
  parseAnimations(animationsNode) {
    let children = animationsNode.children;

    this.animations = [];

    // Any number of animations
    for (let i = 0; i < children.length; ++i) {
      if (children[i].nodeName != "animation") {
        this.onXMLMinorError("unknown tag <" + children[i].nodeName + ">");
        continue;
      }

      var animationID = this.reader.getString(children[i], "id");
      if (animationID == null) return "no ID defined for animation";

      if (this.animations[animationID] != null)
        return (
          "ID must be unique for each animation (conflict: ID = " +
          animationID +
          ")"
        );

      let keyframes = [];
      let prevInst = -1;
      let grandChildren = children[i].children;
      for (let j = 0; j < grandChildren.length; ++j) {
        let inst = this.parseFloat(
          grandChildren[j],
          "instant",
          "Instant not defined for keyframe on node: " + animationID
        );
        if (prevInst >= inst)
          this.onXMLMinorError(
            "The instants " +
              prevInst +
              " and " +
              inst +
              " are unordered. Assuming crescent order."
          );
        prevInst = inst;

        /* tx, ty, tz, rx, ry, rz, sx, sy, sz */
        let global = [0, 0, 0, 0, 0, 0, 1, 1, 1];
        let presentTg = [false, false, false, false, false];

        let grandgrandChildren = grandChildren[j].children;
        for (let k = 0; k < grandgrandChildren.length; ++k) {
          let tgInd = -1;
          let tgName = grandgrandChildren[k].nodeName;
          switch (tgName) {
            case "translation":
              tgInd = 0;
              let coords = this.parseCoordinates3D(
                grandgrandChildren[k],
                "translation of animation with ID: " + animationID + "."
              );
              if (!Array.isArray(coords)) return coords;
              global[0] = coords[0];
              global[1] = coords[1];
              global[2] = coords[2];
              presentTg[0] = true; // translation is present
              break;
            case "rotation":
              let axis = this.reader.getString(grandgrandChildren[k], "axis");
              if (axis == null)
                return (
                  "unable to parse rotation axis of animation with ID: " +
                  animationID +
                  "."
                );

              let angle = this.parseFloat(
                grandgrandChildren[k],
                "angle",
                "angle of animation with ID: " + animationID + "."
              );
              if (typeof angle === "string" || angle instanceof String)
                return angle;
              angle *= DEGREE_TO_RAD; // need to convert to rad

              switch (axis) {
                case "x":
                  tgInd = 1;
                  global[3] = angle;
                  presentTg[1] = true; // rotX is present
                  break;
                case "y":
                  tgInd = 2;
                  global[4] = angle;
                  presentTg[2] = true; // rotY is present
                  break;
                case "z":
                  tgInd = 3;
                  global[5] = angle;
                  presentTg[3] = true; // rotZ is present
                  break;
                default:
                  this.onXMLMinorError(
                    "unknown rotation axis: " +
                      axis +
                      " for animation with ID: " +
                      animationID +
                      ". Skipping it.."
                  );
                  break;
              }
              break;
            case "scale":
              tgInd = 4;
              let scales = this.parseCoordinates3DScale(
                grandgrandChildren[k],
                "animation with ID: " + animationID,
                0.0
              );
              if (!Array.isArray(scales)) return scales;
              global[6] = scales[0];
              global[7] = scales[1];
              global[8] = scales[2];
              presentTg[4] = true; // scale is present
              break;
            default:
              this.onXMLMinorError(
                "Transformation " +
                  tgName +
                  " on animation with ID: " +
                  animationID +
                  " is unkown. Skipping it.."
              );
              break;
          }

          if (tgInd != -1 && k != tgInd) {
            // queixar de transformacoes fora de ordem
            this.onXMLMinorError(
              "Transformation " +
                tgName +
                " on animation with ID: " +
                animationID +
                " is out of order. Assuming the default order."
            );
          }
        }

        // queixar de transformacoes missing
        let missing = "";
        if (!presentTg[0]) missing += "translation, ";
        if (!presentTg[1]) missing += "rotation x, ";
        if (!presentTg[2]) missing += "rotation y, ";
        if (!presentTg[3]) missing += "rotation z, ";
        if (!presentTg[4]) missing += "scale, ";

        if (missing != "") {
          this.onXMLMinorError(
            "Animation with ID: " +
              animationID +
              " is missing transformations: " +
              missing.slice(0, -2) +
              ". Assuming default values for those."
          );
        }

        // push new keyframe
        keyframes.push(new Keyframe(inst, ...global));
      }

      // sort keyframes
      keyframes.sort((a, b) => {
        return a.instant - b.instant;
      });
      for (let i = 0; i < keyframes.length - 1; ++i)
        keyframes[i].nextKF = keyframes[i + 1];
      if (keyframes.length == 0)
        this.onXMLMinorError(
          "Keyframe animation, " +
            animationID +
            ", has no keyframes. Its objects will be invisible."
        );
      // create (and push) the new animation with its keyframes
      this.animations[animationID] = new KeyframeAnimation(
        this.scene,
        animationID,
        keyframes
      );

      this.updatables.push(this.animations[animationID]);
    }

    return null;
  }

  /**
   * Parses a Leaf Type Node
   * @param {leaf block element} leafNode
   * @param afs - texture amplification in s axis
   * @param aft - texture amplification in t axis
   * @returns obj, on successful obj instanciation,
   *          null, on failure
   */
  parseLeaf(leafNode, afs = 1.0, aft = 1.0) {
    let attributeNames;
    let attributeTypes;
    let objType = this.reader.getString(leafNode, "type");
    switch (objType) {
      case "rectangle":
        attributeNames = ["x1", "y1", "x2", "y2"];
        attributeTypes = ["float", "float", "float", "float"];
        break;
      case "triangle":
        attributeNames = ["x1", "y1", "x2", "y2", "x3", "y3"];
        attributeTypes = ["float", "float", "float", "float", "float", "float"];
        break;
      case "cylinder":
        attributeNames = [
          "bottomRadius",
          "topRadius",
          "height",
          "slices",
          "stacks",
        ];
        attributeTypes = ["float", "float", "float", "int", "int"];
        break;
      case "sphere":
        attributeNames = ["radius", "slices", "stacks"];
        attributeTypes = ["float", "int", "int"];
        break;
      case "torus":
        attributeNames = ["slices", "loops", "inner", "outer"];
        attributeTypes = ["int", "int", "float", "float"];
        break;
      case "spritetext":
        attributeNames = ["text"];
        attributeTypes = ["str"];
        break;
      case "spriteanim":
        attributeNames = ["ssid", "duration", "startCell", "endCell"];
        attributeTypes = ["str", "float", "int", "int"];
        break;
      case "plane":
        attributeNames = ["npartsU", "npartsV"];
        attributeTypes = ["int", "int"];
        break;
      case "patch":
        attributeNames = ["npointsU", "npointsV", "npartsU", "npartsV"];
        attributeTypes = ["int", "int", "int", "int"];
        break;
      case "defbarrel":
        attributeNames = ["base", "middle", "height", "slices", "stacks"];
        attributeTypes = ["float", "float", "float", "int", "int"];
        break;
      case "cube":
        attributeNames = ["side"];
        attributeTypes = ["float"];
        break;
      default:
        return "unknown leaf type: " + objType + ".";
    }

    // Parse remaining tag info
    let global = [];
    let nodeNames = [];
    for (var j = 0; j < leafNode.attributes.length; j++)
      nodeNames.push(leafNode.attributes[j].nodeName);

    for (var j = 0; j < attributeNames.length; j++) {
      let attributeIndex = nodeNames.indexOf(attributeNames[j]);

      if (attributeIndex != -1) {
        let aux;
        if (attributeTypes[j] == "int") {
          aux = this.parseInteger(
            leafNode,
            attributeNames[j],
            "leaf integer (" + attributeNames[j] + ") with type " + objType
          );
          if (typeof aux === "string" || aux instanceof String) return aux;
        } else if (attributeTypes[j] == "str") {
          aux = this.reader.getString(leafNode, attributeNames[j]);
          if (typeof aux == null)
            return "Sprite text in couldn't be parsed: " + leafNode + ".";
        } else if (attributeTypes[j] == "float") {
          aux = this.parseFloat(
            leafNode,
            attributeNames[j],
            "leaf float (" + attributeNames[j] + ") with type " + objType
          );
          if (typeof aux === "string" || aux instanceof String) return aux;
        }

        global.push(aux);
      } else
        return "leaf " + attributeNames[j] + " undefined for type = " + objType;
    }

    var obj;
    switch (objType) {
      case "rectangle":
        obj = new MyRectangle(this.scene, ...global, afs, aft);
        break;
      case "triangle":
        obj = new MyTriangle(this.scene, ...global, afs, aft);
        break;
      case "cylinder":
        obj = new MyCylinder(this.scene, ...global);
        break;
      case "sphere":
        obj = new MySphere(this.scene, ...global);
        break;
      case "torus":
        obj = new MyTorus(this.scene, ...global);
        break;
      case "spritetext":
        obj = new MySpriteText(this.scene, ...global);
        break;
      case "spriteanim":
        if (this.spritesheets[global[0]] == null) {
          obj = null;
        } else {
          obj = new MySpriteAnimation(
            this.scene,
            this.spritesheets[global[0]],
            ...global.slice(1)
          );

          // push animation so it can be updated
          this.updatables.push(obj);
        }
        break;
      case "plane":
        obj = new Plane(this.scene, ...global);
        break;
      case "patch":
        // parse control points (list)
        let controlPoints = [];
        let ctrlPointList = leafNode.children;
        for (let i = 0; i < ctrlPointList.length; ++i) {
          if (ctrlPointList[i].nodeName != "controlpoint") {
            this.onXMLMinorError(
              "unknown tag <" + ctrlPointList[i].nodeName + "> inside leaf."
            );
            continue;
          }

          let ctrlP = this.parseCoordinates3D(
            ctrlPointList[i],
            "controlpoint of leaf."
          );
          if (!Array.isArray(ctrlP)) return ctrlP;

          controlPoints.push(ctrlP);
        }

        if (global[0] * global[1] > controlPoints.length) {
          return (
            "Note enough control points were specified. Specified " +
            controlPoints.length +
            " expected " +
            global[0] * global[1]
          );
        } else if (global[0] * global[1] < controlPoints.length) {
          this.onXMLMinorError(
            "There are more control points specified than will be used. Specified " +
              controlPoints.length +
              " expected " +
              global[0] * global[1]
          );
        }

        obj = new Patch(this.scene, ...global, controlPoints);
        break;
      case "defbarrel":
        obj = new Defbarrel(this.scene, ...global);
        break;
      case "cube":
        obj = new MyCube(this.scene, ...global, afs, aft);
        break;
      default:
        obj = null;
        break;
    }

    return obj;
  }

  /**
   * Parses a given node's transformations
   * @param {object that contains transformation's info} tgInfo
   */
  parseNodeTransformation(tgInfo, nodeID) {
    var tgMtr = mat4.create();
    var tg = tgInfo.nodeName;

    if (tg == "translation") {
      let coords = this.parseCoordinates3D(
        tgInfo,
        "translation of node with ID: " + nodeID + "."
      );
      if (!Array.isArray(coords)) return coords;

      mat4.translate(tgMtr, tgMtr, coords);
    } else if (tg == "rotation") {
      let axis = this.reader.getString(tgInfo, "axis");
      if (axis == null)
        return "unable to parse rotation axis of node with ID: " + nodeID + ".";
      let angle = this.parseFloat(
        tgInfo,
        "angle",
        "angle of node with ID: " + nodeID + "."
      );
      if (typeof angle === "string" || angle instanceof String) return angle;
      angle *= DEGREE_TO_RAD; // need to convert to rad

      switch (axis) {
        case "x":
          mat4.rotateX(tgMtr, tgMtr, angle);
          break;
        case "y":
          mat4.rotateY(tgMtr, tgMtr, angle);
          break;
        case "z":
          mat4.rotateZ(tgMtr, tgMtr, angle);
          break;
        default:
          this.onXMLMinorError(
            "unknown rotation axis: " +
              axis +
              " for node with ID: " +
              nodeID +
              ". Assuming no rotation."
          );
          break;
      }
    } else if (tg == "scale") {
      let scales = this.parseCoordinates3DScale(
        tgInfo,
        "node with ID: " + nodeID,
        1.0
      );
      mat4.scale(tgMtr, tgMtr, scales);
    } else {
      this.onXMLMinorError(
        "unknown transformation " +
          tg +
          " for node with ID: " +
          nodeID +
          ". Ignoring it."
      );
    }

    return tgMtr;
  }

  /**
   * Parses the <nodes> block.
   * @param {nodes block element} nodesNode
   */
  parseNodes(nodesNode) {
    var children = nodesNode.children;

    var grandChildren = [];
    var grandgrandChildren = [];
    var nodeNames = [];

    // Any number of nodes.
    for (var i = 0; i < children.length; i++) {
      if (children[i].nodeName != "node") {
        this.onXMLMinorError("unknown tag <" + children[i].nodeName + ">");
        continue;
      }

      // Get id of the current node.
      var nodeID = this.reader.getString(children[i], "id");
      if (nodeID == null) return "no ID defined for nodeID";

      // Checks for repeated IDs.
      if (this.nodes[nodeID] != null)
        return (
          "ID must be unique for each node (conflict: ID = " + nodeID + ")"
        );

      var nodeObj = new MyNode(this.scene, nodeID);
      this.nodes[nodeID] = nodeObj;

      grandChildren = children[i].children;

      nodeNames = [];
      for (var j = 0; j < grandChildren.length; j++)
        nodeNames.push(grandChildren[j].nodeName);

      var transformationsIndex = nodeNames.indexOf("transformations");
      var animationIndex = nodeNames.indexOf("animationref");
      var materialIndex = nodeNames.indexOf("material");
      var textureIndex = nodeNames.indexOf("texture");
      var descendantsIndex = nodeNames.indexOf("descendants");

      // Transformations
      if (transformationsIndex == -1) {
        this.onXMLMinorError(
          "tag <transformations> missing, assuming no transformations."
        );
      } else {
        grandgrandChildren = grandChildren[transformationsIndex].children;
        for (var j = 0; j < grandgrandChildren.length; j++) {
          var tg = this.parseNodeTransformation(grandgrandChildren[j], nodeID);
          if (typeof tg === "string" || tg instanceof String) {
            this.onXMLMinorError(tg + " Ignoring it.");
          } else {
            nodeObj.addTgMatrix(tg);
          }
        }
      }

      // Animation
      if (animationIndex != -1) {
        let animId = this.reader.getString(grandChildren[animationIndex], "id");
        if (animId == null)
          this.onXMLMinorError(
            "Couldn't parse ID of animation for node: " + nodeID + "."
          );
        else nodeObj.animId = animId;
      }

      // Material
      if (materialIndex == -1) {
        this.onXMLMinorError("tag <material> missing for node " + nodeID + ")");
      } else {
        var materialID = this.reader.getString(
          grandChildren[materialIndex],
          "id"
        );
        if (materialID == null) return "material is missing an id.";

        if (materialID == "null" && nodeID == this.idRoot)
          this.onXMLMinorError(
            "root node (" +
              this.idRoot +
              ") has no parents so 'null' material doesn't make sense."
          );

        nodeObj.setMaterial(materialID);
      }

      // Texture
      if (textureIndex == -1) {
        this.onXMLMinorError("tag <texture> missing for node " + nodeID + ")");
      } else {
        var textureID = this.reader.getString(
          grandChildren[textureIndex],
          "id"
        );
        if (textureID == null)
          return "texture for node " + nodeID + " is missing an id.";

        let foundAmp = false;
        var afs = 1.0;
        var aft = 1.0;
        grandgrandChildren = grandChildren[textureIndex].children;
        for (var j = 0; j < grandgrandChildren.length; j++) {
          var tag = grandgrandChildren[j].nodeName;
          if (tag == "amplification") {
            afs = this.parseFloat(
              grandgrandChildren[j],
              "afs",
              "texture afs field for node " + nodeID,
              1.0
            );
            aft = this.parseFloat(
              grandgrandChildren[j],
              "aft",
              "texture afs field for node " + nodeID,
              1.0
            );
            foundAmp = true;
          } else {
            this.onXMLMinorError(
              "unknown tag: " + tag + " on texture for node: " + nodeID + "."
            );
            continue;
          }
        }

        if (!foundAmp) {
          this.onXMLMinorError(
            "amplification field is missing for node " +
              nodeID +
              ". Assuming afs = aft = 1."
          );
        }

        if (textureID == "null" && nodeID == this.idRoot)
          this.onXMLMinorError(
            "root node (" +
              this.idRoot +
              ") has no parents so 'null' texture doesn't make sense."
          );

        nodeObj.setTexture(textureID, afs, aft);
      }

      // Descendants
      if (descendantsIndex == -1) {
        return "tag <descendants> missing. Parsing failed";
      } else {
        grandgrandChildren = grandChildren[descendantsIndex].children;
        for (var j = 0; j < grandgrandChildren.length; j++) {
          var descType = grandgrandChildren[j].nodeName;
          if (descType == "noderef") {
            var descId = this.reader.getString(grandgrandChildren[j], "id");
            if (descId == null) return "noderef is missing an id.";
            nodeObj.addDescendantNode(descId);
          } else if (descType == "leaf") {
            var leafObj = this.parseLeaf(grandgrandChildren[j], afs, aft);
            if (typeof leafObj === "string" || leafObj instanceof String)
              return leafObj;
            else if (!leafObj)
              this.onXMLMinorError(
                "Failed instanciating leaf of: " + nodeID + "."
              );
            else nodeObj.addDescendantLeaf(leafObj);
          } else {
            this.onXMLMinorError("unknown descendant type: " + descType + ".");
          }
        }
      }
    }

    var postProc = this.nodesPostProcessing();
    if (postProc != null) return postProc;

    if (this.nodes[this.idRoot] == null)
      return "Root node " + this.idRoot + " was not defined.";
  }

  /**
   * Checks for missing/unused nodes, textures or materials
   */
  nodesPostProcessing() {
    for (var key in this.nodes) {
      var obj = this.nodes[key];

      /* associate animations with nodes */
      let nodeAnimId = obj.animId;
      if (nodeAnimId != null) {
        let nodeAnim = this.animations[nodeAnimId];
        if (nodeAnim == null) {
          this.onXMLMinorError(
            "animation with id " +
              nodeAnimId +
              " was referenced in node with ID " +
              key +
              " but was not defined. Assuming it didn't exist.."
          );
        } else {
          obj.anim = nodeAnim;
        }
      }

      /* associate descendant noderef's IDs with the correct objects */
      for (var i = 0; i < obj.descendantsNode.length; ++i) {
        var desc = obj.descendantsNode[i];
        if (this.nodes[desc] == null)
          return "missing node with ID: " + desc + ".";
        obj.descendantsNode[i] = this.nodes[desc];
      }

      /* associate CFGtextures with MyNodes */
      let nodeTexId = obj.texId;
      if (obj.texBehaviour == TexBehaviour.CHANGE) {
        if (this.textures[nodeTexId] == null) {
          this.onXMLMinorError(
            "texture with id " +
              nodeTexId +
              " was referenced in node with id " +
              key +
              " but was not defined. Giving it missing texture."
          );
          // " but was not defined. Assuming 'null' texture."
          // obj.texBehaviour = TexBehaviour.KEEP;
          obj.tex = this.scene.defaultTex;
        } else {
          obj.tex = this.textures[nodeTexId];
        }
      }

      /* associate CFGapperances with MyNodes */
      let nodeMatId = obj.matId;
      if (obj.matBehaviour == MatBehaviour.CHANGE) {
        if (this.materials[nodeMatId] == null) {
          this.onXMLMinorError(
            "material with id " +
              nodeMatId +
              " was referenced in node with id " +
              key +
              " but was not defined. Assuming 'null' material."
          );
          obj.matBehaviour = MatBehaviour.KEEP;
        } else {
          obj.mat = this.materials[nodeMatId];
        }
      }
    }

    // TODO check for unused nodes
  }

  parseGameoptions(gameoptsNode) {
    let children = gameoptsNode.children;
    for (let i = 0; i < children.length; ++i) {
      // this.reader.getString(children[i], "y");
      let attributeNames;
      let attributeTypes;

      let nodeName = children[i]["nodeName"];
      switch (nodeName) {
        case "gameboard":
          attributeNames = ["x", "y", "z"];
          attributeTypes = ["float", "float", "float"];
          break;
        case "scoreboard":
          attributeNames = ["x", "y", "z"];
          attributeTypes = ["float", "float", "float"];
          break;
        default:
          // TODO warning
          continue;
      }

      let success = true;
      let global = [];
      for (let j = 0; j < attributeNames.length; ++j) {
        let type = attributeTypes[j];
        let name = attributeNames[j];
        let attr;
        if (type == "float") {
          attr = this.parseFloat(
            children[i],
            name,
            name + " in gameoption " + nodeName
          );

          if (typeof attr === "string" || attr instanceof String) {
            console.warn(attr + "Skipping this option.");
            success = false;
            break;
          }
        }
        global.push(attr);
      }
      if (!success) continue;

      switch (nodeName) {
        case "gameboard":
          this.boardPos = global;
          break;
        case "scoreboard":
          this.scorePos = global;
          break;
        default:
          break;
      }
    }
  }

  /**
   * Parses a float
   * @param {block element} node
   * @param {name of float} name
   * @param {message to be displayed in case of error} messageError
   * @param {default value to assume in case of error} defaultVal
   */
  parseFloat(node, name, messageError, defaultVal = null) {
    var f = this.reader.getFloat(node, name);
    if (f == null || isNaN(f)) {
      if (defaultVal != null) {
        this.onXMLMinorError(
          "unable to parse float component " +
            messageError +
            "; assuming 'value = " +
            defaultVal +
            "'"
        );
        f = defaultVal;
      } else {
        return "unable to parse float component " + messageError;
      }
    }

    return f;
  }

  /**
   * Parses an integer
   * @param {block element} node
   * @param {name of integer} name
   * @param {message to be displayed in case of error} messageError
   * @param {default value to assume in case of error} defaultVal
   */
  parseInteger(node, name, messageError, defaultVal = null) {
    var i = this.reader.getInteger(node, name);
    if (i == null || isNaN(i)) {
      if (defaultVal != null) {
        this.onXMLMinorError(
          "unable to parse integer component " +
            messageError +
            "; assuming 'value = " +
            defaultVal +
            "'"
        );
        i = defaultVal;
      } else {
        return "unable to parse integer component " + messageError;
      }
    }

    return i;
  }

  /**
   * Parses a boolean
   * @param {block element} node
   * @param {name of boolean} name
   * @param {message to be displayed in case of error} messageError
   */
  parseBoolean(node, name, messageError) {
    var boolVal = true;
    boolVal = this.reader.getBoolean(node, name);
    if (
      !(
        boolVal != null &&
        !isNaN(boolVal) &&
        (boolVal == true || boolVal == false)
      )
    ) {
      this.onXMLMinorError(
        "unable to parse value component " +
          messageError +
          "; assuming 'value = 1'"
      );
      boolVal = true;
    }

    return boolVal;
  }

  /**
   * Parse the coordinates from a node with ID = id
   * @param {block element} node
   * @param {message to be displayed in case of error} messageError
   */
  parseCoordinates3D(node, messageError) {
    var position = [];

    // x
    let x = this.reader.getFloat(node, "x");
    if (!(x != null && !isNaN(x)))
      return "unable to parse x-coordinate of the " + messageError;

    // y
    let y = this.reader.getFloat(node, "y");
    if (!(y != null && !isNaN(y)))
      return "unable to parse y-coordinate of the " + messageError;

    // z
    let z = this.reader.getFloat(node, "z");
    if (!(z != null && !isNaN(z)))
      return "unable to parse z-coordinate of the " + messageError;

    position.push(...[x, y, z]);

    return position;
  }

  parseCoordinates3DScale(node, messageError, defaultVal = null) {
    var position = [];

    // x
    var x = this.parseFloat(node, "sx", "sx of " + messageError, defaultVal);
    if (!(x != null && !isNaN(x))) return x;

    // y
    var y = this.parseFloat(node, "sy", "sy of " + messageError, defaultVal);
    if (!(y != null && !isNaN(y))) return y;

    // z
    var z = this.parseFloat(node, "sz", "sz of " + messageError, defaultVal);
    if (!(z != null && !isNaN(z))) return z;

    position.push(...[x, y, z]);

    return position;
  }

  /**
   * Parse the coordinates from a node with ID = id
   * @param {block element} node
   * @param {message to be displayed in case of error} messageError
   */
  parseCoordinates4D(node, messageError) {
    var position = [];

    //Get x, y, z
    position = this.parseCoordinates3D(node, messageError);

    if (!Array.isArray(position)) return position;

    // w
    var w = this.reader.getFloat(node, "w");
    if (!(w != null && !isNaN(w)))
      return "unable to parse w-coordinate of the " + messageError;

    position.push(w);

    return position;
  }

  /**
   * Parse the color components from a node
   * @param {block element} node
   * @param {message to be displayed in case of error} messageError
   */
  parseColor(node, messageError) {
    var color = [];

    // R
    var r = this.reader.getFloat(node, "r");
    if (!(r != null && !isNaN(r) && r >= 0 && r <= 1))
      return "unable to parse R component of the " + messageError;

    // G
    var g = this.reader.getFloat(node, "g");
    if (!(g != null && !isNaN(g) && g >= 0 && g <= 1))
      return "unable to parse G component of the " + messageError;

    // B
    var b = this.reader.getFloat(node, "b");
    if (!(b != null && !isNaN(b) && b >= 0 && b <= 1))
      return "unable to parse B component of the " + messageError;

    // A
    var a = this.reader.getFloat(node, "a");
    if (!(a != null && !isNaN(a) && a >= 0 && a <= 1))
      return "unable to parse A component of the " + messageError;

    color.push(...[r, g, b, a]);

    return color;
  }

  /**
   * Toggles objects' normals
   */
  toggleObjectNormals(isEnabled) {
    for (var key in this.nodes) {
      var node = this.nodes[key];
      if (isEnabled) node.enableNormalViz();
      else node.disableNormalViz();
    }
  }

  resetAnims() {
    this.updatables.forEach((updatable) => {
      updatable.reset();
    });
  }

  update(t) {
    this.updatables.forEach((updatable) => {
      updatable.update(t);
    });
  }

  /**
   * Displays the scene, processing each node, starting in the root node.
   */
  display() {
    this.nodes[this.idRoot].display();
  }
}

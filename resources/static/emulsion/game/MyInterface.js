/**
 * MyInterface class, creating a GUI interface.
 */
class MyInterface extends CGFinterface {
  /**
   * @constructor
   */
  constructor() {
    super();
    this.lightsDir = null;
    this.cameras = null;
  }

  /**
   * Initializes the interface.
   * @param {CGFapplication} application
   */
  init(application) {
    super.init(application);
    // init GUI. For more information on the methods, check:
    //  http://workshop.chromeexperiments.com/examples/gui

    this.gui = new dat.GUI();

    // add a group of controls (and open/expand by defult)

    this.initKeys();

    return true;
  }

  updateGUI() {
    // lights button
    if (this.lightsDir) this.gui.removeFolder(this.lightsDir);

    this.lightsDir = this.gui.addFolder("Lights");
    let i = 0;
    for (let key in this.scene.graph.lights) {
      if (i >= 8) break; // Only eight lights allowed by WebCGF on default shaders.

      let graphLight = this.scene.graph.lights[key];
      this.lightsDir.add(this.scene, "xmlLight" + i).name(graphLight[5]);
      ++i;
    }

    // camera list
    if (this.cameras) this.gui.remove(this.cameras);

    this.cameras = this.gui
      .add(this.scene, "selectedCamera", this.scene.cameraList)
      .name("Selected camera")
      .onChange(this.scene.animSwitchCamera.bind(this.scene));
  }

  instGuiButtons() {
    // camera related buttons show be kept here in case the user
    // loses track of the screen
    this.gui.add(this.scene, "resetCamera");

    // game buttons
    let gameDir = this.gui.addFolder("Game");
    gameDir.open();
    // scene list
    gameDir
      .add(this.scene, "selectedGraph", this.scene.graphNames)
      .name("Selected theme")
      .onChange(this.scene.updateSelectedGraph.bind(this.scene));
    // board size
    gameDir
      .add(this.scene.gameOrchestrator, "boardSize")
      .name("Board size")
      .min(1);

    // debug buttons
    let debugDir = this.gui.addFolder("Debug");
    // toggle to show object normals
    debugDir
      .add(this.scene.gameOrchestrator, "showNormals")
      .name("Show normals")
      .onChange(this.scene.gameOrchestrator.updateNormalViz.bind(this.scene.gameOrchestrator));
    // toggle to show lights as objects
    debugDir.add(this.scene, "areLightsVisible").name("Show lights");
  }

  /**
   * initKeys
   */
  initKeys() {
    this.scene.gui = this;
    this.processKeyboard = function () {};
    this.activeKeys = {};
  }

  processKeyDown(event) {
    this.activeKeys[event.code] = true;
  }

  processKeyUp(event) {
    this.activeKeys[event.code] = false;
  }

  isKeyPressed(keyCode) {
    return this.activeKeys[keyCode] || false;
  }
}

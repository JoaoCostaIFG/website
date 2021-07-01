//From https://github.com/EvanHahn/ScriptInclude
include=function(){function f(){var a=this.readyState;(!a||/ded|te/.test(a))&&(c--,!c&&e&&d())}var a=arguments,b=document,c=a.length,d=a[c-1],e=d.call;e&&c--;for(var g,h=0;c>h;h++)g=b.createElement("script"),g.src=arguments[h],g.async=!0,g.onload=g.onerror=g.onreadystatechange=f,(b.head||b.getElementsByTagName("head")[0]).appendChild(g)};
serialInclude=function(a){var b=console,c=serialInclude.l;if(a.length>0)c.splice(0,0,a);else b.log("Done!");if(c.length>0){if(c[0].length>1){var d=c[0].splice(0,1);b.log("Loading "+d+"...");include(d,function(){serialInclude([]);});}else{var e=c[0][0];c.splice(0,1);e.call();};}else b.log("Finished.");};serialInclude.l=new Array();

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi,    
    function(m,key,value) {
      vars[decodeURIComponent(key)] = decodeURIComponent(value);
    });
    return vars;
}	 
//Include additional files here
serialInclude(['../lib/CGF.js', 'XMLscene.js', 'MyNode.js', 'MySceneGraph.js', 'MyInterface.js', './Primitives/MyCylinder.js',
'./Primitives/MyRectangle.js', './Primitives/MyTriangle.js', './Primitives/MySphere.js', './Primitives/MyTorus.js',
'./Primitives/Plane.js', './Primitives/Patch.js', './Primitives/Defbarrel.js', './Cameras/MyCGFcamera.js',
'./Cameras/MyCGFcameraOrtho.js', './Animations/Animation.js', './Animations/Keyframe.js', './Animations/KeyframeAnimation.js',
'./Animations/MySpriteAnimation.js', './Spritesheets/MySpriteText.js', './Spritesheets/MySpritesheet.js',
'./Primitives/MyTile.js', './Primitives/MyCube.js', './Primitives/MyPiece.js', './Primitives/MyGameBoard.js',
'MyGameMove.js', 'MyGameSequence.js', 'MyGameOrchestrator.js', 'MyAnimator.js', './Primitives/MyBorder.js',
'prolog/MyPrologInterface.js', 'Animations/MovePieceAnimation.js', 'MyScoreBoard.js',
'./Primitives/MyInsignia.js', './Primitives/MyBlackInsignia.js', './Primitives/MyWhiteInsignia.js',
'./Primitives/buttons/MyButton.js', './Primitives/buttons/MyCheckboxButton.js', './Primitives/buttons/MyComboButton.js',
main=function()
{
	// Standard application, scene and interface setup
    var app = new CGFapplication(document.body);
    var myInterface = new MyInterface();
    var myScene = new XMLscene(myInterface);

    app.init();

    app.setScene(myScene);
    app.setInterface(myInterface);

    // myInterface.setActiveCamera(myScene.camera);

	  // get file name provided in URL, e.g. http://localhost/myproj/?file=myfile.xml 
	  // or use "demo.xml" as default (assumes files in subfolder "scenes", check MySceneGraph constructor) 
	
    var spaceFile=getUrlVars()['file'] || "space.xml";
    var poolFile=getUrlVars()['file2'] || "pool.xml";

	  // create and load graph, and associate it to scene. 
	  // Check console for loading errors
    var spaceGraph = new MySceneGraph(spaceFile, myScene);
    var poolGraph = new MySceneGraph(poolFile, myScene);
    var orchestrator = new MyGameOrchestrator(myScene);
	
	  // start
    app.run();
}

]);

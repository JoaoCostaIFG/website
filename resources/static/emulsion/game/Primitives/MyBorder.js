class MyBorder{
    constructor(scene, boardSize){
        this.scene = scene;
        this.cube = new MyCube(scene, 0.5);
        this.len = boardSize * MyPiece.size + MyPiece.size/4;
        this.height = MyPiece.size;
    }

    display(){
        this.scene.pushMatrix();
        this.scene.scale(1,this.height, this.len);
        this.cube.display();
        this.scene.popMatrix();
    }

}

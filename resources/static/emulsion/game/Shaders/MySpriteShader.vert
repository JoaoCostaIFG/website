attribute vec3 aVertexPosition;
attribute vec3 aVertexNormal;
attribute vec2 aTextureCoord;

uniform mat4 uMVMatrix;
uniform mat4 uPMatrix;
uniform mat4 uNMatrix;

varying vec2 vTextureCoord;

uniform vec2 sheetSize;
uniform vec2 charCoords;

void main() {
  vTextureCoord = aTextureCoord;

  vTextureCoord.x += charCoords.x;
  vTextureCoord.y += charCoords.y;
  vTextureCoord.x /= sheetSize.x;
  vTextureCoord.y /= sheetSize.y;

  gl_Position = uPMatrix * uMVMatrix * vec4(aVertexPosition, 1.0);
}


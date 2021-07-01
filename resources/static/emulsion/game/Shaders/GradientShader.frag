#ifdef GL_ES
precision highp float;
#endif

varying vec2 vTextureCoord;

uniform sampler2D uSampler;

uniform float perc;

void main() {
  vec4 color;
  // color = vec4(0.8 - (0.6 * perc),  0.3 * perc, 0.9 * perc, 1.0);
  // #77a1d3, #79cbca, #e684ae
  if ((perc - 0.5) <= 0.000001) {
    float perc2 = perc * 2.0;
    color = vec4(0.47, 0.63 + 0.17 * perc2, 0.83 - 0.04 * perc2, 1.0);
  }
  else {
    float perc2 = (perc - 0.5) * 2.0;
    color = vec4(0.47 + 0.43 * perc2, 0.80 - 0.28 * perc2, 0.79 - 0.11 * perc2, 1.0);
  }

  gl_FragColor = color;
}

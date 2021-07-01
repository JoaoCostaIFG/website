#ifdef GL_ES
precision highp float;
#endif

varying vec2 vTextureCoord;

uniform sampler2D uSampler;

void main() {
	vec4 color = texture2D(uSampler, vTextureCoord);

  if (color.a <= 0.1) {
    discard;
  }

	gl_FragColor = color;
}

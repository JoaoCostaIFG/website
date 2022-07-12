<?php layout_header('About'); ?>

<h2>Hello c|:D</h2>

<div class="row">
  <div class="four columns">
    <img src="<?= img('pfp.jpg') ?>" alt="Me" class="u-full-width">
    <p>
      (This is the profile picture I usually use online. It was generated using
      my <a href="https://gitlab.com/JoaoCostaIFG/allrgb">AllRGB program</a>.)
    </p>
  </div>
  <div class="eight columns">
    <p>
      I'm a twenty-something year old computer engineering student at the
      <a href="https://fe.up.pt">Faculty of Engineering of the University of Porto</a>
      and this is my personal website.<br>
      I started this website so I could learn more about web development and have
      a place to share my experiences/thoughts (mostly) relating to informatics. This
      website passed through multiple changes and is now hosted on my personal home-server
      (alongside other self-hosted services I use).
    </p>
    <p>
      As part of both my academic, work, and personal experience, I've had the
      opportunity to deal with numerous programming languages. As of writing, my
      favorites are: <b>Bash/POSIX shell</b>, <b>C</b>, <b>C++</b>, <b>Java</b>,
      <b>Python3</b>, and <b>Zig</b>.
    </p>
    <p>
      In my free time, I enjoy working on personal projects, listening to music,
      playing games, and reading. Many of my personal projects revolve around
      customizing my Linux machines, be it the personal ones or the servers
      <i>(I use Arch BTW)</i>.
    </p>
    <p>
      I enjoy contributing to open-source software and always try to release mine
      with open licenses (often the MIT license). Generally speaking, I don't like
      social media, so I try to stay as far away from it as possible (which isn't
      always possible). The best/fastest way to contact me is through email at:
      <a href="mailto:joaocosta.work@posteo.net">joaocosta.work@posteo.net</a>
    </p>
    <p>
      You can find my CV <a href="<?= route('cv_route') ?>">here</a>.
    </p>
  </div>
</div>

<?php layout_footer(); ?>

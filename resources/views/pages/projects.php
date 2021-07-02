<?php
$title="Projects";
require_once '../templates/tpl_header.php';
?>

<h2>Projects</h2>
<p>
  The following are some projects I've created/worked on that I feel proud of.
</p>

<h3>
  <a href="https://joaocosta.dev/static/emulsion/game">Emulsion</a>
</h3>
<p>
  This is the
  <a href="https://boardgamegeek.com/boardgame/311851/emulsion"
    >Emulsion board game</a
  >
  written in javascript (front-end) and prolog (back-end). You can find more
  information on its
  <a href="https://gitlab.com/JoaoCostaIFG/LAIG/-/tree/master/TP3">repository</a
  > and play it on my site from the header link.
</p>

<h3>
  <a href="https://github.com/JoaoCostaIFG/mycroft-youtubedl-skill"
    >Mycroft-youtubedl Skill</a
  >
</h3>
<p>
  This a <b>skill</b> for the
  <b><a href="https://mycroft.ai/">mycroft A.I. assistant</a></b
  >. It allows the user to search for an youtube video, download it and then add
  it to the play queue.<br />
  Additionally, this skill also allows the user to skip a currently playing
  video, clear the play queue, and query the name of the currently playing
  song.<br />
  It was designed to be a free alternative to the <b>spotify</b> and
  <b>pandora</b> mycroft skills.
</p>

<h3>
  <a href="https://github.com/JoaoCostaIFG/pbg">PBG</a>
</h3>
<p>
  This is primarily a
  <a href="https://wiki.archlinux.org/index.php/Pacman">Pacman</a> hook to save
  both <a href="https://www.archlinux.org/packages">Pacman native</a> and
  <a href="https://aur.archlinux.org">AUR</a> packages in github gists. The
  alternatives I found online didn't have all the functions I wanted/needed, so
  I decided to create my own solution.<br />
  <b>PBG</b> can do the following:
</p>
<ul>
  <li>
    List the information saved in each of the 2 gists (one for native packages
    and the other for AUR packages) in similar fashion to the
    <code>pacman -Qqem</code>, <code>pacman -Qqen</code> and
    <code>pacman -Qqe</code> commands.
  </li>
  <li>
    Sync your machine with the information currently saved in the gists by
    automatically installing/removing packages (this currently only supports
    pacman <i>native</i> packages because I don't know how to make a
    <i>good and general</i> implementation that works on the most common AUR
    helpers).
  </li>
  <li>
    You have the option to provide an access token with gist permissions if you
    want or you can have the access token created for you by inputting your
    github credentials (they aren't saved anywhere and are only use to create
    the said token).
  </li>
</ul>

<h3>
  <a href="https://github.com/JoaoCostaIFG/dotfiles"
    >Dotfiles/General Usage Scripts</a
  >
</h3>
<p>
  This repository contains my public <i>dotfiles</i> and some of the scripts
  that are added to my <b>PATH</b>.<br />
  Of these scripts, the following are the ones I consider the most important
  (<b>note</b>: many of the scripts I've written depend on suckless's
  <a href="https://tools.suckless.org/dmenu/">dmenu</a>):
</p>
<ul>
  <li>
    <b>dmount</b> - helpful tool to mount external devices/Android phones. It
    might not work for all kinds of Android phones (<b>check</b>:
    <a href="https://wiki.archlinux.org/index.php/Android#Transferring_files"
      >Arch wiki android</a
    >.
  </li>
  <li>
    <b>dtodo</b> - tool I use to take quick notes and keep track of information.
    It can handle multiple files, organize lines alphabetically, get rid of
    blank/empty lines and open <i>urls</i> in your default browser.
  </li>
  <li>
    <b>maim_handler</b> - script that can: take full-screen screen-shots (saves
    them in a previously specified folder), screen-shot a selection of the
    screen (places the image in the clipboard), output color information of a
    selection (saves RGB color code in clipboard and show a notification for it
    too). Depends on <a href="https://github.com/naelstrof/maim">maim</a>.
  </li>

  <li>
    <b>mdmenu_run</b> - This dmenu wrapper is a replacement for the default
    <b>dmenu_run</b> script. It uses a cache file to show the most used
    commands/applications (called through dmenu) first, it runs command in a new
    terminal window if <b>';'</b> is appended to the command and it has options
    to list and browse directories/files and <code>cd</code> to their location
    using the default file manager.
  </li>

  <li>
    <b>mmaxima</b> - wrapper script for
    <a href="http://maxima.sourceforge.net/">maxima </a>. It uses
    <b>rlwrap</b> for history and a file containing all the
    <i>built-in</i> funtions for completion. It is similar in idea to the
    <b>rmaxima</b>
    script but it has a few improvements.
  </li>

  <li>
    <b>skane</b> - a Snake clone I made (and have been slightly
    modifying/improving over time) as a final project for a Linux terminal
    workflow/bash scripting school class. It has a lot of "bashisms" so it needs
    to be run on bash. Sometimes I just call it on a terminal when I'm feeling
    nostalgic.
  </li>
</ul>

<h3>
  <a href="https://github.com/JoaoCostaIFG/LCOM">Skane, Royale Edition</a>
</h3>
<p>
  A game developed in C as the final project for a low-level I/O device
  programming university class. Details of the class can be found here:
  <a
    href="https://sigarra.up.pt/feup/en/UCURR_GERAL.FICHA_UC_VIEW?pv_ocorrencia_id=436435"
    >LCOM FEUP</a
  ><br />
  The game is highly configurable and has both a <b>singleplayer</b> and a
  <b>multiplayer</b> modes.<br />
  <br />
  In the <b>singleplayer</b> mode, you play as a snake and must face
  increasingly difficult waves of enemies, that will try to kill you, by
  shooting them. When you shoot and/or get damaged by enemies, you shrink in
  size. When enemies die, they drop strawberries that you can eat to grow
  larger. You die when you get damaged and are too small to handle that amount
  of damage.<br />
  <br />
  In the <b>multiplayer</b> mode, you can play against a friend in a different
  computer (connect through a serial port). The game mechanics remain mostly the
  same, with the exception that enemy scaling has been removed. To win, you must
  kill the other player (or wait for him to die to his enemies), by
  shooting/colliding with him. This game mode can also be played like a co-op
  survival game with friendly fire on (it can be disabled).
</p>

<h3>
  <a href="https://github.com/JoaoCostaIFG/Workshop-Introduction-Python-3"
    >Workshop: Introduction to Python 3</a
  >
</h3>
<p>
  This workshop, its coding exercises, wiki, and presentation slides were
  created and lectured by me and two of my friends (details and names in
  repository) in association with the University of Porto IEEE student branch
  (which we are members of).<br />
  It was a 3 hour introduction to <b>Python 3</b> for people with little to no
  programming experience that covered the following topics:
</p>
<ul>
  <li>Interpreter.</li>
  <li>Variables.</li>
  <li>Data Types.</li>
  <li>Flow Control.</li>
  <li>Data Structures.</li>
  <li>Iteration.</li>
  <li>Functions.</li>
  <li>Lambda Functions.</li>
  <li>Comprehensions and Generators.</li>
  <li>Creation/Usage of modules.</li>
</ul>

<?php
require_once '../templates/tpl_footer.php';
?>

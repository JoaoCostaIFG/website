---
title: "Projects"
date: 2020-01-30T18:08:07Z
categories: [projects]
description: "List of some nice projects I've created/worked on."
author: "JoaoCostaIFG"
---

## [Mycroft-youtubedl Skill](https://github.com/JoaoCostaIFG/mycroft-youtubedl-skill)

This a **skill** for the **[mycroft](https://mycroft.ai/) A.I. assistant**. It allows
the user to search for an youtube video, download it and then add it to the play
queue.  
This skill also allows the user to skip a currently playing video, clear the play
queue, and querry the name of the current song.  
It was designed to be a free alternative to the **spotify** and **pandora** mycroft
skills.

## [PBG](https://github.com/JoaoCostaIFG/pbg)

This is primarily a [Pacman](https://wiki.archlinux.org/index.php/Pacman) hook to
save both [Pacman native](https://www.archlinux.org/packages/) and
[AUR](https://aur.archlinux.org/) packages in github gists.  
The alternatives I found online didn't have all the functions I wanted/needed so
I decided to create my own solution. **PBG** also has the following functions:

- List the information saved in each of the 2 gists (one for native packages and
  the other for AUR packages) in similar fashion to the `pacman -Qqem`,
  `pacman -Qqen` and `pacman -Qqe` commands;

- Sync your machine with the information currently saved in the gists by automatically
  installing/uninstalling packages (this currently only supports pacman _native_ packages
  because I don't know how to make a _good and general_ implementation of most AUR
  helpers);

- You have the option to provide an access token with gist permissions if you want
  or you can have the access token created for you by inputting your github credentials
  (they aren't saved anywhere and are only use to create the said token).

## [Dotfiles/General Usage Scripts](https://github.com/JoaoCostaIFG/dotfiles)

This repository contains my public dotfiles and the scripts that are added to
my **PATH**.  
Of these scripts, the most important that I developed are:

- **dmount** - helpful tool to mount external devices/Android phones. It might
  not work for all kinds of Android phones (check:
  [Arch wiki android](https://wiki.archlinux.org/index.php/Android#Transferring_files)).  
  Depends on suckless's [dmenu](https://tools.suckless.org/dmenu/);

- **dtodo** - tool I use to take quick notes and keep track of information.
  It can handle multiple files, organize lines alphabetically, get rid of blank/empty
  lines.  
  Depends on suckless's [dmenu](https://tools.suckless.org/dmenu/);

- **maim_handler** - script that can: take full-screen screen-shots (saves them in
  a previously specified folder), screen-shot a selection of the screen (places the
  image in the clipboard), output color information of a selection (saves RGB color
  code in clipboard and show a notification for it too).  
  Depends on [maim](https://github.com/naelstrof/maim);

- **mdmenu_run** - This dmenu wrapper is a replacement for the default
  **dmenu_run**: uses a cache file and sorts it by number of usages (has max entries
  for cache file); runs command in a new terminal window if **';'** is appended to
  a command; has option to list and browse files (cd's to them using file manager);
  also lists directories up to a certain depth and cd's to them if selected.  
  Depends on suckless's [dmenu](https://tools.suckless.org/dmenu/);

- **mmaxima** - script that calls maxima on a terminal. It uses **rlwrap**
  for history and built-ins file (and getline). It is based on **rmaxima**
  but it has a few improvements.  
  Depends on [maxima](http://maxima.sourceforge.net/);

- **skane** - a Snake clone I made (and have been slightly modifing/improving
  over time) as a final project for a linux terminal workflow/bash scripting
  school class. It has a lot of "bashisms" so it needs to be run on bash.
  Sometimes I just call it on a terminal to kill time.

## [Skane, Royale Edition](https://github.com/JoaoCostaIFG/LCOM)

A game developed in C as the final project for a low-level I/O device programming
university class. Details of the class can be found here:
[LCOM FEUP](https://sigarra.up.pt/feup/en/UCURR_GERAL.FICHA_UC_VIEW?pv_ocorrencia_id=436435).

The game is highly configurable and has a both a **singleplayer** and a **multiplayer**
modes.

In the **singleplayer** mode, you play as a snake and must face increasingly difficult
waves of enemies, that will try to kill you, by shooting them. The more you shoot,
the smaller you become. When enemies die, they drop strawberries that you can eat
to increase your size. You die when you get damaged if only your head remains
(minimum size).

In the **multiplayer** mode, you play against a friend in a different computer
(connect through a serial port). The game mechanics remain mostly the same, with
the exception that enemy scaling has been removed. To win, you must kill the other
player (or wait for him to die to his enemies), by shooting/colliding with him.

## [Workshop: Introduction to Python 3](https://github.com/JoaoCostaIFG/Workshop-Introduction-Python-3)

This workshop, its coding exercises, wiki, and presentation slides were created
and lectured by me and two of my friends (details and names in repository) in association
with the IEEE's University of Porto student branch (which we are members of).  
It was a 3 hour introduction to **Python 3** for people with little to no programming
experience that covered the following topics:

- Interpreter;
- Variables;
- Data Types;
- Flow Control;
- Data Structures;
- Iteration;
- Functions;
- Lambda Functions;
- Comprehensions and Generators;
- Modules.

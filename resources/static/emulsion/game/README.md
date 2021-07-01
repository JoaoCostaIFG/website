# LAIG 2020/2021 - TP3

## Group T03-G05

| Name                        | Number    | E-Mail               |
| --------------------------- | --------- | -------------------- |
| Ana Inês Oliveira de Barros | 201806593 | up201806593@fe.up.pt |
| João de Jesus Costa         | 201806560 | up201806560@fe.up.pt |

---

## Project information

### Scenes 1 - Space

- A skybox depicting space with stars.
- A table that holds the game board.
- Two chairs with a floating animation.

### Scene 2 - Pool

- A skybox depicting a house's backyard with a pool.
- A table with two beach chairs next to it.
- A melting ice-cream on top of the table.
- A floater next to the pool.

### Game play

- A gameboard with detailed game pieces and configurable size.
- Available moves are highlighted (the player can still attempt
  to make an invalid move).
- Selected pieces are highlighted.
- Scoreboard shows current turn time and current players' scores.
- Last games' scores history shown next to the scoreboard.
- Some GUI options are pickable objects, e.g.: New Game, Undo, Difficulty Selection...
- Combo-boxes and checkboxes change color dynamically on click (shader).
- Camera switching animation: interpolation between all camera parameters of
  two cameras, using and _ease-in ease-out_ function.
- Camera reset button.
- Toggles for each scene lights.
- Scenes are loaded at the beginning of the program and reset on change.
- All animations have a reset method (used for scene changes).
- A game move is animated in three phases using ["easings"](https://easings.net/)
  functions.
- The game difficulty is configurable. This changes the amount of time available
  to the player on each turn (running out of time loses the game).
- The game mode is configurable. The available modes are: player vs. player,
  computer vs. player, player vs. computer, and computer vs. computer.
- Every game move can be undone (even in the middle of an animation).
- The game movie (replay of all the game moves) can be started/stopped anytime
  during or after gameplay.
- The game movie animates all the moves since the start of the current game sequentially.
  Stopping the game movie goes back to the gameplay (if the game hasn't ended yet).
- A new game can be started anytime with changed options (game restarts aren't
  saved in the history).

### New primitives

- MyCube (a simple cube with configurable size).
- MyGameboard (the gameboard).
- MyTile (a gameboard's tile).
- MyPiece (a game piece).
- MyBlackInsignia (the symbol present on black game pieces).
- MyWhiteInsignia (the symbol present on white game pieces).

### XML

- Scenes can have a name inside the initials block.
- There is a new block called gameoptions.
- Tags for defining the gameboard and the scoreboard positions
  in the scene (inside the gameoptions).
- New cube primitive.

### Extras

- Extra interface controls for better debugging: show/hide vertexes' normals
  and show/hide light objects.
- Cameras reset to initial position upon switching between them.
- Default texture that is applied when an object references an undefined texture.
- Sprite sheets (including text) can have transparent parts.
- Spritetexts have character spacing options.
- Spritetexts can be displayed vertically.

---

## Issues/Problems

- The prolog server implementation doesn't make use of threads. This means that,
  even if we cancel a request (e.g.: we don't want the AI to make a move anymore),
  the server will still process the request before answering to new requests.

- There is no interpolation between the FOV of perspective cameras and the left,
  right, bottom, top values of ortho cameras during animations.

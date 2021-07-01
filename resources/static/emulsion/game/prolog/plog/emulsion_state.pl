%%%%%%%%%%%%%%%%%%%%
% GAMESTATE OBJECT %
%%%%%%%%%%%%%%%%%%%%

make_state(GameSettings, Board, Player, gameState(GameSettings, Length, Board, Player)) :-
  length(Board, Length).

state_getSettings(gameState(GameSettings, _, _, _), GameSettings).
state_getPXSettings(gameState([Settings, _], _, _, _), 0, Settings).
state_getPXSettings(gameState([_, Settings], _, _, _), 1, Settings).
state_setSettings(GameSettings, gameState(_, Length, Board, Player), gameState(GameSettings, Length, Board, Player)).

state_getLength(gameState(_, Length, _, _), Length).
state_getBoard(gameState(_, _, Board, _), Board).
state_setBoard(Board, gameState(GameSettings, _, _, Player), gameState(GameSettings, Length, Board, Player)) :-
  length(Board, Length).

state_getPlayer(gameState(_, _, _, Player), Player).
next_player(Player, NextPlayer) :-
  NextPlayer is mod(Player + 1, 2).
state_nextPlayer(gameState(GameSettings, Length, Board, Player), NextPlayer,
  gameState(GameSettings, Length, Board, NextPlayer)) :-
  next_player(Player, NextPlayer).

state_insideBounds(gameState(_, Length, _, _), [X, Y]) :-
  X >= 0, X < Length,
  Y >= 0, Y < Length.
state_nth0Board(gameState(_, _, Board, _), [X, Y], Ret) :-
  nth0_matrix(X, Y, Board, Ret).

% Get initial state with 8x8 board (checkered)
initial(GameState) :-
  genInitBoard(Board, 9), % N is 9 - 1 = 8
  InitialPlayer is 0,
  make_state([], Board, InitialPlayer, GameState).


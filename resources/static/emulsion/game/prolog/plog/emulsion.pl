%%%%%%%%%%%%
% EMULSION %
%%%%%%%%%%%%

:-use_module(library(system)).
:-use_module(library(random)).

:-include('emulsion_ai.pl').
:-include('emulsion_board.pl').
:-include('emulsion_draw.pl').
:-include('emulsion_menu.pl').
:-include('emulsion_state.pl').

play :-
  menu(GameSettings),
  initial(InitialState1),
  state_setSettings(GameSettings, InitialState1, InitialState),
  state_getPlayer(InitialState, Player),
  game_loop(Player, InitialState),
  play. % loop the game until the user closes it

% The game's main loop
game_loop(Player, CurrentState) :-
  display_game(CurrentState, Player),
  game_over(CurrentState, _Winner).
game_loop(Player, CurrentState) :-
  repeat,
    state_getPXSettings(CurrentState, Player, Dif),
    once(choose_move(CurrentState, Player, Dif, Move)),
    move(CurrentState, Move, StateAfterMove),
  state_nextPlayer(StateAfterMove, NextPlayer, NextState), % change player
  game_loop(NextPlayer, NextState).

% GAME LOGIC %
% checks if the game is over (no more valid moves for the current player)
% and shows the winner
game_over(GameState, Winner) :-
  state_getPlayer(GameState, Player),
  \+valid_moves(GameState, Player, _),
  value(GameState, 0, VL0), value(GameState, 1, VL1),
  parseValueList(VL0, VL1, V0, V1, Winner),
  show_result(V0, V1, Winner, Player).

% MOVEMENT
% check if move is valid and execute it
move(GameState, Move, NewGameState) :-
  % this is a wrapper for the valid_move/3 predicate that offers more
  % user interation/friendliness.
  % check if P1 and P2 have different colors
  [P1, P2] = Move,
  state_nth0Board(GameState, P1, Color),
  \+state_nth0Board(GameState, P2, Color),
  % perform move
  valid_move(GameState, Move, NewGameState).
% in case of invalid move
move(_, _, _) :-
  write('Invalid move. Try again.'), nl, fail.

% check if a move is inside the game board and increased the value of
% the player piece
valid_move(GameState, [P1, P2], NewGameState) :-
  state_getBoard(GameState, CurrentBoard),
  once(switch_spots(CurrentBoard, [P1, P2] , NewBoard)),
  state_setBoard(NewBoard, GameState, NewGameState),
  piece_value(P1, GameState, CurrV),
  piece_value(P2, NewGameState, NewV),
  NewV > CurrV.

% does the same as valid_move, but also checks if the pieces being
% switched have different colors and below to the correct players
valid_move_full(GameState, Player, [P1, P2]) :-
  state_getLength(GameState, L),
  getValue(P1, _, L, Direcs),
  next_player(Player, NextPlayer),
  state_nth0Board(GameState, P1, Player), % check if P1 is player's color
  state_nth0Board(GameState, P2, NextPlayer), % check if P2 is enemy's color
  adjacent(P1, P2, Direcs),
  valid_move(GameState, [P1, P2], _).

% returns a list of all the valid moves for the given player on
% the given board
% ListOfMoves : [[X1, Y1], [X2, Y2]] Switch coord 1 with 2
valid_moves(GameState, Player, ListOfMoves) :-
  bagof(Move, valid_move_full(GameState, Player, Move), ListOfMoves).

% gets the next move from a Player or AI
% Player move
choose_move(GameState, Player, 0, Move) :-
  % X & Y
  nl, write('Select a spot of your color.'), nl,
  inputNum('X? ', X), inputNum('Y? ', Y),
  state_insideBounds(GameState, [X, Y]),
  state_nth0Board(GameState, [X, Y], Player), % check piece color
  % Direction
  input('Move direction [n, nw, w, sw, s, se, e, ne]? ', DirecSymb), nl,
  coordMove([X, Y], DirecSymb, [X1, Y1]),
  state_insideBounds(GameState, [X1, Y1]),
  Move = [[X, Y], [X1, Y1]].
% Easy AI
choose_move(GameState, Player, 1, Move) :-
  valid_moves(GameState, Player, Moves),
  ai_getBestMove(GameState, Player, Moves, 1, Move, _),
  ai_moveAnnounce('Easy', Move).
% Medium AI
choose_move(GameState, Player, 2, Move) :-
  valid_moves(GameState, Player, Moves),
  ai_getBestMove(GameState, Player, Moves, 2, Move, _),
  ai_moveAnnounce('Medium', Move).
% Hard AI
choose_move(GameState, Player, 3, Move) :-
  valid_moves(GameState, Player, Moves),
  ai_getBestMove(GameState, Player, Moves, 3, Move, _),
  ai_moveAnnounce('Hard (SCIENTIA)', Move).
% Random play AI
choose_move(GameState, Player, 4, Move) :-
  valid_moves(GameState, Player, Moves),
  length(Moves, L), random(0, L, RdmInd),
  nth0(RdmInd, Moves, Move),
  ai_moveAnnounce('Random move', Move).
% in case of invalid move (inputed by the user)
choose_move(_, _, _, _) :-
  write('Invalid spot. Try again.'), nl, fail.
  
% DIRECTIONS %
% direction(X,  Y,  DirecSymbol)
direction(0,    -1, 'n').
direction(-1,   -1, 'nw').
direction(-1,   0,  'w').
direction(-1,   1,  'sw').
direction(0,    1,  's').
direction(1,    1,  'se').
direction(1,    0,  'e').
direction(1,    -1, 'ne').

% get the next coordinate along a given direction
coordMove([X, Y], Direc, [Xn, Yn]) :-
  direction(X_inc, Y_inc, Direc),
  Xn is X + X_inc,
  Yn is Y + Y_inc.

% PIECES CONNECTIONS %
% returns the directions from which a connection can possibly
% be found from a given piece,
% e.g.: a piece on the top right corner ([0, 0]) can only be connected from south and/or east
% con_dir([X, Y], Last index, [Dirs])
con_dir([0, 0],   _,         ['s', 'e']).
con_dir([0, L],   L,         ['n', 'e']).
con_dir([L, 0],   L,         ['s', 'w']).
con_dir([L, L],   L,         ['n', 'w']).
con_dir([_, 0],   _,         ['s', 'e', 'w']).
con_dir([_, L],   L,         ['n', 'e', 'w']).
con_dir([0, _],   _,         ['e', 'n', 's']).
con_dir([L, _],   L,         ['w', 'n', 's']).
con_dir([_, _],   _,         ['n', 's', 'e', 'w']).

% checks if 2 pieces are next to each other
adjacent(P, P, _).
adjacent(P1, P2, Directions) :-
  member(Direction, Directions),
  coordMove(P1, Direction, P2).

% checks if 2 pieces are adjacent and of the same color
connected(P1, P2, State) :-
  state_getLength(State, L),
  state_insideBounds(State, P1),
  L1 is L - 1, con_dir(P1, L1, Direcs),
  adjacent(P1, P2, Direcs),
  state_insideBounds(State, P2),
  state_nth0Board(State, P1, Val),
  state_nth0Board(State, P2, Val).

% returns all pieces connected to the Start piece (of the same color)
% recursively
get_all_adjacent(Start, Res, State) :-
  setof(Neighbour, connected(Start, Neighbour, State), Neighbours),
  get_all_adjacent(Neighbours, Res, State, [], _).
get_all_adjacent([], [], _State, Visited, Visited).
get_all_adjacent([Neighbour | Neighbours], Res, State, Visited, NVis) :-
  member(Neighbour, Visited),
  get_all_adjacent(Neighbours, Res, State, Visited, NVis).
get_all_adjacent([Neighbour | Neighbours], [Neighbour | Res], State, Vis, NVis) :-
  \+ member(Neighbour, Vis),
  append(Vis, [Neighbour], TmpVisited),
  setof(NewNeighbour, connected(Neighbour, NewNeighbour, State), NewNeighbours),
  get_all_adjacent(NewNeighbours, CurrRes, State, TmpVisited, CurrVisited),
  get_all_adjacent(Neighbours, NextRes, State, CurrVisited, NVis),
  append(CurrRes, NextRes, Res).

% returns a list with all groups of a given player.
% each group is a list of coordinates of pieces of the same color
% that are ortogonaly connected (recursively)
getAllGroups(_State, _Player, [], [], _Visited).
getAllGroups(State, Player, [G|Groups], [C|Coords], Visited) :-
  \+member(C, Visited),
  get_all_adjacent(C, G, State),
  append(Visited, G, NewVisited),
  getAllGroups(State, Player, Groups, Coords, NewVisited).
getAllGroups(State, Player, Groups, [_C|Coords], Visited) :- % pop C
  getAllGroups(State, Player, Groups, Coords, Visited).
getAllGroups(State, Player, Groups) :-
  bagof(C, state_nth0Board(State, C, Player), CoordList),
  getAllGroups(State, Player, Groups, CoordList, []).

% VALUES %
% Base value of a piece on a given board place
% the number of adjacent pieces needs to be added to this value
% getValue(+[X, Y],   -Value, +Last index, -[Dirs])
getValue([0,  0],     1,      _, ['s', 'e', 'se']).
getValue([0,  L],     1,      L, ['n', 'e', 'ne']).
getValue([L,  0],     1,      L, ['s', 'w', 'sw']).
getValue([L,  L],     1,      L, ['n', 'w', 'nw']).
getValue([X,  0],     0.5,    L, ['s', 'e', 'w', 'se', 'sw']) :- L1 is L - 1, between(1, L1, X).
getValue([X,  L],     0.5,    L, ['n', 'e', 'w', 'ne', 'nw']) :- L1 is L - 1, between(1, L1, X).
getValue([0,  Y],     0.5,    L, ['e', 'n', 's', 'ne', 'ne']) :- L1 is L - 1, between(1, L1, Y).
getValue([L,  Y],     0.5,    L, ['w', 'n', 's', 'nw', 'sw']) :- L1 is L - 1, between(1, L1, Y).
getValue([X,  Y],     0,      L, ['n', 's', 'e', 'w', 'ne', 'se', 'nw', 'sw']) :-
  L1 is L - 1, between(1, L1, X), between(1, L1, Y).

% returns the value of a piece (base value + number of ortogal neightbors)
piece_value([X, Y], State, V) :-
  setof(Neighbour, connected([X, Y], Neighbour, State), Neighbours),
  state_getLength(State, L), L1 is L - 1,
  getValue([X, Y], PieceVal, L1, _),
  length(Neighbours, NeighbNum), % Neighbours includes [X, Y] (do - 1)
  V is (NeighbNum - 1) + PieceVal.

% converts a list of groups to a list of values of each group
getAllGroupsValues(_, [], []).
getAllGroupsValues(State, [G|Groups], [R|Res]) :-
  length(G, R),
  getAllGroupsValues(State, Groups, Res).

% Returns sorted (desc.) list of the values of all groups
% of a given player
value(GameState, Player, Value) :-
  getAllGroups(GameState, Player, G), !,
  getAllGroupsValues(GameState, G, ListOfVals),
  sort(0, @>=, ListOfVals, Value).

% Receives 2 lists of group sizes (calculated by the value predicate)
% Returns the 2 final scores (one for each player)
% Winner will store a number representing the
% end  0 - Player 0 Wins; 1 - Player 1 Wins; result 2 - Tie;
parseValueList(VL0, VL1, Value0, Value1, Winner) :-
  parseValueListN(VL0, VL1, Value0, Value1, 0, 0),
  valueCmp(Value0, Value1, Winner).
parseValueListN([], [], Acc0, Acc1, Acc0, Acc1) :- !.
parseValueListN([], [V1|VL1], Value0, Value1, Acc, Acc) :-
  NewAcc1 is Acc + V1,
  parseValueListN([], VL1, Value0, Value1, Acc, NewAcc1).
parseValueListN([V0|VL0], [], Value0, Value1, Acc, Acc) :-
  NewAcc0 is Acc + V0,
  parseValueListN(VL0, [], Value0, Value1, NewAcc0, Acc).
parseValueListN([V0|VL0], [V1|VL1], Value0, Value1, Acc, Acc) :-
  NewAcc0 is Acc + V0,
  NewAcc1 is Acc + V1,
  parseValueListN(VL0, VL1, Value0, Value1, NewAcc0, NewAcc1).
parseValueListN(_, _, Acc0, Acc1, Acc0, Acc1) :- Acc0 \= Acc1.

% used to to choose the winner of the game
% returns 0, if V0 > V1
% returns 1, if V0 < V1
% returns 2, if V0 = V1
valueCmp(V0, V1, 0) :- V0 > V1.
valueCmp(V0, V1, 1) :- V0 < V1.
valueCmp(V0, V1, 2) :- V0 = V1.

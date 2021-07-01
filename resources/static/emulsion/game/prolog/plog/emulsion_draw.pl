%%%%%%%%%%%
% DRAWING %
%%%%%%%%%%%

% draws a given board/GameState on the console
display_game(GameState, Player) :-
  state_getBoard(GameState, Board),
  print_board(Board),
  display_player(Player),
  nl.

%
% BOARD %
%

print_topruler(Board) :-
  write('Y\\X'),
  print_topruler(Board, 0),
  nl.
print_topruler([], _).
print_topruler([_|B], CurrC) :-
  format('  ~d  ', [CurrC]),
  NewC is CurrC + 1,
  print_topruler(B, NewC).

print_board(Board) :- % first line has a top ruler
  print_topruler(Board),
  print_board(Board, 0).
print_board([], _).
print_board([L | B], CurrL) :-
  print_line(L, CurrL),
  NewL is CurrL + 1, % Y number on ruler
  print_board(B, NewL).

%   ┌───┐
% n │ W │
%   └───┘
print_line([], _).
print_line(L, CurrL) :-
  write('   '), print_line_top(L), nl,
  format(' ~d ', [CurrL]), print_line_center(L), nl,
  write('   '), print_line_bot(L), nl.

% prints the top of boxes (cels) of a given line
print_line_top([]).
print_line_top([C | L]) :-
  set_bg_color(C),
  set_fg_color(C),
  put_code(9484), put_code(9472), put_code(9472), put_code(9472), put_code(9488),
  reset_ansi,
  print_line_top(L).

% prints the bottom of boxes (cels) of a given line
print_line_bot([]).
print_line_bot([C | L]) :-
  set_bg_color(C),
  set_fg_color(C),
  put_code(9492), put_code(9472), put_code(9472), put_code(9472), put_code(9496),
  reset_ansi,
  print_line_bot(L).

% prints the center of the boxes (cells) and the cell content of a given line
print_line_center([]).
print_line_center([C | L]) :-
  print_cell(C),
  print_line_center(L).

% prints the 'center' of a cell
print_cell(C) :-
  cell_code(C, Code),
  set_bg_color(C), set_fg_color(C),
  put_code(9474), write('\33\[1m'), write(Code), write('\33\[22m'), put_code(9474),
  reset_ansi.

% RESULTS %
% helps sending the correct victory information to the show_result/3 predicate
show_result(V0, V1, 0, _) :- show_result(V0, V1, 0).
show_result(V0, V1, 1, _) :- show_result(V1, V0, 1).
show_result(V0, V1, 2, 0) :- show_result(V1, V0, 1).
show_result(V0, V1, 2, 1) :- show_result(V0, V1, 0).
% shows a small victory screen on the game ends
show_result(WinnerPoints, LoserPoints, Winner) :-
  nl,
  write('==============================================='), nl,
  write('=             The game has ended!             ='), nl,
  write('==============================================='), nl,
  write('= '),
  set_bg_color(Winner), set_fg_color(Winner),
  format('Player ~d', [Winner]), reset_ansi,
  format(' wins with ~d points vs. ~d points!', [WinnerPoints, LoserPoints]),
  nl, write('==============================================='), nl.

%
% PLAYER %
%

display_player(Player) :-
  nl,
  set_bg_color(Player), set_fg_color(Player),
  format('Player: ~d', [Player]),
  reset_ansi.

%
% HELPER %
%

cell_code(0, ' B ').
cell_code(1, ' W ').
cell_fg_color(0, '\33\[34m').
cell_fg_color(1, '\33\[31m').
cell_bg_color(0, '\33\[40m').
cell_bg_color(1, '\33\[47m').

% sets the terminal foreground color
set_fg_color(C) :-
  cell_fg_color(C, Color),
  write(Color).
% sets the terminal background color
set_bg_color(C) :-
  cell_bg_color(C, Color),
  write(Color).

% resets all ansi escapes
reset_ansi :- write('\33\[0m').

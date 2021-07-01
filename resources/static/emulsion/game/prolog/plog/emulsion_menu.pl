%%%%%%%%
% MENU %
%%%%%%%%

:-include('emulsion_input.pl').

menu(GameSettings) :-
  repeat,
    grettingsPanel,
    inputNum('Option: ', Op),
    nl, parseOp(Op, GameSettings).

title :-
  write('__        __   _                            _'), nl,
  write('\\ \\      / /__| | ___ ___  _ __ ___   ___  | |_ ___'), nl,
  write(' \\ \\ /\\ / / _ \\ |/ __/ _ \\| \'_ ` _ \\ / _ \\ | __/ _ \\'), nl,
  write('  \\ V  V /  __/ | (_| (_) | | | | | |  __/ | || (_) |'), nl,
  write('   \\_/\\_/ \\___|_|\\___\\___/|_| |_| |_|\\___|  \\__\\___/'), nl,
  nl,
  write(' _____                 _     _             _'), nl,
  write('| ____|_ __ ___  _   _| |___(_) ___  _ __ | |'), nl,
  write('|  _| | \'_ ` _ \\| | | | / __| |/ _ \\| \'_ \\| |'), nl,
  write('| |___| | | | | | |_| | \\__ \\ | (_) | | | |_|'), nl,
  write('|_____|_| |_| |_|\\__,_|_|___/_|\\___/|_| |_(_)'), nl.

grettingsPanel :-
  nl,
  title, nl,
  write('1 - PvP'), nl,
  write('2 - PvAI'), nl,
  write('3 - AIvP'), nl,
  write('4 - AIvAI'), nl,
  write('0 - Exit'), nl,
  nl.

% ret = [p1, p2]
% p == 0 => player
% p >= 1 => AI difficulty (1 -> easy, 2 -> medium, 3 -> hard, 4 -> random)
parseOp(1, [0, 0]).
parseOp(2, [0, Dif]) :- getDifficulty(Dif).
parseOp(3, [Dif, 0]) :- getDifficulty(Dif).
parseOp(4, [Dif1, Dif2]) :-
  write('Player 1 difficulty'), nl,
  getDifficulty(Dif1),
  write('Player 2 difficulty'), nl,
  getDifficulty(Dif2).
parseOp(0, _) :- halt(0).

getDifficulty(Difficulty) :-
  repeat,
    write('1 - Easy'), nl,
    write('2 - Medium'), nl,
    write('3 - Hard'), nl,
    write('4 - Random play'), nl,
    inputNum('Difficulty? ', Difficulty), nl,
    Difficulty >= 1, Difficulty =< 4.


%%%%%%%%%%%%%%%%%%%
% INPUT FUNCTIONS %
%%%%%%%%%%%%%%%%%%%

inputAll(10, []).
inputAll(13, []).
inputAll(Ch, [Ch | Mais]) :-
  get_code(Ch1),
  inputAll(Ch1, Mais).

% Using these predicates, the user doesn't need '' around his input
% or . at the end
input(Prompt, Input) :-
  prompt(_, Prompt),
  get_code(Ch),
  once(inputAll(Ch, TodosChars)), % without once it appends inside repeats
  name(Input, TodosChars).

inputNum(Prompt, Input) :-
  input(Prompt, Input),
  number(Input).

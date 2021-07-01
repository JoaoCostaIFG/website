%%%%%%%%%%%%%%%%
% AI FUNCTIONS %
%%%%%%%%%%%%%%%%

:-use_module(library(random)).

% show the move the AI will make to the player
ai_moveAnnounce(AILevel, [P1, P2]) :-
  nl,
  format('~w AI making move:', [AILevel]), nl,
  format(' - from: ~w', [P1]), nl,
  format(' - to: ~w', [P2]), nl,
  nl,
  sleep(2).

% choose the best move (more value) between 2 moves
ai_getBestMoveChoose(0, Move0, _, VL0, _, Move0, VL0).
ai_getBestMoveChoose(1, _, Move1, _, VL1, Move1, VL1).
ai_getBestMoveChoose(2, Move0, Move1, VL0, VL1, Move, VL) :-
  % if 2 choices with the same value come up, we choose a random one
  random(0, 2, Rdm),
  ai_getBestMoveChoose(Rdm, Move0, Move1, VL0, VL1, Move, VL).

% checks whether the AI (current player) or next player wins
% losing gives 0 value (forcing a losing play if it is the only one 0 > -1)
% winning gives infinite points (forcing a winning play)
ai_getBestMoveNoValidMoves(GameState, AI_Player, [Points]) :-
  next_player(AI_Player, NotAI_Player),
  value(GameState, AI_Player, VL0),
  value(GameState, NotAI_Player, VL1),
  parseValueList(VL0, VL1, _, _, Winner),
  ai_getBestMoveNoValidMovesPoints(GameState, Winner, Points).
ai_getBestMoveNoValidMovesPoints(_, 0, 0).
ai_getBestMoveNoValidMovesPoints(GameState, 1, MaxPoints) :-
  state_getLength(GameState, L), MaxPoints is L * L.

% calculate the best move for the AI to make given its color and the current game state
% the parameter value determines the depth of the move search tree
ai_getBestMove(_, _, [], _, _, [-1]).
% no need to check enemy moves on the last level
ai_getBestMove(GameState, Player, [Move|Moves], 1, BestMove, Val) :-
  valid_move(GameState, Move, NewGameState), % calculate state after move
  once(ai_getBestMove(GameState, Player, Moves, 1, Move1, VL1)), % check next move
  % evaluate and compare states, returning the best one
  value(NewGameState, Player, VL0),
  parseValueList(VL0, VL1, _, _, Winner),
  ai_getBestMoveChoose(Winner, Move, Move1, VL0, VL1, BestMove, Val).


ai_getBestMove(GameState, Player, [Move|Moves], Level, BestMove, Val) :-
  valid_move(GameState, Move, NewGameState), % calculate state after move
  % execute best move for enemy player (based on our move)
  next_player(Player, NPlayer),
  valid_moves(NewGameState, NPlayer, EnemyMoves),
  once(ai_getBestMove(NewGameState, NPlayer, EnemyMoves, 1, EMove, _)),
  % length(EnemyMoves, NumEnemyMoves), random(0, NumEnemyMoves, EMoveInd), nth0(EMoveInd, EnemyMoves, EMove),
  valid_move(NewGameState, EMove, EGameState),

  % evaluate next level (Level - 1)
  valid_moves(EGameState, Player, NewMoves), NextLevel is Level - 1, % can fail (see next predicate)
  once(ai_getBestMove(EGameState, Player, NewMoves, NextLevel, _, VL0)),

  % check next move, evaluating states and returning the best one
  once(ai_getBestMove(GameState, Player, Moves, Level, Move1, VL1)),
  parseValueList(VL0, VL1, _, _, Winner),
  ai_getBestMoveChoose(Winner, Move, Move1, VL0, VL1, BestMove, Val).

ai_getBestMove(GameState, Player, [Move|Moves], Level, BestMove, Val) :- % TODO
  valid_move(GameState, Move, NewGameState),
  % execute best move for enemy player (based on our move)
  next_player(Player, NPlayer),
  valid_moves(NewGameState, NPlayer, EnemyMoves), % can fail (see next predicate)
  once(ai_getBestMove(NewGameState, NPlayer, EnemyMoves, 1, EMove, _)),
  valid_move(NewGameState, EMove, EGameState),

  ai_getBestMoveNoValidMoves(EGameState, Player, VL0),
  once(ai_getBestMove(GameState, Player, Moves, Level, Move1, VL1)),
  parseValueList(VL0, VL1, _, _, Winner),
  ai_getBestMoveChoose(Winner, Move, Move1, VL0, VL1, BestMove, Val).
ai_getBestMove(GameState, Player, [Move|Moves], Level, BestMove, Val) :-
  valid_move(GameState, Move, NewGameState),
  ai_getBestMoveNoValidMoves(NewGameState, Player, VL0),

  once(ai_getBestMove(GameState, Player, Moves, Level, Move1, VL1)),
  parseValueList(VL0, VL1, _, _, Winner),
  ai_getBestMoveChoose(Winner, Move, Move1, VL0, VL1, BestMove, Val).

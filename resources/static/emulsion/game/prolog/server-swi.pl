:-use_module(library(socket)).
:-use_module(library(lists)).
:-use_module(library(codesio)).
:-use_module(library(readutil)).

%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%%%%                   Server                   %%%%
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

port(8081).
addr('0.0.0.0').

% Server Entry Point
server :-
  port(Port), addr(Addr),
  write('Opened Server'), nl, nl,
  tcp_socket(Socket),
  tcp_bind(Socket, Addr:Port),
  tcp_listen(Socket, 5),
  tcp_open_socket(Socket, AcceptFd, _),
  % server loop
  server_loop(AcceptFd),
  tcp_close_socket(Socket),
  write('Closed Server'), nl.

% Server Loop 
% Uncomment writes for more information on incomming connections
server_loop(AcceptFd) :-
  repeat,
    tcp_accept(AcceptFd, Socket, Peer),
    thread_create(process_client(Socket, Peer), _ ,
                  [ detached(true)
                  ]),
    fail.

process_client(Socket, Peer) :-
  setup_call_cleanup(
    tcp_open_socket(Socket, StreamPair),
    handle_service(StreamPair),
    close(StreamPair)).

handle_service(StreamPair) :-
  stream_pair(StreamPair, InStream, OutStream),
  % read and parse request
  read_request(InStream, Request),
  % handle request and write response
  handle_request(Request, Reply, Status),
  format(OutStream, 'HTTP/1.1 ~w~n', [Status]),
  format(OutStream, 'Content-Type: text/plain~n', []),
  format(OutStream, 'Access-Control-Allow-Origin: *~n~n', []),
  format(OutStream, '~w', [Reply]),
  flush_output(OutStream).

read_request(InStream, Request) :-
  read_line_to_codes(InStream, LineCodes),
  print_header_line(LineCodes), % for debug
  % parse request
  atom_codes('GET /', Get),
  append(Get, RL, LineCodes),
  read_request_aux(RL, RL2),
  catch(
    read_from_codes(RL2, Request),
    error(syntax_error(_),_),
    fail
  ), !.
read_request(_, syntax_error).
% read_request_aux([32|_], [46]) :- !.
read_request_aux([32|_], []) :- !.
read_request_aux([C|Cs], [C|RCs]) :- read_request_aux(Cs, RCs).

% Function to Output Request Lines (uncomment the line bellow to see more information on received HTTP Requests)
print_header_line(LineCodes) :-
  catch(
    (atom_codes(Line, LineCodes), format('Request header ~w~n', [Line]), nl),
    _,
    fail), !.
print_header_line(_).

% Handles parsed HTTP requests
% Returns 200 OK on successful aplication of parse_input on request
% Returns 400 Bad Request on syntax error (received from parser) or on failure of parse_input
handle_request(Request, MyReply, '200 OK') :-
  catch(
    parse_input(Request, MyReply),
    error(_, _),
    fail), !.
handle_request(syntax_error, 'Syntax Error', '400 Bad Request') :- !.
handle_request(_, 'Bad Request', '400 Bad Request').

%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%%%%                Commands                %%%%
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

% Require your Prolog Files here
:-include('./plog/emulsion.pl').

% our inputs
parse_input(ai_move(GameState,Player,Difficulty), Move) :-
  Difficulty > 0,
  sleep(0.5),
  valid_moves(GameState, Player, Moves),
  ai_getBestMove(GameState, Player, Moves, Difficulty, Move, _),
  !.
parse_input(ai_move(_,_,_), []).
parse_input(get_valid_moves(GameState,Player), ListOfMoves) :- valid_moves(GameState, Player, ListOfMoves), !.
parse_input(get_valid_moves(_,_), []).
parse_input(valid_move(GameState,Player,Move), Move) :- valid_move_full(GameState, Player, Move), !.
parse_input(valid_move(_,_,_), 'Invalid Move').
parse_input(score(GameState), V0-V1) :-
  value(GameState, 0, VL0), value(GameState, 1, VL1),
  parseValueList(VL0, VL1, V0, V1, _).

parse_input(handshake, handshake).
parse_input(test(C,N), Res) :- test(C,Res,N), !.
parse_input(quit, goodbye).

test(_,[],N) :- N =< 0.
test(A,[A|Bs],N) :- N1 is N-1, test(A,Bs,N1).


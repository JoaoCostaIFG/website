class MyPrologInterface {
  constructor(address, port) {
    this.baseUrl = "https://" + address + "/prolog/";
  }

  getPrologRequest(requestString, onSuccess, onError) {
    var request = new XMLHttpRequest();
    request.open("GET", this.baseUrl + requestString, true);

    request.onload =
      onSuccess ||
      function (data) {
        console.debug("Request successful. Reply: " + data.target.response);
      };
    request.onerror =
      onError ||
      function () {
        console.debug("Error waiting for response");
      };

    request.setRequestHeader(
      "Content-Type",
      "application/x-www-form-urlencoded; charset=UTF-8"
    );
    request.send();

    return request;
  }

  genGameState(board, player) {
    return (
      "gameState([0,0]," +
      board.size +
      "," +
      board.toString() +
      "," +
      player +
      ")"
    );
  }

  /* || MOVE IF VALID */
  requestValidMove(board, player, move, onSuccess) {
    // http://localhost:8081/valid_move(gameState([0,0],2,[[0,1],[1,0]],0),[[0,0],[0,1]])
    let req =
      "valid_move(" +
      this.genGameState(board, player) +
      "," +
      player +
      "," +
      move.toString() +
      ")";
    console.debug("Request: " + req);

    return this.getPrologRequest(req, onSuccess);
  }

  /* || VALID MOVES */
  requestValidMoves(board, player, onSuccess) {
    // http://localhost:8081/get_valid_moves(gameState([0,0],2,[[0,1],[1,0]],0),0)
    let req =
      "get_valid_moves(" +
      this.genGameState(board, player) +
      "," +
      player +
      ")";
    console.debug("Request: " + req);

    return this.getPrologRequest(req, onSuccess);
  }

  /* || SCORE */
  requestScore(board, onSuccess) {
    // http://localhost:8081/score(gameState([0,0],2,[[0,1],[1,0]],0))
    let req = "score(" + this.genGameState(board, "_") + ")";
    console.debug("Request: " + req);

    return this.getPrologRequest(req, onSuccess);
  }

  /* || AI MOVE */
  requestAIMove(board, player, difficulty, onSuccess) {
    // http://localhost:8081/ai_move(gameState([0,0],2,[[0,1],[1,0]],0),0,1)
    let req =
      "ai_move(" +
      this.genGameState(board, player) +
      "," +
      player +
      "," +
      difficulty +
      ")";
    console.debug("Request: " + req);

    return this.getPrologRequest(req, onSuccess);
  }
}

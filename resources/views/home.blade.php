<!DOCTYPE html>
<html>
<head>
  <title>Cliente PHP</title>
</head>
<body>
  <form id="form" action="" method="post">
    <input id="message" type="text" name="message" placeholder="Digite sua mensagem">
    <button type="submit">Enviar</button>
  </form>

  <div id="messages"></div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.1/socket.io.js"></script>
  <script>
    var socket = io('http://localhost:3000');

    document.getElementById('form').addEventListener('submit', function(e) {
      e.preventDefault();
      var room = document.getElementById('room').value;
      var message = document.getElementById('message').value;
      socket.emit('join', room); // Informa ao servidor que o usuário deseja entrar na sala
      socket.emit('chat message', { room: room, msg: message }); // Envia a mensagem para a sala especificada
      document.getElementById('message').value = '';
    });

    socket.on('chat message', function(msg) {
      var messagesDiv = document.getElementById('messages');
      var messageNode = document.createElement('div');
      messageNode.innerText = msg;
      messagesDiv.appendChild(messageNode);
    });
  </script>
</body>
</html>

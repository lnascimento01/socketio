<!DOCTYPE html>
<html>

<head>
  <title>Cliente PHP</title>
</head>

<body>
  <form id="form" action="" method="post">
    @if(empty($room))
    <select id="usuariosSelect" class="form-control">
      @foreach($usuarios as $usuario)
      <option value="{{ $usuario->id }}" id="{{$usuario->id}}">
        {{ $usuario->nome }}
      </option>
      @endforeach
    </select>
    @else
    <input id="room" type="hidden" name="room" value="{{ $room }}">
    <input id="userSelected" type="hidden" name="userSelected" value="0">
    <input id="message" type="text" name="message" placeholder="Digite sua mensagem">
    <button type="submit">Enviar</button>
    @endif
  </form>

  <div id="messages"></div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.1/socket.io.js"></script>
  <script>
    var socket = io('http://localhost:3000');
    const select = document.getElementById('usuariosSelect');

    if (select) {
      select.addEventListener('change', function() {
        const usuarioSelecionado = this.value;
        window.location.href = "?room=" + usuarioSelecionado;
      });
    }

    document.getElementById('form').addEventListener('submit', function(e) {
      e.preventDefault();
      var room = document.getElementById('room').value;
      var message = document.getElementById('message').value;
      socket.emit('join', room); // Informa ao servidor que o usuário deseja entrar na sala
      socket.emit('chat message', {
        room: room,
        msg: message
      }); // Envia a mensagem para a sala especificada
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
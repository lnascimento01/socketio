<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">


    <title>chat app - Soketio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        body {
            background-color: #f4f7f6;
            margin-top: 20px;
        }

        .card {
            background: #fff;
            transition: .5s;
            border: 0;
            margin-bottom: 30px;
            border-radius: .55rem;
            position: relative;
            width: 100%;
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 10%);
        }

        .chat-app .people-list {
            width: 280px;
            position: absolute;
            left: 0;
            top: 0;
            padding: 20px;
            z-index: 7
        }

        .chat-app .chat {
            margin-left: 280px;
            border-left: 1px solid #eaeaea
        }

        .people-list {
            -moz-transition: .5s;
            -o-transition: .5s;
            -webkit-transition: .5s;
            transition: .5s
        }

        .people-list .chat-list li {
            padding: 10px 15px;
            list-style: none;
            border-radius: 3px
        }

        .people-list .chat-list li:hover {
            background: #efefef;
            cursor: pointer
        }

        .people-list .chat-list li.active {
            background: #efefef
        }

        .people-list .chat-list li .name {
            font-size: 15px
        }

        .people-list .chat-list img {
            width: 45px;
            border-radius: 50%
        }

        .people-list img {
            float: left;
            border-radius: 50%
        }

        .people-list .about {
            float: left;
            padding-left: 8px
        }

        .people-list .status {
            color: #999;
            font-size: 13px
        }

        .chat .chat-header {
            padding: 15px 20px;
            border-bottom: 2px solid #f4f7f6
        }

        .chat .chat-header img {
            float: left;
            border-radius: 40px;
            width: 40px
        }

        .chat .chat-header .chat-about {
            float: left;
            padding-left: 10px
        }

        .chat .chat-history {
            padding: 20px;
            border-bottom: 2px solid #fff
        }

        .chat .chat-history ul {
            padding: 0
        }

        .chat .chat-history ul li {
            list-style: none;
            margin-bottom: 30px
        }

        .chat .chat-history ul li:last-child {
            margin-bottom: 0px
        }

        .chat .chat-history .message-data {
            margin-bottom: 15px
        }

        .chat .chat-history .message-data img {
            border-radius: 40px;
            width: 40px
        }

        .chat .chat-history .message-data-time {
            color: #434651;
            padding-left: 6px
        }

        .chat .chat-history .message {
            color: #444;
            padding: 18px 20px;
            line-height: 26px;
            font-size: 16px;
            border-radius: 7px;
            display: inline-block;
            position: relative
        }

        .chat .chat-history .message:after {
            bottom: 100%;
            left: 7%;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
            border-bottom-color: #fff;
            border-width: 10px;
            margin-left: -10px
        }

        .chat .chat-history .my-message {
            background: #efefef
        }

        .chat .chat-history .my-message:after {
            bottom: 100%;
            left: 30px;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
            border-bottom-color: #efefef;
            border-width: 10px;
            margin-left: -10px
        }

        .chat .chat-history .other-message {
            background: #e8f1f3;
            text-align: right
        }

        .chat .chat-history .other-message:after {
            border-bottom-color: #e8f1f3;
            left: 93%
        }

        .chat .chat-message {
            padding: 20px
        }

        .online,
        .offline,
        .me {
            margin-right: 2px;
            font-size: 8px;
            vertical-align: middle
        }

        .online {
            color: #86c541
        }

        .offline {
            color: #e47297
        }

        .me {
            color: #1d8ecd
        }

        .float-right {
            float: right
        }

        .clearfix:after {
            visibility: hidden;
            display: block;
            font-size: 0;
            content: " ";
            clear: both;
            height: 0
        }

        @media only screen and (max-width: 767px) {
            .chat-app .people-list {
                height: 465px;
                width: 100%;
                overflow-x: auto;
                background: #fff;
                left: -400px;
                display: none
            }

            .chat-app .people-list.open {
                left: 0
            }

            .chat-app .chat {
                margin: 0
            }

            .chat-app .chat .chat-header {
                border-radius: 0.55rem 0.55rem 0 0
            }

            .chat-app .chat-history {
                height: 300px;
                overflow-x: auto
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 992px) {
            .chat-app .chat-list {
                height: 650px;
                overflow-x: auto
            }

            .chat-app .chat-history {
                height: 600px;
                overflow-x: auto
            }
        }

        @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape) and (-webkit-min-device-pixel-ratio: 1) {
            .chat-app .chat-list {
                height: 480px;
                overflow-x: auto
            }

            .chat-app .chat-history {
                height: calc(100vh - 350px);
                overflow-x: auto
            }
        }
    </style>
</head>

<body>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <div class="container">
        <input id="actual-user" type="hidden" value="{{ $actualUser }}">
        <input id="selected-user" type="hidden" value="{{ current($users)->nome}}">
        <input id="all-messages" type="hidden" value="{{ $messages }}">
        <input id="actual-room" type="hidden" value="{{ str_replace('usuario', '', $actualUser) + str_replace('usuario', '', current($users)->id) }}">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card chat-app" style="min-height: 500px;">
                    <div id="plist" class="people-list">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                            </div>
                            <input type="text" class="form-control" id="searchInput" placeholder="Search...">
                        </div>
                        <button class="btn btn-primary d-block d-sm-none mt-2 mb-2" id="toggleUserList">Toggle User List</button>
                        <ul class="list-unstyled chat-list mt-2 mb-0">
                            @forelse($users as $key => $user)
                            <li class="clearfix {{ $key === 0 ? 'active' : ''}} user-item">
                                <img src="https://bootdey.com/img/Content/avatar/avatar{{$user->id}}.png" alt="avatar">
                                <a href="#" id="{{ $user->id }}" class="user-link">
                                    <div class="about">
                                        <div class="name">{{ $user->nome }}</div>
                                        <div class="status"> <i class="fa fa-circle offline"></i> left 7 mins ago </div>
                                    </div>
                                </a>
                            </li>
                            @empty
                            <li class="clearfix user-item">
                                No users
                            </li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="chat">
                        <div class="chat-header clearfix">
                            <div class="row">
                                <div class="col-lg-6">
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar{{ current($users)->id }}.png" alt="avatar">
                                    </a>
                                    <div class="chat-about">
                                        <h6 class="m-b-0" id="username">{{ current($users)->nome }}</h6>
                                        <small>Last seen: 2 hours ago</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chat-history" style="min-height: 400px; max-height: 400px; overflow-y: auto;">
                            <ul class="m-b-0" id="chat-painel">
                                @forelse($initialMessages['mensagens'] as $message)
                                @if($message['remetente'] != $actualUser)
                                <li class="clearfix">
                                    <div class="message-data text-right">
                                        <span class="message-data-time">{{ $message["hora"] }} - {{ $message["date"]}}</span>
                                        <img src="https://bootdey.com/img/Content/avatar/avatar{{ current($users)->id }}.png" alt="avatar">
                                    </div>
                                    <div class="message other-message float-right">
                                        @if($message["status"])
                                        <b>
                                            {{ $message["mensagem"] }}
                                        </b>
                                        @else
                                        {{ $message["mensagem"] }}
                                        @endif
                                    </div>
                                </li>
                                @else
                                <li class="clearfix">
                                    <div class="message-data">
                                        <span class="message-data-time">{{ $message["hora"] }} - {{ $message["date"]}}</span>
                                    </div>
                                    <div class="message my-message">{{ $message["mensagem"] }}</div>
                                </li>
                                @endif
                                @empty
                                @endforelse
                            </ul>
                        </div>
                        <div class="chat-message clearfix">
                            <div class="input-group mb-0">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="sendMessage"><i class="fa fa-send"></i></span>
                                </div>
                                <input type="text" class="form-control" id="text-message" placeholder="Enter text here...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.1/socket.io.js"></script>
    <script type="text/javascript">
        var actualUser = $('#actual-user').val();
        var socket = io('http://localhost:3000');

        document.getElementById("toggleUserList").addEventListener("click", function() {
            document.getElementById("plist").classList.toggle("open");
        });

        socket.on('connect', function(data) {
            socket.emit('authenticate', actualUser);
        });

        socket.on(actualUser, function(data) {
            console.log('Mensagem recebida:', data);
            // Faça algo com a mensagem recebida...
        });

        socket.on('chat message', function(msg) {
            let userMessage = {
                receiver: $('#actual-user').val(),
                remetente: $('#selected-user').val(),
                mensagem: msg,
                hora: '15:00',
                date: 'Terça-feira'
            };

            let createdMessage = createMessage(userMessage);

            $('#chat-painel').append(createdMessage)
        });

        function connectChat(room) {
            socket.emit('registerCustomId', room);
            socket.emit('join', room);
            $('#actual-room').val(room);
        }

        function updateActiveUser(userActive) {
            let userItem = document.querySelectorAll('li.user-item');

            userItem.forEach(function(item) {
                let userItemName = item.querySelector('.name').textContent;

                if (userItemName === userActive) {
                    item.classList.add('active');
                }

                if (userItemName !== userActive) {
                    item.classList.remove('active');
                }
            });
        }

        function createMessage(userMessage) {
            let avatarId = userMessage.remetente.replace('usuario', '');
            messageHtml = '<li class="clearfix">';
            messageHtml += '<div class="message-data' + (userMessage.remetente === actualUser ? '">' : ' text-right">');
            messageHtml += '<span class="message-data-time">' + userMessage.hora + ' - ' + userMessage.date + '</span>';

            if (userMessage.remetente !== actualUser) {
                messageHtml += ' <img src = "https://bootdey.com/img/Content/avatar/avatar' + avatarId + '.png" alt = "avatar" >';
            }

            messageHtml += '</div>';
            messageHtml += '<div class="message' + (userMessage.remetente === actualUser ? ' my-message">' : ' other-message float-right">') + userMessage.mensagem + '</div>';
            messageHtml += '</li>';

            return messageHtml;
        }

        function storeMessage(userMessage) {
            socket.emit('checkClientStatus', userMessage.receiver);

            socket.on('ping', () => {
                userMessage.status = true;
            });

            $.ajax({
                url: '/api/message',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(userMessage),
                success: '',
                error: ''
            });
        }

        function updateUnreadMessages(selectedUser, sender) {
            $.ajax({
                url: '/api/message',
                type: 'PATCH',
                contentType: 'application/json',
                data: JSON.stringify({
                    receiver: selectedUser,
                    remetente: sender
                }),
                success: '',
                error: ''
            });
        }

        function focusChat() {
            var chatPanel = document.getElementById('chat-painel');

            if (chatPanel) {
                var messages = chatPanel.getElementsByTagName('li');
                var lastMessage = messages[messages.length - 1];
                if (lastMessage) {
                    lastMessage.scrollIntoView();
                }
            }
        }

        $(document).ready(function() {
            connectChat($('#actual-room').val());
            focusChat();

            $('#sendMessage').click(function(e) {
                let message = $('#text-message').val();
                let room = $('#actual-room').val();


                socket.emit('chat message', {
                    room: room,
                    msg: message
                });

                $('#text-message').val('');

                let userMessage = {
                    receiver: $('#selected-user').val(),
                    remetente: actualUser,
                    mensagem: message,
                    hora: '14:00',
                    date: 'Terça-feira',
                    status: true
                };

                let createdMessage = createMessage(userMessage);

                $('#chat-painel').append(createdMessage);

                storeMessage(userMessage);
            });

            $('.user-link').click(function(e) {
                e.preventDefault();
                let messages = $('#all-messages').val();
                let messagesParsed = JSON.parse(messages);
                let selectedUser = $(this).find('.name').text();
                $('#selected-user').val(selectedUser);
                $('#chat-painel').html('');
                let roomId = parseInt(actualUser.replace('usuario', '')) + parseInt(selectedUser.replace('usuario', ''));
                $('#username').text(selectedUser);
                var imgElement = document.querySelector('.chat-header img');

                var userId = selectedUser.replace('usuario', '', selectedUser); 
                var newSrc = "https://bootdey.com/img/Content/avatar/avatar" + userId + ".png";
                imgElement.src = newSrc;

                connectChat(roomId);

                $.each(messagesParsed, function(index, message) {
                    let unreadMessages = false;

                    let includeActualUser = message.participantes.includes(actualUser);
                    let includeSelectedUser = message.participantes.includes(selectedUser);

                    if (message.participantes.length === 2 && (includeActualUser && includeSelectedUser)) {
                        $.each(message.mensagens, function(indexMessage, userMessage) {
                            if (message.status) {
                                unreadMessages = true;
                            }

                            let createdMessage = createMessage(userMessage);

                            $('#chat-painel').append(createdMessage);
                        });
                    }

                    if (unreadMessages) {
                        updateUnreadMessages(selectedUser, actualUser);
                    }
                });

                updateActiveUser(selectedUser);
                focusChat();
            });

            $('#searchInput').on('input', function() {
                var searchText = $(this).val().toLowerCase();
                $('.user-item').each(function() {
                    var username = $(this).find('.name').text().toLowerCase();
                    if (username.indexOf(searchText) === -1) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            });
        });
    </script>
</body>

</html>
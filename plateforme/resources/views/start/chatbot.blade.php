<style>
    /* Styles pour la bulle de chat */
    .chat-bubble {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
        cursor: pointer;
        background-color: #FEF8E7;;
        color: white;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    /* Styles pour l'icône dans la bulle */
    .chat-bubble img {
        width: 40px;
        height: 40px;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    /* Styles pour la fenêtre de chat */
    .chat-window {
        position: fixed;
        bottom: 90px;
        right: 20px;
        z-index: 1000;
        width: 350px;
        height: 450px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        display: none; /* Cachée par défaut */
        flex-direction: column;
    }

    .chat-header {
        background-color: #0d6efd;
        color: white;
        padding: 15px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chat-body {
        flex-grow: 1;
        overflow-y: auto;
        padding: 15px;
        background-color: #f9f9f9;
        display: flex;
        flex-direction: column;
    }

    .message {
        border-radius: 15px;
        padding: 10px 15px;
        margin-bottom: 10px;
        max-width: 80%;
    }

    .user-message {
        background-color: #0d6efd;
        color: white;
        align-self: flex-end;
    }

    .bot-message {
        background-color: #e9ecef;
        color: #333;
        align-self: flex-start;
    }

    .chat-footer {
        padding: 15px;
        border-top: 1px solid #eee;
    }
</style>

<div class="chat-bubble" onclick="toggleChat()">
    <img src="{{ asset('images/chatbot.png') }}" alt="Chatbot Icon">
</div>

<div class="chat-window" id="chatWindow">
    <div class="chat-header">
        <span>Assistant</span>
        <button onclick="toggleChat()" style="background:none; border:none; color:white; font-size:1.5rem;">&times;</button>
    </div>
    <div class="chat-body" id="chatBody">
        </div>
    <div class="chat-footer">
        <input type="text" id="userInput" placeholder="Écrivez votre message..." style="width:100%; padding:10px; border:1px solid #ccc; border-radius:20px;">
    </div>
</div>





<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    // Fonction pour ouvrir/fermer la fenêtre de chat
    function toggleChat() {
        var chatWindow = document.getElementById('chatWindow');
        if (chatWindow.style.display === 'none' || chatWindow.style.display === '') {
            chatWindow.style.display = 'flex';
        } else {
            chatWindow.style.display = 'none';
        }
    }

    document.getElementById('userInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });

    function sendMessage() {
        var userInput = document.getElementById('userInput');
        var message = userInput.value;
        if (message.trim() === '') return;

        // Affiche le message de l'utilisateur
        var chatBody = document.getElementById('chatBody');
        var userMessageElement = document.createElement('div');
        userMessageElement.classList.add('message', 'user-message');
        userMessageElement.textContent = message;
        chatBody.appendChild(userMessageElement);
        userInput.value = '';

        // Fait défiler le chat
        chatBody.scrollTop = chatBody.scrollHeight;

        // Envoie le message au serveur (Laravel)
        $.ajax({
            url: '{{ route('chatbot.send') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                message: message
            },
            success: function(response) {
                // Affiche la réponse du bot
                var botMessageElement = document.createElement('div');
                botMessageElement.classList.add('message', 'bot-message');
                botMessageElement.textContent = response.reply;
                chatBody.appendChild(botMessageElement);
                chatBody.scrollTop = chatBody.scrollHeight;
            }
        });
    }
</script>
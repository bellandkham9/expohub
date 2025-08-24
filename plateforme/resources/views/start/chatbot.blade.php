<style>
    /* Styles pour la bulle de chat */
    .chat-bubble {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
        cursor: pointer;
        background-color: #FEF8E7;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

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

    /* Fenêtre de chat */
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
        display: none;
        flex-direction: column;
    }

    .chat-header {
        background-color: #224194;
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
        gap: 10px;
    }

    /* Messages */
    .message-wrapper {
        display: flex;
        align-items: flex-end;
        gap: 8px;
    }

    .message {
        border-radius: 15px;
        padding: 10px 15px;
        max-width: 70%;
        word-wrap: break-word;
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

    .avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
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
    <div class="chat-header shadow-2xl">
        <a href="/" class="d-flex align-items-center text-decoration-none">
            <img src="{{ asset('images/chatbot.png') }}" 
                 alt="Chatbot Icon" 
                 width="45" height="45" 
                 class="me-2 rounded-circle p-1 shadow-sm bg-light">
            <span class="fw-bold fs-5 ">Expohub</span>
        </a>
        <button onclick="toggleChat()" style="background:none; border:none; font-size:1.5rem; color:white;">&times;</button>
    </div>

    <div class="chat-body" id="chatBody"></div>

    <div class="chat-footer">
        <input type="text" id="userInput" placeholder="Écrivez votre message..." 
               style="width:100%; padding:10px; border:1px solid #ccc; border-radius:20px;">
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    function toggleChat() {
        let chatWindow = document.getElementById('chatWindow');
        chatWindow.style.display = (chatWindow.style.display === 'flex') ? 'none' : 'flex';
    }

    document.getElementById('userInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });

    function sendMessage() {
        let userInput = document.getElementById('userInput');
        let message = userInput.value.trim();
        if (message === '') return;

        let chatBody = document.getElementById('chatBody');

        // Afficher message utilisateur avec avatar
        let userWrapper = document.createElement('div');
        userWrapper.classList.add('message-wrapper');
        userWrapper.style.justifyContent = "flex-end";

        let userMessageElement = document.createElement('div');
        userMessageElement.classList.add('message', 'user-message');
        userMessageElement.textContent = message;

        let userAvatar = document.createElement('img');
        userAvatar.src = "{{ auth()->user()->avatar_url ? asset(auth()->user()->avatar_url) : asset('images/user-person.png') }}";
        userAvatar.classList.add('avatar');

        userWrapper.appendChild(userMessageElement);
        userWrapper.appendChild(userAvatar);

        chatBody.appendChild(userWrapper);
        userInput.value = '';
        chatBody.scrollTop = chatBody.scrollHeight;

        // Envoyer au serveur
        $.ajax({
            url: '{{ route('chatbot.send') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                message: message
            },
            success: function(response) {
                // Afficher message du bot avec avatar
                let botWrapper = document.createElement('div');
                botWrapper.classList.add('message-wrapper');

                let botAvatar = document.createElement('img');
                botAvatar.src = "{{ asset('images/chatbot.png') }}";
                botAvatar.classList.add('avatar');

                let botMessageElement = document.createElement('div');
                botMessageElement.classList.add('message', 'bot-message');
                botMessageElement.textContent = response.reply;

                botWrapper.appendChild(botAvatar);
                botWrapper.appendChild(botMessageElement);

                chatBody.appendChild(botWrapper);
                chatBody.scrollTop = chatBody.scrollHeight;
            }
        });
    }
</script>

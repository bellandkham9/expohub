<!-- Tu peux renommer ce fichier en expression_ecrite.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TCF Canada - Expression Écrite</title>

    <!-- Bootstrap + FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/expression_ecrite.css')

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: white;
            color: #333;
        }
        .test-container { background-color: white; }
        .test-header { border-bottom: 1px solid #eee; padding: 20px; }
        .test-title { color: #224194; font-weight: 600; }
        .question-section { padding: 25px; border-bottom: 1px solid #eee; }
        .question-title { color: #224194; font-weight: 500; margin-bottom: 15px; }
        .chat-container {
            height: 60vh; overflow-y: auto; padding: 15px;
            background-color: #F8F9FA; border-radius: 8px;
        }
        .message { margin-bottom: 15px; max-width: 80%; }
        .user-message {
            margin-left: auto; background-color: white; color: black;
            border-radius: 15px 15px 0 15px; padding: 10px 15px;
            box-shadow: 1px 1px 1px rgb(193, 192, 192);
        }
        .bot-message {
            background-color: #FEF8E7; border-radius: 15px 15px 15px 0;
            padding: 10px 15px; box-shadow: 1px 1px 1px rgb(193, 192, 192);
        }
        .input-group {
            margin-top: 20px; padding: 30px; border-radius: 25px;
            box-shadow: 2px 2px 2px 1px rgb(179, 178, 178);
        }
        #btn-abonne {
            background-color: #BB1C1E; border-radius: 5px; color: white;
            padding: 10px 20px; font-weight: bold; border: none;
        }
    </style>
</head>
<body>

<div class="container py-4">
    <h2 class="mb-3">Test d'Expression Écrite</h2>

    <div class="card mb-4">
        <div class="card-body">
            <h5><strong>Contexte :</strong></h5>
            <p>{{ $question->contexte_texte }}</p>

            <h5><strong>Consigne :</strong></h5>
            <p>{{ $question->consigne }}</p>

            <input type="hidden" id="questionId" value="{{ $question->id }}">
        </div>
    </div>

    <!-- Timer -->
    <div class="mb-3">
        <div class="alert alert-info">
            Temps restant : <span id="timer">05:00</span>
        </div>
    </div>

    <!-- Chat window -->
    <div class="card mb-3" style="height: 300px; overflow-y: auto;" id="chatWindow">
        <div class="card-body">
            @foreach ($reponses as $rep)
                <div class="mb-2"><strong>Vous :</strong> {{ $rep->reponse }}</div>
                <div class="mb-3"><strong>ExpoHub :</strong> {{ $rep->prompt }}</div>
            @endforeach
        </div>
    </div>

    <!-- Input -->
    <div class="input-group mb-3">
        <input type="text" id="chatInput" class="form-control" placeholder="Écrivez votre réponse...">
        <button id="sendButton" class="btn btn-primary">Envoyer</button>
    </div>


        <input type="hidden" name="abandonner" value="1">
        <button onclick="abandonnerTest()" class="btn btn-danger">Abandonner</button>

        <script>
            function abandonnerTest() {
    if (confirm("Voulez-vous vraiment abandonner le test ?")) {
        window.location.href = "{{ route('expression_ecrite_resultat') }}";
    }
}

        </script>
 
</div>

<script>
    const timerDisplay = document.getElementById('timer');
    let duration = 5 * 60; // 5 minutes

    function updateTimer() {
        let minutes = Math.floor(duration / 60);
        let seconds = duration % 60;
        timerDisplay.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        if (duration > 0) {
            duration--;
        } else {
            window.location.href = "{{ route('expression_ecrite_resultat') }}";
        }
    }
    setInterval(updateTimer, 1000);

    function appendMessage(content, sender) {
        const chatBody = document.querySelector('#chatWindow .card-body');
        const msgDiv = document.createElement('div');
        msgDiv.classList.add('mb-2');
        msgDiv.innerHTML = `<strong>${sender === 'user' ? 'Vous' : 'Assistant'}:</strong> ${content}`;
        chatBody.appendChild(msgDiv);
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    document.getElementById('sendButton').addEventListener('click', sendMessage);
    document.getElementById('chatInput').addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            sendMessage();
            e.preventDefault();
        }
    });

function sendMessage() {
    const input = document.getElementById('chatInput');
    const message = input.value.trim();
    if (!message) return;

    appendMessage(message, 'user');
    input.value = '';

    fetch("{{ route('expression_ecrite_message') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            message: message,
            expression_ecrite_id: document.getElementById('questionId').value
        })
    })
    .then(res => {
        if (!res.ok) throw new Error("Erreur de l'IA");
        return res.json();
    })
    .then(data => {
        appendMessage(data.reply, 'assistant');
    })
    .catch(err => {
        console.error(err);
        appendMessage("Erreur de connexion avec l'IA.", 'assistant');
    });
}


   window.addEventListener('DOMContentLoaded', () => {
    fetch("{{ route('expression_ecrite_message') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            message: "Bonjour, je suis prêt à commencer.",
            expression_ecrite_id: document.getElementById('questionId').value
        })
    })
    .then(res => res.json())
    .then(data => {
        appendMessage(data.reply, 'assistant');
    })
    .catch(err => {
        appendMessage("Erreur de connexion avec l'IA : " + err.message, 'assistant');
    });
});

</script>


</body>
</html>












{{-- <!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TCF Canada - Expression Écrite</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/expression_ecrite.css')
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: white;
            color: #333;
        }

        .test-container {
            background-color: white;
        }

        .test-header {
            border-bottom: 1px solid #eee;
            padding: 20px;
        }

        .test-title {
            color: #224194;
            font-weight: 600;
        }

        .question-section {
            padding: 25px;
            border-bottom: 1px solid #eee;
        }

        .question-title {
            color: #224194;
            font-weight: 500;
            margin-bottom: 15px;
        }

        .chat-container {
            height: 300px;
            overflow-y: auto;
            padding: 15px;
            background-color: #F8F9FA;
            border-radius: 8px;
            height: 60vh;
        }

        .message {
            margin-bottom: 15px;
            max-width: 80%;
        }

        .user-message {
            margin-left: auto;
            background-color: white;
            color: black;
            border-radius: 15px 15px 0 15px;
            padding: 10px 15px;
            box-shadow: 1px 1px 1px rgb(193, 192, 192)
        }

        .bot-message {
            background-color: #FEF8E7;
            border-radius: 15px 15px 15px 0;
            padding: 10px 15px;
            box-shadow: 1px 1px 1px rgb(193, 192, 192)
        }

        .input-group {
            margin-top: 20px;
            padding: 30px;
            border-radius: 25px;
            box-shadow: 2px 2px 2px 1px rgb(179, 178, 178)
        }

        #btn-abonne {
            background-color: #BB1C1E;
            border-radius: 5px;
            color: white;
            padding: 10px;
            font-weight: bold;
            border: none;
            padding-left: 20px;
            padding-right: 20px;
        }

        .status-active {
            background-color: #d4edda;
            color: #155724;
        }

        .status-abandoned {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="test-container">

            <!-- Chat Interface -->
            <div class="p-4">
                <div class="row g-2 gap-x-4 gap-y-4 justify-between">
                    <div class="col-md-4  d-flex justify-content-center my-3">
                        <h4>60 : 00</h4>
                    </div>
                    <div class="col-md-4  d-flex justify-content-center my-3">
                        <h3>TCF CANADA, Expression écrite</h3>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center my-3">
                        <button id="btn-abonne" class="btn btn-outline-danger px-4 py-2" type="button">
                            <i class="fas fa-times-circle me-2"></i> Abandonné
                        </button>
                    </div>
                </div>
                <div class="chat-container mb-3" id="chatWindow">
                    <!-- Sample Chat Messages -->
                    <div class="message bot-message">
                        <strong>Assistant:</strong> Bonjour! Comment puis-je vous aider avec votre test d'expression
                        écrite?
                    </div>
                    <div class="message user-message">
                        <strong>Vous:</strong> Je ne comprends pas la deuxième question
                    </div>
                    <div class="message bot-message">
                        <strong>Assistant:</strong> La question 2 vous demande de décrire une image de 433x140 pixels.
                        Concentrez-vous sur les éléments visibles et utilisez un vocabulaire varié.
                    </div>
                </div>

                <div class="input-group">
                    <input type="text" class="form-control" id="chatInput" placeholder="Un petit texte ici......">
                    <button class="btn " id="sendButton">
                        <img src="{{ asset('images/send.png') }}" alt="Profil" class="" style="">
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Simple Chat Functionality -->
    <script>
        document.getElementById('sendButton').addEventListener('click', function() {
            const input = document.getElementById('chatInput');
            const message = input.value.trim();

            if (message) {
                // Add user message
                const chatWindow = document.getElementById('chatWindow');
                const userMsg = document.createElement('div');
                userMsg.className = 'message user-message';
                userMsg.innerHTML = `<strong>Vous:</strong> ${message}`;
                chatWindow.appendChild(userMsg);

                // Clear input
                input.value = '';

                // Simulate bot response after 1 second
                setTimeout(function() {
                    const botResponses = [
                        "Je comprends votre question. Pouvez-vous préciser?",
                        "Pour cette partie du test, il faut se concentrer sur...",
                        "Voici un exemple de réponse possible: ...",
                        "N'hésitez pas à utiliser des connecteurs logiques comme 'premièrement', 'ensuite'...",
                        "Votre réponse devrait contenir environ 120-150 mots."
                    ];
                    const randomResponse = botResponses[Math.floor(Math.random() * botResponses.length)];

                    const botMsg = document.createElement('div');
                    botMsg.className = 'message bot-message';
                    botMsg.innerHTML = `<strong>Assistant:</strong> ${randomResponse}`;
                    chatWindow.appendChild(botMsg);

                    // Scroll to bottom
                    chatWindow.scrollTop = chatWindow.scrollHeight;
                }, 1000);

                // Scroll to bottom
                chatWindow.scrollTop = chatWindow.scrollHeight;
            }
        });

        // Also allow sending with Enter key
        document.getElementById('chatInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('sendButton').click();
            }
        });
    </script>
</body>

</html>
 --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TCF Canada - Expression Écrite</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     @vite( 'resources/css/expression_ecrite.css')
     <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        .test-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
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
            background-color: #f5f7fa;
            border-radius: 8px;
        }
        .message {
            margin-bottom: 15px;
            max-width: 80%;
        }
        .user-message {
            margin-left: auto;
            background-color: #224194;
            color: white;
            border-radius: 15px 15px 0 15px;
            padding: 10px 15px;
        }
        .bot-message {
            background-color: #e9ecef;
            border-radius: 15px 15px 15px 0;
            padding: 10px 15px;
        }
        .input-group {
            margin-top: 20px;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
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
            <!-- Test Header -->
            <div class="test-header">
                <h1 class="test-title">TCF Canada, Expression écrite</h1>
                <span class="status-badge status-active">En cours</span>
            </div>

            <!-- Question Sections -->
            <div class="question-section">
                <h3 class="question-title">Question 1</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer interdum quam eu sem lobortis, et dignissim nunc rhoncus. Curabitur finibus, dolor nec vestibulum consectetur, arcu diam vestibulum nisi, sit amet imperdiet magna nulla sed magna.</p>
            </div>

            <div class="question-section">
                <h3 class="question-title">433 x 140</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer interdum quam eu sem lobortis, et dignissim nunc rhoncus. Curabitur finibus, dolor nec vestibulum consectetur, arcu diam vestibulum nisi, sit amet imperdiet magna nulla sed magna. Donec fermentum aliquam ligula in lobortis.</p>
            </div>

            <div class="question-section">
                <h3 class="question-title">Abandonné</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer interdum quam eu sem lobortis, et dignissim nunc rhoncus. Curabitur finibus, dolor nec vestibulum consectetur, arcu diam vestibulum nisi, sit amet imperdiet magna nulla sed magna.</p>
            </div>

            <!-- Chat Interface -->
            <div class="p-4">
                <h4 class="mb-3">Aide et Discussion</h4>
                <div class="chat-container mb-3" id="chatWindow">
                    <!-- Sample Chat Messages -->
                    <div class="message bot-message">
                        <strong>Assistant:</strong> Bonjour! Comment puis-je vous aider avec votre test d'expression écrite?
                    </div>
                    <div class="message user-message">
                        <strong>Vous:</strong> Je ne comprends pas la deuxième question
                    </div>
                    <div class="message bot-message">
                        <strong>Assistant:</strong> La question 2 vous demande de décrire une image de 433x140 pixels. Concentrez-vous sur les éléments visibles et utilisez un vocabulaire varié.
                    </div>
                </div>

                <div class="input-group">
                    <input type="text" class="form-control" id="chatInput" placeholder="Posez votre question...">
                    <button class="btn btn-primary" id="sendButton">
                        <i class="fas fa-paper-plane"></i> Envoyer
                    </button>
                </div>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="text-center mt-4 text-muted">
            <p>Un petit texte ici...</p>
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
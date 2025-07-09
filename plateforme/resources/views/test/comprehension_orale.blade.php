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
    @vite('resources/css/expression_ecrite.css')
    <style>
        .test-container {
            background-color: white;
        }

        .chat-container {
            overflow-y: auto;
            padding: 15px;
            background-color: #F8F9FA;
            border-radius: 8px;
            height: 60vh;
            margin: 0 auto;
            justify-content: center;
            align-items: center;
        }

        .message {
            margin-bottom: 15px;
            max-width: 80%;
        }

        .user-message {
          margin: 0 auto;
            background-color: white;
            color: black;
            border-radius: 15px 15px 0 15px;
            padding: 10px 15px;
            display: flex;
            width: 30%;
            align-items: center;
            box-shadow: 1px 1px 1px rgb(193, 192, 192)
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin: 5px;
        }

        .bot-message {
            background-color: #FEF8E7;
            border-radius: 15px 15px 15px 0;
            padding: 10px 15px;
            box-shadow: 1px 1px 1px rgb(193, 192, 192);
            margin: 8px;
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

        #inpu-group {
            border-radius: 10px;
            padding: 30px;
            box-shadow: 2px 2px 2px 2px gainsboro
        }
       #poster {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
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
                        <h5>TCF CANADA, Compréhension orale</h5>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center my-3">
                        <button id="btn-abonne" class="btn btn-outline-danger px-4 py-2" type="button">
                            <i class="fas fa-times-circle me-2"></i> Abandonné
                        </button>
                    </div>
                </div>
                <div id="poster" class="chat-container mb-3 ">
    <img src="{{ asset('images/collaboration.png') }}" alt="collabo" class="shadow-lg img-fluid" style="border-radius: 15px;">
</div>


                <div id="inpu-group" class="container  my-5">
                    <div class="text-center mb-4">
                         <div class="user-message">
                        <audio id="audio" controls>
                            <source src="{{ asset('songs/himra.m4a') }}" type="audio/mp3">
                            Votre navigateur ne supporte pas l'élément audio.
                        </audio>
                    </div>
                    </div>

                    <div class="row g-4 justify-content-center">
                        <div class="col-md-5 btn">
                            <div class="p-3 shadow-lg rounded bg-white text-center h-100">
                                <p class="mb-0">
                                    <span class="fw-bold fs-4 me-2">A</span>
                                    Lorem ipsum dolor sit amet, consectetur
                                </p>
                            </div>
                        </div>
                        <div class="col-md-5 btn">
                            <div class="p-3 shadow-lg rounded bg-white text-center h-100">
                                <p class="mb-0">
                                    <span class="fw-bold fs-4 me-2">B</span>
                                    Lorem ipsum dolor sit amet, consectetur
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 justify-content-center mt-3">
                        <div class="col-md-5 btn">
                            <div class="p-3 shadow-lg rounded bg-white text-center h-100">
                                <p class="mb-0">
                                    <span class="fw-bold fs-4 me-2">C</span>
                                    Lorem ipsum dolor sit amet, consectetur
                                </p>
                            </div>
                        </div>
                        <div class="col-md-5 btn">
                            <div class="p-3 shadow-lg rounded bg-white text-center h-100">
                                <p class="mb-0">
                                    <span class="fw-bold fs-4 me-2">D</span>
                                    Lorem ipsum dolor sit amet, consectetur
                                </p>
                            </div>
                        </div>
                    </div>
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

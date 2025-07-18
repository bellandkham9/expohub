<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT6VZ6zP8E6ztpj6M/t94wr7" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">


    <title>Document</title>
    <style>
        .shadowed {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        html,
        body {
            background-color: white;
            font-family: "Inter", sans-serif;
        }

        .testimonial-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 1rem;
        }

        #hero {
            background-image: url("{{ asset('images/student.png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 600px;
            /* ajuste la hauteur selon ton besoin */
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: start;
            padding: 30px;
            border-radius: 30px;
        }

        #hero-contact {
            background-image: url("{{ asset('images/hero-contact.png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 600px;
            /* ajuste la hauteur selon ton besoin */
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: start;
            padding: 30px;
            border-radius: 30px;
        }

        /*========>     STYLE SIDEBAR*/
        .sidebar .nav-link.active {
            background-color: #f0f8ff;
            border-radius: 0.5rem;
        }

    </style>

    @vite(['resources/sass/app.scss', 'resources/css/custom.css', 'resources/css/suggestion.css',  'resources/css/choix_test.css', 'resources/css/dashboard-client.css', 'resources/js/app.js'])
</head>

<body class="bg-dark">
    <div id="app" class="" style="background-color: white">
        <main class="">
            @yield('content')
        </main>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Bundle (inclut Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YW8hRhP56V8VuSK9Eo0BtJXG5Dspu3j1gzDdt8ZMpPoQ9B/JW1yQlGb0n0e5l9lx" crossorigin="anonymous"></script>




</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

   
    <title>Document</title>
    <style>
        .shadowed {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        html,
        body {
            background-color: white;
        }

        .testimonial-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 1rem;
        }

        #hero {
            hero-contact background-image: url("{{ asset('images/student.png') }}");
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
    </style>

    @vite(['resources/sass/app.scss', 'resources/css/custom.css', 'resources/css/dashboard-client.css', 'resources/js/app.sjs'])
</head>

<body class="bg-dark">
    <div id="app" class="" style="background-color: white">
        <main class="">
            @yield('content')
        </main>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    

</body>

</html>

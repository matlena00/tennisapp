<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Witaj w aplikacji TENISSO</title>
    <style>
        body {
            background-color: #f8f8f8;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #ffffff;
        }
        .container {
            background-color: #204934;
            border-radius: 8px;
            padding: 60px 30px;
            margin: 20px auto;
            max-width: 800px;
        }
        h1 {
            margin-bottom: 20px;
            color: #fff;
        }
        p {
            margin: 10px 0 20px 0;
        }
        .footer {
            font-size: 0.9em;
            color: #ccc;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Witaj, {{$user->name}}</h1>
    <p>Dziękujemy za rejestrację! Już teraz możesz zarezerwować interesujący Cię kort!</p>
    <p>Aby zmienić swoje dane logowania przejdź do zakładki <strong>Profil</strong>. Jeśli chcesz dokonać rezerwacji, musisz przejść pod zakładkę <strong>Rezerwuj kort</strong>.</p>
    <p>Nie możemy się doczekać Twojej pierwszej rezerwacji! Czekamy na Ciebie z niecierpliwością.</p>
    <div class="footer">
        Dziękujemy za zaufanie i do zobaczenia na korcie!
    </div>
</div>
</body>
</html>


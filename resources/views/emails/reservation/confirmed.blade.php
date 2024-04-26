<!DOCTYPE html>
<html>
<head>
    <title>Twoja rezerwacja w aplikacji TENISSO</title>
</head>
<body>
<h2>Rezerwacja #{{$reservation->id}}</h2>
<p>Twoja rezerwacja #{{$reservation->id}} została potiwerdzona. Poniżej znajdziesz jej szczegóły.</p>
<p>Aby anulować rezerwację przejdź do panelu i odszukaj zakładki Moje rezerwacje. Następnie postępuj zgodnie z informacjami pojawiającymi się na ekranie.</p>
<p>Czekamy na Ciebie z niecierpliwością.</p>

<table>
    <th>Nazwa kortu</th>
    <th>Nawierzchnia</th>
    <th>Godzina rozpoczęcia</th>
    <th>Godzina zakończenia</th>
    <tr>
        <td>{{$court_name}}</td>
        <td>{{$court_surface}}</td>
        <td>{{$reservation->start_time}}</td>
        <td>{{$reservation->end_time}}</td>
    </tr>
</table>
</body>
</html>


<h1>Ciao {{ $admin->name }}</h1>

<p>
    <strong>
        {{ $lead->name }} 
    </strong>
    ha inviato un nuovo messaggio dalla tua pagina!
    <strong>
        Messaggio: {{ $lead->message }}
    </strong>
    <strong>
        Email: {{ $lead->email }}
    </strong>
</p>
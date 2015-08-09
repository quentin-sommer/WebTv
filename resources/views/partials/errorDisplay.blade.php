@if(Session::has('error'))
    <div class="alert alert-danger errorBox" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <span class="sr-only">Erreur:</span>
        {{ Session::get('error') }}
    </div>
@endif
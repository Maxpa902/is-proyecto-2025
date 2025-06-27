<p>
    USUARIO: {{ Auth::user() }}
    TIENE ROL: {{ Auth::user()->hasRole('cliente') }}
</p>

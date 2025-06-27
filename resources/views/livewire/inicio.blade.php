@push('styles')
    @vite('resources/css/components/colores.css')
    @vite('resources/css/components/calendario.css')
@endpush
<div>
    <div class="card mt-3" style="border: 0px solid black;">
        <div class="quinto card-body m-3" style="border: 2px solid #00bcd4ff; border-radius: 20px;">
            <h5 class="primero-letra">Modo Invitado: </h5>
            <p>Para inscribirte a clases debes iniciar sesión o registrarte.</p>
        </div>
        <div class="card-footer">
            <x-calendario :clases-por-dia="$clasesPorDia" />
        </div>
    </div>
</div>

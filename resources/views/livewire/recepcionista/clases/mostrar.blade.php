@push('styles')
    @vite('resources/css/components/colores.css')
    @vite('resources/css/components/calendario.css')
@endpush
<div>
    <div>
        {{-- Horarios Semanales - Ahora es un componente Livewire independiente --}}
        <div class="bg-white rounded shadow-sm p-4 mb-4">
            <div class="row text-center card-footer">
                <livewire:cliente.calendario-clases />
            </div>
        </div>
    </div>
</div>

<?php

namespace App\Livewire\Forms;

use App\Models\Actividad;
use App\Models\Clase;
use App\Models\DiaSemana;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ClaseForm extends Form
{
    public ?Clase $clase = null;

    #[Validate('required|integer|min:1|exists:actividades,id')]
    public int $id_actividad = 0;

    #[Validate('required|integer|min:1')]
    public int $numero_clase = 1;

    #[Validate('required|date_format:H:i')]
    public string $hora_inicio = '';

    #[Validate('required|date_format:H:i|after:hora_inicio')]
    public string $hora_fin = '';

    #[Validate('required|integer|min:1|max:100')]
    public int $capacidad_maxima = 1;

    #[Validate('required|in:activa,inactiva')]
    public string $estado = 'activa';

    #[Validate('required|string|max:150')]
    public string $nombre_completo_profesor = '';

    #[Validate('required|string|max:100')]
    public string $lugar = '';

    #[Validate('required|array|min:1')]
    public array $dias_seleccionados = [];

    /**
     * Cargar datos de una clase existente
     */
    public function setClase(Clase $clase): void
    {
        $this->clase = $clase;
        $this->id_actividad = $clase->id_actividad;
        $this->numero_clase = $clase->numero_clase;
        $this->hora_inicio = $clase->hora_inicio->format('H:i');
        $this->hora_fin = $clase->hora_fin->format('H:i');
        $this->capacidad_maxima = $clase->capacidad_maxima;
        $this->estado = $clase->estado;
        $this->nombre_completo_profesor = $clase->nombre_completo_profesor;
        $this->lugar = $clase->lugar;
        $this->dias_seleccionados = $clase->dias->pluck('id')->toArray();
    }

    /**
     * Resetear el formulario completamente
     */
    public function reset(...$properties): void
    {
        if (empty($properties)) {
            $this->clase = null;
            $this->id_actividad = 0;
            $this->numero_clase = 1;
            $this->hora_inicio = '';
            $this->hora_fin = '';
            $this->capacidad_maxima = 1;
            $this->estado = 'activa';
            $this->nombre_completo_profesor = '';
            $this->lugar = '';
            $this->dias_seleccionados = [];
        } else {
            parent::reset(...$properties);

            foreach ($properties as $property) {
                $this->setDefaultValue($property);
            }
        }
    }

    /**
     * Crear nueva clase
     */
    public function store(): Clase
    {
        $this->validate();
        $this->validateTimeLogic();
        $this->validateActiveActivity();
        $this->validateDiasExist();

        return DB::transaction(function () {
            $actividad = Actividad::find($this->id_actividad);

            if (! $actividad) {
                throw new \Exception('Actividad no encontrada');
            }

            // Verificar conflictos detallados
            $conflictos = $actividad->verificarConflictosDetallados(
                $this->dias_seleccionados,
                $this->hora_inicio,
                $this->hora_fin
            );

            if (! empty($conflictos)) {
                $mensajeConflictos = $this->formatearMensajeConflictos($conflictos);
                throw new \Exception($mensajeConflictos);
            }

            $clase = $actividad->crearClase([
                'id_actividad' => $this->id_actividad,
                'hora_inicio' => $this->hora_inicio,
                'hora_fin' => $this->hora_fin,
                'capacidad_maxima' => $this->capacidad_maxima,
                'estado' => $this->estado,
                'nombre_completo_profesor' => $this->nombre_completo_profesor,
                'lugar' => $this->lugar,
            ], $this->dias_seleccionados);

            $clase->load('dias');

            // Configurar rango de fechas (3 meses desde hoy)
            $fechaInicio = Carbon::now()->startOfMonth()->format('Y-m-d');
            $fechaFin = Carbon::now()->addMonths(3)->endOfMonth()->format('Y-m-d');

            $sesionesCreadas = $clase->generarSesionesEnRango($fechaInicio, $fechaFin);

            return $clase;
        });
    }

    /**
     * Actualizar clase
     */
    public function update(): bool
    {
        if (! $this->clase) {
            throw new \Exception('No hay clase para actualizar');
        }

        $this->validate();
        $this->validateTimeLogic();
        $this->validateActiveActivity();
        $this->validateDiasExist();

        // Verificar conflictos detallados
        /**
         * @var Actividad $actividad
         */
        $actividad = $this->clase->actividad;
        $conflictos = $actividad->verificarConflictosDetallados(
            $this->dias_seleccionados,
            $this->hora_inicio,
            $this->hora_fin,
            $this->clase->id,
        );

        if (! empty($conflictos)) {
            $mensajeConflictos = $this->formatearMensajeConflictos($conflictos);
            throw new \Exception($mensajeConflictos);
        }

        return DB::transaction(function () {
            $this->clase->update([
                'hora_inicio' => $this->hora_inicio,
                'hora_fin' => $this->hora_fin,
                'capacidad_maxima' => $this->capacidad_maxima,
                'estado' => $this->estado,
                'nombre_completo_profesor' => $this->nombre_completo_profesor,
                'lugar' => $this->lugar,
            ]);

            $this->clase->dias()->sync($this->dias_seleccionados);
            $this->clase->touch();

            return true;
        });
    }

    /**
     * Obtener opciones para selects
     */
    public function getActividades(): array
    {
        $actividades = Actividad::where('estado', 'activa')
            ->orderBy('nombre')
            ->pluck('nombre', 'id')
            ->toArray();

        // Agregar opción por defecto al inicio
        return [0 => 'Selecciona una actividad'] + $actividades;
    }
    public function getDiasSemana(): array
    {
        return DiaSemana::orderBy('orden')
            ->pluck('nombre', 'id')
            ->toArray();
    }

    public function getEstados(): array
    {
        return [
            'activa' => 'Activa',
            'inactiva' => 'Inactiva',
        ];
    }

    /**
     * Validar todo el formulario incluyendo reglas personalizadas
     */
    public function validateAll(): void
    {
        $this->validate();
        $this->validateTimeLogic();
        $this->validateActiveActivity();
        $this->validateDiasExist();
    }

    /**
     * Validar horarios lógicos
     */
    protected function validateTimeLogic(): void
    {
        if ($this->hora_inicio && $this->hora_fin) {
            $inicio = Carbon::createFromFormat('H:i', $this->hora_inicio);
            $fin = Carbon::createFromFormat('H:i', $this->hora_fin);

            if ($fin->lte($inicio)) {
                throw ValidationException::withMessages([
                    'form.hora_fin' => 'La hora de fin debe ser posterior a la hora de inicio.',
                ]);
            }

            if ($inicio->diffInMinutes($fin) < 30) {
                throw ValidationException::withMessages([
                    'form.hora_fin' => 'La clase debe durar al menos 30 minutos.',
                ]);
            }
        }
    }

    /**
     * Validar que la actividad esté activa
     */
    protected function validateActiveActivity(): void
    {
        if ($this->id_actividad) {
            $actividad = Actividad::find($this->id_actividad);

            if (! $actividad || $actividad->estado !== 'activa') {
                throw ValidationException::withMessages([
                    'form.id_actividad' => 'La actividad seleccionada no está disponible.',
                ]);
            }
        }
    }

    /**
     * Validar que los días existan
     */
    protected function validateDiasExist(): void
    {
        if (! empty($this->dias_seleccionados)) {
            $diasValidos = DiaSemana::whereIn('id', $this->dias_seleccionados)->count();

            if ($diasValidos !== count($this->dias_seleccionados)) {
                throw ValidationException::withMessages([
                    'form.dias_seleccionados' => 'Algunos días seleccionados no son válidos.',
                ]);
            }
        }
    }

    /**
     * Formatear mensaje de conflictos para mostrar al usuario
     */
    private function formatearMensajeConflictos(array $conflictos): string
    {
        $mensaje = "No se puede crear la clase. Conflictos detectados:\n\n";

        foreach ($conflictos as $conflicto) {
            $mensaje .= sprintf(
                "• %s de %s a %s: se superpone con '%s' (%s a %s)\n",
                $conflicto['dia_nombre'],
                $conflicto['hora_inicio_nueva'],
                $conflicto['hora_fin_nueva'],
                $conflicto['clase_nombre'],
                $conflicto['hora_inicio_conflictiva'],
                $conflicto['hora_fin_conflictiva']
            );
        }

        return trim($mensaje);
    }

    /**
     * Establecer valor por defecto para una propiedad
     */
    private function setDefaultValue(string $property): void
    {
        switch ($property) {
            case 'numero_clase':
                $this->numero_clase = 1;
                break;
            case 'capacidad_maxima':
                $this->capacidad_maxima = 1;
                break;
            case 'estado':
                $this->estado = 'activa';
                break;
            case 'id_actividad':
                $this->id_actividad = 0;
                break;
            case 'hora_inicio':
            case 'hora_fin':
            case 'nombre_completo_profesor':
            case 'lugar':
                $this->{$property} = '';
                break;
            case 'dias_seleccionados':
                $this->dias_seleccionados = [];
                break;
            case 'clase':
                $this->clase = null;
                break;
        }
    }
}

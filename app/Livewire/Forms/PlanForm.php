<?php

namespace App\Livewire\Forms;

use App\Models\Actividad;
use App\Models\Plan;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PlanForm extends Form
{
    public ?Plan $plan = null;

    #[Validate('required|exists:actividades,id')]
    public int $id_actividad = 0;

    #[Validate('required|numeric|min:0|max:999999.99')]
    public float $precio_plan = 0;

    #[Validate('required|integer|min:1|max:365')]
    public int $dias_acceso_actividad = 30;

    /**
     * Cargar datos de un plan existente
     */
    public function setPlan(Plan $plan): void
    {
        $this->plan = $plan->load('actividad');

        $this->id_actividad = $plan->id_actividad;
        $this->precio_plan = (float) $plan->precio_plan;
        $this->dias_acceso_actividad = $plan->dias_acceso_actividad;
    }

    /**
     * Resetear el formulario para nuevo plan
     */
    public function reset(...$properties): void
    {
        if (empty($properties)) {
            $properties = [
                'plan',
                'id_actividad',
                'precio_plan',
                'dias_acceso_actividad',
            ];
        }

        parent::reset(...$properties);

        // Valores por defecto
        $this->id_actividad = 0;
        $this->precio_plan = 0;
        $this->dias_acceso_actividad = 30;
    }

    /**
     * Crear nuevo plan
     */
    public function store(): Plan
    {
        $this->validate();
        $this->validateActiveActivity();
        $this->validatePriceLogic();
        $this->validateDaysLogic();
        $this->validateUniquePlan();

        $plan = Plan::create([
            'id_actividad' => $this->id_actividad,
            'precio_plan' => $this->precio_plan,
            'dias_acceso_actividad' => $this->dias_acceso_actividad,
        ]);

        // Notificación para redirect
        session()->flash('notificacion', [
            'tipo' => 'exito',
            'titulo' => 'Plan creado',
            'mensaje' => 'El plan se ha creado correctamente.',
            'duracion' => 4_000,
        ]);

        return $plan;
    }

    /**
     * Actualizar plan existente
     */
    public function update(): bool
    {
        if (! $this->plan) {
            throw new \Exception('No hay plan para actualizar');
        }

        $this->validate();
        $this->validateActiveActivity();
        $this->validatePriceLogic();
        $this->validateDaysLogic();
        $this->validateUniquePlan();

        $updated = $this->plan->update([
            'id_actividad' => $this->id_actividad,
            'precio_plan' => $this->precio_plan,
            'dias_acceso_actividad' => $this->dias_acceso_actividad,
        ]);

        // Notificación para redirect
        session()->flash('notificacion', [
            'tipo' => 'exito',
            'titulo' => 'Plan actualizado',
            'mensaje' => 'El plan se ha actualizado correctamente.',
            'duracion' => 4_000,
        ]);

        return $updated;
    }

    /**
     * Obtener opciones para selects
     */
    public function getActividades(): array
    {
        return Actividad::where('estado', 'activa')
            ->orderBy('nombre')
            ->pluck('nombre', 'id')
            ->toArray();
    }

    /**
     * Calcular precio por día
     */
    public function getPrecioPorDia(): float
    {
        if ($this->dias_acceso_actividad > 0) {
            return round($this->precio_plan / $this->dias_acceso_actividad, 2);
        }

        return 0;
    }

    /**
     * Obtener texto descriptivo del plan
     */
    public function getDescripcion(): string
    {
        if ($this->id_actividad && $this->precio_plan && $this->dias_acceso_actividad) {
            $actividades = $this->getActividades();
            $actividad = $actividades[$this->id_actividad] ?? 'Actividad';
            $precio = number_format($this->precio_plan, 0, ',', '.');

            return "{$actividad} - \${$precio} por {$this->dias_acceso_actividad} días";
        }

        return 'Plan sin configurar';
    }

    /**
     * Validar todo el formulario incluyendo reglas personalizadas
     */
    public function validateAll(): void
    {
        $this->validate();
        $this->validateActiveActivity();
        $this->validatePriceLogic();
        $this->validateDaysLogic();
        $this->validateUniquePlan();
    }

    /**
     * Obtener planes similares para comparación
     */
    public function getPlanesSimilares(): array
    {
        if (! $this->id_actividad) {
            return [];
        }

        return Plan::where('id_actividad', $this->id_actividad)
            ->when($this->plan, fn ($query) => $query->where('id', '!=', $this->plan->id))
            ->with('actividad')
            ->limit(3)
            ->get()
            ->map(function ($plan) {
                return [
                    'id' => $plan->id,
                    'precio' => $plan->precio_plan,
                    'dias' => $plan->dias_acceso_actividad,
                    'precio_por_dia' => round($plan->precio_plan / $plan->dias_acceso_actividad, 2),
                ];
            })
            ->toArray();
    }

    /**
     * Validar que no exista un plan igual para la misma actividad
     */
    protected function validateUniquePlan(): void
    {
        $query = Plan::where('id_actividad', $this->id_actividad)
            ->where('precio_plan', $this->precio_plan)
            ->where('dias_acceso_actividad', $this->dias_acceso_actividad);

        // Si estamos editando, excluir el plan actual
        if ($this->plan) {
            $query->where('id', '!=', $this->plan->id);
        }

        if ($query->exists()) {
            throw ValidationException::withMessages([
                'form.precio_plan' => 'Ya existe un plan idéntico para esta actividad.',
            ]);
        }
    }

    /**
     * Validar que la actividad esté activa
     */
    protected function validateActiveActivity(): void
    {
        $actividad = Actividad::find($this->id_actividad);

        if (! $actividad || $actividad->estado !== 'activa') {
            throw ValidationException::withMessages([
                'form.id_actividad' => 'La actividad seleccionada no está disponible.',
            ]);
        }
    }

    /**
     * Validar precios lógicos
     */
    protected function validatePriceLogic(): void
    {
        if ($this->precio_plan <= 0) {
            throw ValidationException::withMessages([
                'form.precio_plan' => 'El precio debe ser mayor a cero.',
            ]);
        }

        // Validar que no sea excesivamente caro (opcional)
        if ($this->precio_plan > 100_000) {
            throw ValidationException::withMessages([
                'form.precio_plan' => 'El precio parece excesivamente alto. Verifica el monto.',
            ]);
        }
    }

    /**
     * Validar días de acceso lógicos
     */
    protected function validateDaysLogic(): void
    {
        if ($this->dias_acceso_actividad < 1) {
            throw ValidationException::withMessages([
                'form.dias_acceso_actividad' => 'Los días de acceso deben ser al menos 1.',
            ]);
        }

        if ($this->dias_acceso_actividad > 365) {
            throw ValidationException::withMessages([
                'form.dias_acceso_actividad' => 'Los días de acceso no pueden exceder 1 año.',
            ]);
        }
    }
}

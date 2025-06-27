{{-- resources/views/components/input.blade.php --}}
@props([
    'type' => 'text',
    'name' => '',
    'label' => '',
    'placeholder' => '',
    'value' => '',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'autofocus' => false,
    'autocomplete' => null,
    'help' => '',
    'icon' => null,
    'min' => null,
    'max' => null,
    'step' => null,
    'rows' => 3,
    'options' => [], // Para select
    'multiple' => false, // Para select múltiple
    'livewire' => null, // Para wire:model (ej: "form.email")
    'livewireModifier' => 'blur', // Modificador de livewire
    'alpine' => null, // Para x-model
    'loading' => false, // Estado de carga
    'errorField' => null, // Campo específico para errores (si es diferente a name)
])

@php
    $inputId = $name ?: 'input_' . uniqid();

    // Detectar si es Livewire Form antes de calcular errorField
    $isLivewireForm = $livewire && str_starts_with($livewire, 'form.');

    // Para Livewire Forms, el errorField debe incluir el prefix "form."
    if ($isLivewireForm && !$errorField) {
        $errorField = $livewire; // Usar el nombre completo con form.
    } else {
        $errorField = $errorField ?: $name;
    }

    $hasError = $errors->has($errorField);
    $isTextarea = $type === 'textarea';
    $isSelect = $type === 'select';
    $isCheckbox = $type === 'checkbox';
    $isRadio = $type === 'radio';
    $isFile = $type === 'file';

    // Obtener valor actual
    $currentValue = $value;
    if (!$isLivewireForm) {
        // Para formularios normales, usar old()
        $currentValue = old($errorField, $value);
    }
    // Para Livewire Forms, NO manejar el valor aquí - wire:model lo hace automáticamente

    // Construir atributos dinámicos
    $inputAttributes = [
        'id' => $inputId,
        'placeholder' => $placeholder,
    ];

    // CLAVE: Solo establecer 'name' para formularios NO-Livewire
    if (!$isLivewireForm) {
        $inputAttributes['name'] = $name;
    }

    // Clase base según el tipo
    if ($isCheckbox) {
        $inputAttributes['class'] = 'checkbox-input' . ($hasError ? ' error' : '');
    } else {
        $inputAttributes['class'] = 'form-input' . ($hasError ? ' error' : '');
    }

    // Value para inputs normales (no checkbox, file, etc)
    if (!$isCheckbox && !$isFile && !$isSelect && !$isTextarea && !$isLivewireForm) {
        // Solo establecer value si NO es Livewire Form - wire:model lo maneja automáticamente
        $inputAttributes['value'] = $currentValue;
    }

    // Atributos condicionales
    if ($required) {
        $inputAttributes['required'] = true;
    }
    if ($disabled || $loading) {
        $inputAttributes['disabled'] = true;
    }
    if ($readonly) {
        $inputAttributes['readonly'] = true;
    }
    if ($autofocus) {
        $inputAttributes['autofocus'] = true;
    }
    if ($autocomplete) {
        $inputAttributes['autocomplete'] = $autocomplete;
    }
    if ($min !== null) {
        $inputAttributes['min'] = $min;
    }
    if ($max !== null) {
        $inputAttributes['max'] = $max;
    }
    if ($step !== null) {
        $inputAttributes['step'] = $step;
    }
    if ($type !== 'checkbox' && $type !== 'radio') {
        $inputAttributes['type'] = $type;
    }

    // Atributos de integración
    if ($livewire) {
        $inputAttributes['wire:model.' . $livewireModifier] = $livewire;
    }
    if ($alpine) {
        $inputAttributes['x-model'] = $alpine;
    }

    // Para checkbox, manejar el value
    if ($isCheckbox) {
        $inputAttributes['type'] = 'checkbox';
        $inputAttributes['value'] = $value ?: '1';

        // Establecer checked solo para formularios normales (NO Livewire)
        if (!$isLivewireForm && $currentValue) {
            $inputAttributes['checked'] = true;
        }
    }
@endphp

{{-- Checkbox tiene estructura diferente --}}
@if ($isCheckbox)
    <div class="form-group checkbox-group">
        <label for="{{ $inputId }}" class="checkbox-label">
            <input {!! implode(
                ' ',
                array_map(fn($k, $v) => is_bool($v) ? $k : "$k=\"$v\"", array_keys($inputAttributes), $inputAttributes),
            ) !!}>
            <span class="checkbox-text">
                {{ $label }}
                @if ($required)
                    <span class="text-danger">*</span>
                @endif
            </span>
        </label>

        {{-- Texto de ayuda --}}
        @if ($help)
            <div class="form-text">{{ $help }}</div>
        @endif

        {{-- Error del checkbox --}}
        @error($errorField)
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    {{-- Radio buttons --}}
@elseif($isRadio)
    <div class="form-group">
        @if ($label)
            <span class="form-label">
                {{ $label }}
                @if ($required)
                    <span class="text-danger">*</span>
                @endif
            </span>
        @endif

        @foreach ($options as $optionValue => $optionLabel)
            <div class="checkbox-group">
                <label for="{{ $inputId }}_{{ $loop->index }}" class="checkbox-label">
                    <input type="radio" @if (!$isLivewireForm) name="{{ $name }}" @endif
                        id="{{ $inputId }}_{{ $loop->index }}" value="{{ $optionValue }}"
                        class="checkbox-input {{ $hasError ? 'error' : '' }}"
                        @if (!$isLivewireForm && $currentValue == $optionValue) checked @endif
                        @if ($required) required @endif
                        @if ($disabled || $loading) disabled @endif
                        @if ($livewire) wire:model.{{ $livewireModifier }}="{{ $livewire }}" @endif
                        @if ($alpine) x-model="{{ $alpine }}" @endif>
                    <span class="checkbox-text">{{ $optionLabel }}</span>
                </label>
            </div>
        @endforeach

        {{-- Texto de ayuda --}}
        @if ($help)
            <div class="form-text">{{ $help }}</div>
        @endif

        {{-- Error de radio --}}
        @error($errorField)
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    {{-- Todos los demás tipos (text, email, password, textarea, select, etc) --}}
@else
    <div class="form-group">
        {{-- Label --}}
        @if ($label)
            <label for="{{ $inputId }}" class="form-label">
                {{ $label }}
                @if ($required)
                    <span class="text-danger">*</span>
                @endif
            </label>
        @endif

        {{-- Input Group con icono --}}
        @if ($icon)
            <div class="input-group">
                <span class="input-group-text">
                    @if (str_starts_with($icon, 'fa'))
                        <i class="{{ $icon }}"></i>
                    @else
                        {!! $icon !!}
                    @endif
                </span>
        @endif

        {{-- El Input según el tipo --}}
        @if ($isTextarea)
            <textarea {!! implode(
                ' ',
                array_map(fn($k, $v) => is_bool($v) ? $k : "$k=\"$v\"", array_keys($inputAttributes), $inputAttributes),
            ) !!} rows="{{ $rows }}">{{ !$isLivewireForm ? $currentValue : '' }}</textarea>
        @elseif($isSelect)
            <select {!! implode(
                ' ',
                array_map(fn($k, $v) => is_bool($v) ? $k : "$k=\"$v\"", array_keys($inputAttributes), $inputAttributes),
            ) !!} @if ($multiple) multiple @endif>
                @if (!$multiple && !$required)
                    <option value="">Selecciona una opción</option>
                @endif
                @foreach ($options as $optionValue => $optionLabel)
                    <option value="{{ $optionValue }}" @if (
                        !$isLivewireForm &&
                            ($currentValue == $optionValue || (is_array($currentValue) && in_array($optionValue, $currentValue)))) selected @endif>
                        {{ $optionLabel }}
                    </option>
                @endforeach
            </select>
        @else
            <input {!! implode(
                ' ',
                array_map(fn($k, $v) => is_bool($v) ? $k : "$k=\"$v\"", array_keys($inputAttributes), $inputAttributes),
            ) !!}>
        @endif

        {{-- Cerrar input group si hay icono --}}
        @if ($icon)
    </div>
@endif

{{-- Texto de ayuda --}}
@if ($help)
    <div class="form-text">{{ $help }}</div>
@endif

{{-- Mensajes de error --}}
@error($errorField)
    <span class="error-message">{{ $message }}</span>
@enderror
</div>
@endif

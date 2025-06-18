@props(['name', 'options' => [], 'selected' => null, 'label' => null]) <!--que nombre y valores recibir-->

<div>
    @if ($label)
        <label 
        for="{{ $name }}" 
        class="block font-medium text-sm text-gray-700 dark:text-gray-300"
        >
        {{ $label }}
        </label>
    @endif

    <!--Lista desplegable-->
    <select 
    name="{{ $name }}" 
    id="{{ $name }}" 
        {{ $attributes->
            merge
            (['class' => 
                'border-gray-300 
                dark:border-gray-700 dark:bg-gray-900 
                dark:text-gray-300 
                focus:border-indigo-500 
                dark:focus:border-indigo-600 
                focus:ring-indigo-500 
                dark:focus:ring-indigo-600 
                rounded-md 
                shadow-sm'
            ]) 
        }}
    > 

    <!--Recorrer arreglo para mostrar lista de opciones-->
        @foreach ($options as $value => $text)
            <option value="{{ $value }}" @if($value == old($name, $selected)) selected @endif>
                {{ $text }}
            </option>
        @endforeach
        
    </select>
</div>

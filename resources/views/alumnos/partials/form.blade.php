<div class="py-4 px-6 max-w-3xl">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-2 gap-y-4">
        <!-- Columna izquierda -->
        <div>
            <x-input-label value="Nombre" for="nombre_alumno" />
            <x-text-input type="text" name="nombre_alumno" :value="old('nombre_alumno', $alumno->nombre_alumno ?? '')" required autofocus />
        </div>
        <div>
            <x-input-label value="Apellido Paterno" for="apellido_paterno" />
            <x-text-input type="text" name="apellido_paterno" :value="old('apellido_paterno', $alumno->apellido_paterno ?? '')" required />
        </div>

        <div>
            <x-input-label value="Apellido Materno" for="apellido_materno" />
            <x-text-input type="text" name="apellido_materno" :value="old('apellido_materno', $alumno->apellido_materno ?? '')" />
        </div>
        <div>
            <x-input-label value="Edad" for="edad" />
            <x-text-input type="number" name="edad" :value="old('edad', $alumno->edad ?? '')" required />
        </div>

        <div>
            <x-input-label for="rut" value="RUT" />
            <x-text-input id="rut" name="rut" type="text" :value="old('rut', $alumno->rut ?? '')" required
                placeholder="Ej: 12345678-9" pattern="^\d{7,8}-[0-9kK]{1}$"
                title="Ingrese un RUT válido sin puntos, con guion y dígito verificador" class="w-full" />
        </div>

        <div>
            <x-input-label value="Nivel" for="nivel" />
            <x-text-input type="text" name="nivel" :value="old('nivel', $alumno->nivel ?? '')" />
        </div>

        <div>
            <x-input-label value="Grado" for="grado" />
            <x-text-input type="text" name="grado" :value="old('grado', $alumno->grado ?? '')" />
        </div>
        <div>
            <x-input-label value="Estado" for="estado" />
            <x-text-input type="text" name="estado" :value="old('estado', $alumno->estado ?? '')" />
        </div>

        <div class="col-span-2">
            <x-input-label value="Contacto" for="contacto" />
            <x-text-input type="text" name="contacto" :value="old('contacto', $alumno->contacto ?? '')" />
        </div>

        <div class="col-span-">
            <x-input-label value="Comentario" for="comentario" />
            <textarea name="comentario" rows="3"
                class="w-full rounded-md border-gray-300 bg-white dark:bg-white text-gray-900 dark:text-gray-900 focus:ring focus:ring-indigo-200">{{ old('comentario', $alumno->comentario ?? '') }}</textarea>
        </div>
    </div>
</div>

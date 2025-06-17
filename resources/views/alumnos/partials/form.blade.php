<div class="py-4 px-6 max-w-3xl">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-2 gap-y-4">

        <!-- Columna izquierda -->
         <!--NOMBRE-->
        <div>
            <x-input-label value="Nombre" for="nombre_alumno" />
            <x-text-input type="text" name="nombre_alumno" :value="old('nombre_alumno', $alumno->nombre_alumno ?? '')" required autofocus />
        </div>
        <!--APELLIDO PATERNO-->
        <div>
            <x-input-label value="Apellido Paterno" for="apellido_paterno" />
            <x-text-input type="text" name="apellido_paterno" :value="old('apellido_paterno', $alumno->apellido_paterno ?? '')" required />
        </div>

        <!--APELLIDO MATERNO-->
        <div>
            <x-input-label value="Apellido Materno" for="apellido_materno" />
            <x-text-input type="text" name="apellido_materno" :value="old('apellido_materno', $alumno->apellido_materno ?? '')" />
        </div>

        <!--EDAD-->
        <div>
            <x-input-label value="Edad" for="edad" />
            <x-text-input type="number" name="edad" :value="old('edad', $alumno->edad ?? '')" required />
        </div>

        <!--RUT-->
        <div>
            <x-input-label value="RUT" for="rut" />
            <x-text-input type="text" name="rut" :value="old('rut', $alumno->rut ?? '')" required />
        </div>

        <!--LISTA NIVELES-->
        <x-select name="nivel" label="Nivel" :options="[
            '' => 'Selecciona un nivel',
            'junior' =>'Junior', 
            'basico' => 'Básico', 
            'intermedio' => 'Intermedio', 
            'avanzado' => 'Avanzado', 
            'faja_negra' => 'Faja Negra', 
            'sanda' => 'Sanda']"
        :selected="old('nivel', $alumno->nivel ?? '')" />

        <!--LISTA GRADOS-->
        <x-select name="grado" label="Grado" :options="[
            '' => 'Selecciona un grado',
            'tiger_blanco' => 'Tiger Blanco', 
            'tiger_amarillo' => 'Tiger Amarillo', 
            'tiger_verde' => 'Tiger Verde', 
            'tiger_violeta' => 'Tiger Violeta', 
            'tiger_rojo' => 'Tiger Rojo', 
            'amarillo_jr'=> 'Amarillo Junior', 
            'dorado_jr' => 'Dorado Junior', 
            'naranjo_jr' => 'Naranjo Junior', 
            'jade_jr' => 'Jade Junior', 
            'verde_jr' => 'Verde Junior', 
            'violeta_jr' => 'Violeta Junior', 
            'azul_jr' => 'Azul Junior', 
            'rojo_jr' => 'Rojo Junior', 
            'cafe_jr' => 'Café Junior', 
            'cafe_av_jr' => 'Café av Junior', 
            'amarillo' =>'Amarillo', 
            'dorado' => 'Dorado', 
            'naranjo' => 'Naranjo', 
            'jade' => 'Jade', 
            'verde' => 'Verde', 
            'violeta' => 'Violeta', 
            'azul' => 'Azul', 
            'rojo' => 'Rojo', 
            'cafe' => 'Café', 
            'cafe_avanzado' => 'Café Avanzado', 
            'negro' => 'Negro', 
            'negro_I' => 'Negro I', 
            'negro_II' => 'Negro II', 
            'negro_III' => 'Negro III']" 
        :selected="old('grado', $alumno->grado ?? '')" />

        <!--ESTADO-->
        <div>
            <x-select name="estado" label="Estado" :options="[
                '' => 'Selecciona estado',
                'activo'=>'Activo', 
                'congelado' => 'Congelado', 
                'baja' => 'Baja']"
            :selected="old('estado',$alumno->estado ?? '')">

            </x-select>

        <!--CONTACTO-->
        <div class="col-span-2">
            <x-input-label value="Contacto" for="contacto" />
            <x-text-input type="text" name="contacto" :value="old('contacto', $alumno->contacto ?? '')" />
        </div>

        <!--COMENTARIOS-->
        <div class="col-span-">
            <x-input-label value="Comentario" for="comentario" />
            <textarea name="comentario" rows="3" class="w-full rounded-md border-gray-300 bg-white dark:bg-white text-gray-900 dark:text-gray-900 focus:ring focus:ring-indigo-200">{{ old('comentario', $alumno->comentario ?? '') }}</textarea>
        </div>
    </div>
</div>

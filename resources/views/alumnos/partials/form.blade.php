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
            <x-input-label for="rut" value="RUT" />
            <x-text-input id="rut" name="rut" type="text" :value="old('rut', $alumno->rut ?? '')" required
                placeholder="Ej: 12345678-9" pattern="^\d{7,8}-[0-9kK]{1}$"
                title="Ingrese un RUT válido sin puntos, con guion y dígito verificador" />
        </div>
    
        <!--CONTACTO-->
        <div>
            <x-input-label value="Contacto" for="contacto" />
            <x-text-input type="text" name="contacto" :value="old('contacto', $alumno->contacto ?? '')" />
        </div>


        <!--LISTA NIVELES-->
         <div>
            <x-select name="nivel" label="Nivel" :options="[
            '' => 'Selecciona un nivel',
            'junior' =>'Junior', 
            'basico' => 'Básico', 
            'intermedio' => 'Intermedio', 
            'avanzado' => 'Avanzado', 
            'faja_negra' => 'Faja Negra', 
            'sanda' => 'Sanda']"
        :selected="old('nivel', $alumno->nivel ?? '')" />
         </div>
        

        <!--LISTA GRADOS-->
         <div>
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
         </div>
        

        <!--ESTADO-->
        <div>
            <x-select name="estado" label="Estado" :options="[
                '' => 'Selecciona estado',
                'activo'=>'Activo', 
                'congelado' => 'Congelado', 
                'baja' => 'Baja']"
            :selected="old('estado',$alumno->estado ?? '')"/>
        </div>

        <!--PLAN-->
        <!--Se crea un arreglo nombre_plan - id para las opciones-->
            <!--Esto prepara AlpineJS para manejar los datos del plan seleccionado y rellenar los campos.-->
           <div 
                x-data="() => ({
                    mostrar: false,
                    planes: {{ Js::from($planes) }},
                    selectedPlan: null,
                    duracion: '',
                    cuotas: '',
                    monto: '',
                    pagoInicial: '',
                    cuotasList: [],
                    diaPago: 1,

                    generarCuotas() {
                        this.cuotasList = Array.from({ length: this.cuotas }, (_, i) => {
                            const hoy = new Date();
                            const dia = parseInt(this.diaPago) || 5;

                            const fecha = new Date(hoy.getFullYear(), hoy.getMonth() + i, 1);
                            const maxDias = new Date(fecha.getFullYear(), fecha.getMonth() + 1, 0).getDate();
                            fecha.setDate(Math.min(dia, maxDias));

                            return {
                                numero: i + 1,
                                fecha: fecha.toISOString().split('T')[0],
                                monto: this.monto
                            };
                        });
                    },

                    actualizarCampos(planId) {
                        if (!planId) {
                            this.mostrar = false;
                            return;
                        }

                        const plan = this.planes.find(p => p.id == planId);
                        if (plan) {
                            this.selectedPlan = plan;
                            this.duracion = plan.duracion_meses;
                            this.cuotas = plan.duracion_meses;
                            this.monto = plan.monto_base_mensual;
                            this.pagoInicial = plan.pago_inicial;
                            this.generarCuotas();
                            this.mostrar = true;
                        }
                    },

                    totalCuotas() {
                        return this.cuotasList.reduce((suma, c) => suma + Number(c.monto || 0), 0);
                    }
                        

                })"
                >
                
                <!--SELECCIÓN DE PLAN-->
                <x-select
                    name="plan_id"
                    x-ref="planSelect"
                    label="Plan"
                    :options="$planes->pluck('nombre_plan', 'id')->prepend('Selecciona un plan', '')->toArray()"
                    :selected="old('plan_id', optional($alumno?->alumnoPlan)->plan_id)"
                    @change="actualizarCampos($event.target.value)"
                />

                <!--Genera las cuotas cada vez que cambia el monto -->
                <div x-effect="if (cuotasList.length && monto) generarCuotas()"></div>

                <div x-effect="if (cuotas) duracion = cuotas"></div>


               

                <!--TABLA DE PERSONALIZACIÓN -->
                <div x-show="mostrar" class="mt-4 p-4 border border-gray-700 rounded bg-gray-800">
                    <h3 class="text-lg font-bold mb-2 text-white">Detalles del contrato</h3>

                    <div class="grid grid-cols-2 gap-4">
                        

                        <div>
                            <label class="text-white">N° cuotas/meses</label>
                            <input type="number" name="num_cuotas" x-model="cuotas" @change="generarCuotas()" class="w-full rounded p-1" />
                        </div>

                        <div>
                            <label class="text-white">Monto cuota</label>
                            <input type="number" name="monto_cuota" x-model="monto" class="w-full rounded p-1" />
                        </div>

                        <div>
                            <label class="text-white">Pago inicial</label>
                            <input type="number" name="pago_inicial" x-model="pagoInicial" class="w-full rounded p-1" />
                        </div>
                        <div>
                            <label class="text-white">Día de pago</label>
                            <input type="number" min="1" max="28" x-model="diaPago" class="w-full rounded p-1" />
                        </div>

                    </div>

                    <!--TABLA DE CUOTAS-->
                    <div x-show="cuotasList.length > 0" class="mt-4 overflow-x-auto">
                        <h4 class="text-white text-lg mb-2">Detalle de cuotas</h4>
                        <table class="table-auto table-fixed w-full text-white bg-gray-900 rounded">
                            <thead>
                                <tr>

                                    <th class="border w-1/8 px-2 ">N°</th>
                                    <th class="border w-3/6 px-2">Fecha</th>
                                    <th class="border w-2/6 px-2">Monto</th>

                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="cuota in cuotasList" :key="cuota.numero">
                                    <tr>
                                        <td class="border px-2 py-1 text-center" x-text="cuota.numero"></td>
                                        <td class="border px-2 py-1">
                                            <input type="date" x-model="cuota.fecha" class="w-full rounded bg-gray-800 text-white border-gray-600">
                                        </td>
                                        <td class="border px-2 py-1">
                                            <input type="number" x-model="cuota.monto" class="w-full text-right pr-2 rounded bg-gray-800 text-white border-gray-600">
                                        </td>
                                    </tr>
                                </template>
                                <!--SUMA TOTAL DE CUOTAS-->
                                <tr class="bg-gray-900 font-bold text-white">
                                    <td colspan="2" class="text-right font-bold pr-4">Total:</td>
                                    <td>
                                        <input type="text" class="w-full text-right bg-transparent border-none" :value="totalCuotas().toLocaleString()" readonly />
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>

        
        <!--COMENTARIOS-->
        <div>
            <x-input-label value="Comentario" for="comentario" />
            <textarea name="comentario" rows="3"
                class="w-full rounded-md border-gray-300 bg-white dark:bg-white text-gray-900 dark:text-gray-900 focus:ring focus:ring-indigo-200">{{ old('comentario', $alumno->comentario ?? '') }}</textarea>
        </div>

    </div> 
</div>


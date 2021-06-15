<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Módulo de Reportes
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg text-gray-900">Crear un Reporte</h3>
                            <p class="text-sm text-gray-500">(*) Campos Requeridos</p>
                        </div>
                    </div>
                    <div class="md:col-span-2 mt-5 md:mt-0">
                        <div class="shadow bg-white md:rounded-md p-4">
                            <form @submit.prevent="storeData">
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <jet-label for="fecha" value="Fecha (*)" />
                                        <span class="text-lg font-extrabold">{{  form.fecha_mostrar }}</span>
                                    </div>
                                    <div class="col-span-2">
                                        <jet-label for="observacion" value="Observación (*)" />
                                        <textarea required v-model="form.observacion" class="border-gray-300 focus:border-indigo-300 w-full focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
                                        <jet-input-error :message="errors.observacion" class="mt-2" />
                                    </div>
                                </div>
                                <div class="flex justify-end gap-2 mt-2 items-center">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white rounded p-3 font-bold">
                                        Crear
                                    </button>
                                    <inertia-link class="text-blue-400 hover:text-blue-600 underline" :href="route('reporte.index')">
                                        Volver
                                    </inertia-link>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import { ref } from 'vue'
    import { Inertia } from '@inertiajs/inertia'
    import JetInputError from '@/Jetstream/InputError'
    import JetInput from '@/Jetstream/Input'
    import JetLabel from '@/Jetstream/Label'


    export default {
        components: {
            AppLayout,
            JetInputError,
            JetInput,
            JetLabel,
        },
        props: {
            errors: Object,
            fecha : String
        },
        setup(props) {
            
                const form =  ref({
                    observacion : null,
                    fecha : props.fecha,
                    fecha_mostrar : props.fecha,
                });

                const storeData = () => {
                    if(form.value.h_anterior > form.value.hs_maquina){
                        props.errors.h_anterior = 'Las horas debe ser mayor a la hora anterior.';
                    }else{
                        Inertia.post(route('storeReporteNA'), {...form.value})
                    }
                        
                }


                return {form,storeData}
        }
    }

</script>


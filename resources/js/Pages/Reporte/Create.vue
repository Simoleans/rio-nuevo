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
                                        <jet-label for="maquina" value="Maquina (*)" />
                                        <Select2 v-model="form.maquina_id" :options="maquinaOpt" :settings="{ dropdownAutoWidth: true,width: '100%' }"/>
                                        <jet-input-error :message="errors.maquina_id" class="mt-2" />
                                    </div>
                                    <div>
                                        <jet-label for="fecha" value="Fecha (*)" />
                                        <span class="text-lg font-extrabold">{{  form.fecha_mostrar }}</span>
                                    </div>
                                    <div>
                                        <jet-label for="tipo_cultivo" value="T. Cultivo (*)" />
                                        <Select2 required v-model="form.tipo_cultivo_id" :options="tipo_cultivoOpt" :settings="{ dropdownAutoWidth: true,width: '100%' }"/>
                                        <jet-input-error :message="errors.tipo_cultivo_id" class="mt-2" />
                                    </div>
                                    <div>
                                        <jet-label for="variedad" value="Variedad (*)" />
                                        <Select2 required v-model="form.variedad_id" :options="variedadOpt" :settings="{ dropdownAutoWidth: true,width: '100%' }"/>
                                        <jet-input-error :message="errors.variedad_id" class="mt-2" />
                                    </div>
                                    <div class="grid grid-cols-3 col-span-2 gap-3">
                                        <div>
                                            <jet-label for="tipo_bandeja35" value="T. Bandeja de 3.5 (*)" />
                                            <jet-input required id="tipo_bandeja35" type="number" :errors="errors.tipo_bandeja35" class="mt-1 block w-full" v-model="tipo.tipo_bandeja35"/>
                                            <jet-input-error :message="errors.tipo_bandeja35" class="mt-2" />
                                        </div>
                                        <div>
                                            <jet-label for="tipo_bandeja7" value="T. Bandeja de 7 (*)" />
                                            <jet-input required id="tipo_bandeja7" type="number" :errors="errors.tipo_bandeja7" class="mt-1 block w-full" v-model="tipo.tipo_bandeja7"/>
                                            <jet-input-error :message="errors.tipo_bandeja7" class="mt-2" />
                                        </div>
                                        <div>
                                            <jet-label for="tipo_bandeja14" value="T. Bandeja de 14(*)" />
                                            <jet-input required id="tipo_bandeja14" type="number" :errors="errors.tipo_bandeja14" class="mt-1 block w-full" v-model="tipo.tipo_bandeja14"/>
                                            <jet-input-error :message="errors.tipo_bandeja14" class="mt-2" />
                                        </div>
                                    </div>
                                    <div>
                                        <jet-label for="kg_totales" value="Kgs. Totales (*)" />
                                        <jet-input required id="kg_totales" type="number" step="0.01" :errors="errors.kg_totales" class="mt-1 block w-full" v-model="form.kg_totales"/>
                                        <a class="text-xs text-blue-400 cursor-pointer" @click="copyKgTeorico">Copiar KG TEORICO</a>
                                        <jet-input-error :message="errors.kg_totales" class="mt-2" />
                                    </div>
                                    <div>
                                        <jet-label for="kg_teoricos" value="Kgs. Teoricos (*)" />
                                        <jet-input required id="kg_teoricos" type="number" readonly :errors="errors.kg_teoricos" class="mt-1 block w-full" v-model="form.kg_teoricos"/>
                                        <jet-input-error :message="errors.kg_teoricos" class="mt-2" />
                                    </div>
                                    <div>
                                        <jet-label for="productor" value="Productor (*)" />
                                        <Select2 required v-model="form.productor_id" :options="productorOpt" :settings="{ dropdownAutoWidth: true,width: '100%' }"/>
                                        <jet-input-error :message="errors.productor_id" class="mt-2" />
                                    </div>
                                    <div class="tooltip">
                                        <jet-label for="campo" value="Campo (*)" />
                                        <Select2 required v-model="form.campo_id" :options="campoOpt" :settings="{ dropdownAutoWidth: true,width: '100%' }"/>
                                        <jet-input-error :message="errors.campo_id" class="mt-2" />
                                        <span class="tooltiptext">El Campo y Productor lo debe ver en el acta de movilización del SAG</span>
                                    </div>
                                    <div>
                                        <jet-label for="hs_maquina" value="Hs. Maquina (*)" />
                                        <jet-input id="hs_maquina" type="number" :errors="errors.hs_maquina" class="mt-1 block w-full" v-model="form.hs_maquina"/>
                                        <jet-input-error :message="errors.hs_maquina" class="mt-2" />
                                    </div>
                                    <div>
                                        <jet-label for="h_anterior" value="Hora Anterior (*)" />
                                        <jet-input id="h_anterior" readonly type="number" :errors="errors.h_anterior" class="mt-1 bg-gray-200 block w-full" v-model="form.h_anterior"/>
                                        <jet-input-error :message="errors.h_anterior" class="mt-2" />
                                    </div>
                                    <div class="col-span-2">
                                        <jet-label for="observacion" value="Observación" />
                                        <textarea v-model="form.observacion" class="border-gray-300 focus:border-indigo-300 w-full focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
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
    import { ref, watch } from 'vue'
    import { Inertia } from '@inertiajs/inertia'
    import JetInputError from '@/Jetstream/InputError'
    import JetInput from '@/Jetstream/Input'
    import JetLabel from '@/Jetstream/Label'
    import Select2 from 'vue3-select2-component';


    export default {
        components: {
            AppLayout,
            JetInputError,
            JetInput,
            JetLabel,
            Select2,
        },
        props: {
            errors: Object,
            productor : Object,
            campo : Object,
            maquina : Object,
            tipo_cultivo : Object,
            variedad : Object,
            fecha : String
        },
        setup(props) {
            
                const form =  ref({
                    cuartel: null,
                    variedad_id: null,
                    maquina_id: null,
                    campo_id: null,
                    productor_id: null,
                    tipo_cultivo_id: null,
                    kg_totales : null,
                    kg_teoricos : null,
                    hs_maquina : null,
                    observacion : null,
                    fecha : props.fecha,
                    fecha_mostrar : props.fecha,
                    h_anterior : null
                });

                const tipo =  ref({
                    tipo_bandeja35 : null,
                    tipo_bandeja7 : null,
                    tipo_bandeja14 : null,
                    
                });

                const productorOpt = [];
                const campoOpt = ref([]);
                const maquinaOpt = [];
                const variedadOpt = ref([]);
                const tipo_cultivoOpt = [];

                const copyKgTeorico = () => {
                    form.value.kg_totales = form.value.kg_teoricos;
                }

                watch(tipo.value, (v) => {
                    form.value.kg_teoricos = (v.tipo_bandeja35 * 3.5) + (v.tipo_bandeja7 * 7) + (v.tipo_bandeja14 * 14);
                    
                });

                watch(
                    () => form.value.maquina_id,
                    (v) => {
                        fetch(route('hAnterior',v))
                            .then(res => res.json())
                            .catch(error => console.error('Error:', error))
                            .then(response => form.value.h_anterior = response.hs_maquina ?? 0);
                    }
                )

                watch(
                    () => form.value.tipo_cultivo_id,
                    (v) => {
                        fetch(route('variedad_cultivo',v))
                            .then(res => res.json())
                            .catch(error => console.error('Error:', error))
                            .then(response => {
                                variedadOpt.value = [];
                                response.forEach( function(element) {
                                    variedadOpt.value.push({'id' : element.id,'text' : element.nombre})
                                });
                            });
                    }
                )

                watch(
                    () => form.value.productor_id,
                    (v) => {
                        fetch(route('productor_campo',v))
                            .then(res => res.json())
                            .catch(error => console.error('Error:', error))
                            .then(response => {
                                campoOpt.value = [];
                                response.forEach( function(element) {
                                    campoOpt.value.push({'id' : element.id,'text' : element.nombre})
                                });
                            });
                    }
                )

                props.productor.forEach( function(element) {
                    productorOpt.push({'id' : element.id,'text' : element.razon_social})
                });

                props.maquina.forEach( function(element) {
                    maquinaOpt.push({'id' : element.id,'text' : element.nombre})
                });

                props.tipo_cultivo.forEach( function(element) {
                    tipo_cultivoOpt.push({'id' : element.id,'text' : element.nombre})
                });


                const storeData = () => {
                    if(form.value.h_anterior > form.value.hs_maquina){
                        props.errors.h_anterior = 'Las horas debe ser mayor a la hora anterior.';
                    }else{
                        Inertia.post('/reporte', {...form.value,...tipo.value})
                    }
                        
                }

                // const validateDate = (d) => {
                //     Inertia.post('/report/validate/date', {date : d}, 
                //     {
                //         preserveState : true,
                //         preserveScroll: true,
                //         onSuccess: () => {
                //             form.value.fecha = d
                //         }
                //     });
                // }

                return {form,storeData,productorOpt,campoOpt,maquinaOpt,variedadOpt,tipo_cultivoOpt,copyKgTeorico,tipo}
        }
    }

</script>
<style>
    .select2-container .select2-selection--single {
        height: 38px !important;
        padding-top: 3px;
    }
    .tooltip {
        position: relative;
        display: inline-block;
        /* border-bottom: 1px dotted black; */
    }

    .tooltip .tooltiptext {
        visibility: hidden;
        width: 160px;
        background-color: #555;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px 0;
        position: absolute;
        z-index: 1;
        bottom: 90%;
        left: 50%;
        margin-left: -70px;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .tooltip .tooltiptext::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #555 transparent transparent transparent;
    }

    .tooltip:hover .tooltiptext {
        visibility: visible;
        opacity: 1;
    }
</style>


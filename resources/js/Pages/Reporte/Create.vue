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
                                        <jet-label for="campo" value="Maquina (*)" />
                                        <Select2 v-model="form.maquina" :options="maquinaOpt" :settings="{ dropdownAutoWidth: true,width: '100%' }"/>
                                        <jet-input-error :message="errors.campo" class="mt-2" />
                                    </div>
                                    <div>
                                        <jet-label for="tipo_cultivo" value="T. Cultivo (*)" />
                                        <Select2 required v-model="form.tipo_cultivo" :options="tipo_cultivoOpt" :settings="{ dropdownAutoWidth: true,width: '100%' }"/>
                                        <jet-input-error :message="errors.tipo_cultivo" class="mt-2" />
                                    </div>
                                </div>
                                <jet-label for="variedad" value="Variedad (*)" />
                                <Select2 required v-model="form.variedad" :options="variedadOpt" :settings="{ dropdownAutoWidth: true,width: '100%' }"/>
                                <jet-input-error :message="errors.variedad" class="mt-2" />
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <jet-label for="tipo_bandeja" value="T. Bandeja (*)" />
                                        <select :class="{ ' border border-red-500' : errors.tipo_bandeja }" class="border-gray-300 w-full focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1" v-model="form.tipo_bandeja">
                                            <option value="">Seleccione...</option>
                                            <option v-for="option in tipo_bandejaOpt" :value="option.id" :key="option.id">
                                                {{ option.text }}
                                            </option>
                                        </select>
                                        <jet-input-error :message="errors.tipo_bandeja" class="mt-2" />
                                    </div>

                                    <div>
                                        <jet-label for="cuartel" value="Cuartel (*)" />
                                        <jet-input required id="cuartel" type="number" :errors="errors.cuartel" class="mt-1 block w-full" v-model="form.cuartel"/>
                                        <jet-input-error :message="errors.cuartel" class="mt-2" />
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-3">
                                    <div>
                                        <jet-label for="nro_bandeja" value="Nro . Bandejas (*)" />
                                        <jet-input required id="nro_bandeja" type="number" :errors="errors.nro_bandeja" class="mt-1 block w-full" v-model="form.nro_bandeja"/>
                                        <jet-input-error :message="errors.nro_bandeja" class="mt-2" />
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
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <jet-label for="productor" value="Productor (*)" />
                                        <Select2 required v-model="form.productor" :options="productorOpt" :settings="{ dropdownAutoWidth: true,width: '100%' }"/>
                                        <jet-input-error :message="errors.productor" class="mt-2" />
                                    </div>
                                    <div>
                                        <jet-label for="campo" value="Campo (*)" />
                                        <Select2 required v-model="form.campo" :options="campoOpt" :settings="{ dropdownAutoWidth: true,width: '100%' }"/>
                                        <jet-input-error :message="errors.campo" class="mt-2" />
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-3">
                                    <div>
                                        <jet-label for="petroleo" value="Petróleo (*)" />
                                        <jet-input required id="petroleo" type="number" :errors="errors.petroleo" class="mt-1 block w-full" v-model="form.petroleo"/>
                                        <jet-input-error :message="errors.petroleo" class="mt-2" />
                                    </div>
                                    <div>
                                        <jet-label for="hs_maquina" value="Hs. Maquina (*)" />
                                        <jet-input required id="hs_maquina" type="number" :errors="errors.hs_maquina" class="mt-1 block w-full" v-model="form.hs_maquina"/>
                                        <jet-input-error :message="errors.hs_maquina" class="mt-2" />
                                    </div>
                                    <div>
                                        <jet-label for="hectareas" value="Hectáreas (*)" />
                                        <jet-input required id="hectareas" type="number" :errors="errors.hectareas" class="mt-1 block w-full" v-model="form.hectareas"/>
                                        <jet-input-error :message="errors.hectareas" class="mt-2" />
                                    </div>
                                </div>
                                <jet-label for="observacion" value="Observación (*)" />
                                <textarea v-model="form.observacion" class="border-gray-300 focus:border-indigo-300 w-full focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
                                <jet-input-error :message="errors.observacion" class="mt-2" />
                                
                                <div class="flex justify-end gap-2 mt-2 items-center">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white rounded p-3 font-bold">
                                        Crear
                                    </button>
                                    <inertia-link class="text-blue-400 hover:text-blue-600 underline" :href="route('machine.index')">
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
    import SelectInput from '@/components/SelectInput'

    

    export default {
        components: {
            AppLayout,
            JetInputError,
            JetInput,
            JetLabel,
            Select2,
            SelectInput
        },
        props: {
            errors: Object,
            productor : Object,
            campo : Object,
            maquina : Object,
            tipo_cultivo : Object,
            variedad : Object
        },
        setup(props) {
                const form =  ref({
                    cuartel: null,
                    variedad: null,
                    maquina: null,
                    campo: null,
                    productor : null,
                    tipo_cultivo : null,
                    tipo_bandeja : null,
                    kg_totales : null,
                    kg_teoricos : null,
                    nro_bandeja : null,
                    hectareas : null,
                    petroleo : null,
                    hs_maquina : null,
                    observacion : null,
                });

                const productorOpt = [];
                const campoOpt = [];
                const maquinaOpt = [];
                const variedadOpt = [];
                const tipo_cultivoOpt = [];

                const tipo_bandejaOpt = [{
                    'id' : 3.5,
                    'text' : 3.5
                },
                {
                    'id' : 7,
                    'text' : 7
                },
                {
                    'id' : 14,
                    'text' : 14
                }]

                const copyKgTeorico = () => {
                    form.value.kg_totales = form.value.kg_teoricos;
                }

                watch(form.value, (v) => {
                    v.kg_teoricos = v.nro_bandeja * v.tipo_bandeja;
                });

                props.productor.forEach( function(element) {
                    productorOpt.push({'id' : element.razon_social,'text' : element.razon_social})
                });

                props.campo.forEach( function(element) {
                    campoOpt.push({'id' : element.nombre,'text' : element.nombre})
                });

                props.maquina.forEach( function(element) {
                    maquinaOpt.push({'id' : element.nombre,'text' : element.nombre})
                });

                props.variedad.forEach( function(element) {
                    variedadOpt.push({'id' : element.nombre,'text' : element.nombre})
                });

                props.tipo_cultivo.forEach( function(element) {
                    tipo_cultivoOpt.push({'id' : element.nombre,'text' : element.nombre})
                });


                const storeData = () => {
                        Inertia.post('/reporte', {...form.value})
                }

                return {form,storeData,productorOpt,campoOpt,maquinaOpt,variedadOpt,tipo_cultivoOpt,tipo_bandejaOpt,copyKgTeorico}
        }
    }

</script>
<style>
    .select2-container .select2-selection--single {
        height: 38px !important;
        padding-top: 3px;
    }
</style>


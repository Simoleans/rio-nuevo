<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Módulo de Notas
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg text-gray-900">Editar Maquina</h3>
                            <p class="text-sm text-gray-500">(*) Campos Requeridos</p>
                        </div>
                    </div>
                    <div class="md:col-span-2 mt-5 md:mt-0">
                        <div class="shadow bg-white md:rounded-md p-4">
                            <form @submit.prevent="updateData">
                                <jet-label for="productor" value="Productor (*)" />
                                <Select2 required v-model="form.productor" :options="productorOpt" :settings="{ dropdownAutoWidth: true,width: '100%' }"/>
                                <jet-input-error :message="errors.productor" class="mt-2" />

                                <jet-label for="campo" value="Campo (*)" />
                                <Select2 required v-model="form.campo" :options="campoOpt" :settings="{ dropdownAutoWidth: true,width: '100%' }"/>
                                <jet-input-error :message="errors.campo" class="mt-2" />

                                <jet-label for="campo" value="Maquina (*)" />
                                <Select2 v-model="form.maquina" :options="maquinaOpt" :settings="{ dropdownAutoWidth: true,width: '100%' }"/>
                                <jet-input-error :message="errors.campo" class="mt-2" />

                                <jet-label for="fecha_inicio" value="Fecha Inicio (*)" />
                                <jet-input required id="fecha_inicio" type="date" :errors="errors.fecha_inicio" class="mt-1 block w-full" v-model="form.fecha_inicio"/>
                                <jet-input-error :message="errors.fecha_inicio" class="mt-2" />
                                <p v-show="errorDate" class="text-sm text-red-600">
                                    La Fecha de Inicio no debe ser mayor a la fecha final.
                                </p>

                                <jet-label for="fecha_final" value="Fecha Final (*)" />
                                <jet-input required id="fecha_final" type="date" :errors="errors.fecha_final" class="mt-1 block w-full" v-model="form.fecha_final"/>
                                <jet-input-error :message="errors.fecha_final" class="mt-2" />

                                <div class="flex justify-end gap-2 mt-2 items-center">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white rounded p-3 font-bold">
                                        Editar
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
    import { reactive } from 'vue'
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
            Select2
        },
        props: {
            errors: Object,
            faena : Object,
            productor : Object,
            campo : Object,
            maquina : Object
        },
        setup(props) {
                const form =  reactive({
                    fecha_final: props.faena.fecha_final,
                    fecha_inicio: props.faena.fecha_inicio,
                    maquina: props.faena.maquina,
                    campo: props.faena.campo,
                    productor : props.faena.productor
                });

                const productorOpt = [];
                const campoOpt = [];
                const maquinaOpt = [];

                props.productor.forEach( function(element) {
                    productorOpt.push({'id' : element.razon_social,'text' : element.razon_social})
                });

                props.campo.forEach( function(element) {
                    campoOpt.push({'id' : element.nombre,'text' : element.nombre})
                });

                props.maquina.forEach( function(element) {
                    maquinaOpt.push({'id' : element.nombre,'text' : element.nombre})
                });


                const updateData = () => {
                    if (form.fecha_inicio > form.fecha_final) {
                        props.errors.fecha_inicio = 'La fecha de inicio no debe ser mayor a la fecha final.';
                    }else{
                        Inertia.put(route('faena.update',props.faena.id), {...form});
                    }
                }

                return {form,updateData,productorOpt,campoOpt,maquinaOpt}
        }
    }
</script>
<style>
    .select2-container .select2-selection--single {
        height: 38px !important;
        padding-top: 3px;
    }
</style>

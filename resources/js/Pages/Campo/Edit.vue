<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Módulo de Campos
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg text-gray-900">Editar Tipo de Cultivo</h3>
                            <p class="text-sm text-gray-500">(*) Campos Requeridos</p>
                        </div>
                    </div>
                    <div class="md:col-span-2 mt-5 md:mt-0">
                        <div class="shadow bg-white md:rounded-md p-4">
                            <form @submit.prevent="updateData">
                                <jet-label for="nombre" value="Nombre (*)" />
                                <jet-input id="nombre" type="text" :errors="errors.nombre" class="mt-1 block w-full" v-model="form.nombre"/>
                                <jet-input-error :message="errors.nombre" class="mt-2" />

                                <jet-label for="productor" value="Productor (*)" />
                                <Select2 required v-model="form.productor_id" :options="productorOpt" :settings="{ dropdownAutoWidth: true,width: '100%' }"/>
                                <jet-input-error :message="errors.productor_id" class="mt-2" />

                                <jet-label for="localidad" value="Localidad (*)" />
                                <jet-input id="localidad" type="text" :errors="errors.localidad" class="mt-1 block w-full" v-model="form.localidad"/>
                                <jet-input-error :message="errors.localidad" class="mt-2" />

                                <div class="flex justify-end gap-2 mt-2 items-center">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white rounded p-3 font-bold">
                                        Editar
                                    </button>
                                    <inertia-link class="text-blue-400 hover:text-blue-600 underline" :href="route('campo.index')">
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
            campo : Object,
            productor : Object
        },
        setup(props) {
                const form =  reactive({
                    nombre: props.campo.nombre,
                    localidad: props.campo.localidad,
                    productor_id: props.campo.productor_id,
                });

                const productorOpt = [];

                props.productor.forEach( function(element) {
                    productorOpt.push({'id' : element.id,'text' : element.razon_social})
                });

                const updateData = () => {
                    Inertia.put(route('campo.update',props.campo.id), {...form});
                }

                return {form,updateData,productorOpt}
        }
    }

</script>
<style>
    .select2-container .select2-selection--single {
        height: 38px !important;
        padding-top: 3px;
    }
</style>

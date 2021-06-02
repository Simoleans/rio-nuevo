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
                                <jet-label for="nombre" value="Nombre (*)" />
                                <jet-input id="nombre" type="text" :errors="errors.nombre" class="mt-1 block w-full" v-model="form.nombre"/>
                                <jet-input-error :message="errors.nombre" class="mt-2" />

                                <jet-label for="marca" value="Marca (*)" />
                                <jet-input id="marca" type="text" :errors="errors.marca" class="mt-1 block w-full" v-model="form.marca"/>
                                <jet-input-error :message="errors.marca" class="mt-2" />

                                <jet-label for="modelo" value="Modelo (*)" />
                                <jet-input id="modelo" type="text" :errors="errors.modelo" class="mt-1 block w-full" v-model="form.modelo"/>
                                <jet-input-error :message="errors.modelo" class="mt-2" />

                                <jet-label for="tipo" value="Tipo (*)" />
                                <select-input :errors="errors.tipo" :model="form.tipo" :options="options" />
                                <jet-input-error :message="errors.tipo" class="mt-2" />

                                <jet-label for="year" value="Año (*)" />
                                <jet-input id="year" type="text" :errors="errors.year" class="mt-1 block w-full" v-model="form.year"/>
                                <jet-input-error :message="errors.year" class="mt-2" />

                                <jet-label for="serie" value="Serie (*)" />
                                <jet-input id="serie" type="text" :errors="errors.serie" class="mt-1 block w-full" v-model="form.serie"/>
                                <jet-input-error :message="errors.serie" class="mt-2" />

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
    import SelectInput from '@/components/SelectInput'
    

    export default {
        components: {
            AppLayout,
            JetInputError,
            JetInput,
            JetLabel,
            SelectInput
        },
        props: {
            errors: Object,
            machine : Object
        },
        setup(props) {
                const form =  reactive({
                    nombre: props.machine.nombre,
                    marca: props.machine.marca,
                    modelo: props.machine.modelo,
                    tipo: props.machine.tipo,
                    year: props.machine.year,
                    serie: props.machine.serie,
                });

                const options = [
                        { text: 'Normal', value: 'normal'},
                        { text: 'Arriendo', value: 'arriendo'}
                    ];

                const updateData = () => {
                    Inertia.put(route('machine.update',props.machine.id), {...form});
                }

                return {form,updateData,options}
        }
    }

</script>

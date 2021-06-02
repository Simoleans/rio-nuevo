<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Módulo de Variedades
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg text-gray-900">Editar Variedad</h3>
                            <p class="text-sm text-gray-500">(*) Campos Requeridos</p>
                        </div>
                    </div>
                    <div class="md:col-span-2 mt-5 md:mt-0">
                        <div class="shadow bg-white md:rounded-md p-4">
                            <form @submit.prevent="updateData">
                                <jet-label for="nombre" value="Nombre (*)" />
                                <jet-input id="nombre" type="text" :errors="errors.nombre" class="mt-1 block w-full" v-model="form.nombre"/>
                                <jet-input-error :message="errors.nombre" class="mt-2" />

                                <jet-label for="tipo_cultivo" value="T. Cultivo (*)" />
                                <select :class="{ ' border border-red-500' : errors.tipo_cultivo }" class="border-gray-300 w-full focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-2" v-model="form.tipo_cultivo">
                                    <option value="">Seleccione...</option>
                                    <option  v-for="tipo_cultivo in tipo_cultivos" :value="tipo_cultivo.nombre" :key="tipo_cultivo.id">
                                        {{ tipo_cultivo.nombre }}
                                    </option>
                                </select>
                                <jet-input-error :message="errors.tipo_cultivo" class="mt-2" />

                                <div class="flex justify-end gap-2 mt-2 items-center">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white rounded p-3 font-bold">
                                        Editar
                                    </button>
                                    <inertia-link class="text-blue-400 hover:text-blue-600 underline" :href="route('variedad.index')">
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
    

    export default {
        components: {
            AppLayout,
            JetInputError,
            JetInput,
            JetLabel,
        },
        props: {
            errors: Object,
            variedad : Object,
            tipo_cultivos : Object
        },
        setup(props) {
                const form =  reactive({
                    nombre: props.variedad.nombre,
                    tipo_cultivo : props.variedad.tipo_cultivo
                });

                const updateData = () => {
                    Inertia.put(route('variedad.update',props.variedad.id), {...form});
                }

                return {form,updateData}
        }
    }

</script>

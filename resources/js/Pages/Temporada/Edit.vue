<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Módulo de Temporadas
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg text-gray-900">Editar Temporada</h3>
                            <p class="text-sm text-gray-500">(*) Campos Requeridos</p>
                        </div>
                    </div>
                    <div class="md:col-span-2 mt-5 md:mt-0">
                        <div class="shadow bg-white md:rounded-md p-4">
                            <form @submit.prevent="updateData">
                                <jet-label for="nombre" value="Nombre (*)" />
                                <jet-input id="nombre" type="text" :errors="errors.nombre" class="mt-1 block w-full" v-model="form.nombre"/>
                                <jet-input-error :message="errors.nombre" class="mt-2" />

                                <jet-label for="pais" value="País (*)" />
                                <jet-input id="pais" type="text" :errors="errors.pais" class="mt-1 block w-full" v-model="form.pais"/>
                                <jet-input-error :message="errors.pais" class="mt-2" />

                                <jet-label for="fecha_inicio" value="F. Inicio (*)" />
                                <jet-input id="fecha_inicio" type="date" :errors="errors.fecha_inicio" class="mt-1 block w-full" v-model="form.fecha_inicio"/>
                                <jet-input-error :message="errors.fecha_inicio" class="mt-2" />

                                <div class="flex justify-end gap-2 mt-2 items-center">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white rounded p-3 font-bold">
                                        Editar
                                    </button>
                                    <inertia-link class="text-blue-400 hover:text-blue-600 underline" :href="route('temporada.index')">
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
            temporada : Object,
        },
        setup(props) {
                const form =  reactive({
                    nombre: props.temporada.nombre,
                    pais : props.temporada.pais,
                    fecha_inicio : props.temporada.fecha_inicio
                });

                const updateData = () => {
                    Inertia.put(route('temporada.update',props.temporada.id), {...form});
                }

                return {form,updateData}
        }
    }

</script>

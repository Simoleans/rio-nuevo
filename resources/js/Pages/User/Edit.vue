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
                                <jet-label for="name" value="Nombre (*)" />
                                <jet-input id="name" type="text" :errors="errors.name" class="mt-1 block w-full" v-model="form.name"/>
                                <jet-input-error :message="errors.name" class="mt-2" />

                                <jet-label for="email" value="Correo Eléctronico (*)" />
                                <jet-input id="email" type="text" :errors="errors.email" class="mt-1 block w-full" v-model="form.email"/>
                                <jet-input-error :message="errors.email" class="mt-2" />

                                <jet-label for="rol" value="Rol (*)" />
                                <Select2 v-model="form.rol" :options="options" :settings="{ dropdownAutoWidth: true,width: '100%' }"/>
                                <jet-input-error :message="errors.rol" class="mt-2" />

                                <jet-label for="status" value="Estatus (*)" />
                                <Select2 v-model="form.status" :options="optionsStatus" :settings="{ dropdownAutoWidth: true,width: '100%' }"/>
                                <jet-input-error :message="errors.status" class="mt-2" />

                                <div class="flex justify-end gap-2 mt-2 items-center">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white rounded p-3 font-bold">
                                        Editar
                                    </button>
                                    <inertia-link class="text-blue-400 hover:text-blue-600 underline" :href="route('usuario.index')">
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
            user : Object
        },
        setup(props) {
                const form =  reactive({
                    name: props.user.name,
                    email: props.user.email,
                    rol : props.user.rol,
                    status : props.user.status
                });

                const options = [
                        { text: 'Administrador', id: 'admin' },
                        { text: 'Operador', id: 'operador' }
                    ];

                    const optionsStatus = [
                        { text: 'Habilitar', id: 1 },
                        { text: 'Deshabilitar', id: 0 }
                    ];

                const updateData = () => {
                    Inertia.put(route('usuario.update',props.user.id), {...form});
                }

                return {form,updateData,options,optionsStatus}
        }
    }

</script>
<style>
    .select2-container .select2-selection--single {
        height: 38px !important;
        padding-top: 3px;
    }
</style>

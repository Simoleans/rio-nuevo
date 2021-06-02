<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Módulo de Usuarios
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg text-gray-900">Crear un Usuario</h3>
                            <p class="text-sm text-gray-500">(*) Campos Requeridos</p>
                        </div>
                    </div>
                    <div class="md:col-span-2 mt-5 md:mt-0">
                        <div class="shadow bg-white md:rounded-md p-4">
                            <form @submit.prevent="storeData">
                                <jet-label for="name" value="Nombre (*)" />
                                <jet-input id="name" type="text" :errors="errors.name" class="mt-1 block w-full" v-model="form.name"/>
                                <jet-input-error :message="errors.name" class="mt-2" />

                                <jet-label for="email" value="Correo Eléctronico (*)" />
                                <jet-input id="email" type="text" :errors="errors.email" class="mt-1 block w-full" v-model="form.email"/>
                                <jet-input-error :message="errors.email" class="mt-2" />

                                <jet-label for="rol" value="Rol (*)" />
                                <select-input :errors="errors.rol" v-model="form.rol" :options="options" />
                                <jet-input-error :message="errors.rol" class="mt-2" />

                                <jet-label for="password" value="Contraseña (*)" />
                                <jet-input id="password" type="password" :errors="errors.password" class="mt-1 block w-full" v-model="form.password"/>
                                <jet-input-error :message="errors.password" class="mt-2" />

                                <jet-label for="password_confirmation" value="Repetir Contraseña (*)" />
                                <jet-input id="password_confirmation" type="password" :errors="errors.password_confirmation" class="mt-1 block w-full" v-model="form.password_confirmation"/>
                                <jet-input-error :message="errors.password_confirmation" class="mt-2" />

                                <div class="flex justify-end gap-2 mt-2 items-center">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white rounded p-3 font-bold">
                                        Crear
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
            errors: Object
        },
        setup() {
                const form =  reactive({
                    name: null,
                    email: null,
                    password_confirmation: null,
                    password : null,
                });

                const options = [
                        { text: 'Administrador', value: 'admin' },
                        { text: 'Operador', value: 'operador' }
                    ];

                const storeData = () => {
                    Inertia.post('/usuario', {...form})
                }

                return {form,storeData,options}
        }
    }

</script>

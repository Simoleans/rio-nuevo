<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Módulo de Productores
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg text-gray-900">Editar Productor</h3>
                            <p class="text-sm text-gray-500">(*) Campos Requeridos</p>
                        </div>
                    </div>
                    <div class="md:col-span-2 mt-5 md:mt-0">
                        <div class="shadow bg-white md:rounded-md p-4">
                            <form @submit.prevent="updateData">
                                <jet-label for="rut" value="RUT (*)" />
                                <jet-input id="rut" type="text" :errors="errors.rut" class="mt-1 block w-full" v-model="form.rut"/>
                                <jet-input-error :message="errors.rut" class="mt-2" />

                                <jet-label for="razon_social" value="Razón Social (*)" />
                                <jet-input id="razon_social" type="text" :errors="errors.razon_social" class="mt-1 block w-full" v-model="form.razon_social"/>
                                <jet-input-error :message="errors.razon_social" class="mt-2" />

                                <jet-label for="email" value="Correo Eléctronico (*)" />
                                <jet-input id="email" type="text" :errors="errors.email" class="mt-1 block w-full" v-model="form.email"/>
                                <jet-input-error :message="errors.email" class="mt-2" />

                                <jet-label for="telefono" value="Telefono (*)" />
                                <jet-input id="telefono" type="text" :errors="errors.telefono" class="mt-1 block w-full" v-model="form.telefono"/>
                                <jet-input-error :message="errors.telefono" class="mt-2" />

                                <jet-label for="localidad" value="Localidad (*)" />
                                <jet-input id="localidad" type="text" :errors="errors.localidad" class="mt-1 block w-full" v-model="form.localidad"/>
                                <jet-input-error :message="errors.localidad" class="mt-2" />

                                <jet-label for="region" value="Región (*)" />
                                <jet-input id="region" type="text" :errors="errors.region" class="mt-1 block w-full" v-model="form.region"/>
                                <jet-input-error :message="errors.region" class="mt-2" />

                                <jet-label for="comuna" value="Comuna (*)" />
                                <jet-input id="comuna" type="text" :errors="errors.comuna" class="mt-1 block w-full" v-model="form.comuna"/>
                                <jet-input-error :message="errors.comuna" class="mt-2" />

                                <jet-label for="direccion" value="Dirección (*)" />
                                <jet-input id="direccion" type="text" :errors="errors.direccion" class="mt-1 block w-full" v-model="form.direccion"/>
                                <jet-input-error :message="errors.direccion" class="mt-2" />

                                <jet-label for="nombre_responsable" value="Nombre Responsable (*)" />
                                <jet-input id="nombre_responsable" type="text" :errors="errors.nombre_responsable" class="mt-1 block w-full" v-model="form.nombre_responsable"/>
                                <jet-input-error :message="errors.nombre_responsable" class="mt-2" />

                                <div class="flex justify-end gap-2 mt-2 items-center">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white rounded p-3 font-bold">
                                        Editar
                                    </button>
                                    <inertia-link class="text-blue-400 hover:text-blue-600 underline" :href="route('productors.index')">
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
            productor : Object
        },
        setup(props) {
                const form =  reactive({
                    rut: props.productor.rut,
                    razon_social: props.productor.razon_social,
                    region: props.productor.region,
                    comuna: props.productor.comuna,
                    localidad: props.productor.localidad,
                    email: props.productor.email,
                    telefono: props.productor.telefono,
                    nombre_responsable : props.productor.nombre_responsable,
                    direccion : props.productor.direccion,
                });

                const updateData = () => {
                    Inertia.put(route('productors.update',props.productor.id), {...form});
                }

                return {form,updateData}
        }
    }

</script>

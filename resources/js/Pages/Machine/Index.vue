<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Módulo de Maquinas
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="md:grid md:grid-cols-4 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg text-gray-900">Listado de Maquinas</h3>
                        </div>
                    </div>
                    <div class="md:col-span-3 mt-5 md:mt-0">
                        <div class="shadow bg-white md:rounded-md p-4">
                            <div class="flex justify-between items-center">
                                <input type="text" class="form-input rounded-md shadow-md p-2 m-1" placeholder="Buscar..." v-model="search">
                                <inertia-link :href="route('machine.create')" class="bg-blue-500 hover:bg-blue-700 p-3 rounded font-bold text-white">
                                    Crear Maquina
                                </inertia-link>
                            </div>
                            <hr class="my-6">
                            <table class="border-collapse w-full">
                                <thead>
                                    <tr>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Nombre</th>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Temporada</th>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Status</th>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(machine,i) in machines.data" :key="i" class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Nombre</span>
                                            {{ machine.nombre }}
                                        </td>
                                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Temporada</span>
                                            {{ machine.temporada }}
                                        </td>
                                        
                                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Status</span>
                                            <span :class="{'bg-green-400' : machine.status == 1,'bg-red-400' : machine.status == 0}" class="rounded py-1 px-3 text-xs font-bold" v-text="machine.status == 1 ? 'Activa' : 'Inactiva'"></span>
                                        </td>
                                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Acción</span>
                                            <inertia-link v-show="machine.status == 1" class="text-blue-400 hover:text-blue-600 underline m-2" :href="route('machine.edit',machine.id)">
                                                Editar
                                            </inertia-link>
                                            <a v-show="machine.status == 1" class="text-blue-400 hover:text-blue-600 underline m-2" href="#" @click="confirmDeleteData(machine.id)">
                                                Deshabilitar
                                            </a>
                                            <a v-show="machine.status == 0" class="text-blue-400 hover:text-blue-600 underline m-2" href="#" @click="enabledMachine(machine.id)">
                                                Habilitar
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <pagination class="mt-6" :data="machines" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Delete Account Confirmation Modal -->
        <jet-dialog-modal :show="confirmDelete" @close="closeModal">
            <template #title>
                Borrar Maquina
            </template>

            <template #content>
                ¿Estás seguro de que quieres Eliminar esta maquina?
            </template>

            <template #footer>
                <jet-secondary-button @click="closeModal">
                    Cancelar
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click="deleteMachine" :class="{ 'opacity-25': processing }" :disabled="processing">
                    Eliminar
                </jet-danger-button>
            </template>
        </jet-dialog-modal>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Pagination from '@/Components/Pagination'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetDangerButton from '@/Jetstream/DangerButton'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import { Inertia } from '@inertiajs/inertia'

    export default {
        components: {
            AppLayout,
            Pagination,
            JetDialogModal,
            JetDangerButton,
            JetSecondaryButton
        },
        props : {
            machines : Object,
        },
        data() 
        {
            return {
                search : '',
                confirmDelete : false,
                processing : true,
                id : null
            }
        },
        methods : {
            confirmDeleteData(data) {

                this.id = data;

                this.confirmDelete = true;

                setTimeout(() => this.processing = false, 850)
            },
            closeModal() {

                this.id = null;
                this.confirmDelete = false

                this.processing = true;
            },
            deleteMachine(){
                Inertia.delete(this.route('machine.destroy' , this.id), {
                    preserveScroll: true,
                    onSuccess: () => this.closeModal(),
                })
            },
            enabledMachine(id){
                    
                Inertia.put(this.route('machine.enable',id));
            }
        },
        watch : {
            search : function (value) {
                this.$inertia.replace(this.route('machine.index', {
                    search : value
                }));
            }
        }

    }
</script>

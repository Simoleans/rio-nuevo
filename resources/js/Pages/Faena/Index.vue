<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Módulo de Faenas
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="md:grid md:grid-cols-4 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg text-gray-900">Listado de Faenas</h3>
                        </div>
                    </div>
                    <div class="md:col-span-3 mt-5 md:mt-0">
                        <div class="shadow bg-white md:rounded-md p-4">
                            <div class="flex justify-between items-center">
                                <input type="text" class="form-input rounded-md shadow-md p-2 m-1" placeholder="Buscar..." v-model="search">
                                <inertia-link :href="route('faena.create')" class="bg-blue-500 hover:bg-blue-700 p-3 rounded font-bold text-white">
                                    Crear Faena
                                </inertia-link>
                            </div>
                            <hr class="my-6">
                            <table class="border-collapse w-full">
                                <thead>
                                    <tr>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Temporada</th>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Productor</th>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Maquina</th>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Campo</th>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Fecha Inicio</th>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Fecha Final</th>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Estatus</th>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(faena,i) in faenas.data" :key="i" class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                                        <td @click="showData({...faena})" class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Temporada</span>
                                            {{ faena.temporada }}
                                        </td>
                                        <td @click="showData({...faena})" class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Productor</span>
                                            {{ faena.productor }}
                                        </td>
                                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Maquina</span>
                                            {{ faena.maquina }}
                                        </td>
                                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Campo</span>
                                            {{ faena.campo }}
                                        </td>
                                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Fecha Inicio</span>
                                            {{ faena.fecha_inicio }}
                                        </td>
                                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Fecha Final</span>
                                            {{ faena.fecha_final }}
                                        </td>
                                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Status</span>
                                            <span :class="{'bg-green-400' : faena.status == 1,'bg-red-400' : faena.status == 0}" class="rounded py-1 px-3 text-xs font-bold" v-text="faena.status == 1 ? 'Activa' : 'Finalizada'"></span>
                                        </td>
                                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Acción</span>
                                            <inertia-link class="text-blue-400 hover:text-blue-600 underline m-2" :href="route('faena.edit',faena.id)">
                                                Editar
                                            </inertia-link>
                                            <a class="text-blue-400 hover:text-blue-600 underline m-2" href="#" @click="confirmDeleteData(faena.id)">
                                                Eliminar
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <pagination class="mt-6" :data="faenas" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Delete Account Confirmation Modal -->
        <jet-dialog-modal :show="confirmDelete" @close="closeModal">
            <template #title>
                Borrar Faena
            </template>

            <template #content>
                ¿Estás seguro de que quieres Eliminar esta faena?
            </template>

            <template #footer>
                <jet-secondary-button @click="closeModal">
                    Cancelar
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click="deletefaena" :class="{ 'opacity-25': processing }" :disabled="processing">
                    Eliminar
                </jet-danger-button>
            </template>
        </jet-dialog-modal>

        <!-- Show Account Modal -->
        <jet-dialog-modal :show="showModalData" @close="closeModalShow">
            <template #title>
                <strong>{{ modal.productor }} - {{ modal.maquina }}</strong>
            </template>
            
            <template #content>
                <div class="flex flex-col gap-2">
                    <p>Campo:</p><strong>{{ modal.campo }}</strong>
                    <p>Fecha Inicio:</p><strong>{{ modal.fecha_inicio }}</strong>
                    <p>Fecha Final:</p><strong>{{ modal.fecha_final }}</strong>
                </div>
            </template>

            <template #footer>
                <jet-danger-button :class="{ 'opacity-25': processing }" :disabled="processing" @click="finishFaena(modal.id)">
                    Finalizar Faena
                </jet-danger-button>
                <jet-secondary-button class="ml-2" @click="closeModalShow">
                    Cerrar
                </jet-secondary-button>
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
            faenas : Object,
        },
        data() 
        {
            return {
                search : '',
                confirmDelete : false,
                processing : true,
                id : null,
                showModalData : false,
            }
        },
        methods : {
            confirmDeleteData(data) {

                this.id = data;

                this.confirmDelete = true;

                setTimeout(() => this.processing = false, 950)
            },
            closeModal() {

                this.id = null;
                this.confirmDelete = false

                this.processing = true;
            },
            deletefaena(){
                Inertia.delete(this.route('faena.destroy' , this.id), {
                    preserveScroll: true,
                    onSuccess: () => this.closeModal(),
                })
            },
            showData(faena){
                this.showModalData = true;
                this.modal = {...faena};
                setTimeout(() => this.processing = false, 850)
            },
            finishFaena(id){
                Inertia.put(route('disabledFaena',id),{
                    onSuccess : () => this.closeModal()
                });
            },
            closeModalShow() {
                this.id = null;
                this.showModalData = false;
                this.processing = true;
            },
        },
        watch : {
            search : function (value) {
                this.$inertia.replace(this.route('faena.index', {
                    search : value
                }));
            }
        }

    }
</script>

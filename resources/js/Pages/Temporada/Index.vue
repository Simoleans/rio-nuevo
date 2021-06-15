<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Módulo de Temporadas
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="md:grid md:grid-cols-4 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg text-gray-900">Listado de Temporadas</h3>
                        </div>
                    </div>
                    <div class="md:col-span-3 mt-5 md:mt-0">
                        <div class="shadow bg-white md:rounded-md p-4">
                            <div class="flex justify-between items-center">
                                <input type="text" class="form-input rounded-md shadow-md p-2 m-1" placeholder="Buscar..." v-model="search">
                                <inertia-link :href="route('temporada.create')" class="bg-blue-500 hover:bg-blue-700 p-3 rounded font-bold text-white">
                                    Crear Temporada
                                </inertia-link>
                            </div>
                            <hr class="my-6">
                            <table class="border-collapse w-full">
                                <thead>
                                    <tr>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Nombre</th>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">País</th>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Fecha Inicio</th>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Status</th>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(temporada,i) in temporadas.data" :key="i" class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                                        <td @click="showData({...temporada})" class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Nombre</span>
                                            {{ temporada.nombre }}
                                        </td>
                                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">País</span>
                                            {{ temporada.pais }}
                                        </td>
                                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">F. Inicio</span>
                                            {{ temporada.fecha_inicio }}
                                        </td>
                                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Status</span>
                                            <span :class="{'bg-green-400' : temporada.status == 1,'bg-red-400' : temporada.status == 0}" class="rounded py-1 px-3 text-xs font-bold" v-text="temporada.status == 1 ? 'En Proceso' : 'Finalizada'"></span>
                                        </td>
                                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Acción</span>
                                            <inertia-link v-show="temporada.status == 1" class="text-blue-400 hover:text-blue-600 underline m-2" :href="route('temporada.edit',temporada.id)">
                                                Editar
                                            </inertia-link>
                                            <a v-show="temporada.status == 0" class="text-blue-400 hover:text-blue-600 underline" :href="route('excelExport',temporada.id)">
                                                Descargar reportes
                                            </a>
                                            <a class="text-blue-400 hover:text-blue-600 underline m-2" href="#" @click="confirmDeleteData(temporada.id)">
                                                Eliminar
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <pagination class="mt-6" :data="temporadas" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Show Account Modal -->
        <jet-dialog-modal :show="showModalData" @close="closeModalShow">
            <template #title>
                <strong>{{ modal.nombre }}</strong>
            </template>
            
            <template #content>
                <div class="flex flex-col gap-2">
                    <p>País:</p><strong>{{ modal.pais }}</strong>
                    <p>Fecha Inicio:</p><strong>{{ modal.fecha_inicio }}</strong>
                    <p v-show="modal.status == 0">Fecha Final:</p><strong v-show="modal.status == 0">{{ modal.fecha_fin }}</strong>
                </div>
                    <div v-show="modal.status == 1">
                        <jet-label for="fecha_fin" value="Fecha Final (*)" />
                        <jet-input id="fecha_fin" type="date" :errors="errors.fecha_fin" class="mt-1 block w-full" v-model="fecha_fin"/>
                        <jet-input-error :message="errors.fecha_fin" class="mt-2" />
                    </div>
            </template>

            <template #footer>
                <jet-danger-button v-show="modal.status == 1" :class="{ 'opacity-25': processing }" :disabled="processing" @click="finishTemporada(modal.id,modal.fecha_inicio)">
                    Finalizar Faena
                </jet-danger-button>
                
                <jet-secondary-button class="ml-2" @click="closeModalShow">
                    Cerrar
                </jet-secondary-button>
            </template>
        </jet-dialog-modal>
        <!-- Delete Account Confirmation Modal -->
        <jet-dialog-modal :show="confirmDelete" @close="closeModal">
            <template #title>
                Borrar Temporada
            </template>

            <template #content>
                ¿Estás seguro de que quieres Eliminar esta Temporada?
            </template>

            <template #footer>
                <jet-secondary-button @click="closeModal">
                    Cancelar
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click="deleteTipo" :class="{ 'opacity-25': processing }" :disabled="processing">
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
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'

    export default {
        components: {
            AppLayout,
            Pagination,
            JetDialogModal,
            JetDangerButton,
            JetSecondaryButton,
            JetInputError,
            JetLabel,
            JetInput
        },
        props : {
            temporadas : Object,
            errors : Object
        },
        data() 
        {
            return {
                search : '',
                confirmDelete : false,
                showModalData : false,
                processing : true,
                id : null,
                fecha_fin : null,
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
            showData(temporada){
                
                this.showModalData = true;
                this.modal = {...temporada};
                setTimeout(() => this.processing = false, 850)
            },
            finishTemporada(id,fecha_inicio){
                if (this.fecha_fin == null) {
                    this.errors.fecha_fin = 'Debe seleccionar una fecha para finalizar.';
                }else if(this.fecha_fin < fecha_inicio){
                    this.errors.fecha_fin = 'La fecha ifnal no puede ser menor a la fecha de inicio.';
                }else {
                     Inertia.put(route('finishTemporada',id),
                         {fecha_fin : this.fecha_fin},
                        { onSuccess : () => {
                             this.closeModalShow()
                         }
                     });
                }
            },
            closeModalShow() {
                this.id = null;
                this.showModalData = false;
                this.processing = true;
                this.fecha_fin = null;
            },
            deleteTipo(){
                Inertia.delete(this.route('temporada.destroy' , this.id), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.search = '';
                        this.closeModal();
                    },
                })
            },
        },
        watch : {
            search : function (value) {
                this.$inertia.replace(this.route('temporada.index', {
                    search : value
                }));
            }
        }

    }
</script>

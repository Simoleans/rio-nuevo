<template>
    <app-layout>    
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Módulo de Reportes
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-4 w-full">
                    <div class="grid grid-cols-2 md:grid-cols-7 lg:grid-cols-7 gap-2">
                        <div v-for="(w,i) in weeks" :key="i" class="col-span-2 md:col-span-1 hover:shadow-lg">
                            <div class="flex flex-col bg-gray-300 shadow-sm rounded p-4 " :class="{
                                'bg-blue-300' : w.todayValidation}" >
                                <div class="flex flex-col items-center justify-center flex-shrink-0 h-12 w-full rounded-xl bg-blue-400 text-white font-extrabold">
                                    {{ w.dayName.toUpperCase() }}
                                </div>
                                <div class="flex flex-col flex-grow ml-4 items-center justify-center pt-2">
                                    <a @click="showOptions(w.encriptedDate,w.dff)" class="cursor-pointer text-sm text-blue-800 font-extrabold text-md">Asignar Fecha</a>
                                    <a class="text-sm text-red-800 font-extrabold text-md">{{ w.totalKG }}</a>
                                    <div class="font-bold text-md">{{ w.dates }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-show="validationMessage" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-3" role="alert">
                    <strong class="font-bold">Alerta!</strong>
                    <span class="block sm:inline"> Hay días anteriores a esté que aun no se han registrado reportes.</span>
                    <span @click="closevalidationMessage" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                    </span>
                </div>
                <div class="md:grid md:grid-cols-4 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg text-gray-900">Listado de Reportes</h3>
                        </div>
                    </div>
                    <div class="md:col-span-3 mt-5 md:mt-0">
                        <div class="shadow bg-white md:rounded-md p-4">
                            <div class="flex justify-between items-center gap-6">
                                <input type="text" class="form-input rounded-md shadow-md p-2 m-1 md:w-1/3 lg:w-1/3" placeholder="Buscar por Productor | Maquina" v-model="search">
                            </div>
                            <hr class="my-6">
                            <table class="border-collapse w-full">
                                <thead>
                                    <tr>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Productor</th>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Maquina</th>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Campo</th>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">T. Bandeja</th>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Fecha</th>
                                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Estatus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(reporte,i) in reportes.data" :key="i" class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                                        <td @click="showData({...reporte})" class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Productor</span>
                                            {{ reporte.productor.razon_social }}
                                        </td>
                                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Maquina</span>
                                            {{ reporte.maquina.nombre }}
                                        </td>
                                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Campo</span>
                                            {{ reporte.campo.nombre }}
                                        </td>
                                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">T. Bandeja</span>
                                            {{ reporte.tipo_bandeja }}
                                        </td>
                                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Fecha</span>
                                            {{ reporte.fecha }}
                                        </td>
                                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Status</span>
                                            <span :class="{'bg-green-400' : reporte.status == 1,'bg-red-400' : reporte.status == 0}" class="rounded py-1 px-3 text-xs font-bold" v-text="reporte.status == 1 ? 'Activa' : 'Finalizada'"></span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <pagination class="mt-6" :data="reportes" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Delete Account Confirmation Modal -->
        <jet-dialog-modal :show="confirmDelete" @close="closeModal">
            <template #title>
                Borrar reporte
            </template>

            <template #content>
                ¿Estás seguro de que quieres Eliminar esta reporte?
            </template>

            <template #footer>
                <jet-secondary-button @click="closeModal">
                    Cancelar
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click="finishreporte(modal.id)" :class="{ 'opacity-25': processing }" :disabled="processing">
                    Finalizar Reporte
                </jet-danger-button>
            </template>
        </jet-dialog-modal>

        <!-- Show Account Modal -->
        <jet-dialog-modal :show="showModalData" @close="closeModalShow">
            <template #title>
                <strong>{{ modal.productor.razon_social }} - {{ modal.maquina.nombre }} | <span v-show="modal.status == 0"> Anulado por : {{ modal.user_anular.name }}</span></strong>
            </template>
            
            <template #content>
                <div class="flex justify-between mb-5">
                    <div class="flex flex-col gap-2">
                        <p>Campo:</p><strong>{{ modal.campo.nombre }}</strong>
                        <p>Variedad:</p><strong>{{ modal.variedad.nombre }}</strong>
                        <p>T. Cultivo:</p><strong>{{ modal.tipo_cultivo.nombre }}</strong>
                        <p>T. Bandeja:</p><strong>{{ modal.tipo_bandeja }}</strong>
                        <p>Nro. Bandeja:</p><strong>{{ modal.nro_bandeja }}</strong>
                    </div>
                    <div class="flex flex-col gap-2">
                        <p>Kg Totales:</p><strong>{{ modal.kg_totales }}</strong>
                        <p>Kg Teóricos:</p><strong>{{ modal.kg_teoricos }}</strong>
                        <p>Hs. Maquina:</p><strong>{{ modal.hs_maquina }}</strong>
                        <p>Creado por:</p><strong>{{ modal.user.name }}</strong>
                    </div>
                </div>
                <div class="border-t border-gray-300 mb-2"></div>
                <div class="flex flex-col gap-2">
                    <p>Observación:</p><strong>{{ modal.observacion ?? 'N/T' }}</strong>
                </div>
            </template>

            <template #footer>
            <div class="flex flex-col md:flex-row lg:flex-row justify-between gap-4">
                <!-- <a v-show="modal.status == 1" class="text-blue-400 hover:text-blue-600 underline m-2" :href="route('reporte.cloneView',modal.id)">
                    Clonar
                </a> -->
                <jet-button v-show="modal.status == 0" :class="{ 'opacity-25': processing }" :disabled="processing" @click="enableReporte(modal.id)">
                    Activar Reporte
                </jet-button>
                <jet-danger-button  v-show="modal.status == 1 && $page.props.user.admin"  :class="{ 'opacity-25': processing }" :disabled="processing" @click="finishreporte(modal.id)">
                    Anular Reporte
                </jet-danger-button>
                <jet-secondary-button class="ml-2" @click="closeModalShow">
                    Cerrar
                </jet-secondary-button>
            </div>
            </template>
        </jet-dialog-modal>

        <!-- modal de opciones -->
        <jet-dialog-modal :show="showModalOptions" @close="closeModalOptions">
            <template #title>
                <strong>Opciones</strong>
            </template>
            <template #footer>
            <div class="flex flex-col md:flex-row lg:flex-row justify-between gap-4 items-center">
                <!-- <a v-show="modal.status == 1" class="text-blue-400 hover:text-blue-600 underline m-2" :href="route('reporte.cloneView',modal.id)">
                    Clonar
                </a> -->
                <a class="bg-blue-500 hover:bg-blue-600 inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition" :href="route('createFechaReport',date)">
                    Crear Reporte
                </a>
                <a v-show="lastReport != 0" class="text-blue-400 hover:text-blue-600 underline m-2" :href="route('reporte.cloneView',{'reporte' : lastReport,'fecha' : date})">
                    Clonar
                </a>
                <a class="bg-green-500 hover:bg-green-600 inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition" :href="route('createReportNA',date)">
                    No cosecho
                </a>
                <!-- <a href="#" class="ml-2 font-bold text-md text-blue-400 underline" @click="closeModalOptions">
                    Cerrar
                </a> -->
            </div>
            </template>
        </jet-dialog-modal>
        <!-- fin modal opciones -->
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Pagination from '@/Components/Pagination'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetDangerButton from '@/Jetstream/DangerButton'
    import JetButton from '@/Jetstream/Button'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import { Inertia } from '@inertiajs/inertia'

    export default {
        components: {
            AppLayout,
            Pagination,
            JetDialogModal,
            JetDangerButton,
            JetSecondaryButton,
            JetButton
        },
        props : {
            reportes : Object,
            weeks : Object,
            lastReportToUser : String
        },
        data() 
        {
            return {
                search : '',
                confirmDelete : false,
                processing : true,
                id : null,
                showModalData : false,
                showModalOptions : false,
                date: null,
                validationMessage : false,
                lastReport : this.lastReportToUser != null ? this.lastReportToUser.id : 0
            }
        },
        methods : {
            confirmDeleteData(data) {

                this.id = data;

                this.confirmDelete = true;

            },

            closevalidationMessage(){
                this.validationMessage = false;
            },
            createReport(d){
                Inertia.get(route('createFechaReport',d));
            },
            closeModal() {

                this.id = null;
                this.confirmDelete = false

                this.processing = true;
            },
            closeModalOptions() {

                this.showModalOptions = false;
                this.date = null;
            },
            showOptions(date,validation){
                if(validation){
                    this.showModalOptions = true;
                    this.date = date;
                    this.validationMessage = false;
                }else{
                    this.validationMessage = true;
                }
            },
            deletereporte(){
                Inertia.delete(this.route('reporte.destroy' , this.id), {
                    preserveScroll: true,
                    onSuccess: () => this.closeModal(),
                })
            },
            showData(reporte){
                this.showModalData = true;
                this.modal = {...reporte};
                setTimeout(() => this.processing = false, 1050)
            },
            finishreporte(id){
                Inertia.put(route('disabledReporte',id),{},
                    {onSuccess : () => this.closeModalShow()
                });

                
            },
            enableReporte(id){
                Inertia.put(route('reporte.enable',id));

                this.closeModalShow();
            },
            cloneReport(data){
                Inertia.post(this.route('reporte.clone' , {...data}))

                this.closeModalShow();
            },
            closeModalShow() {
                this.id = null;
                this.showModalData = false;
                this.processing = false;
            }
        },
        watch : {
            search : function (value) {
                this.$inertia.replace(this.route('reporte.index', {
                    search : value
                }));
            }
        }

    }
</script>

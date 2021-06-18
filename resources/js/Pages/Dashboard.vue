<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Inicio
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
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    
                </div>
            </div>
        </div>

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
            </div>
            </template>
        </jet-dialog-modal>
        <!-- fin modal opciones -->

    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetDialogModal from '@/Jetstream/DialogModal'

    export default {
        components: {
            AppLayout,
            JetDialogModal,
        },
        props : {
            weeks : Object,
            lastReportToUser : String
        },
        data(){
            return {
                showModalOptions : false,
                date: null,
                validationMessage : false,
                lastReport : this.lastReportToUser != null ? this.lastReportToUser.id : 0
            }
        },
        methods : {
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
            closevalidationMessage(){
                this.validationMessage = false;
            },
        }
    }
</script>

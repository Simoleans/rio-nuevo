<template>
    <div>
        <div class="flex flex-wrap -mb-1">
            <inertia-link v-if="data.next_page_url == null && data.to != null"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-blue-800 focus:border-blue-500 focus:text-blue-500"
                    :class="'bg-blue-700 text-white'" :href="data.first_page_url">Inicio</inertia-link>
            <inertia-link v-if="data.prev_page_url != null"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-blue-800 focus:border-blue-500 focus:text-blue-500"
                    :class="'bg-blue-700 text-white'" :href="data.prev_page_url">Anterior</inertia-link>
            <inertia-link v-if="data.next_page_url != null"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-blue-800 focus:border-blue-500 focus:text-blue-500"
                    :class="'bg-blue-700 text-white'" :href="data.next_page_url">Siguiente</inertia-link>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            data: Array
        }
    }

</script>
<template>
    <inertia-link :href="href" :class="classes">
        <slot></slot>
    </inertia-link>
</template>

<script>
    export default {
        props: ['href', 'active'],

        computed: {
            classes() {
                return this.active
                            ? 'inline-flex items-center px-1 pt-1 border-b-4 border-red-200 text-sm font-bold leading-5 text-white focus:outline-none focus:border-indigo-700 transition'
                            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-white hover:font-bold hover:border-red-500 focus:outline-none focus:text-white focus:border-red-500 transition'
            }
        }
    }
</script>

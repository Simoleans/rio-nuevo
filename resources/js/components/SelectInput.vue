<template>
    <div>
        <select :class="{ ' border border-red-500' : errors }" class="border-gray-300 w-full focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1" v-model="model" @input="$emit('update:modelValue', $event.target.value)" ref="input">
            <option value="">Seleccione...</option>
            <option v-for="option in options" :value="option.value" :key="option.id">
                {{ option.text }}
            </option>
        </select>
    </div>
</template>

<script>
    export default {
        props: ['modelValue','errors','options','model','database','ModelVal'],

        emits: ['update:modelValue','update:modelValue'],

        methods: {
            focus() {
                this.$refs.input.focus()
            }
        }
    }
</script>
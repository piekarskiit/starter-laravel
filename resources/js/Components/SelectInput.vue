<script setup lang="ts">
import {defineProps, defineEmits, withDefaults} from "vue";
import {useInput} from "@/hooks/useInput";

interface Props {
    options: string[];
    modelValue?: string | number;
    placeholder?: string;
}

const props = withDefaults(defineProps<Props>(), {
    placeholder: "",
    modelValue: "",
});

const emit = defineEmits(["update:modelValue"]);

const {value} = useInput(props, emit);

</script>

<template>
    <select v-model="value"
            ref="input"
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
    >
        <option v-if="placeholder" :disabled="true" :selected="true" value="">
            {{ placeholder }}
        </option>
        <option v-for="(option, index) in options"
                :key="index"
                :value="option"
        >
            {{ option }}
        </option>
    </select>
</template>

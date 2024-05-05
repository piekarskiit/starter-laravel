<template>
    <component
        :is="href && as === 'button' ? Link : as"
        :href="href ?? null"
        :type="as === 'button' ? type : null"
        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer"
    >
        <slot/>
    </component>
</template>

<script lang="ts" setup>
import type {Component} from "vue";
import {defineProps} from 'vue';
import {Link} from "@inertiajs/vue3";

interface Props {
    href?: string;
    type?: "button" | "submit" | "reset";
    as?: string | Component | object,
}

withDefaults(defineProps<Props>(), {
    type: "submit",
    as: "button",
});

</script>

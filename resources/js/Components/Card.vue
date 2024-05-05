<template>
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <header v-if="title">
            <h2 class="text-lg font-medium text-gray-900">{{ title }}</h2>

            <p class="mt-1 text-sm text-gray-600" v-if="subtitle">
                {{ subtitle }}
            </p>
        </header>
        <main>
            <slot name="content"/>
        </main>
        <footer>
            <slot name="footer"/>
        </footer>
    </div>
</template>

<script setup lang="ts">
import {defineProps} from 'vue';

interface Props {
    title?: string;
    subtitle?: string;
}

defineProps<Props>();
</script>

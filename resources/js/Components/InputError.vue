<script setup>
defineProps(['message']);
</script>

<template>
    <div v-show="message">
        <p class="text-sm text-red-600 italic">
            {{ message }}
        </p>
    </div>
</template>

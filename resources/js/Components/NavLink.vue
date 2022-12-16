
<script setup>
import { ref, defineProps } from 'vue';

const props = defineEmits('ShowNav')


function NAVbtn(){
    console.log(props)
}
</script>
<template>

</template>

<script>
export default {
    name: "NavlinkVue"
}
</script>

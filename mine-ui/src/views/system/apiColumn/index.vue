<template>
    asdasd
</template>

<script setup>
import { onMounted, getCurrentInstance } from 'vue'

const { proxy } = getCurrentInstance()
onMounted(() => {
    console.log(proxy.$root.$route)
})
</script>
<template>
    <ma-container>
        <el-empty></el-empty>
        <upload type="image" @uploadData="getFiles"></upload>
    </ma-container>
</template>

<script>
export default {
    data () {
        return {
            files: [],
        }
    },

    methods: {
        getFiles(files) {
            this.files = files
            console.log(this.files)
        }
    }
}
</script>
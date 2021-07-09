<template>
  <ma-container>
    <photo v-model="files">
      <template slot="upload">
        <upload type="file" @uploadData="getFiles"></upload>
      </template>
    </photo>
  </ma-container>
</template>

<script>
export default {
  data () {
    return {
      files: []
    }
  },

  methods: {
    getFiles (files) {
      this.files = files
    }
  }
}
</script>

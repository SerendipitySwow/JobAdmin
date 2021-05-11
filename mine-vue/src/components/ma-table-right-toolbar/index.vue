<template>
  <div class="table-right-toolbar">
    <el-row>
      <el-tooltip class="item" effect="dark" :content="showRecycle ? '显示正常数据' : '显示回收站数据'" placement="top">
        <el-button size="small" :type="dataType" circle icon="el-icon-delete" @click="toggleData()" />
      </el-tooltip>
      <el-tooltip class="item" effect="dark" :content="showSearch ? '隐藏搜索栏' : '显示搜索栏'" placement="top">
        <el-button size="small" circle icon="el-icon-search" @click="toggleSearch()" />
      </el-tooltip>
      <el-tooltip class="item" effect="dark" content="刷新表格" placement="top">
        <el-button size="small" circle icon="el-icon-refresh" @click="refresh()" />
      </el-tooltip>
      <el-tooltip class="item" effect="dark" content="显隐列" placement="top" v-if="columns">
        <el-button size="small" circle icon="el-icon-menu" @click="showColumn()" />
      </el-tooltip>
    </el-row>
  </div>
</template>
<script>
export default {
  name: 'table-right-toolbar',
  props: {
    showSearch: {
      type: Boolean,
      default: true
    },
    columns: {
      type: Array
    }
  },
  data () {
    return {
      dataType: null,
      showRecycle: false
    }
  },
  created () {
  },
  methods: {
    refresh () {
      this.$emit('refreshTable')
    },
    toggleData () {
      this.showRecycle = !this.showRecycle
      this.dataType = this.showRecycle ? 'primary' : ''
      this.$emit('toggleData')
    }
  }
}
</script>
<style lang="scss" scoped>
.table-right-toolbar {
  float: right;
  margin-bottom: 10px;
  margin-right: 5px;
}
</style>

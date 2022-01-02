<template>
	<el-container>
		<el-aside width="180px" style="border-right: 1px solid #e6e6e6; padding:10px;">
			<el-menu size="small" @select="handleSelect" :default-active="defaultActive">
        <el-menu-item index="send_box">
          <el-icon><el-icon-message-box /></el-icon>
          <template #title>已发送</template>
        </el-menu-item>
        <el-menu-item index="receive_box">
          <el-icon><el-icon-message /></el-icon>
          <template #title>收信箱</template>
        </el-menu-item>
        <el-menu-item v-for="item in messageType" :key="item.value" :index="item.value">
          <el-icon><Component :is="typeIcon[item.value] ? typeIcon[item.value] : 'el-icon-message-box'" /></el-icon>
          <template #title>{{ item.label }}</template>
        </el-menu-item>
			</el-menu>
		</el-aside>
		<el-container ref="printMain">
      <el-header>
        <div class="left-panel">
          <el-button
            icon="el-icon-plus"
            type="primary"
          >发信息</el-button>

          <el-button
            type="danger"
            plain
            icon="el-icon-delete"
            :disabled="selection.length==0"
            @click="del(selection, true)"
          >删除</el-button>

          <el-radio-group
            v-model="queryParams.read_status"
            style="margin-left:10px"
            v-if="defaultActive !== 'send_box'"
            @change="readStatusChange"
          >
            <el-radio-button label="all">全部</el-radio-button>
            <el-radio-button label="0">未读</el-radio-button>
            <el-radio-button label="1">已读</el-radio-button>
          </el-radio-group>
        </div>
        <div class="right-panel">
          <el-input placeholder="搜索标题" />
          <el-tooltip class="item" effect="dark" content="搜索" placement="top">
            <el-button type="primary" icon="el-icon-search" @click="handlerSearch"></el-button>
          </el-tooltip>

          <el-tooltip class="item" effect="dark" content="清空条件" placement="top">
            <el-button icon="el-icon-refresh" @click="resetSearch"></el-button>
          </el-tooltip>
        </div>
      </el-header>
      <el-main class="nopadding">
        <maTable
          ref="table"
          :api="api"
          @selection-change="selectionChange"
          :autoLoad="false"
          stripe
          remoteSort
          remoteFilter
        >
          <el-table-column type="selection" width="50"></el-table-column>
          
          <el-table-column
            label="消息类型"
            prop="content_type"
            sortable="custom"
            width="120"
          >
            <template #default="scope">
              <ma-dict-tag :options="messageType" :value="scope.row.content_type" />
            </template>
          </el-table-column>

          <el-table-column
            label="发送人"
            prop="send_user.nickname"
            sortable="custom"
            v-if="defaultActive !== 'send_box'"
            width="120"
          />

          <el-table-column
            label="标题"
            prop="title"
            show-overflow-tooltip
          ></el-table-column>

          <el-table-column
            label="发送时间"
            prop="created_at"
            width="200"
            sortable="custom"
          ></el-table-column>

          <el-table-column
            label="操作"
            width="150"
          >
            <template #default="scope">
              <el-button type="text" @click="del(scope.row.id)">删除</el-button>
              <el-button type="text" @click="showDetails(scope.row)">详细</el-button>
              <el-button type="text" v-if="defaultActive === 'send_box'">发送列表</el-button>
            </template>
          </el-table-column>

        </maTable>
      </el-main>
		</el-container>
	</el-container>

  <el-drawer v-model="drawer" title="详细内容" size="50%" >
    <el-main>
      <h2 style="font-size: 24px; line-height: 60px;"> {{ row.title }} </h2>
      <div v-html="row.content"></div>
    </el-main>
  </el-drawer>
</template>

<script>
	export default {
		name: 'message',
		data() {
			return {
        api: { list: () => {} },
        defaultActive: 'receive_box',
        messageType: [],
        typeIcon: {
          carbon_copy_mine: 'el-icon-copy-document',
          todo: 'el-icon-calendar',
          announcement: 'el-icon-cellphone',
          notice: 'el-icon-bell',
        },
        queryParams: { read_status: 'all' },
        selection: [],
        drawer: false,
        row: {
          title: '', content: ''
        },
			}
		},
    
		async mounted() { 
      await this.getDictData()
      await this.loadData()
		},

		methods: {

      loadData (type = undefined) {
        if (! this.defaultActive) return

        this.api.list = this.defaultActive === 'send_box' ? this.$API.queueMessage.getSendList : this.$API.queueMessage.getReceiveList
        this.queryParams = { read_status: 'all' }
        this.queryParams.content_type = type
        this.$refs.table.reload(this.queryParams)
      },

      readStatusChange(value) {
        this.queryParams.read_status = value
        this.$refs.table.upData(this.queryParams)
      },

      showDetails(row) {
        this.drawer = true
        this.row = row
      },

      add() {

      },

      // 删除
      async del(id, batch = false) {
        let msg = batch ? '确定要删除选中的消息吗？' : '确定删除该消息吗？';
        await this.$confirm(msg, '提示', {
          type: 'warning'
        }).then(() => {
          this.$API.queueMessage.deletes(batch ? id.join(',') : id).then(res => {
            res.success && this.$message.success(res.message)
            res.success || this.$message.error(res.message)
          })
          this.$refs.table.upData(this.queryParams)
        }).catch(()=>{})
      },

      // 菜单点击事件
      handleSelect(name) {
        this.defaultActive = name
        this.loadData( (name === 'receive_box' || name === 'send_box') ? undefined : name)
      },

      // 处理搜索事件
      handlerSearch() {
        this.$refs.table.upData(this.queryParams)
      },

      // 重置搜索
      resetSearch() {
        this.loadData(this.defaultActive)
      },

      // 选择事件
      selectionChange(selection){
        this.selection = selection.map( item => item.id )
      },

      // 查询字典
      getDictData () {
        this.getDict('queue_msg_type').then(res => {
          this.messageType = res.data
        })
      }
		}
	}
</script>

<style scoped lang="scss">
  .el-menu-item.is-active {
    background: var(--el-background-color-base)
  }
  .el-menu-item {
    border-radius: 4px;  
  }
	.innerPage {width: 100%;margin:0 auto;}

	@media (max-width: 1610px){
	.innerPage {width: 100%;}
	}

</style>

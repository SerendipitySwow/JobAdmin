<template>
	<el-container>
		<el-aside width="180px" style="border-right: 1px solid #e6e6e6; padding:10px;">
			<el-menu size="small" @select="handleSelect" default-active="receive_box">
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
            v-auth="['system:queueMessage:save']"
            type="primary"
            @click="add"
          >发信息</el-button>

          <el-button
            type="danger"
            plain
            icon="el-icon-delete"
            v-auth="['system:role:delete']"
            :disabled="selection.length==0"
            @click="batchDel"
          >删除</el-button>

          <el-button-group style="margin-left: 10px;">
            <el-button
              plain
              v-auth="['system:attachment:delete']"
            >全部</el-button>

            <el-button
              plain
              v-auth="['system:attachment:delete']"
            >已读</el-button>

            <el-button
              plain
              v-auth="['system:attachment:recovery']"
            >未读</el-button>
          </el-button-group>
        </div>
        <div class="right-panel">
          <el-input placeholder="搜索发送人" />
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
          ></el-table-column>

          <el-table-column
            label="发送人"
            prop="title"
            sortable="custom"
            width="120"
          ></el-table-column>

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

        </maTable>
      </el-main>
		</el-container>
	</el-container>
</template>

<script>
	export default {
		name: 'message',
		data() {
			return {
        messageType: [],
        typeIcon: {
          carbon_copy_mine: 'el-icon-copy-document',
          todo: 'el-icon-calendar',
          announcement: 'el-icon-cellphone',
          notice: 'el-icon-bell',
        },
        selection: [],
			}
		},
    
		async mounted() {
      await this.getDictData()
		},

		methods: {

      // 菜单点击事件
      handleSelect(e) {
        console.log(e)
      },

      // 选择事件
      selectionChange(selection){
        this.selection = selection
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

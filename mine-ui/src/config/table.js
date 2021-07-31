//数据表格配置
import { ElMessage } from 'element-plus'

export default {

	pageSize: 20,						//表格每一页条数

	parseData: function (res) {			//数据分析
		if (res.data.items) {
			return {
				rows: res.data.items,			//分析行数据字段结构
				total: res.data.pageInfo.total,	//分析总数字段结构
				message: res.message,			//分析描述字段结构
				code: res.code					//分析状态字段结构
			}
		} else {
			return {
				rows: res.data,
				message: res.message,
				code: res.code
			}
		}
	},

	request: {							//请求规定字段
		page: 'page',					//规定当前分页字段
		pageSize: 'pageSize',			//规定一页条数字段
		prop: 'orderBy',					//规定排序字段名字段
		order: 'orderType'					//规定排序规格字段
	},

	/**
	 * 自定义列保存处理
	 * @tableName scTable组件的props->tableName
	 * @column 用户配置好的列
	 * @ref 列配置弹窗组件的ref
	 */
	columnSettingSave: function (tableName, column, ref) {
		ref.isSave = true
		setTimeout(()=>{
			ref.isSave = false
			ElMessage.success(`${tableName} 保存列配置成功`)
		},1000)
	}
}
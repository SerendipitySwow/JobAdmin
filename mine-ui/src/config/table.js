//数据表格配置

export default {
	pageSize: 20,						//表格每一页条数
	parseData: function (res) {			//数据分析
		return {
			rows: res.data.items,			//分析行数据字段结构
			total: res.data.pageInfo.total,	//分析总数字段结构
			message: res.message,		//分析描述字段结构
			code: res.code				//分析状态字段结构
		}
	},
	request: {							//请求规定字段
		page: 'page',					//规定当前分页字段
		pageSize: 'pageSize',			//规定一页条数字段
		prop: 'orderBy',					//规定排序字段名字段
		order: 'orderType'					//规定排序规格字段
	}
}
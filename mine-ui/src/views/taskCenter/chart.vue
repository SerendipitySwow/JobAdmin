<template>
	<el-container>
		<el-header>
			<div class="left-panel">
				<el-radio-group v-model="dateType" size="mini" style="margin-right: 15px;">
					<el-radio-button label="今天"></el-radio-button>
					<el-radio-button label="昨天"></el-radio-button>
					<el-radio-button label="最近7天"></el-radio-button>
					<el-radio-button label="最近30天"></el-radio-button>
				</el-radio-group>
				<el-date-picker v-model="date" type="datetimerange" range-separator="至" start-placeholder="开始日期" end-placeholder="结束日期" size="mini"></el-date-picker>
			</div>
		</el-header>
		<el-main>
			<el-card shadow="hover">
				<div class="number-data">
					<div class="item">
						<h2>任务数量
							<el-tooltip effect="light">
								<template #content>
									<div style="width: 200px;line-height: 2;">
									 任务中心运行的任务数量
									</div>
								</template>
								<el-icon><el-icon-question-filled /></el-icon>
							</el-tooltip>
						</h2>
						<p>65,715</p>
					</div>
					<div class="item">
						<h2>调度次数
							<el-tooltip effect="light">
								<template #content>
									<div style="width: 200px;line-height: 2;">
										任务中心触发的调度次数
									</div>
								</template>
								<el-icon><el-icon-question-filled /></el-icon>
							</el-tooltip>
						</h2>
						<p>8,936</p>
					</div>
					<div class="item">
						<h2>执行器数量
							<el-tooltip effect="light">
								<template #content>
									<div style="width: 200px;line-height: 2;">
										任务中心执行的协程数量
									</div>
								</template>
								<el-icon><el-icon-question-filled /></el-icon>
							</el-tooltip>
						</h2>
						<p>10,279</p>
					</div>
					<div class="item">
						<h2>平均执行时长
							<el-tooltip effect="light">
								<template #content>
									<div style="width: 200px;line-height: 2;">
										执行任务的平均耗时
									</div>
								</template>
								<el-icon><el-icon-question-filled /></el-icon>
							</el-tooltip>
						</h2>
						<p>00:19:05</p>
					</div>
				</div>
				<div class="chart">
					<el-row>
						<el-col :span="10">
							<scEcharts height="350px" :option="pie"></scEcharts>
						</el-col>
						<el-col :span="14">
							<scEcharts height="350px" :option="option"></scEcharts>
						</el-col>
					</el-row>
				</div>
			</el-card>
		</el-main>
	</el-container>
</template>

<script>
import scEcharts from '@/components/scEcharts';

export default {
	name: 'chartlist',
	components: {
		scEcharts
	},
	data(){
		return {
			dateType: "今天",
			date: [new Date(2000, 10, 10, 10, 10), new Date(2000, 10, 11, 10, 10)],
			data: [
				{
					type: "直接访问",
					pv: "57,847",
					uv: "7,129",
					ip: "8,330",
					out: "26.38%",
					time: "00:20:35"
				},
				{
					type: "搜索引擎",
					pv: "5,942",
					uv: "1,338",
					ip: "1,449",
					out: "33.49%",
					time: "00:11:31"
				},
				{
					type: "外部链接",
					pv: "1,926",
					uv: "469",
					ip: "500",
					out: "44.53%",
					time: "00:08:49"
				}
			],
			pie: {
				title: {
					text: '状态统计',
					left: 'center'
				},
				legend: {
					orient: 'vertical',
					left: 'left'
				},
				tooltip: {
					trigger: 'item'
				},
				series: [
					{
						name: '状态统计',
						type: 'pie',
						radius: ['55%', '70%'],
						itemStyle: {
							borderRadius: 5,
							borderColor: '#fff',
							borderWidth: 1
						},
						data: [
							{value: 1048, name: '成功'},
							{value: 235, name: '失败'},
							{value: 180, name: '终止'},
							{value: 180, name: '取消'}
						]
					}
				]
			},
			option: {
				legend: {
					data: ['成功', '取消', '终止']
				},
				tooltip: {
					trigger: 'axis'
				},
				xAxis: {
					type: 'category',
					data: ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00'],
					boundaryGap: false,
				},
				yAxis: {
					type: 'value'
				},
				series: [{
					name: '成功',
					data: [120, 210, 150, 80, 70, 110, 130],
					type: 'line',
				},
					{
						name: '取消',
						data: [110, 180, 120, 120, 60, 90, 110],
						type: 'line',
					},
					{
						name: '终止',
						data: [50, 90, 60, 60, 30, 40, 50],
						type: 'line',
					}]
			}
		}
	}
}
</script>

<style scoped>
.el-card {margin-bottom: 15px;}

.number-data {display: flex;}
.number-data .item {flex:1;border-right: 1px solid #f0f0f0;padding:0 20px;}
.number-data .item:last-child {border: 0;}
.number-data .item h2 {font-size: 12px;color: #787a7d;font-weight: normal;display: flex;align-items: center;}
.number-data .item h2 i {margin-left: 5px;color: #8cc5ff;cursor: pointer;}
.number-data .item p {font-size: 20px;color: #121315;margin-top: 10px;}

.chart {border-top: 1px solid #f0f0f0;margin-top: 20px;padding-top: 20px;}

[data-theme='dark'] .number-data .item {border-color: var(--el-border-color-base);}
[data-theme='dark'] .number-data .item p {color: #d0d0d0;}
[data-theme='dark'] .chart {border-color: var(--el-border-color-base);}
</style>

<template>
    <el-main>
        <el-row :gutter="15">
            <el-col :lg="24">
                <el-card shadow="never" header="选择资源组件（MineAdmin版)">
                    <el-alert title="只有上传文件" type="warning" />
                    <ma-resource-select :resource="false" @upload-data="handleSuccess" />

                    <el-alert title="有选择图片" type="warning" style="margin-top: 20px;" />
                    <ma-resource-select :resource="true" @upload-data="handleSuccess" />

                    <el-alert title="包含预览" type="warning" style="margin-top: 20px;" />
                    <ma-resource-select :resource="true" :thumb="true" :value="list" @upload-data="handleSuccess" />
                    <div class="selectResource">
                        <p>选择的资源：</p>
                        {{ list }}
                    </div>
                </el-card>

                <el-card shadow="never" header="城市联级选择器">
                    <el-alert title="返回城市编码" type="warning" />
                    <city-linkage v-model="cityDataCode" valueType="code"/>

                    <p>{{cityDataCode}}</p>

                    <el-alert title="返回城市名称" type="warning" class="mt" />
                    <city-linkage v-model="cityDataName" valueType="name"/>

                    <p class="value">{{cityDataName}}</p>
                </el-card>

                <el-card shadow="never" header="城市下拉联动选择器">
                    <el-alert title="返回城市编码" type="warning" />
                    <three-level-linkage v-model="cityDataCode2" valueType="code" />
                    <p>{{cityDataCode2}}</p>

                    <el-alert title="返回城市名称" type="warning" class="mt" />
                    <three-level-linkage v-model="cityDataName2" valueType="name" />
                    <p>{{cityDataName2}}</p>


                    <imageChip v-model="isPassing" :images="images" />

                </el-card>

            </el-col>
        </el-row>
    </el-main>
</template>
<script>
import cityLinkage from '@/components/maCityLinkage'
import threeLevelLinkage from '@/components/maCityLinkage/threeLevelLinkage'
import imageChip from '@/components/maDragVerify/imageChip'

export default {
    name: 'demo:index',

    components: {
        cityLinkage,
        threeLevelLinkage,
        imageChip
    },

    data () {
        return {
            list: [],
            cityDataCode: [],
            cityDataName: [],
            cityDataCode2: {},
            cityDataName2: {},
            isPassing: false,
            images: [
                'https://img1.baidu.com/it/u=2813520958,2218166536&fm=26&fmt=auto&gp=0.jpg',
                'https://ss0.bdstatic.com/70cFvHSh_Q1YnxGkpoWK1HF6hhy/it/u=1813762643,1914315241&fm=26&gp=0.jpg',
                'https://gimg2.baidu.com/image_search/src=http%3A%2F%2Fup.enterdesk.com%2Fedpic_360_360%2F13%2Fb0%2Fa9%2F13b0a9a111bdf4b70e7c9a9c1317a2b3.jpg&refer=http%3A%2F%2Fup.enterdesk.com&app=2002&size=f9999,10000&q=a80&n=0&g=0n&fmt=jpeg?sec=1638885184&t=0662b629206457db48ecdadc8da27bea',
            ]
        }
    },

    methods: {
        handleSuccess(data) {
            this.list = data
        }
    }
}
</script>

<style scoped>
.mt {
    margin-top: 15px;
}
.selectResource {
    margin: 15px 0;
    font-size: 14px;
    line-height: 25px;
}
.value {
    margin: 15px 0;
}
</style>
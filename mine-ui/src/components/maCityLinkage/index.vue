<template>
    <el-main style="padding-left: 0">
        <el-cascader
            v-model="defaultValue"
            :options="cityLinkageList"
            :props="{ expandTrigger: 'hover', value: valueType, label: 'name' }"
            filterable
            size="small"
            :placeholder="placeholder"
            clearable
        ></el-cascader>
    </el-main>
</template>

<script>
import cityLinkageJson from './lib/cityLinkageCascader.json';
export default {
    name: 'cityLinkage',


    props: {
        modelValue: {
            type: Object, 
            default: () => {} 
        },
        placeholder: {
            type: String,
            default: '请选择区域'
        },
        valueType: {
            type: String,
            default: 'code',
        },
        limitLevel: {
            type: String,
            default: '3'
        }
    },

    created() {
        // 处理层级数据
        switch (this.limitLevel) {
            case '1':
                cityLinkageJson.map(item => {
                    delete item.children
                    this.cityLinkageList.push(item)
                })
                break;
            case '2':
                cityLinkageJson.map(item => {
                    let children = item.children.map(city => {
                        delete city.children
                        return city
                    })
                    item.children = children
                    this.cityLinkageList.push(item)
                })
                break;
            default:
                this.cityLinkageList = cityLinkageJson
                break;
        }
    },

    watch:{
        valueType(val) {
            this.defaultType = val !== 'code' ? 'name' : 'code'
        },
        modelValue(val){
            this.defaultValue = val
        },
        defaultValue(val){
            this.$emit('update:modelValue', val)
        }
    },
    
    data () {
        return {
            cityLinkageList: [],
            defaultValue: '',
            defaultType: '',
        }
    }

}
</script>
<template>
    <el-popover placement="bottom" :width="520" trigger="click">
        <template #reference>
            <el-input v-model="defaultValue" placeholder="请输入Cron规则" clearable />
        </template>
        <el-tabs type="border-card" v-model="activeName">
            <el-tab-pane label="秒" name="second">
                <second :check="checkNumber" />
            </el-tab-pane>
            <el-tab-pane label="分钟" name="minute">
                
            </el-tab-pane>
            <el-tab-pane label="小时" name="hour">
                
            </el-tab-pane>
            <el-tab-pane label="日" name="day">
                
            </el-tab-pane>
            <el-tab-pane label="月" name="month">
                
            </el-tab-pane>
            <el-tab-pane label="周" name="week">
                
            </el-tab-pane>
        </el-tabs>
    </el-popover>
</template>

<script>
import second from './components/second'
export default {
    name: 'crontab:expression',

    components: {
        second,
    },

    props: {
        modelValue: {
            type: String,
            default: ''
        }
    },
    
    created () {
        this.defaultValue = this.modelValue
    },

    watch: {
        modelValue(val) {
            this.defaultValue = val
        },

        defaultValue(val) {
            this.$emit('update:modelValue', val)
        }
    },

    data() {
        return {
            defaultValue: '',
            activeName: 'second',
            second: '*',
            minute: '*',
            hour: '*',
            day: '*',
            month: '*',
            week: '*',
        }
    },

    methods: {
        handleChange() {
            let arr = [
                this.second,
                this.minute,
                this.hour,
                this.day,
                this.month,
                this.week,
            ]

            this.defaultValue = arr.join(' ')
        },

        checkNumber() {
            return 1;
        }
    }
}
</script>
(window.webpackJsonp=window.webpackJsonp||[]).push([["home-widgets-components-time"],{1905:function(e,t,n){"use strict";n("9555")},9555:function(e,t,n){},f369:function(e,t,n){"use strict";n.r(t);var o=n("7a23"),c={class:"time"};var i={title:"时钟",icon:"el-icon-clock",description:"演示部件效果",data:function(){return{time:"",day:""}},mounted:function(){var e=this;this.showTime(),setInterval((function(){e.showTime()}),1e3)},methods:{showTime:function(){this.time=this.$TOOL.dateFormat(new Date,"hh:mm:ss"),this.day=this.$TOOL.dateFormat(new Date,"yyyy年MM月dd日")}}},a=(n("1905"),n("6b0d"));const s=n.n(a)()(i,[["render",function(e,t,n,i,a,s){var r=Object(o.resolveComponent)("el-card");return Object(o.openBlock)(),Object(o.createBlock)(r,{shadow:"hover",header:"时钟",class:"item-background"},{default:Object(o.withCtx)((function(){return[Object(o.createElementVNode)("div",c,[Object(o.createElementVNode)("h2",null,Object(o.toDisplayString)(a.time),1),Object(o.createElementVNode)("p",null,Object(o.toDisplayString)(a.day),1)])]})),_:1})}],["__scopeId","data-v-8af9f95e"]]);t.default=s}}]);
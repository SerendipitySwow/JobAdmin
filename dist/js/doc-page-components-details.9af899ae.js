(window.webpackJsonp=window.webpackJsonp||[]).push([["doc-page-components-details"],{"360f":function(e,t,a){"use strict";a.r(t);a("b0c0"),a("a4d3"),a("e01a");var c=a("7a23"),n={class:"lh"},o=Object(c.createTextVNode)("接口信息"),r=Object(c.createTextVNode)("简易模式"),i=Object(c.createTextVNode)("复杂模式"),u={key:0},d=Object(c.createTextVNode)(" 简易模式下，只需要在接口后面带上 "),l=Object(c.createTextVNode)("app_id"),b=Object(c.createTextVNode)(" 和"),p=Object(c.createTextVNode)("app_secret"),j={key:1},O=Object(c.createTextVNode)(" 复杂模式下，先需要获取 "),s=Object(c.createTextVNode)("AccessToken"),f=Object(c.createTextVNode)("，再以此请求接口 "),V=Object(c.createTextVNode)("请求参数"),m=["innerHTML"],_=Object(c.createTextVNode)("是"),h=Object(c.createTextVNode)("否"),N=Object(c.createTextVNode)("响应参数"),w=Object(c.createTextVNode)("接口介绍"),x=["innerHTML"],C=Object(c.createTextVNode)("返回示例");var v=a("1da1"),y=(a("d81d"),a("96cf"),a("bff7")),D={components:{maHighlight:a("6dd0").a,simRequest:y.default},data:function(){return{drawer:!1,apiData:{},activeName:"params",requestData:[],responseData:[],api_data_type:[]}},methods:{open:function(e){var t=this;return Object(v.a)(regeneratorRuntime.mark((function a(){return regeneratorRuntime.wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return t.apiData=e,t.responseData=[],t.requestData=[],a.next=5,t.getColumnList();case 5:return a.next=7,t.getDictData();case 7:t.drawer=!0;case 8:case"end":return a.stop()}}),a)})))()},getColumnList:function(){var e=this;this.$API.apiDoc.getColumnList(this.apiData.id).then((function(t){t.data.api_column.map((function(t){"0"===t.type?e.requestData.push(t):e.responseData.push(t)}))}))},getDictData:function(){var e=this;this.getDict("api_data_type").then((function(t){e.api_data_type=t.data}))}}},k=(a("d7dc"),a("6b0d"));const g=a.n(k)()(D,[["render",function(e,t,a,v,y,D){var k=Object(c.resolveComponent)("el-divider"),g=Object(c.resolveComponent)("el-descriptions-item"),T=Object(c.resolveComponent)("el-tag"),B=Object(c.resolveComponent)("el-descriptions"),q=Object(c.resolveComponent)("el-card"),L=Object(c.resolveComponent)("el-table-column"),E=Object(c.resolveComponent)("ma-dict-tag"),H=Object(c.resolveComponent)("el-table"),M=Object(c.resolveComponent)("ma-highlight"),R=Object(c.resolveComponent)("el-tab-pane"),S=Object(c.resolveComponent)("sim-request"),A=Object(c.resolveComponent)("el-tabs"),I=Object(c.resolveComponent)("el-main"),J=Object(c.resolveComponent)("el-drawer");return Object(c.openBlock)(),Object(c.createBlock)(J,{modelValue:y.drawer,"onUpdate:modelValue":t[1]||(t[1]=function(e){return y.drawer=e}),"with-header":!1,size:"50%"},{default:Object(c.withCtx)((function(){return[Object(c.createVNode)(I,null,{default:Object(c.withCtx)((function(){return[Object(c.createElementVNode)("h2",n,Object(c.toDisplayString)(y.apiData.name),1),Object(c.createVNode)(A,{modelValue:y.activeName,"onUpdate:modelValue":t[0]||(t[0]=function(e){return y.activeName=e})},{default:Object(c.withCtx)((function(){return[Object(c.createVNode)(R,{label:"参数列表",name:"params"},{default:Object(c.withCtx)((function(){return[Object(c.createVNode)(k,{"content-position":"left"},{default:Object(c.withCtx)((function(){return[o]})),_:1}),Object(c.createVNode)(B,{column:1,border:""},{default:Object(c.withCtx)((function(){return[Object(c.createVNode)(g,{label:"接口地址"},{default:Object(c.withCtx)((function(){return[Object(c.createTextVNode)(" /api/v1/"+Object(c.toDisplayString)(y.apiData.access_name),1)]})),_:1}),Object(c.createVNode)(g,{label:"认证模式"},{default:Object(c.withCtx)((function(){return["0"===y.apiData.auth_mode?(Object(c.openBlock)(),Object(c.createBlock)(T,{key:0,type:"success"},{default:Object(c.withCtx)((function(){return[r]})),_:1})):(Object(c.openBlock)(),Object(c.createBlock)(T,{key:1,type:"danger"},{default:Object(c.withCtx)((function(){return[i]})),_:1}))]})),_:1}),Object(c.createVNode)(g,{label:"认证说明"},{default:Object(c.withCtx)((function(){return["0"===y.apiData.auth_mode?(Object(c.openBlock)(),Object(c.createElementBlock)("div",u,[d,Object(c.createVNode)(T,null,{default:Object(c.withCtx)((function(){return[l]})),_:1}),b,Object(c.createVNode)(T,null,{default:Object(c.withCtx)((function(){return[p]})),_:1})])):(Object(c.openBlock)(),Object(c.createElementBlock)("div",j,[O,Object(c.createVNode)(T,null,{default:Object(c.withCtx)((function(){return[s]})),_:1}),f]))]})),_:1})]})),_:1}),Object(c.createVNode)(k,{"content-position":"left"},{default:Object(c.withCtx)((function(){return[V]})),_:1}),Object(c.createVNode)(H,{data:y.requestData,stripe:"",style:{width:"100%"}},{default:Object(c.withCtx)((function(){return[Object(c.createVNode)(L,{type:"expand"},{default:Object(c.withCtx)((function(e){return[Object(c.createVNode)(q,{style:{width:"99%",margin:"0 auto"}},{default:Object(c.withCtx)((function(){return[Object(c.createElementVNode)("div",{innerHTML:e.row.description},null,8,m)]})),_:2},1024)]})),_:1}),Object(c.createVNode)(L,{prop:"name",label:"参数名"}),Object(c.createVNode)(L,{prop:"data_type",label:"参数名"},{default:Object(c.withCtx)((function(e){return[Object(c.createVNode)(E,{options:y.api_data_type,value:e.row.data_type},null,8,["options","value"])]})),_:1}),Object(c.createVNode)(L,{prop:"is_required",label:"必填"},{default:Object(c.withCtx)((function(e){return["0"===e.row.is_required?(Object(c.openBlock)(),Object(c.createBlock)(T,{key:0,type:"danger"},{default:Object(c.withCtx)((function(){return[_]})),_:1})):(Object(c.openBlock)(),Object(c.createBlock)(T,{key:1,type:"success"},{default:Object(c.withCtx)((function(){return[h]})),_:1}))]})),_:1}),Object(c.createVNode)(L,{prop:"default_value",label:"默认值"},{default:Object(c.withCtx)((function(e){return[Object(c.createTextVNode)(Object(c.toDisplayString)(e.row.default_value?e.row.default_value:"-"),1)]})),_:1})]})),_:1},8,["data"]),Object(c.createVNode)(k,{"content-position":"left"},{default:Object(c.withCtx)((function(){return[N]})),_:1}),Object(c.createVNode)(H,{data:y.responseData,stripe:"",style:{width:"100%"}},{default:Object(c.withCtx)((function(){return[Object(c.createVNode)(L,{type:"expand"},{default:Object(c.withCtx)((function(e){return[Object(c.createVNode)(M,{code:e.row.description,lang:"js"},null,8,["code"])]})),_:1}),Object(c.createVNode)(L,{prop:"name",label:"参数名"}),Object(c.createVNode)(L,{prop:"data_type",label:"参数名"},{default:Object(c.withCtx)((function(e){return[Object(c.createVNode)(E,{options:y.api_data_type,value:e.row.data_type},null,8,["options","value"])]})),_:1}),Object(c.createVNode)(L,{prop:"updated_at",label:"更新时间"})]})),_:1},8,["data"]),Object(c.createVNode)(k,{"content-position":"left"},{default:Object(c.withCtx)((function(){return[w]})),_:1}),Object(c.createVNode)(q,null,{default:Object(c.withCtx)((function(){return[Object(c.createElementVNode)("div",{innerHTML:y.apiData.description?y.apiData.description:"暂无介绍"},null,8,x)]})),_:1}),Object(c.createVNode)(k,{"content-position":"left"},{default:Object(c.withCtx)((function(){return[C]})),_:1}),Object(c.createVNode)(M,{code:y.apiData.response,lang:"js"},null,8,["code"])]})),_:1}),Object(c.createVNode)(R,{label:"模拟请求",name:"request"},{default:Object(c.withCtx)((function(){return[Object(c.createVNode)(S,{url:y.apiData.access_name},null,8,["url"])]})),_:1})]})),_:1},8,["modelValue"])]})),_:1})]})),_:1},8,["modelValue"])}],["__scopeId","data-v-6c0757d6"]]);t.default=g},"6f32":function(e,t,a){},d7dc:function(e,t,a){"use strict";a("6f32")}}]);
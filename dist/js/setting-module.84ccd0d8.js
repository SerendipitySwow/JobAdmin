(window.webpackJsonp=window.webpackJsonp||[]).push([["setting-module","setting-module-save"],{"5a65":function(e,t,n){"use strict";n.r(t);n("b0c0");var r=n("7a23"),o={class:"left-panel"},a=Object(r.createTextVNode)("新增"),l={class:"right-panel"},c={class:"right-panel-search"},i=Object(r.createTextVNode)(" 更多筛选"),u=Object(r.createElementVNode)("i",{class:"el-icon-arrow-down el-icon--right"},null,-1),s=Object(r.createTextVNode)("删除");var d=n("1da1"),b=(n("96cf"),{name:"setting:module",components:{saveDialog:n("fc84").default},data:function(){return{dialog:{save:!1},povpoerShow:!1,api:{list:this.$API.module.getPageList},queryParams:{name:void 0,label:void 0}}},methods:{add:function(){var e=this;this.dialog.save=!0,this.$nextTick((function(){e.$refs.saveDialog.open()}))},handleDelete:function(e){var t=this;return Object(d.a)(regeneratorRuntime.mark((function n(){return regeneratorRuntime.wrap((function(n){for(;;)switch(n.prev=n.next){case 0:return n.next=2,t.$confirm("确定删除该模块吗？","提示",{type:"warning"}).then((function(){var n=t.$loading();t.$API.module.deletes(e).then((function(){t.$refs.table.upData(t.queryParams)})),n.close(),t.$message.success("操作成功")})).catch((function(){}));case 2:case"end":return n.stop()}}),n)})))()},handlerSearch:function(){this.$refs.table.upData(this.queryParams)},resetSearch:function(){this.queryParams={name:void 0,label:void 0},this.$refs.table.upData(this.queryParams)},handleSuccess:function(){this.$refs.table.upData(this.queryParams)}}}),m=n("6b0d");const f=n.n(m)()(b,[["render",function(e,t,n,d,b,m){var f=Object(r.resolveComponent)("el-button"),p=Object(r.resolveComponent)("el-input"),j=Object(r.resolveComponent)("el-tooltip"),O=Object(r.resolveComponent)("el-form-item"),h=Object(r.resolveComponent)("el-form"),v=Object(r.resolveComponent)("el-popover"),V=Object(r.resolveComponent)("el-header"),g=Object(r.resolveComponent)("el-table-column"),w=Object(r.resolveComponent)("maTable"),C=Object(r.resolveComponent)("el-main"),N=Object(r.resolveComponent)("el-container"),x=Object(r.resolveComponent)("save-dialog"),k=Object(r.resolveDirective)("auth");return Object(r.openBlock)(),Object(r.createElementBlock)(r.Fragment,null,[Object(r.createVNode)(N,null,{default:Object(r.withCtx)((function(){return[Object(r.createVNode)(V,null,{default:Object(r.withCtx)((function(){return[Object(r.createElementVNode)("div",o,[Object(r.withDirectives)(Object(r.createVNode)(f,{icon:"el-icon-plus",type:"primary",onClick:m.add},{default:Object(r.withCtx)((function(){return[a]})),_:1},8,["onClick"]),[[k,["setting:module:save"]]])]),Object(r.createElementVNode)("div",l,[Object(r.createElementVNode)("div",c,[Object(r.createVNode)(p,{modelValue:b.queryParams.label,"onUpdate:modelValue":t[0]||(t[0]=function(e){return b.queryParams.label=e}),placeholder:"模块标签",clearable:""},null,8,["modelValue"]),Object(r.createVNode)(j,{class:"item",effect:"dark",content:"搜索",placement:"top"},{default:Object(r.withCtx)((function(){return[Object(r.createVNode)(f,{type:"primary",icon:"el-icon-search",onClick:m.handlerSearch},null,8,["onClick"])]})),_:1}),Object(r.createVNode)(j,{class:"item",effect:"dark",content:"清空条件",placement:"top"},{default:Object(r.withCtx)((function(){return[Object(r.createVNode)(f,{icon:"el-icon-refresh",onClick:m.resetSearch},null,8,["onClick"])]})),_:1}),Object(r.createVNode)(v,{placement:"bottom-end",width:450,trigger:"click"},{reference:Object(r.withCtx)((function(){return[Object(r.createVNode)(f,{type:"text",onClick:t[1]||(t[1]=function(e){return b.povpoerShow=!b.povpoerShow})},{default:Object(r.withCtx)((function(){return[i,u]})),_:1})]})),default:Object(r.withCtx)((function(){return[Object(r.createVNode)(h,{"label-width":"80px"},{default:Object(r.withCtx)((function(){return[Object(r.createVNode)(O,{label:"模块名称",prop:"name"},{default:Object(r.withCtx)((function(){return[Object(r.createVNode)(p,{modelValue:b.queryParams.name,"onUpdate:modelValue":t[2]||(t[2]=function(e){return b.queryParams.name=e}),placeholder:"模块名称",clearable:""},null,8,["modelValue"])]})),_:1})]})),_:1})]})),_:1})])])]})),_:1}),Object(r.createVNode)(C,{class:"nopadding"},{default:Object(r.withCtx)((function(){return[Object(r.createVNode)(w,{ref:"table",api:b.api,stripe:""},{default:Object(r.withCtx)((function(){return[Object(r.createVNode)(g,{label:"模块名称",prop:"name",width:"150"}),Object(r.createVNode)(g,{label:"模块名称",prop:"label",width:"150"}),Object(r.createVNode)(g,{label:"版本",prop:"version",width:"130"}),Object(r.createVNode)(g,{label:"描述",prop:"description"}),Object(r.createVNode)(g,{label:"状态",prop:"installed",width:"100"},{default:Object(r.withCtx)((function(e){return[Object(r.createTextVNode)(Object(r.toDisplayString)(e.row.installed?"正常":"已卸载"),1)]})),_:1}),Object(r.createVNode)(g,{label:"操作",fixed:"right",align:"right",width:"130"},{default:Object(r.withCtx)((function(e){return[Object(r.withDirectives)(Object(r.createVNode)(f,{type:"text",disabled:"System"==e.row.name||"Setting"==e.row.name,onClick:function(t){return m.handleDelete(e.row.name)}},{default:Object(r.withCtx)((function(){return[s]})),_:2},1032,["disabled","onClick"]),[[k,["setting:module:delete"]]])]})),_:1})]})),_:1},8,["api"])]})),_:1})]})),_:1}),b.dialog.save?(Object(r.openBlock)(),Object(r.createBlock)(x,{key:0,ref:"saveDialog",onSuccess:m.handleSuccess,onClosed:t[3]||(t[3]=function(e){return b.dialog.save=!1})},null,8,["onSuccess"])):Object(r.createCommentVNode)("",!0)],64)}]]);t.default=f},fc84:function(e,t,n){"use strict";n.r(t);n("b0c0"),n("a4d3"),n("e01a");var r=n("7a23"),o=Object(r.createTextVNode)("取 消"),a=Object(r.createTextVNode)("保 存");var l=n("1da1"),c=(n("96cf"),{emits:["success","closed"],data:function(){return{form:{name:null,label:null,version:null,description:null},rules:{name:[{required:!0,pattern:/^[A-Za-z]{2,}$/g,message:"名称必须是2位以上的英文",trigger:"blur"}],label:[{required:!0,message:"模块标签必填",trigger:"blur"}],version:[{required:!0,pattern:/^[0-9\.]{3,}$/g,message:"版本号必须包含数字和小数点",trigger:"blur"}],description:[{required:!0,message:"模块功能描述必填",trigger:"blur"}]},visible:!1,isSaveing:!1}},methods:{open:function(){this.visible=!0},submit:function(){var e=this;this.$refs.dialogForm.validate(function(){var t=Object(l.a)(regeneratorRuntime.mark((function t(n){var r;return regeneratorRuntime.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(!n){t.next=7;break}return e.isSaveing=!0,t.next=4,e.$API.module.save(e.form);case 4:r=t.sent,e.isSaveing=!1,r.success?(e.$emit("success",e.form,e.mode),e.visible=!1,e.$message.success(r.message)):e.$alert(r.message,"提示",{type:"error"});case 7:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}())}}}),i=n("6b0d");const u=n.n(i)()(c,[["render",function(e,t,n,l,c,i){var u=Object(r.resolveComponent)("el-input"),s=Object(r.resolveComponent)("el-form-item"),d=Object(r.resolveComponent)("el-form"),b=Object(r.resolveComponent)("el-button"),m=Object(r.resolveComponent)("el-dialog");return Object(r.openBlock)(),Object(r.createBlock)(m,{title:"创建新模块",modelValue:c.visible,"onUpdate:modelValue":t[6]||(t[6]=function(e){return c.visible=e}),width:500,"destroy-on-close":"",onClosed:t[7]||(t[7]=function(t){return e.$emit("closed")})},{footer:Object(r.withCtx)((function(){return[Object(r.createVNode)(b,{onClick:t[4]||(t[4]=function(e){return c.visible=!1})},{default:Object(r.withCtx)((function(){return[o]})),_:1}),Object(r.createVNode)(b,{type:"primary",loading:c.isSaveing,onClick:t[5]||(t[5]=function(e){return i.submit()})},{default:Object(r.withCtx)((function(){return[a]})),_:1},8,["loading"])]})),default:Object(r.withCtx)((function(){return[Object(r.createVNode)(d,{model:c.form,rules:c.rules,ref:"dialogForm","label-width":"80px"},{default:Object(r.withCtx)((function(){return[Object(r.createVNode)(s,{label:"模块名称",prop:"name"},{default:Object(r.withCtx)((function(){return[Object(r.createVNode)(u,{modelValue:c.form.name,"onUpdate:modelValue":t[0]||(t[0]=function(e){return c.form.name=e}),size:"small",placeholder:"请输入模块名称（英文名称）"},null,8,["modelValue"])]})),_:1}),Object(r.createVNode)(s,{label:"模块标签",prop:"label"},{default:Object(r.withCtx)((function(){return[Object(r.createVNode)(u,{modelValue:c.form.label,"onUpdate:modelValue":t[1]||(t[1]=function(e){return c.form.label=e}),size:"small",placeholder:"请输入模块标签（中文名称）"},null,8,["modelValue"])]})),_:1}),Object(r.createVNode)(s,{label:"版本号",prop:"version"},{default:Object(r.withCtx)((function(){return[Object(r.createVNode)(u,{modelValue:c.form.version,"onUpdate:modelValue":t[2]||(t[2]=function(e){return c.form.version=e}),size:"small",placeholder:"请输入版本号"},null,8,["modelValue"])]})),_:1}),Object(r.createVNode)(s,{label:"描述",prop:"description"},{default:Object(r.withCtx)((function(){return[Object(r.createVNode)(u,{modelValue:c.form.description,"onUpdate:modelValue":t[3]||(t[3]=function(e){return c.form.description=e}),type:"textarea",rows:3,size:"small",placeholder:"请输入模块功能描述"},null,8,["modelValue"])]})),_:1})]})),_:1},8,["model","rules"])]})),_:1},8,["modelValue"])}]]);t.default=u}}]);
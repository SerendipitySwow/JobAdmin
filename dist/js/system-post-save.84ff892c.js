(window.webpackJsonp=window.webpackJsonp||[]).push([["system-post-save"],{"2b32":function(e,t,r){"use strict";r.r(t);r("b0c0"),r("4e82");var o=r("7a23"),n=Object(o.createTextVNode)("启用"),a=Object(o.createTextVNode)("停用"),l=Object(o.createTextVNode)("取 消"),c=Object(o.createTextVNode)("保 存");var u=r("1da1"),i=(r("96cf"),{emits:["success","closed"],data:function(){return{mode:"add",titleMap:{add:"新增岗位",edit:"编辑岗位"},form:{id:null,name:null,code:null,status:"0",sort:0,remark:null},rules:{name:[{required:!0,message:"请输入岗位名称",trigger:"blur"}],code:[{required:!0,message:"请输入岗位代码",trigger:"blur"}]},visible:!1,isSaveing:!1}},methods:{open:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"add";return this.mode=e,this.visible=!0,this},submit:function(){var e=this;this.$refs.dialogForm.validate(function(){var t=Object(u.a)(regeneratorRuntime.mark((function t(r){var o;return regeneratorRuntime.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(!r){t.next=14;break}if(e.isSaveing=!0,o=null,"add"!=e.mode){t.next=9;break}return t.next=6,e.$API.post.save(e.form);case 6:o=t.sent,t.next=12;break;case 9:return t.next=11,e.$API.post.update(e.form.id,e.form);case 11:o=t.sent;case 12:e.isSaveing=!1,o.success?(e.$emit("success",e.form,e.mode),e.visible=!1,e.$message.success(o.message)):e.$alert(o.message,"提示",{type:"error"});case 14:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}())},setData:function(e){this.form.id=e.id,this.form.name=e.name,this.form.code=e.code,this.form.status=e.status,this.form.sort=e.sort,this.form.remark=e.remark}}}),s=r("6b0d");const d=r.n(s)()(i,[["render",function(e,t,r,u,i,s){var d=Object(o.resolveComponent)("el-input"),m=Object(o.resolveComponent)("el-form-item"),b=Object(o.resolveComponent)("el-input-number"),f=Object(o.resolveComponent)("el-radio"),p=Object(o.resolveComponent)("el-radio-group"),j=Object(o.resolveComponent)("el-form"),O=Object(o.resolveComponent)("el-button"),V=Object(o.resolveComponent)("el-dialog");return Object(o.openBlock)(),Object(o.createBlock)(V,{title:i.titleMap[i.mode],modelValue:i.visible,"onUpdate:modelValue":t[7]||(t[7]=function(e){return i.visible=e}),width:500,"destroy-on-close":"",onClosed:t[8]||(t[8]=function(t){return e.$emit("closed")})},{footer:Object(o.withCtx)((function(){return[Object(o.createVNode)(O,{onClick:t[5]||(t[5]=function(e){return i.visible=!1})},{default:Object(o.withCtx)((function(){return[l]})),_:1}),Object(o.createVNode)(O,{type:"primary",loading:i.isSaveing,onClick:t[6]||(t[6]=function(e){return s.submit()})},{default:Object(o.withCtx)((function(){return[c]})),_:1},8,["loading"])]})),default:Object(o.withCtx)((function(){return[Object(o.createVNode)(j,{model:i.form,rules:i.rules,ref:"dialogForm","label-width":"80px"},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(m,{label:"岗位名称",prop:"name"},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(d,{modelValue:i.form.name,"onUpdate:modelValue":t[0]||(t[0]=function(e){return i.form.name=e}),size:"small",clearable:"",placeholder:"请输入岗位名称"},null,8,["modelValue"])]})),_:1}),Object(o.createVNode)(m,{label:"代码",prop:"code"},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(d,{modelValue:i.form.code,"onUpdate:modelValue":t[1]||(t[1]=function(e){return i.form.code=e}),size:"small",clearable:"",placeholder:"请输入岗位代码"},null,8,["modelValue"])]})),_:1}),Object(o.createVNode)(m,{label:"排序",prop:"sort"},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(b,{modelValue:i.form.sort,"onUpdate:modelValue":t[2]||(t[2]=function(e){return i.form.sort=e}),size:"small",clearable:"",min:0,max:999,label:"排序"},null,8,["modelValue"])]})),_:1}),Object(o.createVNode)(m,{label:"状态",prop:"status"},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(p,{modelValue:i.form.status,"onUpdate:modelValue":t[3]||(t[3]=function(e){return i.form.status=e})},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(f,{label:"0"},{default:Object(o.withCtx)((function(){return[n]})),_:1}),Object(o.createVNode)(f,{label:"1"},{default:Object(o.withCtx)((function(){return[a]})),_:1})]})),_:1},8,["modelValue"])]})),_:1}),Object(o.createVNode)(m,{label:"备注",prop:"remark"},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(d,{type:"textarea",size:"small",clearable:"",rows:3,placeholder:"备注信息",modelValue:i.form.remark,"onUpdate:modelValue":t[4]||(t[4]=function(e){return i.form.remark=e}),maxlength:"255","show-word-limit":""},null,8,["modelValue"])]})),_:1})]})),_:1},8,["model","rules"])]})),_:1},8,["title","modelValue"])}]]);t.default=d}}]);
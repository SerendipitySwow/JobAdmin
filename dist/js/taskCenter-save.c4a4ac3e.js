(window.webpackJsonp=window.webpackJsonp||[]).push([["taskCenter-save","chunk-2d0ced70"],{1707:function(e,t,n){"use strict";n.r(t);n("b0c0");var o=n("7a23"),r=Object(o.createTextVNode)("取 消"),a=Object(o.createTextVNode)("保 存");var l=n("1da1"),i=(n("96cf"),{emits:["success","closed"],components:{editor:n("60bb").default},data:function(){return{mode:"add",titleMap:{add:"新增任务列表",edit:"编辑任务列表"},treeList:[],form:{id:"",is_deleted:"",status:"",app_key:"",task_no:"",step:"",runtime:"",content:"",created_at:"",timeout:"",name:"",coroutine_id:"",memo:"",result:"",retry_times:"",consul_service_id:""},rules:{},visible:!1,isSaveing:!1}},created:function(){var e=this;return Object(l.a)(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.getDictData();case 2:case"end":return t.stop()}}),t)})))()},methods:{open:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"add";return this.mode=e,this.visible=!0,this},submit:function(){var e=this;this.$refs.dialogForm.validate(function(){var t=Object(l.a)(regeneratorRuntime.mark((function t(n){var o;return regeneratorRuntime.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(!n){t.next=14;break}if(e.isSaveing=!0,o=null,"add"!=e.mode){t.next=9;break}return t.next=6,e.$API.missionTask.save(e.form);case 6:o=t.sent,t.next=12;break;case 9:return t.next=11,e.$API.missionTask.update(e.form.id,e.form);case 11:o=t.sent;case 12:e.isSaveing=!1,o.success?(e.$emit("success",e.form,e.mode),e.visible=!1,e.$message.success(o.message)):e.$alert(o.message,"提示",{type:"error"});case 14:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}())},setData:function(e){this.form.id=e.id,this.form.is_deleted=e.is_deleted,this.form.status=e.status,this.form.app_key=e.app_key,this.form.task_no=e.task_no,this.form.step=e.step,this.form.runtime=e.runtime,this.form.content=e.content,this.form.created_at=e.created_at,this.form.timeout=e.timeout,this.form.name=e.name,this.form.coroutine_id=e.coroutine_id,this.form.memo=e.memo,this.form.result=e.result,this.form.retry_times=e.retry_times,this.form.consul_service_id=e.consul_service_id},getDictData:function(){}}}),c=n("6b0d");const u=n.n(c)()(i,[["render",function(e,t,n,l,i,c){var u=Object(o.resolveComponent)("el-input"),d=Object(o.resolveComponent)("el-form-item"),s=Object(o.resolveComponent)("el-form"),m=Object(o.resolveComponent)("el-button"),f=Object(o.resolveComponent)("el-dialog");return Object(o.openBlock)(),Object(o.createBlock)(f,{title:i.titleMap[i.mode],modelValue:i.visible,"onUpdate:modelValue":t[11]||(t[11]=function(e){return i.visible=e}),width:500,"destroy-on-close":"",onClosed:t[12]||(t[12]=function(t){return e.$emit("closed")})},{footer:Object(o.withCtx)((function(){return[Object(o.createVNode)(m,{onClick:t[9]||(t[9]=function(e){return i.visible=!1})},{default:Object(o.withCtx)((function(){return[r]})),_:1}),Object(o.createVNode)(m,{type:"primary",loading:i.isSaveing,onClick:t[10]||(t[10]=function(e){return c.submit()})},{default:Object(o.withCtx)((function(){return[a]})),_:1},8,["loading"])]})),default:Object(o.withCtx)((function(){return[Object(o.createVNode)(s,{model:i.form,rules:i.rules,ref:"dialogForm","label-width":"80px"},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(d,{label:"任务状态",prop:"status"},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(u,{modelValue:i.form.status,"onUpdate:modelValue":t[0]||(t[0]=function(e){return i.form.status=e}),clearable:"",placeholder:"请输入任务状态 0:待处理 1:处理中 2:已处理 3:已取消 4:处理失败"},null,8,["modelValue"])]})),_:1}),Object(o.createVNode)(d,{label:"重试间隔(秒)",prop:"step"},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(u,{modelValue:i.form.step,"onUpdate:modelValue":t[1]||(t[1]=function(e){return i.form.step=e}),clearable:"",placeholder:"请输入重试间隔(秒)"},null,8,["modelValue"])]})),_:1}),Object(o.createVNode)(d,{label:"执行时间",prop:"runtime"},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(u,{modelValue:i.form.runtime,"onUpdate:modelValue":t[2]||(t[2]=function(e){return i.form.runtime=e}),clearable:"",placeholder:"请输入执行时间"},null,8,["modelValue"])]})),_:1}),Object(o.createVNode)(d,{label:"任务内容",prop:"content"},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(u,{modelValue:i.form.content,"onUpdate:modelValue":t[3]||(t[3]=function(e){return i.form.content=e}),clearable:"",placeholder:"请输入任务内容"},null,8,["modelValue"])]})),_:1}),Object(o.createVNode)(d,{label:"任务执行时间",prop:"timeout"},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(u,{modelValue:i.form.timeout,"onUpdate:modelValue":t[4]||(t[4]=function(e){return i.form.timeout=e}),clearable:"",placeholder:"请输入任务执行时间"},null,8,["modelValue"])]})),_:1}),Object(o.createVNode)(d,{label:"任务名称",prop:"name"},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(u,{modelValue:i.form.name,"onUpdate:modelValue":t[5]||(t[5]=function(e){return i.form.name=e}),clearable:"",placeholder:"请输入任务名称"},null,8,["modelValue"])]})),_:1}),Object(o.createVNode)(d,{label:"错误信息",prop:"memo"},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(u,{modelValue:i.form.memo,"onUpdate:modelValue":t[6]||(t[6]=function(e){return i.form.memo=e}),clearable:"",placeholder:"请输入当任务执行出现错误时,记录错误信息"},null,8,["modelValue"])]})),_:1}),Object(o.createVNode)(d,{label:"重试次数",prop:"retry_times"},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(u,{modelValue:i.form.retry_times,"onUpdate:modelValue":t[7]||(t[7]=function(e){return i.form.retry_times=e}),clearable:"",placeholder:"请输入重试次数"},null,8,["modelValue"])]})),_:1}),Object(o.createVNode)(d,{label:"consul运行服务的ID",prop:"consul_service_id"},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(u,{modelValue:i.form.consul_service_id,"onUpdate:modelValue":t[8]||(t[8]=function(e){return i.form.consul_service_id=e}),clearable:"",placeholder:"请输入consul运行服务的ID"},null,8,["modelValue"])]})),_:1})]})),_:1},8,["model","rules"])]})),_:1},8,["title","modelValue"])}]]);t.default=u},"60bb":function(e,t,n){"use strict";n.r(t);var o=n("7a23"),r={class:"sceditor"};var a=n("1da1"),l=(n("96cf"),n("a9e3"),n("365c")),i=n("ca72"),c=n("e562"),u=n.n(c),d=(n("0d68"),n("ec27"),n("64d8"),n("4ea8"),n("4237"),n("0a9d"),n("07d1"),{components:{Editor:i.a},props:{modelValue:{type:String,default:""},placeholder:{type:String,default:""},height:{type:Number,default:300},disabled:{type:Boolean,default:!1},plugins:{type:[String,Array],default:"code image link preview table"},toolbar:{type:[String,Array],default:"undo redo |  forecolor backcolor bold italic underline strikethrough link | formatselect fontselect fontsizeselect | \t\t\t\t\talignleft aligncenter alignright alignjustify outdent indent lineheight | bullist numlist | \t\t\t\t\timage table  preview | code selectall"}},data:function(){return{init:{language_url:"tinymce/langs/zh_CN.js",language:"zh_CN",skin_url:"tinymce/skins/ui/oxide",content_css:"tinymce/skins/content/default/content.css",menubar:!1,statusbar:!0,plugins:this.plugins,toolbar:this.toolbar,fontsize_formats:"12px 14px 16px 18px 20px 22px 24px 28px 32px 36px 48px 56px 72px",height:this.height,placeholder:this.placeholder,branding:!1,resize:!0,elementpath:!0,content_style:"",images_upload_handler:(e=Object(a.a)(regeneratorRuntime.mark((function e(t,n,o){var r,a;return regeneratorRuntime.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return(r=new FormData).append("image",t.blob(),t.filename()),e.prev=2,e.next=5,l.a.upload.uploadImage(r);case 5:a=e.sent,n(a.data.url),e.next=12;break;case 9:e.prev=9,e.t0=e.catch(2),o("图片上传失败");case 12:case"end":return e.stop()}}),e,null,[[2,9]])}))),function(t,n,o){return e.apply(this,arguments)}),setup:function(e){e.on("init",(function(){this.getBody().style.fontSize="14px"}))}},contentValue:this.modelValue};var e},watch:{modelValue:function(e){this.contentValue=e},contentValue:function(e){this.$emit("update:modelValue",e)}},mounted:function(){u.a.init({})},methods:{onClick:function(e){this.$emit("onClick",e,u.a)}}}),s=n("6b0d");const m=n.n(s)()(d,[["render",function(e,t,n,a,l,i){var c=Object(o.resolveComponent)("Editor");return Object(o.openBlock)(),Object(o.createElementBlock)("div",r,[Object(o.createVNode)(c,{modelValue:l.contentValue,"onUpdate:modelValue":t[0]||(t[0]=function(e){return l.contentValue=e}),init:l.init,disabled:n.disabled,placeholder:n.placeholder,onOnClick:i.onClick},null,8,["modelValue","init","disabled","placeholder","onOnClick"])])}]]);t.default=m}}]);
(window.webpackJsonp=window.webpackJsonp||[]).push([["system-api-save","chunk-2d0ced70"],{"0ed5":function(e,t,a){"use strict";a.r(t);a("b0c0"),a("a4d3"),a("e01a");var n=a("7a23"),o=Object(n.createTextVNode)("简易模式"),r=Object(n.createTextVNode)("复杂模式"),l=Object(n.createTextVNode)("取 消"),c=Object(n.createTextVNode)("保 存");var u=a("1da1"),i=(a("d3b7"),a("159b"),a("b64b"),a("96cf"),a("60bb")),d=a("2b19"),s={emits:["success","closed"],components:{editor:i.default,maJsonEditor:d.a},data:function(){return{mode:"add",activeName:"base",titleMap:{add:"新增接口",edit:"编辑接口"},form:{id:"",group_id:"",name:"",access_name:"",class_name:"",method_name:"",auth_mode:"0",request_mode:"A",description:"",response:"{\n  code: 200,\n  success: true,\n  message: '请求成功',\n  data: []\n}",status:"0",remark:""},rules:{group_id:[{required:!0,message:"接口分组必选",trigger:"change"}],name:[{required:!0,message:"接口名称必填",trigger:"blur"}],access_name:[{required:!0,message:"访问名称必填",trigger:"blur"}],class_name:[{required:!0,message:"类名称必填",trigger:"blur"}],method_name:[{required:!0,message:"方法名必填",trigger:"blur"}],auth_mode:[{required:!0,message:"认证模式必填",trigger:"blur"}],request_mode:[{required:!0,message:"请求模式必填",trigger:"blur"}]},visible:!1,isSaveing:!1,request_mode_data:[],data_status_data:[],groupData:[],modules:[]}},methods:{open:function(){var e=arguments,t=this;return Object(u.a)(regeneratorRuntime.mark((function a(){var n;return regeneratorRuntime.wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return n=e.length>0&&void 0!==e[0]?e[0]:"add",a.next=3,t.getDictData();case 3:return a.next=5,t.getGroupData();case 5:return a.next=7,t.getModuleList();case 7:return t.mode=n,t.visible=!0,a.abrupt("return",t);case 10:case"end":return a.stop()}}),a)})))()},submit:function(){var e=this;this.$refs.dialogForm.validate(function(){var t=Object(u.a)(regeneratorRuntime.mark((function t(a){var n;return regeneratorRuntime.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(!a){t.next=14;break}if(e.isSaveing=!0,n=null,"add"!=e.mode){t.next=9;break}return t.next=6,e.$API.api.save(e.form);case 6:n=t.sent,t.next=12;break;case 9:return t.next=11,e.$API.api.update(e.form.id,e.form);case 11:n=t.sent;case 12:e.isSaveing=!1,n.success?(e.$emit("success",e.form,e.mode),e.visible=!1,e.$message.success(n.message)):e.$alert(n.message,"提示",{type:"error"});case 14:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}())},setData:function(e){this.form.id=e.id,this.form.group_id=e.group_id,this.form.name=e.name,this.form.access_name=e.access_name,this.form.class_name=e.class_name,this.form.method_name=e.method_name,this.form.auth_mode=e.auth_mode,this.form.request_mode=e.request_mode,this.form.description=e.description,this.form.response=e.response,this.form.status=e.status,this.form.remark=e.remark},getDictData:function(){var e=this;this.getDict("request_mode").then((function(t){e.request_mode_data=t.data})),this.getDict("data_status").then((function(t){e.data_status_data=t.data}))},getModuleList:function(){var e=this;this.$API.api.getModuleList().then((function(t){t.success&&(e.modules=t.data)}))},getGroupData:function(){var e=this;this.$API.apiGroup.getSelectList().then((function(t){t.success&&(e.groupData=t.data)}))},querySearch:function(e,t){var a=[];Object.keys(this.modules).forEach((function(t){-1!==t.indexOf(e)&&a.push({value:"Api\\InterfaceApi\\v1\\".concat(t)})})),t(a)}}},m=a("6b0d");const b=a.n(m)()(s,[["render",function(e,t,a,u,i,d){var s=Object(n.resolveComponent)("el-option"),m=Object(n.resolveComponent)("el-select"),b=Object(n.resolveComponent)("el-form-item"),f=Object(n.resolveComponent)("el-input"),p=Object(n.resolveComponent)("el-autocomplete"),h=Object(n.resolveComponent)("el-radio"),j=Object(n.resolveComponent)("el-radio-group"),O=Object(n.resolveComponent)("el-tab-pane"),g=Object(n.resolveComponent)("editor"),V=Object(n.resolveComponent)("ma-json-editor"),_=Object(n.resolveComponent)("el-tabs"),v=Object(n.resolveComponent)("el-form"),x=Object(n.resolveComponent)("el-button"),C=Object(n.resolveComponent)("el-dialog");return Object(n.openBlock)(),Object(n.createBlock)(C,{title:i.titleMap[i.mode],modelValue:i.visible,"onUpdate:modelValue":t[14]||(t[14]=function(e){return i.visible=e}),width:800,"destroy-on-close":"",onClosed:t[15]||(t[15]=function(t){return e.$emit("closed")})},{footer:Object(n.withCtx)((function(){return[Object(n.createVNode)(x,{onClick:t[12]||(t[12]=function(e){return i.visible=!1})},{default:Object(n.withCtx)((function(){return[l]})),_:1}),Object(n.createVNode)(x,{type:"primary",loading:i.isSaveing,onClick:t[13]||(t[13]=function(e){return d.submit()})},{default:Object(n.withCtx)((function(){return[c]})),_:1},8,["loading"])]})),default:Object(n.withCtx)((function(){return[Object(n.createVNode)(v,{model:i.form,rules:i.rules,ref:"dialogForm","label-width":"80px"},{default:Object(n.withCtx)((function(){return[Object(n.createVNode)(_,{modelValue:i.activeName,"onUpdate:modelValue":t[11]||(t[11]=function(e){return i.activeName=e})},{default:Object(n.withCtx)((function(){return[Object(n.createVNode)(O,{label:"基础信息",name:"base"},{default:Object(n.withCtx)((function(){return[Object(n.createVNode)(b,{label:"接口分组",prop:"group_id"},{default:Object(n.withCtx)((function(){return[Object(n.createVNode)(m,{modelValue:i.form.group_id,"onUpdate:modelValue":t[0]||(t[0]=function(e){return i.form.group_id=e}),style:{width:"100%"},filterable:"",clearable:"",placeholder:"请选择接口分组"},{default:Object(n.withCtx)((function(){return[(Object(n.openBlock)(!0),Object(n.createElementBlock)(n.Fragment,null,Object(n.renderList)(i.groupData,(function(e,t){return Object(n.openBlock)(),Object(n.createBlock)(s,{key:t,value:e.id,label:e.name},null,8,["value","label"])})),128))]})),_:1},8,["modelValue"])]})),_:1}),Object(n.createVNode)(b,{label:"接口名称",prop:"name"},{default:Object(n.withCtx)((function(){return[Object(n.createVNode)(f,{modelValue:i.form.name,"onUpdate:modelValue":t[1]||(t[1]=function(e){return i.form.name=e}),clearable:"",placeholder:"请输入接口名称"},null,8,["modelValue"])]})),_:1}),Object(n.createVNode)(b,{label:"访问名称",prop:"access_name"},{default:Object(n.withCtx)((function(){return[Object(n.createVNode)(f,{modelValue:i.form.access_name,"onUpdate:modelValue":t[2]||(t[2]=function(e){return i.form.access_name=e}),clearable:"",placeholder:"请输入接口访问名称"},null,8,["modelValue"])]})),_:1}),Object(n.createVNode)(b,{label:"类名称",prop:"class_name"},{default:Object(n.withCtx)((function(){return[Object(n.createVNode)(p,{modelValue:i.form.class_name,"onUpdate:modelValue":t[3]||(t[3]=function(e){return i.form.class_name=e}),"fetch-suggestions":d.querySearch,clearable:"",style:{width:"100%"},placeholder:"请输入类名称，包括命名空间"},null,8,["modelValue","fetch-suggestions"])]})),_:1}),Object(n.createVNode)(b,{label:"方法名",prop:"method_name"},{default:Object(n.withCtx)((function(){return[Object(n.createVNode)(f,{modelValue:i.form.method_name,"onUpdate:modelValue":t[4]||(t[4]=function(e){return i.form.method_name=e}),clearable:"",placeholder:"请输入方法名"},null,8,["modelValue"])]})),_:1}),Object(n.createVNode)(b,{label:"认证模式",prop:"auth_mode"},{default:Object(n.withCtx)((function(){return[Object(n.createVNode)(j,{modelValue:i.form.auth_mode,"onUpdate:modelValue":t[5]||(t[5]=function(e){return i.form.auth_mode=e})},{default:Object(n.withCtx)((function(){return[Object(n.createVNode)(h,{label:"0"},{default:Object(n.withCtx)((function(){return[o]})),_:1}),Object(n.createVNode)(h,{label:"1"},{default:Object(n.withCtx)((function(){return[r]})),_:1})]})),_:1},8,["modelValue"])]})),_:1}),Object(n.createVNode)(b,{label:"请求模式",prop:"request_mode"},{default:Object(n.withCtx)((function(){return[Object(n.createVNode)(m,{modelValue:i.form.request_mode,"onUpdate:modelValue":t[6]||(t[6]=function(e){return i.form.request_mode=e}),style:{width:"100%"},clearable:"",placeholder:"请选择请求模式"},{default:Object(n.withCtx)((function(){return[(Object(n.openBlock)(!0),Object(n.createElementBlock)(n.Fragment,null,Object(n.renderList)(i.request_mode_data,(function(e,t){return Object(n.openBlock)(),Object(n.createBlock)(s,{key:t,label:e.label,value:e.value},{default:Object(n.withCtx)((function(){return[Object(n.createTextVNode)(Object(n.toDisplayString)(e.label),1)]})),_:2},1032,["label","value"])})),128))]})),_:1},8,["modelValue"])]})),_:1}),Object(n.createVNode)(b,{label:"状态",prop:"status"},{default:Object(n.withCtx)((function(){return[Object(n.createVNode)(j,{modelValue:i.form.status,"onUpdate:modelValue":t[7]||(t[7]=function(e){return i.form.status=e})},{default:Object(n.withCtx)((function(){return[(Object(n.openBlock)(!0),Object(n.createElementBlock)(n.Fragment,null,Object(n.renderList)(i.data_status_data,(function(e,t){return Object(n.openBlock)(),Object(n.createBlock)(h,{key:t,label:e.value},{default:Object(n.withCtx)((function(){return[Object(n.createTextVNode)(Object(n.toDisplayString)(e.label),1)]})),_:2},1032,["label"])})),128))]})),_:1},8,["modelValue"])]})),_:1})]})),_:1}),Object(n.createVNode)(O,{label:"其他信息",name:"other"},{default:Object(n.withCtx)((function(){return[Object(n.createVNode)(b,{label:"说明介绍",prop:"description"},{default:Object(n.withCtx)((function(){return[Object(n.createVNode)(g,{modelValue:i.form.description,"onUpdate:modelValue":t[8]||(t[8]=function(e){return i.form.description=e}),placeholder:"请输入说明介绍",height:300},null,8,["modelValue"])]})),_:1}),Object(n.createVNode)(b,{label:"返回示例",prop:"response"},{default:Object(n.withCtx)((function(){return[Object(n.createVNode)(V,{modelValue:i.form.response,"onUpdate:modelValue":t[9]||(t[9]=function(e){return i.form.response=e})},null,8,["modelValue"])]})),_:1}),Object(n.createVNode)(b,{label:"备注",prop:"remark"},{default:Object(n.withCtx)((function(){return[Object(n.createVNode)(f,{modelValue:i.form.remark,"onUpdate:modelValue":t[10]||(t[10]=function(e){return i.form.remark=e}),type:"textarea",rows:3,clearable:"",placeholder:"请输入备注"},null,8,["modelValue"])]})),_:1})]})),_:1})]})),_:1},8,["modelValue"])]})),_:1},8,["model","rules"])]})),_:1},8,["title","modelValue"])}]]);t.default=b},"2b19":function(e,t,a){"use strict";a("a9e3");var n=a("7a23"),o=a("f33e"),r=(a("7257"),a("a106"),{props:{modelValue:{type:String,default:function(){}},height:{type:Number,default:300},theme:{type:String,default:"vs"}},emits:["update:modelValue"],setup:function(e,t){var a,r=t.emit,l=e,c=Object(n.ref)();return Object(n.onMounted)((function(){(a=o.a.create(c.value,{model:o.a.createModel(l.modelValue,"javascript"),tabSize:2,automaticLayout:!0,scrollBeyondLastLine:!1,language:"javascript",theme:l.theme,autoIndent:!0,minimap:{enabled:!1}})).onDidChangeModelContent((function(){r("update:modelValue",a.getValue())}))})),function(e,t){return Object(n.openBlock)(),Object(n.createElementBlock)("div",{class:"editor",ref:function(e,t){t.dom=e,c.value=e},style:Object(n.normalizeStyle)("height: "+l.height+"px")},null,4)}}}),l=(a("6ba7"),a("6b0d"));const c=a.n(l)()(r,[["__scopeId","data-v-94581018"]]);t.a=c},"2f75":function(e,t,a){},"60bb":function(e,t,a){"use strict";a.r(t);var n=a("7a23"),o={class:"sceditor"};var r=a("1da1"),l=(a("96cf"),a("a9e3"),a("365c")),c=a("ca72"),u=a("e562"),i=a.n(u),d=(a("0d68"),a("ec27"),a("64d8"),a("4ea8"),a("4237"),a("0a9d"),a("07d1"),{components:{Editor:c.a},props:{modelValue:{type:String,default:""},placeholder:{type:String,default:""},height:{type:Number,default:300},disabled:{type:Boolean,default:!1},plugins:{type:[String,Array],default:"code image link preview table"},toolbar:{type:[String,Array],default:"undo redo |  forecolor backcolor bold italic underline strikethrough link | formatselect fontselect fontsizeselect | \t\t\t\t\talignleft aligncenter alignright alignjustify outdent indent lineheight | bullist numlist | \t\t\t\t\timage table  preview | code selectall"}},data:function(){return{init:{language_url:"tinymce/langs/zh_CN.js",language:"zh_CN",skin_url:"tinymce/skins/ui/oxide",content_css:"tinymce/skins/content/default/content.css",menubar:!1,statusbar:!0,plugins:this.plugins,toolbar:this.toolbar,fontsize_formats:"12px 14px 16px 18px 20px 22px 24px 28px 32px 36px 48px 56px 72px",height:this.height,placeholder:this.placeholder,branding:!1,resize:!0,elementpath:!0,content_style:"",images_upload_handler:(e=Object(r.a)(regeneratorRuntime.mark((function e(t,a,n){var o,r;return regeneratorRuntime.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return(o=new FormData).append("image",t.blob(),t.filename()),e.prev=2,e.next=5,l.a.upload.uploadImage(o);case 5:r=e.sent,a(r.data.url),e.next=12;break;case 9:e.prev=9,e.t0=e.catch(2),n("图片上传失败");case 12:case"end":return e.stop()}}),e,null,[[2,9]])}))),function(t,a,n){return e.apply(this,arguments)}),setup:function(e){e.on("init",(function(){this.getBody().style.fontSize="14px"}))}},contentValue:this.modelValue};var e},watch:{modelValue:function(e){this.contentValue=e},contentValue:function(e){this.$emit("update:modelValue",e)}},mounted:function(){i.a.init({})},methods:{onClick:function(e){this.$emit("onClick",e,i.a)}}}),s=a("6b0d");const m=a.n(s)()(d,[["render",function(e,t,a,r,l,c){var u=Object(n.resolveComponent)("Editor");return Object(n.openBlock)(),Object(n.createElementBlock)("div",o,[Object(n.createVNode)(u,{modelValue:l.contentValue,"onUpdate:modelValue":t[0]||(t[0]=function(e){return l.contentValue=e}),init:l.init,disabled:a.disabled,placeholder:a.placeholder,onOnClick:c.onClick},null,8,["modelValue","init","disabled","placeholder","onOnClick"])])}]]);t.default=m},"6ba7":function(e,t,a){"use strict";a("2f75")}}]);
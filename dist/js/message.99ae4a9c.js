(window.webpackJsonp=window.webpackJsonp||[]).push([["message","userCenter-components-createMessage","chunk-2d0ced70"],{"221a":function(e,t,n){"use strict";n("f9c8")},"60bb":function(e,t,n){"use strict";n.r(t);var o=n("7a23"),c={class:"sceditor"};var r=n("1da1"),a=(n("96cf"),n("a9e3"),n("365c")),i=n("ca72"),l=n("e562"),u=n.n(l),s=(n("0d68"),n("ec27"),n("64d8"),n("4ea8"),n("4237"),n("0a9d"),n("07d1"),{components:{Editor:i.a},props:{modelValue:{type:String,default:""},placeholder:{type:String,default:""},height:{type:Number,default:300},disabled:{type:Boolean,default:!1},plugins:{type:[String,Array],default:"code image link preview table"},toolbar:{type:[String,Array],default:"undo redo |  forecolor backcolor bold italic underline strikethrough link | formatselect fontselect fontsizeselect | \t\t\t\t\talignleft aligncenter alignright alignjustify outdent indent lineheight | bullist numlist | \t\t\t\t\timage table  preview | code selectall"}},data:function(){return{init:{language_url:"tinymce/langs/zh_CN.js",language:"zh_CN",skin_url:"tinymce/skins/ui/oxide",content_css:"tinymce/skins/content/default/content.css",menubar:!1,statusbar:!0,plugins:this.plugins,toolbar:this.toolbar,fontsize_formats:"12px 14px 16px 18px 20px 22px 24px 28px 32px 36px 48px 56px 72px",height:this.height,placeholder:this.placeholder,branding:!1,resize:!0,elementpath:!0,content_style:"",images_upload_handler:(e=Object(r.a)(regeneratorRuntime.mark((function e(t,n,o){var c,r;return regeneratorRuntime.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return(c=new FormData).append("image",t.blob(),t.filename()),e.prev=2,e.next=5,a.a.upload.uploadImage(c);case 5:r=e.sent,n(r.data.url),e.next=12;break;case 9:e.prev=9,e.t0=e.catch(2),o("图片上传失败");case 12:case"end":return e.stop()}}),e,null,[[2,9]])}))),function(t,n,o){return e.apply(this,arguments)}),setup:function(e){e.on("init",(function(){this.getBody().style.fontSize="14px"}))}},contentValue:this.modelValue};var e},watch:{modelValue:function(e){this.contentValue=e},contentValue:function(e){this.$emit("update:modelValue",e)}},mounted:function(){u.a.init({})},methods:{onClick:function(e){this.$emit("onClick",e,u.a)}}}),d=n("6b0d");const b=n.n(d)()(s,[["render",function(e,t,n,r,a,i){var l=Object(o.resolveComponent)("Editor");return Object(o.openBlock)(),Object(o.createElementBlock)("div",c,[Object(o.createVNode)(l,{modelValue:a.contentValue,"onUpdate:modelValue":t[0]||(t[0]=function(e){return a.contentValue=e}),init:a.init,disabled:n.disabled,placeholder:n.placeholder,onOnClick:i.onClick},null,8,["modelValue","init","disabled","placeholder","onOnClick"])])}]]);t.default=b},a034:function(e,t,n){"use strict";n.r(t);var o=n("7a23"),c=Object(o.createTextVNode)("取 消"),r=Object(o.createTextVNode)("保 存");var a=n("1da1"),i=(n("96cf"),{components:{editor:n("60bb").default},data:function(){return{visible:!1,isSaveing:!1,form:{title:"",users:[],content:""},rules:{title:[{required:!0,message:"消息必填",trigger:"blur"}],users:[{required:!0,message:"接收人员必选",trigger:"blur"}],content:[{required:!0,message:"消息内容必填",trigger:"blur"}]}}},methods:{open:function(){this.visible=!0},submit:function(){var e=this;this.$refs.dialogForm.validate(function(){var t=Object(a.a)(regeneratorRuntime.mark((function t(n){return regeneratorRuntime.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:n&&(e.isSaveing=!0,e.$API.queueMessage.sendPrivateMessage(e.form).then((function(t){t.success&&e.$message.success(t.message),t.success||e.$message.error(t.message),e.isSaveing=!1,e.visible=!1})));case 1:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}())}}}),l=n("6b0d");const u=n.n(l)()(i,[["render",function(e,t,n,a,i,l){var u=Object(o.resolveComponent)("el-input"),s=Object(o.resolveComponent)("el-form-item"),d=Object(o.resolveComponent)("ma-select-user"),b=Object(o.resolveComponent)("editor"),f=Object(o.resolveComponent)("el-form"),p=Object(o.resolveComponent)("el-button"),m=Object(o.resolveComponent)("sc-dialog");return Object(o.openBlock)(),Object(o.createBlock)(m,{modelValue:i.visible,"onUpdate:modelValue":t[5]||(t[5]=function(e){return i.visible=e}),title:"发消息",width:800,"destroy-on-close":""},{footer:Object(o.withCtx)((function(){return[Object(o.createVNode)(p,{onClick:t[3]||(t[3]=function(e){return i.visible=!1})},{default:Object(o.withCtx)((function(){return[c]})),_:1}),Object(o.createVNode)(p,{type:"primary",loading:i.isSaveing,onClick:t[4]||(t[4]=function(e){return l.submit()})},{default:Object(o.withCtx)((function(){return[r]})),_:1},8,["loading"])]})),default:Object(o.withCtx)((function(){return[Object(o.createVNode)(f,{model:i.form,rules:i.rules,ref:"dialogForm","label-width":"80px"},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(s,{label:"消息标题",prop:"title"},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(u,{modelValue:i.form.title,"onUpdate:modelValue":t[0]||(t[0]=function(e){return i.form.title=e}),size:"small",clearable:"",placeholder:"请输入消息标题"},null,8,["modelValue"])]})),_:1}),Object(o.createVNode)(s,{label:"接收人员",prop:"users"},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(d,{modelValue:i.form.users,"onUpdate:modelValue":t[1]||(t[1]=function(e){return i.form.users=e})},null,8,["modelValue"])]})),_:1}),Object(o.createVNode)(s,{label:"消息内容",prop:"content"},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(b,{modelValue:i.form.content,"onUpdate:modelValue":t[2]||(t[2]=function(e){return i.form.content=e}),clearable:"",placeholder:"请输入消息内容"},null,8,["modelValue"])]})),_:1})]})),_:1},8,["model","rules"])]})),_:1},8,["modelValue"])}]]);t.default=u},c013:function(e,t,n){"use strict";n.r(t);var o=n("7a23"),c=Object(o.createTextVNode)("已发送"),r=Object(o.createTextVNode)("收信箱"),a={class:"left-panel"},i=Object(o.createTextVNode)("发信息"),l=Object(o.createTextVNode)("删除"),u=Object(o.createTextVNode)("全部"),s=Object(o.createTextVNode)("未读"),d=Object(o.createTextVNode)("已读"),b={class:"right-panel"},f=Object(o.createTextVNode)("删除"),p=Object(o.createTextVNode)("详细"),m=Object(o.createTextVNode)("接收人员"),j={style:{"font-size":"24px","line-height":"60px","text-align":"center"}},h=["innerHTML"];var O=n("1da1"),g=(n("a15b"),n("d81d"),n("96cf"),{name:"message",components:{createMessage:n("a034").default},data:function(){return{api:{list:function(){}},receiveListApi:{list:function(){}},defaultActive:"receive_box",messageType:[],typeIcon:{carbon_copy_mine:"el-icon-copy-document",todo:"el-icon-calendar",announcement:"el-icon-cellphone",notice:"el-icon-bell",private_message:"el-icon-chat-line-round"},queryParams:{read_status:"all"},selection:[],drawer:!1,drawerLoading:!0,sendDialog:!1,row:{title:"",content:""}}},mounted:function(){var e=this;return Object(O.a)(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.getDictData();case 2:return t.next=4,e.loadData();case 4:case"end":return t.stop()}}),t)})))()},methods:{loadData:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:void 0;this.defaultActive&&(this.api.list="send_box"===this.defaultActive?this.$API.queueMessage.getSendList:this.$API.queueMessage.getReceiveList,this.queryParams={read_status:"all"},this.queryParams.content_type=e,this.$refs.table.reload(this.queryParams))},readStatusChange:function(e){this.queryParams.read_status=e,this.$refs.table.upData(this.queryParams)},showDetails:function(e){var t=this;return Object(O.a)(regeneratorRuntime.mark((function n(){return regeneratorRuntime.wrap((function(n){for(;;)switch(n.prev=n.next){case 0:return t.drawerLoading=!0,t.drawer=!0,n.next=4,t.$API.queueMessage.updateReadStatus(e.id);case 4:t.drawerLoading=!1,t.row=e;case 6:case"end":return n.stop()}}),n)})))()},showReceiveList:function(e){var t=this;this.sendDialog=!0,this.$nextTick((function(){t.receiveListApi.list=t.$API.queueMessage.getReceiveUser,t.$refs.receiveList.reload({id:e})}))},add:function(){var e=this;this.$nextTick((function(){e.$refs.send_msg.open()}))},del:function(e){var t=arguments,n=this;return Object(O.a)(regeneratorRuntime.mark((function o(){var c,r;return regeneratorRuntime.wrap((function(o){for(;;)switch(o.prev=o.next){case 0:return c=t.length>1&&void 0!==t[1]&&t[1],r=c?"确定要删除选中的消息吗？":"确定删除该消息吗？",o.next=4,n.$confirm(r,"提示",{type:"warning"}).then((function(){n.$API.queueMessage.deletes(c?e.join(","):e).then((function(e){e.success&&n.$message.success(e.message),e.success||n.$message.error(e.message)})),n.$refs.table.upData(n.queryParams)})).catch((function(){}));case 4:case"end":return o.stop()}}),o)})))()},handleSelect:function(e){this.defaultActive=e,this.loadData("receive_box"===e||"send_box"===e?void 0:e)},handlerSearch:function(){this.$refs.table.upData(this.queryParams)},resetSearch:function(){this.loadData(this.defaultActive)},selectionChange:function(e){this.selection=e.map((function(e){return e.id}))},getDictData:function(){var e=this;this.getDict("queue_msg_type").then((function(t){e.messageType=t.data}))}}}),v=(n("221a"),n("6b0d"));const x=n.n(v)()(g,[["render",function(e,t,n,O,g,v){var x=Object(o.resolveComponent)("el-icon-message-box"),C=Object(o.resolveComponent)("el-icon"),V=Object(o.resolveComponent)("el-menu-item"),w=Object(o.resolveComponent)("el-icon-message"),_=Object(o.resolveComponent)("el-menu"),N=Object(o.resolveComponent)("el-aside"),k=Object(o.resolveComponent)("el-button"),y=Object(o.resolveComponent)("el-radio-button"),S=Object(o.resolveComponent)("el-radio-group"),D=Object(o.resolveComponent)("el-input"),T=Object(o.resolveComponent)("el-tooltip"),$=Object(o.resolveComponent)("el-header"),q=Object(o.resolveComponent)("el-table-column"),A=Object(o.resolveComponent)("ma-dict-tag"),B=Object(o.resolveComponent)("maTable"),L=Object(o.resolveComponent)("el-main"),P=Object(o.resolveComponent)("el-container"),R=Object(o.resolveComponent)("el-drawer"),M=Object(o.resolveComponent)("sc-dialog"),I=Object(o.resolveComponent)("create-message"),z=Object(o.resolveDirective)("loading");return Object(o.openBlock)(),Object(o.createElementBlock)(o.Fragment,null,[Object(o.createVNode)(P,null,{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(N,{width:"180px",style:{"border-right":"1px solid #e6e6e6",padding:"10px"}},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(_,{size:"small",onSelect:v.handleSelect,"default-active":g.defaultActive},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(V,{index:"send_box"},{title:Object(o.withCtx)((function(){return[c]})),default:Object(o.withCtx)((function(){return[Object(o.createVNode)(C,null,{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(x)]})),_:1})]})),_:1}),Object(o.createVNode)(V,{index:"receive_box"},{title:Object(o.withCtx)((function(){return[r]})),default:Object(o.withCtx)((function(){return[Object(o.createVNode)(C,null,{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(w)]})),_:1})]})),_:1}),(Object(o.openBlock)(!0),Object(o.createElementBlock)(o.Fragment,null,Object(o.renderList)(g.messageType,(function(e){return Object(o.openBlock)(),Object(o.createBlock)(V,{key:e.value,index:e.value},{title:Object(o.withCtx)((function(){return[Object(o.createTextVNode)(Object(o.toDisplayString)(e.label),1)]})),default:Object(o.withCtx)((function(){return[Object(o.createVNode)(C,null,{default:Object(o.withCtx)((function(){return[(Object(o.openBlock)(),Object(o.createBlock)(Object(o.resolveDynamicComponent)(g.typeIcon[e.value]?g.typeIcon[e.value]:"el-icon-message")))]})),_:2},1024)]})),_:2},1032,["index"])})),128))]})),_:1},8,["onSelect","default-active"])]})),_:1}),Object(o.createVNode)(P,{ref:"printMain"},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)($,null,{default:Object(o.withCtx)((function(){return[Object(o.createElementVNode)("div",a,[Object(o.createVNode)(k,{icon:"el-icon-plus",type:"primary",onClick:v.add},{default:Object(o.withCtx)((function(){return[i]})),_:1},8,["onClick"]),Object(o.createVNode)(k,{type:"danger",plain:"",icon:"el-icon-delete",disabled:0==g.selection.length,onClick:t[0]||(t[0]=function(e){return v.del(g.selection,!0)})},{default:Object(o.withCtx)((function(){return[l]})),_:1},8,["disabled"]),"send_box"!==g.defaultActive?(Object(o.openBlock)(),Object(o.createBlock)(S,{key:0,modelValue:g.queryParams.read_status,"onUpdate:modelValue":t[1]||(t[1]=function(e){return g.queryParams.read_status=e}),style:{"margin-left":"10px"},onChange:v.readStatusChange},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(y,{label:"all"},{default:Object(o.withCtx)((function(){return[u]})),_:1}),Object(o.createVNode)(y,{label:"0"},{default:Object(o.withCtx)((function(){return[s]})),_:1}),Object(o.createVNode)(y,{label:"1"},{default:Object(o.withCtx)((function(){return[d]})),_:1})]})),_:1},8,["modelValue","onChange"])):Object(o.createCommentVNode)("",!0)]),Object(o.createElementVNode)("div",b,[Object(o.createVNode)(D,{placeholder:"搜索标题"}),Object(o.createVNode)(T,{class:"item",effect:"dark",content:"搜索",placement:"top"},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(k,{type:"primary",icon:"el-icon-search",onClick:v.handlerSearch},null,8,["onClick"])]})),_:1}),Object(o.createVNode)(T,{class:"item",effect:"dark",content:"清空条件",placement:"top"},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(k,{icon:"el-icon-refresh",onClick:v.resetSearch},null,8,["onClick"])]})),_:1})])]})),_:1}),Object(o.createVNode)(L,{class:"nopadding"},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(B,{ref:"table",api:g.api,onSelectionChange:v.selectionChange,autoLoad:!1,stripe:"",remoteSort:"",remoteFilter:""},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(q,{type:"selection",width:"50"}),Object(o.createVNode)(q,{label:"消息类型",prop:"content_type",sortable:"custom",width:"120"},{default:Object(o.withCtx)((function(e){return[Object(o.createVNode)(A,{options:g.messageType,value:e.row.content_type},null,8,["options","value"])]})),_:1}),"send_box"!==g.defaultActive?(Object(o.openBlock)(),Object(o.createBlock)(q,{key:0,label:"发送人",prop:"send_user.nickname",sortable:"custom",width:"120"})):Object(o.createCommentVNode)("",!0),Object(o.createVNode)(q,{label:"标题",prop:"title","show-overflow-tooltip":""}),Object(o.createVNode)(q,{label:"发送时间",prop:"created_at",width:"200",sortable:"custom"}),Object(o.createVNode)(q,{label:"操作",width:"150"},{default:Object(o.withCtx)((function(e){return[Object(o.createVNode)(k,{type:"text",onClick:function(t){return v.del(e.row.id)}},{default:Object(o.withCtx)((function(){return[f]})),_:2},1032,["onClick"]),Object(o.createVNode)(k,{type:"text",onClick:function(t){return v.showDetails(e.row)}},{default:Object(o.withCtx)((function(){return[p]})),_:2},1032,["onClick"]),"send_box"===g.defaultActive?(Object(o.openBlock)(),Object(o.createBlock)(k,{key:0,type:"text",onClick:function(t){return v.showReceiveList(e.row.id)}},{default:Object(o.withCtx)((function(){return[m]})),_:2},1032,["onClick"])):Object(o.createCommentVNode)("",!0)]})),_:1})]})),_:1},8,["api","onSelectionChange"])]})),_:1})]})),_:1},512)]})),_:1}),Object(o.createVNode)(R,{modelValue:g.drawer,"onUpdate:modelValue":t[2]||(t[2]=function(e){return g.drawer=e}),title:"详细内容",size:"50%"},{default:Object(o.withCtx)((function(){return[Object(o.withDirectives)(Object(o.createVNode)(L,{"element-loading-background":"rgba(50, 50, 50, 0.5)","element-loading-text":"数据加载中...",style:{height:"100%"}},{default:Object(o.withCtx)((function(){return[Object(o.createElementVNode)("h2",j,Object(o.toDisplayString)(g.row.title),1),Object(o.createElementVNode)("div",{innerHTML:g.row.content},null,8,h)]})),_:1},512),[[z,g.drawerLoading]])]})),_:1},8,["modelValue"]),Object(o.createVNode)(M,{modelValue:g.sendDialog,"onUpdate:modelValue":t[3]||(t[3]=function(e){return g.sendDialog=e}),title:"接收人列表"},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(B,{ref:"receiveList",api:g.receiveListApi,autoLoad:!1,stripe:""},{default:Object(o.withCtx)((function(){return[Object(o.createVNode)(q,{label:"用户名",prop:"username"}),Object(o.createVNode)(q,{label:"昵称",prop:"nickname"}),Object(o.createVNode)(q,{label:"查看状态",prop:"read_status"})]})),_:1},8,["api"])]})),_:1},8,["modelValue"]),Object(o.createVNode)(I,{ref:"send_msg"},null,512)],64)}],["__scopeId","data-v-623a14fc"]]);t.default=x},f9c8:function(e,t,n){}}]);
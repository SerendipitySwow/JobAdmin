(window.webpackJsonp=window.webpackJsonp||[]).push([["setting-table"],{"5b11":function(e,t,n){"use strict";n("cea8")},a785:function(e,t,n){"use strict";n.r(t);n("b0c0");var l=n("7a23"),o=function(e){return Object(l.pushScopeId)("data-v-2cae2ad8"),e=e(),Object(l.popScopeId)(),e},r=o((function(){return Object(l.createElementVNode)("span",null,"基础数据",-1)})),a={style:{float:"left"}},c={style:{float:"right",color:"#8492a6","font-size":"13px"}},u=Object(l.createTextVNode)("创建数据表"),d=o((function(){return Object(l.createElementVNode)("span",null,"字段",-1)})),i=Object(l.createTextVNode)("增加字段"),b=Object(l.createTextVNode)("删除"),m=Object(l.createTextVNode)("创建时间 & 更新时间"),f=Object(l.createTextVNode)("创建人 & 更新人"),s=Object(l.createTextVNode)("软删除"),O=Object(l.createTextVNode)("主键雪花ID");var j=n("1da1"),p=(n("e9c4"),n("a434"),n("ac1f"),n("00b4"),n("a15b"),n("96cf"),{name:"setting:table",data:function(){return{loading:!1,form:{name:"",module:"",columns:[],autoTime:!0,autoUser:!0,softDelete:!0,snowflakeId:!0,pk:"id",engine:"",comment:""},sysinfo:{},currentModule:"",tablePrefix:"",engines:null,fields:{id:0,name:"",type:"",unsigned:!1,len:0,isNull:!1,index:"",default:"",comment:""},indexs:["UNIQUE","NORMAL","FULLTEXT"],mysqlTypes:h,rules:{name:[{required:!0,pattern:/^[A-Za-z|_]{2,}$/g,message:"表名称只能是英文和下划线，至少两个字符",trigger:"blur"}],module:[{required:!0,message:"请选择所属模块",trigger:"change"}],engine:[{required:!0,message:"请选择表引擎",trigger:"change"}],comment:[{required:!0,message:"请输入表注释",trigger:"blur"}],pk:[{required:!0,pattern:/^[A-Za-z|_]{2,}$/g,message:"主键为英文和下划线，至少两个字符",trigger:"blur"}]}}},created:function(){var e=this;return Object(j.a)(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.$API.table.getSystemInfo().then((function(t){e.sysinfo=t.data}));case 2:return t.next=4,e.getDict("table_engine").then((function(t){e.engines=t.data}));case 4:e.handleAddColumn();case 5:case"end":return t.stop()}}),t)})))()},methods:{handleAddColumn:function(){var e=JSON.parse(JSON.stringify(this.fields));e.id=this.form.columns.length+1,this.form.columns.push(e)},handleDeleteColumn:function(e){for(var t=0;t<this.form.columns.length;t++)if(this.form.columns[t].id===e){this.form.columns.splice(t,1);break}},hanldeChangeModule:function(e){this.currentModule=e.toLowerCase()},handleSubmit:function(){var e=this;this.loading=!0,this.$refs.form.validate((function(t){if(!t)return e.loading=!1,!1;if(e.form.columns.length<1)return e.$message.error("表没有字段"),void(e.loading=!1);for(var n=e.form.columns,l=0;l<n.length;l++){var o=[];if(""===n[l].name)o.push("字段名称");else if(!/^[A-Za-z|_]{2,}$/g.test(n[l].name))return e.$message.error("第".concat(n[l].id,"行的字段名称必须是英文和下划线组成")),void(e.loading=!1);if(""===n[l].type&&o.push("字段类型"),""===n[l].comment&&o.push("表注释"),o.length>0)return e.$message.error("第".concat(n[l].id,"行字段列表的 ")+o.join("、")+" 为空 "),void(e.loading=!1)}e.$API.table.save(e.form).then((function(t){e.$message.success(t.message)})),e.loading=!1}))}}}),h=[{label:"整型及数字类型",options:[{value:"BIGINT"},{value:"INT"},{value:"TINYINT"},{value:"SMALLINT"},{value:"MEDIUMINT"},{value:"DECIMAL"}]},{label:"字符串及文本类型",options:[{value:"CHAR"},{value:"VARCHAR"},{value:"TINYTEXT"},{value:"TEXT"},{value:"MEDIUMTEXT"},{value:"LONGTEXT"}]},{label:"日期与时间类型",options:[{value:"DATE"},{value:"DATETIME"},{value:"TIMESTAMP"},{value:"TIME"}]},{label:"JSON类型",options:[{value:"JSON"}]}],V=(n("5b11"),n("6b0d"));const x=n.n(V)()(p,[["render",function(e,t,n,o,j,p){var h=Object(l.resolveComponent)("el-alert"),V=Object(l.resolveComponent)("el-input"),x=Object(l.resolveComponent)("el-form-item"),w=Object(l.resolveComponent)("el-col"),g=Object(l.resolveComponent)("el-option"),N=Object(l.resolveComponent)("el-select"),C=Object(l.resolveComponent)("el-button"),v=Object(l.resolveComponent)("el-row"),_=Object(l.resolveComponent)("el-card"),y=Object(l.resolveComponent)("el-table-column"),k=Object(l.resolveComponent)("el-option-group"),T=Object(l.resolveComponent)("el-checkbox"),U=Object(l.resolveComponent)("el-input-number"),I=Object(l.resolveComponent)("el-table"),B=Object(l.resolveComponent)("el-form");return Object(l.openBlock)(),Object(l.createBlock)(B,{ref:"form",inline:!0,model:j.form,rules:j.rules,"label-width":"80px",class:"page-form"},{default:Object(l.withCtx)((function(){return[Object(l.createVNode)(h,{title:"提示",type:"warning",closable:!1,description:"本表设计器不能替代专业工具，仅提供常用字段选项。另外建议自己制作一个迁移文件","show-icon":""}),Object(l.createVNode)(_,{class:"box-card ma-card",shadow:"hover"},{header:Object(l.withCtx)((function(){return[r]})),default:Object(l.withCtx)((function(){return[Object(l.createVNode)(v,{gutter:15},{default:Object(l.withCtx)((function(){return[Object(l.createVNode)(w,{xs:24,md:7,xl:7},{default:Object(l.withCtx)((function(){return[Object(l.createVNode)(x,{label:"表名称",prop:"name",style:{width:"100%"}},{default:Object(l.withCtx)((function(){return[Object(l.createVNode)(V,{modelValue:j.form.name,"onUpdate:modelValue":t[0]||(t[0]=function(e){return j.form.name=e}),placeholder:"请输入表名称",clearable:""},{prepend:Object(l.withCtx)((function(){return[Object(l.createTextVNode)(Object(l.toDisplayString)(""===j.sysinfo.tablePrefix?"无前缀":j.sysinfo.tablePrefix)+" "+Object(l.toDisplayString)(""===j.currentModule?"":j.currentModule+"_"),1)]})),_:1},8,["modelValue"])]})),_:1})]})),_:1}),Object(l.createVNode)(w,{xs:24,md:6,xl:6},{default:Object(l.withCtx)((function(){return[Object(l.createVNode)(x,{label:"所属模块",prop:"module",style:{width:"100%"}},{default:Object(l.withCtx)((function(){return[Object(l.createVNode)(N,{modelValue:j.form.module,"onUpdate:modelValue":t[1]||(t[1]=function(e){return j.form.module=e}),clearable:"",placeholder:"请选择模块",onChange:p.hanldeChangeModule,style:{width:"100%"}},{default:Object(l.withCtx)((function(){return[(Object(l.openBlock)(!0),Object(l.createElementBlock)(l.Fragment,null,Object(l.renderList)(j.sysinfo.modulesList,(function(e,t){return Object(l.openBlock)(),Object(l.createBlock)(g,{label:e.name,value:e.name,key:t},{default:Object(l.withCtx)((function(){return[Object(l.createElementVNode)("span",a,Object(l.toDisplayString)(e.name),1),Object(l.createElementVNode)("span",c,Object(l.toDisplayString)(e.label),1)]})),_:2},1032,["label","value"])})),128))]})),_:1},8,["modelValue","onChange"])]})),_:1})]})),_:1}),Object(l.createVNode)(w,{xs:24,md:3,xl:2},{default:Object(l.withCtx)((function(){return[Object(l.createVNode)(C,{type:"primary",onClick:p.handleSubmit,loading:j.loading,style:{width:"100%"}},{default:Object(l.withCtx)((function(){return[u]})),_:1},8,["onClick","loading"])]})),_:1})]})),_:1})]})),_:1}),Object(l.createVNode)(_,{class:"box-card ma-card",shadow:"hover"},{header:Object(l.withCtx)((function(){return[Object(l.createVNode)(v,{gutter:15},{default:Object(l.withCtx)((function(){return[Object(l.createVNode)(w,{xs:24,md:20,sm:20,xl:22,style:{"margin-bottom":"15px"}},{default:Object(l.withCtx)((function(){return[d]})),_:1}),Object(l.createVNode)(w,{xs:24,md:4,sm:4,xl:2,style:{"text-align":"right"}},{default:Object(l.withCtx)((function(){return[Object(l.createVNode)(C,{icon:"el-icon-plus",style:{width:"100%"},type:"primary",onClick:p.handleAddColumn},{default:Object(l.withCtx)((function(){return[i]})),_:1},8,["onClick"])]})),_:1})]})),_:1})]})),default:Object(l.withCtx)((function(){return[Object(l.createVNode)(I,{data:j.form.columns,"empty-text":"请添加字段..."},{default:Object(l.withCtx)((function(){return[Object(l.createVNode)(y,{label:"操作",align:"center",fixed:"left",width:"100"},{default:Object(l.withCtx)((function(e){return[Object(l.createVNode)(C,{type:"text",onClick:function(t){return p.handleDeleteColumn(e.row.id)}},{default:Object(l.withCtx)((function(){return[b]})),_:2},1032,["onClick"])]})),_:1}),Object(l.createVNode)(y,{prop:"name",label:"字段名称"},{default:Object(l.withCtx)((function(e){return[Object(l.createVNode)(V,{modelValue:e.row.name,"onUpdate:modelValue":function(t){return e.row.name=t},clearable:"",placeholder:"字段名称"},null,8,["modelValue","onUpdate:modelValue"])]})),_:1}),Object(l.createVNode)(y,{prop:"type",label:"字段类型"},{default:Object(l.withCtx)((function(e){return[Object(l.createVNode)(N,{modelValue:e.row.type,"onUpdate:modelValue":function(t){return e.row.type=t},clearable:"",placeholder:"字段类型"},{default:Object(l.withCtx)((function(){return[(Object(l.openBlock)(!0),Object(l.createElementBlock)(l.Fragment,null,Object(l.renderList)(j.mysqlTypes,(function(e){return Object(l.openBlock)(),Object(l.createBlock)(k,{key:e.label,label:e.label},{default:Object(l.withCtx)((function(){return[(Object(l.openBlock)(!0),Object(l.createElementBlock)(l.Fragment,null,Object(l.renderList)(e.options,(function(e,t){return Object(l.openBlock)(),Object(l.createBlock)(g,{key:t,label:e.value,value:e.value},null,8,["label","value"])})),128))]})),_:2},1032,["label"])})),128))]})),_:2},1032,["modelValue","onUpdate:modelValue"])]})),_:1}),Object(l.createVNode)(y,{prop:"unsigned",label:"Unsigned",width:"100"},{default:Object(l.withCtx)((function(e){return[Object(l.createVNode)(T,{modelValue:e.row.unsigned,"onUpdate:modelValue":function(t){return e.row.unsigned=t}},null,8,["modelValue","onUpdate:modelValue"])]})),_:1}),Object(l.createVNode)(y,{prop:"isNull",label:"NULL",width:"100"},{default:Object(l.withCtx)((function(e){return[Object(l.createVNode)(T,{modelValue:e.row.isNull,"onUpdate:modelValue":function(t){return e.row.isNull=t}},null,8,["modelValue","onUpdate:modelValue"])]})),_:1}),Object(l.createVNode)(y,{prop:"len",label:"长度"},{default:Object(l.withCtx)((function(e){return[Object(l.createVNode)(U,{modelValue:e.row.len,"onUpdate:modelValue":function(t){return e.row.len=t},clearable:"","controls-position":"right",min:1,max:9999},null,8,["modelValue","onUpdate:modelValue"])]})),_:1}),Object(l.createVNode)(y,{prop:"index",label:"索引类型"},{default:Object(l.withCtx)((function(e){return[Object(l.createVNode)(N,{modelValue:e.row.index,"onUpdate:modelValue":function(t){return e.row.index=t},clearable:"",placeholder:"索引类型"},{default:Object(l.withCtx)((function(){return[(Object(l.openBlock)(!0),Object(l.createElementBlock)(l.Fragment,null,Object(l.renderList)(j.indexs,(function(e){return Object(l.openBlock)(),Object(l.createBlock)(g,{value:e,key:e},{default:Object(l.withCtx)((function(){return[Object(l.createTextVNode)(Object(l.toDisplayString)(e),1)]})),_:2},1032,["value"])})),128))]})),_:2},1032,["modelValue","onUpdate:modelValue"])]})),_:1}),Object(l.createVNode)(y,{prop:"default",label:"默认值"},{default:Object(l.withCtx)((function(e){return[Object(l.createVNode)(V,{modelValue:e.row.default,"onUpdate:modelValue":function(t){return e.row.default=t},clearable:"",placeholder:"默认值"},null,8,["modelValue","onUpdate:modelValue"])]})),_:1}),Object(l.createVNode)(y,{prop:"comment",label:"注释"},{default:Object(l.withCtx)((function(e){return[Object(l.createVNode)(V,{modelValue:e.row.comment,"onUpdate:modelValue":function(t){return e.row.comment=t},clearable:"",placeholder:"注释"},null,8,["modelValue","onUpdate:modelValue"])]})),_:1})]})),_:1},8,["data"]),Object(l.createVNode)(v,{gutter:15,style:{"margin-top":"25px"}},{default:Object(l.withCtx)((function(){return[Object(l.createVNode)(w,{xs:24,md:6,xl:6},{default:Object(l.withCtx)((function(){return[Object(l.createVNode)(x,{label:"表引擎",prop:"engine",style:{width:"100%"}},{default:Object(l.withCtx)((function(){return[Object(l.createVNode)(N,{modelValue:j.form.engine,"onUpdate:modelValue":t[2]||(t[2]=function(e){return j.form.engine=e}),placeholder:"表引擎",clearable:"",style:{width:"100%"}},{default:Object(l.withCtx)((function(){return[(Object(l.openBlock)(!0),Object(l.createElementBlock)(l.Fragment,null,Object(l.renderList)(j.engines,(function(e,t){return Object(l.openBlock)(),Object(l.createBlock)(g,{value:e.value,label:e.label,key:t},{default:Object(l.withCtx)((function(){return[Object(l.createTextVNode)(Object(l.toDisplayString)(e.label),1)]})),_:2},1032,["value","label"])})),128))]})),_:1},8,["modelValue"])]})),_:1})]})),_:1}),Object(l.createVNode)(w,{xs:24,md:6,xl:6},{default:Object(l.withCtx)((function(){return[Object(l.createVNode)(x,{label:"表注释",fixed:"",prop:"comment",clearable:"",style:{width:"100%"}},{default:Object(l.withCtx)((function(){return[Object(l.createVNode)(V,{modelValue:j.form.comment,"onUpdate:modelValue":t[3]||(t[3]=function(e){return j.form.comment=e}),placeholder:"请输入表注释"},null,8,["modelValue"])]})),_:1})]})),_:1}),Object(l.createVNode)(w,{xs:24,md:6,xl:6},{default:Object(l.withCtx)((function(){return[Object(l.createVNode)(x,{label:"ID主键",prop:"pk",clearable:"",style:{width:"100%"}},{default:Object(l.withCtx)((function(){return[Object(l.createVNode)(V,{modelValue:j.form.pk,"onUpdate:modelValue":t[4]||(t[4]=function(e){return j.form.pk=e}),placeholder:"请输入ID主键"},null,8,["modelValue"])]})),_:1})]})),_:1})]})),_:1}),Object(l.createVNode)(v,{class:"ma-row"},{default:Object(l.withCtx)((function(){return[Object(l.createVNode)(T,{modelValue:j.form.autoTime,"onUpdate:modelValue":t[5]||(t[5]=function(e){return j.form.autoTime=e})},{default:Object(l.withCtx)((function(){return[m]})),_:1},8,["modelValue"]),Object(l.createVNode)(T,{modelValue:j.form.autoUser,"onUpdate:modelValue":t[6]||(t[6]=function(e){return j.form.autoUser=e})},{default:Object(l.withCtx)((function(){return[f]})),_:1},8,["modelValue"]),Object(l.createVNode)(T,{modelValue:j.form.softDelete,"onUpdate:modelValue":t[7]||(t[7]=function(e){return j.form.softDelete=e})},{default:Object(l.withCtx)((function(){return[s]})),_:1},8,["modelValue"]),Object(l.createVNode)(T,{modelValue:j.form.snowflakeId,"onUpdate:modelValue":t[8]||(t[8]=function(e){return j.form.snowflakeId=e})},{default:Object(l.withCtx)((function(){return[O]})),_:1},8,["modelValue"])]})),_:1})]})),_:1})]})),_:1},8,["model","rules"])}],["__scopeId","data-v-2cae2ad8"]]);t.default=x},cea8:function(e,t,n){}}]);
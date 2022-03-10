(window.webpackJsonp=window.webpackJsonp||[]).push([["home-widgets","home-widgets-components","home-widgets-components-about","home-widgets-components-echarts","home-widgets-components-progress","home-widgets-components-time","home-widgets-components-ver","home-widgets-components-welcome"],{"0071":function(e,t,n){"use strict";n.r(t);var c=n("7a23"),o=function(e){return Object(c.pushScopeId)("data-v-6bdb232a"),e=e(),Object(c.popScopeId)(),e},i={class:"welcome"},r=o((function(){return Object(c.createElementVNode)("div",{class:"logo"},[Object(c.createElementVNode)("img",{src:"img/logo.svg"}),Object(c.createElementVNode)("h2",null,"欢迎体验 MineAdmin")],-1)})),a={class:"tips"},s={class:"tips-item"},l={class:"tips-item-icon"},d=o((function(){return Object(c.createElementVNode)("div",{class:"tips-item-message"},"PHP有很多优秀的后台管理系统，但基于Swoole的后台管理系统没找到合适我自己的。 所以就开发了一套后台管理系统。系统可以用于网站管理后台、CMS、CRM、OA、ERP等。",-1)})),u={class:"tips-item"},m={class:"tips-item-icon"},b=o((function(){return Object(c.createElementVNode)("div",{class:"tips-item-message"},"MineAdmin是一个后台权限管理系统，提供完善的权限体系，让开发者把注意力集中到具体业务当中，降低开发成本，提高项目效率。同时，支持PC和移动端。企业和个人可以免费使用",-1)})),f={class:"tips-item"},O={class:"tips-item-icon"},p=o((function(){return Object(c.createElementVNode)("div",{class:"tips-item-message"},"欢迎大家提交PR，有问题可以上Gitee提Issues",-1)})),j={class:"actions"},h=Object(c.createTextVNode)("文档");var g={title:"欢迎",icon:"el-icon-present",description:"项目特色以及文档链接",data:function(){return{}},methods:{godoc:function(){window.open("https://doc.mineadmin.com/")}}},v=(n("a884"),n("6b0d"));const w=n.n(v)()(g,[["render",function(e,t,n,o,g,v){var w=Object(c.resolveComponent)("el-icon-promotion"),V=Object(c.resolveComponent)("el-icon"),N=Object(c.resolveComponent)("el-icon-star"),y=Object(c.resolveComponent)("el-icon-coffee"),C=Object(c.resolveComponent)("el-button"),k=Object(c.resolveComponent)("el-card");return Object(c.openBlock)(),Object(c.createBlock)(k,{shadow:"hover",header:"欢迎"},{default:Object(c.withCtx)((function(){return[Object(c.createElementVNode)("div",i,[r,Object(c.createElementVNode)("div",a,[Object(c.createElementVNode)("div",s,[Object(c.createElementVNode)("div",l,[Object(c.createVNode)(V,null,{default:Object(c.withCtx)((function(){return[Object(c.createVNode)(w)]})),_:1})]),d]),Object(c.createElementVNode)("div",u,[Object(c.createElementVNode)("div",m,[Object(c.createVNode)(V,null,{default:Object(c.withCtx)((function(){return[Object(c.createVNode)(N)]})),_:1})]),b]),Object(c.createElementVNode)("div",f,[Object(c.createElementVNode)("div",O,[Object(c.createVNode)(V,null,{default:Object(c.withCtx)((function(){return[Object(c.createVNode)(y)]})),_:1})]),p])]),Object(c.createElementVNode)("div",j,[Object(c.createVNode)(C,{type:"primary",icon:"el-icon-check",size:"medium",onClick:v.godoc},{default:Object(c.withCtx)((function(){return[h]})),_:1},8,["onClick"])])])]})),_:1})}],["__scopeId","data-v-6bdb232a"]]);t.default=w},1905:function(e,t,n){"use strict";n("9555")},3266:function(e,t,n){"use strict";n.r(t);var c=n("7a23");n("ac1f"),n("5319");var o={title:"实时收入",icon:"el-icon-data-line",description:"Echarts组件演示",components:{scEcharts:n("591b").a},data:function(){return{loading:!0,option:{}}},created:function(){var e=this;setTimeout((function(){e.loading=!1}),500);var t={tooltip:{trigger:"axis"},xAxis:{boundaryGap:!1,type:"category",data:function(){for(var e=new Date,t=[],n=30;n--;)t.unshift(e.toLocaleTimeString().replace(/^\D*/,"")),e=new Date(e-2e3);return t}()},yAxis:[{type:"value",name:"价格",splitLine:{show:!1}}],series:[{name:"收入",type:"line",symbol:"none",lineStyle:{width:1,color:"#409EFF"},areaStyle:{opacity:.1,color:"#79bbff"},data:function(){for(var e=[],t=30;t--;)e.push(Math.round(0*Math.random()));return e}()}]};this.option=t},mounted:function(){var e=this;setInterval((function(){var t=e.option;t.series[0].data.shift(),t.series[0].data.push(Math.round(100*Math.random())),t.xAxis.data.shift(),t.xAxis.data.push((new Date).toLocaleTimeString().replace(/^\D*/,""))}),2100)}},i=n("6b0d");const r=n.n(i)()(o,[["render",function(e,t,n,o,i,r){var a=Object(c.resolveComponent)("scEcharts"),s=Object(c.resolveComponent)("el-card"),l=Object(c.resolveDirective)("loading");return Object(c.withDirectives)((Object(c.openBlock)(),Object(c.createBlock)(s,{shadow:"hover",header:"实时收入"},{default:Object(c.withCtx)((function(){return[Object(c.createVNode)(a,{ref:"c1",height:"300px",option:i.option},null,8,["option"])]})),_:1},512)),[[l,i.loading]])}]]);t.default=r},"591b":function(e,t,n){"use strict";var c=n("7a23");var o=n("5530"),i=n("313e"),r={color:["#409EFF","#36CE9E","#f56e6a","#626c91","#edb00d","#909399"],grid:{left:"3%",right:"3%",bottom:"10",top:"40",containLabel:!0},legend:{textStyle:{color:"#999"},inactiveColor:"rgba(128,128,128,0.4)"},categoryAxis:{axisLine:{show:!0,lineStyle:{color:"rgba(128,128,128,0.2)",width:1}},axisTick:{show:!1,lineStyle:{color:"#333"}},axisLabel:{color:"#999"},splitLine:{show:!1,lineStyle:{color:["#eee"]}},splitArea:{show:!1,areaStyle:{color:["rgba(255,255,255,0.01)","rgba(0,0,0,0.01)"]}}},valueAxis:{axisLine:{show:!1,lineStyle:{color:"#999"}},splitLine:{show:!0,lineStyle:{color:"rgba(128,128,128,0.2)"}}}};i.registerTheme("T",r);var a=Object(o.a)(Object(o.a)({},i),{},{name:"scEcharts",props:{height:{type:String,default:"100%"},width:{type:String,default:"100%"},nodata:{type:Boolean,default:!1},option:{type:Object,default:function(){}}},data:function(){return{isActivat:!1,myChart:null}},watch:{option:{deep:!0,handler:function(e){var t;(t=this.myChart,t&&(t.__v_raw||t.valueOf()||t)).setOption(e)}}},computed:{myOptions:function(){return this.option||{}}},activated:function(){var e=this;this.isActivat||this.$nextTick((function(){e.myChart.resize()}))},deactivated:function(){this.isActivat=!1},mounted:function(){var e=this;this.isActivat=!0,this.$nextTick((function(){e.draw()}))},methods:{draw:function(){var e=i.init(this.$refs.scEcharts,"T");e.setOption(this.myOptions),this.myChart=e,window.addEventListener("resize",(function(){return e.resize()}))}}}),s=n("6b0d");const l=n.n(s)()(a,[["render",function(e,t,n,o,i,r){return Object(c.openBlock)(),Object(c.createElementBlock)("div",{ref:"scEcharts",style:Object(c.normalizeStyle)({height:n.height,width:n.width})},null,4)}]]);t.a=l},"659f":function(e,t,n){"use strict";n.r(t);n("a15b"),n("a4d3"),n("e01a");var c=n("7a23"),o=function(e){return Object(c.pushScopeId)("data-v-5ea30e96"),e=e(),Object(c.popScopeId)(),e},i={class:"widgets-content"},r={class:"widgets-top"},a=o((function(){return Object(c.createElementVNode)("div",{class:"widgets-top-title"}," 控制台 ",-1)})),s={class:"widgets-top-actions"},l=Object(c.createTextVNode)("完成"),d=Object(c.createTextVNode)("自定义"),u={class:"widgets",ref:"widgets"},m={class:"widgets-wrapper"},b={key:0,class:"no-widgets"},f={class:"widgets-item"},O={key:0,class:"customize-overlay"},p={key:0,class:"widgets-aside"},j=o((function(){return Object(c.createElementVNode)("div",{class:"widgets-aside-title"},[Object(c.createElementVNode)("i",{class:"el-icon-circle-plus"}),Object(c.createTextVNode)("添加部件")],-1)})),h=[o((function(){return Object(c.createElementVNode)("i",{class:"el-icon-close"},null,-1)}))],g={class:"selectLayout"},v=o((function(){return Object(c.createElementVNode)("span",null,null,-1)})),w=o((function(){return Object(c.createElementVNode)("span",null,null,-1)})),V=o((function(){return Object(c.createElementVNode)("span",null,null,-1)})),N=o((function(){return Object(c.createElementVNode)("span",null,null,-1)})),y=o((function(){return Object(c.createElementVNode)("span",null,null,-1)})),C=o((function(){return Object(c.createElementVNode)("span",null,null,-1)})),k=o((function(){return Object(c.createElementVNode)("span",null,null,-1)})),E=o((function(){return Object(c.createElementVNode)("span",null,null,-1)})),x=o((function(){return Object(c.createElementVNode)("span",null,null,-1)})),_={class:"widgets-list"},L={key:0,class:"widgets-list-nodata"},B={class:"item-logo"},S={class:"item-info"},z={class:"item-actions"},T=Object(c.createTextVNode)("恢复默认");var D=n("2909"),A=(n("e9c4"),n("d3b7"),n("99af"),n("7db0"),n("4de4"),n("159b"),n("b76a")),$=n.n(A),M=n("9755"),I={components:{draggable:$.a},data:function(){return{customizing:!1,allComps:M.default,selectLayout:[],defaultGrid:this.$CONFIG.DEFAULT_GRID,grid:[]}},created:function(){this.grid=this.$TOOL.data.get("grid")||JSON.parse(JSON.stringify(this.defaultGrid))},mounted:function(){this.$emit("on-mounted")},computed:{allCompsList:function(){var e=[];for(var t in this.allComps)e.push({key:t,title:M.default[t].title,icon:M.default[t].icon,description:M.default[t].description});for(var n=this.grid.copmsList.reduce((function(e,t){return e.concat(t)})),c=function(){var e=i[o];n.find((function(t){return t===e.key}))&&(e.disabled=!0)},o=0,i=e;o<i.length;o++)c();return e},myCompsList:function(){return this.allCompsList.filter((function(e){return!e.disabled}))},nowCompsList:function(){return this.grid.copmsList.reduce((function(e,t){return e.concat(t)}))}},methods:{custom:function(){var e=this;this.customizing=!0;var t=this.$refs.widgets.offsetWidth;this.$nextTick((function(){var n=e.$refs.widgets.offsetWidth/t;e.$refs.widgets.style.setProperty("transform","scale(".concat(n,")"))}))},setLayout:function(e){this.grid.layout=e,"24"==e.join(",")&&(this.grid.copmsList[0]=[].concat(Object(D.a)(this.grid.copmsList[0]),Object(D.a)(this.grid.copmsList[1]),Object(D.a)(this.grid.copmsList[2])),this.grid.copmsList[1]=[],this.grid.copmsList[2]=[])},push:function(e){this.grid.copmsList[0].push(e.key)},remove:function(e){var t=this.grid.copmsList;t.forEach((function(n,c){var o=n.filter((function(t){return t!=e}));t[c]=o}))},save:function(){this.customizing=!1,this.$refs.widgets.style.removeProperty("transform"),this.$TOOL.data.set("grid",this.grid)},backDefaul:function(){this.customizing=!1,this.$refs.widgets.style.removeProperty("transform"),this.grid=JSON.parse(JSON.stringify(this.defaultGrid)),this.$TOOL.data.remove("grid")},close:function(){this.customizing=!1,this.$refs.widgets.style.removeProperty("transform")}}},F=(n("f785"),n("6b0d"));const P=n.n(F)()(I,[["render",function(e,t,n,o,D,A){var $=Object(c.resolveComponent)("el-button"),M=Object(c.resolveComponent)("el-empty"),I=Object(c.resolveComponent)("draggable"),F=Object(c.resolveComponent)("el-col"),P=Object(c.resolveComponent)("el-row"),G=Object(c.resolveComponent)("el-header"),R=Object(c.resolveComponent)("el-main"),q=Object(c.resolveComponent)("el-footer"),J=Object(c.resolveComponent)("el-container");return Object(c.openBlock)(),Object(c.createElementBlock)("div",{class:Object(c.normalizeClass)(["widgets-home",D.customizing?"customizing":""]),ref:"main"},[Object(c.createElementVNode)("div",i,[Object(c.createElementVNode)("div",r,[a,Object(c.createElementVNode)("div",s,[D.customizing?(Object(c.openBlock)(),Object(c.createBlock)($,{key:0,type:"primary",icon:"el-icon-check",round:"",onClick:A.save},{default:Object(c.withCtx)((function(){return[l]})),_:1},8,["onClick"])):(Object(c.openBlock)(),Object(c.createBlock)($,{key:1,type:"primary",icon:"el-icon-edit",round:"",onClick:A.custom},{default:Object(c.withCtx)((function(){return[d]})),_:1},8,["onClick"]))])]),Object(c.createElementVNode)("div",u,[Object(c.createElementVNode)("div",m,[A.nowCompsList.length<=0?(Object(c.openBlock)(),Object(c.createElementBlock)("div",b,[Object(c.createVNode)(M,{image:"img/no-widgets.svg",description:"没有部件啦","image-size":280})])):Object(c.createCommentVNode)("",!0),Object(c.createVNode)(P,{gutter:15},{default:Object(c.withCtx)((function(){return[(Object(c.openBlock)(!0),Object(c.createElementBlock)(c.Fragment,null,Object(c.renderList)(D.grid.layout,(function(e,t){return Object(c.openBlock)(),Object(c.createBlock)(F,{key:t,md:e,xs:24},{default:Object(c.withCtx)((function(){return[Object(c.createVNode)(I,{modelValue:D.grid.copmsList[t],"onUpdate:modelValue":function(e){return D.grid.copmsList[t]=e},animation:"200",handle:".customize-overlay",group:"people","item-key":"com",dragClass:"aaaaa","force-fallback":"",fallbackOnBody:"",class:"draggable-box"},{item:Object(c.withCtx)((function(e){var t=e.element;return[Object(c.createElementVNode)("div",f,[(Object(c.openBlock)(),Object(c.createBlock)(Object(c.resolveDynamicComponent)(D.allComps[t]))),D.customizing?(Object(c.openBlock)(),Object(c.createElementBlock)("div",O,[Object(c.createVNode)($,{class:"close",type:"danger",plain:"",icon:"el-icon-close",size:"small",onClick:function(e){return A.remove(t)}},null,8,["onClick"]),Object(c.createElementVNode)("label",null,[Object(c.createElementVNode)("i",{class:Object(c.normalizeClass)(D.allComps[t].icon)},null,2),Object(c.createTextVNode)(Object(c.toDisplayString)(D.allComps[t].title),1)])])):Object(c.createCommentVNode)("",!0)])]})),_:2},1032,["modelValue","onUpdate:modelValue"])]})),_:2},1032,["md"])})),128))]})),_:1})])],512)]),D.customizing?(Object(c.openBlock)(),Object(c.createElementBlock)("div",p,[Object(c.createVNode)(J,null,{default:Object(c.withCtx)((function(){return[Object(c.createVNode)(G,null,{default:Object(c.withCtx)((function(){return[j,Object(c.createElementVNode)("div",{class:"widgets-aside-close",onClick:t[0]||(t[0]=function(e){return A.close()})},h)]})),_:1}),Object(c.createVNode)(G,{style:{height:"auto"}},{default:Object(c.withCtx)((function(){return[Object(c.createElementVNode)("div",g,[Object(c.createElementVNode)("div",{class:Object(c.normalizeClass)(["selectLayout-item item01",{active:"12,6,6"==D.grid.layout.join(",")}]),onClick:t[1]||(t[1]=function(e){return A.setLayout([12,6,6])})},[Object(c.createVNode)(P,{gutter:2},{default:Object(c.withCtx)((function(){return[Object(c.createVNode)(F,{span:12},{default:Object(c.withCtx)((function(){return[v]})),_:1}),Object(c.createVNode)(F,{span:6},{default:Object(c.withCtx)((function(){return[w]})),_:1}),Object(c.createVNode)(F,{span:6},{default:Object(c.withCtx)((function(){return[V]})),_:1})]})),_:1})],2),Object(c.createElementVNode)("div",{class:Object(c.normalizeClass)(["selectLayout-item item02",{active:"24,16,8"==D.grid.layout.join(",")}]),onClick:t[2]||(t[2]=function(e){return A.setLayout([24,16,8])})},[Object(c.createVNode)(P,{gutter:2},{default:Object(c.withCtx)((function(){return[Object(c.createVNode)(F,{span:24},{default:Object(c.withCtx)((function(){return[N]})),_:1}),Object(c.createVNode)(F,{span:16},{default:Object(c.withCtx)((function(){return[y]})),_:1}),Object(c.createVNode)(F,{span:8},{default:Object(c.withCtx)((function(){return[C]})),_:1})]})),_:1})],2),Object(c.createElementVNode)("div",{class:Object(c.normalizeClass)(["selectLayout-item item03",{active:"24"==D.grid.layout.join(",")}]),onClick:t[3]||(t[3]=function(e){return A.setLayout([24])})},[Object(c.createVNode)(P,{gutter:2},{default:Object(c.withCtx)((function(){return[Object(c.createVNode)(F,{span:24},{default:Object(c.withCtx)((function(){return[k]})),_:1}),Object(c.createVNode)(F,{span:24},{default:Object(c.withCtx)((function(){return[E]})),_:1}),Object(c.createVNode)(F,{span:24},{default:Object(c.withCtx)((function(){return[x]})),_:1})]})),_:1})],2)])]})),_:1}),Object(c.createVNode)(R,{class:"nopadding"},{default:Object(c.withCtx)((function(){return[Object(c.createElementVNode)("div",_,[A.myCompsList.length<=0?(Object(c.openBlock)(),Object(c.createElementBlock)("div",L,[Object(c.createVNode)(M,{description:"没有部件啦","image-size":60})])):Object(c.createCommentVNode)("",!0),(Object(c.openBlock)(!0),Object(c.createElementBlock)(c.Fragment,null,Object(c.renderList)(A.myCompsList,(function(e){return Object(c.openBlock)(),Object(c.createElementBlock)("div",{key:e.title,class:"widgets-list-item"},[Object(c.createElementVNode)("div",B,[Object(c.createElementVNode)("i",{class:Object(c.normalizeClass)(e.icon)},null,2)]),Object(c.createElementVNode)("div",S,[Object(c.createElementVNode)("h2",null,Object(c.toDisplayString)(e.title),1),Object(c.createElementVNode)("p",null,Object(c.toDisplayString)(e.description),1)]),Object(c.createElementVNode)("div",z,[Object(c.createVNode)($,{type:"primary",icon:"el-icon-plus",size:"small",onClick:function(t){return A.push(e)}},null,8,["onClick"])])])})),128))])]})),_:1}),Object(c.createVNode)(q,{style:{height:"51px"}},{default:Object(c.withCtx)((function(){return[Object(c.createVNode)($,{size:"mini",onClick:t[4]||(t[4]=function(e){return A.backDefaul()})},{default:Object(c.withCtx)((function(){return[T]})),_:1})]})),_:1})]})),_:1})])):Object(c.createCommentVNode)("",!0)],2)}],["__scopeId","data-v-5ea30e96"]]);t.default=P},"70a5":function(e,t,n){},"74a2":function(e,t,n){"use strict";n.r(t);var c=n("7a23"),o=Object(c.createElementVNode)("div",{class:"progress"},[Object(c.createElementVNode)("p",null,[Object(c.createElementVNode)("a",{href:"https://qm.qq.com/cgi-bin/qm/qr?k=uini_iX64HMzeaV1nrIB944mQ-8VHjbM&jump_from=webapi",target:"_blank"},[Object(c.createElementVNode)("img",{src:"https://svg.hamm.cn/badge.svg?key=点击入群&value=15169734"})])]),Object(c.createElementVNode)("p",null,[Object(c.createElementVNode)("a",{href:"https://support.qq.com/products/360106?",target:"_blank"},[Object(c.createElementVNode)("img",{src:"https://svg.hamm.cn/badge.svg?key=反馈&value=社区交流"})])])],-1);var i={title:"技术交流",data:function(){return{}}},r=n("6b0d");const a=n.n(r)()(i,[["render",function(e,t,n,i,r,a){var s=Object(c.resolveComponent)("el-card");return Object(c.openBlock)(),Object(c.createBlock)(s,{shadow:"hover",header:"技术交流"},{default:Object(c.withCtx)((function(){return[o]})),_:1})}]]);t.default=a},"88cf":function(e,t,n){},9555:function(e,t,n){},"959a":function(e,t,n){"use strict";n.r(t);var c=n("7a23"),o={style:{height:"210px","text-align":"center"}},i=Object(c.createElementVNode)("img",{src:"img/ver.svg",style:{height:"140px"}},null,-1),r={style:{"margin-top":"15px"}},a={style:{"margin-top":"5px"}},s={style:{"margin-top":"20px"}},l=Object(c.createTextVNode)("更新日志"),d=Object(c.createTextVNode)("gitee");var u=n("1da1"),m=(n("96cf"),{title:"版本信息",icon:"el-icon-monitor",description:"当前项目版本信息",data:function(){return{ver:"loading..."}},mounted:function(){this.getVer()},methods:{getVer:function(){return Object(u.a)(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:case"end":return e.stop()}}),e)})))()},golog:function(){window.open("https://gitee.com/xmo/MineAdmin/releases")},gogit:function(){window.open("https://gitee.com/xmo/MineAdmin")}}}),b=n("6b0d");const f=n.n(b)()(m,[["render",function(e,t,n,u,m,b){var f=Object(c.resolveComponent)("el-button"),O=Object(c.resolveComponent)("el-card");return Object(c.openBlock)(),Object(c.createBlock)(O,{shadow:"hover",header:"版本信息"},{default:Object(c.withCtx)((function(){return[Object(c.createElementVNode)("div",o,[i,Object(c.createElementVNode)("h2",r,"MineAdmin "+Object(c.toDisplayString)(e.$CONFIG.APP_VER),1),Object(c.createElementVNode)("p",a,"最新版本 "+Object(c.toDisplayString)(m.ver),1)]),Object(c.createElementVNode)("div",s,[Object(c.createVNode)(f,{type:"primary",plain:"",round:"",onClick:b.golog},{default:Object(c.withCtx)((function(){return[l]})),_:1},8,["onClick"]),Object(c.createVNode)(f,{type:"primary",plain:"",round:"",onClick:b.gogit},{default:Object(c.withCtx)((function(){return[d]})),_:1},8,["onClick"])])]})),_:1})}]]);t.default=f},9755:function(e,t,n){"use strict";n.r(t);n("d3b7"),n("159b"),n("ddb0"),n("ac1f"),n("5319");var c=n("7a23"),o={},i=n("b948");i.keys().forEach((function(e){var t=i(e);o[e.replace(/^\.\/(.*)\.\w+$/,"$1")]=t.default})),t.default=Object(c.markRaw)(o)},a884:function(e,t,n){"use strict";n("88cf")},ae8e:function(e,t,n){"use strict";n("70a5")},b948:function(e,t,n){var c={"./about.vue":"e6ab","./echarts.vue":"3266","./progress.vue":"74a2","./time.vue":"f369","./ver.vue":"959a","./welcome.vue":"0071"};function o(e){var t=i(e);return n(t)}function i(e){if(!n.o(c,e)){var t=new Error("Cannot find module '"+e+"'");throw t.code="MODULE_NOT_FOUND",t}return c[e]}o.keys=function(){return Object.keys(c)},o.resolve=i,e.exports=o,o.id="b948"},bc81:function(e,t,n){},e6ab:function(e,t,n){"use strict";n.r(t);var c=n("7a23"),o=function(e){return Object(c.pushScopeId)("data-v-ce45d956"),e=e(),Object(c.popScopeId)(),e},i=o((function(){return Object(c.createElementVNode)("p",null,"高性能 / 精致 / 优雅。后台基于Swoole的Hyperf框架，前端Vue3 + Element-Plus 的中后台解决方案，如果喜欢就点个星星支持一下。",-1)})),r=o((function(){return Object(c.createElementVNode)("p",null,[Object(c.createElementVNode)("a",{href:"https://gitee.com/xmo/MineAdmin",target:"_blank"},[Object(c.createElementVNode)("img",{src:"https://gitee.com/xmo/MineAdmin/badge/star.svg?theme=dark",alt:"star",style:{"vertical-align":"middle"}})])],-1)}));var a={title:"关于项目",icon:"el-icon-setting",description:"点个星星支持一下",data:function(){return{}}},s=(n("ae8e"),n("6b0d"));const l=n.n(s)()(a,[["render",function(e,t,n,o,a,s){var l=Object(c.resolveComponent)("el-card");return Object(c.openBlock)(),Object(c.createBlock)(l,{shadow:"hover",header:"关于项目",class:"item-background"},{default:Object(c.withCtx)((function(){return[i,r]})),_:1})}],["__scopeId","data-v-ce45d956"]]);t.default=l},f369:function(e,t,n){"use strict";n.r(t);var c=n("7a23"),o={class:"time"};var i={title:"时钟",icon:"el-icon-clock",description:"演示部件效果",data:function(){return{time:"",day:""}},mounted:function(){var e=this;this.showTime(),setInterval((function(){e.showTime()}),1e3)},methods:{showTime:function(){this.time=this.$TOOL.dateFormat(new Date,"hh:mm:ss"),this.day=this.$TOOL.dateFormat(new Date,"yyyy年MM月dd日")}}},r=(n("1905"),n("6b0d"));const a=n.n(r)()(i,[["render",function(e,t,n,i,r,a){var s=Object(c.resolveComponent)("el-card");return Object(c.openBlock)(),Object(c.createBlock)(s,{shadow:"hover",header:"时钟",class:"item-background"},{default:Object(c.withCtx)((function(){return[Object(c.createElementVNode)("div",o,[Object(c.createElementVNode)("h2",null,Object(c.toDisplayString)(r.time),1),Object(c.createElementVNode)("p",null,Object(c.toDisplayString)(r.day),1)])]})),_:1})}],["__scopeId","data-v-8af9f95e"]]);t.default=a},f785:function(e,t,n){"use strict";n("bc81")}}]);
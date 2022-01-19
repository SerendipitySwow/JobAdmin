(window.webpackJsonp=window.webpackJsonp||[]).push([["signature"],{"0c13":function(t,e,n){},"130b":function(t,e,n){"use strict";n("ee06")},4450:function(t,e,n){"use strict";n.r(e);n("e9c4");var r=n("7a23"),c=function(t){return Object(r.pushScopeId)("data-v-77e2467a"),t=t(),Object(r.popScopeId)(),t},i=c((function(){return Object(r.createElementVNode)("h2",null,"签名简介",-1)})),a=Object(r.createTextVNode)("MineAdmin API"),s=Object(r.createTextVNode)(" 的签名主要是用于获取身份令牌 "),o=c((function(){return Object(r.createElementVNode)("span",{class:"tag"},"AccessToken",-1)})),l=Object(r.createTextVNode)(" 时所需必要认证参数"),u=c((function(){return Object(r.createElementVNode)("p",null,[Object(r.createTextVNode)("在请求需要复杂认证接口的时候，系统会验证 "),Object(r.createElementVNode)("span",{class:"tag"},"AccessToken")],-1)})),h=c((function(){return Object(r.createElementVNode)("p",null,[Object(r.createTextVNode)("在请求获取 "),Object(r.createElementVNode)("span",{class:"tag"},"AccessToken"),Object(r.createTextVNode)(" 的接口时候，服务器会对用户请求合法性的 "),Object(r.createElementVNode)("span",{class:"tag"},"signature"),Object(r.createTextVNode)(" 进行检查，以此来确定是否向用户返回 "),Object(r.createElementVNode)("span",{class:"tag"},"AccessToken")],-1)})),d=c((function(){return Object(r.createElementVNode)("h2",null,"获取app id 和 app secret",-1)})),p=c((function(){return Object(r.createElementVNode)("p",null,[Object(r.createTextVNode)("进入后台管理系统后，依次点击以下导航获取"),Object(r.createElementVNode)("span",{class:"tag"},"app id"),Object(r.createTextVNode)(" 和 "),Object(r.createElementVNode)("span",{class:"tag"},"app secret")],-1)})),_=c((function(){return Object(r.createElementVNode)("p",null,[Object(r.createElementVNode)("span",{class:"tag"},"数据中心"),Object(r.createTextVNode)(" > "),Object(r.createElementVNode)("span",{class:"tag"},"应用中心"),Object(r.createTextVNode)(" > "),Object(r.createElementVNode)("span",{class:"tag"},"应用管理")],-1)})),g=c((function(){return Object(r.createElementVNode)("p",null,[Object(r.createTextVNode)("鼠标移动到要赋值的 "),Object(r.createElementVNode)("span",{class:"tag"},"app id"),Object(r.createTextVNode)(" 或 "),Object(r.createElementVNode)("span",{class:"tag"},"app secret"),Object(r.createTextVNode)("，单击左键即可复制到剪切板")],-1)})),f=c((function(){return Object(r.createElementVNode)("h2",null,"生成signature",-1)})),b=c((function(){return Object(r.createElementVNode)("p",null,"一、组合签名数据格式",-1)})),O=c((function(){return Object(r.createElementVNode)("p",null,[Object(r.createTextVNode)("二、根据字段名降序排序，组合"),Object(r.createElementVNode)("span",{class:"tag"},"http原始字符串")],-1)})),j=Object(r.createTextVNode)("三、md5"),m=c((function(){return Object(r.createElementVNode)("span",{class:"tag"},"http原始字符串",-1)})),N=Object(r.createTextVNode)("，完成生成 "),T=Object(r.createTextVNode)("signature"),x=c((function(){return Object(r.createElementVNode)("h2",null,"获取AccessToken",-1)})),V=Object(r.createTextVNode)("1. "),v=c((function(){return Object(r.createElementVNode)("span",{class:"tag"},"AccessToken",-1)})),E=Object(r.createTextVNode)("有效期只有 "),k=Object(r.createTextVNode)("7200"),y=Object(r.createTextVNode)(" 秒，获取后请缓存到本地"),w=c((function(){return Object(r.createElementVNode)("p",null,[Object(r.createTextVNode)("2. 有效期内再次请求的"),Object(r.createElementVNode)("span",{class:"tag"},"AccessToken"),Object(r.createTextVNode)("会导致之前请求的全部失效")],-1)})),C=c((function(){return Object(r.createElementVNode)("p",null,"3. 最好使用服务器端来做接口请求，客户端可能会出现跨域等问题。",-1)})),A=Object(r.createTextVNode)("4. 获取"),S=c((function(){return Object(r.createElementVNode)("span",{class:"tag"},"AccessToken",-1)})),I=Object(r.createTextVNode)("地址："),K=Object(r.createTextVNode)("http://你的服务器地址/api/v1/getAccessToken"),G=Object(r.createTextVNode)("请求方法：POST"),U=c((function(){return Object(r.createElementVNode)("br",null,null,-1)})),$=c((function(){return Object(r.createElementVNode)("p",null,"组合完整请求参数",-1)})),L=c((function(){return Object(r.createElementVNode)("p",null,[Object(r.createTextVNode)("请求获取"),Object(r.createElementVNode)("span",{class:"tag"},"AccessToken"),Object(r.createTextVNode)("接口")],-1)}));var J={components:{maHighlight:n("6dd0").a},data:function(){return{jsonData:{app_id:"到后台应用管理查看app id",app_secret:"到后台应用管理查看app secret",sign_ver:"1.0",timestamp:"当前系统时间戳"},demoData:"app_id=xxxx&app_secret=xxxxxxxxxx&sign_ver=1.0&timestamp=128097733",requestParams:{app_id:"xxxx",signature:"2d41751369f4daaf9dd869aefa0da1e4",timestamp:128097733}}}},H=(n("d57f"),n("6b0d"));const M=n.n(H)()(J,[["render",function(t,e,n,c,J,H){var M=Object(r.resolveComponent)("el-tag"),R=Object(r.resolveComponent)("el-card"),P=Object(r.resolveComponent)("el-timeline-item"),D=Object(r.resolveComponent)("ma-highlight"),q=Object(r.resolveComponent)("el-timeline");return Object(r.openBlock)(),Object(r.createBlock)(R,{shadow:"never",class:"card"},{default:Object(r.withCtx)((function(){return[Object(r.createVNode)(q,null,{default:Object(r.withCtx)((function(){return[Object(r.createVNode)(P,{timestamp:"签名简介",placement:"top"},{default:Object(r.withCtx)((function(){return[Object(r.createVNode)(R,null,{default:Object(r.withCtx)((function(){return[i,Object(r.createElementVNode)("p",null,[Object(r.createVNode)(M,null,{default:Object(r.withCtx)((function(){return[a]})),_:1}),s,o,l]),u,h]})),_:1})]})),_:1}),Object(r.createVNode)(P,{timestamp:"获取app id 和 app secret",placement:"top"},{default:Object(r.withCtx)((function(){return[Object(r.createVNode)(R,null,{default:Object(r.withCtx)((function(){return[d,p,_,g]})),_:1})]})),_:1}),Object(r.createVNode)(P,{timestamp:"生成signature",placement:"top"},{default:Object(r.withCtx)((function(){return[Object(r.createVNode)(R,null,{default:Object(r.withCtx)((function(){return[f,b,Object(r.createVNode)(D,{code:JSON.stringify(J.jsonData),lang:"json"},null,8,["code"]),O,Object(r.createVNode)(D,{code:J.demoData,lang:"js"},null,8,["code"]),Object(r.createElementVNode)("p",null,[j,m,N,Object(r.createVNode)(M,{type:"danger"},{default:Object(r.withCtx)((function(){return[T]})),_:1})]),Object(r.createVNode)(D,{code:"2d41751369f4daaf9dd869aefa0da1e4",lang:"js"})]})),_:1})]})),_:1}),Object(r.createVNode)(P,{timestamp:"获取AccessToken",placement:"top"},{default:Object(r.withCtx)((function(){return[Object(r.createVNode)(R,null,{default:Object(r.withCtx)((function(){return[x,Object(r.createElementVNode)("p",null,[V,v,E,Object(r.createVNode)(M,null,{default:Object(r.withCtx)((function(){return[k]})),_:1}),y]),w,C,Object(r.createElementVNode)("p",null,[A,S,I,Object(r.createVNode)(M,null,{default:Object(r.withCtx)((function(){return[K]})),_:1}),G]),U,$,Object(r.createVNode)(D,{code:JSON.stringify(J.requestParams),lang:"json"},null,8,["code"]),L,Object(r.createVNode)(D,{code:"//请求方法：POST\nhttp://服务器地址/api/v1/getAccessToken",lang:"js"})]})),_:1})]})),_:1})]})),_:1})]})),_:1})}],["__scopeId","data-v-77e2467a"]]);e.default=M},"6dd0":function(t,e,n){"use strict";var r=n("7a23"),c={class:"code-container"},i=["innerHTML"],a=Object(r.createTextVNode)("复制");var s=n("1da1"),o=(n("d3b7"),n("e9c4"),n("ac1f"),n("5319"),n("1276"),n("159b"),n("466d"),n("fb6a"),n("a434"),n("a15b"),n("498a"),n("96cf"),n("e6a9")),l=n.n(o),u=n("1487"),h=n.n(u),d=(n("4d63"),n("c607"),n("2c3e"),n("25f0"),function(t){var e=["__dataHolder_",[Math.random(),Math.random(),Math.random(),Math.random()].join("_").replace(/[^0-9]/g,"_"),"_"].join("_"),n={},r=0;return t=(t=function(t,e,n,r){var c;for((c=new function(){return this.pos=0,this.token="",this.current_mode="CONTENT",this.tags={parent:"parent1",parentcount:1,parent1:""},this.tag_type="",this.token_text=this.last_token=this.last_text=this.token_type="",this.Utils={whitespace:"\n\r\t ".split(""),single_token:"br,input,link,meta,!doctype,basefont,base,area,hr,wbr,param,img,isindex,?xml,embed".split(","),extra_liners:"head,body,/html".split(","),in_array:function(t,e){for(var n=0;n<e.length;n++)if(t===e[n])return!0;return!1}},this.get_content=function(){for(var t="",e=[],n=!1;"<"!==this.input.charAt(this.pos);){if(this.pos>=this.input.length)return e.length?e.join(""):["","TK_EOF"];if(t=this.input.charAt(this.pos),this.pos++,this.line_char_count++,this.Utils.in_array(t,this.Utils.whitespace))e.length&&(n=!0),this.line_char_count--;else{if(n){if(this.line_char_count>=this.max_char){e.push("\n");for(var r=0;r<this.indent_level;r++)e.push(this.indent_string);this.line_char_count=0}else e.push(" "),this.line_char_count++;n=!1}e.push(t)}}return e.length?e.join(""):""},this.get_script=function(){var t="",e=[],n=new RegExp("<\/script>","igm");n.lastIndex=this.pos;for(var r=n.exec(this.input),c=r?r.index:this.input.length;this.pos<c;){if(this.pos>=this.input.length)return e.length?e.join(""):["","TK_EOF"];t=this.input.charAt(this.pos),this.pos++,e.push(t)}return e.length?e.join(""):""},this.record_tag=function(t){this.tags[t+"count"]?(this.tags[t+"count"]++,this.tags[t+this.tags[t+"count"]]=this.indent_level):(this.tags[t+"count"]=1,this.tags[t+this.tags[t+"count"]]=this.indent_level),this.tags[t+this.tags[t+"count"]+"parent"]=this.tags.parent,this.tags.parent=t+this.tags[t+"count"]},this.retrieve_tag=function(t){if(this.tags[t+"count"]){for(var e=this.tags.parent;e&&t+this.tags[t+"count"]!==e;)e=this.tags[e+"parent"];e&&(this.indent_level=this.tags[t+this.tags[t+"count"]],this.tags.parent=this.tags[e+"parent"]),delete this.tags[t+this.tags[t+"count"]+"parent"],delete this.tags[t+this.tags[t+"count"]],1==this.tags[t+"count"]?delete this.tags[t+"count"]:this.tags[t+"count"]--}},this.get_tag=function(){var t="",e=[],n=!1;do{if(this.pos>=this.input.length)return e.length?e.join(""):["","TK_EOF"];t=this.input.charAt(this.pos),this.pos++,this.line_char_count++,this.Utils.in_array(t,this.Utils.whitespace)?(n=!0,this.line_char_count--):("'"!==t&&'"'!==t||e[1]&&"!"===e[1]||(t+=this.get_unformatted(t),n=!0),"="===t&&(n=!1),e.length&&"="!==e[e.length-1]&&">"!==t&&n&&(this.line_char_count>=this.max_char?(this.print_newline(!1,e),this.line_char_count=0):(e.push(" "),this.line_char_count++),n=!1),e.push(t))}while(">"!==t);var r,c=e.join("");r=-1!=c.indexOf(" ")?c.indexOf(" "):c.indexOf(">");var i=c.substring(1,r).toLowerCase();if("/"===c.charAt(c.length-2)||this.Utils.in_array(i,this.Utils.single_token))this.tag_type="SINGLE";else if("script"===i)this.record_tag(i),this.tag_type="SCRIPT";else if("style"===i)this.record_tag(i),this.tag_type="STYLE";else if("!"===i.charAt(0))if(-1!=i.indexOf("[if")){if(-1!=c.indexOf("!IE")){var a=this.get_unformatted("--\x3e",c);e.push(a)}this.tag_type="START"}else-1!=i.indexOf("[endif")?(this.tag_type="END",this.unindent()):-1!=i.indexOf("[cdata[")?(a=this.get_unformatted("]]>",c),e.push(a),this.tag_type="SINGLE"):(a=this.get_unformatted("--\x3e",c),e.push(a),this.tag_type="SINGLE");else"/"===i.charAt(0)?(this.retrieve_tag(i.substring(1)),this.tag_type="END"):(this.record_tag(i),this.tag_type="START"),this.Utils.in_array(i,this.Utils.extra_liners)&&this.print_newline(!0,this.output);return e.join("")},this.get_unformatted=function(t,e){if(e&&-1!=e.indexOf(t))return"";var n="",r="",c=!0;do{if(n=this.input.charAt(this.pos),this.pos++,this.Utils.in_array(n,this.Utils.whitespace)){if(!c){this.line_char_count--;continue}if("\n"===n||"\r"===n){r+="\n";for(var i=0;i<this.indent_level;i++)r+=this.indent_string;c=!1,this.line_char_count=0;continue}}r+=n,this.line_char_count++,c=!0}while(-1==r.indexOf(t));return r},this.get_token=function(){var t;if("TK_TAG_SCRIPT"===this.last_token){var e=this.get_script();return"string"!=typeof e?e:[e,"TK_CONTENT"]}return"CONTENT"===this.current_mode?"string"!=typeof(t=this.get_content())?t:[t,"TK_CONTENT"]:"TAG"===this.current_mode?"string"!=typeof(t=this.get_tag())?t:[t,"TK_TAG_"+this.tag_type]:void 0},this.printer=function(t,e,n,r){this.input=t||"",this.output=[],this.indent_character=e||" ",this.indent_string="",this.indent_size=n||2,this.indent_level=0,this.max_char=r||70,this.line_char_count=0;for(var c=0;c<this.indent_size;c++)this.indent_string+=this.indent_character;this.print_newline=function(t,e){if(this.line_char_count=0,e&&e.length){if(!t)for(;this.Utils.in_array(e[e.length-1],this.Utils.whitespace);)e.pop();e.push("\n");for(var n=0;n<this.indent_level;n++)e.push(this.indent_string)}},this.print_token=function(t){this.output.push(t)},this.indent=function(){this.indent_level++},this.unindent=function(){this.indent_level>0&&this.indent_level--}},this}).printer(t,n,e);;){var i=c.get_token();if(c.token_text=i[0],c.token_type=i[1],"TK_EOF"===c.token_type)break;switch(c.token_type){case"TK_TAG_START":case"TK_TAG_SCRIPT":case"TK_TAG_STYLE":c.print_newline(!1,c.output),c.print_token(c.token_text),c.indent(),c.current_mode="CONTENT";break;case"TK_TAG_END":c.print_newline(!0,c.output),c.print_token(c.token_text),c.current_mode="CONTENT";break;case"TK_TAG_SINGLE":c.print_newline(!1,c.output),c.print_token(c.token_text),c.current_mode="CONTENT";break;case"TK_CONTENT":""!==c.token_text&&(c.print_newline(!1,c.output),c.print_token(c.token_text)),c.current_mode="TAG"}c.last_token=c.token_type,c.last_text=c.token_text}return c.output.join("")}(t=t.replace(/(\")(data:[^\"]*)(\")/g,(function(t,c,i,a){var s=e+r++;return n[s]=i,c+s+a})),2," ")).replace(new RegExp(e+"[0-9]+","g"),(function(t){return n[t]}))}),p=(n("d2ee"),{name:"maHighlight",props:{code:{type:String,required:!1,default:""},formatHtml:{type:Boolean,required:!1,default:!1},lang:{type:String,required:!1,default:""}},data:function(){return{highlightHTML:""}},mounted:function(){this.highlight()},watch:{code:function(){this.highlight()}},methods:{copy:function(){var t=this;return Object(s.a)(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.prev=0,e.next=3,l()().toClipboard(t.code);case 3:t.$message.success(t.$t("sys.copy_success")),e.next=9;break;case 6:e.prev=6,e.t0=e.catch(0),t.$message.error(t.$t("sys.copy_fail"));case 9:case"end":return e.stop()}}),e,null,[[0,6]])})))()},highlight:function(){var t=this.formatHtml?d(this.code):this.code;t="json"===this.lang?this.formatJson(t):t,this.highlightHTML=h.a.highlightAuto(t,[this.lang,"html","javascript","json","css","scss","less"]).value},transitionJsonToString:function(t,e){var n=null;if("[object String]"!==Object.prototype.toString.call(t))try{n=JSON.stringify(t)}catch(t){console.error("您传递的json数据格式有误，请核对..."),console.error(t),e(t)}else try{if(""==t||null==t)return"{}";t=t.replace(/(\')/g,'"'),n=JSON.stringify(JSON.parse(t))}catch(t){console.error("您传递的json数据格式有误，请核对..."),console.error(t),e(t)}return n},formatJson:function(t,e){var n="",r=0,c=this.transitionJsonToString(t,e);if(!c)return c;var i=[],a=null,s=null,o=[];return c=(c=(c=(c=(c=c.replace(/([\{\}])/g,"\r\n$1\r\n")).replace(/([\[\]])/g,"\r\n$1\r\n")).replace(/(\,)/g,"$1\r\n")).replace(/(\r\n\r\n)/g,"\r\n")).replace(/\r\n\,/g,","),(o=c.split("\r\n")).forEach((function(t,e){var n=t.match(/\"/g)?t.match(/\"/g).length:0;n%2&&!a&&(a=e),n%2&&a&&a!=e&&(s=e),a&&s&&(i.push({start:a,end:s}),a=null,s=null)})),i.reverse().forEach((function(t){var e=o.slice(t.start,t.end+1);o.splice(t.start,t.end+1-t.start,e.join(""))})),c=(c=(c=o.join("\r\n")).replace(/\:\r\n\{/g,":{")).replace(/\:\r\n\[/g,":["),(o=c.split("\r\n")).forEach((function(t){var e=0,c=0,i="";for(t.match(/\{$/)||t.match(/\[$/)?c+=1:t.match(/\}$/)||t.match(/\]$/)||t.match(/\},$/)||t.match(/\],$/)?0!==r&&(r-=1):c=0,e=0;e<r;e++)i+="    ";n+=i+t+"\r\n",r+=c})),n.trim()}}}),_=(n("130b"),n("6b0d"));const g=n.n(_)()(p,[["render",function(t,e,n,s,o,l){var u=Object(r.resolveComponent)("el-button");return Object(r.openBlock)(),Object(r.createElementBlock)("div",c,[Object(r.createElementVNode)("pre",{class:"ma-highlight hljs",innerHTML:o.highlightHTML},null,8,i),Object(r.createVNode)(u,{type:"primary",class:"copy-btn",onClick:l.copy},{default:Object(r.withCtx)((function(){return[a]})),_:1},8,["onClick"])])}],["__scopeId","data-v-5fbc9de3"]]);e.a=g},d2ee:function(t,e,n){},d57f:function(t,e,n){"use strict";n("0c13")},ee06:function(t,e,n){}}]);
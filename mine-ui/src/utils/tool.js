/*
 * @Descripttion: 工具集
 * @version: 1.1
 * @LastEditors: sakuya
 * @LastEditTime: 2021年7月20日10:58:41
 */

import CryptoJS from 'crypto-js';

const tool = {}

/* localStorage */
tool.data = {
	set(table, settings) {
		var _set = JSON.stringify(settings)
		return localStorage.setItem(table, _set);
	},
	get(table) {
		var data = localStorage.getItem(table);
		try {
			data = JSON.parse(data)
		} catch (err) {
			return null
		}
		return data;
	},
	remove(table) {
		return localStorage.removeItem(table);
	},
	clear() {
		return localStorage.clear();
	}
}

/* Fullscreen */
tool.screen = function (element) {
	var isFull = !!(document.webkitIsFullScreen || document.mozFullScreen || document.msFullscreenElement || document.fullscreenElement);
	if(isFull){
		if(document.exitFullscreen) {
			document.exitFullscreen();
		}else if (document.msExitFullscreen) {
			document.msExitFullscreen();
		}else if (document.mozCancelFullScreen) {
			document.mozCancelFullScreen();
		}else if (document.webkitExitFullscreen) {
			document.webkitExitFullscreen();
		}
	}else{
		if(element.requestFullscreen) {
			element.requestFullscreen();
		}else if(element.msRequestFullscreen) {
			element.msRequestFullscreen();
		}else if(element.mozRequestFullScreen) {
			element.mozRequestFullScreen();
		}else if(element.webkitRequestFullscreen) {
			element.webkitRequestFullscreen();
		}
	}
}

/* 复制对象 */
tool.objCopy = function (obj) {
	return JSON.parse(JSON.stringify(obj));
}

/* 日期格式化 */
tool.dateFormat = function (date, fmt='yyyy-MM-dd') {
	date = new Date(date)
	var o = {
		"M+" : date.getMonth()+1,                 //月份
		"d+" : date.getDate(),                    //日
		"h+" : date.getHours(),                   //小时
		"m+" : date.getMinutes(),                 //分
		"s+" : date.getSeconds(),                 //秒
		"q+" : Math.floor((date.getMonth()+3)/3), //季度
		"S"  : date.getMilliseconds()             //毫秒
	};
	if(/(y+)/.test(fmt)) {
		fmt=fmt.replace(RegExp.$1, (date.getFullYear()+"").substr(4 - RegExp.$1.length));
	}
	for(var k in o) {
		if(new RegExp("("+ k +")").test(fmt)){
			fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));
		}
	}
	return fmt;
}

/* 千分符 */
tool.groupSeparator = function (num) {
	num = num + '';
	if(!num.includes('.')){
		num += '.'
	}
	return num.replace(/(\d)(?=(\d{3})+\.)/g, function ($0, $1) {
		return $1 + ',';
	}).replace(/\.$/, '');
}

/* 常用加解密 */
tool.crypto = {
	//MD5加密
	MD5(data){
		return CryptoJS.MD5(data).toString()
	},
	//BASE64加解密
	BASE64: {
		encrypt(data){
			return CryptoJS.enc.Base64.stringify(CryptoJS.enc.Utf8.parse(data))
		},
		decrypt(cipher){
			return CryptoJS.enc.Base64.parse(cipher).toString(CryptoJS.enc.Utf8)
		}
	},
	//AES加解密
	AES: {
		encrypt(data, secretKey){
			const result = CryptoJS.AES.encrypt(data, CryptoJS.enc.Utf8.parse(secretKey))
			return result.toString()
		},
		decrypt(cipher, secretKey){
			const result = CryptoJS.AES.decrypt(cipher, CryptoJS.enc.Utf8.parse(secretKey))
			return CryptoJS.enc.Utf8.stringify(result);
		}
	}
}

tool.capsule = function (title, info, type = 'primary') {
	console.log(
		`%c ${title} %c ${info} %c`,
		'background:#35495E; padding: 1px; border-radius: 3px 0 0 3px; color: #fff;',
		`background:${typeColor(type)}; padding: 1px; border-radius: 0 3px 3px 0;  color: #fff;`,
		'background:transparent'
	)
}

function typeColor (type = 'default') {
	let color = ''
	switch (type) {
		case 'default': color = '#35495E'; break
		case 'primary': color = '#3488ff'; break
		case 'success': color = '#43B883'; break
		case 'warning': color = '#e6a23c'; break
		case 'danger': color = '#f56c6c'; break
		default: break
	}
	return color
}

tool.formatData = function (data) {
	if (typeof data == 'undefined') {
		return '0';
	}
	if (data < (1024 * 1024)) {
		return parseInt(data / 1024 / 1024) + 'K'
	} else if (data < (1024 * 1024 * 1024)) {
		return parseInt(data / 1024 / 1024 / 1024) + 'M'
	} else if (data < (1024 * 1024 * 1024 * 1024)) {
		return parseInt(data / 1024 / 1024 / 1024 / 1024) + 'G'
	} else if (data < (1024 * 1024 * 1024 * 1024 * 1024)) {
		return parseInt(data / 1024 / 1024 / 1024 / 1024 / 1024) + 'T'
	} else {
		return '文件太大'
	}
}

tool.download = function(res) {
	const aLink = document.createElement('a')
	console.log(res.headers);
  var blob = new Blob([res.data], {type: res.headers['content-type']})
  // //从response的headers中获取filename, 后端response.setHeader("Content-disposition", "attachment; filename=xxxx.docx") 设置的文件名;
  var patt = new RegExp('filename=([^;]+\\.[^\\.;]+);*')
  var contentDisposition = decodeURI(res.headers['content-disposition'])
  var result = patt.exec(contentDisposition)
  var fileName = result[1]
  fileName = fileName.replace(/\"/g, '')
  aLink.style.display = 'none'
  aLink.href = URL.createObjectURL(blob)
  aLink.setAttribute('download', fileName) // 设置下载文件名称
  document.body.appendChild(aLink)
  aLink.click()
  URL.revokeObjectURL(aLink.href);//清除引用
  document.body.removeChild(aLink);
}

export default tool

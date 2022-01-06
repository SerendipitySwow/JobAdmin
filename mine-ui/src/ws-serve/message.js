import webSocket from "@/utils/webSocket"
import tool from '@/utils/tool'
import { ElNotification } from 'element-plus'

class Message {

  ws

  constructor() {
    console.log(process.env.VUE_APP_WS_URL + '?token=' + tool.getToken())
    this.ws = new webSocket(
      process.env.VUE_APP_WS_URL + '?token=' + tool.getToken(), {
        onOpen:  _ => { console.log('已成功连接到消息服务器...') },
        onError: _ => { console.log('未成功连接到消息服务器...') },
        onClose: _ => { console.log('与消息服务器断开...') },
      }
    )

    this.registerEvents()
  }

  registerEvents() {
    this.ws.on('ev_new_message', data => {
      ElNotification.success({
        title: '新消息提示',
        message: "您收到一条新的消息，请注意查收！",
        onClick: data => {
          console.log(data)
        }
      })
    })

    this.ws.on('ev_read_status', data => {
      // TODO...
    })

    this.ws.on('ev_error', data => {
      ElNotification.error({
        title: '提示',
        message: data.message,
      })
    })
  }

  connection() {
    this.ws.connection()
  }

}

export default Message
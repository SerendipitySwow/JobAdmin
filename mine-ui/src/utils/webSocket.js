/**
 * websocket处理封装
 * @author X.Mo <root@imoi.cn>
 */

class webSocket
{
    /**
     * websocket 连接句柄
     * @var Websocket
     */
    ws

    /**
     * 服务器地址
     * @var 
     */
    serverUrl

    /**
     * 心跳发送间隔，默认10秒
     * @var int
     */
    heartbeatInterval = 10 * 1000

    /**
     * 心跳定时器
     * @var function
     */
    heaerbeatTimer = () => {}

    /**
     * ws事件
     * @var Array
     */
    onEvent = []
}
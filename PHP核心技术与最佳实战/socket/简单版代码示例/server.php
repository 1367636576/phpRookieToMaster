<?php
//确保在连接客户端时不会超时
set_time_limit(0);
$ip = '127.0.0.1';
$port = 8888;

/*
 +-------------------------------
 *    @socket通信整个过程
+-------------------------------
 *    @socket_create 1.初始化Socket
 *    @socket_bind  2.端口绑定(bind)
 *    @socket_listen 3.对端口进行监听(listen)
  *    @socket_accept 4.调用accept阻塞，等待 客户端连接
  *    @socket_read 5.接收客户端请求数据
  *    @socket_write 6.回应数据发送给客户端
  *    @socket_close 7.关闭连接
  +--------------------------------
 */

/*----------------    1.初始化Socket    -------------------*/
//创建服务端的socket套接流,net协议为IPv4，protocol协议为TCP
$socket = socket_create(AF_INET,SOCK_STREAM,SOL_TCP);

/*----------------    2.端口绑定(bind)    -------------------*/
/*绑定接收的套接流主机和端口,与客户端相对应*/
if(socket_bind($socket,$ip,$port) == false){
    echo 'server bind fail:'.socket_strerror(socket_last_error());
    /*这里的127.0.0.1是在本地主机测试，你如果有多台电脑，可以写IP地址*/
}

/*----------------    3.对端口进行监听(listen)    -------------------*/
//监听套接流
if(socket_listen($socket,4)==false){
    echo 'server listen fail:'.socket_strerror(socket_last_error());
}


/*----------------    4.调用accept阻塞，等待 客户端连接    -------------------*/
//让服务器无限获取客户端传过来的信息
do{
    /*接收客户端传过来的信息*/
    $accept_resource = socket_accept($socket);
    /*socket_accept的作用就是接受socket_bind()所绑定的主机发过来的套接流*/

    if($accept_resource !== false){
        /*读取客户端传过来的资源，并转化为字符串*/
        /*----------5.接收客户端请求数据-----------*/
        $string = socket_read($accept_resource,1024);
        /*socket_read的作用就是读出socket_accept()的资源并把它转化为字符串*/

        echo 'server receive is :'.$string.PHP_EOL;//PHP_EOL为php的换行预定义常量
        if($string != false){
            $return_client = 'server receive is : '.$string.PHP_EOL;
            /*向socket_accept的套接流写入信息，也就是回馈信息给socket_bind()所绑定的主机客户端*/
            /*------6.回应数据发送给客户端-----------*/
            socket_write($accept_resource,$return_client,strlen($return_client));
            /*socket_write的作用是向socket_create的套接流写入信息，或者向socket_accept的套接流写入信息*/
        }else{
            echo 'socket_read is fail';
        }
        /*socket_close的作用是关闭socket_create()或者socket_accept()所建立的套接流*/
        socket_close($accept_resource);
    }
}while(true);
socket_close($socket);

## 通讯流程

>什么是Socket？工作流程是怎样的？
    
    Socket又称网络套接字，是一种操作系统提供的进程间通信机制

    工作流程
        1.服务端先用socket 函数来建立一个套接字，并调用 listen 函数，使服务端
        的这个端口和ip处于监听状态，等待客户端的连接

        2.客户端用socket函数建立一个套接字，设定远程 IP 和端口，并调用 connect 函数

        3.服务端用accept 函数来接受远程计算机的连接，建立起与客户端之间的通信

        4.完成通信以后,最后使用 close 函数关闭 socket 连接。

   
>服务器端

        socket(创建socket)
        bind(绑定socket和端口号)
        listen(监听该端口号)
        read,write(读取数据和返回数据)
        close(关闭socket)
>客户端

        socket(创建socket)
        connect(连接指定的端口)
        read,write(读取数据和返回数据)
        close(关闭socket)
        
        

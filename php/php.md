# php

> Hypertext Preprocessor，超文本预处理语言


## cli模式和cgi模式区别:

>cli是命令行模式,cgi是web模式

    cgi
        公共网关接口 HTTP服务器与你的或其他机器上的程序进行'交谈'的一种工具,其程序必须运行在网络服务上.
        以cgi方式运行时,web server 将用户请求以消息的方式转交给php独立进程,php与web服务之间无从属关系
        纯粹调用 -- 返回结果的形式通讯
        模块模式 将php作为web server 的子进程控制,两者之间有从属关系
        明显例子: cgi模式下,如果修改了php.ini的配置文件,不用重启web服务便可生效,而模块模式下需要重启web服务

    cli 
        命令行界面 可在用户提示符下键入可执行指令的界面
        cli则是命令行接口,用于在操作系统命令模式下执行php,比如可以直接在win的cmd或linux的shell模式下直接输入php a.php来得到结果
        它与cgi模式最大的不同的地方在于既不会输出HTTP头信息(cgi模式除了输出用户能看到的结果外,还会输出用户不能直接看到的HTTP头信息)
        抛出的信息也直接以文本方式而不以HTML方式给出,比如新建一个test.php,写入内容:<?php phpinfo(); ?>,在浏览器中可以看到以HTML
        表格描述的信息,而在命令行输入php test.php 则会看到纯文本的输出








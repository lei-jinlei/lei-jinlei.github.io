# php

> Hypertext Preprocessor，超文本预处理语言

## php的设计理念及特点

- 多进程模型：这样能做到进程间互相不受影响，对于进程的资源利用更快速、便捷
- 弱类型语言：和强类型语言C、C++、java等语言不同，php中变量的类型并不是一开始就确定的，他是在运行时才确定的，可以隐式或显式的对其进行类型转换，这就使其在开发中非常的灵活，程序员无需关注变量类型的问题
- Zend引擎+ 组件（ext）的模式降低内部的耦合
- 中间层（sapi）隔绝web server 和php
- 语法简单灵活，规范少。这一点就有利有弊了。。。

## PHP 的四层体系：
PHP从下到上是一个4层体系：
- Zend引擎：Zend整体用纯C实现，是PHP的内核部门，它将PHP代码翻译（词法、语法解析等一系列编译过程）为可执行opcode的处理
并实现相应的处理方法、实现了基本的数据结构（如hashtable、oo）、内存分配及管理、提供了相应的api方法供外部调用，是一切的核心，
所有的外围功能均围绕 Zend 实现
- Extensions：围绕着 Zend 引擎，extensions 通过组件式的方式提供各种基础服务，我们常见的各种内置函数（如array系列）、标准库等
都是通过extension来实现，用户也可以根据需要实现自己的extension以达到功能扩展、性能优化等目的（如贴吧正在使用的PHP中间层、富文本解析
就是extension的典型应用）
- Sapi：Sapi 全称是Server Application Programming Interface，也就是服务端应用编程接口，Sapi 通过一系列钩子函数，
使得PHP可以和外围交互数据，这是PHP非常优雅和成功的一个设计，通过sapi成功的将PHP本身和上层应用解耦隔离，PHP可以不再考虑如何针对不同应用
进行兼容，而应用本身也可以针对自己的特点实现不同的处理方式
- 上层应该：这就是我们平时编写的PHP程序，通过不同的sapi方式得到各种各样的应用模式，如通过webserver实现web应用、在命令行下以脚本方式运行等等


## Sapi
Sapi 通过一系列的接口，使得外部应用可以和PHP交换数据并可以根据不同应用特点实现特定的处理方法，我们常见的一些sapi有：
- apache2handler：这是以Apache作为webserver，采用mod_php模式运行时候的处理方式,也是现在应用最广泛的一种
- cgi：这是webserver和PHP直接的另一种交互方式，也就是大名鼎鼎的fastcgi协议，在最近今年fastcgi+PHP得到越来越多的应用，
也是异步webserver所唯一支持的方式
- cli：命令行调用的应用模式


### cli模式和cgi模式区别:

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

### 动态语言执行过程

- 拿到一段代码后，scanning(Lexing)，将PHP代码转换为语言片段(Token)
- Parsing 将Tokens转换成简单而有意义的表达式
- Compilation 将表达式编译成 Opcode
- Execution 顺次执行Opcodes，从而实现PHP脚本的功能


## Zend引擎介绍

Zend引擎作为php的内核，主要的设计机制有：

### 实现Hash Table 数据结构

HashTable 是 Zend 的核心数据结构,在PHP里面几乎用来实现所有功能,PHP的数据array()就是典型的应用.此外在Zend内部,
如函数符号表、全景变量都是通过Hash Table 来实现的

Zend hash table 实现了典型的hash表散列结构，同时通过附加一个双向链表，提供了正向、反向、遍历数组的功能

### PHP变量的实现原理
PHP是一门弱类型语言，不严格区分变量的类型。PHP的变量可以分为简单类型（int、sting、bool）、集合类型（array、resource、object）
和常量（const），所有的变量在底层都是同一种结构zval


## 语法规则

mysql与mysqli的主要区别

1. 首先两个函数都是用来处理DB 的。
2. mysqli 连接是永久连接，而mysql是非永久连接。什么意思呢？ mysql连接每当第二次使用的时候，都会重新打开一个新的进程，而mysqli则只使用同一个进程，这样可以很大程度的减轻服务器端压力。
3. mysqli封装了诸如事务等一些高级操作，同时封装了DB操作过程中的很多可用的方法。应用比较多的地方是 mysqli的事务。




















































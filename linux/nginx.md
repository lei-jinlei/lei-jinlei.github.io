# Nginx

## Nginx 配置
```
user www-data;
pid /run/nginx.pid;

worker_processes 4;
worker_cpu_affinity 0001 0010 0100 1000;
worker_rlimit_nofile 65535;


events {
        use epoll;
        worker_connections 65535;
        accept_mutex off;
        multi_accept off;

}

http {

        ##
        # Basic Settings
        ##

        sendfile on;
        tcp_nopush on;
        tcp_nodelay on;
        keepalive_timeout 60 50;
        send_timeout 10s;
        types_hash_max_size 2048;
        client_header_buffer_size 4k;
        client_max_body_size 8m;

        include /etc/nginx/mime.types;
        default_type application/octet-stream;

        ##
        # Logging Settings
        ##

        access_log /var/log/nginx/access.log;
        error_log /var/log/nginx/error.log;

        ##
        # Gzip Settings
        ##

        gzip on;
        gzip_disable "msie6";
        gzip_min_length 1024;
        gzip_vary on;
        gzip_comp_level 2;
        gzip_buffers 32 4k;
        gunzip_static on;
        gzip_types text/plain text/css application/json application/x-javascript text/xml application/xml application/xml+rss text/javascript;


        ##
        # Virtual Host Configs
        ##

        include /etc/nginx/conf.d/*.conf;
        include /etc/nginx/sites-enabled/*;
}

```

#### worker_processes
worker_processes 用来设置Nginx服务的进程数, 推荐是CPU内核数或内核数的倍数,推荐使用CPU内核数

#### worker_cpu_affinity
默认情况下，Nginx的多个进程有可能跑在某一个CPU或CPU的某一核上，导致Nginx进程使用硬件的资源不均，因此绑定Nginx进程到不同的CPU上是为了充分利用硬件的多CPU多核资源的目的。

worker_cpu_affinity用来为每个进程分配CPU的工作内核，参数有多个二进制值表示，每一组代表一个进程，每组中的每一位代表该进程使用CPU的情况，1代表使用，0代表不使用。

所以我们使用worker_cpu_affinity 0001 0010 0100 1000;来让进程分别绑定不同的核上。



## Apache 和 Nginx 的区别

### Nginx
1. 轻量级,采用 C 进行编写,同样的web服务,会占用更少的内存及资源
2. 抗并发, nginx 以 epoll and kqueue 作为开发模型, 处理请求是异步非阻塞的, 负载能力比Apache高很多
而Apache则是阻塞型的.在高并发下 nginx 能保持低资源低消耗高性能, 而Apache 在 php 处理慢或者前端压力很大
的情况下, 很容易出现进程飙升, 从而拒绝服务的现象
3. nginx处理静文件好, 静态处理性能比 Apache 高三倍以上
4. nginx 的设计高度模块化, 编写模块相对简单
5. nginx 配置简洁, 正则配置让很多事情变得简单,而且改完配置能使用 -t 测试配置有没有问题.Apache配置复杂
重启的时候发现配置出错了,会很崩溃
6. nginx 作为负载均衡服务器,支持7层负载均衡
7. nginx本身就是一个反向代理服务器,而且可以作为非常优秀的邮件代理服务器
8. 启动特别容易,并且几乎可以做到7*24不间断运行,即使运行数个月也不需要重新启动,还能够不间断服务的情况下进行软件版本的升级
9. 社区活跃,各种高性能模块出品迅速

### Apache
1. Apache 的 rewrite 比 nginx 强大, 在 rewrite 频繁的情况下, 用Apache
2. Apache 发展到现在, 模块超多,基本想到的都可以找到
3. Apache 更为稳定, 少bug, nginx 的 bug 相对较多
4. Apache 超稳定
5. Apache 对 php 的支持比较简单, nginx 在这方面是鸡肋
6. Apache 在处理动态请求有优势, nginx在这方面是鸡肋, 一般动态请求要Apache去做，nginx 适合静态和反向。
7. Apache 仍然是目前的主流，拥有丰富的特性，成熟的技术和开发社区

总结:
    
- 两者最核心的区别在于 Apache 是同步多进程模型, 一个连接对应一个进程, 而 nginx 是异步的，多个连接（万级别）可以对应一个进程
- 更为通用的方案是，前端 nginx 抗并发，后端 apache 集群，配合起来会更好。

### nginx的负载均衡实现方式

    1.轮询
    2.用户IP哈希
    3.指定权重
    4.fair(第三方)
    5.url_hash(第三方)





























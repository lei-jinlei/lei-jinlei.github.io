# supervisor

>使用supervisor实现守护进程
	
	守护进程，就是一直运行的收存周期很长的进程，使用supervisor可以实现这样的进程，
	该进程并且会在被杀掉的时候再次重启
	
>安装supervisor

    yum install supervisor

在配置文件(/etc/supervisord.conf)配置一下:

```
//program:nodejsblog  这里:后面的是个名字,可以随便起
//command= 这里是要执行的命令
//user= 这里是执行用户


[program:nodejsblog]
command=/usr/bin/nodejs /var/www/html/nblog index.js
user=root
```

开启 

    supervisord -c /etc/supervisord.conf

此时nodeJS的守护进程也会随着启动了，可以使用PS命令去看一下，并且在你kill该进程的时候，会自动重启

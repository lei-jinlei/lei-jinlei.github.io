# Linux

Linux硬链接和软链接有什么区别

    1.硬链接不可以跨分区，软件链可以跨分区
    2.硬链接指向一个i节点，而软链接则是创建一个新的i节点
    3.删除硬链接、软链接文件，对源文件都没有什么影响，但是如果删除原文件，会导致软链接失效，硬链接无影响

建立软链接，以及硬链接的命令

    软链接：ln -s slink source
    硬链接：ln link source

怎么利用ps查看指定进程的信息

    ps -ef|grep pid

Linux下命令有哪几种可使用的通配符？分别代表什么含义

    "?"可替代单个字符
    "*"可替代任意多个字符
    中括号“[charset]”可替代 charset 集中的任何单个字符，如[a-z]，[abABC]


查看系统当前进程连接数？

    netstat -an | grep ESTABLISHED | wc -l

查看当前进程

    ps a

如何修改文件为当前用户只读#

    chmod u=r 文件名

Linux 进程属性

    1.进程：是用pid表示，它的数值是唯一的
    2.父进程：用ppid表示
    3.启动进程的用户：用UID表示
    4.启动进程的用户所属的组：用GID表示
    5.进程的状态：运行R，就绪W，休眠S，僵尸Z

nginx的负载均衡实现方式

    1.轮询
    2.用户IP哈希
    3.指定权重
    4.fair(第三方)
    5.url_hash(第三方)

    
## 常用操作以及概念
快捷键
- Tab: 命令和文件名补全
- Ctrl+c: 中断正在运行的程序
- Ctrl+d: 结束键盘输入

求助

--help

指令的基本用法与选项介绍。

man

man 是 manual 的缩写，将指令的具体信息显示出来。

当执行man date时，有 DATE(1) 出现，其中的数字代表指令的类型，常用的数字及其类型如下：

| 代号 | 类型 |
| :---: | :---: |
| 1 | 用户在 shell 环境中可以操作的指令或者可执行文件|
| 5 | 配置文件 | 
| 8 | 系统管理员可以使用的管理指令 | 


info

info 与 man 类似，但是 info 将文档分成一个个页面，每个页面可以进行跳转。

doc

/usr/share/doc 存放着软件的一整套说明文件。

sudo

sudo 允许一般用户使用 root 可执行的命令，不过只有在 /etc/sudoers 配置文件中添加的用户才能使用该指令。

### 包管理工具

RPM 和 DPKG 为最常见的两类软件包管理工具：

RPM 全称为 Redhat Package Manager，最早由 Red Hat 公司制定实施，随后被 GNU 开源操作系统接受并成为很多 Linux 系统 (RHEL) 的既定软件标准。
与 RPM 进行竞争的是基于 Debian 操作系统 (Ubuntu) 的 DEB 软件包管理工具 DPKG，全称为 Debian Package，功能方面与 RPM 相似。
YUM 基于 RPM，具有依赖管理功能，并具有软件升级的功能。

### 文件与目录的基本操作
ls

列出文件或者目录的信息,目录的信息就是其中包含的文件
    
    # ls [-aAdfFhilnrRSt] file|dir
    -a ：列出全部的文件
    -d ：仅列出目录本身
    -l ：以长数据串行列出，包含文件的属性与权限等等数据

cd

更换当前目录

    cd [相对路径或绝对路径]
    
mkdir

创建目录

    # mkdir [-mp] 目录名称
    -m ：配置目录权限
    -p ：递归创建目录
    
touch

更新文件时间或者建立新文件。
    
    # touch [-acdmt] filename
    -a ： 更新 atime
    -c ： 更新 ctime，若该文件不存在则不建立新文件
    -m ： 更新 mtime
    -d ： 后面可以接更新日期而不使用当前日期，也可以使用 --date="日期或时间"
    -t ： 后面可以接更新时间而不使用当前时间，格式为[YYYYMMDDhhmm]
    
rm

删除文件

    # rm [-fir] 文件或目录
    -r ：递归删除
    
mv

移动文件

    # mv [-fiu] source destination
    # mv [options] source1 source2 source3 .... directory
    -f ： force 强制的意思，如果目标文件已经存在，不会询问而直接覆盖
    

修改权限

可以将一组权限用数字来表示，此时一组权限的 3 个位当做二进制数字的位，从左到右每个位的权值为 4、2、1，即每个权限对应的数字权值为 r : 4、w : 2、x : 1。

    # chmod [-R] xyz dirname/filename
示例：将 .bashrc 文件的权限修改为 -rwxr-xr--。

    # chmod 754 .bashrc
也可以使用符号来设定权限。

    # chmod [ugoa]  [+-=] [rwx] dirname/filename
    - u：拥有者
    - g：所属群组
    - o：其他人
    - a：所有人
    - +：添加权限
    - -：移除权限
    - =：设定权限
示例：为 .bashrc 文件的所有用户添加写权限。

    # chmod a+w .bashrc

#### 文件默认权限

- 文件默认权限：文件默认没有可执行权限，因此为 666，也就是 -rw-rw-rw- 。
- 目录默认权限：目录必须要能够进入，也就是必须拥有可执行权限，因此为 777 ，也就是 drwxrwxrwx。

可以通过 umask 设置或者查看文件的默认权限，通常以掩码的形式来表示，例如 002 表示其它用户的权限去除了一个 2 的权限，也就是写权限，因此建立新文件时默认的权限为 -rw-rw-r--。


### 获取文件内容

cat

获取文件内容

    # cat [-AbEnTv] filename
    -n ：打印出行号，连同空白行也会有行号，-b 不会
    
tac

是 cat 的反向操作, 从最后一行开始打印

more

和 cat 不同的是它可以一页一页查看文件内容, 比较适合大文件的查看

less

和more类似, 但是多了一个向前翻页的功能

head

取得文件前几行

    # head [-n number] filename
    -n ：后面接数字，代表显示几行的意思
    
tail

是 head 的反向操作, 只是取得是后几行

od
 
以字符或者十六进制的形式显示二进制文件

#### 指令和文件搜索

which

指令搜索
    
    # which [-a] command
    -a ：将所有指令列出，而不是只列第一个
    
whereis

文件搜索 速度比较快 因为它只搜索几个特定的目录

    whereis [-bmsu] dirname/filename
    
locate

文件搜索 可以用关键字或者正则表达式进行搜索

locate 使用 /var/lib/mlocate/ 这个数据库来进行搜索，它存储在内存中，并且每天更新一次，所以无法用 locate 搜索新建的文件。可以使用 updatedb 来立即更新数据库。

    # locate [-ir] keyword
    -r：正则表达式
    
find

文件搜索 可以使用文件的属性和权限进行搜索

    # find [basedir] [option]
    example: find . -name "shadow*"
    
与时间有关的选项

    -mtime  n ：列出在 n 天前的那一天修改过内容的文件
    -mtime +n ：列出在 n 天之前 (不含 n 天本身) 修改过内容的文件
    -mtime -n ：列出在 n 天之内 (含 n 天本身) 修改过内容的文件
    -newer file ： 列出比 file 更新的文件
    
 与文件拥有者和所属群组有关的选项

    -uid n
    -gid n
    -user name
    -group name
    -nouser ：搜索拥有者不存在 /etc/passwd 的文件
    -nogroup：搜索所属群组不存在于 /etc/group 的文件

与文件权限和名称有关的选项

    -name filename
    -size [+-]SIZE：搜寻比 SIZE 还要大 (+) 或小 (-) 的文件。这个 SIZE 的规格有：c: 代表 byte，k: 代表 1024bytes。所以，要找比 50KB 还要大的文件，就是 -size +50k
    -type TYPE
    -perm mode  ：搜索权限等于 mode 的文件
    -perm -mode ：搜索权限包含 mode 的文件
    -perm /mode ：搜索权限包含任一 mode 的文件


### 压缩与打包

Linux 底下有很多压缩文件名，常见的如下：

| 扩展名 | 压缩程序 |
| :---: | :---: |
| *.Z | compress |
| *.zip |	zip |
| *.gz |	gzip |
| *.bz2 |	bzip2 |
| *.xz |	xz |
| *.tar |	tar 程序打包的数据，没有经过压缩 |
| *.tar.gz |	tar 程序打包的文件，经过 gzip 的压缩 |
| *.tar.bz2 |	tar 程序打包的文件，经过 bzip2 的压缩 |
| *.tar.xz |	tar 程序打包的文件，经过 xz 的压缩 |










































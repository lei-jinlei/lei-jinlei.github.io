# 进程管理

## 进程与线程
#### 进程
进程是资源分配的基本单位

进程控制块(Process Control Block, PCB)描述进程的基本信息和运行状态，所谓的创建进程和撤销进程，都是指对 PCB 的操作

#### 线程
线程是独立调度的基本单位

一个进程可以有多个线程，它们共享进程资源

QQ和浏览器是两个进程，浏览器进程里面有很多线程，例如 HTTP 请求线程、事件响应线程、渲染线程等等，线程的并发执行使得在浏览器中点击一个新链接从而发起 HTTP 请求时，浏览器还可以响应用户的其他事件

#### 区别
1. 拥有资源

    进程是资源分配的基本单位，但线程不拥有资源，线程可以访问隶属进程的资源

2. 调度

    线程是独立调度的基本单位，在同一个进程中线程的切换不会引起进程切换，从一个进程的线程切换到另一个进程的线程时，会引起进程切换

3. 系统开销
    
    由于创建或撤销进程时，系统都要为之分配或回收资源，如内存空间、I/O 设备等，所付出的开销远大于创建或撤销线程时的开销。类似地，在进行进程切换时，涉及当前执行进程 CPU 环境的保存及新调度进程 CPU 环境的设置，而线程切换只需保存和设置少量寄存器内容，开销很小
    
4. 通信方面

    线程间可以通过直接读写同一进程中的数据进行通信，但是进程通信需要借助 IPC
    
## 进程状态的切换
- 就绪状态(ready)：等待被调度
- 运行状态(running)
- 阻塞状态(waiting)：等待资源

应该注意以下内容：
    
- 只有在就绪态和运行态可以相互转换，其他的都是单向转换。就绪状态的进程通过调度算法从而获得 CPU 时间，转为运行状态；而运行状态的进程，在分配给它的 CPU 时间片用完之后就会转为就绪状态，等待下一次调度

- 阻塞状态是缺少需要的资源从而由运行状态转换而来，但是该资源不包括 CPU 时间，缺少 CPU 时间会从运行状态转换为就绪态。

## 进程调度算法

不同环境的调度算法目标不同，因此需要针对不同环境来讨论调度算法

### 批处理系统

批处理系统没有太多的用户操作，在该系统中，调度算法目标是保证吞吐量和周转时间（从提交到终止的时间）

#### 先来先服务

按照请求的顺序进行调度

有利于长作业，但不利于短作业，因为短作业必须一直等待前面的长作业执行完毕才能执行，而长作业又需要执行很长时间，造成了短作业等待时间过长

#### 短作业优先

按估计运行时间最短的顺序进行调度

长作业有可能会被饿死，处于一直等待短作业执行完毕的状态。因为如果一直有短作业到来，那么长作业永远得不到调度

#### 最短剩余时间优先

按估计剩余时间最短的顺序进行调度

### 交互式系统
交互式系统有大量的用户交互操作，在该系统中调度算法的目标是快速地进行响应

#### 时间片轮转
将所有就绪进程按 FCFS 的原则排成一个队列，每次调度时，把 CPU 时间分配给对首进程，该进程可以执行一个时间片。当时间片用完时，由计时器发出时钟中断，调度程序便停止该进程的执行，并将它送往就绪队列的末尾，同时继续把 CPU 时间分配给队首的进程

时间片轮转算法的效率和时间片的大小有很大关系：
- 因为进程切换都要保存进程的信息并且载入新进程的信息，如果时间片太小，会导致进程切换得太频繁，在进程切换上就会花过多时间
- 而如果时间片过长，那么实时性就不能得到保证

#### 优先级调度
为每个进程分配一个优先级，按优先级进行调度

为了防止低优先级的进程永远等不到调度，可以随着时间的推移增加等待进程的优先级

#### 多级反馈队列
一个进程需要执行 100 个时间片，如果采用时间片轮转调度算法，那么需要交换 100 次

多级队列是为这种需要连续执行多个时间片的进程考虑，它设置了多个队列，每个队列时间片大小都不同，例如：1,2,4,8... 进程在第一个队列没执行完，就会被移到下一个队列。这种方式下，之前的进程只需要交换7次

每个队列优先权也不同，最上面的优先权最高。因此只有上一个队列没有进程在排队，才能调度当前队列上的进程

可以将这种调度算法看成是时间片轮转调度算法和优先级调度算法的结合

## 进程同步

#### 临界区
对临界资源进行访问的那段代码称为临界区

为了互斥访问临界资源，每个进程在进入临界区之前，需要先进行检查

#### 同步与互斥
- 同步：多个进程按一定顺序执行；
- 互斥：多个进程在同一时刻只有一个进程能进入临界区

#### 信号量
信号量是一个整型变量，可以对其执行 down 和 up 操作，也就是常见的 p 和 v 操作

- down：如果信号量大于0，执行 -1 操作；如果信号量等于 0，进程睡眠，等待信号量大于0；
- up：对信号量执行 +1 操作，唤醒睡眠的进程让其完成 down 操作

down 和 up 操作需要被设计成原语，不可分割，通常的做法是在执行这些操作的时候屏蔽中断

如果信号量的取值只能为 0 或者 1，那么就成为了互斥量，0 表示临界区已经加锁，1 表示临界区解锁

```
typedef int semaphore;
semaphore mutex = 1;
void P1() {
    down(&mutex);
    // 临界区
    up(&mutex);
}

void P2() {
    down(&mutex);
    // 临界区
    up(&mutex);
}

```
##### 使用信号量实现生产者-消费者问题
问题描述：使用一个缓冲区来保存物品，只有缓冲区没有满，生产者才可以放入物品；只有缓冲区不为空，消费者才能拿走物品

因为缓冲区属于临界资源，因此需要使用一个互斥量 mutex 来控制对缓冲区的互斥访问

为了同步生产者和消费者的行为，需要记录缓冲区物品的数量。数量可以使用信号量来进行统计，这里需要使用两个信号量：empty 记录空缓冲去的数量，full 记录满缓冲区的数量
其中，empty 信号量是在生产者进程中使用，当 empty 不为 0 时，生产者才可以放入物品；full信号量是在消费者进程中使用，当 full 信号量不为 0 时，消费者才可以取走物品

注意，不能先对缓冲区进行加锁，再测试信号量。也就是说，不能先执行 down(mutex) 再执行(empty)。如果这么做了，那么可能会出现这种情况：生产者对缓冲区加锁后，执行 down(empty) 操作，
发现empty = 0，此时生产者睡眠。消费者不能进入临界区，因为生产者对缓冲区加锁了，消费者就无法执行 up(empty) 操作，empty 永远为 0，导致生产者永远等待下，不会释放锁，消费者因此也会永远等待下去

```
#define N 100
typedef int semaphore;
semaphore mutex = 1;
semaphore empty = N;
semaphore full = 0;

void producer() {
    while(TRUE) {
        int item = produce_item();
        down(&empty);
        down(&mutex);
        insert_item(item);
        up(&mutex);
        up(&full);
    }
}

void consumer() {
    while(TRUE) {
        down(&full);
        down(&mutex);
        int item = remove_item();
        consume_item(item);
        up(&mutex);
        up(&empty);
    }
}

```

#### 管程
使用信号量制实现的生产者消费者问题需要客户端代码做很多控制，而管程把控制的代码独立出来，不仅不容易出错，也使得客户端代码调用更容易

c 语言不支持管程，下面的示例代码使用了类 Pascal 语言来描述管程。示例代码的管程提供了 insert() 和 remove() 方法，
客户端代码通过调用这两个方法来解决生产者-消费者问题

```
monitor ProducerConsumer
    integer i;
    condition c;

    procedure insert();
    begin
        // ...
    end;

    procedure remove();
    begin
        // ...
    end;
end monitor;
```
管程有一个重要特性：在一个时刻只能有一个进程使用管程。进程在无法继续执行的时候不能一直占用管程，否则其他进程永远不能使用管程

管程引入了条件变量 以及相关的操作：wait() 和 signal() 来实现同步操作。对条件变量执行 wait() 操作会导致调用进程阻塞，
把管程让出来给另一个进程持有，signal()操作用于唤醒被阻塞的进程

##### 使用管程实现生产者-消费者问题 
```
// 管程
monitor ProducerConsumer
    condition full, empty;
    integer count := 0;
    condition c;

    procedure insert(item: integer);
    begin
        if count = N then wait(full);
        insert_item(item);
        count := count + 1;
        if count = 1 then signal(empty);
    end;

    function remove: integer;
    begin
        if count = 0 then wait(empty);
        remove = remove_item;
        count := count - 1;
        if count = N -1 then signal(full);
    end;
end monitor;

// 生产者客户端
procedure producer
begin
    while true do
    begin
        item = produce_item;
        ProducerConsumer.insert(item);
    end
end;

// 消费者客户端
procedure consumer
begin
    while true do
    begin
        item = ProducerConsumer.remove;
        consume_item(item);
    end
end;

```

## 经典同步问题
生产者和消费者问题前面已经讨论过了

### 1. 读者-写者问题
允许多个进程同时对数据进行读操作，但是不允许读和写以及写和写操作同时发生

一个整型变量 count 记录在对数据进行读操作的进程数量，一个互斥量 count_mutex 用于对 count 加锁，一个互斥量 data_mutex 用于对读写的数据加锁

```
typedef int semaphore;
semaphore count_mutex = 1;
semaphore data_mutex = 1;
int count = 0;

void reader() {
    while(TRUE) {
        down(&count_mutex);
        count++;
        if(count == 1) down(&data_mutex); // 第一个读者需要对数据进行加锁，防止写进程访问
        up(&count_mutex);
        read();
        down(&count_mutex);
        count--;
        if(count == 0) up(&data_mutex);
        up(&count_mutex);
    }
}

void writer() {
    while(TRUE) {
        down(&data_mutex);
        write();
        up(&data_mutex);
    }
}

```

















































































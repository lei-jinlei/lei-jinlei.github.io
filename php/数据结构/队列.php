<?php

class Node
{
    public $data;
    public $next;

    public function __construct($data, $next = null)
    {
        $this->data = $data;
        $this->next = $next;
    }
}

class Queue
{
    public $front = null;
    public $rear = null;

    public $size = 0;

    public function __construct()
    {
    }

    public function push($data)
    {
        $node = new Node($data);
        if ($this->front == null && $this->rear == null) {
            $this->front = $node;
            $this->rear = $node;
        } else {
            $this->rear->next = $node;
            $this->rear = $node;
        }
        $this->size++;
    }

    public function shift()
    {
        if ($this->front) {
            $this->size--;
            $data = $this->front->data;
            $this->front = $this->front->next;
            return $data;
        } else {
            return null;
        }
    }
}

// $s = new Queue();
// $s->push("aaaa");
// $s->push("bb");
// $s->push("cc");
// $s->push("dd");
// $s->push("fifo");

// // echo $s->shift();

// while($data = $s->shift()){
//  echo $data."<br>";
// }

//数组实现队列
// $arr = [];
// array_push($arr,"张三");
// array_push($arr,"李四");
// array_push($arr,"王五");
// array_push($arr,"王六");

// while($data  = array_shift($arr)){
//  echo $data."<br>";
// }


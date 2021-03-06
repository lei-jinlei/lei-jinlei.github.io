<?php

class Node
{
    public $data = null;
    public $next = null;
    public function __construct($data, $next = null)
    {
        $this->data = $data;
        $this->next = $next;
    }
}

class singleLinkList
{
    private $header = null;
    private $last = null;
    public $size = 0;

    public function __construct()
    {
    }

    public function add($data)
    {
        $node = new Node($data);
        if ($this->head == null && $this->last == null) {
            $this->head = $node;
            $this->last = $node;
        } else {
            $this->last->next = $node;
            $this->last = $node;
        }
    }

    public function del($data)
    {
        $node = $this->header;
        if ($node->data == $data) {
            $this->header = $this->head->next;
            return true;
        } else {
            while($node->next->data == $data) {
                $node->next = $node->next->next;
                return true;
            }
        }
        return false;
    }

    public function update($old, $new)
    {
        $node = $this->header;
        while($node->next != null) {
            if ($node->data == $old) {
                $node->data = $new;
                return true;
            }
            $node = $node->next;
        }
        echo 'not found!';
        return false;
    }

    public function find($data)
    {
        $node = $this->header;
        if ($node->data == $data) {
            echo 'found';
            return true;
        }
        while($node->next != null) {
            if ($node->data == $data) {
                echo 'found';
                return true;
            }
            $node = $node->next;
        }
        echo 'not found';
        return false;
    }

    public function getAll()
    {
        $node = $this->header;
        while($node->next != null) {
            echo $node->data;
            $node = $node->next;
        }
        echo $node->data;
    }
}


$list =  new singleLinkList();
$list->add("1");
$list->add("2");
$list->add("3");
$list->add("4");
$list->add("5");
$list->add("6");
echo "<pre>";
// $list->getAll();

// if($list->del("2")){
//  echo "success";
// }else{
//  echo "false";
// }

// if($list->update("3","7")){
//  var_dump($list);
// }

$list->find(7);
// $list->getAll();

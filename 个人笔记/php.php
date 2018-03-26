<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/3/23
 * Time: 14:39
 */

/**
 * 冒泡排序
 * @param $arr
 * @return bool
 */
function bubble_sort($arr)
{
    $count = count($arr);
    if ($count == 0){
        return false;
    }

    for ($i = 0; $i < $count; $i++){
        for ($j = 0; $j < $count-1-$i; $j++){
            if ($arr[$j] > $arr[$j+1]){
                $temp = $arr[$j];
                $arr[$j] = $arr[$j+1];
                $arr[$j+1] = $temp;
            }
        }
    }
    return $temp;
}

/**
 * 反转数组
 * @param array $arr
 * @return array
 */
function reverse($arr)
{
    $n = count($arr);

    $left = 0;
    $right = $n - 1;

    while ($left < $right) {
        $temp = $arr[$left];
        $arr[$left++] = $arr[right];
        $arr[$right--] = $temp;
    }
    return $arr;
}

/**
 * 获取大王
 * @param int $n
 * @param int $m
 * @return int
 */
function get_king_money($n, $m)
{
    $arr = range(1, $n);
    $i = 0;

    while (count($arr) > 1) {
        $i++;
        $survice = array_shift($arr);

        if ($i % $m != 0){
            array_push($arr, $survice);
        }
    }

    return $arr[0];
}

function write($str)
{
    $fp = fopen($str, 'a');

    do{
        usleep(100);
    } while (!flock($fp, LOCK_EX));
    fwrite($fp, $str, PHP_EOL);
    flock($fp, LOCK_UN);
    fclose($fp);
}

function check_ip($ip)
{
    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        return false;
    } else {
        return true;
    }
}


// 设计一个秒杀系统
$ttl = 4;
$random = mt_rand(1, 1000) . '-' . gettimeofday(true) . '-' . mt_rand(1, 1000);

$lock = false;
while (!$lock){
    $lock = $redis->set('lock', $random, array('nx', 'ex' => $ttl));
}

if ($redis->get('goods.num') <= 0) {
    echo ("秒杀已经结束");
    // 删除锁
    if ($redis->get('lock') == $random) {
        $redis->del('lock');
    }
    return false;
}

$redis->decr('goods.num');
echo ("秒杀成功");
// 删除锁
if ($redis->get('lock') == $random) {
    $redis->del('lock');
}
return true;
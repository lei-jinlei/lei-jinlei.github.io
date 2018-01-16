<?php

/**
 * 生成不重复的随机数
 * @param  integer $start  需要生成的数字开始范围
 * @param  integer $end    结束范围
 * @param  integer $length 需要生成的随机数个数
 * @return array          生成的随机数
 */
function get_rand_number($start=1, $end=10, $length=4)
{
    $connt = 0;
    $temp = array();
    while ($connt<$length) {
        $temp[] = rand($start, $end);
        $data = array_unique($temp);
        $connt = count($data);
    }
    sort($data);
    return $data;
}

/**
 * 将字符串分隔为数组
 * @param  string $str 字符串
 * @return array      分隔得到的数组
 */
function mb_str_split($str)
{
    return preg_split('/(?<!^)(?!$)/u', $str);
}

// 验证emil
filter_var($email,FILTER_VALIDATE_EMAIL);
// 验证url
filter_var($url,FILTER_VALIDATE_URL);

/**
 * 创建多级目录
 * @param  [type]  $path 要创建的目录
 * @param  integer $mode 创建目录的模式，在Windows下省略
 * @return [type]        是否成功
 */
function create_dir($path, $mode = 0777)
{
    if (is_dir($path)) {
        # 如果目录已经存在，则不创建
        echo '该目录已经存在';
    } else {
        # 不存在，创建
        if (mkdir($path, $model, true)) {
            echo '创建成功';
        } else {
            echo '创建失败';
        }
    }
}


// php用preg_match来匹配并判断一个字符串中是否含有中文或者都是中文的方法
function is_chinese_str($str)
{
    if (preg_match('/[\x7f-\xff]/', $str)) {
        echo '字符串中有中文';
    } else {
        echo '字符串中没有中文';
    }
}

// 确保多个进程同时写入同一个文件成功
$fp = fopen('lock.txt', "w+");
if (flock($fp, LOCK_EX)) {
    // 获得写锁，写数据
    fwrite($fp, "write something");
    // 解除锁定
    flock($fp, LOCK_UN);
} else {
    echo 'file is locking...';
}
fclose($fp);

// 取出url扩展名
function getExt($url)
{
    $arr = parse_url($url);
    $file = basename($arr['path']);
    $ext = explode('.', $file);
    return $ext[count($ext)-1];
}

// 取出url扩展名
function getExt_2($url)
{
    $url = basename($url);
    $pos1 = strpos($url, '.');
    $pos2 = strpos($url, '?');
    if (strstr($url, '?')) {
        return substr($url, $pos1+1, $pos2-$pos1-1);
    } else {
        return substr($url, $pos1);
    }
}

// 遍历一个文件夹下的所有文件和子文件夹
function my_scandir($dir)
{
    $files = array();
    if (is_dir($dir)) {
        if ($handle = opendir($dir)) {
            while (($file = readdir($handle)) !== false) {
                if ($file != "." && $file != "..") {
                    if (is_dir($dir . '/' . $file)) {
                        $files[$file] = my_scandir($dir . '/'. $file);
                    } else {
                        $files[] = $dir . '/'. $file;
                    }
                }
            }
            closedir($handle);
            return $files;
        }
    }
}

// 判断一个字符串是否为utf-8格式
if (mb_detect_encoding($str, 'UTF-8', true)) {
    // 是UTF-8格式的字符
}

// 获取上个月的最后一天
date_default_timezone_set('PRC');// 设置时区
//方法一
$times = date('d') * 24 * 3600;
echo date('Y-m-d H:i:s', time() - $times);
echo '<br/>';
// 方法二
$day = date('d');
echo date('Y-m-d H:i:s', strtotime(-$day.'day'));
echo '<br/>';
// 方法三
echo date('Y-m-d H:i:s',strtotime("last day of last month"));















//

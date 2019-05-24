<?php

require_once dirname(__FILE__) . '/_init.php';

$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';  //IP
$signature = isset($_SERVER['HTTP_X_GOGS_SIGNATURE']) ? $_SERVER['HTTP_X_GOGS_SIGNATURE'] : '';  //签名
$event = isset($_SERVER['HTTP_X_GOGS_EVENT']) ? $_SERVER['HTTP_X_GOGS_EVENT'] : '';  //事件

if (empty($ip) || empty($signature) || empty($event)) {
    echo 'error 403';
    exit();
}

$Log::INFO("========================================webhook start========================================");

//获取json数据
$json_data = file_get_contents("php://input");
$data = json_decode($json_data, true);

if (empty($data)) {
    $Log::ERROR('无效数据');
    exit();
}

$branch = @end(explode("/", $data['ref']));  //分支
$repository_url = $data['repository']['ssh_url'];  //版本库地址(ssh_url)

$Log::INFO('地址: ' . $repository_url . ', 分支: ' . $branch . ', 事件: ' . $event);
$Log::INFO("RAW DATA: \r\n" . var_export($data, true));

//验证签名
$re_sign = hash_hmac('sha256', $json_data, SECRET);
if ($re_sign != $signature) {
    $Log::ERROR('signature签名错误');
    exit();
}

if (!empty($ip_arr) && (empty($ip) || !in_array($ip, $ip_arr))) {
    $Log::ERROR('不合法IP');
    exit();
}

if (strtolower($event) != 'push') {
    $Log::INFO('非push操作');
    exit();
}

$job_key = $repository_url . '=>' . $branch;
if (!isset($job_repository[$repository_url]) || $job_repository[$repository_url]['branch'] != $branch) {
    $Log::ERROR($job_key . ' 任务不存在');
    exit();
}

$filename = toCamelCase($data['repository']['name']) . toCamelCase($job_repository[$repository_url]['branch']);
$jobfile = JOB_DIR . '/' . $filename . '.php';
if (!is_file($jobfile)) {
    $filename = 'JobBase';
}


$Log::INFO('执行开始');
try {
    $nn = "\\webhook\\jobs\\" . $filename;
    $Job = new $nn($job_repository[$repository_url]['branch'], $job_repository[$repository_url]['wwwroot']);
    $res = $Job->execJob();
    if (!empty($res)) {
        $res_info = "执行结果: \r\n" . implode("\r\n", $res);
        $Log::INFO($res_info);
    } else {
        $Log::INFO('执行结果: 无效执行');
    }
} catch (\webhook\jobs\exception\JobException $e) {
    $Log::ERROR($e->getMessage());
}
$Log::INFO('执行结束');

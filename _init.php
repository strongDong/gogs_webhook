<?php

error_reporting(0);
ini_set('display_errors', 0);
set_time_limit(0);
ini_set('memory_limit', '512M');

//定义部署脚本路径
define('ROOT_DIR', dirname(__FILE__));
define('JOB_DIR', ROOT_DIR . '/jobs');
define('LOG_DIR', ROOT_DIR . '/logs');

//注册自动加载
require_once ROOT_DIR . '/lib/Loader.php';
spl_autoload_register('Loader::autoload');

//加载Log
include_once ROOT_DIR . '/lib/log.php';
$log_file = LOG_DIR . '/' . date('Y-m-d') . '.log';
$log_handler = new CLogFileHandler($log_file);
$Log = Log::init($log_handler);

//加载job_repository配置
require_once ROOT_DIR . '/job_config.php';

//秘钥（项目添加webhook时填写的秘钥文本，添加webhook必须是gogs类型）
define('SECRET', '');

//合法IP（不添加则不验证）
$ip_arr = array('');

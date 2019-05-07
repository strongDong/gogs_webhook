<?php

/******************************repository config start ****************************************/
//只对下边列出的git版本库以及指定分支生效
//格式: '版本库=>分支名' => '部署用的脚本名'（版本库地址填写 ssh_url）
$job_repository = array(
    'git@github.com:strongDong/gogs_webhook.git=>refs/heads/master' => 'GogsWebhookMaster',
);

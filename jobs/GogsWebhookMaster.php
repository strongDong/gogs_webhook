<?php

namespace webhook\jobs;

use \webhook\jobs\JobBase;
use \webhook\jobs\exception\JobException;

class GogsWebhookMaster extends JobBase
{

    protected $wwwroot = '/www/gogs_webhook';    //程序部署目录，必填
    protected $branch = 'master';    //需要更新的分支，必填

    /**
     * pull完的回调
     * */

    protected function execCallback()
    {
        
    }

}

<?php

namespace webhook\jobs;

use \webhook\jobs\exception\JobException;

class JobBase
{

    protected $wwwroot;
    protected $branch;

    public function __construct()
    {
        
    }

    public function execJob()
    {
        if (empty($this->wwwroot)) {
            throw new JobException('wwwroot未定义');
        }

        if (empty($this->branch)) {
            throw new JobException('branch未定义');
        }

        if (!file_exists($this->wwwroot)) {
            throw new JobException('wwwroot目录不存在');
        }

        $git_dir = rtrim($this->wwwroot, '/') . '/.git';
        if (!file_exists($git_dir)) {
            throw new JobException('版本库未初始化');
        }

        $command = "cd " . $this->wwwroot . " && git checkout " . $this->branch . " && git pull";
        exec($command, $run_log);

        $this->execCallback();

        return $run_log;
    }

    protected function execCallback()
    {
        
    }

}

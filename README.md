# gogs_webhook
gogs webhook自动拉取部署项目，可设置多个项目


需复制config.php.example为config.php，
然后配置 config.php 里的 SECRET参数，IP验证可选。
把要部署的项目按规则配置到$job_repository数组里。


如果需要回调，用项目名称+分支名称以驼峰名称方式（包括下划线）为文件名称，在jobs目录下新建一个类继承JobBase，然后重写execCallback方法即可，
DemoMaster.php.example为示例类。


完成。

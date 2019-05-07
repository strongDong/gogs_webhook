# gogs_webhook
gogs webhook自动拉取部署项目，可设置多个项目

需配置 _init.php 里的 SECRET参数，IP验证可选。
把要部署的项目按规则配置到job_config.php里。
用上一步配置的“部署用的脚本名”在jobs目录下新建一个类继承 JobBase类，配置好$wwwroot和$branch，可参看示例。

完成。
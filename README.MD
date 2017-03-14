# 这是使用Lge框架的示例项目
    1. 本项目包含多干个分站示例，包括：示例分站、管理后台、微信前台、溯源系统、管理工具、定时程序等等；
    2. 温馨提示：本项目文件容量较大，/static/plugin目录中包含若干开源项目，请根据需要打包下载特定目录内容；

## Crontab 定时任务(示例)
    ## 日常任务
    */10 * * * * cd 项目src本地路径 && php index.php --s=crontab --c=ip-updater 2>&1 &
    0    1 * * * cd 项目src本地路径 && php index.php --s=crontab --c=backupper 2>&1 &



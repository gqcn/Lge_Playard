# 这是使用Lge框架的示例项目


## Crontab 定时任务(示例)
    ## 日常任务
    */10 * * * * cd 项目src本地路径 && php index.php --s=crontab --c=ip-updater 2>&1 &
    0    1 * * * cd 项目src本地路径 && php index.php --s=crontab --c=backupper 2>&1 &



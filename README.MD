# 这是使用Lge框架的示例项目


## Crontab 定时任务(示例)
    ## 日常任务
    */10 * * * * cd 项目src本地路径 && php index.php --s=crontab --c=ip-updater 2>&1 &
    0    1 * * * cd 项目src本地路径 && php index.php --s=crontab --c=backupper 2>&1 &

    ## 数据备份(root)
    0 1  * * * mount /dev/sdb1 /media/backup/ > /media/backup/mount.log 2>&1 &
    0 2  * * * rsync -vaur --delete /home /media/backup/ > /media/backup/home_backup.log 2>&1 &
    0 2  * * * rsync -vaur --delete /etc /media/backup/ > /media/backup/etc_backup.log 2>&1 &
    0 10 * * * umount /media/backup/ > /media/backup/umount.log 2>&1 &



<?php
namespace Lge;

if (!defined('LGE')) {
	exit('Include Permission Denied!');
}

class Controller_Backupper extends Controller_Base
{
    public $logCategory = 'crontab/backupper';
    
    /**
     * 默认入口函数.
     *
     * @return void
     */
    public function index()
    {
        Logger::log('==================start===================', $this->logCategory);

        $config       = Config::getFile('backupper', true);
        $clientConfig = $config['backup_client'];
        $serverConfig = $config['backup_server'];
        $backupDir    = rtrim($clientConfig['folder'], '/');
        foreach ($serverConfig as $groupName => $backupConfig) {
            // 首先备份数据库
            if (!empty($backupConfig['data'])) {
                foreach ($backupConfig['data'] as $dataConfig) {
                    $host = $dataConfig['host'];
                    $port = $dataConfig['port'];
                    $user = $dataConfig['user'];
                    $pass = $dataConfig['pass'];
                    $dataBackupDir = "{$backupDir}/{$groupName}/{$host}/data";
                    if (!file_exists($dataBackupDir)) {
                        @mkdir($dataBackupDir, 0777, true);
                    }
                    // 执行备份
                    foreach ($dataConfig['names'] as $name => $keepDays) {
                        $date          = date('Ymd');
                        $filePath      = "{$dataBackupDir}/{$name}.{$date}.sql.bz2";
                        $filePathTemp  = "{$dataBackupDir}/{$name}.{$date}.temp.sql.bz2";
                        $localShellCmd = "mysqldump -C -h{$host} -P{$port} -u{$user} -p{$pass} {$name} | bzip2 > {$filePathTemp}";
                        Logger::log("Backing up database: {$filePath}", $this->logCategory);
                        shell_exec($localShellCmd);
                        // 判断是否备份成功(大于1K)，使用临时文件防止失败时被覆盖
                        if (filesize($filePathTemp) > 1024) {
                            copy($filePathTemp, $filePath);
                        }
                        unlink($filePathTemp);
                        if ($keepDays > 1) {
                            $this->_clearDirByKeepDays($dataBackupDir, $keepDays);
                        }
                    }
                }
            }

            // 其次增量备份项目文件
            if (!empty($backupConfig['file'])) {
                foreach ($backupConfig['file'] as $fileConfig) {
                    $fileBackupDir = "{$backupDir}/{$groupName}/{$fileConfig['host']}/file/";
                    if (!file_exists($fileBackupDir)) {
                        @mkdir($fileBackupDir, 0777, true);
                    }
                    foreach ($fileConfig['folders'] as $folderPath => $keepDays) {
                        $host = $clientConfig['host'];
                        $port = $clientConfig['port'];
                        $user = $clientConfig['user'];
                        $pass = $clientConfig['pass'];
                        $folderPath = rtrim($folderPath, '/');
                        $folderName = basename($folderPath);
                        $sshShellCmds = array(
                            array("rsync -aurvz --delete -e 'ssh -p {$port}' {$folderPath} {$user}@{$host}:{$fileBackupDir}", false, 10),
                            array("yes", true, 10),
                            array($pass, true, 3600),
                        );
                        try {
                            $ssh = new Lib_Network_Ssh($fileConfig['host'], $fileConfig['port'], $fileConfig['user'], $fileConfig['pass']);
                            $ssh->asyncCmd($sshShellCmds);
                            if ($keepDays > 0) {
                                $backupDirPath = rtrim($fileBackupDir, '/').'/'.$folderName;
                                if (file_exists($backupDirPath)) {
                                    $this->_compressBackupFileDir($backupDirPath);
                                    $this->_clearDirByKeepDays($fileBackupDir, $keepDays);
                                }
                            }
                        } catch (\Exception $e) {
                            echo $e->getMessage().PHP_EOL;
                        }
                    }
                }
            }

            echo "Done!\n\n";
        }

        Logger::log('==================end====================', $this->logCategory);
    }

    /**
     * 压缩备份的文件目录
     *
     * @param string $backupFileDirPath 文件目录绝对路径
     *
     * @return void
     */
    private function _compressBackupFileDir($backupFileDirPath)
    {
        $date    = date('Ymd');
        $dirPath = dirname($backupFileDirPath);
        $dirName = basename($backupFileDirPath);
        exec("tar -cjvf {$dirPath}/{$dirName}.{$date}.tar.bz2 {$backupFileDirPath}");
    }

    /**
     * 按照给定天数清除超过保存期限的备份文件。
     *
     * @param string  $dirPath  备份目录绝对路径
     * @param integer $keepDays 保存天数
     *
     * @return void
     */
    private function _clearDirByKeepDays($dirPath, $keepDays)
    {
        $files = array_diff(scandir($dirPath), array('..', '.'));
        // 只计算压缩文件的数量
        foreach ($files as $k => $file) {
            if (!preg_match('/.+\.bz2/', $file)) {
                unset($files[$k]);
            }
        }
        while (count($files) > $keepDays) {
            $file     = array_shift($files);
            $filePath = $dirPath.'/'.$file;
            Logger::log("Clearing expired file: {$filePath}", $this->logCategory);
            unlink($filePath);
        }
    }

}
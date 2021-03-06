<?php
/**
 * The install module English file of XiRangCSM.
 *
 * @copyright   Copyright 2009-2011 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     install
 * @version     $Id$
 * @link        http://www.zentao.net
 */
$lang->install->common  = 'Install';
$lang->install->next    = 'Next';
$lang->install->pre     = 'Back';
$lang->install->reload  = 'Reload';
$lang->install->error   = 'Error ';

$lang->install->start            = 'Start install';
$lang->install->keepInstalling   = 'Keep install this version';
$lang->install->seeLatestRelease = 'See the latest release.';
$lang->install->welcome          = 'Welcome to use XiRangCSM.';
$lang->install->desc             = <<<EOT
XiRangCSM is an content management software.

XiRangCSM is developped by PHH and mysql under the XiRangCSM framework developped by the same team. Through the framework, XiRangCSM can be customed and extended very easily.

XiRangCSM is developped by <strong class='red'><a href='http://www.cnezsoft.com' target='_blank'>Nature EasySoft Network Tecnology Co.ltd, QingDao, China</a></strong>。
The official website of XiRangCSM is <a href='http://www.zentao.net' target='_blank'>http://www.zentao.net</a>

The version of current release is <strong class='red'>%s</strong>。
EOT;
$lang->install->choice     = 'You can ';
$lang->install->checking   = 'System checking';
$lang->install->ok         = 'OK(√)';
$lang->install->fail       = 'Failed(×)';
$lang->install->loaded     = 'Loaded';
$lang->install->unloaded   = 'Not loaded';
$lang->install->exists     = 'Exists ';
$lang->install->notExists  = 'Not exists ';
$lang->install->writable   = 'Writable ';
$lang->install->notWritable= 'Not writable ';
$lang->install->phpINI     = 'PHP ini file';
$lang->install->checkItem  = 'Items';
$lang->install->current    = 'Current';
$lang->install->result     = 'Result';
$lang->install->action     = 'How to fix';

$lang->install->phpVersion = 'PHP version';
$lang->install->phpFail    = 'Must > 5.2.0';

$lang->install->pdo          = 'PDO extension';
$lang->install->pdoFail      = 'Edit the php.ini file to load PDO extsion.';
$lang->install->pdoMySQL     = 'PDO_MySQL extension';
$lang->install->pdoMySQLFail = 'Edit the php.ini file to load PDO_MySQL extsion.';
$lang->install->tmpRoot      = 'Temp directory';
$lang->install->dataRoot     = 'Upload directory.';
$lang->install->mkdir        = '<p>Should creat the directory %s。<br /> Under linux, can try<br /> mkdir -p %s</p>';
$lang->install->chmod        = 'Should change the permission of "%s".<br />Under linux, can try<br />chmod o=rwx -R %s';

$lang->install->settingDB    = 'Set database';
$lang->install->webRoot      = 'XiRangCSM path';
$lang->install->requestType  = 'URL type';
$lang->install->requestTypes['GET']       = 'GET';
$lang->install->requestTypes['PATH_INFO'] = 'PATH_INFO';
$lang->install->dbHost     = 'Database host';
$lang->install->dbHostNote = 'If localhost can connect, try 127.0.0.1';
$lang->install->dbPort     = 'Host port';
$lang->install->dbUser     = 'Database user';
$lang->install->dbPassword = 'Database password';
$lang->install->dbName     = 'Database name';
$lang->install->dbPrefix   = 'Table prefix';
$lang->install->createDB   = 'Auto create database';
$lang->install->clearDB    = 'Clear data if database exists.';

$lang->install->errorConnectDB     = 'Database connect failed.';
$lang->install->errorCreateDB      = 'Database create failed.';
$lang->install->errorDBExists      = 'Database alread exists, to continue install, check the clear db box.';
$lang->install->errorCreateTable   = 'Table create failed.';
$lang->install->errorGrantPriv     = 'Grant privilieg failed';

$lang->install->setConfig  = 'Create config file';
$lang->install->key        = 'Item';
$lang->install->value      = 'Value';
$lang->install->saveConfig = 'Save config';
$lang->install->save2File  = '<div class="a-center"><span class="fail">Try to save the config auto, but failed.</span></div>Copy the text of the textareaand save to "<strong> %s </strong>".';
$lang->install->saved2File = 'The config file has saved to "<strong>%s</strong> ".';
$lang->install->errorNotSaveConfig = 'Not save config file.';

$lang->install->getPriv  = 'Set admin';
$lang->install->company  = 'Company name';
$lang->install->account  = 'Administrator';
$lang->install->password = 'Admin password';
$lang->install->errorEmptyPassword = "Can't be empty";

$lang->install->success    = "Success installed";
$lang->install->saveAdmin  = "Save theese two lines to config/my.php";
$lang->install->visitFront = 'Visit front';
$lang->install->visitAdmin = 'Visit admin';

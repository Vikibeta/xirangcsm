<?php
/**
 * The upgrade router file of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2013 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     ZenTaoPMS
 * @version     $Id: upgrade.php 4131 2013-01-18 02:24:44Z wwccss $
 * @link        http://www.zentao.net
 */
/* Judge my.php exists or not. */
$myConfig = dirname(dirname(__FILE__)) . '/config/my.php';
if(!file_exists($myConfig))
{
    echo "文件" . $myConfig . "不存在！ 提示：不要重命名原来的禅道安装目录，下载最新的源码包，覆盖即可。" . "<br />";
    echo $myConfig . " doesn't exists! Please don't rename zentao before overriding the source code!";
    exit;
}

error_reporting(0);
define('RUN_MODE', 'upgrade');

/* Load the framework. */
include '../framework/router.class.php';
include '../framework/control.class.php';
include '../framework/model.class.php';
include '../framework/helper.class.php';

/* Instance the app. */
$app = router::createApp('pms', dirname(dirname(__FILE__)));
$common = $app->loadCommon();

/* Reset the config params to make sure the install program will be lauched. */
$config->set('requestType', 'GET');
$config->set('debug', true);
$config->set('default.module', 'upgrade');
$config->set('default.method', 'index');
$app->setDebug();

/* Check the installed version is the latest or not. */
$config->installedVersion = $common->loadModel('setting')->getVersion();
if(version_compare($config->version, $config->installedVersion) <= 0) die(header('location: index.php'));

/* Run it. */
$app->parseRequest();
$common->checkUpgradeStatus();
$app->loadModule();

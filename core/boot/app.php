<?php
/**
 * Created by Yeganehha .
 * User: Erfan Ebrahimi (http://ErfanEbrahimi.ir)
 * Date: 3/24/2019
 * Time: 7:58 PM
 * project : paymentCMS
 * version : 0.0.0.1
 * update Time : 3/24/2019 - 7:58 PM
 * Description of this Page :
 */


use paymentCms\component\cache;
use paymentCms\component\file;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\strings;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');


class App
{

    // default  controller and method if url is empty
    private static $app = 'home';
    private static $appProvider = null;
    private static $controller = 'home';
    private static $method = 'index';

    private static $params = [];
    private static $url = [];

    private static $appPatch = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR;
    private static $pluginPatch = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR;

    public static function init()
    {
        if (is_file(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config.php')) {
            self::generateUrlPrams();
            $appName = self::$app;

            $links = self::generateAllLinks();
            if (is_array($links)) {
                usort($links, ['App', 'sortArrayByLength']);
                $fullAddress = self::getFullRequestUrl();
                foreach ($links as $link) {
                    $justLink = self::generateMasterDomain($link['link']);
                    if (strings::strFirstHas($fullAddress, $justLink)) {
                        if ((isset(self::$url[0]) and (strings::strLastHas($justLink, '/' . self::$url[0]))) or count(self::$url) == 0) {
                            $appName = $link['app'];
                            array_shift(self::$url);
                        } elseif (isset(self::$url[0]) and strings::subStr($fullAddress, 0, '/' . self::$url[0]) == $justLink) {
                            $appName = $link['app'];
                        }
                    }
                }
            } else {
                if (isset(self::$url[0])) {
                    $appName = self::$url[0];
                    array_shift(self::$url);
                }
            }

            self::checkAppIsExist($appName);
            self::checkControllerIsExist();
            self::checkMethodIsExist();
            self::getParamsFromUrl();
        } else {
            self::$app = 'install';
        }

        if (self::$appProvider == null)
            $className = 'App\\' . self::$app . '\controller\\' . self::$controller;
        else
            $className = 'App\\' . self::$appProvider . '\app_provider\\' . self::$app . '\\' . self::$controller;
        $methodName = self::$method;
        if (class_exists($className) and method_exists($className, $methodName)) {
            $class = new $className ();
            call_user_func_array([$class, $methodName], (array)self::$params);
        } else {
            $className = 'App\core\controller\httpErrorHandler';
            $methodName = 'E404';
            $class = new $className ();
            call_user_func_array([$class, $methodName], self::$params);
        }

    }


    /**
     * check is controller Exist
     *
     * @return bool
     */
    private static function checkAppIsExist($app = null)
    {
        if ($app == null)
            $app = self::$url[0];
        if (!isset($app))
            return false;
        if (!empty($app)) {
//			$app = trim(strtolower($app));
            $app = trim($app);
            $appPatch = self::$appPatch . $app;
            if (is_dir($appPatch)) {
//				array_shift(self::$url);
                self::$app = $app;
                return true;
            } else {
                return false;
            }
        }
        return true;
    }

    /**
     * check is controller Exist
     *
     * @return bool
     */
    private static function checkControllerIsExist()
    {
        if (!isset(self::$url[0]))
            return false;
        $controller = trim(self::$url[0]);
        if (!empty($controller)) {
            $controllerPatch = self::$appPatch . self::$app . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR . $controller . '.php';
            if (file_exists($controllerPatch)) {
                if (class_exists('App\\' . self::$app . '\controller\\' . $controller)) {
                    array_shift(self::$url);
                    if (!self::checkAppIsInstalled(self::$app, false)) {
                        self::$app = 'core';
                        self::$controller = 'httpErrorHandler';
                        self::$method = 'E404';
                        return false;
                    }
                    self::$controller = $controller;
                    return true;
                } else {
                    self::$app = 'core';
                    self::$controller = 'httpErrorHandler';
                    self::$method = 'E404';
                    return false;
                }
            } elseif (is_dir(self::$appPatch . self::$app)) {
                $files = file::get_files_by_pattern(self::$appPatch, '*' . DIRECTORY_SEPARATOR . 'app_provider' . DIRECTORY_SEPARATOR . self::$app . DIRECTORY_SEPARATOR . $controller . '.php');
                if (is_array($files) and count($files) > 0) {
                    $appProvider = strings::deleteWordFirstString(strings::deleteWordLastString($files[0], DIRECTORY_SEPARATOR . 'app_provider' . DIRECTORY_SEPARATOR . self::$app . DIRECTORY_SEPARATOR . $controller . '.php'), self::$appPatch);
                    if (class_exists('App\\' . $appProvider . '\app_provider\\' . self::$app . '\\' . $controller)) {
                        array_shift(self::$url);
                        if (!self::checkAppIsInstalled($appProvider, true) or !self::checkAppIsInstalled(self::$app, false)) {
                            self::$app = 'core';
                            self::$controller = 'httpErrorHandler';
                            self::$method = 'E404';
                            return false;
                        }
                        self::$controller = $controller;
                        self::$appProvider = $appProvider;
                        return true;
                    }
                } else
                    return false;
            }
        }
        return true;
    }

    private static function checkAppIsInstalled($app, $isAppProvider = false)
    {
        if ($app == 'core')
            return true;
        $statusApp = cache::get('appStatus', $app, 'paymentCms');
        if ($statusApp != 'active')
            return false;
        if ($isAppProvider)
            self::$appProvider = $app;
        else
            self::$app = $app;
        return true;
    }

    /**
     *
     * @return bool
     */
    private static function checkMethodIsExist()
    {
        if (!isset(self::$url[0]))
            return false;
        $method = self::$url[0];
        if (self::$appProvider == null)
            $className = 'App\\' . self::$app . '\controller\\' . self::$controller;
        else
            $className = 'App\\' . self::$appProvider . '\app_provider\\' . self::$app . '\\' . self::$controller;
        if (class_exists($className, false)) {
            if (method_exists($className, $method)) {
                array_shift(self::$url);
                self::$method = $method;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    private static function getParamsFromUrl()
    {
        self::$params = array_merge((array)self::$params, (array)self::$url);
    }

    /**
     * get url and generate to class and methods and prams
     */
    private static function generateUrlPrams()
    {
        $url = [];
        if (isset($_GET['urlFromHtaccess'])) {
            $url = explode('/', trim($_GET['urlFromHtaccess']));
        }
        self::$url = $url;
    }

    /**
     * @return string
     */
    public static function getApp()
    {
        return self::$app;
    }

    public static function getAppProvider()
    {
        return self::$appProvider;
    }


    public static function appsList()
    {
//		return file::get_name_folders(self::$appPatch);
        $appsStatus = cache::get('appStatus', null, 'paymentCms');
        $appActive = array_keys($appsStatus, "active");
        return $appActive;
    }

    public static function appsListWithConfig($app = null)
    {
        if (is_array($app))
            $apps = $app;
        elseif (!is_array($app) and $app != null)
            $apps = [$app];
        else
            $apps = file::get_name_folders(self::$appPatch);
        $return = [];
        if (is_array($apps)) {
            foreach ($apps as $app) {
                $file_name = self::$appPatch . $app . DIRECTORY_SEPARATOR . 'info.php';
                if (file_exists($file_name)) {
                    $temp = require $file_name;
                    if (isset($temp['info'])) {
                        $return[$app] = $temp['info'];
                        $return[$app]['status'] = cache::get('appStatus', $app, 'paymentCms');
                        if ($return[$app]['status'] == null)
                            $return[$app]['status'] = 'notInstall';
                    }
                }
            }
        }
        return $return;
    }


    public static function pluginsList()
    {
//		return file::get_name_folders(self::$pluginPatch);
        $pluginsStatus = cache::get('pluginStatus', null, 'paymentCms');
        $pluginActive = array_keys($pluginsStatus, "active");
        return $pluginActive;
    }

    public static function pluginsListWithConfig()
    {
        $plugins = file::get_name_folders(self::$pluginPatch);
        $return = [];
        if (is_array($plugins)) {
            foreach ($plugins as $plugin) {
                $file_name = self::$pluginPatch . $plugin . DIRECTORY_SEPARATOR . 'info.php';
                if (file_exists($file_name)) {
                    $temp = require $file_name;
                    if (isset($temp['info'])) {
                        $return[$plugin] = $temp['info'];
                        $return[$plugin]['status'] = cache::get('pluginStatus', $plugin, 'paymentCms');
                        if ($return[$plugin]['status'] == null)
                            $return[$plugin]['status'] = 'deActive';
                    }
                }
            }
        }
        return $return;
    }

    public static function appsControllerList($app = null)
    {
        $result = [];
        if ($app != null) {
            $result1 = file::get_name_file(self::$appPatch . $app . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR, false, [], ['.php']);
            $result2 = file::get_name_file_by_pattern(self::$appPatch, false, '*' . DIRECTORY_SEPARATOR . 'app_provider' . DIRECTORY_SEPARATOR . $app . DIRECTORY_SEPARATOR . '*.php');
            return array_merge($result1, $result2);
        } else {
            $apps = self::appsList();
            if (is_array($apps)) {
                foreach ($apps as $app) {
                    $result1 = file::get_name_file(self::$appPatch . $app . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR, false, [], ['.php']);
                    $result2 = file::get_name_file_by_pattern(self::$appPatch, false, '*' . DIRECTORY_SEPARATOR . 'app_provider' . DIRECTORY_SEPARATOR . $app . DIRECTORY_SEPARATOR . '*.php');
                    $result[$app] = array_merge($result1, $result2);
                }
            }
        }
        return array_filter($result);
    }

    public static function appsControllerMethodList($app = null, $controller = null)
    {
        $return = [];
        if ($app != null and $controller != null) {
            if (is_file(self::$appPatch . $app . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR . $controller . '.php')) {
                $methods = get_class_methods('App\\' . $app . '\controller\\' . $controller);
                for ($i = count((array)$methods) - 1; $i >= 0; $i--)
                    if (strings::strFirstHas($methods[$i], '__'))
                        unset($methods[$i]);
                if (count((array)$methods) == 0)
                    return false;
                return ['app' => $app, 'appProvider' => '', 'controller' => $controller, 'methods' => $methods];
            } else {
                $files = file::get_files_by_pattern(self::$appPatch, '*' . DIRECTORY_SEPARATOR . 'app_provider' . DIRECTORY_SEPARATOR . $app . DIRECTORY_SEPARATOR . $controller . '.php');
                if (is_array($files) and count($files) > 0) {
                    $appProvider = strings::deleteWordFirstString(strings::deleteWordLastString($files[0], DIRECTORY_SEPARATOR . 'app_provider' . DIRECTORY_SEPARATOR . $app . DIRECTORY_SEPARATOR . $controller . '.php'), self::$appPatch);
                    $methods = get_class_methods('App\\' . $appProvider . '\app_provider\\' . $app . '\\' . $controller);
                    for ($i = count($methods) - 1; $i >= 0; $i--)
                        if (strings::strFirstHas($methods[$i], '__'))
                            unset($methods[$i]);
                    if (count($methods) == 0)
                        return false;
                    return ['app' => $app, 'appProvider' => $appProvider, 'controller' => $controller, 'methods' => $methods];
                }
            }
        } elseif ($app != null and $controller == null) {
            $controllers = self::appsControllerList($app);
            foreach ($controllers as $tempController) {
                $result = self::appsControllerMethodList($app, $tempController);
                if ($result != false)
                    $return[$tempController] = $result;
            }
        } else {
            $apps = self::appsList();
            foreach ($apps as $tmpApp) {
                $result = self::appsControllerMethodList($tmpApp);
                if ($result != false)
                    $return[$tmpApp] = $result;
            }
        }
        return $return;
    }

    public static function getFullRequestUrl()
    {
        $protocol = 'http';
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") $protocol = 'https';
        return $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }

    public static function setFullRequestUrl($catch = null)
    {
        $_SERVER['REQUEST_URI'] = $catch;
    }

    public static function getAppPath($path = null, $app = null)
    {
        $baseDir = 'app';
        if ($app == null)
            $app = self::$app;
        elseif (strings::strLastHas($app, ':plugin')) {
            $baseDir = 'plugins';
            $app = strings::deleteWordLastString($app, ':plugin');
        }
        $path = str_replace(['\\', '/', '>'], DIRECTORY_SEPARATOR, $path);
        $path = (substr($path, -1) == DIRECTORY_SEPARATOR or is_null($path)) ? $path : $path . DIRECTORY_SEPARATOR;
        return payment_path . $baseDir . DIRECTORY_SEPARATOR . $app . DIRECTORY_SEPARATOR . ((!is_null($path)) ? $path : '');
    }

    public static function getAppLink($path = null, $app = null)
    {
        $baseUrl = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
        $protocol = 'http';
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") $protocol = 'https';
        $baseDir = 'app';
        if ($app == null)
            $app = self::$app;
        elseif (strings::strLastHas($app, ':plugin')) {
            $baseDir = 'plugins';
            $app = strings::deleteWordLastString($app, ':plugin');
        }
        $path = str_replace(['\\', '/', '>'], '/', $path);
        $path = str_replace('//', '/', $path);
        $path = (substr($path, -1) == '/' or $path == '') ? $path : $path . '/';
        return $protocol . '://' . $_SERVER['HTTP_HOST'] . $baseUrl . $baseDir . '/' . $app . '/' . ((!is_null($path)) ? $path : '');
    }

    public static function getBaseAppLink($path = null, $app = null)
    {
        if ($app == null)
            $app = self::$app;
        $baseUrl = self::getAppLinkFromAppsLink($app);
        $path = str_replace(['\\', '/', '>'], '/', $path);
        $path = str_replace('//', '/', $path);
        $path = (substr($path, -1) == '/' or $path == '') ? $path : $path . '/';
        return $baseUrl . '/' . ((!is_null($path)) ? $path : '');
    }

    public static function getCurrentBaseLink($path = null)
    {
        $server = request::server('HTTPS,HTTP_HOST,SCRIPT_NAME');
        $httpProtocol = $server['HTTPS'] == 'on' ? 'https://' : 'http://';
        $domain = $httpProtocol . $server['HTTP_HOST'] . $server['SCRIPT_NAME'];
        $baseUrl = strings::deleteWordLastString($domain, '/index.php');
        $path = str_replace(['\\', '/', '>'], '/', $path);
        $path = str_replace('//', '/', $path);
        $path = (substr($path, -1) == '/' or $path == '') ? $path : $path . '/';
        return $baseUrl . '/' . ((!is_null($path)) ? $path : '');
    }

    public static function getCurrentBaseLinkForMasterDomain($path = null)
    {
        $server = request::server('HTTPS,HTTP_HOST,SCRIPT_NAME');
        $domain = '[DOMAIN]' . $server['SCRIPT_NAME'];
        $baseUrl = strings::deleteWordLastString($domain, '/index.php');
        $path = str_replace(['\\', '/', '>'], '/', $path);
        $path = str_replace('//', '/', $path);
        $path = (substr($path, -1) == '/' or $path == '') ? $path : $path . '/';
        return $baseUrl . '/' . ((!is_null($path)) ? $path : '');
    }

    private static function getAppLinkFromAppsLink($app)
    {
        $links = self::generateAllLinks();
        $key = array_search($app, array_column($links, 'app'));
        return self::generateMasterDomain($links[$key]['link']);
    }

    private static function generateAllLinks()
    {
        if (!cache::hasLifeTime('apps_link', 'paymentCms')) {
            $links = model::searching(null, null, 'apps_link');
            cache::save($links, 'apps_link', PHP_INT_MAX, 'paymentCms');
        } else {
            $links = cache::get('apps_link', null, 'paymentCms');
        }
        return $links;
    }

    /**
     * @return string
     */
    public static function getController()
    {
        return self::$controller;
    }

    /**
     * @return string
     */
    public static function getMethod()
    {
        return self::$method;
    }

    private static function sortArrayByLength($a, $b)
    {
        return strlen($a['link']) - strlen($b['link']);
    }

    private static function generateMasterDomain($link)
    {
        if (strings::strFirstHas($link, '[DOMAIN]')) {
            $protocol = 'http';
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") $protocol = 'https';
            $link = str_replace('[DOMAIN]', $_SERVER['HTTP_HOST'], $link);
            $link = $protocol . '://' . str_replace(['////', '///', '//'], '/', $link);
            return $link;
        } else
            return $link;
    }
}
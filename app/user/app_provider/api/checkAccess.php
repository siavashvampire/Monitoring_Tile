<?php


namespace App\user\app_provider\api;


use App;
use App\api\controller\innerController;
use paymentCms\component\cache;
use paymentCms\component\model;
use paymentCms\component\session;
use paymentCms\component\strings;
use ReflectionClass;
use ReflectionException;

/**
 * Created by Yeganehha .
 * User: Erfan Ebrahimi (http://ErfanEbrahimi.ir)
 * Date: 11/22/2020
 * Time: 5:10 PM
 * project : payment-sia-demo
 * virsion : 0.0.0.1
 * update Time : 11/22/2020 - 5:10 PM
 * Discription of this Page :
 */


if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');


class checkAccess extends innerController
{


    /**
     * @param null $app
     * @param null $controller
     * @param null $method
     * @param null $appProvider
     *
     * @return bool
     *             [no-access]
     */
    public static function index($userGroupId, $app = null, $controller = null, $method = null, $appProvider = null)
    {
        if (($appProvider == null or $appProvider == "") and ($app == null or $app == "")) $appProvider = App::getAppProvider();
        if ($app == null or $app == "") $app = App::getApp();
        if ($controller == null or $controller == "") $controller = App::getController();
        if ($method == null or $method == "") $method = App::getMethod();

        if ($appProvider == null)
            $className = 'App\\' . $app . '\controller\\' . $controller;
        else
            $className = 'App\\' . $appProvider . '\app_provider\\' . $app . '\\' . $controller;
        if (($resultCommentCheck = self::checkCommentAccess($className, $method)) !== null) {
            if (!$resultCommentCheck)
                return self::jsonError($resultCommentCheck);
        }

        if ($app == 'user' and $controller == 'access')
            return self::json(true);

        $userPermission = self::getPermissionOfGroupId($app . '_' . $controller . '_' . $method, $userGroupId);
        if ($userPermission == null) {
            return self::jsonError(false);
        }
        return self::json(true);

    }

    /**
     * @param null $app
     * @param null $controller
     * @param null $method
     * @param null $appProvider
     *
     * @return bool
     *             [no-access]
     */
    public static function forMenu($app = null, $controller = null, $method = null, $appProvider = null)
    {

        if ($appProvider == null and $app == null) $appProvider = App::getAppProvider();
        if ($app == null) $app = App::getApp();
        if ($controller == null) $controller = App::getController();
        if ($method == null) $method = App::getMethod();

        if ($appProvider == null)
            $className = 'App\\' . $app . '\controller\\' . $controller;
        else
            $className = 'App\\' . $appProvider . '\app_provider\\' . $app . '\\' . $controller;
        if (($resultCommentCheck = self::checkCommentAccess($className, $method)) !== null) {
            if (!$resultCommentCheck)
                return false;
        }

        if ($app == 'user' and $controller == 'access')
            return true;

        if (session::has('userAppLoginInformation')) {
            $user = session::get('userAppLoginInformation');
            $userPermission = self::getPermissionOfGroupId($app . '_' . $controller . '_' . $method, $user['user_group_id']);
            if ($userPermission == null) {
                return false;
            }
            return true;
        } else {
            $userPermission = self::getPermissionOfGroupId($app . '_' . $controller . '_' . $method);
            if ($userPermission == null) {
                return false;
            } elseif ($userPermission['loginRequired']) {
                return false;
            }
            return true;
        }
    }


    private static function getPermissionOfGroupId($page, $groupId = null)
    {
        if (!cache::hasLifeTime('userPermissions', 'user')) {
            self::savePermissionOfGroupId();
        }
        $permission = cache::get('userPermissions', null, 'user');
        $result = null;
        for ($i = 0; $i < count($permission); $i++) {
            if ($groupId != null and $permission[$i]['user_groupId'] == $groupId and ($permission[$i]['accessPage'] == $page or $permission[$i]['accessPage'] == '--FULL-ACCESS--'))
                return $permission[$i];
            elseif ($groupId == null and ($permission[$i]['accessPage'] == $page or $permission[$i]['accessPage'] == '--FULL-ACCESS--')) {
                $result[$permission[$i]['loginRequired']] = $permission[$i];
            }
        }
        if (isset($result[0]))
            return $result[0];
        elseif (isset($result[1]))
            return $result[1];
        return null;
    }

    private static function checkCommentAccess($controllerClass, $method)
    {
        if (version_compare(phpversion(), '5.0.0', '<')) {
            return null;
        }
        try {
            $rc = new ReflectionClass($controllerClass);
            $stringClass = $rc->getDocComment();
            if (($tempReturn = self::checkAccessComment($stringClass)) === null) {
                $stringMethod = $rc->getMethod($method)->getDocComment();
                return self::checkAccessComment($stringMethod);
            }
            return $tempReturn;
        } catch (ReflectionException $e) {
            return null;
        }
    }

    private static function checkAccessComment($string)
    {
        $pattern = "[no-access]";
        if (strings::strhas($string, $pattern)) {
            return false;
        }

        $pattern = "[user-access]";
        if (strings::strhas($string, $pattern)) {
            if (!session::has('userAppLoginInformation'))
                return false;
        }

        $pattern = "[notUser-access]";
        if (strings::strhas($string, $pattern)) {
            if (session::has('userAppLoginInformation'))
                return false;
            return true;
        }

        $pattern = "[global-access]";
        if (strings::strhas($string, $pattern)) {
            return true;
        }

        return null;
    }

    private static function savePermissionOfGroupId()
    {
        model::join('user_group as user_group', 'user_group.user_groupId = user_group_permission.user_groupId');
        $permission = model::searching(null, null, 'user_group_permission as user_group_permission', 'user_group_permission.user_groupId,accessPage,loginRequired');
        return cache::save($permission, 'userPermissions', PHP_INT_MAX, 'user');
    }
}
<?php

namespace App\user\app_provider\api;

use app;
use App\api\controller\innerController;
use App\core\controller\fieldService;
use paymentCms\component\cache;
use paymentCms\component\arrays;
use paymentCms\component\file;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\security;
use paymentCms\component\session;
use paymentCms\component\validate;

/**
 * Created by Yeganehha .
 * User: Erfan Ebrahimi (http://ErfanEbrahimi.ir)
 * Date: 4/19/2019
 * Time: 12:21 AM
 * project : paymentCMS
 * virsion : 0.0.0.1
 * update Time : 4/19/2019 - 12:21 AM
 * Discription of this Page :
 */


if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');


class user extends innerController
{


    public static function login($getToken = true, $data = null)
    {

        if ($data != null)
            $data = request::getFromArray($data, 'password,username');
        else
            $data = request::post('password,username');
        $rules = [
            "password" => ["required", rlang('password')],
            "username" => ["required", rlang('username')],
        ];
        $valid = validate::check($data, $rules);
        if ($valid->isFail()) {
            return self::jsonError($valid->errorsIn());
        }

        /* @var \paymentCms\model\user $model */
        $model = parent::model('user');
        $model->setPassword($data['password']);
        $password = $model->getPassword();

        $model = parent::model('user', [$data['username'], $data['username']], ' ( phone = ? or email = ?) and block = 0 ');
//        show($password,false);
//show($model->getPassword(),false);
        if ($model->getUserId() == null) {
            return self::jsonError(rlang('cantFindUser'));
        }
        if ($model->getPassword() != $password)
            return self::jsonError(rlang('passwordIsWrong'));

        $doBeforeLogin = parent::callHooks('doBeforeLogin', ['userObject' => $model, 'isApi' => parent::$jsonResponse]);
        if (is_array($doBeforeLogin)) {
            foreach ($doBeforeLogin as $do)
                if ($do === false)
                    return self::jsonError('login blocked by hooks!');
        }

        if ($getToken) {
            $user = $model->returnAsArray();
            unset($user['password']);
            $user['token'] = security::creatToken($model->getUserId());
            return self::json($user);
        }
        return self::json($model->returnAsArray());
    }

    /**
     * @param $whereValue
     * @param $whereClause
     *
     * @return \paymentCms\model\user|\App\model\model
     *
     *                               [no-access]
     */
    public static function getUser($whereValue, $whereClause)
    {
        return self::model('user', $whereValue, $whereClause);
    }

    /**
     * @param $userId
     *
     * @return \paymentCms\model\user|\App\model\model
     *
     *                               [no-access]
     */
    public static function getUserById($userId)
    {
        return self::model('user', $userId);
    }

    public static function getUsersByGroupId($group_id, $jsonFlag = true)
    {
        if ($jsonFlag)
            return self::json(self::model(['user', 'user'])->search([$group_id], ' user_group_id  = ? AND userId <> -1', null, '*', ['column' => 'userId', 'type' => 'asc']));
        else
            return self::model(['user', 'user'])->search([$group_id], ' user_group_id  = ? AND userId <> -1', null, '*', ['column' => 'userId', 'type' => 'asc']);;
    }


    /**
     * @param $userId
     * @param $data
     *
     * @return array
     */
    public static function editUser($userId, $data)
    {
        $get = request::getFromArray($data, 'fname,lname,email,phone,password,groupId,block=0,verified,admin_note,customField,avatar', null);
        $isFileBase64 = true;
        if ($get['avatar'] == null or $get['avatar'] == "") {
            $get['avatar'] = $_FILES['avatar']['tmp_name'];
            $isFileBase64 = false;
        }
        $rulesStatus = cache::get('defaultFieldRegisterPageStatus' . $get['groupId'], null, 'user');
        if ($rulesStatus != null) {
            if ($rulesStatus['firstNameStatus'] == 'required')
                $rules["fname"] = ["required", rlang('firstName')];
            if ($rulesStatus['lastNameStatus'] == 'required')
                $rules["lname"] = ["required", rlang('lastName')];
            if ($rulesStatus['emailNameStatus'] == 'required')
                $rules["email"] = ["required", rlang('email')];
            if ($rulesStatus['phoneNameStatus'] == 'required')
                $rules["phone"] = ["required|mobile", rlang('phone')];
            if ($rulesStatus['avatarStatus'] == 'required' and $userId == null)
                $rules["avatar"] = ["required", rlang('avatar')];
            if ($rulesStatus['passwordStatus'] == 'required' and $userId == null)
                $rules["password"] = ["required", rlang('password')];
        }
        if ($get['verified'] == null) {
            $get['verified'] = $rulesStatus['verifiedStatus'];
        }
        $rules["groupId"] = ["required|match:>0", rlang('permission')];
        $rules["block"] = ["required|format:{0/1}", rlang('block')];
        $rules["verified"] = ["required|format:{0/1/-1/-2}", rlang('verified')];
        $valid = validate::check($get, $rules);
        if ($valid->isFail()) {
            return self::jsonError($valid->errorsIn(), 400);
        }
        /* @var \paymentCms\model\user $model */
        /* @var \paymentCms\model\user $modelLastInsert */
        if ($userId == null) {
            if ($get['email'] != '' and $get['phone'] != '')
                $modelLastInsert = self::model('user', [$get['phone'], $get['email']], 'phone = ? or email = ?');
            elseif ($get['email'] == '' and $get['phone'] != '')
                $modelLastInsert = self::model('user', [$get['phone']], 'phone = ?');
            elseif ($get['email'] != '' and $get['phone'] == '')
                $modelLastInsert = self::model('user', [$get['email']], 'email = ?');

            $model = self::model('user');
        } else {

            if ($get['email'] != '' and $get['phone'] != '')
                $modelLastInsert = self::model('user', [$get['phone'], $get['email'], $userId], '(phone = ? or email = ? ) and userId != ?');
            elseif ($get['email'] == '' and $get['phone'] != '')
                $modelLastInsert = self::model('user', [$get['phone'], $userId], 'phone = ? and userId != ?');
            elseif ($get['email'] != '' and $get['phone'] == '')
                $modelLastInsert = self::model('user', [$get['email'], $userId], 'email = ? and userId != ?');

            $model = self::model('user', $userId);
            if ($model->getUserId() != $userId) {
                return self::jsonError(rlang('cantFindUser'), 400);
            }
        }
        if ($modelLastInsert->getUserId() != null) {
            return self::jsonError(rlang('emailOrPhoneIsRepeatedly'), 400);
        }
        $model->setUserGroupId($get['groupId']);
        $model->setFname($get['fname']);
        $model->setLname($get['lname']);
        $model->setEmail($get['email']);
        $model->setPhone($get['phone']);
        if ($get['password'] != null) $model->setPassword($get['password']);
        $model->setBlock($get['block']);
        if ($get['verified'] != -2)
            $model->setVerified($get['verified']);
        $model->setAdminNote($get['admin_note']);
        $model->setRegisterTime(($model->getRegisterTime() != null) ? $model->getRegisterTime() : date('Y-m-d H:i:s'));
        model::transaction();
        if ($userId == null) {
            $result = $model->insertToDataBase();
            if ($result !== false) {
                if ($get['customField'] != null) {
                    $resultFillOutForm = fieldService::fillOutForm($get['groupId'], 'user_register', $get['customField'], $model->getUserId(), 'user_register');
                    if (!$resultFillOutForm['status']) {
                        model::rollback();
                        return self::jsonError(rlang('pleaseTryAGain'), 500);
                    }
                }
                self::callHooks('userUpdate', ['userObject' => $model, 'filed' => $get['customField'], 'data' => $data]);
                if ($get['avatar'] != null) {
                    if ($isFileBase64)
                        $resultUpload = self::uploadBase64($model->getUserId(), $get['avatar']);
                    else
                        $resultUpload = self::uploadFile($model->getUserId(), 'avatar');
                    if ($resultUpload['status'] == false) {
                        model::rollback();
                        return self::jsonError($resultUpload['massage']);
                    } else {
                        model::commit();
                        return self::json($model->getUserId());
                    }
                } else {
                    model::commit();
                    return self::json($model->getUserId());
                }
            } else {
                model::rollback();
//                show( model::getLastQuery() );
                return self::jsonError(rlang('pleaseTryAGain'), 500);
            }
        } else {
            $result = $model->upDateDataBase();
            if ($result) {
                if ($get['customField'] != null) {
                    $resultFillOutForm = fieldService::updateFillOutForm($get['groupId'], 'user_register', $get['customField'], $model->getUserId(), 'user_register');
                    if (!$resultFillOutForm['status']) {
                        model::rollback();
                        return self::jsonError(rlang('pleaseTryAGain') . ' - ' . $resultFillOutForm['massage'], 500);
                    }
                }
                if ($model->getUserId() == session::get('userAppLoginInformation')['userId'])
                    session::lifeTime(1, 'hour')->set('userAppLoginInformation', $model->returnAsArray());
                self::callHooks('userUpdate', ['userObject' => $model, 'filed' => $get['customField'], 'data' => $data]);
                if ($get['avatar'] != null) {
                    if ($isFileBase64)
                        $resultUpload = self::uploadBase64($model->getUserId(), $get['avatar']);
                    else
                        $resultUpload = self::uploadFile($model->getUserId(), 'avatar');
                    if ($resultUpload['status'] == false) {
                        model::rollback();
                        return self::jsonError($resultUpload['massage']);
                    } else {
                        model::commit();
                        return self::json($model->getUserId());
                    }
                } else {
                    model::commit();
                    return self::json($model->getUserId());
                }
            } else {
                model::rollback();
                return self::jsonError(rlang('pleaseTryAGain'), 500);
            }
        }
    }

    public static function generateUser($data = null)
    {
        if ($data == null)
            $data = $_POST;
        return self::editUser(null, $data);
    }

    public static function getGroups()
    {
        $model = self::model(['user', 'user_group']);
        $value = array();
        $search = $model->search([1], '? AND user_groupId <> -1', null, '*', ['column' => 'user_groupId', 'type' => 'asc']);
        $result = [];
        if (is_array($search)) {
            foreach ($search as $group) {
                $result[$group['user_groupId']] = $group;
            }
        }
        return self::json($result);
    }

    /**
     * @param bool $justId
     *
     * @return bool|null
     *                  [no-access]
     */
    public static function getUserLogin($justId = false)
    {
        if (session::has('userAppLoginInformation')) {
            $user = session::get('userAppLoginInformation');
            if ($justId)
                return $user['userId'];
            else
                return $user;
        } else
            return false;
    }


    private static function uploadFile($userId, $fileName)
    {
        $uploadStoragePath = app::getAppPath('storage', 'user');
        file::make_folder($uploadStoragePath);
        $allowed_types = array(
            'image/jpeg', 'image/png', 'image/bmp',
        );
        $fileInput = $_FILES[$fileName];
        if ($fileInput['error'] != UPLOAD_ERR_OK)
            return self::jsonError(rlang($fileInput['error']) . ' (' . $fileInput['error'] . ')');
        $temporaryName = $fileInput['tmp_name'];

        if (!in_array($fileInput['type'], $allowed_types))
            return self::jsonError(rlang('formatWrong') . ' ( ' . $fileInput['type'] . ' ) ');
        if (file_exists($uploadStoragePath . DIRECTORY_SEPARATOR . $userId . '.jpg'))
            unlink($uploadStoragePath . DIRECTORY_SEPARATOR . $userId . '.jpg');
        if (!move_uploaded_file($temporaryName, $uploadStoragePath . DIRECTORY_SEPARATOR . $userId . '.jpg'))
            return self::jsonError(rlang('pleaseTryAGain'));

        $fileWatermark = app::getAppPath('theme/assets/image', 'user') . 'watermark.png';
        if (file_exists($fileWatermark)) {
            $watermark = imagecreatefrompng($fileWatermark);
            $image = imagecreatefromjpeg($uploadStoragePath . DIRECTORY_SEPARATOR . $userId . '.jpg');

            $wm_x = imagesx($watermark);
            $wm_y = imagesy($watermark);
            $img_x = imagesx($image);
            $img_y = imagesy($image);

            // calculate watermark size
            $wm_scale = 3; // set size in relation to image
            $wm_w = $img_x / $wm_scale;
            $wm_aspect = $wm_y / $wm_x;
            $wm_h = (int)($wm_aspect * $wm_w);

            // calculate margin
            $margin_scale = 8; // set margin in relation to new watermark size
            $margin_right = $wm_w / $margin_scale;
            $margin_bottom = $wm_h / $margin_scale;

            // calculate watermark destination
            $dst_x = $img_x - $wm_w - $margin_right;
            $dst_y = $img_y - $wm_h - $margin_bottom;

            imagecopyresized($image, $watermark, $dst_x, $dst_y, 0, 0, $wm_w, $wm_h, $wm_x, $wm_y);
            imagejpeg($image, $uploadStoragePath . DIRECTORY_SEPARATOR . $userId . 'W.jpg');
            imagepng($watermark);
            imagedestroy($image);
            unlink($uploadStoragePath . DIRECTORY_SEPARATOR . $userId . '.jpg');
            copy($uploadStoragePath . DIRECTORY_SEPARATOR . $userId . 'W.jpg', $uploadStoragePath . DIRECTORY_SEPARATOR . $userId . '.jpg');
            unlink($uploadStoragePath . DIRECTORY_SEPARATOR . $userId . 'W.jpg');
        }
        return self::json(null);
    }

    private static function uploadBase64($userId, $avatar)
    {
        $uploadStoragePath = app::getAppPath('storage', 'user');
        file::make_folder($uploadStoragePath);

        $data = explode(',', $avatar);

        if (!stristr($avatar, 'image/jpeg'))
            return self::jsonError(rlang('formatWrong') . ' ( ' . $data[0] . ' ) ');

        $file_contents = base64_decode($data[1]);

        if (file_exists($uploadStoragePath . DIRECTORY_SEPARATOR . $userId . '.jpg'))
            unlink($uploadStoragePath . DIRECTORY_SEPARATOR . $userId . '.jpg');

        $save_file = $uploadStoragePath . DIRECTORY_SEPARATOR . $userId . '.jpg';
        if (file_put_contents($save_file, $file_contents)) {
            $isImage = @imagecreatefromjpeg($save_file);
            if (!$isImage) {
                unlink($save_file);
                imagedestroy($isImage);
                return self::jsonError(rlang('formatWrong'));
            }
            $fileWatermark = app::getAppPath('theme/assets/image', 'user') . 'watermark.png';
            if (file_exists($fileWatermark)) {
                $watermark = imagecreatefrompng($fileWatermark);
                $image = imagecreatefromjpeg($uploadStoragePath . DIRECTORY_SEPARATOR . $userId . '.jpg');

                $wm_x = imagesx($watermark);
                $wm_y = imagesy($watermark);
                $img_x = imagesx($image);
                $img_y = imagesy($image);

                // calculate watermark size
                $wm_scale = 3; // set size in relation to image
                $wm_w = $img_x / $wm_scale;
                $wm_aspect = $wm_y / $wm_x;
                $wm_h = (int)($wm_aspect * $wm_w);

                // calculate margin
                $margin_scale = 8; // set margin in relation to new watermark size
                $margin_right = $wm_w / $margin_scale;
                $margin_bottom = $wm_h / $margin_scale;

                // calculate watermark destination
                $dst_x = $img_x - $wm_w - $margin_right;
                $dst_y = $img_y - $wm_h - $margin_bottom;

                imagecopyresized($image, $watermark, $dst_x, $dst_y, 0, 0, $wm_w, $wm_h, $wm_x, $wm_y);
                imagejpeg($image, $uploadStoragePath . DIRECTORY_SEPARATOR . $userId . 'W.jpg');
                imagepng($watermark);
                imagedestroy($image);
                unlink($uploadStoragePath . DIRECTORY_SEPARATOR . $userId . '.jpg');
                copy($uploadStoragePath . DIRECTORY_SEPARATOR . $userId . 'W.jpg', $uploadStoragePath . DIRECTORY_SEPARATOR . $userId . '.jpg');
                unlink($uploadStoragePath . DIRECTORY_SEPARATOR . $userId . 'W.jpg');
            }
            imagedestroy($isImage);
            return self::json(null);
        } else
            return self::jsonError(rlang('pleaseTryAGain'));
    }
}
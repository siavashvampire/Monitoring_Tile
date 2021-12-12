<?php


namespace App\core\controller;


use App\api\controller\innerController;
use App\core\app_provider\api\fields;
use paymentCms\component\mold\mold;

/**
 * Created by Yeganehha .
 * User: Erfan Ebrahimi (http://ErfanEbrahimi.ir)
 * Date: 4/1/2019
 * Time: 5:27 PM
 * project : paymentCMS
 * virsion : 0.0.0.1
 * update Time : 4/1/2019 - 5:27 PM
 * Discription of this Page :
 */


if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

/**
 * Class fieldService
 * @package App\core\controller
 *          [no-access]
 */
class fieldService extends innerController
{

    /**
     * get list of fields for edit , add or delete then should show to user
     * @param      $serviceId
     * @param      $serviceType
     * @param null,mold $mold
     *
     * @return array
     */
    public static function getFieldsToEdit($serviceId, $serviceType, &$mold = null)
    {
        /* @var $mold mold */
        $return = fields::getFieldsToEdit($serviceId, $serviceType);
        if ($mold != null and isset($return['result'])) {
            $hooks = parent::callHooks('fieldService_listOfTypes', [$serviceId, $serviceType, $return['result']]);
            $getPath = $mold->getPath();
            $mold->path('default', 'core');
            $mold->view('editAbleFields.mold.html');
            $mold->set('numberOfFields', count($return['result']));
            $mold->set('fields', $return['result']);
            $mold->set('fieldsOfHooks', $hooks);
            $mold->path($getPath['folder'], $getPath['app']);
        }
        return (isset($return['result']) ? $return['result'] : []);
    }

    public static function getFieldsById($fieldsId)
    {
        return fields::getFieldsById($fieldsId);
    }

    public static function getFieldsToFillOut($serviceId, $serviceType, &$mold = null)
    {
        $return = fields::getFieldsToEdit($serviceId, $serviceType, ['admin', 'invisible'], true);
        if ($mold != null and isset($return['result'])) {
            $getPath = $mold->getPath();
            $mold->path('default', 'core');
            $mold->view('fillOutFields.mold.html');
            $mold->set('fields', $return['result']);
            $mold->path($getPath['folder'], $getPath['app']);
        }
        return $return;
    }

    public static function updateFields($serviceId, $serviceType, $fields, $deletedFields = null)
    {
        return fields::updateFields($serviceId, $serviceType, $fields, $deletedFields);
    }

    public static function updateFieldsByLabel($model, $label, $serviceId, $serviceType)
    {
        $resultUpdateField = self::getFieldsToEdit($serviceId, $serviceType);

        $found = false;
        if ($model->getId()) {
            foreach ($resultUpdateField as $key => $field) {
                if ($field['title'] == $label) {
                    $resultUpdateField[$key]['title'] = $model->getLabel();
                    $found = true;
                }
            }
        }

        $resultUpdateField = self::convertFieldForUpdate($resultUpdateField);

        if (!$found) {
            $temp = array();
            $temp['id'] = "0";
            $temp['name'] = $model->getLabel();
            $temp['type'] = "number";
            $temp['description'] = "";
            $temp['status'] = "visible";
            $temp['value'] = "";
            $temp['order'] = "";
            $temp['regex'] = "";
            $resultUpdateField[] = $temp;
        }

        return self::updateFields($serviceId, $serviceType, $resultUpdateField);

    }

    public static function fillOutForm($serviceId, $serviceType, $data, $objectId, $objectType)
    {
        return fields::fillOutForm($serviceId, $serviceType, $data, $objectId, $objectType);
    }

    public static function updateFillOutForm($serviceId, $serviceType, $data, $objectId, $objectType)
    {
        return fields::updateFillOutForm($serviceId, $serviceType, $data, $objectId, $objectType);
    }

    public static function showFilledOutForm($serviceId, $serviceType, $objectId, $objectType)
    {
        return fields::showFilledOutForm($serviceId, $serviceType, $objectId, $objectType, ['admin', 'invisible']);
    }

    public static function showFilledOutValue($fieldIds, $serviceId, $serviceType, $objectId, $objectType)
    {
        return fields::showFilledOutValue($fieldIds, $serviceId, $serviceType, $objectId, $objectType, ['admin', 'invisible']);
    }

    public static function showFilledOutValueWithAllFields($fieldIds, $serviceId, $serviceType, $objectId, $objectType)
    {
        return fields::showFilledOutValue($fieldIds, $serviceId, $serviceType, $objectId, $objectType);
    }

    public static function showFilledOutFormWithAllFields($serviceId, $serviceType, $objectId, $objectType, $editAble = false, &$mold = null)
    {
        $return = fields::showFilledOutForm($serviceId, $serviceType, $objectId, $objectType);
        if ($editAble and $mold != null and isset($return['result'])) {
            $getPath = $mold->getPath();
            $mold->path('default', 'core');
            $mold->view('fillOutFields.mold.html');
            $mold->set('fields', $return['result']);
            $mold->path($getPath['folder'], $getPath['app']);
        }
        return $return;
    }

    public static function whereSave()
    {
        return fields::$creatTable;
    }

    public static function saveInOneTable()
    {
        fields::$creatTable = false;
    }

    public static function saveInServiceTable()
    {
        fields::$creatTable = true;
    }

    public static function convertFieldForUpdate($fields)
    {
        $temp = array();
        $returnArray = array();
        foreach ($fields as $field) {
            $temp['id'] = $field["fieldId"];
            $temp['name'] = $field["title"];
            $temp['type'] = $field["type"];
            $temp['description'] = $field["description"];
            $temp['status'] = $field["status"];
            $temp['value'] = "";
            $temp['order'] = "";
            $temp['regex'] = "";
            $returnArray[] = $temp;
        }
        return $returnArray;
    }
}
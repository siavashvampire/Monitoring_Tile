<?php


namespace App\core\app_provider\api;


use App\api\controller\innerController;
use mysql_xdevapi\Exception;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\security;
use paymentCms\component\strings;
use paymentCms\component\validate;
use paymentCms\model\field;
use paymentCms\model\fieldvalue;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');


/**
 * Class fields
 * @package App\core\app_provider\api
 *          [no-access]
 */
class fields extends innerController
{

    public static $creatTable = true;
    public static $tableName = 'customFieldValue_';

    public static function getFieldsToEdit($serviceId, $serviceType, $statusNotBe = null, $defineKeys = false, $fieldsId = null)
    {
        /* @var field $fieldModel */
        $fieldModel = self::model('field');
        $searchWhere = ' serviceType = ? and ( 0 ';
        $searchValue[] = $serviceType;
        if ($serviceId !== null) {
            $searchWhere .= ' or serviceId IN (' . strings::deleteWordLastString(str_repeat('? , ', count((array)$serviceId)), ', ') . ')';
            $searchValue = array_merge($searchValue, (array)$serviceId);
        }
        if ($fieldsId !== null and count($fieldsId) > 0) {
            $searchWhere .= ' or fieldId IN (' . strings::deleteWordLastString(str_repeat('? , ', count($fieldsId)), ', ') . ')';
            $searchValue = array_merge($searchValue, (array)$fieldsId);
        }
        $searchWhere .= ' ) ';
        if ($statusNotBe != null) {
            if (is_array($statusNotBe)) {
                foreach ($statusNotBe as $statusOne) {
                    $searchValue[] = $statusOne;
                    $searchWhere .= ' and status != ? ';
                }
            }
        }
        $fields = $fieldModel->search($searchValue, $searchWhere, null, '*', ['column' => 'orderNumber', 'type' => 'desc']);
        if ($fields === true)
            $fields = [];

        if ($defineKeys) {
            foreach ($fields as $key => $field) {
                if ($field['type'] == 'checkbox' or $field['type'] == 'radio' or $field['type'] == 'select')
                    $fields[$key]['valuesDe'] = explode(',', $field['values']);
            }
        }

        return self::json($fields);
    }

    public static function getFieldsById($fieldsId)
    {
        /* @var field $fieldModel */
        $fieldModel = self::model('field');
        $searchWhere = ' fieldId = ? ';
        $searchValue[] = $fieldsId;


        $fields = $fieldModel->search($searchValue, $searchWhere, null, '*', ['column' => 'orderNumber', 'type' => 'desc']);
        if ($fields === true)
            $fields = [];

        return self::json($fields);
    }


    public static function updateFields($serviceId, $serviceType, $fields, $deletedFields = null)
    {
        $form = ['moreField' => $fields, 'deleteField' => $deletedFields];
        $rules = [
            'moreField.*.status' => ['format:{visible/invisible/required/admin}', rlang('status')],
//			'moreField.*.type' => ['format:{text/url/password/email/select/radio/checkbox/textarea/date/number/file}'	, rlang('type')],
            'moreField.*.name' => ['notEmpty', rlang('name')],
            'moreField.*.order' => ['number', rlang('orderToShow')],
        ];
        $valid = validate::check($form, $rules);
        if ($valid->isFail())
            return self::jsonError($valid->errorsIn(), 500);
        model::transaction();
        try {
            $tableCreated = false;
            if (self::$creatTable and !model::tableExist(self::$tableName . $serviceId . '_' . $serviceType)) {
                $query = self::generateQueryCreatTable(self::$tableName . $serviceId . '_' . $serviceType);
                if (model::queryUnprepared($query) === false) {
                    model::rollback();
                    return self::jsonError('cantCreatTable', 500);
                }
                $tableCreated = true;
            }

            /* @var field $modelField */
            if (is_array($fields) and count($fields) > 0)
                $idsOfItem = [];
            foreach ($fields as $key => $field) {
                if ($field['id'] > 0)
                    $modelField = self::model('field', $field['id']);
                else
                    $modelField = self::model('field');
                $modelField->setStatus($field['status']);
                $modelField->setDescription($field['description']);
                $modelField->setOrder($field['order']);
                $modelField->setRegex($field['regex']);
                $modelField->setTitle($field['name']);
                $modelField->setType($field['type']);
                $modelField->setValues($field['value']);
                $modelField->setServiceId($serviceId);
                $modelField->setServiceType($serviceType);
                if ($field['id'] > 0) {
                    $modelField->upDateDataBase();
                    if ($tableCreated)
                        $idsOfItem[] = $modelField->getFieldId();
                } else {
                    $modelField->insertToDataBase();
                    if (substr($modelField->getType(), 0, 10) == 'fieldCall_') {
                        $fieldHookData = explode('_', $modelField->getType());
                        parent::callHooks('fieldService_SetId', [$fieldHookData[2], $modelField->getServiceId(), $modelField->getServiceType(), $modelField->getFieldId()], $fieldHookData[1]);
                    }
                    $idsOfItem[] = $modelField->getFieldId();
                }
            }
            if (self::$creatTable and count($idsOfItem) > 0) {
                if (!model::tableExist(self::$tableName . $serviceId . '_' . $serviceType))
                    return self::json(null);
                $query = self::addToTable(self::$tableName . $serviceId . '_' . $serviceType, (array)$idsOfItem);
                if (model::queryUnprepared($query) === false) {
                    model::rollback();
                    return self::jsonError('cantAddToTable', 500);
                }
            }
            if (is_array($deletedFields) and count($deletedFields) > 0) {
                if ($modelField == null)
                    $modelField = self::model('field');
                $fieldsDeletedForHook = self::getFieldsToEdit($serviceId, $serviceType, null, false, $deletedFields);
                if ($fieldsDeletedForHook['status'] and count($fieldsDeletedForHook['result']) > 0) {
                    foreach ($fieldsDeletedForHook['result'] as $fieldDeletedForHook) {
                        if (substr($fieldDeletedForHook['type'], 0, 10) == 'fieldCall_') {
                            $fieldHookData = explode('_', $fieldDeletedForHook['type']);
                            parent::callHooks('fieldService_DeleteId', [$fieldHookData[2], $fieldDeletedForHook['serviceId'], $fieldDeletedForHook['serviceType'], $fieldDeletedForHook['fieldId']], $fieldHookData[1]);
                        }
                    }
                }
                $modelField->db()->where('fieldId', $deletedFields, 'IN');
                $modelField->db()->where('serviceId', $serviceId);
                $modelField->db()->where('serviceType', $serviceType);
                $modelField->db()->delete('field');
                if (self::$creatTable and count($deletedFields) > 0) {
                    if (!model::tableExist(self::$tableName . $serviceId . '_' . $serviceType))
                        return self::json(null);
                    $query = self::deleteFromTable(self::$tableName . $serviceId . '_' . $serviceType, (array)$deletedFields);
                    if (model::queryUnprepared($query) === false) {
                        model::rollback();
                        return self::jsonError('cantDropToTable', 500);
                    }
                }
            }
            model::commit();
            return self::json(null);
        } catch (Exception $exception) {
            model::rollback();
            return self::jsonError($exception->getMessage(), 500);
        }
    }


    public static function fillOutForm($serviceId, $serviceType, $data, $objectId, $objectType)
    {
        $fields = self::getFieldsToEdit($serviceId, $serviceType, ['admin', 'invisible'], true);
        if (!empty($fields) and is_array($fields)) {
            foreach ($fields['result'] as $key => $field) {
                $regix = null;
                if ($field['regex'] != null) {
                    $regix = explode(',', $field['regex']);
                }
                if ($field['status'] == 'required') {
                    $regix[] = 'required';
                }
                if ($regix == null or count($regix) == 0)
                    continue;
                $rules[$field['fieldId']] = [implode('|', array_unique(array_filter($regix))), $field['title']];
                $fieldsInformation[$field['fieldId']] = $field;
            }
        }
        unset($fields);
        if (isset($rules)) {
            $valid = validate::check($data, $rules);
            if ($valid->isFail()) {
                return self::jsonError($valid->errorsIn());
            }
        }
        if (is_array($data) and !empty($data)) {
            model::transaction();
            $insertRow['objectId'] = $objectId;
            $insertRow['objectType'] = $objectType;
            foreach ($data as $fieldId => $fieldValue) {
                if ($fieldValue == null) continue;
                if (is_array($fieldValue)) {
                    $fieldValueBackup = $fieldValue;
                    $fieldValue = implode(' - ', $fieldValue);
                }
                if (!self::$creatTable) {
                    /* @var fieldvalue $fieldValueModel */
                    $fieldValueModel = self::model('fieldvalue');
                    $fieldValueModel->setObjectId($objectId);
                    $fieldValueModel->setObjectType($objectType);
                    $fieldValueModel->setFieldId($fieldId);
                    $fieldValueModel->setValue($fieldValue);
                    $fieldValueStatus = $fieldValueModel->insertToDataBase();
                    if (!$fieldValueStatus) {
                        model::rollback();
                        return self::jsonError(rlang('canNotInsertFieldValue'), 500);
                    }
                } else {
                    $insertRow['f_' . $fieldId] = $fieldValue;
                }
                if (substr($fieldsInformation[$fieldId]['type'], 0, 10) == 'fieldCall_') {
                    $hookOfThis = explode('_', $fieldsInformation[$fieldId]['type']);
                    self::callHooks('fieldService_setValue_' . $hookOfThis[2], [$fieldsInformation[$fieldId], [$objectId, $objectType], (isset($fieldValueBackup)) ? $fieldValueBackup : $fieldValue]);
                }
            }
            if (self::$creatTable) {
                if (!model::tableExist(self::$tableName . $serviceId . '_' . $serviceType))
                    return self::json(null);
                if (!model::insert(self::$tableName . $serviceId . '_' . $serviceType, $insertRow)) {
                    model::rollback();
                    return self::jsonError(rlang('canNotInsertFieldValueRow'), 500);
                }
            }
            model::commit();
            return self::json(null);
        }
        return self::json(null);
    }

    public static function updateFillOutForm($serviceId, $serviceType, $data, $objectId, $objectType)
    {
        $fields = self::getFieldsToEdit($serviceId, $serviceType, ['admin', 'invisible'], true);
        if (!empty($fields) and is_array($fields)) {
            foreach ($fields['result'] as $key => $field) {
                $regix = null;
                if ($field['regex'] != null) {
                    $regix = explode(',', $field['regex']);
                }
                if ($field['status'] == 'required') {
                    $regix[] = 'required';
                }
                if ($regix == null or count($regix) == 0)
                    continue;
                $rules[$field['fieldId']] = [implode('|', array_unique(array_filter($regix))), $field['title']];
                $fieldsInformation[$field['fieldId']] = $field;
            }
        }
        unset($fields);
        if (isset($rules)) {
            $valid = validate::check($data, $rules);
            if ($valid->isFail()) {
                return self::jsonError($valid->errorsIn());
            }
        }
        if (is_array($data) and !empty($data)) {
            model::transaction();
            $insertRow = [];
            foreach ($data as $fieldId => $fieldValue) {
                if ($fieldValue == null) continue;
                if (is_array($fieldValue)) {
                    $fieldValueBackup = $fieldValue;
                    $fieldValue = implode(' - ', $fieldValue);
                }
                if (!self::$creatTable) {
                    /* @var fieldvalue $fieldValueModel */
                    $fieldValueModel = self::model('fieldvalue', 'objectId = ? and objectType = ? and fieldId = ?', [$objectId, $objectType, $fieldId]);
                    if ($fieldValueModel->getFieldId() != $fieldId) {
                        $fieldValueModel->setObjectId($objectId);
                        $fieldValueModel->setObjectType($objectType);
                        $fieldValueModel->setFieldId($fieldId);
                        $fieldValueModel->setValue($fieldValue);
                        $fieldValueStatus = $fieldValueModel->insertToDataBase();
                        if (!$fieldValueStatus) {
                            model::rollback();
                            return self::jsonError(rlang('canNotInsertFieldValue'), 500);
                        }
                    } else {
                        $fieldValueModel->setValue($fieldValue);
                        $fieldValueStatus = $fieldValueModel->upDateDataBase();
                        if (!$fieldValueStatus) {
                            model::rollback();
                            return self::jsonError(rlang('canNotInsertFieldValue'), 500);
                        }
                    }
                } else {
                    $insertRow['f_' . $fieldId] = $fieldValue;
                }
                if (substr($fieldsInformation[$fieldId]['type'], 0, 10) == 'fieldCall_') {
                    $hookOfThis = explode('_', $fieldsInformation[$fieldId]['type']);
                    self::callHooks('fieldService_updateValue_' . $hookOfThis[2], [$fieldsInformation[$fieldId], [$objectId, $objectType], (isset($fieldValueBackup)) ? $fieldValueBackup : $fieldValue]);
                }
            }
            if (count($insertRow) == 0) {
                return self::json(null);
            }
            if (self::$creatTable) {
                if (!model::tableExist(self::$tableName . $serviceId . '_' . $serviceType))
                    return self::json(null);
                $count = model::searching([$objectId, $objectType], 'objectId = ? and objectType = ?', self::$tableName . $serviceId . '_' . $serviceType);
                if ($count == null) {
                    $insertRow['objectId'] = $objectId;
                    $insertRow['objectType'] = $objectType;
                    $result = model::insert(self::$tableName . $serviceId . '_' . $serviceType, $insertRow);
                } else {
                    $result = model::update(self::$tableName . $serviceId . '_' . $serviceType, $insertRow, 'objectId = ? and objectType = ?', [$objectId, $objectType]);
                }
                if (!$result) {
                    model::rollback();
                    return self::jsonError(rlang('canNotInsertFieldValueRow'), 500);
                }
            }
            model::commit();
            return self::json(null);
        }
        return self::json(null);
    }

    public static function showFilledOutForm($serviceId, $serviceType, $objectId, $objectType, $statusNotBe = null)
    {
        if (!self::$creatTable) {
            /* @var fieldvalue $fieldValueModel */
            $fieldValueModel = self::model('fieldvalue');
            $fieldsFill = [];
            $fieldsFillTemp = $fieldValueModel->search([$objectId, $objectType], 'objectId = ? and objectType = ? ', 'fieldvalue');
            if (is_array($fieldsFillTemp))
                foreach ($fieldsFillTemp as $fieldFill) {
                    $fieldsFill[$fieldFill['fieldId']] = $fieldFill;
                }
            unset($fieldsFillTemp);

            $allFields = self::getFieldsToEdit($serviceId, $serviceType, $statusNotBe, true, array_keys($fieldsFill));
            if (is_array($allFields['result']))
                foreach ($allFields['result'] as $index => $allField)
                    if (isset($fieldsFill[$allField['fieldId']]))
                        $allFields['result'][$index]['value'] = $fieldsFill[$allField['fieldId']]['value'];

        } else {
            if (!model::tableExist(self::$tableName . $serviceId . '_' . $serviceType))
                return self::json(null);
            $fieldsFill = model::searching([$objectId, $objectType], 'objectId = ? and objectType = ? ', self::$tableName . $serviceId . '_' . $serviceType);
            if ($fieldsFill == null) {
                $allFields = self::getFieldsToEdit($serviceId, $serviceType, $statusNotBe, true);
            } else
                $allFields = self::getFieldsToEdit($serviceId, $serviceType, $statusNotBe, true, array_keys($fieldsFill));
            if (is_array($allFields['result']))
                foreach ($allFields['result'] as $index => $allField)
                    if (isset($fieldsFill[0]['f_' . $allField['fieldId']]))
                        $allFields['result'][$index]['value'] = $fieldsFill[0]['f_' . $allField['fieldId']];

        }
        return self::json($allFields['result']);
    }

    public static function showFilledOutValue($fieldIds, $serviceId, $serviceType, $objectId, $objectType, $statusNotBe = null)
    {
        if ($fieldIds == null)
            return self::showFilledOutForm($serviceId, $serviceType, $objectId, $objectType, $statusNotBe);
        elseif (is_array($fieldIds)) {
            $fieldId = $fieldIds;
        } else {
            $fieldId = explode(',', $fieldIds);
        }
        if (count($fieldId) == 0)
            return self::showFilledOutForm($serviceId, $serviceType, $objectId, $objectType, $statusNotBe);
        $allFields = [];
        if (!self::$creatTable) {
            /* @var fieldvalue $fieldValueModel */
            $fieldValueModel = self::model('fieldvalue');
            $fieldsFill = [];
            $fieldsFillTemp = $fieldValueModel->search(array_merge([$objectId, $objectType], $fieldId), 'objectId = ? and objectType = ? and fieldId In (' . substr(str_repeat(',?', count($fieldId)), 1) . ') ', 'fieldvalue');
            if (is_array($fieldsFillTemp))
                foreach ($fieldsFillTemp as $fieldFill) {
                    $fieldsFill[$fieldFill['fieldId']] = $fieldFill['value'];
                }
            unset($fieldsFillTemp);

            $allFieldsBig = self::getFieldsToEdit($serviceId, $serviceType, $statusNotBe, true, $fieldId);
            if (is_array($allFieldsBig['result']))
                foreach ($allFieldsBig['result'] as $index => $allField)
                    if (isset($fieldsFill[$allField['fieldId']]))
                        $allFields[$allField['title']] = $fieldsFill[$allField['fieldId']];

        } else {
            if (!model::tableExist(self::$tableName . $serviceId . '_' . $serviceType))
                return self::json(null);
            $fieldsFill = model::searching([$objectId, $objectType], 'objectId = ? and objectType = ? ', self::$tableName . $serviceId . '_' . $serviceType, 'f_' . implode(',f_', $fieldId));
            $allFieldsBig = self::getFieldsToEdit($serviceId, $serviceType, $statusNotBe, true, $fieldId);
            if (is_array($allFieldsBig['result']))
                foreach ($allFieldsBig['result'] as $index => $allField)
                    if (isset($fieldsFill[0]['f_' . $allField['fieldId']]))
                        $allFields[$allField['title']] = $fieldsFill[0]['f_' . $allField['fieldId']];

        }
        return self::json($allFields);
    }


    private static function generateQueryCreatTable($tableName, $configDataBase = null)
    {
        if ($configDataBase == null)
            $configDataBase = require payment_path . 'core' . DIRECTORY_SEPARATOR . 'config.php';
        $query = 'CREATE TABLE IF NOT EXISTS `' . $configDataBase['_dbTableStartWith'] . $tableName . '` (' . chr(10);
        $query .= '  `objectId`  INT NOT NULL ,' . chr(10);
        $query .= '  `objectType`  VARCHAR(65) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL ' . chr(10);
        $query .= ') ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;' . chr(10) . chr(10);
        return $query;
    }

    private static function addToTable($tableName, $ids, $configDataBase = null)
    {
        if (!is_array($ids)) {
            $ids = (array)$ids;
        }
        if (count($ids) == null) return false;

        if ($configDataBase == null)
            $configDataBase = require payment_path . 'core' . DIRECTORY_SEPARATOR . 'config.php';
        $query = 'ALTER TABLE `' . $configDataBase['_dbTableStartWith'] . $tableName . '` ' . chr(10);
        $query .= 'ADD `f_' . implode('` TEXT CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL ,' . chr(10) . 'ADD `f_', $ids) . '` TEXT CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL ;';
        return $query;
    }

    private static function deleteFromTable($tableName, $ids, $configDataBase = null)
    {
        if (!is_array($ids)) {
            $ids = (array)$ids;
        }
        if (count($ids) == null) return false;

        if ($configDataBase == null)
            $configDataBase = require payment_path . 'core' . DIRECTORY_SEPARATOR . 'config.php';
        $query = 'ALTER TABLE `' . $configDataBase['_dbTableStartWith'] . $tableName . '` ' . chr(10);
        $query .= 'DROP `f_' . implode('` ,' . chr(10) . 'DROP `f_', $ids) . '` ;';
        return $query;
    }
}
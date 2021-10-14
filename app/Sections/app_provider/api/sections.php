<?php

namespace App\Sections\app_provider\api;

use App\api\controller\innerController;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class sections extends innerController
{
    public static function index($ids = null)
    {
        $value = array();
        $variable = array();
        if ($ids != null){
            $value = array_merge($value,$ids);
            $variable[] = ' item.id IN ( ' . substr(str_repeat('? ,', count($ids)), 0, -1) . ')';
        }
        /** @var \App\Sections\model\sections $model */
        $model = parent::model(['Sections', 'sections']);
        return self::json($model->getItems($value,$variable));
    }

    public static function getSectionModelById($id)
    {
        /** @var \App\Sections\model\sections $model */
        $model = parent::model(['Sections', 'sections'], $id);
        return $model;
    }
}
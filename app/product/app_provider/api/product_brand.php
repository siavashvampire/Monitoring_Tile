<?php

namespace App\product\app_provider\api;

use App\api\controller\innerController;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class product_brand extends innerController
{
    public static function index()
    {
        /** @var \App\product\model\product_brand $model */
        $model = parent::model(['product', 'product_brand']);
        return self::json($model->getItems());
    }

    public static function getByUsersId($UserId)
    {
        /** @var \App\product\model\product_brand $model */
        $model = parent::model(['product', 'product_brand']);
        return self::json($model->getByUsersId($UserId));
    }

    public static function getById($id, $justLabel = true)
    {
        /** @var \App\product\model\product_brand $model */
        $model = parent::model(['product', 'product_brand'], $id);
        if ($justLabel)
            return self::json($model->getLabel());
        else
            return $model;
    }
}
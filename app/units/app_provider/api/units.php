<?php

namespace App\units\app_provider\api;

use App\api\controller\innerController;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class units extends innerController
{
    public static function index(): array
    {
        $value = array();
        $variable = array();
        $value[] = '-1';
        $variable[] = 'item.id <> ?';
        $value[] = '-2';
        $variable[] = 'item.id <> ?';
        $value[] = '-3';
        $variable[] = 'item.id <> ?';
        $value[] = '-4';
        $variable[] = 'item.id <> ?';
        return self::json(parent::model(['units', 'units'])->getItems($value, $variable));
    }

    public static function all(): array
    {
        return self::json(parent::model(['units', 'units'])->getItems());
    }

    public function getById($ids): array
    {
        if (!is_array($ids))
            $ids = explode(',', $ids);
        $data = array();
        $model = parent::model(['units', 'units']);
        foreach ($ids as $id)
            $data[] = $model->getById($id)[0];
        return self::json($data);
    }
}
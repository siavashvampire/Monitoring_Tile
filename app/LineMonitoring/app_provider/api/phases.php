<?php
namespace App\LineMonitoring\app_provider\api;

use App\api\controller\innerController;

if ( !defined( 'paymentCMS' ) ) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class phases extends innerController {
    public  static function index($ids = null): array
    {
        $value = array();
        $variable = array();
        if ($ids != null){
            $value = array_merge($value,$ids);
            $variable[] = ' item.id IN ( ' . substr(str_repeat('? ,', count($ids)), 0, -1) . ')';
        }

       $value[] = '-4';
       $variable[] = 'item.id <> ?';
        return self::json( parent::model( ['LineMonitoring', 'phases'] )->getItems($value,$variable));
    }
    public  static function all(): array
    {
        return self::json( parent::model( ['LineMonitoring', 'phases'] )->getItems());
    }
    public function getById($ids): array
    {

        if (!is_array($ids))
            $ids = explode(',', $ids);
        $data = array();
        $model = parent::model(['LineMonitoring', 'phases']);

        foreach ($ids as $id)
            $data[] = $model->getById($id)[0];
        return self::json($data);
    }
}
<?php
namespace App\post_design\app_provider\api;

use App\api\controller\innerController;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class contract extends innerController {
	public static function getEvaluationType($jsonFlag = true): array
    {
        $data = self::model(['post_design', 'post_type'])->search([1], '?', null, '*', ['column' => 'id', 'type' => 'asc']);
        if ($jsonFlag)
            return self::json($data);
        else
            return $data;
    }
	public static function getEvaluationTypeByEvaluatedGroup($evaluatedGroup,$jsonFlag = true): array
    {
        $data = self::model(['post_design', 'post_type'])->search([$evaluatedGroup], 'evaluatedGroup = ?', null, '*', ['column' => 'id', 'type' => 'asc']);
        if ($jsonFlag)
            return self::json($data);
        else
            return $data;
    }
}



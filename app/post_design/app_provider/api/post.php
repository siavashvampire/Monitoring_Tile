<?php

namespace App\post_design\app_provider\api;

use App\api\controller\innerController;
use App\core\controller\httpErrorHandler;
use App\post_design\model\post_data;
use App\post_design\model\post_type;
use paymentCms\component\request;
use paymentCms\component\Response;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class post extends innerController
{
    public static function getEvaluationType($jsonFlag = true)
    {
        /** @var post_type $data */
        $data = self::model(['post_design', 'post_type'])->search([1], '?', null, '*', ['column' => 'id', 'type' => 'asc']);
        if ($jsonFlag)
            return self::json($data);
        else
            return $data;
    }

    public static function getEvaluationTypeByEvaluatedGroup($evaluatedGroup, $jsonFlag = true)
    {
        /** @var post_type $data */
        $data = self::model(['post_design', 'post_type'])->search([$evaluatedGroup], 'evaluatedGroup = ?', null, '*', ['column' => 'id', 'type' => 'asc']);
        if ($jsonFlag)
            return self::json($data);
        else
            return $data;
    }

    public function changeFinish($id = null)
    {
        $get = request::post('id');

        if ($get['id'] != '') {
            $id = $get['id'];
        }

        if ($id == null)
            return self::json(['status' => false, 'message' => 'کد یکتا وارد نشده']);


        /* @var post_data $eval_data */
        $eval_data = $this->model(['post_design', 'post_data'], $id);

        if ($eval_data->getId() != $id)
            return self::json(['status' => false, 'message' => 'کد یکتا وارد نشده']);

        $message = 'وضعیت فرم ';
        $message .= $eval_data->getEvaluatedPersonName();
        $message .= ' به ';

        if ($eval_data->getFinished()) {
            $message .= ' ناتمام ';
            $eval_data->setFinished(0);
        }
        else {
            $message .= ' تمام ';
            $eval_data->setFinished(1);
        }
        $message .= 'تغییر یافت';

        $eval_data->upDateDataBase();
        return self::json(['status' => true, 'message' => $message]);
    }
}



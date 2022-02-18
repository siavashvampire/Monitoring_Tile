<?php

namespace App\product\app_provider\admin;

use App\product\model\grading_statistics_space;
use App\user\app_provider\api\checkAccess;
use App\user\app_provider\api\user;
use controller;
use paymentCms\component\JDate;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class disadvantages extends controller
{
    private $item_label = "آمار معایب";
    private $log_name = 'disadvantages';
    private $model_name = 'disadvantages';
    private $controller_name = 'disadvantages';
    private $app_name = 'product';
    private $active_menu = 'disadvantages';
    private $html_file_path = 'disadvantages';

    public function index(): bool
    {
        /* @var \App\product\model\grading_statistics $model */
        $get = request::post('page=1,perEachPage=25,product_id,StartTime,EndTime');
        $rules = [
            "page" => ["required|match:>0", rlang('page')],
            "perEachPage" => ["required|match:>0|match:<501", rlang('page')],
        ];
        $valid = validate::check($get, $rules);
        $value = array();
        $variable = array();
        if ($valid->isFail()) {
            Response::jsonMessage($valid->errorsIn(), false);
            return false;
        } else {
            if ($get['product_id'] != null) {
                $value[] = $get['product_id'];
                $variable[] = 'item.product_id = ? ';
            }
            if ( $get['StartTime'] != null and $get['EndTime'] == null) {
                $value[] = date('Y-m-d H:i:s' , $get['StartTime'] / 1000 ) ;
                $variable[] = ' item.routine_date > ? ';
            } elseif ( $get['StartTime'] == null and $get['EndTime'] != null) {
                $value[] = date('Y-m-d H:i:s' , $get['EndTime'] / 1000 ) ;
                $variable[] = ' item.routine_date < ? ';
            } elseif ( $get['StartTime'] != null and $get['EndTime'] != null)  {
                $value[] = date('Y-m-d H:i:s' , $get['StartTime'] / 1000 ) ;
                $value[] = date('Y-m-d H:i:s' , $get['EndTime'] / 1000 ) ;
                $variable[] = ' (item.routine_date BETWEEN ? AND ?) ';
            }
        }

        $model = parent::model($this->model_name);
        $numberOfAll = $model->getCount($value, $variable);
        $pagination = parent::pagination($numberOfAll, $get['page'], $get['perEachPage']);
        $pagination = [$pagination['start'], $pagination['limit']];
        $kind_degree = (new \App\product\model\product_degree())->getItems();
        $products = (new \App\product\model\product())->getItems();
        $search = $model->getItems($kind_degree , $value, $variable, ['column' => 'id', 'type' => 'desc'], $pagination);
        $this->mold->path('default', $this->app_name);
        $this->mold->view($this->html_file_path.'/index.mold.html');
        $this->mold->setPageTitle(rlang('list') . " " . $this->item_label);
        $this->mold->set('activeMenu', $this->active_menu);
        $this->mold->set('items', $search);
        $this->mold->set('degrees', $kind_degree);
        $this->mold->set('products', $products);
        $this->mold->set('item_label', $this->item_label);
        $editAccess = checkAccess::index(user::getUserLogin()['user_group_id'], 'admin', $this->controller_name, 'update', $this->app_name)["status"];
        $this->mold->set('editAccess', $editAccess);
        $insertAccess = checkAccess::index(user::getUserLogin()['user_group_id'], 'admin', $this->controller_name, 'insert', $this->app_name)["status"];
        $this->mold->set('insertAccess', $insertAccess);
        return false;
    }

    public function insert(){
        return $this->edit(0);
    }

    public function edit($id){
        $kind_degree = (new \App\product\model\product_degree())->getItems();
        $products = (new \App\product\model\product())->getItems();
        $novancs = (new \App\product\model\product_novanc())->getItems();
        $object = new \App\product\model\grading_statistics($id);
        if ( request::isPost('product_id'))
            $this->update($id , $object);
        if ( $object != null ){
            $spaces = (new \App\product\model\grading_statistics_space())->getItems([$object->getId()] , ['grading_statistic_id = ?']);
            $this->mold->set('spaces', $spaces);
        }
        $this->mold->path('default', $this->app_name);
        $this->mold->view($this->html_file_path.'/edit.mold.html');
        $this->mold->setPageTitle(rlang($id > 0 ? 'edit' : 'insert') . " " . $this->item_label);
        $this->mold->set('activeMenu', $this->active_menu);
        $this->mold->set('degrees', $kind_degree);
        $this->mold->set('products', $products);
        $this->mold->set('novancs', $novancs);
        $this->mold->set('model', $object);
        $this->mold->set('item_label', $this->item_label);
        return false;
    }

    private function update($id , $object){
        /* @var \App\product\model\grading_statistics $object */
        $data = request::post('product_id,novance_id,date,degree');
        $shamsi = explode('/', $data['date']);
        $miladi = JDate::jalali_to_gregorian($shamsi[0], $shamsi[1], $shamsi[2], '-');
        $object->setProductId($data['product_id']);
        $object->setNovancId($data['novance_id']);
        $object->setRoutineDate($miladi);
        $object->setInsertId(user::getUserLogin(true));
        $space = new grading_statistics_space();
        if ( $id == 0 ){
            $object->setInsertDate(date('Y-m-d'));
            $id = $object->insertToDataBase();
            if ( $id == false ){
                $this->alert('warning' , null,rlang('pleaseTryAGain'),'error');
                return false;
            }
        } else {
            if ( ! $object->upDateDataBase() ) {
                $this->alert('warning' , null,rlang('pleaseTryAGain'),'error');
                return false;
            }
            $space->deleteOnFullQuery([$id],'grading_statistic_id = ?');
        }
        $space->setGradingStatisticId($id);
        foreach ($data['degree'] as $id => $spaceF){
            $space->setSpace(round($spaceF,2));
            $space->setDegreeId($id);
            $space->insertToDataBase();
        }
        Response::redirect(\app::getBaseAppLink('grading_statistics'));
        return true;
    }


}
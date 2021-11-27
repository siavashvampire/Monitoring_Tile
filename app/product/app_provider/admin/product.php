<?php

namespace App\product\app_provider\admin;

use App;
use App\core\controller\httpErrorHandler;
use App\LineMonitoring\app_provider\api\phases;
use App\Sections\app_provider\api\sections;
use App\user\app_provider\api\checkAccess;
use App\user\app_provider\api\user;
use controller;
use paymentCms\component\JDate;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class product extends controller
{
    private $item_label = "کاشی";
    private $ChangeURL = "product";
    private $PDFURL = "product/getPDF";
    private $listChangeURL = "product/list";
    private $log_name = 'product';
    private $model_name = 'product';
    private $app_name = 'product';
    private $class_name = 'product';
    private $active_menu = 'product';
    private $list_html_file_path = 'product_list.mold.html';
    private $html_file_path = 'product.mold.html';
    private $certificate_html_file_path = 'CertificatePdf.mold.html';

    public function list(): bool
    {
        /* @var App\product\model\product $model */
        $get = request::post('page=1,perEachPage=25');
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
            if ($get['label'] != null) {
                $value[] = '%' . $get['name'] . '%';
                $variable[] = 'item.label Like ? ';
            }
        }

        $model = parent::model($this->model_name);
        $numberOfAll = ($model->search($value, (count($variable) == 0) ? null : implode(' and ', $variable), null, 'COUNT(id) as co')) [0]['co'];
        $pagination = parent::pagination($numberOfAll, $get['page'], $get['perEachPage']);
        $search = $model->search($value, ((count($variable) == 0) ? null : implode(' and ', $variable)), null, '*', ['column' => 'label', 'type' => 'asc'], [$pagination['start'], $pagination['limit']]);
        $this->mold->path('default', $this->app_name);
        $this->mold->view($this->list_html_file_path);
        $this->mold->setPageTitle(rlang('list') . " " . $this->item_label);
        $this->mold->set('activeMenu', $this->active_menu);
        $this->mold->set('items', $search);
        $this->mold->set('item_label', $this->item_label);
        $this->mold->set('ChangeURL', $this->ChangeURL);
        $this->mold->set('PDFURL', $this->PDFURL);
        $editAccess = checkAccess::index(user::getUserLogin()['user_group_id'], 'admin', $this->class_name,
            'index', $this->app_name)["status"];
        $this->mold->set('editAccess', $editAccess);
        return false;
    }

    public function index($id = null): bool
    {
        /* @var App\product\model\product $model */
        if ($id != null) {
            $model = parent::model($this->model_name, $id);
            if ($model->getId() != $id) {
                httpErrorHandler::E404();
                return false;
            }
            $this->mold->set('model', $model);
        } else
            $model = parent::model($this->model_name);
        if (request::ispost()) {
            $get = request::post('label,color,exampleCode,phase,size,template,kind,technique,effect,decor,production_design_code,body,body_weight,engobe,engobe_weight,glaze,glaze_weight');
            $rules = [
                "label" => ["required", rlang('name') . " " . $this->item_label],
                "production_design_code" => ["required|match:>0", rlang('code') . " " . rlang('example') . " " . rlang('experiment')],
                "exampleCode" => ["required|match:>0", rlang('code') . " " . rlang('design') . " " . rlang('production')],
            ];
            $valid = validate::check($get, $rules);
            $GLOBALS['timeStart'] = '';
            if ($valid->isFail()) {
                Response::jsonMessage($valid->errorsIn(), false);
                return false;
            }

            $Dis = $this->item_label . " " . rlang('with') . " " . rlang('name') . " ";
            $Dis .= $model->getLabel() . " ";

            $model->setLabel($get['label']);
            $model->setColor($get['color']);
            $model->setExampleCode($get['exampleCode']);
            $model->setProductionDesignCode($get['production_design_code']);
            $model->setPhase($get['phase']);
            $model->setSize($get['size']);
            $model->setTemplate($get['template']);
            $model->setKind($get['kind']);
            $model->setTechnique($get['technique']);
            $model->setEffect($get['effect']);
            $model->setDecor($get['decor']);
            $model->setBody($get['body']);
            $model->setBodyWeight($get['body_weight']);
            $model->setEngobe($get['engobe']);
            $model->setEngobeWeight($get['engobe_weight']);
            $model->setGlaze($get['glaze']);
            $model->setGlazeWeight($get['glaze_weight']);

            if ($id != null) {
                if ($model->upDateDataBase()) {
                    $Dis .= rlang('be') . " " . $this->item_label . " " . rlang('with') . " " . rlang('name') . " ";
                    $Dis .= $model->getlabel() . " ";
                    $Dis .= rlang('changed');
                    Response::redirect(App::getBaseAppLink($this->class_name . '/list/', 'admin'));
                    $this->callHooks('addLog', [$Dis, $this->log_name]);
                } else {
                    $this->alert('danger', '', 'رید');
                }

            } else {
                if ($model->insertToDataBase()) {
                    $Dis .= $model->getLabel() . " ";
                    $Dis = $Dis . rlang('inserted');
                    Response::redirect(App::getBaseAppLink($this->class_name . '/list/', 'admin'));
                    $this->callHooks('addLog', [$Dis, $this->log_name]);
                } else {
                    $this->alert('danger', '', 'رید');
                }
            }

        }
        $this->mold->path('default', $this->app_name);
        $this->mold->view($this->html_file_path);
        if ($id == null)
            $this->mold->setPageTitle(rlang('insert') . " " . $this->item_label);
        else
            $this->mold->setPageTitle(rlang('Edit') . " " . $this->item_label);

        $this->mold->set('ChangeURL', $this->listChangeURL);
        $this->mold->set('item_label', $this->item_label);
        $editAccess = checkAccess::index(user::getUserLogin()['user_group_id'], 'admin', $this->class_name, 'list', $this->app_name)["status"];
        $this->mold->set('editAccess', $editAccess);
        $this->mold->set('activeMenu', $this->active_menu);
        $this->mold->set('item_label', $this->item_label);
        $this->mold->set('colors', App\product\app_provider\api\product::color()["result"]);
        $this->mold->set('phases', phases::index()["result"]);
        $this->mold->set('sizes', App\product\app_provider\api\product::size()["result"]);
        $this->mold->set('templates', App\product\app_provider\api\product::template()["result"]);
        $this->mold->set('kinds', App\product\app_provider\api\product::kind()["result"]);
        $this->mold->set('techniques', App\product\app_provider\api\product::technique()["result"]);
        $this->mold->set('glazeParents', App\product\app_provider\api\product::glazeParents()["result"]);
        $this->mold->set('glazes', App\product\app_provider\api\product::glazeChild()["result"]);
        $this->mold->set('effects', App\product\app_provider\api\product::effect()["result"]);
        $this->mold->set('decors', App\product\app_provider\api\product::decor()["result"]);
        $this->mold->set('engobes', App\product\app_provider\api\product::engobe()["result"]);
        $this->mold->set('bodys', App\product\app_provider\api\product::body()["result"]);

        return false;
    }

    public function getPDF($id)
    {
        $this->mold->path('default', $this->app_name);
        $this->mold->view($this->certificate_html_file_path);
        $this->mold->setPageTitle(rlang('list') . " " . $this->item_label);
        $this->mold->set('activeMenu', $this->active_menu);
        $views = $this->mold->getViews();
        $this->mold->unshow($views);

        /** @var \App\product\model\product $model */
        $model = parent::model($this->model_name, $id);
        $this->mold->set('model', $model);
        $this->mold->set('date', JDate::jdate('Y/m/d'));

        $file_name = "بخش ";

        $this->mold->setPageTitle('گزارش گیری خدمات');
        $this->mold->unshow('footer.mold.html');
        $htmlpersian = $this->mold->render();
//        show($htmlpersian);
        $this->callHooks('makePDF', ['htmlpersian' => $htmlpersian, 'nameOfFile' => $file_name, 'landscape' => false, 'type' => 'A4', 'font_size' => 12]);
    }
}
<?php

namespace App\post_design;

use app;
use App\core\controller\fieldService;
use App\product\model\product_kind;
use App\user\app_provider\api\user;
use paymentCms\component\cache;
use paymentCms\component\model;
use pluginController;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class hook extends pluginController
{
    public function _adminHeaderNavbar($vars2)
    {
        $this->menu->after('users', 'postTab', 'نامه', "#", 'fa fa-file-text-o', '', null, 'admin/post/list/post_design');
        $this->menu->addChild('postTab', 'post', 'فرم ساز', app::getBaseAppLink('post/newType', 'admin'), 'fa fa-id-badge', '', 'admin/post/newType/post_design');
        $this->menu->addChild('postTab', 'post_list', 'لیست نامه ها', app::getBaseAppLink('post/list', 'admin'), 'fa fa-list-ol', '', 'admin/post/list/post_design');
        $this->menu->addChild('postTab', 'post_insert', 'ثبت نامه جدید', app::getBaseAppLink('post', 'admin'), 'fa fa-check-square-o', '', 'admin/post/index/post_design');
        $user = user::getUserLogin();
        $contractsVote = model::searching([$user['userId']], ' userId	= ? and fillOutDate is null', 'contracts_vote', '*');

//        if ($contractsVote !== true and count($contractsVote) > 0) {
//            $this->mold->set('firstFillOutId', $contractsVote[0]['fillOutId']);
//            $this->mold->set('firstFillOutIdCount', count($contractsVote));
//
//            $getPath = $this->mold->getPath();
//            $this->mold->path('default', 'post_design');
//            $this->mold->view('newVote.admin.hook.mold.html');
//            $this->mold->path($getPath['folder'], $getPath['app']);
//        }
    }

    public function _settingFooter()
    {
        $getPath = $this->mold->getPath();
        $this->mold->path('default', 'post_design');
        $Groups = user::getGroups()["result"];
        $fieldsOf = [];
        if (is_array($Groups)) {
            foreach ($Groups as $group) {
                $fieldsOf[] = ['name' => $group['name'], 'groupId' => $group['user_groupId']];
            }
        }
        $this->mold->set('listGroups', $fieldsOf);

        $this->mold->view('configuration.system.mold.html');
        $this->mold->path($getPath['folder'], $getPath['app']);
        $this->mold->set('dirStartUP', payment_path . 'startup');
    }
}
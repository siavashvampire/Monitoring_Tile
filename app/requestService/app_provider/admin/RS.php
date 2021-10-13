<?php

namespace App\requestService\app_provider\admin;

use App;
use App\core\controller\fieldService;
use App\LineMonitoring\app_provider\api\phases;
use App\user\app_provider\api\user;
use App\requestService\model\requestService;
use App\Sections\app_provider\api\sections;
use App\requestService\app_provider\api\request_service;
use controller;
use paymentCms\component\JDate;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\validate;
use paymentCms\component\Response;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class RS extends controller
{
    public function index($requestId = null)
    {
        $RequestAdmin = $this->setting('RequestAdmin');
        $this->mold->set('RequestAdmin', $RequestAdmin);

        $Person_id = user::getUserLogin(true);
        $user = user::getUserLogin(false);

        $fields = fieldService::showFilledOutFormWithAllFields($user['user_group_id'], 'user_register', $user['userId'], 'user_register', true);
        $section = false;
        $phase = false;
        if (is_array($fields['result'])) {
            foreach ($fields['result'] as $index => $fields) {
                if ($fields['type'] == 'fieldCall_Sections_sections') {
                    $section = $fields['value'];
                } elseif ($fields['type'] == 'fieldCall_LineMonitoring_phase') {
                    $phase = $fields['value'];
                }
                if ($phase and $section) break;
            }
        }

        if ($requestId != null) {
            $requestService = parent::model('requestService', $requestId);

            if ($requestService->getRequestId() != $requestId or (!($requestService->getUnitPersonId() == $Person_id) and $user['user_group_id'] != $RequestAdmin and $user['user_group_id'] != 1)) {
                if ((!($phase == $requestService->getPhase() or $section == $requestService->getSection())) and $user['user_group_id'] != $this->setting('supervisor'))

                    httpErrorHandler::E404();
                return false;
            }

            $requestService->setCost(explode(',', $requestService->getCost()));
            $requestService->setWorkTitle(explode(',', $requestService->getWorkTitle()));
            $requestService->setBugInfluence(explode(',', $requestService->getBugInfluence()));
//            $requestService->setWorkerSection(explode(',',$requestService->getWorkerSection()));
            $this->mold->set('requestService', $requestService);
        } else
            $requestService = parent::model('requestService');

        $get = request::post('Line,Cost,Workersection,System_Status,WorkTitle,BugInfluence,Sender_note', null);

        $value = array();
        $variable = array();
        /* @var \app\requestService\model\requestService $model */

        $this->mold->set('phases', phases::index()["result"]);
        $this->mold->set('Workersections', sections::index() ["result"]);
        $this->mold->set('BugInfluences', request_service::buginfluence() ["result"]);
        $this->mold->set('worktitles', request_service::worktitle() ["result"]);
        $this->mold->set('system_statuses', request_service::system_status() ["result"]);
        $this->mold->set('costs', request_service::cost() ["result"]);


        if ($section or $user['user_group_id'] == $RequestAdmin or $user['user_group_id'] == 1) {
            if ($section == null and $user['user_group_id'] != $RequestAdmin and $user['user_group_id'] != 1) {
                $this->alert('danger', '', "واحدی برای شما ثبت نشده");
            } else {
                if (request::ispost()) {
                    if ($phase == null) {
                        $this->alert('warning', '', "فازی برای شما ثبت نشده");
                    } else {
                        $requestService->setPhase($phase);
                    }
                    $requestService->setLine($get['Line']);
                    $requestService->setSection($section);
                    $requestService->setCost(',' . implode(',', $get['Cost']) . ',');
//                $requestService->setWorkerSection(',' . implode(',',$get['Workersection']) . ',');
                    $requestService->setWorkerSection($get['Workersection']);
                    $requestService->setSystemStatus($get['System_Status']);
                    $requestService->setWorkTitle(',' . implode(',', $get['WorkTitle']) . ',');
                    $requestService->setBugInfluence(',' . implode(',', $get['BugInfluence']) . ',');
                    $requestService->setUnitPersonId(user::getUserLogin(true));
                    $requestService->setTime_Send(date('Y-m-d H:i:s'));
                    $requestService->setSenderNote($get['Sender_note']);

                    $section = $this->model('sections', $requestService->getSection());
                    $Workersection = $this->model('sections', $requestService->getWorkerSection());
                    $Dis = 'درخواست واحد  ';
                    $Dis = $Dis . $section->getName();
                    $Dis = $Dis . ' برای واحد  ';
                    $Dis = $Dis . $Workersection->getName();
                    if ($requestService->insertToDataBase()) {
                        Response::redirect(App::getBaseAppLink('RS/Send_lists', 'admin'));
                        $Dis = $Dis . ' ثبت شد';
                        $this->callHooks('addLog', [$Dis, 'RequestService']);
                        $this->alert('success', '', "ثبت درخواست با موفقیت انجام شد");
                    } else {
                        $this->alert('danger', '', "ثبت درخواست با مشکلی مواجه شده است");
                    }
                }

                $this->mold->path('default', 'requestService');
                $this->mold->view('requestService.mold.html');
                $this->mold->setPageTitle('درخواست خدمات');
                $this->mold->set('activeMenu', 'requestService');
            }
        } else {
            $this->alert('danger', '', "شما سمت مناسبی برای استفاده از این بخش ندارید");
        }
    }

    public function Send_lists()
    {
        $RequestAdmin = $this->setting('RequestAdmin');
        $this->mold->set('RequestAdmin', $RequestAdmin);
        $get = request::post('page=1,perEachPage=25,StartTime,EndTime,phase,sortWith', null);
        $rules = [
            "page" => ["required|match:>0", rlang('page')],
            "perEachPage" => ["required|match:>0|match:<501", rlang('page')],
        ];
        $valid = validate::check($get, $rules);
        $value = array();
        $variable = array();
        $sortWith = ['column' => 'Time_Send', 'type' => 'desc'];

        /** @var requestService $requestService */
        $requestService = parent::model('requestService');


        $user = user::getUserLogin(false);
        $fields = fieldService::showFilledOutFormWithAllFields($user['user_group_id'], 'user_register', $user['userId'], 'user_register', true);
        $section = null;
        $phase = null;

        if (is_array($fields['result'])) {
            foreach ($fields['result'] as $index => $fields) {
                if ($fields['type'] == 'fieldCall_Sections_sections') {
                    $section = $fields['value'];
                } elseif ($fields['type'] == 'fieldCall_LineMonitoring_phase') {
                    $phase = $fields['value'];
                }
                if ($phase and $section) break;
            }
        }

        if ($section) {
            $value[] = '%' . $section . '%';
            $variable[] = 'reSer.section Like ?';
            $numberOfAll = $requestService->getCount($value, $variable);
            $pagination = parent::pagination($numberOfAll, $get['page'], $get['perEachPage']);
            $requestServices = $requestService->getItemsBySection($section, $sortWith, $pagination);
        } elseif ($user['user_group_id'] == $RequestAdmin or $user['user_group_id'] == 1) {
            $numberOfAll = $requestService->getCount();
            $pagination = parent::pagination($numberOfAll, $get['page'], $get['perEachPage']);
            $pagination = [$pagination["start"], $pagination["limit"]];
            $requestServices = $requestService->getItems(array(), array(), $sortWith, $pagination);
        } else {
            $this->alert('danger', '', "شما سمت مناسبی برای استفاده از این بخش ندارید");
        }


        $this->mold->set('requestServices', $requestServices);
        $this->mold->path('default', 'requestService');
        $this->mold->view('requestServiceList_Send.mold.html');
        $this->mold->setPageTitle('نمایش خدمات');
        $this->mold->set('activeMenu', 'requestServiceList_Send');

        $this->mold->set('phases', phases::index([$phase])["result"]);
        $this->mold->set('sections', sections::index([$section]) ["result"]);

    }

    public function Received_lists()
    {
        $RequestAdmin = $this->setting('RequestAdmin');
        $this->mold->set('RequestAdmin', $RequestAdmin);
        $get = request::post('page=1,perEachPage=25,StartTime,EndTime,phase,sortWith', null);

        $rules = [
            "page" => ["required|match:>0", rlang('page')],
            "perEachPage" => ["required|match:>0|match:<501", rlang('page')],
        ];
        $valid = validate::check($get, $rules);
        $value = array();
        $variable = array();
        $sortWith = ['column' => 'Time_Send', 'type' => 'desc'];

        /** @var requestService $requestService */
        $requestService = parent::model('requestService');

        $this->mold->set('phases', phases::index()["result"]);
        $this->mold->set('sections', sections::index() ["result"]);

        $user = user::getUserLogin(false);
        $fields = fieldService::showFilledOutFormWithAllFields($user['user_group_id'], 'user_register', $user['userId'], 'user_register', true);
        $section = false;
        $phase = false;
        if (is_array($fields['result'])) {
            foreach ($fields['result'] as $index => $fields) {
                if ($fields['type'] == 'fieldCall_Sections_sections') {
                    $section = $fields['value'];
                } elseif ($fields['type'] == 'fieldCall_LineMonitoring_phase') {
                    $phase = $fields['value'];
                }
                if ($section and $phase) break;
            }
        }

        if ($section) {
            $value[] = '%' . $section . '%';
            $variable[] = 'reSer.WorkerSection Like ?';
            $numberOfAll = $requestService->getCount($value, $variable);
            $pagination = parent::pagination($numberOfAll, $get['page'], $get['perEachPage']);
            $requestServices = $requestService->getItemsByWorkerSection($section, $sortWith, $pagination);
        } elseif ($user['user_group_id'] == $RequestAdmin or $user['user_group_id'] == 1) {
            $numberOfAll = $requestService->getCount();
            $pagination = parent::pagination($numberOfAll, $get['page'], $get['perEachPage']);
            $requestServices = $requestService->getItems(array(), array(), $sortWith, $pagination);
        } else {
            $this->alert('danger', '', "شما سمت مناسبی برای استفاده از این بخش ندارید");
        }

        $this->mold->set('requestServices', $requestServices);
        $this->mold->path('default', 'requestService');
        $this->mold->view('requestServiceList_Received.mold.html');
        $this->mold->setPageTitle('نمایش خدمات');
        $this->mold->set('activeMenu', 'requestServiceList_Received');

    }

    public function Ajax_View($requestId)
    {
        $Person_id = user::getUserLogin(true);
        $user = user::getUserLogin(false);
        if ($requestId != null) {
            $requestService = $this->model(['requestService', 'requestService'], $requestId);
            if ($requestService->getRequestId() != $requestId or !($requestService->getUnitPersonId() == $Person_id or $requestService->getworkerPerson_id() == $Person_id or $user['user_group_id'] == $this->setting('RequestAdmin') or $user['user_group_id'] == 1)) {

                $fields = fieldService::showFilledOutFormWithAllFields($user['user_group_id'], 'user_register', $user['userId'], 'user_register', true);
                $section = false;
                $phase = false;
                if (is_array($fields['result'])) {
                    foreach ($fields['result'] as $index => $fields) {
                        if ($fields['type'] == 'fieldCall_Sections_sections') {
                            $section = $fields['value'];
                        } elseif ($fields['type'] == 'fieldCall_LineMonitoring_phase') {
                            $phase = $fields['value'];
                        }
                        if ($phase and $section) break;
                    }
                }

                if ((!($phase == $requestService->getPhase() or $section == $requestService->getSection())) and $user['user_group_id'] != $this->setting('RequestAdmin') and $user['user_group_id'] != 1)

                    httpErrorHandler::E404();
                return false;
            }

            $Cost = explode(',', $requestService->getCost());
            $WorkerSection = explode(',', $requestService->getWorkerSection());
            $System_Status = explode(',', $requestService->getSystemStatus());
            $WorkTitle = explode(',', $requestService->getWorkTitle());
            $BugInfluence = explode(',', $requestService->getBugInfluence());

            $BugInfluences = $requestService->search($BugInfluence, 'id in (' . substr(str_repeat(', ? ', count($BugInfluence)), 1) . ')', 'requestService_buginfluence', '*', ['column' => 'id', 'type' => 'asc']);
            $this->mold->set('BugInfluences', array_column($BugInfluences, 'Title'));

            $worktitles = $requestService->search($WorkTitle, 'id in (' . substr(str_repeat(', ? ', count($WorkTitle)), 1) . ')', 'requestService_worktitle', '*', ['column' => 'id', 'type' => 'asc']);
            $this->mold->set('worktitles', array_column($worktitles, 'Title'));

            $system_statuses = $requestService->search($System_Status, 'id in (' . substr(str_repeat(', ? ', count($System_Status)), 1) . ')', 'requestService_system_status', '*', ['column' => 'id', 'type' => 'asc']);
            $this->mold->set('system_statuses', array_column($system_statuses, 'Title'));

            $costs = $requestService->search($Cost, 'id in (' . substr(str_repeat(', ? ', count($Cost)), 1) . ')', 'requestService_cost', 'Title', ['column' => 'id', 'type' => 'asc']);
            $this->mold->set('costs', array_column($costs, 'Title'));

            $WorkerSection = $requestService->search($WorkerSection, 'id in (' . substr(str_repeat(', ? ', count($WorkerSection)), 1) . ')', 'sections', 'Name', ['column' => 'id', 'type' => 'asc']);
            $this->mold->set('WorkerSection', array_column($WorkerSection, 'Name'));


//            $this->mold->set('user', $user);
            $this->mold->set('requestService', $requestService);
            $this->mold->path('default', 'requestService');
            $this->mold->view('requestServiceAjax.mold.html');
        }
    }

    public function adminService($requestId = null)
    {

        /** @var requestService $requestService */
        $user = user::getUserLogin(false);
        $RequestAdmin = $this->setting('RequestAdmin');
        $this->mold->set('RequestAdmin', $RequestAdmin);
        if ($user['user_group_id'] == $RequestAdmin or $user['user_group_id'] == 1) {
            if ($requestId != null) {
                $requestService = parent::model('requestService', $requestId);
                if ($requestService->getRequestId() != $requestId) {
                    httpErrorHandler::E404();
                    return false;
                }

                $requestService->setCost(explode(',', $requestService->getCost()));
                $requestService->setWorkTitle(explode(',', $requestService->getWorkTitle()));
                $requestService->setBugInfluence(explode(',', $requestService->getBugInfluence()));
                $requestService->setConsumablePartsQty(explode(',', substr($requestService->getConsumablePartsQty(), 1, strlen($requestService->getConsumablePartsQty()) - 2)));
                $requestService->setConsumableParts(explode(',', substr($requestService->getConsumableParts(), 1, strlen($requestService->getConsumableParts()) - 2)));
                //$requestService->setTime_Send(jdate::jdate('Y/m/d' , strtotime($requestService->getTime_Send())));
//                $requestService->setWorkerSection(explode(',',$requestService->getWorkerSection()));
                $this->mold->set('requestService', $requestService);
            } else

                /** @var requestService $requestService */
                $requestService = parent::model('requestService');

            $get = request::post('requestCode,Time_Send,Time_Send_justT,Time_Start,Time_End,System_Name,phase,ServiceSection,Line,Cost,Workersection,offTime,System_Status,WorkTitle,BugInfluence,Latency,LatencyTime,DoneworkDes,Donework,failureDes,failure,Sender_note,HumanNumber,PartName,PartQuantity', null);

            $this->mold->set('phases', phases::index()["result"]);
            $this->mold->set('Workersections', sections::index() ["result"]);
            $this->mold->set('BugInfluences', request_service::buginfluence() ["result"]);
            $this->mold->set('worktitles', request_service::worktitle() ["result"]);
            $this->mold->set('system_statuses', request_service::system_status() ["result"]);
            $this->mold->set('costs', request_service::cost() ["result"]);
            $this->mold->set('failures', request_service::failure() ["result"]);
            $this->mold->set('doneWork', request_service::doneWork() ["result"]);
            $this->mold->set('Latencys', request_service::latency() ["result"]);
            $this->mold->set('ServiceSections', sections::index() ["result"]);
            $this->mold->set('Parts', request_service::consumable_Parts() ["result"]);

            if (request::ispost()) {
                $shamsi = explode('/', $get['Time_Send']);
                $miladi = JDate::jalali_to_gregorian($shamsi[0], $shamsi[1], $shamsi[2], '/');

                $get['Time_Start'] = $get['Time_Start'] / 1000;
                $get['Time_End'] = $get['Time_End'] / 1000;
                $requestService->setRequestCode($get['requestCode']);
                $requestService->setTimeSend(date('Y-m-d H:i:s', strtotime(date('Y-m-d ', strtotime($miladi)) . date('H:i:00', strtotime($get['Time_Send_justT'])))));
                $requestService->setJTimeSend(JDate::jdate('Y-m-d', strtotime(date('Y-m-d ', strtotime($miladi)) . date('H:i:00', strtotime($get['Time_Send_justT'])))));
                $requestService->setTimeStart(date('Y-m-d H:i:s', $get['Time_Start']));
                $requestService->setTimeEnd(date('Y-m-d H:i:s', $get['Time_End']));
                $requestService->setSystemName($get['System_Name']);
                $requestService->setPhase($get['phase']);
                $requestService->setLine($get['Line']);
                $requestService->setSection($get['ServiceSection']);
                $requestService->setCost(',' . implode(',', $get['Cost']) . ',');

//                $requestService->setWorkerSection(',' . implode(',',$get['Workersection']) . ',');
                $requestService->setWorkerSection($get['Workersection']);
                $requestService->setOffTime($get['offTime']);
                $requestService->setSystemStatus($get['System_Status']);
                $requestService->setWorkTitle(',' . implode(',', $get['WorkTitle']) . ',');
                $requestService->setBugInfluence(',' . implode(',', $get['BugInfluence']) . ',');
                $requestService->setFailure($get['failure']);
                $requestService->setFailureDes($get['failureDes']);
                $requestService->setDonework($get['Donework']);
                $requestService->setDoneworkDes($get['DoneworkDes']);
                $requestService->setLatency($get['Latency']);
                $requestService->setLatencyTime($get['LatencyTime']);
                $requestService->setUnitPersonId(user::getUserLogin(true));
                $requestService->setSenderNote($get['Sender_note']);
                $requestService->setHumanNumber($get['HumanNumber']);
                $requestService->setConsumableParts(',' . implode(',', $get['PartName']) . ',');
                $requestService->setConsumablePartsQty(',' . implode(',', $get['PartQuantity']) . ',');

                $section = sections::getSectionModelById($requestService->getSection());
                $Workersection = sections::getSectionModelById($requestService->getWorkerSection());
                $Dis = 'درخواست واحد  ';
                $Dis = $Dis . $section->getLabel();
                $Dis = $Dis . ' برای واحد  ';
                $Dis = $Dis . $Workersection->getLabel();
                if ($requestId == null and $requestService->insertToDataBase()) {
                    $Dis = $Dis . ' ثبت شد';
                    $this->callHooks('addLog', [$Dis, 'RequestService']);
                    $this->alert('success', '', "ثبت درخواست با موفقیت انجام شد");
                    Response::redirect(App::getBaseAppLink('RS/Send_lists', 'admin'));
                } elseif ($requestId != null and $requestService->upDateDataBase()) {
                    $Dis = $Dis . ' تغییر یافت';
                    $this->callHooks('addLog', [$Dis, 'RequestService']);
                    $this->alert('success', '', "ویرایش درخواست با موفقیت انجام شد");
                    Response::redirect(App::getBaseAppLink('RS/Send_lists', 'admin'));
                } else {
                    $this->alert('danger', '', "ثبت درخواست با مشکلی مواجه شده است");
                }
            }
            $this->mold->path('default', 'requestService');
            $this->mold->view('requestServiceAdmin.mold.html');
            $this->mold->setPageTitle('درخواست خدمات');
            $this->mold->set('activeMenu', 'requestServiceAdmin');
        } else {
            $this->alert('danger', '', "شما سمت مناسبی برای استفاده از این بخش ندارید");
        }
    }

    public function OptimalService($requestId = null)
    {
        /* @var requestService $requestService */
        $user = user::getUserLogin(false);
        $RequestAdmin = $this->setting('RequestAdmin');
        $this->mold->set('RequestAdmin', $RequestAdmin);
        if ($user['user_group_id'] == $RequestAdmin or $user['user_group_id'] == 1) {
            if ($requestId != null) {
                $requestService = parent::model('requestService', $requestId);
                if ($requestService->getRequestId() != $requestId) {
                    httpErrorHandler::E404();
                    return false;
                }

                $requestService->setCost(explode(',', $requestService->getCost()));
                $requestService->setWorkTitle(explode(',', $requestService->getWorkTitle()));
                $requestService->setBugInfluence(explode(',', $requestService->getBugInfluence()));
                $requestService->setConsumablePartsQty(explode(',', substr($requestService->getConsumablePartsQty(), 1, strlen($requestService->getConsumablePartsQty()) - 2)));
                $requestService->setConsumableParts(explode(',', substr($requestService->getConsumableParts(), 1, strlen($requestService->getConsumableParts()) - 2)));
                $this->mold->set('requestService', $requestService);
            } else
                $requestService = parent::model('requestService');

            $get = request::post('Time_Send,Time_Send_justT,ServiceSection,Workersection,workerPerson,Sender_note', null);
            $value = array();
            $variable = array();

            $this->mold->set('Users', user::index()["result"]);
            $this->mold->set('phases', phases::index()["result"]);
            $this->mold->set('Workersections', sections::index() ["result"]);
            $this->mold->set('BugInfluences', request_service::buginfluence() ["result"]);
            $this->mold->set('worktitles', request_service::worktitle() ["result"]);
            $this->mold->set('system_statuses', request_service::system_status() ["result"]);
            $this->mold->set('costs', request_service::cost() ["result"]);
            $this->mold->set('ServiceSections', sections::index() ["result"]);
            $this->mold->set('Parts', request_service::consumable_Parts() ["result"]);
            $this->mold->set('failures', request_service::failure() ["result"]);
            $this->mold->set('doneWork', request_service::doneWork() ["result"]);
            $this->mold->set('Latencys', request_service::latency() ["result"]);


            if (request::ispost()) {
                $shamsi = explode('/', $get['Time_Send']);
                $miladi = JDate::jalali_to_gregorian($shamsi[0], $shamsi[1], $shamsi[2], '/');

                $get['Time_Start'] = $get['Time_Start'] / 1000;
                $get['Time_End'] = $get['Time_End'] / 1000;

                $requestService->setRequestCode(0);
                $requestService->setTimeSend(date('Y-m-d H:i:s', strtotime(date('Y-m-d ', strtotime($miladi)) . date('H:i:00', strtotime($get['Time_Send_justT'])))));
                $requestService->setJTimeSend(JDate::jdate('Y-m-d', strtotime(date('Y-m-d ', strtotime($miladi)) . date('H:i:00', strtotime($get['Time_Send_justT'])))));
                $requestService->setTimeStart(date('Y-m-d H:i:s'));
                $requestService->setTimeEnd(date('Y-m-d H:i:s'));
                $requestService->setSystemName("");
                $requestService->setPhase(0);
                $requestService->setLine(1);
                $requestService->setSection($get['ServiceSection']);
                $requestService->setCost(',,');
                $requestService->setWorkerSection($get['Workersection']);
                $requestService->setOffTime(0);
                $requestService->setSystemStatus('0');
                $requestService->setWorkTitle(',,');
                $requestService->setBugInfluence(',,');
                $requestService->setFailure(4);
                $requestService->setFailureDes("");
                $requestService->setDonework(1);
                $requestService->setDoneworkDes("");
                $requestService->setLatency(3);
                $requestService->setLatencyTime(0);
                $requestService->setUnitPersonId(user::getUserLogin(true));
                $requestService->setWorkerPersonId($get['workerPerson']);
                $requestService->setSenderNote($get['Sender_note']);
                $requestService->setHumanNumber(1);
                $requestService->setConsumableParts(',,');
                $requestService->setConsumablePartsQty(',,');
                $section = $this->model('sections', $requestService->getSection());
                $Workersection = $this->model('sections', $requestService->getWorkerSection());
                $Dis = 'درخواست واحد  ';
                $Dis = $Dis . $section->getName();
                $Dis = $Dis . ' برای واحد  ';
                $Dis = $Dis . $Workersection->getName();
                if ($requestId == null and $requestService->insertToDataBase()) {
                    $Dis = $Dis . ' ثبت شد';
                    $this->callHooks('addLog', [$Dis, 'RequestService']);
                    $this->alert('success', '', "ثبت درخواست با موفقیت انجام شد");
                    Response::redirect(App::getBaseAppLink('RS/Send_lists', 'admin'));
                } elseif ($requestId != null and $requestService->upDateDataBase()) {
                    $Dis = $Dis . ' تغییر یافت';
                    $this->callHooks('addLog', [$Dis, 'RequestService']);
                    $this->alert('success', '', "ویرایش درخواست با موفقیت انجام شد");
                    Response::redirect(App::getBaseAppLink('RS/Send_lists', 'admin'));
                } else {
                    $this->alert('danger', '', "ثبت درخواست با مشکلی مواجه شده است");
                }
            }
            $this->mold->path('default', 'requestService');
            $this->mold->view('requestServiceOptimal.mold.html');
            $this->mold->setPageTitle('درخواست خدمات');
            $this->mold->set('activeMenu', 'requestServiceOptimal');
        } else {
            $this->alert('danger', '', "شما سمت مناسبی برای استفاده از این بخش ندارید");
        }
    }
}
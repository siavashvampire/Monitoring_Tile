<?php


namespace App\admin\controller;

use App;
use App\core\controller\fieldService;
use App\user\app_provider\api\user;
use controller;
use paymentCms\component\request;
use paymentCms\component\model;


if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');


class home extends controller
{
    public function index()
    {
        $localData = array(
            'version' => PCVERSION,
            'siteUrl' => App::getCurrentBaseLink(),
            'lang' => 'fa',
            'theme' => 'default',
            'app' => json_encode(App::appsListWithConfig()),
        );
        $update = json_decode(curl(request::serverOne('s'), $localData), true);
        if ($update['update']['needUpdate'])
            $this->alert('danger', rlang('update'), rlang('needUpdate'), 'autorenew');

        $this->mold->set('tabOne', $update['panel1']);
        $this->mold->set('tabTwo', $update['panel2']);
        $this->mold->view('home.mold.html');
        $this->mold->setPageTitle(rlang('dashboard'));
        $this->mold->set('activeMenu', 'dashboard');
        $this->callHooks('adminDashboard');

        $value = array();
        $variable = array();

        $user = user::getUserLogin();
        $fields = fieldService::showFilledOutFormWithAllFields($user['user_group_id'], 'user_register', $user['userId'], 'user_register', true);
        $unitId = false;
        $phase = false;
        if (is_array($fields['result'])) {
            foreach ($fields['result'] as $index => $fields) {
                if ($fields['type'] == 'fieldCall_units_units') {
                    $unitId = $fields['value'];
                } elseif ($fields['type'] == 'fieldCall_LineMonitoring_phase') {
                    $phase = $fields['value'];
                }
                if ($unitId and $phase) break;
            }
        }
        if ($unitId) {
            $value[] = $unitId;
            $variable[] = ' sensors.unit = ? ';
        }
        if ($phase) {
            $value[] = $phase;
            $variable[] = ' sensors.phase = ? ';
        }
        $value[] = 0;
        $value[] = 0;
        $value[] = 0;
        $variable[] = ' sensors.Sensor_plc_id <> ? ';
        $variable[] = ' sensors.OffTime <> ? ';
        $variable[] = ' sensors.isVirtual = ? ';
        $model = parent::model(['LineMonitoring', 'sensors']);
        $model->join('units units', 'units.id = sensors.unit ');
        $sensor = $model->search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), 'sensors sensors', 'sensors.label , sensors.phase ,sensors.Active , units.label as unitName', ['column' => 'sensors.showSort', 'type' => 'asc']);

        $value = array();
        $variable = array();
        $value[] = 0;
        $variable[] = ' CamSwitch.Switch_plc_id <> ? ';
        $model = parent::model(['LineMonitoring', 'CamSwitch']);
        $model->join('units units', 'units.id = CamSwitch.unit ');
        $switch = $model->search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), 'CamSwitch CamSwitch', 'CamSwitch.*,units.label as unitName', ['column' => 'CamSwitch.Switch_plc_id', 'type' => 'desc']);
//        show($switch);

        $this->mold->set('sensors', $sensor);
        $this->mold->set('Switchs', $switch);


    }
}
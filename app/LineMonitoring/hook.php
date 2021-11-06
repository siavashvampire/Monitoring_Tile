<?php

namespace App\LineMonitoring;

use app;
use App\core\controller\fieldService;
use App\LineMonitoring\model\data;
use App\LineMonitoring\model\phases;
use App\user\app_provider\api\user;
use App\vakilnet\model\specialties;
use paymentCms\component\cache;
use paymentCms\component\file;
use paymentCms\component\model;
use pluginController;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class hook extends pluginController
{
    public function _adminHeaderNavbar($vars2)
    {
        $this->menu->after('users', 'diagrams', 'نقشه کارخانه', app::getBaseAppLink('diagram/s', 'admin'), 'fa fa-map', '', null, 'admin/diagram/s/LineMonitoring');

        $this->menu->after('diagrams', 'sensorCount', 'تولیدات خطوط', app::getBaseAppLink('sensorlog/counter', 'admin'), 'fa fa-eye', '', null, 'admin/sensorlog/counter/LineMonitoring');

        $this->menu->after('sensorCount', 'InsertsensorOfflog', 'ثبت علت توقفات', app::getBaseAppLink('sensorOffTimeLog', 'admin'), 'fa fa-history', '', null, 'admin/sensorOffTimeLog/index/LineMonitoring');

        $this->menu->after('InsertsensorOfflog', 'Reports', 'گزارش ها', "#", 'fa fa-file-excel-o', '', null, 'admin/export/Merge/LineMonitoring');

        $this->menu->addChild('Reports', 'exportExcel', 'گزارش گیری', app::getBaseAppLink('sensorlog/export', 'admin'), 'fa fa-file-excel-o', '', 'admin/sensorlog/export/LineMonitoring');

        $this->menu->addChild('Reports', 'exportProduction', 'گزارش گیری تولید', app::getBaseAppLink('export/Production', 'admin'), 'fa fa-file-excel-o', '', 'admin/export/Production/LineMonitoring');

        $this->menu->addChild('Reports', 'exportStops', 'گزارش گیری توقفات', app::getBaseAppLink('export/Stops', 'admin'), 'fa fa-file-excel-o', '', 'admin/export/Stops/LineMonitoring');
        $this->menu->addChild('Reports', 'chart', 'گزارش گیری نموداری', app::getBaseAppLink('export/chart', 'admin'), 'fa fa-file-excel-o', '', 'admin/export/chart/LineMonitoring');

        $this->menu->after('Reports', 'alllogs', 'لاگ ها', "#", 'fa fa-history', '', null, 'admin/sensorlog/index/LineMonitoring');

        $this->menu->addChild('alllogs', 'sensorlog', 'لاگ سنسور ها', app::getBaseAppLink('sensorlog', 'admin'), 'fa fa-history', '', 'admin/sensorlog/index/LineMonitoring');

        $this->menu->addChild('alllogs', 'sensorOfflog', 'لاگ توقفات واحدها', app::getBaseAppLink('sensorOffTimeLog/lists', 'admin'), 'fa fa-history', '', 'admin/sensorOffTimeLog/lists/LineMonitoring');

        $this->menu->addChild('alllogs', 'SwitchOfflog', 'لاگ توقفات کلیدها', app::getBaseAppLink('SwitchOffTimeLog', 'admin'), 'fa fa-history', '', 'admin/SwitchOffTimeLog/index/LineMonitoring');

        $this->menu->after('alllogs', 'configurationLine', 'تنظیمات خط تولید', "#", 'fa fa-cogs', '', null, 'admin/sensor/index/LineMonitoring');


        $this->menu->addChild('configurationLine', 'sensors', 'تنظیمات سنسورها', app::getBaseAppLink('sensor', 'admin'), 'fa fa-usb', '', 'admin/sensor/index/LineMonitoring');
        $this->menu->addChild('configurationLine', 'virtualSensor', 'تنظیمات سنسورهای مجازی', app::getBaseAppLink('virtualSensor/List', 'admin'), 'fa fa-usb', '', 'admin/virtualSensor/index/LineMonitoring');
        $this->menu->addChild('configurationLine', 'storageSensor', 'تنظیمات سنسورهای دخیره ساز', app::getBaseAppLink('storageSensor/List', 'admin'), 'fa fa-usb', '', 'admin/storageSensor/index/LineMonitoring');
        $this->menu->addChild('configurationLine', 'CamSwitch', 'تنظیمات کلیدها', app::getBaseAppLink('CamSwitch', 'admin'), 'fa fa-usb', '', 'admin/CamSwitch/index/LineMonitoring');

        $this->menu->after('configurationLine', 'configurationManufactor', 'تنظیمات کارخانه', "#", 'fa fa-building-o ', '', null, 'admin/off_sensor_reasons/lists/LineMonitoring');


        $this->menu->addChild('configurationManufactor', 'phases', rlang('PhaseAndBudgetDefinition'), app::getBaseAppLink('phases/List', 'admin'), 'fa fa-calendar', '', 'admin/phases/lists /LineMonitoring');

        $this->menu->addChild('configurationManufactor', 'off_sensor_reasons', 'تنظیمات علت توقفات', app::getBaseAppLink('off_sensor_reasons', 'admin'), 'fa fa-file-text-o', '', 'admin/off_sensor_reasons/lists/LineMonitoring');

        $this->menu->addChild('configurationManufactor', 'diagramSetting', 'تنظیمات نقشه‌های کارخانه', app::getBaseAppLink('diagram', 'admin'), 'fa fa-map-signs', '', 'admin/diagram/index/LineMonitoring');
    }

    /*
 * this method from hear to line 100 lines after hear ( _fieldService_updateValue_specialties method)
 *      is for add list of special ( of Lawyers ) to any forms.
 */
    public function _fieldService_listOfTypes($vars2)
    {
        return [
            ['type' => 'phase', 'name' => 'فاز ها'],
        ];
    }

    public function _fieldService_showToFillOut_phase($vars2)
    {
        $phases = $this->model(['LineMonitoring', 'phases'])->getItems();
        $options = '';
        if (is_array($phases))
            foreach ($phases as $phase) {
                $selected = '';
                if (isset($this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']])) {
                    if (in_array($phase['id'], $this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']]))
                        $selected = 'selected';
                } elseif (isset($this->mold->get('field')['value'])) {
                    $explodeSelectedValue = explode(' - ', $this->mold->get('field')['value']);
                    if (in_array($phase['id'], $explodeSelectedValue))
                        $selected = 'selected';
                }
                $options .= '<option value ="' . $phase['id'] . '" ' . $selected . '>' . $phase['label'] . '</option>';

            }
        $html = '<div class="' . $this->mold->get('fillOutFieldServiceFormCssClassAllDiv') . '">
    <label class="' . $this->mold->get('fillOutFieldServiceFormCssClassLabelDiv') . '" for="field_' . $this->mold->get('field')['fieldId'] . '">' . $this->mold->get('field')['title'] . ' ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? '<span class="text-danger">*</span>' : '') . '</label>
    <div class="' . $this->mold->get('fillOutFieldServiceFormCssClassInputDiv') . '">
        <select  autocomplete="off" data-live-search="true" class="selectpicker" id="field_' . $this->mold->get('field')['fieldId'] . '"  name="customField[' . $this->mold->get('field')['fieldId'] . '][]" ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? 'required' : '') . ' data-size="7" data-style="btn btn-outline-info btn-round text-right" title="' . rlang(['please', 'selecting']) . '">
        ' . $options . '
        </select>
        ' . (($this->mold->get('field')['description'] != '') ? '<div class="small text-gray">' . $this->mold->get('field')['description'] . '</div>' : '') . '
    </div>
</div>';

        return $html;

    }

    public function _fieldService_showValue_phase($fieldInformation = null)
    {
        /** @var phases $model */
        $model = $this->model(['LineMonitoring', 'phases'], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _settingFooter()
    {
        $getPath = $this->mold->getPath();
        $this->mold->path('default', 'LineMonitoring');

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
        $port = $this->setting('wsPort', 'LineMonitoring', true);
        $ipsInString = $this->setting('WsIP', 'LineMonitoring', true);
        $ips = preg_split('/\r\n|[\r\n]/', $ipsInString);
        $mainFolder = (explode(':', payment_path))[0];
        $dire = str_replace($mainFolder . ':', '', payment_path) . 'app' . DIRECTORY_SEPARATOR . 'LineMonitoring' . DIRECTORY_SEPARATOR . 'web_socket' . DIRECTORY_SEPARATOR;
        file::remove_all_into_dir(payment_path . 'startup', '*.bat');

        $this->mold->set('dirStartUP', payment_path . 'startup');
        for ($i = 0; $i < count($ips); $i++) {
            $ip = trim($ips[$i]);
            $ip = str_replace(['https://', 'http://', '/', 'https:', 'http:'], '', $ip);
            if ($ip != '' and $port != '') {
                $text = $mainFolder . ':' . "\r\n";
                $text .= 'cd ' . $dire . "\r\n";
                $text .= 'php -q ws_server.php ' . $ip . ' ' . $port;
                file::generate_file(payment_path . 'startup' . DIRECTORY_SEPARATOR . 'ws-ipNumber' . $i . '.bat', $text);
            }
        }
    }

    public function _adminDashboard()
    {
        $user = user::getUserLogin();
        $numberOfAll = 0;
        if ($user['user_group_id'] == $this::setting('supervisor', 'LineMonitoring', true)) {
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
                $variable[] = ' data.unit = ? ';
            }
            if ($phase) {
                $value[] = $phase;
                $variable[] = ' data.phase = ? ';
            }
            $value[] = '0';
            $variable[] = ' ( data.reason is null or data.description is null or ? ) ';
            $numberOfAll = (model::searching((array)$value, implode(' and ', $variable), 'sensor_active_log_archive data', 'COUNT(data.Sensor_id) as co')) [0]['co'];

        }
        if ($numberOfAll > 0) {
            $this->mold->set('numberOfSensorsToFill', $numberOfAll);
            $getPath = $this->mold->getPath();
            $this->mold->path('default', 'LineMonitoring');
            $this->mold->view('sensorReason.admin.hook.mold.html');
            $this->mold->path($getPath['folder'], $getPath['app']);
        }
            }

    public function _should_update()
    {
        $should_update = array();

        $data = cache::get('is_sensor_update', null, 'LineMonitoring');
        $dataSwitch = cache::get('is_switch_update', null, 'LineMonitoring');

        if ($data !== 'yes')
            $should_update[] = "sensor_update";


        if ($dataSwitch !== 'yes')
            $should_update[] = "switch_update";

        if (count($should_update) == 0)
            return null;

        return $should_update;
    }

    public function _need_plc()
    {
        return ["label" => "LineMonitoring"];
    }

}
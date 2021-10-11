<?php
namespace App\units ;

use app;
use pluginController;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class hook extends pluginController {
	public function _adminHeaderNavbar($vars2){
//        $this->menu->addChild('configurationManufactor', 'Units', 'واحد‌های کارخانه', app::getBaseAppLink('units', 'admin'), 'fa fa-columns', '',  'admin/units/index/units');
        $this->menu->after('users', 'Units', 'واحد‌های کارخانه', app::getBaseAppLink('units', 'admin'), 'fa fa-columns', '',  null,'admin/units/index/units');

    }


    public function _fieldService_listOfTypes($vars2)
    {
        return [
            ['type' => 'units', 'name' => 'واحد ها'],
        ];
    }


    public function _fieldService_showToFillOut_units($vars2)
    {
        $model = $this->model(['units', 'units']);
        $searchFathers = $model->search('1', ' ?  ', null, '*', ['column' => 'Name', 'type' => 'asc']);
        $options = '';
        if (is_array($searchFathers))
            foreach ($searchFathers as $search) {
                $selected = '';
                if (isset($this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']])) {
                    if (in_array($search['unitId'], $this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']]))
                        $selected = 'selected';
                } elseif (isset($this->mold->get('field')['value'])) {
                    $explodeSelectedValue = explode(' - ', $this->mold->get('field')['value']);
                    if (in_array($search['unitId'], $explodeSelectedValue))
                        $selected = 'selected';
                }
                $options .= '<option value ="' . $search['unitId'] . '" ' . $selected . '>' . $search['Name'] . '</option>';

            }
        $html = '<div class="' . $this->mold->get('fillOutFieldServiceFormCssClassAllDiv') . '">
    <label class="' . $this->mold->get('fillOutFieldServiceFormCssClassLabelDiv') . '" for="field_' . $this->mold->get('field')['fieldId'] . '">' . $this->mold->get('field')['title'] . ' ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? '<span class="text-danger">*</span>' : '') . '</label>
    <div class="' . $this->mold->get('fillOutFieldServiceFormCssClassInputDiv') . '">
        <select  autocomplete="off" class="selectpicker" id="field_' . $this->mold->get('field')['fieldId'] . '"  name="customField[' . $this->mold->get('field')['fieldId'] . '][]" ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? 'required' : '') . ' data-size="7" data-style="btn btn-outline-info btn-round text-right" title="' . rlang(['please', 'selecting']) . '">
        ' . $options . '
        </select>
        ' . (($this->mold->get('field')['description'] != '') ? '<div class="small text-gray">' . $this->mold->get('field')['description'] . '</div>' : '') . '
    </div>
</div>';

        return $html;

    }

    public function _fieldService_showValue_units($fieldInformation = null)
    {
        $model = $this->model(['units', 'units'], $fieldInformation['value']);
        return $model->getLabel();
    }

}
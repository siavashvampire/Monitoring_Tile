<?php
namespace App\product ;

use app;
use App\product\model\product_glaze;
use App\product\model\product_size;
use App\product\model\product_punch;
use pluginController;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class hook extends pluginController {
	public function _adminHeaderNavbar($vars2){
        $this->menu->addChild('configurationLine', 'product_size', 'سایز کاشی‌ها', app::getBaseAppLink('product_size', 'admin'), 'fa fa-delicious', '', 'admin/product_size/index/product');
        $this->menu->addChild('configurationLine', 'product_glaze', 'لعاب ‌ها', app::getBaseAppLink('product_glaze', 'admin'), 'fa fa-delicious', '', 'admin/product_glaze/index/product');
        $this->menu->addChild('configurationLine', 'product_brand', 'برند ‌ها', app::getBaseAppLink('product_brand', 'admin'), 'fa fa-delicious', '', 'admin/product_brand/index/product');
        $this->menu->addChild('configurationLine', 'product_punch', 'پانچ ‌ها', app::getBaseAppLink('product_punch', 'admin'), 'fa fa-delicious', '', 'admin/product_punch/index/product');
    }

    public function _fieldService_listOfTypes($vars2)
    {
        return [
            ['type' => 'productKind', 'name' => 'نوع کاشی'],
            ['type' => 'productGlaze', 'name' => 'لعاب کاشی'],
            ['type' => 'productPunch', 'name' => 'پانچ کاشی'],
        ];
    }

    public function _fieldService_showToFillOut_productSize($vars2)
    {
        /* @var product_size $model */
        $model = $this->model(['product', 'product_size']);
        $searchFathers = $model->getItems();
        $options = '';
        if (is_array($searchFathers))
            foreach ($searchFathers as $search) {
                $selected = '';
                if (isset($this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']])) {
                    if (in_array($search['id'], $this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']]))
                        $selected = 'selected';
                } elseif (isset($this->mold->get('field')['value'])) {
                    $explodeSelectedValue = explode(' - ', $this->mold->get('field')['value']);
                    if (in_array($search['id'], $explodeSelectedValue))
                        $selected = 'selected';
                }
                $options .= '<option value ="' . $search['id'] . '" ' . $selected . '>' . $search['label'] . '</option>';
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

    public function _fieldService_showValue_productSize($fieldInformation = null)
    {
        /** @var product_size $model */
        $model = $this->model(['product', 'product_size'], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productGlaze($vars2)
    {
        /* @var product_glaze $model */
        $model = $this->model(['product', 'product_glaze']);
        $searchFathers = $model->getItems();

        $options = '';
        if (is_array($searchFathers))
            foreach ($searchFathers as $search) {
                $selected = '';
                if (isset($this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']])) {
                    if (in_array($search['id'], $this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']]))
                        $selected = 'selected';
                } elseif (isset($this->mold->get('field')['value'])) {
                    $explodeSelectedValue = explode(' - ', $this->mold->get('field')['value']);
                    if (in_array($search['id'], $explodeSelectedValue))
                        $selected = 'selected';
                }
                $options .= '<option value ="' . $search['id'] . '" ' . $selected . '>' . $search['label'] . '</option>';
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

    public function _fieldService_showValue_productGlaze($fieldInformation = null)
    {
        /** @var product_glaze $model */
        $model = $this->model(['product', 'product_glaze'], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productPunch($vars2)
    {
        /* @var product_punch $model */
        $model = $this->model(['product', 'product_punch']);
        $searchFathers = $model->getItems();

        $options = '';
        if (is_array($searchFathers))
            foreach ($searchFathers as $search) {
                $selected = '';
                if (isset($this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']])) {
                    if (in_array($search['id'], $this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']]))
                        $selected = 'selected';
                } elseif (isset($this->mold->get('field')['value'])) {
                    $explodeSelectedValue = explode(' - ', $this->mold->get('field')['value']);
                    if (in_array($search['id'], $explodeSelectedValue))
                        $selected = 'selected';
                }
                $options .= '<option value ="' . $search['id'] . '" ' . $selected . '>' . $search['label'] . '</option>';
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

    public function _fieldService_showValue_productPunch($fieldInformation = null)
    {
        /** @var product_punch $model */
        $model = $this->model(['product', 'product_punch'], $fieldInformation['value']);
        return $model->getLabel();
    }

}
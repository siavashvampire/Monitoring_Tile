<?php

namespace App\product;

use app;
use App\product\model\product_brand;
use App\product\model\product_color;
use App\product\model\product_decor;
use App\product\model\product_degree;
use App\product\model\product_effect;
use App\product\model\product_glaze;
use App\product\model\product_kind;
use App\product\model\product_size;
use App\product\model\product_punch;
use App\product\model\product_technique;
use App\product\model\product_template;
use pluginController;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class hook extends pluginController
{
    private $appName = 'product';
    public function _adminHeaderNavbar($vars2)
    {
        $this->menu->addChild('configurationLine', 'product', 'کاشی‌ها', app::getBaseAppLink('product/list', 'admin'), 'fa fa-delicious', '', 'admin/product/list/product');
        $this->menu->addChild('configurationLine', 'product_size', 'سایز کاشی‌ها', app::getBaseAppLink('product_size', 'admin'), 'fa fa-delicious', '', 'admin/product_size/index/product');
        $this->menu->addChild('configurationLine', 'product_glaze', 'لعاب ‌ها', app::getBaseAppLink('product_glaze', 'admin'), 'fa fa-delicious', '', 'admin/product_glaze/index/product');
        $this->menu->addChild('configurationLine', 'product_brand', 'برند ‌ها', app::getBaseAppLink('product_brand', 'admin'), 'fa fa-delicious', '', 'admin/product_brand/index/product');
        $this->menu->addChild('configurationLine', 'product_punch', 'پانچ ‌ها', app::getBaseAppLink('product_punch', 'admin'), 'fa fa-delicious', '', 'admin/product_punch/index/product');
        $this->menu->addChild('configurationLine', 'product_color', 'رنگ ‌ها', app::getBaseAppLink('product_color', 'admin'), 'fa fa-delicious', '', 'admin/product_color/index/product');
        $this->menu->addChild('configurationLine', 'product_kind', 'نوع محصول', app::getBaseAppLink('product_kind', 'admin'), 'fa fa-delicious', '', 'admin/product_kind/index/product');
        $this->menu->addChild('configurationLine', 'product_technique', 'تکنیک تولید', app::getBaseAppLink('product_technique', 'admin'), 'fa fa-delicious', '', 'admin/product_technique/index/product');
        $this->menu->addChild('configurationLine', 'product_effect', 'افکت ها', app::getBaseAppLink('product_effect', 'admin'), 'fa fa-delicious', '', 'admin/product_effect/index/product');
        $this->menu->addChild('configurationLine', 'product_decor', 'دکور ها', app::getBaseAppLink('product_decor', 'admin'), 'fa fa-delicious', '', 'admin/product_decor/index/product');
        $this->menu->addChild('configurationLine', 'product_degree', 'درجه ها', app::getBaseAppLink('product_degree', 'admin'), 'fa fa-delicious', '', 'admin/product_degree/index/product');
        $this->menu->addChild('configurationLine', 'product_template', 'قالب ها', app::getBaseAppLink('product_template', 'admin'), 'fa fa-delicious', '', 'admin/product_template/index/product');
    }

    public function _fieldService_listOfTypes($vars2): array
    {
        return [
            ['type' => 'productSize', 'name' => 'سایز کاشی'],
            ['type' => 'productGlaze', 'name' => 'لعاب کاشی'],
            ['type' => 'productPunch', 'name' => 'پانچ کاشی'],
            ['type' => 'productBrand', 'name' => 'برند کاشی'],
            ['type' => 'productColor', 'name' => 'رنگ کاشی'],
            ['type' => 'productKind', 'name' => 'نوع محصول'],
            ['type' => 'productTemplate', 'name' => 'نوع محصول'],
        ];
    }

    public function _fieldService_showToFillOut_productSize($vars2)
    {
        $modelName = 'product_size';

        /* @var product_size $model */
        $model = $this->model([$this->appName, $modelName]);
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
        $modelName = 'product_size';

        /** @var product_size $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productGlaze($vars2)
    {
        $modelName = 'product_glaze';

        /* @var product_glaze $model */
        $model = $this->model([$this->appName, $modelName]);
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
        $modelName = 'product_glaze';

        /** @var product_glaze $model */
        $model = $this->model([$this->appName,$modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productPunch($vars2)
    {
        $modelName = 'product_punch';

        /* @var product_punch $model */
        $model = $this->model([$this->appName, $modelName]);
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
        $modelName = 'product_punch';

        /** @var product_punch $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productBrand($vars2)
    {
        $modelName = 'product_brand';
        /* @var product_brand $model */
        $model = $this->model([$this->appName, $modelName]);
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

    public function _fieldService_showValue_productBrand($fieldInformation = null)
    {
        $modelName = 'product_brand';
        /** @var product_brand $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productColor($vars2)
    {
        $modelName = 'product_color';
        /* @var product_color $model */
        $model = $this->model([$this->appName, $modelName]);
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

    public function _fieldService_showValue_productColor($fieldInformation = null)
    {
        $modelName = 'product_color';
        /** @var product_color $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productKind($vars2)
    {
        $modelName = 'product_kind';
        /* @var product_kind $model */
        $model = $this->model([$this->appName, $modelName]);
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

    public function _fieldService_showValue_productKind($fieldInformation = null)
    {
        $modelName = 'product_kind';
        /** @var product_kind $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productTechnique($vars2)
    {
        $modelName = 'product_technique';
        /* @var product_technique $model */
        $model = $this->model([$this->appName, $modelName]);
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

    public function _fieldService_showValue_productTechnique($fieldInformation = null)
    {
        $modelName = 'product_technique';
        /** @var product_technique $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productEffect($vars2)
    {
        $modelName = 'product_effect';
        /* @var product_effect $model */
        $model = $this->model([$this->appName, $modelName]);
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

    public function _fieldService_showValue_productEffect($fieldInformation = null)
    {
        $modelName = 'product_effect';
        /** @var product_effect $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productDecor($vars2)
    {
        $modelName = 'product_decor';
        /* @var product_decor $model */
        $model = $this->model([$this->appName, $modelName]);
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

    public function _fieldService_showValue_productDecor($fieldInformation = null)
    {
        $modelName = 'product_decor';
        /** @var product_decor $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productDegree($vars2)
    {
        $modelName = 'product_degree';
        /* @var product_degree $model */
        $model = $this->model([$this->appName, $modelName]);
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

    public function _fieldService_showValue_productDegree($fieldInformation = null)
    {
        $modelName = 'product_degree';
        /** @var product_degree $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _fieldService_showToFillOut_productTemplate($vars2)
    {
        $modelName = 'product_template';
        /* @var product_template $model */
        $model = $this->model([$this->appName, $modelName]);
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

    public function _fieldService_showValue_productTemplate($fieldInformation = null)
    {
        $modelName = 'product_template';
        /** @var product_template $model */
        $model = $this->model([$this->appName, $modelName], $fieldInformation['value']);
        return $model->getLabel();
    }

    public function _logField(): array
    {
        return [["value" => "product", "label" => "تغییرات کاشی ها"],
            ["value" => "product_punch", "label" => "تغییرات پانچ ها"],
            ["value" => "product_punch", "label" => "تغییرات پانچ ها"],
            ["value" => "product_glaze", "label" => "تغییرات لعاب ها"],
            ["value" => "product_brand", "label" => "تغییرات برند ها"],
            ["value" => "product_color", "label" => "تغییرات رنگ ها"],
            ["value" => "product_kind", "label" => "تغییرات نوع محصول"],
            ["value" => "product_technique", "label" => "تغییرات تکنیک تولید"],
            ["value" => "product_effect", "label" => "تغییرات افکت ها"],
            ["value" => "product_decor", "label" => "تغییرات دکور ها"],
            ["value" => "product_degree", "label" => "تغییرات درجه ها"],
            ["value" => "product_template", "label" => "تغییرات قالب ها"],
        ];
    }
}
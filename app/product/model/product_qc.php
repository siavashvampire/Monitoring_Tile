<?php


namespace App\product\model;


use paymentCms\component\model;
use paymentCms\model\modelInterFace;

class product_qc extends model implements modelInterFace
{
    private $tableName = 'product_qc';

    private $primaryKey = ['id'];
    private $primaryKeyShouldNotInsertOrUpdate = 'id';
    private $id;
    private $product;
    private $qc_date;
    private $body;
    private $engobe;
    private $glaze;
    private $sub_engobe;
    private $thickness;
    private $novanc;
    private $code;
    private $file_code;
    private $controller;
    private $description;

    public function setFromArray($result)
    {
        $this->id = $result['id'];
        $this->product = $result['product'];
        $this->qc_date = $result['qc_date'];
        $this->body = $result['body'];
        $this->engobe = $result['engobe'];
        $this->glaze = $result['glaze'];
        $this->sub_engobe = $result['sub_engobe'];
        $this->thickness = $result['thickness'];
        $this->novanc = $result['novanc'];
        $this->code = $result['code'];
        $this->file_code = $result['file_code'];
        $this->controller = $result['controller'];
        $this->description = $result['description'];
    }

    public function returnAsArray()
    {
        $array['id'] = $this->id;
        $array['product'] = $this->product;
        $array['qc_date'] = $this->qc_date;
        $array['body'] = $this->body;
        $array['engobe'] = $this->engobe;
        $array['glaze'] = $this->glaze;
        $array['sub_engobe'] = $this->sub_engobe;
        $array['thickness'] = $this->thickness;
        $array['novanc'] = $this->novanc;
        $array['code'] = $this->code;
        $array['file_code'] = $this->file_code;
        $array['controller'] = $this->controller;
        $array['description'] = $this->description;
        return $array;
    }

    /**
     * @return array
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * @return string
     */
    public function getPrimaryKeyShouldNotInsertOrUpdate()
    {
        return $this->primaryKeyShouldNotInsertOrUpdate;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }
    /**
     * @return mixed
     */
    public function getProductLabel()
    {
        return parent::search([$this->product], 'item.id = ?', 'product' . ' item', 'item.label')[0]['label'];
    }

    public function getSizeLabel()
    {
        model::join('product_size  size', 'item.size = size.id');
        return parent::search([$this->product], 'item.id = ?', 'product' . ' item', 'CONCAT(size.length,"×", size.width) as size')[0]['size'];
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product): void
    {
        $this->product = $product;
    }

    /**
     * @return mixed
     */
    public function getQcDate()
    {
        return $this->qc_date;
    }

    /**
     * @param mixed $qc_date
     */
    public function setQcDate($qc_date): void
    {
        $this->qc_date = $qc_date;
    }


    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code): void
    {
        if ($code == '')
            $code = null;
        $this->code = $code;
    }


    /**
     * @return mixed
     */
    public function getGlazeLabel()
    {
        return parent::search([$this->glaze], 'item.id = ?', 'product_glaze' . ' item', 'item.label')[0]['label'];
    }


    /**
     * @return mixed
     */
    public function getGlaze()
    {
        return $this->glaze;
    }

    /**
     * @return mixed
     */
    public function getGlazeParent()
    {
        return parent::search([$this->glaze], 'item.id = ?', 'product_glaze' . ' item', 'item.parent')[0]['parent'];
    }

    public function getGlazeParentLabel()
    {
        return parent::search([self::getGlazeParent()], 'item.id = ?', 'product_glaze' . ' item', 'item.label')[0]['label'];
    }

    /**
     * @param mixed $glaze
     */
    public function setGlaze($glaze): void
    {
        if ($glaze == '')
            $glaze = null;
        $this->glaze = $glaze;
    }

    /**
     * @return mixed
     */
    public function getNovanc()
    {
        return $this->novanc;
    }

    /**
     * @param mixed $novanc
     */
    public function setNovanc($novanc): void
    {
        if ($novanc == '')
            $novanc = null;
        $this->novanc = $novanc;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return mixed
     */
    public function getBodyLabel()
    {
        return parent::search([$this->body], 'item.id = ?', 'product_body' . ' item', 'item.label')[0]['label'];
    }

    /**
     * @param mixed $body
     */
    public function setBody($body): void
    {
        if ($body == '')
            $body = null;
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function getEngobe()
    {
        return $this->engobe;
    }

    /**
     * @return mixed
     */
    public function getEngobeLabel()
    {
        return parent::search([$this->engobe], 'item.id = ?', 'product_engobe' . ' item', 'item.label')[0]['label'];
    }

    /**
     * @param mixed $engobe
     */
    public function setEngobe($engobe): void
    {
        if ($engobe == '')
            $engobe = null;
        $this->engobe = $engobe;
    }

    /**
     * @return mixed
     */
    public function getFileCode()
    {
        return $this->file_code;
    }

    /**
     * @param mixed $file_code
     */
    public function setFileCode($file_code): void
    {
        if ($file_code == '')
            $file_code = null;
        $this->file_code = $file_code;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        if ($description == '')
            $description = null;
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getSubEngobe()
    {
        return $this->sub_engobe;
    }

    /**
     * @param mixed $sub_engobe
     */
    public function setSubEngobe($sub_engobe): void
    {
        if ($sub_engobe == '')
            $sub_engobe = null;
        $this->sub_engobe = $sub_engobe;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param mixed $controller
     */
    public function setController($controller): void
    {
        $this->controller = $controller;
    }

    /**
     * @return mixed
     */
    public function getThickness()
    {
        return $this->thickness;
    }

    /**
     * @param mixed $thickness
     */
    public function setThickness($thickness): void
    {
        if ($thickness == '')
            $thickness = null;
        $this->thickness = $thickness;
    }

    public function getCount($value = array(), $variable = array())
    {

        model::join('product  product', 'product.id = item.product');
        return (parent::search((array)$value, (count($variable) == 0) ? null : implode(' and ', $variable), $this->tableName . ' item', 'COUNT(item.product) as co')) [0]['co'];
    }

    public function getItems($value = array(), $variable = array(), $sortWith = ['column' => 'item.qc_date', 'type' => 'DESC'], $pagination = [0, 9999])
    {
        model::join('product_body  body', 'body.id = item.body');
        model::join('product_novanc  novanc', 'novanc.id = item.novanc');
        model::join('product_engobe  engobe', 'engobe.id = item.engobe');
        model::join('product_sub_engobe  sub_engobe', 'sub_engobe.id = item.sub_engobe');
        model::join('product_glaze  glaze', 'glaze.id = item.glaze');
        model::join('product  product', 'product.id = item.product');

        model::join('user controller', 'item.controller = controller.userId');

        $field = array();
        $field[] = 'item.id';
        $field[] = 'item.product';
        $field[] = 'product.label as productLabel';
        $field[] = 'DATE_FORMAT(jdate(item.qc_date), "%Y-%m-%d") as date';
        $field[] = 'body.label as bodyLabel';
        $field[] = 'item.thickness';
        $field[] = 'novanc.label as novancLabel';
        $field[] = 'item.code';
        $field[] = 'item.file_code';
        $field[] = 'item.controller as controller';
        $field[] = 'concat(controller.fname," ",controller.lname) as controllerUser';
        $field[] = 'engobe.label as engobeLabel';
        $field[] = 'glaze.label as glazeLabel';
        $field[] = 'sub_engobe.label as sub_engobeLabel';
        $field[] = 'item.description';

        $field = implode(',', $field);

        return parent::search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), $this->tableName . ' item', $field, $sortWith, $pagination);
    }

    public function getItemsForExport($value = array(), $variable = array(), $sortWith = ['column' => 'item.qc_date', 'type' => 'DESC'], $pagination = [0, 9999])
    {

        model::join('product product','product.id = item.product');
        model::join('phases  phase','phase.id = product.phase');
        model::join('product_size  size','size.id = product.size');
        model::join('product_body  body','body.id = item.body');
        model::join('product_novanc  novanc','novanc.id = item.novanc');
        model::join('product_engobe  engobe','engobe.id = item.engobe');
        model::join('product_sub_engobe  sub_engobe','sub_engobe.id = item.sub_engobe');
        model::join('product_glaze  glaze','glaze.id = item.glaze');

        model::join('user controller', 'item.controller = controller.userId');

        $field = array();
        $field[] = 'item.id';
        $field[] = 'DATE_FORMAT(jdate(item.qc_date), "%d") as day';
        $field[] = 'DATE_FORMAT(jdate(item.qc_date), "%m") as month';
        $field[] = 'DATE_FORMAT(jdate(item.qc_date), "%Y") as year';
        $field[] = 'phase.label as phaseLabel';
        $field[] = 'size.label as sizeLabel';
        $field[] = 'body.label as bodyeLabel';
        $field[] = 'item.thickness';
        $field[] = 'product.label';
        $field[] = 'novanc.label as novancLabel';
        $field[] = 'item.code';
        $field[] = 'item.file_code';
        $field[] = 'concat(controller.fname," ",controller.lname) as controllerUser';
        $field[] = 'engobe.label as engobeLabel';
        $field[] = 'glaze.label as glazeLabel';
        $field[] = 'sub_engobe.label as sub_engobeLabel';
        $field[] = 'item.description';

        $field = implode(',', $field);

        return parent::search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), $this->tableName . ' item', $field, $sortWith, $pagination);
    }
}

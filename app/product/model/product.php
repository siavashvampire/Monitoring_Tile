<?php


namespace App\product\model;


use paymentCms\component\model;
use paymentCms\model\modelInterFace;

class product extends model implements modelInterFace
{
    private $tableName = 'product';

    private $primaryKey = ['id'];
    private $primaryKeyShouldNotInsertOrUpdate = 'id';
    private $id;
    private $label;
    private $example_code;
    private $production_design_code;
    private $kind;
    private $size;
    private $phase;
    private $color;
    private $punch;
    private $degree;
    private $weight;
    private $pallet;
    private $technique;
    private $template;
    private $effect;
    private $decor;
    private $body;
    private $body_weight;
    private $engobe;
    private $engobe_weight;
    private $glaze;
    private $glaze_weight;
    private $cylinder_before;
    private $cylinder_after;
    private $complementary_printing_before_digital;
    private $complementary_printing_before_digital_weight;
    private $complementary_printing_after_digital;
    private $complementary_printing_after_digital_weight;
    private $packing;
    private $carton_packing;
    private $pallet_packing;

    public function setFromArray($result)
    {
        $this->id = $result['id'];
        $this->label = $result['label'];
        $this->example_code = $result['example_code'];
        $this->production_design_code = $result['production_design_code'];
        $this->kind = $result['kind'];
        $this->size = $result['size'];
        $this->phase = $result['phase'];
        $this->color = $result['color'];
        $this->punch = $result['punch'];
        $this->degree = $result['degree'];
        $this->weight = $result['weight'];
        $this->pallet = $result['pallet'];
        $this->technique = $result['technique'];
        $this->template = $result['template'];
        $this->effect = $result['effect'];
        $this->decor = $result['decor'];
        $this->body = $result['body'];
        $this->body_weight = $result['body_weight'];
        $this->engobe = $result['engobe'];
        $this->engobe_weight = $result['engobe_weight'];
        $this->glaze = $result['glaze'];
        $this->glaze_weight = $result['glaze_weight'];
        $this->cylinder_before = $result['cylinder_before'];
        $this->cylinder_after = $result['cylinder_after'];
        $this->complementary_printing_before_digital = $result['complementary_printing_before_digital'];
        $this->complementary_printing_before_digital_weight = $result['complementary_printing_before_digital_weight'];
        $this->complementary_printing_after_digital = $result['complementary_printing_after_digital'];
        $this->complementary_printing_after_digital_weight = $result['complementary_printing_after_digital_weight'];
        $this->packing = $result['packing'];
        $this->carton_packing = $result['carton_packing'];
        $this->pallet_packing = $result['pallet_packing'];
    }

    public function returnAsArray()
    {
        $array['id'] = $this->id;
        $array['label'] = $this->label;
        $array['example_code'] = $this->example_code;
        $array['production_design_code'] = $this->production_design_code;
        $array['kind'] = $this->kind;
        $array['size'] = $this->size;
        $array['phase'] = $this->phase;
        $array['color'] = $this->color;
        $array['punch'] = $this->punch;
        $array['degree'] = $this->degree;
        $array['weight'] = $this->weight;
        $array['pallet'] = $this->pallet;
        $array['technique'] = $this->technique;
        $array['template'] = $this->template;
        $array['effect'] = $this->effect;
        $array['decor'] = $this->decor;
        $array['body'] = $this->body;
        $array['body_weight'] = $this->body_weight;
        $array['engobe'] = $this->engobe;
        $array['engobe_weight'] = $this->engobe_weight;
        $array['glaze'] = $this->glaze;
        $array['glaze_weight'] = $this->glaze_weight;
        $array['cylinder_before'] = $this->cylinder_before;
        $array['cylinder_after'] = $this->cylinder_after;
        $array['complementary_printing_before_digital'] = $this->complementary_printing_before_digital;
        $array['complementary_printing_before_digital_weight'] = $this->complementary_printing_before_digital_weight;
        $array['complementary_printing_after_digital'] = $this->complementary_printing_after_digital;
        $array['complementary_printing_after_digital_weight'] = $this->complementary_printing_after_digital_weight;
        $array['packing'] = $this->packing;
        $array['carton_packing'] = $this->carton_packing;
        $array['pallet_packing'] = $this->pallet_packing;
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
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label): void
    {
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public function getExampleCode()
    {
        return $this->example_code;
    }

    /**
     * @param mixed $example_code
     */
    public function setExampleCode($example_code): void
    {
        $this->example_code = $example_code;
    }

    /**
     * @return mixed
     */
    public function getProductionDesignCode()
    {
        return $this->production_design_code;
    }

    /**
     * @param mixed $production_design_code
     */
    public function setProductionDesignCode($production_design_code): void
    {
        $this->production_design_code = $production_design_code;
    }



    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return mixed
     */
    public function getSizeLabel()
    {
        return parent::search([$this->size], 'item.id = ?', 'product_size' . ' item', 'item.label')[0]['label'];
    }

    /**
     * @param mixed $size
     */
    public function setSize($size): void
    {
        $this->size = $size;
    }

    /**
     * @return mixed
     */
    public function getPhase()
    {
        return $this->phase;
    }

    /**
     * @return mixed
     */
    public function getPhaseLabel()
    {
        return parent::search([$this->phase], 'item.id = ?', 'phases' . ' item', 'item.label')[0]['label'];
    }

    /**
     * @param mixed $phase
     */
    public function setPhase($phase): void
    {
        $this->phase = $phase;
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
        $this->glaze = $glaze;
    }

    /**
     * @return mixed
     */
    public function getPunch()
    {
        return $this->punch;
    }

    /**
     * @param mixed $punch
     */
    public function setPunch($punch): void
    {
        $this->punch = $punch;
    }

    /**
     * @return mixed
     */
    public function getDegree()
    {
        return $this->degree;
    }

    /**
     * @param mixed $degree
     */
    public function setDegree($degree): void
    {
        $this->degree = $degree;
    }

    /**
     * @return mixed
     */
    public function getTemplateLabel()
    {
        return parent::search([$this->template], 'item.id = ?', 'product_template' . ' item', 'item.label')[0]['label'];
    }

    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param mixed $template
     */
    public function setTemplate($template): void
    {
        $this->template = $template;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     */
    public function setWeight($weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return mixed
     */
    public function getPallet()
    {
        return $this->pallet;
    }

    /**
     * @param mixed $pallet
     */
    public function setPallet($pallet): void
    {
        $this->pallet = $pallet;
    }


    /**
     * @return mixed
     */
    public function getKindLabel()
    {
        return parent::search([$this->kind], 'item.id = ?', 'product_kind' . ' item', 'item.label')[0]['label'];
    }

    /**
     * @return mixed
     */
    public function getKind()
    {
        return $this->kind;
    }

    /**
     * @param mixed $kind
     */
    public function setKind($kind): void
    {
        $this->kind = $kind;
    }

    /**
     * @return mixed
     */
    public function getColorLabel()
    {
        return parent::search([$this->color], 'item.id = ?', 'product_color' . ' item', 'item.label')[0]['label'];
    }
    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color): void
    {
        $this->color = $color;
    }


    /**
     * @return mixed
     */
    public function getTechniqueLabel()
    {
        return parent::search([$this->technique], 'item.id = ?', 'product_technique' . ' item', 'item.label')[0]['label'];
    }

    /**
     * @return mixed
     */
    public function getTechnique()
    {
        return $this->technique;
    }

    /**
     * @param mixed $technique
     */
    public function setTechnique($technique): void
    {
        $this->technique = $technique;
    }



    /**
     * @return mixed
     */
    public function getEffectLabel()
    {
        return parent::search([$this->effect], 'item.id = ?', 'product_effect' . ' item', 'item.label')[0]['label'];
    }

    /**
     * @return mixed
     */
    public function getEffect()
    {
        return $this->effect;
    }

    /**
     * @param mixed $effect
     */
    public function setEffect($effect): void
    {
        $this->effect = $effect;
    }


    /**
     * @return mixed
     */
    public function getDecorLabel()
    {
        return parent::search([$this->decor], 'item.id = ?', 'product_decor' . ' item', 'item.label')[0]['label'];
    }


    /**
     * @return mixed
     */
    public function getDecor()
    {
        return $this->decor;
    }

    /**
     * @param mixed $decor
     */
    public function setDecor($decor): void
    {
        $this->decor = $decor;
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
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function getBodyWeight()
    {
        return $this->body_weight;
    }

    /**
     * @param mixed $body_weight
     */
    public function setBodyWeight($body_weight): void
    {
        $this->body_weight = $body_weight;
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
        $this->engobe = $engobe;
    }

    /**
     * @return mixed
     */
    public function getEngobeWeight()
    {
        return $this->engobe_weight;
    }

    /**
     * @param mixed $engobe_weight
     */
    public function setEngobeWeight($engobe_weight): void
    {
        $this->engobe_weight = $engobe_weight;
    }

    /**
     * @return mixed
     */
    public function getGlazeWeight()
    {
        return $this->glaze_weight;
    }

    /**
     * @param mixed $glaze_weight
     */
    public function setGlazeWeight($glaze_weight): void
    {
        $this->glaze_weight = $glaze_weight;
    }

    /**
     * @return mixed
     */
    public function getCylinderBefore()
    {
        return $this->cylinder_before;
    }
    /**
     * @return mixed
     */
    public function getCylinderBeforeLabel()
    {
        return parent::search([$this->cylinder_before], 'item.id = ?', 'product_cylinder' . ' item', 'item.label')[0]['label'];
    }

    /**
     * @param mixed $cylinder_before
     */
    public function setCylinderBefore($cylinder_before): void
    {
        $this->cylinder_before = $cylinder_before;
    }

    /**
     * @return mixed
     */
    public function getCylinderAfter()
    {
        return $this->cylinder_after;
    }
    /**
     * @return mixed
     */
    public function getCylinderAfterLabel()
    {
        return parent::search([$this->cylinder_after], 'item.id = ?', 'product_cylinder' . ' item', 'item.label')[0]['label'];
    }

    /**
     * @param mixed $cylinder_after
     */
    public function setCylinderAfter($cylinder_after): void
    {
        $this->cylinder_after = $cylinder_after;
    }




    /**
     * @return mixed
     */
    public function getComplementaryPrintingBeforeDigital()
    {
        return $this->complementary_printing_before_digital;
    }
    /**
     * @return mixed
     */
    public function getComplementaryPrintingBeforeDigitalLabel()
    {
        return parent::search([$this->complementary_printing_before_digital], 'item.id = ?', 'product_complementary_printing_before_digital' . ' item', 'item.label')[0]['label'];
    }

    /**
     * @param mixed $complementary_printing_before_digital
     */
    public function setComplementaryPrintingBeforeDigital($complementary_printing_before_digital): void
    {
        $this->complementary_printing_before_digital = $complementary_printing_before_digital;
    }

    /**
     * @return mixed
     */
    public function getComplementaryPrintingBeforeDigitalWeight()
    {
        return $this->complementary_printing_before_digital_weight;
    }

    /**
     * @param mixed $complementary_printing_before_digital_weight
     */
    public function setComplementaryPrintingBeforeDigitalWeight($complementary_printing_before_digital_weight): void
    {
        $this->complementary_printing_before_digital_weight = $complementary_printing_before_digital_weight;
    }

    /**
     * @return mixed
     */
    public function getComplementaryPrintingAfterDigital()
    {
        return $this->complementary_printing_after_digital;
    }
    /**
     * @return mixed
     */
    public function getComplementaryPrintingAfterDigitalLabel()
    {
        return parent::search([$this->complementary_printing_after_digital], 'item.id = ?', 'product_complementary_printing_after_digital' . ' item', 'item.label')[0]['label'];
    }

    /**
     * @param mixed $complementary_printing_after_digital
     */
    public function setComplementaryPrintingAfterDigital($complementary_printing_after_digital): void
    {
        $this->complementary_printing_after_digital = $complementary_printing_after_digital;
    }

    /**
     * @return mixed
     */
    public function getComplementaryPrintingAfterDigitalWeight()
    {
        return $this->complementary_printing_after_digital_weight;
    }

    /**
     * @param mixed $complementary_printing_after_digital_weight
     */
    public function setComplementaryPrintingAfterDigitalWeight($complementary_printing_after_digital_weight): void
    {
        $this->complementary_printing_after_digital_weight = $complementary_printing_after_digital_weight;
    }

    /**
     * @return mixed
     */
    public function getPacking()
    {
        return $this->packing;
    }

    /**
     * @param mixed $packing
     */
    public function setPacking($packing): void
    {
        $this->packing = $packing;
    }

    /**
     * @return mixed
     */
    public function getCartonPacking()
    {
        return $this->carton_packing;
    }

    /**
     * @param mixed $carton_packing
     */
    public function setCartonPacking($carton_packing): void
    {
        $this->carton_packing = $carton_packing;
    }

    /**
     * @return mixed
     */
    public function getPalletPacking()
    {
        return $this->pallet_packing;
    }

    /**
     * @param mixed $pallet_packing
     */
    public function setPalletPacking($pallet_packing): void
    {
        $this->pallet_packing = $pallet_packing;
    }

    public function getCount($value = array(), $variable = array())
    {
        return (parent::search((array)$value, (count($variable) == 0) ? null : implode(' and ', $variable), $this->tableName . ' item', 'COUNT(item.id) as co')) [0]['co'];
    }

    public function getItems($value = array(), $variable = array(), $sortWith = ['column' => 'id', 'type' => 'asc'], $pagination = [0, 9999])
    {
        return parent::search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), $this->tableName . ' item', 'item.*', $sortWith, $pagination);
    }
}

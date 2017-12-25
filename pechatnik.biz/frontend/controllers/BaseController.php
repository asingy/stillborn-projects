<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 02.10.17
 * Time: 17:05
 */

namespace frontend\controllers;


use backend\helpers\ConfigHelper;
use backend\models\Config;
use yii\web\Controller;

class BaseController extends Controller
{

    private $title;
    private $metaKeywords;
    private $metaDescription;

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * @param mixed $metaKeywords
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;
    }

    /**
     * @return mixed
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * @param mixed $metaDescription
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;
    }

    public function render($view, $params = [])
    {
        $params['data'] = ConfigHelper::getParamsByType(Config::TYPE_FRONTEND);

        $this->view->title = $this->getTitle();
        $this->view->registerMetaTag(['content'=>$this->getMetaDescription(), 'name'=>'description'], 'description');
        $this->view->registerMetaTag(['content'=>$this->getMetaKeywords(), 'name'=>'keywords'], 'keywords');

        return parent::render($view, $params);
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 25.09.17
 * Time: 18:22
 */

namespace frontend\models;


class Pages extends \common\models\Pages
{

    public function getTitle()
    {
        if ($this->meta_title) {
            return $this->meta_title;
        }

        return $this->name;
    }

    public function getHeader()
    {
        return $this->name;
    }

}
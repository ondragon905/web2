<?php


namespace common\models;


use yii\db\ActiveRecord;

class Spisok extends ActiveRecord
{
    private $id;
    private $title;
    private $userid;

    function rules()
    {
        return [[['title'], 'required']];
    }

    function getId(){
        $this->primaryKey();
    }
}
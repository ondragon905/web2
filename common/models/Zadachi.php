<?php


namespace common\models;


use yii\db\ActiveRecord;

class Zadachi extends ActiveRecord
{
    private $id;
    private $title;
    private $idspisok;

    function rules()
    {
        return [[['title'], 'required']];
    }
}
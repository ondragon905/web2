<?php

use common\models\Spisok;
use common\models\Zadachi;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>


<h3><center>  Задачи </center> </h3>

<h3><?php echo $sort->link('Sort', ['class' => 'label label-info']); ?></h3>
<table class="table table-striped">
    <thead>
    <tr>
        <th>Название</th>
        <th>Действие</th>
    </tr>
    </thead>

    <tbody>
    <tr>
        <?php foreach ($spzad as $sp): ?>
        <td> <?php echo $sp->title; ?> </td>
        <td>
            <span> <?= Html::a('&#10006;', ['delete', 'id' => $sp->id], ['class'=>"badge badge-pill badge-primary"])?> </span>

            <span> <?= Html::a('&#9998;', ['update', 'id' => $sp->id], ['class'=>"badge badge-pill badge-light"])?> </span>
        </td>

    </tr>
    <?php endforeach ?>
    <?php
    ?>
    </tbody>
</table>

<div class = "row">
    <span>
        <?php echo
            '<a href="'.Url::toRoute(['create', 'id' => $idspiska]).'"
                style="text-decoration: none"> &#10010; Добавить задачу
            </a>'
        ?>


    </span>
</div>

<center>
    <?= LinkPager::widget([
        'pagination' => $pages,
    ]); ?>
</center>
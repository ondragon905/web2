<?php use yii\helpers\Html;
use yii\helpers\Url; ?>


<h3><center>  Список задач </center> </h3>


<div class = "row">
    <span>
        <font>   <?= Html::a('&#10010;',['create'], ['class' => 'btn btn-success'])?></font>

    </span>
</div>

<table class="table table-striped">
  <thead>
    <tr>
      <th>Заголовок</th>
      <th>Действие</th>
    </tr>
  </thead>

  <tbody>
    <tr>

        <?php foreach ($spisok as $sp): ?>


       <td>
           <?php echo
               '<h4>
                    <a href="'.Url::toRoute(['zadachi/zad', 'id' => $sp->id]).'"  
                        style="text-decoration: none"> &#9776; '.$sp->title.' 
                     </a>
                </h4>'
           ?>
       </td>

        <td>
            <span> <?= Html::a(' &#10008;', ['delete', 'id' => $sp->id], ['class' => 'label label-danger'])?> </span>

            <span> <?= Html::a('&#10000;', ['update', 'id' => $sp->id], ['class'=>"label label-warning"])?> </span>

        </td>
    </tr>
    <?php endforeach ?>
  </tbody>
</table>



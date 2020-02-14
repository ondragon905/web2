<?php
use yii\helpers\html;
use common\models\Posts;
use yii\widgets\ActiveForm;
?>
<?php
$form = \yii\widgets\ActiveForm::begin() ?>

<div class = "row">
    <div class = "form-group">
        <div class = "col-lg-6">
            <?= $form->field($zad, 'title') -> textarea(['rows' => '2']);?>
        </div>
    </div>
</div>

<div class = "row">
    <div class = "form-group">
        <div class = "col-lg-6">
            <div class = "col-lg-3">
                <?= Html::submitButton('Изменить',  ['class' => 'btn btn-success'])?>
            </div>

            <div class = "col-lg-2">
                <?= Html::a('Назад', ['/site/contact'],  ['class' => 'btn btn-success'])?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end() ?>

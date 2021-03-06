<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuarios-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apellido')->textInput(['maxlength' => true]) ?>

    <?=
    $form->field($model, 'fechanacimiento')->widget(\yii\jui\DatePicker::class, [
            'language' => 'es',
            'dateFormat' => 'dd/MM/yyyy',
            'clientOptions' => [
                'changeMonth' => 'true',
                'changeYear' => 'true',
            ],
    ])
    ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= ($operacion == 'alta') ? $form->field($model, 'username')->textInput(['maxlength' => true]) : '' ?>

        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <div class="form-group">
    <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>

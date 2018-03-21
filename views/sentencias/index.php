<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SentenciasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sentencias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sentencias-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Sentencias', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'sentencia',
            'usuarios_id',
            'chats_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

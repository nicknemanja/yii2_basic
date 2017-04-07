<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FeedType */

$this->title = 'Update Feed Type: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Feed Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="feed-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

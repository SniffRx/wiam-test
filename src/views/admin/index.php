<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<h1>Admin Panel</h1>

<table class="table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Decision</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($decision as $decision_1): ?>
        <tr>
            <td><a href="https://picsum.photos/id/<?= Html::encode($decision_1['image_id']) ?>/600/500" target="_blank"><?= Html::encode($decision_1['image_id']) ?></a></td>
            <td><?= Html::encode($decision_1['decision']) ?></td>
            <td><?= Html::a('Undo', ['admin/undo', 'id' => $decision_1['id'], 'token' => 'xyz123'], ['class' => 'btn btn-warning']) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

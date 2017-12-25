<?php
/** @var \frontend\models\Pages $model */
?>

<div id="page-container">
    <div class="container">
        <h1><?php echo $model->getHeader(); ?></h1>
    
        <div class="content">
            <?php echo $model->content ?>
        </div>
    </div>
</div>


<?#= $this->render('blocks/faq.php', ['data' => $data['faq']]); ?>

<?= $this->render('blocks/contacts.php', ['data' => $data['contacts']]); ?>
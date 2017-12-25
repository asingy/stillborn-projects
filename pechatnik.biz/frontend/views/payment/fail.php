
<div id="page-container">
    <div class="container">
        <h1>Ошибка!</h1>

        <div class="content">
            Заказ №<?php echo $number; ?>
        </div>
    </div>
</div>


<?= $this->render('../site/blocks/faq.php', ['data' => $data['faq']]); ?>

<?= $this->render('../site/blocks/contacts.php', ['data' => $data['contacts']]); ?>
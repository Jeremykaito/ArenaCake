<?=$this->Html->css('Datatables.jquery.dataTables.min');?>
<?= $this->Html->script('jquery.min.js');?>
<?= $this->Html->script('Datatables.jquery.dataTables.min');?>
<?= $this->Html->script('Datatables.shCore'); ?>
<?=$this->assign('title', 'WebArena - Journal');?>	
<?=$this->assign('header_title', 'Journal');?>

<script>
    $(document).ready(function () {
        $('#diary').DataTable({
            "order": [[3, "desc"]]
        });
    });
</script>

<section class='cadre_gris'>

    <p>Bienvenue dans le journal ! </p>
    <p>Ici, vous pouvez voir les évènements qui se sont produits au cours des dernières 24h à proximité de vos personnages.</p>
    <p>Ainsi, vous êtes sûr de n'avoir rien raté pendant votre absence !</p>

    <?php 
    if(!empty($events)){?>
    <table id="diary" class="display">
        <thead>
            <tr>
                <th>Name</th>
                <th>Date</th>
                <th>Coordinate X</th>
                <th>Coordinate Y</th>
            </tr>
        </thead>
        <?php foreach ($events as $event): ?>
        <tr>
            <td><?= $event->name ?></td>
            <td><?= $event->date ?></td>
            <td><?= $event->coordinate_x ?></td>
            <td><?= $event->coordinate_y ?></td>
        </tr>
    <?php endforeach; ?>
    </table>
    <?php
    }
    else{?>
    <p>Il n'y a aucun évènement à afficher ! Revenez plus tard.</p>
    <?php }
    ?>
</section>
<?=$this->Html->css('Datatables.jquery.dataTables.min');?>
<?= $this->Html->script('jquery.min.js');?>
<?= $this->Html->script('Datatables.jquery.dataTables.min');?>
<?= $this->Html->script('Datatables.shCore'); ?>
<?=$this->assign('title', 'WebArena - Journal');?>
<?=$this->assign('header_title', 'Journal');?>

<script>
    $(document).ready(function () {
        $('#diary').DataTable({
            "order": [[1, "desc"]],
            "language": {
              search: "Rechercher",
              info: "",
              "lengthMenu":     "Montrer _MENU_ Entrées",
              emptyTable:     "Aucun événement durant les dernières 24h, allez on se bouge!",
              paginate: {
                first:      "Début",
                previous:   "Précédente",
                next:       "Suivante",
                last:       "Fin"
              }
            }
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
                <th>Nom</th>
                <th>Date</th>
                <th>Coordonnée X</th>
                <th>Coordonnée Y</th>
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

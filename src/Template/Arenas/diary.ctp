<?= $this->Html->css('Datatables.jquery.dataTables.min');?>
<?= $this->Html->script('jquery.min.js');?>
<?= $this->Html->script('Datatables.jquery.dataTables.min');?>
<?= $this->Html->script('Datatables.shCore'); ?>

<script>
$(document).ready(function() {
 $('#diary').DataTable( {
  "order": [[ 3, "desc" ]]
 } );
} );
 </script>

 <section>
    <h1>DataTables example <span>Default ordering (sorting)</span></h1>
    <!--//Tableau a copier mais avec boucle for-->
    <table id="diary" class="display">
     <thead>
      <tr>
       <th>Name</th>
       <th>Position</th>
       <th>Office</th>
       <th>Age</th>
       <th>Start date</th>
       <th>Salary</th>
      </tr>
     </thead>
     <tfoot>
      <tr>
       <th>Name</th>
       <th>Position</th>
       <th>Office</th>
       <th>Age</th>
       <th>Start date</th>
       <th>Salary</th>
      </tr>
     </tfoot>
     <tbody>
     <?php for($i=0;$i<100; $i++){ ?>
      <tr>
       <td>Lael Greer</td>
       <td>Systems Administrator</td>
       <td>London</td>
       <td>21</td>
       <td>2009/02/27</td>
       <td>$103,500</td>
      </tr>
      <?php  }?>
      <tr>
       <td>Jonas Alexander</td>
       <td>Developer</td>
       <td>San Francisco</td>
       <td>30</td>
       <td>2010/07/14</td>
       <td>$86,500</td>
      </tr>
      <tr>
       <td>Shad Decker</td>
       <td>Regional Director</td>
       <td>Edinburgh</td>
       <td>51</td>
       <td>2008/11/13</td>
       <td>$183,000</td>
      </tr>
      <tr>
       <td>Michael Bruce</td>
       <td>Javascript Developer</td>
       <td>Singapore</td>
       <td>29</td>
       <td>2011/06/27</td>
       <td>$183,000</td>
      </tr>
      <tr>
       <td>Donna Snider</td>
       <td>Customer Support</td>
       <td>New York</td>
       <td>27</td>
       <td>2011/01/25</td>
       <td>$112,000</td>
      </tr>
     </tbody>
    </table>
  </section>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    
    <title>Schools</title>

    <script type="text/javascript" src="<?=base_url()?>javascript/jquery.js"></script>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>

         <?php echo link_tag('css/style.css', 'stylesheet', 'text/css'); ?>
        
</head>
  
  <body>
<h1><?=$groups[0]['trainer_name']?></h1>
      <?php $enrollments= 0;
      $schools = 0;
      $ids = array();?>
       <table class="table table-striped">
        <thead>
            <tr>
                <th>Hub</th>
                <th>Name</th>
                <th>Enrollment</th>
                <th>%meet+</th>
                <th>Miles</th>
            </tr>
        </thead>
    
    <?php $groups_count = 0;?>
    <?php foreach($groups AS $g):

        
    ?>
        
        <?php $groups_count++;?>
        
       
            <tr class="primary">
                <td><?=$groups_count?></td>
                <td><?=$g['school_name']?></td>
                <td><?=$g['total_enrollment']?></td>
                <td><?=$g['meet_or_exceeds']?></td>
                <td></td>
             
            </tr>
            <?php foreach ($g['near'] as $row): 
            
               if(!in_array($row['id'],$ids)):
            $enrollment = $enrollment+$row['total_enrollment'];
            $schools++;?>
            
            <tr>
                <td><?=$groups_count?></td>
                <td><strong><?=$row['school_name']?></strong></td>
                <td><?=$row['total_enrollment']?></td>
                <td><?=$row['meet_or_exceeds']?></td>  
                <td><?=$row['distance']?></td>
            </tr>
            
            <?php  endif;$ids[] = $row['id']; endforeach;?>
            <tr>
                <td colspan="5"><hr></td> 
            </tr>
                
<?php endforeach;?>

</table>

<?php var_dump($enrollment,$schools,$ids);?>
</body>
</html>
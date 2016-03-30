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
    <?php foreach($groups AS $g):?>
        
        <?php $groups_count++;?>
        
       
            <tr class="primary">
                <td><?=$groups_count?></td>
                <td><?=$g['school_name']?></td>
                <td><?=$g['total_enrollment']?></td>
                <td><?=$g['meet_or_exceeds']?></td>
                <td></td>
             
            </tr>
            <?php foreach ($g['near'] as $row): ?>
            
            <tr>
                <td><?=$groups_count?></td>
                <td><strong><?=$row['school_name']?></strong></td>
                <td><?=$row['total_enrollment']?></td>
                <td><?=$row['meet_or_exceeds']?></td>  
                <td><?=$row['distance']?></td>
            </tr>
            
            <?php endforeach;?>
            <tr>
                <td colspan="5"><hr></td> 
            </tr>
                
        <script>
                var geocoder<?=$groups_count?>;
                var map<?=$groups_count?>;
                var places<?=$groups_count?> = [];
                var descriptions<?=$groups_count?> = [];
                var infowindow<?=$groups_count?> = new google.maps.InfoWindow();
                var markers<?=$groups_count?> = [];        



                function initialize<?=$groups_count?>() {
                    // Create inital Google Map
                    var latlng<?=$groups_count?> = new google.maps.LatLng(43.59311 , -72.452085);
                    var myOptions<?=$groups_count?> = {
                        zoom: 8,
                        center: latlng<?=$groups_count?>,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    };

                    map<?=$groups_count?> = new google.maps.Map(document.getElementById("map_canvas<?=$groups_count?>"), myOptions<?=$groups_count?>);

                   var bounds<?=$groups_count?> = new google.maps.LatLngBounds();


                   // Create marker 
                   
                        markerlatlong<?=$groups_count?> = new google.maps.LatLng('<?=$g['lat']?>','-<?=$g['lng']?>')
                        
                      var circlepoint<?=$groups_count?> = new google.maps.Marker({
                        map: map<?=$groups_count?>,
                        html: "<?=$g['name']?>",
                        position: markerlatlong<?=$groups_count?>,
                        title: ' <?=$g['name']?> ',
                        icon: '<?=base_url()?>images/blue_7.png'
                      });

                      bounds<?=$groups_count?>.extend(markerlatlong<?=$groups_count?>);
                      
                      <?php $count = 1;?>
                   <?php foreach ($g['near'] as $row): ?>
                   <?php $count++;?>
                        markerlatlong<?=$groups_count?> = new google.maps.LatLng('<?=$row['lat']?>','<?=$row['lng']?>')

                         var marker<?=$groups_count?> = new google.maps.Marker({
                             map: map<?=$groups_count?>,
                             position: markerlatlong<?=$groups_count?>,
                             index : <?=$count?>,
                             html: "<h3><?=$row['school_name']?></h3> <p><?=$row['total_enrollment']?><br><?=$row['meet_or_exceeds']?></p>"<?php if ($row['y2010'] == 1): ?>,
                             icon: '<?=base_url()?>images/alert_7.png' <?php else:?>,
                             icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|FE7569'
                             <?php endif; ?>
                         });

                         bounds<?=$groups_count?>.extend(markerlatlong<?=$groups_count?>);

                         markers<?=$groups_count?>[<?=$count?>] = marker<?=$groups_count?>;

                         google.maps.event.addListener(marker<?=$groups_count?>, 'click', function () {
                             infowindow.setContent(this.html);
                             infowindow.open(map<?=$groups_count?>, this);
                         });
                         
                   <?php endforeach;?>



                   map<?=$groups_count?>.fitBounds(bounds<?=$groups_count?>);
                   

                }  
                
                $(document).ready(function () {

                    initialize1();

                $('#display_map<?=$groups_count?>').click(function() {
                        
                      $('#map_canvas<?=$groups_count?>').show();
                      
                          initialize<?=$groups_count?>();
                    });
                  });
           </script>




<?php endforeach;?>

</table>

</body>
</html>
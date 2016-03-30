<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    
    <title>Schools</title>

    <script type="text/javascript" src="<?=base_url()?>javascript/jquery.js"></script>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <!--<script type="text/javascript" src="http://gmaps-utility-library-dev.googlecode.com/svn/tags/mapiconmaker/1.1/src/mapiconmaker_packed.js"></script>-->

                 <?php echo link_tag('css/style.css', 'stylesheet', 'text/css'); ?>
        
</head>
  
  <body>

      
      
      <?php $train_count = 0;?>
    <?php foreach($trainers AS $t):?>
        
        <h1><?=$t['name']?>  </h1>
        
        <?php $train_count++;?>
        <script>
                var geocoder<?=$train_count?>;
                var map<?=$train_count?>;
                var places<?=$train_count?> = [];
                var descriptions<?=$train_count?> = [];
                var infowindow<?=$train_count?> = new google.maps.InfoWindow();
                var markers<?=$train_count?> = [];        



                function initialize<?=$train_count?>() {
                    // Create inital Google Map
                    var latlng<?=$train_count?> = new google.maps.LatLng(43.59311 , -72.452085);
                    var myOptions<?=$train_count?> = {
                        zoom: 8,
                        center: latlng<?=$train_count?>,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    };

                    map<?=$train_count?> = new google.maps.Map(document.getElementById("map_canvas<?=$train_count?>"), myOptions<?=$train_count?>);

                   var bounds<?=$train_count?> = new google.maps.LatLngBounds();


                   // Create marker 
                      var circlepoint<?=$train_count?> = new google.maps.Marker({
                        map: map<?=$train_count?>,
                        html: "<?=$t['name']?>",
                        position: new google.maps.LatLng(<?=$t['lat']?> , <?=$t['lng']?> ),
                        title: ' <?=$t['name']?> ',
                        icon: '<?=base_url()?>images/blue_7.png'
                      });

                      // Add circle overlay and bind to marker
                      var circle<?=$train_count?> = new google.maps.Circle({
                        map: map<?=$train_count?>,
                          html: "<?=$t['name']?>",
                        radius: <?=($miles * 1609.3)?>,    // 10 miles in metres
                        fillColor: '#AA0000'
                      });
                      circle<?=$train_count?>.bindTo('center', circlepoint<?=$train_count?>, 'position');



                      <?php $count = 1;?>
                   <?php foreach ($t['schools'] as $row): ?>
                   <?php $count++;?>
                        markerlatlong<?=$train_count?> = new google.maps.LatLng('<?=$row->lat?>','<?=$row->lng?>')

                         var marker<?=$train_count?> = new google.maps.Marker({
                             map: map<?=$train_count?>,
                             position: markerlatlong<?=$train_count?>,
                             index : <?=$count?>,
                             html: "<h3><?=$row->school_name?></h3> <p><?=$row->total_enrollment?><br><?=$row->meet_or_exceeds?></p>"<?php if ($row->y2010 == 1): ?>,
                             icon: '<?=base_url()?>images/alert_7.png' <?php else:?>,
                             icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|FE7569'
                             <?php endif; ?>
                         });

                         bounds<?=$train_count?>.extend(markerlatlong<?=$train_count?>);

                         markers<?=$train_count?>[<?=$count?>] = marker<?=$train_count?>;

                         google.maps.event.addListener(marker<?=$train_count?>, 'click', function () {
                             infowindow.setContent(this.html);
                             infowindow.open(map<?=$train_count?>, this);
                         });
                   <?php endforeach;?>

                   <?php foreach ($fwni_schools->result() as $row):?>
                   <?php $count++;?>
                        markerlatlong<?=$train_count?> = new google.maps.LatLng('<?=$row->lat?>','-<?=$row->lng?>')

                         var marker<?=$train_count?> = new google.maps.Marker({
                             map: map<?=$train_count?>,
                             position: markerlatlong<?=$train_count?>,
                             index : <?=$count?>,
                             html: "<h3><?=$row->school_name?></h3> <p>Enrollment: <?=$row->total_enrollment?><br>%meeting: <?=$row->meet_or_exceeds?></p>"<?php if($row->y2011 == 1):?>,
                             icon: '<?=base_url()?>images/15.png' <?php else: ?>,
                             icon: '<?=base_url()?>images/alert_7.png'
                             <?php endif; ?>
                         });


                         markers<?=$train_count?>[<?=$count?>] = marker<?=$train_count?>;

                         google.maps.event.addListener(marker<?=$train_count?>, 'click', function () {
                             infowindow.setContent(this.html);
                             infowindow.open(map<?=$train_count?>, this);
                         });
                   <?php endforeach; ?>


                   map<?=$train_count?>.fitBounds(bounds<?=$train_count?>);


                }
                   $(document).ready(function () {

                     initialize<?=$train_count?>();



                   });
           </script>

        <div id="map_canvas<?=$train_count?>" style="width: 100%; height: 500px;"></div>

        </div>      
        
        
        
        
    <table class="table table-striped">
        <thead>
          <tr>
            <th>School Name</th>
              <th>FWNI Status</th>
            <th>Total Enrollment</th>
            <th>Meets or exceeds Percentage</th>
            <th>Distance</th>
          </tr>
        </thead>
        <tbody>

<?php     
   foreach ($t['schools'] as $row):

?>
   <tr>
    <td><strong><?=$row->school_name?></strong></td>
       <td><?=$row->y2010?></td>
       <td><?=$row->total_enrollment?></td>
    <td><?=$row->meet_or_exceeds?></td>  
    <td><?=$row->distance?></td>
   </tr>
<?php endforeach;?>   
</tbody>
</table>


<?php endforeach;?>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    
    <title>Schools</title>

    <script type="text/javascript" src="<?=base_url()?>javascript/jquery.js"></script>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <!--<script type="text/javascript" src="http://gmaps-utility-library-dev.googlecode.com/svn/tags/mapiconmaker/1.1/src/mapiconmaker_packed.js"></script>-->

        
</head>
  
  <body>
      
      


<script>
        var geocoder;
        var map;
        var places = [];
        var descriptions = [];
        var infowindow = new google.maps.InfoWindow();
        var markers = [];        

        $(document).ready(function () {

            initialize();

        });

        function initialize() {
            // Create inital Google Map
            var latlng = new google.maps.LatLng(-34.397, 150.644);
            var myOptions = {
                zoom: 8,
                center: latlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

           var bounds = new google.maps.LatLngBounds();



           <?php foreach($trainers AS $t): ?>
          
           // Create marker 
              var circlepoint = new google.maps.Marker({
                map: map,
                position: new google.maps.LatLng(<?=$t['lat']?> , <?=$t['lng']?> ),
                title: ' <?=$t['name']?> ',
                icon: 'http://www.google.com/intl/en_us/mapfiles/ms/micons/blue-dot.png'
              });

              // Add circle overlay and bind to marker
              var circle = new google.maps.Circle({
                map: map,
                radius: <?=($miles * 1609.3)?>,    // 10 miles in metres
                fillColor: '#AA0000'
              });
              circle.bindTo('center', circlepoint, 'position');
              
              <?php $count = 1;?>
           <?php foreach ($t['schools'] as $row): ?>
           <?php $count++;?>
                markerlatlong = new google.maps.LatLng('<?=$row->lat?>','<?=$row->lng?>')

                 var marker = new google.maps.Marker({
                     map: map,
                     position: markerlatlong,
                     index : <?=$count?>,
                     html: "<h3><?=$row->school_name?></h3> <p><?=$row->total_enrollment?><br><?=$row->meet_or_exceeds?></p>"<?php if($row->y2011 == 1):?>,
                     icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|108510' <?php elseif ($row->y2010 == 1): ?>,
                     icon: '<?=base_url()?>images/alert_7.png' <?php else:?>,
                     icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|FE7569'
                     <?php endif; ?>
                 });

                 bounds.extend(markerlatlong);

                 markers[<?=$count?>] = marker;

                 google.maps.event.addListener(marker, 'click', function () {
                     infowindow.setContent(this.html);
                     infowindow.open(map, this);
                 });
           <?php endforeach;?>
           <?php endforeach;?>

           <?php foreach ($fwni_schools->result() as $row):?>
           <?php $count++;?>
                markerlatlong = new google.maps.LatLng('<?=$row->lat?>','-<?=$row->lng?>')

                 var marker = new google.maps.Marker({
                     map: map,
                     position: markerlatlong,
                     index : <?=$count?>,
                     html: "<h3><?=$row->school_name?></h3> <p>Enrollment: <?=$row->total_enrollment?><br>%meeting: <?=$row->meet_or_exceeds?></p>"<?php if($row->y2011 == 1):?>,
                     icon: '<?=base_url()?>images/15.png' <?php else: ?>,
                     icon: '<?=base_url()?>images/alert_7.png'
                     <?php endif; ?>
                 });

                 bounds.extend(markerlatlong);

                 markers[<?=$count?>] = marker;

                 google.maps.event.addListener(marker, 'click', function () {
                     infowindow.setContent(this.html);
                     infowindow.open(map, this);
                 });
           <?php endforeach; ?>


           map.fitBounds(bounds);


        }  
   </script>

<div id="map_canvas" style="width: 100%; height: 700px;"></div>

</div>

   

    <?php 
    $ids = array();
    $schools = 0;
    $enrollment = 0;
    
    foreach($trainers AS $t):?>
        <h1><?=$t['name']?>  </h1>
    <table>
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

   if(!in_array($row->id,$ids)):
   $schools++;
$enrollment = $enrollment+$row->total_enrollment;

?>
   <tr>
    <td><strong><?=$row->id.$row->school_name?></strong></td>
       <td><?=$row->y2010?></td>
       <td><?=$row->total_enrollment?></td>
    <td><?=$row->meet_or_exceeds?></td>  
    <td><?=$row->distance?></td>
   </tr>
<?php        endif;
       $ids[] = $row->id;
       endforeach;?>   
</tbody>
</table>


<?php endforeach;?>


<?php var_dump($ids,$enrollment,$schools);?>
</body>
</html>
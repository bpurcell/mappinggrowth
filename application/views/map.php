<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    
    <title>Schools</title>

    <script type="text/javascript" src="<?=base_url()?>javascript/jquery.js"></script>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>

        
</head>
  
  <body>
      
    <table>
        <thead>
          <tr>
            <th>Location Name</th>
            <th>Category</th>
            <th>Submitter</th>
          </tr>
        </thead>
        <tbody>

<?php     
   foreach ($schools->result() as $row):

?>
   <tr>
    <td><strong><?=$row->school_name?></strong></td>
    <td><?=$row->total_enrollment?></td>
    <td><?=$row->meet_or_exceeds?></td>  
   </tr>
<?php endforeach;?>   
</tbody>
</table>



</div>
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


        <?php if(false):?>
           // Create marker 
           var circlepoint = new google.maps.Marker({
             map: map,
             position: new google.maps.LatLng(<?=$applet->lat?>, <?=$applet->lng?>),
             title: 'Your Center'
           });

           // Add circle overlay and bind to marker
           var circle = new google.maps.Circle({
             map: map,
             radius: <?=($applet->distance * 1609.3)?>,    // 10 miles in metres
             fillColor: '#AA0000'
           });
           circle.bindTo('center', circlepoint, 'position');
       <?php endif ?>



            <?php    
            $count = 1;
               foreach ($schools->result() as $row):
               $count++;
            ?>
            markerlatlong = new google.maps.LatLng('<?=$row->lat?>','<?=$row->lng?>')

             var marker = new google.maps.Marker({
                 map: map,
                 position: markerlatlong,
                 index : <?=$count?>,
                 html: "<h3><?=$row->school_name?></h3> <p><?=$row->total_enrollment?></p>" 
             });

             bounds.extend(markerlatlong);

             markers[<?=$count?>] = marker;

             google.maps.event.addListener(marker, 'click', function () {
                 infowindow.setContent(this.html);
                 infowindow.open(map, this);
             });
           <?php endforeach;?>

           map.fitBounds(bounds);


        }  
   </script>

<div id="map_canvas" style="width: 100%; height: 600px;"></div>

</div>


</body>
</html>
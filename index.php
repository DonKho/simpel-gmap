<?php

	// Awal Script Koneksi

	$host = "localhost";
	$username = "root";
	$password = "";
	$db_name = "test";

	$mysqli = new mysqli($host,$username,$password,$db_name);

	// Akhir Script Koneksi

	// Awal Script Panggil data

	$query = "SELECT * from tbl_map";
	$result = $mysqli->query($query);

	// Akhir Script Panggil data

?>
<html>
<head>
	<title>Google Maps</title>
</head>
<body>
	<div style="width:100%; height:100%" id="gmap"></div>


// Script panggil Google Map API, silahkan ganti API Keynya sesuai dengan project yang dibuat di Google Developer
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDaT93DT0DeY0AhEoFR1eRXmDl6fRAGjQM&sensor=false"></script>

<script type="text/javascript">
		// Inisiasi variabel map
		var map;
        //Parameter Google maps
        var options = {
          zoom: 17, //level zoom
        //posisi tengah peta
          center: new google.maps.LatLng(-5.146049, 119.438221),
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
      
       // Buat variabel peta baru
        var map = new google.maps.Map(document.getElementById('gmap'), options);

        var i = 0;
        var content = new Array();
        var infowindow = new google.maps.InfoWindow();

            <?php while($data = mysqli_fetch_array($result)) { ?>


                
                // Buat Konten Info Window
                content[i] = "<?php echo $data['nama']; ?>";                


	            // Ganti image marker
	            var marker_icon = {
	                url: 'icon.png'
	            };
                
                // Buat menempatkan titik lokasi marker
                var locLatLng = new google.maps.LatLng (
                    <?php echo $data['lattitude']; ?>, 
                    <?php echo $data['longitude']; ?>
                );
            
                // Create marker
                var marker = new google.maps.Marker({
                    position: locLatLng,
                    map: map,
                    icon: marker_icon,
                    title: "<?php echo $data['nama']; ?>"
                });


                // Buat menangani kejadian apabila marker di klik makan muncul infowindow
                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                    
                    infowindow.setContent(content[i]);
                    infowindow.open(map,marker);
                    }
                })(marker, i));
            
                
                i = i + 1;
        	<?php } ?> 
</script>

</body>
</html>



    var lat = 36.236032;
    var lon = 1.175735;
    var mycard = null;
    const mymap = 1.5;
    // Card initialization
    function initMap() {
      // // Create the "mycard" object and put it in the html element with the id "map"
      mycard = L.map('map').setView([lat,lon], 10);
      // Leaflet does not retrieve tiles from a server by default. We have to tell him where we want to get them. Here, openstreetmap.org
      L.tileLayer('	https://a.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        // It's a good idea to leave the link to the data source.
        attribution: 'Copyright@ Smart Traveller</a>',
        minZoom: 1,
        maxZoom: 19,
      }).addTo(mycard);
      // markers
      var xhttp1 = new XMLHttpRequest();
      var xhttp2 = new XMLHttpRequest();
      var recommended_poi_array = [];
     
    
      
        //xhttp function
        xhttp1.onreadystatechange = function() {
          if (this.readyState == 4) {
            if (this.status == 200) {

              let data = JSON.parse(this.responseText);
              Object.entries(data.pois).forEach((poi) => {

                recommended_poi_array.push(poi[1].id);

                var self_icon = L.icon({
                  iconUrl: 'https://smart-traveller.000webhostapp.com/assets/icons/recommendation icons/' + poi[1].type + '-rec.png',

                  iconSize: [42, 47], // size of the icon
                  iconAnchor: [21, 47], // point of the icon which will correspond to marker's location
                  popupAnchor: [0, -40] // point from which the popup should open relative to the iconAnchor

                });

                let marker = L.marker([poi[1].latitude, poi[1].longitude], {
                  icon: self_icon ,
                  zIndexOffset :1000
                }).addTo(mycard);
                
                var popup_content =
                  '<div class="row"> <div class="col-md"><h5 class="font-weight-bold text-center">' + poi[1].designation + '</h5> </div> </div> <div class="row"> <div class="col-md"> <p class="text-center">' ;
                  if(poi[1].description == null){
                    popup_content += poi[1].type;
                  }else{
                    popup_content += poi[1].description;
                  }
                  popup_content += '</p> </div> </div> <div class="row"> <div class="col-md d-flex justify-content-end"> <a class="btn btn-green " href="?';
                if (sap_bool){
                  popup_content += "show_all_places&";
                }
                popup_content += "poi_details_id=" + poi[1].id;
                if (Array.isArray(poi[1].RS)) {
                  poi[1].RS.forEach((RS_id) => {

                    popup_content += "&RS" + RS_id;
                  });
                } else {
                  popup_content += "&RS" + poi[1].RS;
                }
                popup_content += '#poi_details" style="color: rgb(42, 53, 11);  border-radius: 20px; padding: 8px 15px 8px 15px;"><b>Details...</b></a>';

                marker.bindPopup(popup_content);
              });

                  //Geolocation Service
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition((position) => {
            // Storing Longitude and Latitude in variables
            var current_long = position.coords.longitude;
            var current_lat = position.coords.latitude; 
          // Show current position icon on the Map
          var current_position_marker = L.marker([current_lat,current_long],{zIndexOffset :1200}).addTo(mycard);
          current_position_marker.bindPopup("Current position");

      });
    }
            } else {
              console.log(this.statusText);
            }
          }
        };
        xhttp1.open(
          'GET',
          'https://smart-traveller.000webhostapp.com/includes/logic/recommended-markers.php',
          true
        );
       
      xhttp1.send();

       //show all pois parameter boolean
       if (sap_bool) {
      
        //xhttp function
        xhttp2.onreadystatechange = function() {
          if (this.readyState == 4) {
            if (this.status == 200) {

              let data = JSON.parse(this.responseText);
              console.log(recommended_poi_array);

           
           
              Object.entries(data.pois).forEach((poi) => {
              if(!recommended_poi_array.includes(poi[1].id)){


                  var self_icon = L.icon({
                    iconUrl: 'https://smart-traveller.000webhostapp.com/assets/icons/' + poi[1].type + '.png',

                    iconSize: [32, 37], // size of the icon
                    iconAnchor: [16, 37], // point of the icon which will correspond to marker's location
                    popupAnchor: [0, -30] // point from which the popup should open relative to the iconAnchor

                  });
                
              
                let marker = L.marker([poi[1].latitude, poi[1].longitude], {
                  icon: self_icon
                }).addTo(mycard);

            
                var popup_content =
                '<div class="row"> <div class="col-md"><h5 class="font-weight-bold text-center">' + poi[1].designation + '</h5> </div> </div> <div class="row"> <div class="col-md"> <p class="text-center">' ;
                if(poi[1].description == null){
                  popup_content += poi[1].type;
                }else{
                  popup_content += poi[1].description;
                }
                popup_content += '</p> </div> </div> <div class="row"> <div class="col-md d-flex justify-content-end"> <a class="btn btn-green " href="?show_all_places&poi_details_id=' + poi[1].id + '#poi_details" style="color: rgb(42, 53, 11);  border-radius: 20px; padding: 8px 15px 8px 15px;"><b>Details...</b></a>';
              marker.bindPopup(popup_content);

            }
              });
            } else {
              console.log(this.statusText);
            }
          }
        };
        xhttp2.open(
          'GET',
          'https://smart-traveller.000webhostapp.com/includes/logic/map-markers.php',
          true
        );
        xhttp2.send();
      }
    }

    window.onload = function() {
      // Fonction d'initialisation qui est exécutée lorsque le DOM est chargé
      initMap();
    };
  



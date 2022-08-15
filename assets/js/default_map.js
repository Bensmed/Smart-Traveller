
var lat = 36.236032;
var lon = 1.175735;
var mycard = null;
const mymap = 1.5;



// Card initialization
function initMap() {
  // // Create the "mycard" object and put it in the html element with the id "map"
  mycard = L.map('map').setView([lat, lon],10);
  // Leaflet does not retrieve tiles from a server by default. We have to tell him where we want to get them. Here, openstreetmap.org
  L.tileLayer('	https://a.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    // It's a good idea to leave the link to the data source.
    attribution: 'Copyright@ Smart Traveller</a>',
    minZoom: 1,
    maxZoom: 19,
  }).addTo(mycard);
  // markers


  var xhttp = new XMLHttpRequest();

  //xhttp function
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4) {
      if (this.status == 200) {

        let data = JSON.parse(this.responseText);

        Object.entries(data.pois).forEach((poi) => {

          //init full path of icons 
          let self_icon = L.icon({
            iconUrl: 'https://smart-traveller.000webhostapp.com/assets/icons/' + poi[1].type + '.png',

            iconSize: [32, 37], // size of the icon
            iconAnchor: [16, 37], // point of the icon which will correspond to marker's location
            popupAnchor: [0, -30] // point from which the popup should open relative to the iconAnchor
          });
          //Fetch POI's Markers
          let marker = L.marker([poi[1].latitude, poi[1].longitude], {
            icon: self_icon
          }).addTo(mycard);
          var popup_content =
          '<div class="row"> <div class="col-md"><h5 class="font-weight-bold text-center">' + poi[1].designation + '</h5> </div> </div> <div class="row"> <div class="col-md"> <p class="text-center">';
          if(poi[1].description == null){
            popup_content += poi[1].type;
          }else{
            popup_content += poi[1].description;
          }
          if(is_loggedIn == true){
            popup_content += '</p> </div> </div> <div class="row"> <div class="col-md d-flex justify-content-end"> <a class="btn btn-green" href="Recommendation?poi_details_id=' + poi[1].id + '#poi_details" style=" color: #212923e0;" >Details</a> </div> </div>';
         
        }else{
           popup_content += '</p> </div> </div> <div class="row"> <div class="col-md d-flex justify-content-end"> <a class="btn btn-green" data-toggle="modal" href="#" data-target="#loginModal" style=" color: #212923e0;" >Details</a> </div> </div>';
        }
        marker.bindPopup(popup_content);

        });
      
        //Geolocation Service
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition((position) => {
            // Storing Longitude and Latitude in variables
            var current_long = position.coords.longitude;
            var current_lat = position.coords.latitude; 
          // Show current position icon on the Map
          var current_position_marker = L.marker([current_lat,current_long],{zIndexOffset :1000}).addTo(mycard);
          current_position_marker.bindPopup("Current position");

      });
    }

    
      } else {
        console.log(this.statusText);
      }
    }
  };
 
  xhttp.open(
    'GET',
    'https://smart-traveller.000webhostapp.com/includes/logic/map-markers.php',
    true
  );
  xhttp.send();
}

window.onload = function() {
  // Fonction d'initialisation qui est exécutée lorsque le DOM est chargé
  initMap();
};



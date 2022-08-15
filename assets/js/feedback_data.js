
window.addEventListener('load', () => {
  // Openweathermap API. Do not share it publicly.
  const api = '6610c0760fa7cbbf829eb77c0176b042'; //Replace with your API


  const tempC = document.getElementById('poi_temp');
  const desc = document.getElementById('poi_weather');
  const current_long = document.getElementById('feedback_long');
  const current_lat = document.getElementById('feedback_lat');
  
  
  
    // Accesing Geolocation of User
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition((position) => {
        // Storing Longitude and Latitude in variables
        var user_long = position.coords.longitude;
        var user_lat = position.coords.latitude; 
   
        const base = `https://api.openweathermap.org/data/2.5/weather?lat=${user_lat}&lon=${user_long}&appid=${api}&units=metric`;
    
    //  document.writeln(long+"<br>"+lat);
  
        // Using fetch to get data
        fetch(base)
          .then((response) => {
            return response.json();
          })
          .then((data) => {
            const { temp } = data.main;
            const { main } = data.weather[0];
  
      
            // Interacting with DOM to show data
            desc.value = `${main}`;
            tempC.value = `${temp.toFixed(2)}`;
            current_lat.value = user_long;
            current_long.value = user_lat;
  
        
          });
      });
    }
  });
  
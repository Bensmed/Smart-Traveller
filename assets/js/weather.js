
window.addEventListener('load', () => {
// Openweathermap API. Do not share it publicly.
const api = '6610c0760fa7cbbf829eb77c0176b042'; //Replace with your API
  let long;
  let lat;
const iconImg = document.getElementById('weather-icon');
const loc = document.querySelector('#location');
const tempC = document.querySelector('.c');
const desc = document.querySelector('.desc');



  // Accesing Geolocation of User
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition((position) => {
      // Storing Longitude and Latitude in variables
      var current_long = position.coords.longitude;
      var current_lat = position.coords.latitude; 
 
      const base = `https://api.openweathermap.org/data/2.5/weather?lat=${current_lat}&lon=${current_long}&appid=${api}&units=metric`;
	
	//  document.writeln(long+"<br>"+lat);

      // Using fetch to get data
      fetch(base)
        .then((response) => {
          return response.json();
        })
        .then((data) => {
          const { temp, feels_like } = data.main;
          const place = data.name;
          const { main, description, icon } = data.weather[0];

          const iconUrl = `https://openweathermap.org/img/wn/${icon}@2x.png`;
		
          // Interacting with DOM to show data
          iconImg.src = iconUrl;
          loc.textContent = `${place}`;
          desc.textContent = `${description}`;
          tempC.textContent = `${temp.toFixed(2)} °C`;

          document.cookie = 'weather=' + `${main}`; 
		  
        });
    });
  }
});

const apiKey = "1e9c398347e6ef79f8f40e36c69f24e5";
const apiUrl =
  "https://api.openweathermap.org/data/2.5/weather?units=metric&q=";

const cities = ["London", "Mumbai", "New York"];
const weatherIcons = {
  Clouds: "images/clouds.png",
  Clear: "images/clear.png",
  Rain: "images/rain.png",
  Drizzle: "images/drizzle.png",
  Mist: "images/mist.png",
  Haze: "images/mist.png",
  Smoke: "images/smoke.png",
};

async function updateWeather(city, cardIndex) {
  const response = await fetch(apiUrl + city + `&appid=${apiKey}`);
  const data = await response.json();

  const card = document.querySelectorAll(".card")[cardIndex];
  const cityElem = card.querySelector(".city");
  const tempElem = card.querySelector(".temp");
  const conditionElem = card.querySelector(".condition");
  const weatherIconElem = card.querySelector(".weather-icon");

  cityElem.textContent = city;
  tempElem.textContent = Math.round(data.main.temp) + " °C";
  conditionElem.textContent = data.weather[0].main;
  weatherIconElem.src = weatherIcons[data.weather[0].main];

  card.style.display = "block";
}

async function updateAllWeather() {
  for (let i = 0; i < cities.length; i++) {
    console.log(cities[i]);
    await updateWeather(cities[i], i);
  }
}

updateAllWeather(); // Call the function to update weather for all cities

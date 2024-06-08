<?php
session_start();

// Check if the user is logged in
$isLoggedIn = isset($_SESSION["user_id"]);

// Redirect logic based on login status
if ($isLoggedIn) {
    
} else {
    // if User is not logged in redirect to the login page
    header("Location: login.php");
    exit(); 
}
?>
<script>
  function redirectToProfile() {
    
      window.location.href = "profile.php"; // Redirect to the profile page
    
  }
</script>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Weather App</title>
    <link rel="stylesheet" href="style.css" />
    <style>
      .profile {
        position: absolute;
        right: 10px;
        margin-top: 70px;
        margin-right: 40px;
        width: 50px;
        height: 50px;
        background-color: #97e7e1; /* Blue color */
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        cursor: pointer;
        transition: box-shadow 0.3s ease; /* Add transition for smooth effect */
      }

      /* Add hover effect for profile */
      .profile:hover {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Light circular shadow */
      }

      /* Add shadow effect for cards */
      .card {
        margin-bottom: 20px;
        padding: 10px;
        background-color: #7aa2e3; /* White background */
        border-radius: 10px;
        transition: box-shadow 0.3s ease; /* Add transition for smooth effect */
        cursor: pointer;
        padding-top: 30px;
        padding-bottom: 10px;
      }

      /* Add hover effect for cards */
      .card:hover {
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.5); /* Light shadow */
      }
    </style>
    <script
      src="https://kit.fontawesome.com/e22178dd4a.js"
      crossorigin="anonymous"
    ></script>
  </head>
  <body>
    <div class="outer">
      <div class="profile" onclick="redirectToProfile()">
        <i class="fa-solid fa-user" style="color: #7aa2e3"></i>
      </div>
      <div class="search">
        <input
          type="text"
          id="cityInput"
          placeholder="Enter city Name"
          spellcheck="false"
        />
        <button onclick="redirectToWeather()"><img src="images/search.png" alt=""></button>
      </div>
      <div class="error" style="display: none">
        <p>Invalid city name</p>
      </div>
      <div class="container">
        <!-- Delhi Weather Card -->
        <div class="card" onclick="redirectToWeather('London')">
          <h2 class="city">Delhi</h2>
          <div class="weather">
            <img src="" alt="" class="weather-icon" />
            <h1 class="temp"></h1>
            <p class="condition"></p>
          </div>
        </div>

        <!-- Hyderabad Weather Card -->
        <div class="card" onclick="redirectToWeather('Mumbai')">
          <h2 class="city">Hyderabad</h2>
          <div class="weather">
            <img src="" alt="" class="weather-icon" />
            <h1 class="temp"></h1>
            <p class="condition"></p>
          </div>
        </div>

        <!-- Bangalore Weather Card -->
        <div class="card" onclick="redirectToWeather('New York')">
          <h2 class="city">Bangalore</h2>
          <div class="weather">
            <img src="" alt="" class="weather-icon" />
            <h1 class="temp"></h1>
            <p class="condition"></p>
          </div>
        </div>
      </div>
    </div>

    <script src="script.js"></script>
    <script>
      async function redirectToWeather() {
        const cityInput = document.getElementById("cityInput").value.trim();
        if (cityInput === "") {
            // Show error message if city name is empty
            document.querySelector(".error").style.display = "block";
        } else {
            // Check if city name is valid using OpenWeatherMap API
            const isValid = await checkCityValidity(cityInput);
            if (!isValid) {
                // Show error message if city name is invalid
                document.querySelector(".error").style.display = "block";
            } else {
                // Redirect to weather page with the valid city name in the URL
                console.log(cityInput);
                window.location.href = `weather.html?city=${encodeURIComponent(cityInput)}`;
                // console.log("url");
            }
        }
      }


      async function checkCityValidity(city) {
        const response = await fetch(
          `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=1e9c398347e6ef79f8f40e36c69f24e5`
        );
        return response.status !== 404;
      }
      
      async function redirectToWeather(city) {
        window.location.href = `weather.html?city=${city}`;
      }
    </script>
  </body>
</html>

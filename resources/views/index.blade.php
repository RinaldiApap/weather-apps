<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Weather-bit.</title>
    {{-- library --}}
    {{-- google lib --}}
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAq9Tta9D6N89NxwmslhhDlpI1i-GIrE6A&v=3.exp&signed_in=true&libraries=places">
    </script>
    {{-- end google  --}}
    {{-- bootstrap lib --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    {{-- end bootstrap --}}
    <link rel="stylesheet" href="{{ asset('asset/style.css') }}" />
    <link href="{{ asset('asset/fonts/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
</head>

<body>
    <div>
        <header>
            <nav class="navbar navbar-expand-sm navbar-light bg-dark">
                <div class="container ">
                    <a class="navbar-brand text-light" href="#">Weather-bit.</a>
                </div>
            </nav>
        </header>
        <div class="container mt-4 border-none" align="center">
            <div class="col-8">
                <div class="input-group ">
                    <input type="text" class="form-control bg-dark isearch text-light" id="txtPlaces"
                        placeholder="Location" aria-label="location" aria-describedby="basic-addon1" value=""
                        onkeyup="iclearshow()" />
                    <button type="button" class="btn bg-transparent btn-clear btn-up text-white"
                        style="margin-left: -50px; display:none; " id="iclear" ">
                        <i class=" fa fa-times"></i>
                    </button>
                    <button type="button" class="btn bg-primary text-white btn-search btn-up" id="btnGet">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <main class="container mt-3">
            <h2 id="address"></h2>
            <!-- results for weather data -->
            <div class="weather row gx-2">
                <div class="col" style="display: none;">
                    <div class="card">
                        <h5 class="card-title p-2">Date</h5>
                        <img src="http://openweathermap.org/img/wn/10d@4x.png" class="card-img-top"
                            alt="Weather description" />
                        <div class="card-body">
                            <h3 class="card-title">Weather Label</h3>
                            <p class="card-text">High Temp Low Temp</p>
                            <p class="card-text">HighFeels like</p>
                            <p class="card-text">Pressure</p>
                            <p class="card-text">Humidty</p>
                            <p class="card-text">UV Index</p>
                            <p class="card-text">Precipitation</p>
                            <p class="card-text">Dew Point</p>
                            <p class="card-text">Wind speed and direction</p>
                            <p class="card-text">Sunrise</p>
                            <p class="card-text">Sunset</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    {{-- google location --}}
    <script>
        //   iclear show
    function iclearshow() {
        var x = document.getElementById("txtPlaces").value;
        if (x == "") {
            document.getElementById("iclear").style.display = "none";
        } else {
            document.getElementById("iclear").style.display = "block";
        }
    }
    </script>
    <script type="text/javascript">
        // iclear click clear input
    document.getElementById('iclear').addEventListener('click', function () {
        document.getElementById('txtPlaces').value = '';
        document.getElementById("iclear").style.display = "none";
    });
    // google location
        var lat ="";
            var lon ="";
            var addr ="";
            google.maps.event.addDomListener(window, 'load', function () {
                        var places = new google.maps.places.Autocomplete(document.getElementById('txtPlaces'));
                        google.maps.event.addListener(places, 'place_changed', function () {
                            var place = places.getPlace();
                            var addr = place.formatted_address;
                            var lati = place.geometry.location.lat();
                            var longi = place.geometry.location.lng();
                            // weather get
                            const app = {
                            init: () => {
                            document
                            .getElementById('btnGet')
                            .addEventListener('click', app.fetchWeather);
                 
                            },
                            fetchWeather: (ev) => {
                            let lat = lati;
                            let lon = longi;
                            let key = '50bfbdbc97e41c8f0468e75ca5483768';
                            let lang = 'en';
                            let units = 'metric';
                            let url =
                            `http://api.openweathermap.org/data/2.5/onecall?lat=${lat}&lon=${lon}&appid=${key}&units=${units}&lang=${lang}`;
                            //fetch the weather
                            fetch(url)
                            .then((resp) => {
                            if (!resp.ok) throw new Error(resp.statusText);
                            return resp.json();
                            })
                            .then((data) => {
                            app.showWeather(data);
                            })
                            .catch(console.err);
                            },
                            
                            showWeather: (resp) => {
                            console.log(resp);
                            let row = document.querySelector('.weather.row');
                            //clear out the old weather and add the new
                            // row.innerHTML = '';
                            row.innerHTML = resp.daily
                            .map((day, idx) => {
                            document.getElementById('address').innerHTML = addr;
                            console.log(day);
                            if (idx <= 6) { 
                                let dt=new Date(day.dt * 1000); //timestamp * 1000 let sr=new Date(day.sunrise * 1000).toTimeString();
                                let ss=new Date(day.sunset * 1000).toTimeString(); 
                                if (idx == 0) {
                                  return `
                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <div class="card bg-w">
                                        <div class="row">
                                        <div  class="col-lg-5 col-md-5 col-sm-5 text-center">
                                            <img src="{{ asset('asset/images/${day.weather[0].main}.jpg') }}" class="img-fluid rounded-top" style="height:100%;width:100%;" alt="">
                                            
                                            </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 text-center">
                                    <h5 class="card-title p-2">${dt.toDateString()}</h5>
                                    <h3 class="card-title ">${day.weather[0].main}</h3>
                                    <img src="http://openweathermap.org/img/wn/${day.weather[0].icon
                                                    }@4x.png" class="card-img-top" alt="${day.weather[0].description}" />
                                                    </div>
                                        <div class="col-sm-3 col-sm-3 col-sm-3">
                                        <div class="card-body">
                                    <h3 class="card-title ">Today Feels :</h3>
                                        <p class="card-text">High ${day.temp.max}&deg;C Low ${day.temp.min
                                            }&deg;C</p>
                                        <p class="card-text">High Feels like ${day.feels_like.day
                                            }&deg;C</p>
                                        <p class="card-text">Pressure ${day.pressure}mb</p>
                                        <p class="card-text">Humidity ${day.humidity}%</p>
                                        <p class="card-text">UV Index ${day.uvi}</p>
                                        <p class="card-text">Precipitation ${day.pop * 100}%</p>
                                        <p class="card-text">Dewpoint ${day.dew_point}</p>
                                        <p class="card-text">Wind ${day.wind_speed}m/s, ${day.wind_deg
                                            }&deg;</p>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                </div>`;
                                } else {
                                    return `
                                    <div class="col-lg-2 col-md-2 col-sm-12 mb-2">
                                    <div class="card bg-w text-center">
                                    <h5 class="card-title p-2">${dt.toDateString()}</h5>
                                    <img src="http://openweathermap.org/img/wn/${day.weather[0].icon
                                                    }@4x.png" class="card-img-top" alt="${day.weather[0].description}" />
                                    <div class="card-body">
                                        <h4 class="card-title">${day.weather[0].main}</h4>
                                        </p>
                                    </div>
                                
                                </div>
                                </div>
                                </div>
                                </div>`;
                                }
                                
                                }
                                })
                                .join(' ');
                                },
                                };
                            
                                app.init();
                            // end weather get
                        });
                    });
    </script>
    {{-- <script src="{{ asset('asset/app.js') }}" defer></script> --}}
    {{-- end library google location --}}
</body>

</html>
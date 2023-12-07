<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $destinationCity = $_POST["destination"]; 
    $originCity = $_POST["origin"]; 
    $departDate = $_POST["departureDate"];
    $returnDate = $_POST["returnDate"];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Build Your Trip</title>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>
<body>

  <h1>Here are your results:</h1>

  <div id="flights"></div>
  <div id="hotels"></div>
</body>

<script>
    main(); 
     async function main(){
        hotelCity(); 
        var departCity = await getLocation(<?php echo json_encode($originCity); ?>);
        var arriveCity = await  getLocation(<?php echo json_encode($destinationCity); ?>);
        searchFlights(departCity, arriveCity);

    }

    async function hotelCity() {
         city = <?php echo json_encode($destinationCity); ?>;
         console.log("city is: " + city);
         const options = {
         method: 'GET',
         url: 'https://priceline-com-provider.p.rapidapi.com/v1/hotels/locations',
         params: {
             name: city,
             search_type: 'CITY'
         },
         headers: {
             'X-RapidAPI-Key': 'a00b02125bmsh74e9e69d3c19c41p1583d3jsn618c1d6b72d1',
             'X-RapidAPI-Host': 'priceline-com-provider.p.rapidapi.com'
         }
         };
         try {
            const response = await axios.request(options);
            const cityID = response.data[0].cityID;
            console.log("hotel city id: " + cityID); 
            displayHotel(cityID);
         } catch (error) {
            console.error(error);
         }
         
     }
     async function displayHotel(cityID){
         const checkIn = <?php echo json_encode($departDate); ?>;
         const checkOut = <?php echo json_encode($returnDate); ?>;

         const options = {
             method: 'GET',
             url: 'https://priceline-com-provider.p.rapidapi.com/v1/hotels/search',
             params: {
                 date_checkout: checkOut,
                 sort_order: 'PROXIMITY',
                 location_id: cityID,
                 date_checkin: checkIn,
             },
             headers: {
                'X-RapidAPI-Key': 'a00b02125bmsh74e9e69d3c19c41p1583d3jsn618c1d6b72d1',
                'X-RapidAPI-Host': 'priceline-com-provider.p.rapidapi.com'
             }
             };
             try {
                 document.getElementById("hotels").innerHTML = "Loading hotels...";
                 const response = await axios.request(options);
                 console.log(response); 
                 document.getElementById("hotels").innerHTML = "";
                 if(response.data.hotels == null){
                     document.getElementById("hotels").innerHTML = "<br><h2>No hotel availability in the area on those dates. Try adjusting the dates.<br>";
                 }
                 else if(response.data.hotels.length <= 5){
                    document.getElementById("hotels").innerHTML += "<br><h3>HOTELS: </h3>";
                     for(let i = 0; i < response.data.hotels.length; i++){
                         document.getElementById("hotels").innerHTML += "<br><h2>Hotel Name: " + response.data.hotels[i].name + 
                         "</h2><br>";
                         document.getElementById("hotels").innerHTML += "<br><p>Average guest ratings (out of " +  response.data.hotels[i].totalReviewCount + " reviews): " + response.data.hotels[i].overallGuestRating+ "</p><br>";
                         document.getElementById("hotels").innerHTML += "<br><p>Minimum available price: " + response.data.hotels[i].ratesSummary.minCurrencyCode + response.data.hotels[i].ratesSummary.minPrice + 
                         "</p><br>";
                         const address = response.data.hotels[i].location.address; 
                         document.getElementById("hotels").innerHTML += "<br><p>Address: "+ address.addressLine1 + ", " + address.cityName + ", " + address.countryName + " " + address.zip + "</p><br>";
                         document.getElementById("hotels").innerHTML += '<br><img src= "' + response.data.hotels[i].media.url + 
                     '" width="250px">';
                     }
                 }
                 else{
                    document.getElementById("hotels").innerHTML += "<br><h2>HOTELS: </h3>";
                     for(let i = 0; i < 5; i++){
                     document.getElementById("hotels").innerHTML += "<br><h3>Hotel Name: " + response.data.hotels[i].name + 
                     "</h2><br>";
                     document.getElementById("hotels").innerHTML += "<br><p>Average guest ratings (out of " +  response.data.hotels[i].totalReviewCount + " reviews): " + response.data.hotels[i].overallGuestRating+ "</p><br>";
                     document.getElementById("hotels").innerHTML += "<br><p>Minimum available price: " + response.data.hotels[i].ratesSummary.minCurrencyCode + response.data.hotels[i].ratesSummary.minPrice + 
                     "</p><br>";
                     const address = response.data.hotels[i].location.address; 
                     document.getElementById("hotels").innerHTML += "<br><p>Address: "+ address.addressLine1 + ", " + address.cityName + ", " + address.countryName + " " + address.zip + "</p><br>";
                     document.getElementById("hotels").innerHTML += '<br><img src= "' + response.data.hotels[i].media.url + 
                 '" width="250px">';
                 }
                 }
                 
             } catch (error) {
                 console.error(error);
             }

     }

    async function getLocation(city) {
        const options = {
            method: 'GET',
            url: 'https://priceline-com-provider.p.rapidapi.com/v1/flights/locations',
            params: {
                name: city, 
            },
            headers: {
                'X-RapidAPI-Key': 'a00b02125bmsh74e9e69d3c19c41p1583d3jsn618c1d6b72d1',
                'X-RapidAPI-Host': 'priceline-com-provider.p.rapidapi.com'
            },
        };  
        try {
            const response = await axios.request(options);
            return response.data[0].id;
        } catch (error) {
            console.error(error);
        }
    }
    async function searchFlights(depart, arrive) {
    // Get form data
    const departDate = <?php echo json_encode($departDate); ?>;
    const returnDate =  <?php echo json_encode($returnDate); ?>;

    const today = new Date().toISOString().split('T')[0];
    if (departDate === today || departDate < today) {
        alert('Please select another date in the future (after today).');
        return;
    }
    if (returnDate < departDate) {
        alert('Return date cannot be before the departure date. Please select a valid return date.');
        return;
    }

      const options = {
            method: 'GET',
            url: 'https://priceline-com-provider.p.rapidapi.com/community/v1/flights/search',
            params: {
                date_departure: departDate,
                location_departure: depart,
                class_type: 'ECO',
                sort_order: 'TRAVELTIME',
                itinerary_type: 'ROUND_TRIP',
                location_arrival: arrive,
                price_max: '20000',
                price_min: '100',
                number_of_stops: '0',
                date_departure_return: returnDate,
                number_of_passengers: '1',
                duration_max: '2051'
            },
            headers: {
                'X-RapidAPI-Key':'a00b02125bmsh74e9e69d3c19c41p1583d3jsn618c1d6b72d1',
                'X-RapidAPI-Host': 'priceline-com-provider.p.rapidapi.com'
            }
            };
            try {
                document.getElementById("flights").innerHTML = "Loading flights...";
                const response = await axios.request(options);
                document.getElementById("flights").innerHTML = "";
                console.log(response);
                if(response.data.listings == null){
                    document.getElementById("flights").innerHTML = "<br><h2>No flight availability on those dates. Try adjusting the dates or where you're flying from.<br>";
                }
                else {
                    document.getElementById("flights").innerHTML += "<br><h2>FLIGHTS: </h3>";
                    for(let i = 0; i < 3; i++){
                       document.getElementById("flights").innerHTML += "<br><h3>Airline: " + response.data.listings[i].airlines[0].name + 
                       "</h2><br>";
                        document.getElementById("flights").innerHTML += "<br><p>Seat type: " +  response.data.listings[i].allFareBrandNames+ "</p><br>";
                        document.getElementById("flights").innerHTML += "<br><p>Seats available: " +  response.data.listings[i].seatsAvailable + "</p><br>";
                        document.getElementById("flights").innerHTML += "<br><p>Price: $" +  response.data.listings[i].totalPriceWithDecimal.price + "</p><br>";
                        var dTime = new Date(response.data.listings[i].slices[0].segments[0].departInfo.time.dateTime);
                        document.getElementById("flights").innerHTML += "<br><p>Departure information: " +  response.data.listings[i].slices[0].segments[0].departInfo.airport.name + " at "+ dTime +"</p><br>";
            
                    }
                }                
            } catch (error) {
                console.error(error);
            }

            }
 </script>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $destinationCity = $_POST["destination"]; 
    $originCity = $_POST["origin"]; 
    $departDate = $_POST["departureDate"];
    $returnDate = $_POST["returnDate"];

    if (isset($_POST['maxDist']) && !empty($_POST['maxDist'])) {
        $distanceLimit = $_POST['maxDist'];
    } else {
        $distanceLimit = 6.5;
    }

    $wheelchair = isset($_POST['accessibility']) ? $_POST['accessibility'] : '';
    $wifi = isset($_POST['wifi']) ? $_POST['wifi'] : '';

    // get the array of activity categories
    $catsWanted = [];
    if (isset($_POST["activity"])) {
        foreach ($_POST["activity"] as $activityCat) {
            $catsWanted[] = $activityCat;
        }
    }

    // if food category is selected, also check if user provided dietary restrictions
    $diet = [];
    if (in_array("catering", $catsWanted)) {
        if (isset($_POST["diet"])) {
            foreach ($_POST["diet"] as $dietType) {
                $diet[] = $dietType;
            }
        }
    }

    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $email = $_POST['email'];
    $card = $_POST['card'];
    $package = $_POST['package'];
} else {
    // redirect if accessed directly without submitting the form
    header('Location: tripForm.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Build Your Trip</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=PT-Serif">
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
    <style type="text/css">
        body {
            width: 100%;
            background-color: white;
            text-align: center; 
        }
        .page-title {
            margin-top: 50px;
            color: black;
            text-align: center;
        }
        .all-containers h2 {
            margin: 10px 0px;
            color: #1C6B80;
            text-align: center;
            width: 100%;
        }


        #cats-container {
            display: block;
            width: 100%;
            margin: 0 auto;
            padding: 0px;
        }
        .catResults {
            width: 100%;
            padding: 10px 0px 30px 0px;
            margin: 0px;
            margin-bottom: 20px;
            display: none; /* not shown unless user chose the category in the form */
        }
        .catResults input[type='button'] {
            padding: 10px; /* Adjust the padding as needed */
            display: inline-block;
            border-radius: 0; 
            border: 1px solid grey;
            background-color: white;
        }
        .catResults input[type='button']:hover {
            cursor: pointer;
        }

        .panes {
            display: flex;
            flex-wrap: wrap;
            font-size: 20px;
            width: 100%;
            margin: 0 auto;
            justify-content: center; 
            overflow: scroll;
            overflow-x: hidden;
            height: 400px;
        }
        /* hotels */
        #hotels {
            display: block;
            width: 100%;
            margin: 0 auto;
            padding: 0px;
        }
        #hotel-container {
            background-color: white;
            width: 100%;
            padding: 10px 0px 30px 0px;
            margin: 0px;
            display: block;
            margin-bottom: 10px;
        }
        /* flights */
        #flights {
            display: block;
            width: 100%;
            margin: 0 auto;
            padding: 0px;
        }
        #flight-container {
            background-color: white;
            width: 100%;
            padding: 10px 0px 30px 0px;
            margin: 0px;
            margin-bottom: 10px;
            display: block;
        }

        .all-containers form {
            display: block;
            margin-bottom: 10px;
        }

        .place-info {
            text-align: left;
            display: block;
            font-size: 18px;
            padding: 10px;
            padding-bottom: 0px;
            border-radius: 20px;
            line-height: 1.5em;
            margin: 10px;
            width: 300px;
            display: block;
            background-color: aliceblue;
            pointer-events: all;
        }

        .all-containers a {
            text-decoration: none;
        }
        .all-containers a:hover {
            cursor: pointer;
            color: #b6a75e;
        }
        .all-containers ul {
            line-height: 1.8em;
            padding-left: 0px;
        }
        .all-containers ul li {
            margin: 20px 0px;
            list-style: none;
            line-height: 1.3em;
        }
        .place-name {
            font-weight: bold;
        }
        .all-containers b {
            font-family: PT Serif;
        }

        /* tag icon with text for labeling results */
        .tag-container {
            position: relative;
            display: inline-block;
        }

        .tag-container img {
            width: 100px;
        }

        .tag-container .tag-text {
            position: absolute;
            top: 40%;
            left: 60%;
            transform: translate(-50%, -50%);
            color: black;
            font-size: 16px;
            text-align: center;
        }

        .heartBtn {
            background-color: #BAD5DE;
            display: inline-block;
            padding: 2px 20px;
            cursor: pointer;
            color: black;
            margin: 12px; 
            float: right; 
            border-radius: 15px; 
        }

        .heartBtn:hover {
            background-color: #4e92a6;
            color: white;
        }

        #.done-f{
            display: inline-block;
            align-content: center;
            text-align: center;
            background-color: #79adc0;
            color: rgb(255, 255, 255);
            font-size: 22px;
            font-weight: 800;
            font-family: PT Serif;
            padding: 5px;
            border-radius: 20px;
            /* Adding rounded corners */
            border: none;
            cursor: pointer;
            transition: transform 0.3s, background-color 0.3s;
            }   

        .signOut:hover {
            background-color: #4e92a6;
            color: white;
        }

        .liked:hover {
            background-color: pink;
        } 
        input[type="submit"] {
                display: inline-block;
        align-content: center;
        text-align: center;
        background-color: #79adc0;
        color: rgb(255, 255, 255);
        font-size: 22px;
        font-weight: 800;
        padding: 20px;
        border-radius: 20px;
        /* Adding rounded corners */
        border: none;
        cursor: pointer;
        transition: transform 0.3s, background-color 0.3s;
        }        
        input[type="submit"]:hover {
                background-color: #4e92a6;
        /* Scale the button slightly on hover */
        color: white;
        }
        /* #done-submit{
            display: inline-block;
            align-content: center;
            text-align: center;
            background-color: #79adc0;
            color: rgb(255, 255, 255);
            font-size: 22px;
            font-weight: 800;
            padding: 5px;
            border-radius: 20px;
            border: none;
            cursor: pointer;
            transition: transform 0.3s, background-color 0.3s;
            }   

        #done-submit:hover {
            background-color: #4e92a6;
            color: white;
        } */
    </style>
</head>
<body>
<nav class="navbar">
    <ul class="nav-links">
      <li><a href="services.html">Our Services</a></li>
      <li><a href="catalog.php">Plan Your Trip</a></li>
      <li><a href="index.html" class="logo"></a></li>
      <li><a href="story.html">Our Story</a> </li>
      <li><a href="contact.html">Contact Us</a></li>
    </ul>
    <div class="user-icon">
      <a href="login.php"><i class="fa fa-user" style="font-size:36px; color:white;"></i></a>
    </div>
  </nav>
  <div class="dropdown">
        <button onclick="toggleDropdown()" class="dropbtn">☰ Menu</button>
        <div id="dropdownContent" class="dropdown-content">
          <a href="index.html">Home</a>
          <a href="services.html">Our Services</a>
          <a href="catalog.php">Plan Your Trip</a>
          <a href="story.html">Our Story</a>
          <a href="contact.html">Contact Us</a>
          <a href="login.php">Login</a>
        </div>
    </div>
    
    <h1 class="page-title">Here's what we found for you!</h1><br />

    <div id="flights">
        <div id='flight-container' class='all-containers'>
            <h2>FLIGHTS THERE</h2>
            <div class="panes"></div>
        </div>
    </div>

    <div id="hotels">
        <div id='hotel-container' class='all-containers'>
            <h2>HOTELS</h2>
            <div class="panes"></div>
        </div>
    </div>

    <h1 id="title-activities">Activities</h1>
    <div id="cats-container" class='all-containers'>
        <div class='catResults' id='catering-container'>
            <h2>FOOD & DRINK</h2>
            <form id="catering-form" action="#" method="#">&nbsp; &nbsp;Filter results: </form>
            <div class="panes"></div>
        </div>

        <div class='catResults' id='cultural-container'>
            <h2>CLASSIC TOURISM</h2>
            <form id="cultural-form" action="#" method="#">&nbsp; &nbsp;Filter results: </form>
            <div class="panes"></div>
        </div>

        <div class='catResults' id='commercial-container'>
            <h2>SHOPPING</h2>
            <form id="commercial-form" action="#" method="#">&nbsp; &nbsp;Filter results: </form>
            <div class="panes"></div>
        </div>

        <div class='catResults' id='natural-container'>
            <h2>NATURE</h2>
            <form id="natural-form" action="#" method="#">&nbsp; &nbsp;Filter results: </form>
            <div class="panes"></div>
        </div>      
    </div>
    <br>
    <form id="done-form" action="showResults.php" method="POST">
        <input type="submit" id="done-submit" value="I'm done!">
    </form>
    <br><br>
</body>
<footer class="footer">
      <div class="left">
        <!-- Contact Information -->
        <p>Contact Us</p>
        <p>Email: contact@travelbuddy.com</p>
        <p>Phone: +123456789</p>
      </div>
      <div class="social-icons">
        <!-- Social Media Icons -->
        <a href="https://www.instagram.com/" class="icon instagram"><i class="fa fa-instagram"></i></a>
        <a href="https://www.facebook.com/" class="icon facebook"><i class="fa fa-facebook"></i></a>
      </div>
      <div class="right">
        <!-- Copyright Statement -->
        <p>&copy; 2023 </p>
        <p>Travel Buddy</p>
        <p>All rights reserved.</p>
      </div>
    </footer>

<script>
    const fname = <?php echo json_encode($first_name); ?>;
    const lname = <?php echo json_encode($last_name); ?>;
    const email = <?php echo json_encode($email); ?>;
    const card = <?php echo json_encode($card); ?>;
    const package = <?php echo json_encode($package); ?>;
    const cityName = <?php echo json_encode($destinationCity); ?>;

    main(); 
    
    async function main(){
        var coordinates = await hotelCity(); 

        showActivities(coordinates);

        var departCity = await getLocation(<?php echo json_encode($originCity); ?>);
        var arriveCity = await getLocation(cityName);
        searchFlights(departCity, arriveCity);
    }

    /**
     * formats the given amount as a currency string.
     * 
     * @param {number} amount - a numeric amount to display as currency.
     * @throws - will throw type error if amount is not a number.
     * @return {string} - amount padded with up to 2 trailing zeros.
     */
    function currencyStr(amount) {
        if (typeof amount !== "number") {
            throw new TypeError("amount cannot be formatted as currency");
        }

        // round to 2 decimal places
        let rounded = Math.round(amount * 100) / 100;
        
        // if whole number, add two trailing zeros
        if (Math.round(amount) - rounded === 0) {
            rounded += ".00";
        } else { // if only one decimal place (eg, 2.5), add a trailing 0
            rounded += "";
            if (rounded.split(".")[1].length === 1) {
                rounded += "0";
            }
        }

        return rounded;
    }

    async function hotelCity() {
         city = <?php echo json_encode($destinationCity); ?>;
         const options = {
         method: 'GET',
         url: 'https://priceline-com-provider.p.rapidapi.com/v1/hotels/locations',
         params: {
             name: city,
             search_type: 'CITY'
         },
         headers: {
             'X-RapidAPI-Key': '6514cc7badmshe7ee4122ff0b96dp18a0b8jsn6573eb2c79a2',
             'X-RapidAPI-Host': 'priceline-com-provider.p.rapidapi.com'
         }
         };
         try {
            const response = await axios.request(options);
            const cityID = response.data[0].cityID;

            displayHotel(cityID);

            return {
                lat: response.data[0].lat,
                lon: response.data[0].lon
            };
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
                'X-RapidAPI-Key': '6514cc7badmshe7ee4122ff0b96dp18a0b8jsn6573eb2c79a2',
                'X-RapidAPI-Host': 'priceline-com-provider.p.rapidapi.com'
             }
        };

        try {
            $("#hotel-container .panes").html("Loading hotels...");
            const response = await axios.request(options);

            const hotelsList = response.data.hotels;
            if (hotelsList == null){
                $("#hotel-container .panes").html("No hotel availability in the area on those dates. Try adjusting the dates.");
            } else {
                const numHotels = Math.min(hotelsList.length, 4);

                let allHotelsHtml = "";
                for(let i = 0; i < numHotels; i++){
                    const currHotel = hotelsList[i];

                    if (!currHotel.name) {
                        continue;
                    }

                    const address = currHotel.location.address;

                    let hotelHtml = `<div class='place-info'><ul><li class='place-name'>${currHotel.name}</li><li>Average rating (${currHotel.totalReviewCount} reviews): ${currHotel.overallGuestRating}</li><li>Minimum available price: ${currHotel.ratesSummary.minCurrencyCode + currHotel.ratesSummary.minPrice}</li><li>📍 ${address.addressLine1}, ${address.cityName}, ${address.countryName} ${address.zip}</li>`;

                    if (currHotel.media) {
                        hotelHtml += `<li><img src='${currHotel.media.url}' width='250px'></li>`;
                    }

                    const saveId = heartId;
                    heartId += 1;

                    allData.hotel.push({
                        id: `heart${saveId}`, 
                        content: $('<div/>').text(hotelHtml + "</ul></div>").html()
                    });

                    hotelHtml += `<div id="heart${saveId}" class="heartBtn">Save</div>`;
                    hotelHtml += "</ul></div>";

                    allHotelsHtml += hotelHtml;
                }

                $(`#hotel-container .panes`).html(allHotelsHtml); 
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
                'X-RapidAPI-Key': '6514cc7badmshe7ee4122ff0b96dp18a0b8jsn6573eb2c79a2',
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

        const options = {
            method: 'GET',
            url: 'https://priceline-com-provider.p.rapidapi.com/community/v1/flights/search',
            params: {
                date_departure: departDate,
                location_departure: depart,
                class_type: 'ECO',
                sort_order: 'TRAVELTIME',
                itinerary_type: 'ROUND_TRIP',
                // itinerary_type: 'ONE_WAY',
                location_arrival: arrive,
                price_max: '20000',
                price_min: '10',
                number_of_stops: '1',
                date_departure_return: returnDate,
                number_of_passengers: '1',
                duration_max: '3000'
            },
            headers: {
                'X-RapidAPI-Key':'6514cc7badmshe7ee4122ff0b96dp18a0b8jsn6573eb2c79a2',
                'X-RapidAPI-Host': 'priceline-com-provider.p.rapidapi.com'
            }
            };
            try {
                $("#flight-container .panes").html("Loading flights...");
                const response = await axios.request(options);
                
                if(response.data.listings == null){
                    $("#flight-container .panes").html("No flight availability on those dates. Try adjusting the dates or where you're flying from.");
                }
                else {
                    let allFlightsHtml = "";
                    const numFlights = Math.min(4, response.data.listings.length);

                    for (let i = 0; i < numFlights; i++){
                        const flightEntry = response.data.listings[i];
                        const segments = flightEntry.slices[0].segments;
                        const dTime = new Date(segments[0].departInfo.time.dateTime);
                        const formattedTime = dTime.toLocaleString('en-US', {
                            year: 'numeric',
                            month: 'short',
                            day: '2-digit',
                            hour: '2-digit',
                            minute: '2-digit',
                            timeZoneName: 'short'
                        });


                        let flightHtml = `<div class='place-info'><ul><li class='place-name'>Airline: ${flightEntry.airlines[0].name}</li><li>Seat type: ${flightEntry.allFareBrandNames}</li><li>Seats available: ${flightEntry.seatsAvailable}</li><li>Price: USD${currencyStr(flightEntry.totalPriceWithDecimal.price)}</li><li>Layovers: ${segments.length - 1}</li><li>Departure: ${segments[0].departInfo.airport.name} at ${formattedTime}</li>`;

                        const saveId = heartId;
                        heartId += 1;

                        allData.flight.push({
                            id: `heart${saveId}`, 
                            content: $('<div/>').text(flightHtml + "</ul></div>").html()
                        });

                        flightHtml += `<div id="heart${saveId}" class="heartBtn">Save</div>`;
                        flightHtml += "</ul></div>";

                        allFlightsHtml += flightHtml;
                    }

                    $(`#flight-container .panes`).html(allFlightsHtml); 
                }                
            } catch (error) {
                console.error(error);
            }
        }

    
        // ACTIVITIES

        const cateringTypes = [
            "catering.restaurant",
            "catering.cafe"
        ];

        const cateringTags = {
            "catering.restaurant": 'Restaurant',
            "catering.cafe": 'Cafe', 
            "vegetarian": "Vegetarian",
            "vegan": "Vegan", 
            "halal": "Halal", 
            "kosher": "Kosher"
        };

        const commercialTags = {
            "commercial.supermarket": "Supermarket",
            "commercial.marketplace": "Marketplace",
            "commercial.shopping_mall": "Mall",
            "commercial.clothing": "Clothing",
            // "service.financial.bank%2Cservice.financial.atm": "Banks/ATM",
            // "public_transport": "Transport",
        };

        const naturalTags = {
            "natural.forest": "Forest",
            "natural.water": "Water",
            "natural.mountain": "Mountain",
            "leisure.park": "Park",
            // "natural": "Any nature"
        };

        const culturalTags = {
            "tourism.sights": "Tourist",
            "entertainment.culture": "Theatre/Art",
            "entertainment.museum": "Museum",
            "tourism.sights.place_of_worship": "Religious",
            "building.historic": "Historical"
        };

        // for extracting info from result places
        const basicFields = [
            "year_of_construction",
            "opening_hours",
            "phone",
            "website",
        ];

        const distMeters = 10000;
        const wheelchair = <?php echo json_encode($wheelchair); ?>;   // empty string means false
        const wifi = <?php echo json_encode($wifi); ?>;               // empty string means false
        const dietRestrictions = <?php echo json_encode($diet); ?>;
        const allCategories = <?php echo json_encode($catsWanted); ?>;

        var heartId = 0;
        var allData = {
            flight: [],
            hotel: [],
            activity: []
        };

        // FUNCTION DEFINITIONS
        function getCatTags(containerId) {
            switch (containerId) {
                case "catering-container":
                    return cateringTags;
                case "commercial-container":
                    return commercialTags;
                case "natural-container":
                    return naturalTags;
                case "cultural-container":
                    return culturalTags;
                default:
                    return {};
            }
        }

        function makeTag(text) {
            text = text.replace(/_/g, ' ');
            capitalized = text[0].toUpperCase() + text.slice(1);

            const html = `<div class='tag-container'><img src='images/tag-icon.png' alt='grey tag with text'><div class='tag-text'>${capitalized}</div></div>`;

            return html;
        }

        function makeLink(classname, url, text) {
            return `<a href='${url}' class='${classname}'>${text}</a>`;
        }

        function makeChkBox(name, id, val) {
            return `<input type='checkbox' name='${name}' id='${id}' value='${val}' />`;
        }

        function makeFilter(classname, id, val) {
            return `<input type='button' value='${val}' class='${classname}' id='${id}' />`;
        }

        function formatWebsite(url) {
            return makeLink("weblink", url, "🔗 Read more");
        }

        function formatPhone(num) {
            return makeLink("phonelink", "tel:" + num, "📞 Call us"); 
        }

        function formatHours(hoursStr) {
            let formatted = hoursStr.replace(/;/g, '<br />&nbsp;&nbsp;&nbsp;&nbsp;');
            formatted = formatted.replace(/, /g, '<br />&nbsp;&nbsp;&nbsp;&nbsp;');
            return "🕒 " + formatted;
        }

        function formatAddress(addressStr) {
            const addressLower = addressStr.toLowerCase();
            const cityLower = cityName.toLowerCase();
            const cityIdx = addressLower.indexOf(cityLower);

            if (cityIdx !== -1) {
                // truncate the address up to the city
                return "📍 " + addressStr.substring(0, cityIdx + cityLower.length);
            } else {
                // if the city is not found, return the full address
                return "📍 " + addressStr;
            }
        }

        function metersToKm(meters) {
            const km = meters / 1000;
            const rounded = Math.round(km * 100) / 100;
            return rounded;
        }

        function formatbasicFields(type, val) {
            switch(type) {
                case "phone":
                    return formatPhone(val);
                case "website": 
                    return formatWebsite(val);
                case "opening_hours":
                    return formatHours(val);
                case "year_of_construction":
                    return "Year built: " + val;
                default: 
                    return "";
            }
        }
    
        async function loadResults(container, categories, conditions, coordinates) {
            const containerId = `#${container}-container`;
            $(`${containerId} .panes`).html("Searching...");

            if (wheelchair !== "") {
                conditions.push(wheelchair);
            }
            if (wifi !== "") {
                conditions.push(wifi);
            }

            const conditionStr = conditions.length == 0 ? "" : `&conditions=${ conditions.join("%2C") }`;
            const catStr = categories.join("%2C");
            
            // a lot of nature entries don't have enough detail - no guarantee, but we can get some extra entries
            const maxResults = containerId == "#natural-container" ? 20 : 10; 
            const url = `https://api.geoapify.com/v2/places?categories=${catStr}${conditionStr}&filter=circle%3A${coordinates.lon}%2C${coordinates.lat}%2C${distMeters}&bias=proximity%3A${coordinates.lon}%2C${coordinates.lat}&limit=${maxResults}&apiKey=0b813d154863412cb86acd4b37d93c3b`;

            fetch(url)
                .then(res => res.text())
                .then(data => 
                {
                    const locations = JSON.parse(data);
                    locationsArr = locations.features;

                    let dataHTML = "";
                    for (const place of locationsArr) {
                        
                        const info = place.properties;
                        const placeCats = info.categories;

                        // missing key info
                        if (!("name" in info) || !("distance" in info)) {
                            continue;
                        }

                        // features of this place to display as tags
                        const allTags = getCatTags(`${container}-container`);
                        let matchingTags = [];

                        for (const key in allTags) {                            
                            if (placeCats.includes(key)) {
                                matchingTags.push(allTags[key]);
                            }
                        }

                        const tagsHTML = matchingTags.map(makeTag).join('');
                        let list = `<div class='place-info'><ul><li class='tags'>${tagsHTML}</li><li class='place-name'>${info.name}</li><li>${metersToKm(info.distance)} km away</li><li>${formatAddress(info.formatted)}</li>`; // this is the full address

                        const moreinfo = info.datasource.raw;

                        for (const key of basicFields) {
                            if (moreinfo.hasOwnProperty(key)) {
                                list += `<li>${formatbasicFields(key, moreinfo[key])}</li>`;
                            }
                        }

                        const saveId = heartId;
                        heartId += 1;

                        allData.activity.push({
                            id: `heart${saveId}`, 
                            content: $('<div/>').text(list + "</ul></div>").html()
                        });

                        list += `<div id="heart${saveId}" class="heartBtn">Save</div>`;
                        list += "</ul></div>";

                        dataHTML += list;
                    }

                    // no results found
                    if (dataHTML == "") {
                        dataHTML = "We couldn't find any matching results.";
                    }

                    $(`${containerId} .panes`).html(dataHTML); 
                })
            .catch (error => console.log(error));
        }

        function makeCategoryFilters(filterNames, category) {
            const formId = `#${category}-form`;
            const containerId = `#${category}-container`;

            filterNames.forEach((k, idx) => {
                const filter = makeFilter(`${category}Chk`, `chk${idx}${category}`, k);
                $(formId).append(filter);
            });

            $(`${formId} input[type='button']`).each(function() {
                makeClickEvent($(this), $(containerId), $(formId));
            });
        }

        function loadCategory(category, tags, tagDisplayNames, conditions, coordinates) {
            $(`#${category}-container`).css("display", "block");
            // create filters
            makeCategoryFilters(tagDisplayNames, category);

            // make API call to populate this category's results
            loadResults(category, tags, conditions, coordinates);
        }

        function makeClickEvent(button, catContainer, catForm) {
            button.click(function(event) {
                event.preventDefault();

                button.toggleClass('on');
                button.css('background-color', button.hasClass('on') ? '#FFDEC2' : 'white');

                // check which categories have been selected
                const categories = [];
                catForm.find("input[type='button']").each(function() {
                    if ($(this).hasClass('on')) {
                        const selectedFilter = $(this).val();
                        categories.push(selectedFilter);
                    }
                });

                // display only results that match at least one of the selected categories. 
                // If no filters are selected, show everything
                if (categories.length == 0) {
                    catContainer.find('.place-info').each(function() {
                        $(this).show();
                    })
                } else {
                    catContainer.find('.place-info').each(function() {
                        const tagDivs = $(this).find('.tag-text');

                        // Check if any tag-text div has text that is in the categories array
                        let hasMatchingCategory = false;
                        
                        tagDivs.each(function() {
                            const tagContent = $(this).text();
                            if (categories.includes(tagContent)) {
                                hasMatchingCategory = true;
                                return false; // break out of the loop since we found a match
                            }
                        });

                        // If this place does not have a matching category, hide it
                        if (hasMatchingCategory) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                }
            });
        }

        async function showActivities(coordinates) {

            // food
            if (allCategories.includes("catering")) {
                loadCategory("catering", cateringTypes, Object.values(cateringTags), dietRestrictions, coordinates);
            }
            
            // commercial
            if (allCategories.includes("commercial")) {
                loadCategory("commercial", Object.keys(commercialTags), Object.values(commercialTags), [], coordinates);
            }

            // natural
            if (allCategories.includes("natural")) {
                loadCategory("natural", Object.keys(naturalTags), Object.values(naturalTags), [], coordinates);
            }

            // tourist
            if (allCategories.includes("cultural")) {
                loadCategory("cultural", Object.keys(culturalTags), Object.values(culturalTags), [], coordinates);
            }
        }

        $(document).on('click', '.heartBtn', function(event) {
            event.preventDefault();

            $(this).toggleClass('liked');

            if ($(this).hasClass('liked')) {
                $(this).css("background-color", "pink");
            } else {
                $(this).css("background-color", "#BAD5DE");
            }
        });

        // $('.heartBtn').hover(
        //     function() {
        //         if ($(this).css("background-color") == "#BAD5DE") {
        //             $(this).css("background-color", "pink");
        //         } else {
        //             $(this).css("background-color", "#BAD5DE");
        //         }
        //     },
        //     function() {
        //         if ($(this).css("background-color") == "#BAD5DE") {
        //             $(this).css("background-color", "pink");
        //         } else {
        //             $(this).css("background-color", "#BAD5DE");
        //         }
        //     }
        // );

        $(document).ready(function() {
            if (package == "Basic") {
                $("#title-activities").css("display", "none");
            }

            let hiddenInfo = `<input type='hidden' name='fname' value='${fname}'/>`
            + `<input type='hidden' name='lname' value='${lname}'/>`
            + `<input type='hidden' name='email' value='${email}'/>`
            + `<input type='hidden' name='card' value='${card}'/>`
            + `<input type='hidden' name='package' value='${package}'/>`;

            $("#done-form").append(hiddenInfo);

            $('#done-form').submit(function(event) {

                for (const category in allData) {
                    allData[category].forEach(function(obj) {
                        const id = obj.id;
                        const content = obj.content;

                        // check if the element with that id has class 'liked'
                        if ($(`#${id}`).hasClass('liked')) {
                            let idNum = 0;

                            // get the number from the id
                            const match = id.match(/\d+/);
                            if (match) {
                                idNum = parseInt(match[0], 10);
                            }
                            
                            const currName = category + idNum;
                        
                            $('#done-form').append(`<input type="hidden" name="${currName}" value="${content}">`);
                        }
                    });
                }

                return true;
            });
        });
 </script>
</html>
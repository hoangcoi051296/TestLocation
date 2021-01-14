<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test location</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<div id="distance"></div>
</body>
<script>
    //check again after 30s
    // setInterval(function () {
    //     checkLocation()
    // }, 30000);//10*60*1000

    //distanceAllow(meters)
    checkLocation()
    var distanceAllow = 300
    $('input[name=distance]').blur(function () {
        distanceAllow = $(this).val()
        checkLocation()
    })


    function checkLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successFunction, errorFunction);
        }
    }

    function successFunction(position) {
        var lat = position.coords.latitude
        var long = position.coords.longitude
        $.ajax({
            type: "GET",
            url: "{{route('check-location')}}",
            data: {
                'lat': lat,
                'long': long,
                'distance_allow': distanceAllow
            },
            success: function (response) {
                var html = ''
                var ds = response.distance.toFixed(0)
                if (response.status ==0){
                    html += '<span>'+ds+'-Khoảng cách phải nhỏ hơn '+distanceAllow+' mét</span>'
                }else{
                    html += '<span>'+ds+'-Khoảng cách hợp lệ '+distanceAllow+' mét</span>'
                }
                $("#distance").html(html)
            }
        })
    }

    function errorFunction() {
        alert("Geocoder failed");
    }

    // function checkconnection() {
    //     var status = navigator.onLine;
    //     if (status) {
    //         alert('Internet connected !!');
    //     } else {
    //         alert('No internet Connection !!');
    //     }
    // }
</script>
</html>

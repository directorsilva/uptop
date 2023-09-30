<!--@extends('layouts.app')-->

@section('content')

<div id="main-wrapper" class="page-wrapper">

    <!-- start container-->

    <div class="container-fluid">

        <!--map Start-->
        <div class="row daes-sec-sec">

            <div class="col-12">

                <div class="card">

                    <div class="box-header">
                        <h3 class="box-title">{{trans('lang.on_ride_cars')}}</h3>
                    </div>

                    <div class="card-body">

                        <div id="map" style="height:500px"></div>

                    </div>
                </div>
            </div>
        </div>
        <!--map End-->

    </div>
    <!-- end container -->

</div>

<!-- end page-wrapper -->

@endsection

@section('scripts')

<script type="text/javascript">

var default_lat = '23.022505';
var default_lng ='72.571365';

var defaultLatLong=JSON.parse('<?php echo json_encode($latlong); ?>');
if(defaultLatLong.length !=0 ){
   default_lat = parseFloat(defaultLatLong['lat']);
   default_lng = parseFloat(defaultLatLong['lng']);
}

var markers = [];
var data = [];

var map = new google.maps.Map(document.getElementById('map'), {
    center: new google.maps.LatLng(default_lat, default_lng),
    zoom: 7,
    mapTypeId: 'roadmap',
    mapTypeControl: false,
    zoomControl: true,
    scaleControl: true,
    streetViewControl: false,
    
    fullscreenControl: true,
});

var data = JSON.parse('<?php echo json_encode($data); ?>');

console.log(data);
LoadRides(data);

function LoadRides(data) {

    $.each(data, function (key, val) {
        
        if (typeof val.latlong != 'undefined') {

            var content = `
                <div class="p-2">
                    <h6>Driver Name : ${val.name ?? '-'} </h6>
                    <h6>Mobile : ${val.mobile ?? '-'} </h6>
                    <h6>Car Number : ${val.vehicle_number ?? '-'} </h6>
                    <h6>Car Type : ${val.vehicle_type_name ?? '-'} </h6>
                </div>`;
            var infowindow = new google.maps.InfoWindow({
                content: content
            });

            var iconImg = "{{ asset('images/sport-car.png') }}";

            var carIcon = new google.maps.Marker({
                position: new google.maps.LatLng(val.latlong[0], val.latlong[1]),
                icon: {
                    url: iconImg,
                    scaledSize: new google.maps.Size(35, 35)
                },
                
                map: map
            });

            carIcon.addListener('click', function () {
                infowindow.open(map, carIcon);
            });

            markers.push(carIcon);
            
            carIcon.setMap(map);
            
            setInterval(function() {
                toggleBounce(carIcon);
            },10000);
        }
    });

    function toggleBounce(carIcon) {
        if (carIcon.getAnimation() !== null) {
            carIcon.setAnimation(null);
        } else {
            carIcon.setAnimation(google.maps.Animation.VA);
        }
    }
}

</script>

@endsection

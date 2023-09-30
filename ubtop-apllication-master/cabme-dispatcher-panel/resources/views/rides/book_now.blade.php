@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{trans('lang.book_now')}}</h3>
            </div>

            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                    <li class="breadcrumb-item"><a href="{!! route('rides') !!}">{{trans('lang.all_rides')}}</a></li>
                    <li class="breadcrumb-item active">{{trans('lang.book_now')}}</li>
                </ol>
            </div>
        </div>


        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card pb-4">
                        <div class="card-body">

                            <div id="data-table_processing" class="dataTables_processing panel panel-default"
                                 style="display: none;">
                                {{trans('lang.processing')}}
                            </div>
                            <div class="error_top"></div>
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="row">

                                 <div class="col-12">

                                     <div class="box">

                                         <div class="box-header bb-2 border-primary">
                                            <h3 class="box-title">{{trans('lang.map_view')}}</h3>
                                         </div>

                                         <div class="box-body">
                                             <div id="map" style="height:300px">
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                            <form action="{{ route('bookNow.store') }}" method="post" enctype="multipart/form-data"
                                  id="create_driver">
                                @csrf
                                <div class="row restaurant_payout_create">
                                    <div class="restaurant_payout_create-inner">
                                        <fieldset>
                                            <legend>{{trans('lang.user_details')}}</legend>

                                            <div class="form-group row width-50">
                                                <label class="col-3 control-label">{{trans('lang.select_user')}}</label>
                                                <div class="col-7">
                                                    <select id='user_list' name="user_id" class="form-control select2 required_for_valid" required>
                                                        <option value="">{{trans('lang.select_user')}}</option>
                                                        @foreach($UserApp as $value)
                                                            <option value="{{$value->id}}">{{$value->prenom}} {{$value->nom}} </option>
                                                        @endforeach

                                                    </select>
                                                    <span id="error-user_id"></span>
                                                    <a target="_blank" href="{{route('bookNow.createuser')}}"><i
                                                                class="fa fa-plus mr-2"></i>{{trans('lang.walk_in_customer')}}
                                                    </a>

                                                </div>
                                            </div>

                                            <div class="form-group row width-50">
                                                <label class="col-3 control-label">{{trans('lang.number_poeple')}}</label>
                                                <div class="col-5">
                                                    <input type="number" min="1" value="1" class="form-control pickup required_for_valid" name="number_poeple">
                                                </div>
                                            </div>

                                        </fieldset>
                                        <fieldset>
                                            <legend>{{trans('lang.location_detail')}}</legend>

                                            <div class="form-group row width-50">
                                                <label class="col-3 control-label">{{trans('lang.pickup_location')}}</label>
                                                <div class="col-7">
                                                    <input type="text" class="form-control pickup required_for_valid" id="pickup"
                                                           name="pickup" onclick="pickLocation()" >
                                                    <input type="hidden" class="form-control pickup_lat" id="pickup_lat"
                                                           name="pickup_lat">
                                                    <input type="hidden" class="form-control pickup_long"
                                                           id="pickup_long" name="pickup_long">
                                                           <span id="error-pickup"></span>

                                                </div>
                                            </div>

                                            <div class="form-group row width-50">
                                                <label class="col-3 control-label">{{trans('lang.dropup_location')}}</label>
                                                <div class="col-7">
                                                    <input type="text" class="form-control dropup required_for_valid" id="dropup"
                                                           name="dropup" onclick="dropLocation()" >
                                                    <input type="hidden" class="form-control drop_lat" id="drop_lat"
                                                           name="drop_lat">
                                                    <input type="hidden" class="form-control drop_lng" id="drop_lng"
                                                           name="drop_lng">
                                                      <span id="error-dropup"></span>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset class=" book_vehicle_type" id="vehicleTypeDiv" style="display:none">
                                            <legend>{{trans('lang.vehicle_type')}}</legend>
                                            <div class="form-group row width-50">

                                                <div class="col-7">
                                                    <select class="form-control brand_id required_for_valid" name="vehicle_id" id="vehicle_type" required>
                                                        <option value="">Select Vehicle Type</option>
                                                        @foreach($vehicleType as $value)
                                                            <option value="{{$value->id}}">{{$value->libelle}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="error-vehicle_id"></span>
                                                </div>
                                            </div>

                                            <div class="row" >
                                                <div class="col-md-4">
                                                    <h4><strong id="wallet">Total : --</strong> </h4>
                                                </div>
                                                <div class="col-md-4">
                                                    <h4><strong id="distance">Distance : --</strong> </h4>
                                                </div>
                                                <div class="col-md-4">
                                                    <h4><strong id="duration">Time : --</strong> </h4>

                                                </div>
                                            </div>

                                        </fieldset>
                                        <fieldset>
                                            <legend>{{trans('lang.payment_method')}}</legend>

                                            <div class="form-group row width-50">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" id="cash" type="radio"
                                                           name="payment_opt" value="Cash" checked/>
                                                    <label class="form-check-label book" for="cash">Cash</label>
                                                </div>
                                            </div>
                                            <input type="text" id="montant"  name="montant" hidden />
                                              <input type="text" id="duree"  name="duree" hidden />
                                                <input type="text" id="dist"  name="distance" hidden />
                                        </fieldset>
                                    </div>
                                </div>


                                <div class="form-group col-12 text-center btm-btn">
                                    <button type="submit" class="btn btn-primary  create_user_btn"><i
                                                class="fa fa-save"></i> {{ trans('lang.book')}}</button>
                                    <a href="{!! route('rides') !!}" class="btn btn-default"><i
                                                class="fa fa-undo"></i>{{ trans('lang.cancel')}}</a>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script type="text/javascript">
    var default_lat = '23.022505';
    var default_lng ='72.571365';
    var defaultLatLong=JSON.parse('<?php echo json_encode($latlong); ?>');
    if(defaultLatLong.length!=0){
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

    function pickLocation() {
            var input = document.getElementById('pickup');
            var autocomplete = new google.maps.places.Autocomplete(input);
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var place = autocomplete.getPlace();

                address_lat = place.geometry.location.lat();
                $('#pickup_lat').val(address_lat);
                address_lng = place.geometry.location.lng();
                $('#pickup_long').val(address_lng);

                var drop_lat=$('#drop_lat').val();
                var drop_lng=$('#drop_lng').val();
                if(drop_lat!='' && drop_lng!=''){

                  setTimeout(getDirection,1000);
                }
            });

        }

        function dropLocation() {


            var input = document.getElementById('dropup');
            var autocomplete = new google.maps.places.Autocomplete(input);

            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var place = autocomplete.getPlace();

                drop_address_lat = place.geometry.location.lat();
                $('#drop_lat').val(drop_address_lat);
                drop_address_lng = place.geometry.location.lng();
                $('#drop_lng').val(drop_address_lng);
                $('.book_vehicle_type').show();
                setTimeout(getDirection,1000);


            });

        }


        function getDirection(){
            var pickup_lat=  $('#pickup_lat').val();
            var pickup_lng=$('#pickup_long').val();
            var drop_lat=$('#drop_lat').val();
            var drop_lng=$('#drop_lng').val();
            var drop_location=$('#dropup').val();
            var map;

            var marker;
            var myLatlng = new google.maps.LatLng( parseFloat(drop_lat) , parseFloat(drop_lng) );
            var geocoder = new google.maps.Geocoder();
            var infowindow = new google.maps.InfoWindow();

            var mapOptions = {
                zoom: 10,
                center: myLatlng,
                streetViewControl: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            map = new google.maps.Map(document.getElementById("map"), mapOptions);
            console.log(map);
            marker = new google.maps.Marker({
                map: map,
                position: myLatlng,
                draggable: true
            });

            google.maps.event.addListener(marker, 'click', function () {
                infowindow.setContent( drop_location  );
                infowindow.open(map, marker);
            });

            //Set direction route
            let directionsService = new google.maps.DirectionsService();
            let directionsRenderer = new google.maps.DirectionsRenderer();

            directionsRenderer.setMap(map);

            const origin = {lat: parseFloat(pickup_lat) , lng: parseFloat(pickup_lng) };
            const destination = {lat: parseFloat(drop_lat) , lng: parseFloat(drop_lng) };

            const route = {
                origin: origin,
                destination: destination,
                travelMode: 'DRIVING'
            }

            directionsService.route(route, function (response, status) {
                if (status !== 'OK') {
                    window.alert('Directions request failed due to ' + status);
                    return;
                } else {
                    directionsRenderer.setDirections(response);
                    var directionsData = response.routes[0].legs[0];
                }
            });
        }
        $(document).on('change','#vehicle_type',function(){
              var vehicle_type=$('#vehicle_type').val();
              var pickup_lat=  $('#pickup_lat').val();
              var pickup_lng=$('#pickup_long').val();
              var drop_lat=$('#drop_lat').val();
              var drop_lng=$('#drop_lng').val();

              if(vehicle_type){
                $.ajax({
                    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
                        url:'bookNow/getDistance',
                        method:"POST",
                        data:{'vehicle_type':vehicle_type,'pickup_lat':pickup_lat,'pickup_lng':pickup_lng,'drop_lat':drop_lat,'drop_lng':drop_lng},
                        success: function(data){
                            var obj=JSON.parse(data);
                            var wallet=parseFloat(obj['amount']).toFixed(2);
                            var distance=parseFloat(obj['distance']).toFixed(2);
                            var duration=obj['duration'];
                            var currency=obj['currency'];
                            $('#montant').val(wallet);
                            $('#wallet').text("Total : "+currency+" "+wallet);
                            $('#distance').text("Distance : "+distance+" KM");
                            $('#dist').val(distance);
                            $('#duration').text("Time :"+ duration);
                            $('#duree').val(duration);
                        },

                });
            }else{
                $('#wallet').text("Total : --");
                $('#distance').text("Distance : --");
                  $('#duration').text("Time : --");
            }
        });
        $(document).on("blur change keyup", ".required_for_valid", function() {
                    let current_value = $(this).val();
                    let name = $(this).attr("name");
                    if (current_value != '') {
                        $("#error-" + name).html(" ");
                    } else {
                        $("#error-" + name).html("This Field is required");
                        $("#error-" + name).css('color','red');
                    }
                });

</script>

@endsection

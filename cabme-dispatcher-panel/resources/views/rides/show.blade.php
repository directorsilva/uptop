@extends('layouts.app')

@section('content')

    <div class="page-wrapper ridedetail-page">

        <div class="row page-titles">

            <div class="col-md-5 align-self-center">

                <h3 class="text-themecolor">{{trans('lang.ride_detail')}}</h3>

            </div>

            <div class="col-md-7 align-self-center">

                <ol class="breadcrumb">

                    <li class="breadcrumb-item">
                        <a href="{!! url('/dashboard') !!}">{{trans('lang.home')}}</a>
                    </li>

                    <li class="breadcrumb-item">
                        <a href="{!! route('rides') !!}">{{trans('lang.all_rides')}}</a>
                    </li>

                    <li class="breadcrumb-item active">
                        {{trans('lang.ride_detail')}}
                    </li>

                </ol>

            </div>
        </div>

        <div class="container-fluid">

            <div class="row">

                <div class="col-12">

                    <div class="card">
                        <div class="card-body">
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

                            <div id="data-table_processing" class="dataTables_processing panel panel-default"
                                 style="display: none;">{{trans('lang.processing')}}</div>

                                 <form method="post" action="{{ route('rides.update',$ride->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method("PUT")
                                <div class="order_detail px-2" id="order_detail">
                                    <div class="order_detail-top">
                                        <div class="row">
                                            <div class="order_edit-genrl col-md-6">

                                                <h3>{{trans('lang.general_details')}}</h3>
                                                <div class="order_detail-top-box">

                                                    <div class="form-group row widt-100 gendetail-col">
                                                        <label class="col-12 control-label"><strong>{{trans('lang.date_created')}}
                                                                : </strong><span
                                                                    id="createdAt">{{ date('d F Y h:i A',strtotime($ride->creer))}}</span></label>
                                                    </div>
                                                    <div class="form-group row widt-100 gendetail-col">
                                                        <label class="col-12 control-label"><strong>{{trans('lang.number_poeple')}}
                                                                : </strong><span
                                                                    id="no_of_people">{{ $ride->number_poeple}}</span></label>
                                                    </div>

                                                    <div class="form-group row widt-100 gendetail-col payment_method">
                                                        <label class="col-12 control-label"><strong>{{trans('lang.payment_methods')}}
                                                        : </strong><span id="payment_method">{{$ride->payment_methods}}</span>
                                                        </label>
                                                    </div>

                                                    <div class="form-group row widt-100 gendetail-col payment_method">
                                                        <label class="col-12 control-label"><strong>{{trans('lang.total_amount')}}
                                                        : </strong><span id="payment_method">
                                                            @if($currency->symbol_at_right=="true")
                                                            {{ number_format($ride->montant,$currency->decimal_digit).$currency->symbole }}
                                     
                                                            @else
                                                            {{ $currency->symbole.number_format($ride->montant,$currency->decimal_digit) }}
                                                            @endif
                                                        </span>
                                                        </label>
                                                    </div>


                                                    <div class="form-group row width-100 ">
                                                        <label class="col-3 control-label">{{trans('lang.ride_status')}}
                                                            :</label>
                                                        <div class="col-7">

                                                            @php
                                                                $status = ['new' => 'New', 'confirmed' => 'Confirmed', 'on ride'
                                                                => 'On Ride', 'completed' => 'Completed', 'canceled' => 'Canceled', 'rejected' => 'Rejected','driver_rejected'=>'Driver Rejected']

                                                            @endphp

                                                            <select name="order_status" class="form-control">
                                                                @foreach ($status as $key => $value)
                                                                    <option value="{{ $key }}" {{ ( $key == $ride->statut) ? 'selected' : '' }}> {{ $value }} </option>
                                                                @endforeach

                                                            </select>

                                                        </div>
                                                    </div>


                                                </div>

                                            </div>

                                            <div class="order_edit-genrl col-md-6">
                                                <h3>{{ trans('lang.customer_details')}}</h3>


                                                <div class="address order_detail-top-box">
                                                    <div class="form-group row widt-100 gendetail-col">
                                                        <label class="col-12 control-label"><strong
                                                                    style="width:30%">{{trans('lang.name')}}
                                                                : </strong><span style="margin-left: 10%;"
                                                                                 id="billing_name">{{ $ride->userPreNom}} {{ $ride->userNom}}</span></label>

                                                    </div>

                                                    <div class="form-group row widt-100 gendetail-col">
                                                        <label class="col-12 control-label"><strong
                                                                    style="width:30%">{{trans('lang.email')}}
                                                                : </strong><span style="margin-left: 10%;"
                                                                                 id="billing_email">{{$ride->userEmail}}</span></label>

                                                    </div>
                                                    <div class="form-group row widt-100 gendetail-col">
                                                        <label class="col-12 control-label"><strong
                                                                    style="width:30%">{{trans('lang.phone')}}
                                                                : </strong><span style="margin-left: 10%;"
                                                                                 id="billing_phone">{{$ride->userPhone}}</span></label>

                                                    </div>


                                                </div>


                                            </div>

                                        </div>
                                        <div class="order-deta-btm mt-4">
                                            <div class="row">

                                                <div class="col-md-6 order-deta-btm-right">
                                                    <div class="resturant-detail">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h4 class="card-header-title">{{trans('lang.ride_detail')}}</h4>
                                                            </div>
                                                            <div class="card-body">
                                                                <h5 class="contact-info">{{trans('lang.pickup_location')}}:</h5>
                                                                <p>{{$ride->depart_name}}</p>
                                                                <h5 class="contact-info">{{trans('lang.dropup_location')}}:</h5>
                                                                <p>{{$ride->destination_name}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 order-deta-btm-right">
                                                    <div class="resturant-detail">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h4 class="card-header-title">{{trans('lang.driver_detail')}}</h4>
                                                            </div>

                                                            <div class="card-body">
                                                                <h5 class="contact-info">{{trans('lang.contact_info')}}:</h5>
                                                                <p><strong>{{trans('lang.name')}}:</strong>
                                                                    <span id="vendor_name">{{$ride->driverPreNom}} {{$ride->driverNom}}</span>
                                                                </p>
                                                                <p><strong>{{trans('lang.email')}}:</strong>
                                                                    <span id="vendor_email">{{$ride->driverEmail}}</span>
                                                                </p>
                                                                <p><strong>{{trans('lang.phone')}}:</strong>
                                                                    <span id="vendor_phone">{{$ride->driverPhone}}</span>
                                                                </p>

                                                                <h5 class="contact-info">{{trans('lang.car_info')}}:</h5>

                                                                <p><strong style="width:auto !important;">{{trans('lang.brand')}}
                                                                        :</strong>
                                                                    <span id="driver_carName">{{$ride->brand}}</span>
                                                                </p>
                                                                <p><strong style="width:auto !important;">{{trans('lang.car_number')}}
                                                                        :</strong>
                                                                    <span id="driver_carNumber">{{$ride->numberplate}}</span>
                                                                </p>
                                                                <p><strong style="width:auto !important;">{{trans('lang.car_model')}}
                                                                        :</strong>
                                                                    <span id="driver_carNumber">{{$ride->model}}</span>
                                                                </p>

                                                                <p><strong style="width:auto !important;">{{trans('lang.car_make')}}
                                                                        :</strong>
                                                                    <span id="driver_car_make">{{$ride->car_make}}</span>
                                                                </p>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                    </div>
                                </div>

                        </div>

                    </div>


                    <!--  </div> -->


                    <div class="form-group col-12 text-center btm-btn">
                        <button type="submit" class="btn btn-primary save_order_btn"><i
                                    class="fa fa-save"></i> {{trans('lang.save')}}</button>
                        <a href="javascript:history.go(-1)" class="btn btn-default"><i
                                    class="fa fa-undo"></i>{{trans('lang.cancel')}}</a>

                    </div>
                    <div class="form-group col-12 text-center btm-btn"></div>
                    <div class="form-group col-12 text-center btm-btn"></div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    </div>


@endsection
@section('scripts')

    <script type="text/javascript">
        var map;
        var marker;
        var myLatlng = new google.maps.LatLng({!! $ride->latitude_arrivee !!},{!! $ride->longitude_arrivee !!});
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
            infowindow.setContent('{!! $ride->destination_name !!}');
            infowindow.open(map, marker);
        });

        //Set direction route
        let directionsService = new google.maps.DirectionsService();
        let directionsRenderer = new google.maps.DirectionsRenderer();

        directionsRenderer.setMap(map);

        const origin = {lat: {!! $ride->latitude_depart !!}, lng: {!! $ride->longitude_depart !!}};
        const destination = {lat: {!! $ride->latitude_arrivee !!}, lng: {!! $ride->longitude_arrivee !!}};

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

    </script>

@endsection

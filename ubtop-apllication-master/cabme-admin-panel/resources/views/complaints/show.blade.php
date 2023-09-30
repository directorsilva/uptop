@extends('layouts.app')

@section('content')

<div class="page-wrapper ridedetail-page">

	<div class="row page-titles">

		<div class="col-md-5 align-self-center">

			<h3 class="text-themecolor">{{trans('lang.complaints_detail')}}</h3>

		</div>

		<div class="col-md-7 align-self-center">

			<ol class="breadcrumb">

				<li class="breadcrumb-item">
					<a href="{!! url('/dashboard') !!}">{{trans('lang.home')}}</a>
				</li>

				<li class="breadcrumb-item">
					<a href="{!! route('complaints') !!}">{{trans('lang.complaints')}}</a>
				</li>

				<li class="breadcrumb-item active">
				{{trans('lang.complaints_detail')}}
				</li>

			</ol>

		</div>

	</div>

	<div class="container-fluid">

		<div class="row">

			<div class="col-12">

				<div class="card">

					<div class="card-body p-0 pb-5">

						<div class="user-top">

							<div class="row align-items-center">

								<!--<div class="user-profile col-md-2">

									<div class="profile-img">


									</div>

								</div>-->
								<div class="user-title col-md-8">
									<h4 class="card-title"> Details of Complaint</h4>
								</div>
							</div>
						</div>

						<div class="user-detail taxi-detail" role="tabpanel">

							<!-- Nav tabs -->
							<ul class="nav nav-tabs">

								<li role="presentation" class="">
									<a href="#user" aria-controls="information" role="tab" data-toggle="tab" class="{{ (Request::get('tab') == 'user' || Request::get('tab') == '') ? 'active show' : '' }}">User</a>
								</li>
								<li role="presentation" class="">
									<a href="#driver" aria-controls="driver" role="tab" data-toggle="tab" class="{{ (Request::get('tab') == 'driver') ? 'active show' : '' }}}}">Driver</a>
								</li>

								<li role="presentation" class="">
									<a href="#complaint" aria-controls="complaint" role="tab" data-toggle="tab" class="{{ (Request::get('tab') == 'complaint') ? 'active show' : '' }}">Complaint</a>
								</li>

							</ul>

							<!-- Tab panes -->
							<div class="tab-content">

								<div role="tabpanel" class="tab-pane {{ (Request::get('tab') == 'user' || Request::get('tab') == '') ? 'active' : '' }}" id="user">

									<div class="row">
										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.user_name')}}:</label>
												<span>{{ $complaints->userPrenom}} {{ $complaints->userNom}}</span>
											</div>
										</div>

										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.user_phone')}}:</label>
												<span>{{ $complaints->user_phone}}</span>
											</div>
										</div>

										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.email')}}:</label>
												<span>{{ $complaints->user_email}}</span>
											</div>
										</div>




									</div>

								</div>
								<div role="tabpanel" class="tab-pane {{ Request::get('tab') == 'driver' ? 'active' : '' }}" id="driver">

									<div class="row">
										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.driver_name')}}:</label>
												<span>{{ $complaints->driverPrenom}} {{ $complaints->driverNom}}</span>
											</div>
										</div>

										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.driver_phone')}}:</label>
												<span>{{ $complaints->driver_phone}}</span>
											</div>
										</div>

										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.email')}}:</label>
												<span>{{ $complaints->driver_email}}</span>
											</div>
										</div>




									</div>

								</div>

								<div role="tabpanel" class="tab-pane {{ Request::get('tab') == 'complaint' ? 'active' : '' }}" id="complaint">

									<div class="row">

										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.title')}}:</label>
												<span >{{ $complaints->title}}</span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.message')}}:</label>
												<span>{{ $complaints->description}}</span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.complaint_by')}}:</label>
												<span>{{ $complaints->user_type}}</span>
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
</div>


@endsection

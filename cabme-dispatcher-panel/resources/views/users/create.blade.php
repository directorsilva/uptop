@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{trans('lang.create_user')}}</h3>
        </div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.create_user')}}</li>
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
                        <form action="{{ route('bookNow.storeuser') }}" method="post" enctype="multipart/form-data"
                              id="create_driver">
                            @csrf
                            <div class="row restaurant_payout_create">
                                <div class="restaurant_payout_create-inner">
                                    <fieldset>
                                        <legend>{{trans('lang.user_details')}}</legend>


                                        <div class="form-group row width-50">
                                            <label class="form-label">{{trans('lang.first_name')}}</label>
                                            <div class="col-7">
                                                <input placeholder="First Name" type="text" name="first_name"
                                                       class="form-control">

                                            </div>
                                        </div>
                                        <div class="form-group row width-50">
                                            <label class="form-label">{{trans('lang.last_name')}}</label>
                                            <div class="col-7">
                                                <input placeholder="Last Name" type="text" name="last_name"
                                                       class="form-control">

                                            </div>
                                        </div>
                                        <div class="form-group row width-50">
                                            <label class="form-label">{{trans('lang.phone')}}</label>
                                            <div class="col-7">
                                                <input placeholder="Phone" type="text" name="phone" class="form-control">

                                            </div>
                                        </div>
                                        <div class="form-group row width-50">
                                            <label class="form-label">{{trans('lang.email')}}</label>
                                            <div class="col-7">
                                                <input placeholder="Email Address" type="text" name="email"
                                                       class="form-control">

                                            </div>
                                        </div>
                                        <div class="form-group row width-50">
                                            <label class="form-label">{{trans('lang.password')}}</label>
                                            <div class="col-7">
                                                <input placeholder="Password" type="password" name="password"
                                                       class="form-control" id="password" required autocomplete="new-password">

                                            </div>
                                        </div>
                                        <div class="form-group row width-50">
                                            <label class="form-label">{{trans('lang.confirm_password')}}</label>
                                            <div class="col-7">
                                                <input placeholder="Confirm Password" type="password" name="confirm_password"
                                                       class="form-control" id="conf_password" required >
                                                <span id="error_msg"></span>

                                            </div>
                                        </div>
                                    </fieldset>

                                </div>
                            </div>


                            <div class="form-group col-12 text-center btm-btn">
                                <button type="submit" id="saveBtn" class="btn btn-primary  create_user_btn"><i
                                            class="fa fa-save"></i> {{ trans('lang.save')}}
                                </button>
                                <a href="{!! route('bookNow') !!}" class="btn btn-default"><i
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript">

  $(document).on('change','#conf_password',function(){

    var password=$('#password').val();
    var confirm_password=$('#conf_password').val();

    checkPassword(password,confirm_password);


  });
   $(document).on('click', '#saveBtn', function () {
    var password=$('#password').val();
    var confirm_passwor=$('#confirm_password').val();
    checkPassword(password,confirm_password);

  });
  function checkPassword(password,confirm_pass){

    if(password!=confirm_pass){
      $('#error_msg').text("Password doesn't match");
      $('#error_msg').css('color','red');
      return false;
    }
    else{
      
      $('#error_msg').text("PassWord Matched!");
      $('#error_msg').css('color','green');
    }
  }
</script>

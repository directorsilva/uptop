@extends('layouts.app')


@section('content')
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{trans('lang.language_edit')}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item"><a href="{!! route('language') !!}">{{trans('lang.user_plural')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.language_edit')}}</li>
            </ol>
        </div>

    </div>

    <div>
        <div class="card-body">

            <div id="data-table_processing" class="dataTables_processing panel panel-default" style="display: none;">
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
            <form method="post" action="{{ route('language.update',$language->id) }}" enctype="multipart/form-data">
                @csrf
                @method("PUT")
                <div class="row restaurant_payout_create">
                    <div class="restaurant_payout_create-inner">

                        <fieldset>
                            <legend>{{trans('lang.language_edit')}}</legend>
                            <div class="form-group row width-50">
                                <label class="col-3 control-label">{{trans('lang.language')}}</label>
                                <div class="col-7">
                                    <input type="text" class="form-control language" name="language"
                                           value="{{$language->language}}">
                                    <div class="form-text text-muted">
                                        {{ trans("lang.language_help") }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row width-50">
                                <label class="col-3 control-label">{{trans('lang.code')}}</label>
                                <div class="col-7">
                                    <input type="text" class="form-control code" name="code"
                                           value="{{$language->code}}">
                                    <div class="form-text text-muted">
                                        {{ trans("lang.code_help") }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row width-100">
                                <label class="col-2 control-label">{{trans('lang.flag')}}</label>
                                <input type="file" class="col-6 photo" name="flag">

                                @if (file_exists(public_path('assets/images/flags'.'/'.$language->flag)) && !empty($language->flag))
                                <img class="rounded" style="width:50px"
                                     src="{{asset('assets/images/flags').'/'.$language->flag}}" alt="image">
                                @else
                                <img class="rounded" style="width:50px"
                                      src="{{asset('assets/images/placeholder_image.jpg')}}" alt="image">

                                @endif

                            </div>

                            <div class="form-group row width-50">

                                <div class="form-check">

                                    @if ($language->status === "true")
                                    <input type="checkbox" class="user_active" name="status" id="status"
                                           checked="checked">
                                    @else
                                    <input type="checkbox" class="user_active" name="status" id="status" value="false"/>
                                    @endif
                                    <label class="col-3 control-label"
                                           for="status">{{trans('lang.active')}}</label>
                                </div>

                            </div>

                            <div class="form-group row width-50">

                                <div class="form-check">

                                    @if ($language->is_rtl === "true")
                                    <input type="checkbox" class="user_active" name="is_rtl" id="is_rtl"
                                           checked="checked">
                                    @else
                                    <input type="checkbox" class="user_active" name="is_rtl" id="is_rtl" value="false">
                                    @endif
                                    <label class="col-3 control-label" for="is_rtl">{{trans('lang.is_rtl')}}</label>
                                </div>

                            </div>
                        </fieldset>


                    </div>
                </div>
        </div>
        <div class="form-group col-12 text-center btm-btn">
            <button type="submit" class="btn btn-primary  save_user_btn"><i class="fa fa-save"></i> {{
                trans('lang.save')}}
            </button>
            <a href="{!! route('language') !!}" class="btn btn-default"><i class="fa fa-undo"></i>{{
                trans('lang.cancel')}}</a>
        </div>

    </div>
    </form>

</div>
@endsection

@section('scripts')
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>

<script> -->

<!-- // 	var id = <?php //echo $user ?>;

// 	var database = firebase.firestore();
// 	var ref = database.collection('users').where("id","==",id);
// 	var photo = '';
// 	var placeholderImage = '';
//     var placeholder = database.collection('settings').doc('placeHolderImage');

//     placeholder.get().then( async function(snapshotsimage){
//         var placeholderImageData = snapshotsimage.data();
//         placeholderImage = placeholderImageData.image;
//     })
// 	$(document).ready(function(){


//  		jQuery("#data-table_processing").show();

//   		ref.get().then( async function(snapshots){

// 		var user = snapshots.docs[0].data();
// 		$(".user_first_name").val(user.firstName);
// 		$(".user_last_name").val(user.lastName);
// 		$(".user_email").val(user.email);
// 		$(".user_phone").val(user.phoneNumber);
// 		if(user.shippingAddress && user.shippingAddress.line1){
// 			$(".address_line1").val(user.shippingAddress.line1);
// 		}
// 		if(user.shippingAddress && user.shippingAddress.line2){
// 			$(".address_line2").val(user.shippingAddress.line2);
// 		}
// 		if(user.shippingAddress && user.shippingAddress.city){
// 			$(".city").val(user.shippingAddress.city);
// 		}
// 		if(user.shippingAddress && user.shippingAddress.country){
// 			$(".country").val(user.shippingAddress.country);
// 		}
// 		if(user.shippingAddress && user.shippingAddress.postalCode){
// 			$(".postalcode").val(user.shippingAddress.postalCode);
// 		}
// 		if(user.shippingAddress && user.shippingAddress.location.latitude){
// 			$(".user_latitude").val(user.shippingAddress.location.latitude);
// 		}
// 		if(user.shippingAddress && user.shippingAddress.location.longitude){
// 			$(".user_longitude").val(user.shippingAddress.location.longitude);
// 		}
// 		photo = user.profilePictureURL;
// 		console.log(photo);
// 		if (photo!='') {

// 			$(".user_image").append('<img class="rounded" style="width:50px" src="'+photo+'" alt="image">');
// 		}
// 		else{

// 			$(".user_image").append('<img class="rounded" style="width:50px" src="'+placeholderImage+'" alt="image">');
// 		}
		
// 		if(user.active){
// 		  $(".user_active").prop('checked',true);
// 		}


//   	jQuery("#data-table_processing").hide();
 
//   })


  
// $(".save_user_btn").click(function(){
 
// 	var userFirstName = $(".user_first_name").val();
// 	var userLastName = $(".user_last_name").val();
// 	var email = $(".user_email").val();
// 	var userPhone = $(".user_phone").val();
// 	var active = $(".user_active").is(":checked");
// 	var password = $(".user_password").val();
// 	var user_name = userFirstName+" "+userLastName;
// 	var address_line1 = $(".address_line1").val();
// 	var address_line2 = $(".address_line2").val();
// 	var city = $(".city").val();
// 	var country = $(".country").val();
// 	var postalcode = $(".postalcode").val();

// 	var latitude = parseFloat($(".user_latitude").val());
// 	var longitude = parseFloat($(".user_longitude").val());

// 	var location = {'latitude':latitude ,'longitude':longitude };
// 	var shippingAddress = { 'city': city,'country': country,'email': email,'line1': address_line1,'line2': address_line2,'location': location, 'name': name,'postalCode': postalcode};

//  	if(userFirstName == ''){
//         $(".error_top").show();
//         $(".error_top").html("");
//         $(".error_top").append("<p>{{trans('lang.user_firstname_error')}}</p>");
//         window.scrollTo(0, 0);

//     }else if(email == ''){
//         $(".error_top").show();
//         $(".error_top").html("");
//         $(".error_top").append("<p>{{trans('lang.user_email_error')}}</p>");
//         window.scrollTo(0, 0);
//     } else if(userPhone == '' ){
//         $(".error_top").show();
//         $(".error_top").html("");
//         $(".error_top").append("<p>{{trans('lang.user_phone_error')}}</p>");
//         window.scrollTo(0, 0);
//     }else if(address_line1 == '' ){
// 	    $(".error_top").show();
// 	    $(".error_top").html("");
// 	    $(".error_top").append("<p>{{trans('lang.address_line1_error')}}</p>");
// 	    window.scrollTo(0, 0);
//  	}  else if(city == '' ){
// 	    $(".error_top").show();
// 	    $(".error_top").html("");
// 	    $(".error_top").append("<p>{{trans('lang.city_error')}}</p>");
// 	    window.scrollTo(0, 0);
//  	}  else if(country == '' ){
// 	    $(".error_top").show();
// 	    $(".error_top").html("");
// 	    $(".error_top").append("<p>{{trans('lang.country_error')}}</p>");
// 	    window.scrollTo(0, 0);
//  	} else if(postalcode == '' ){
// 	    $(".error_top").show();
// 	    $(".error_top").html("");
// 	    $(".error_top").append("<p>{{trans('lang.postalcode_error')}}</p>");
// 	    window.scrollTo(0, 0);
//  	} else if(latitude < -90 || latitude > 90){
//       	$(".error_top").show();
//         $(".error_top").html("");
//         $(".error_top").append("<p>{{trans('lang.user_lattitude_limit_error')}}</p>");
//         window.scrollTo(0, 0);
//   	}else if(longitude < -180 || longitude > 180){
//       $(".error_top").show();
//       $(".error_top").html("");
//       $(".error_top").append("<p>{{trans('lang.user_longitude_limit_error')}}</p>");
//       window.scrollTo(0, 0);

//   	}else{

//        database.collection('users').doc(id).update({'firstName':userFirstName,'lastName':userLastName,'email':email,'phoneNumber':userPhone,'isActive':active,'profilePictureURL':photo,'role':'customer','shippingAddress':shippingAddress,'active':active}).then(function(result) {
                
//                 window.location.href = '{{ route("users")}}';

//              }); 
//    }
    
// })


// })
// var storageRef = firebase.storage().ref('images');
// function handleFileSelect(evt) {
//   var f = evt.target.files[0];
//   var reader = new FileReader();
  

//   reader.onload = (function(theFile) {
//     return function(e) {
        
//       var filePayload = e.target.result;
//       var hash = CryptoJS.SHA256(Math.random() + CryptoJS.SHA256(filePayload));
//       var val =f.name;       
//       var ext=val.split('.')[1];
//       var docName=val.split('fakepath')[1];
//       var filename = (f.name).replace(/C:\\fakepath\\/i, '')
//       var timestamp = Number(new Date()); 
// 	  console.log(storageRef);
//       var uploadTask = storageRef.child(filename).put(theFile);
	
//       uploadTask.on('state_changed', function(snapshot){
//       var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
	 
//       console.log('Upload is ' + progress + '% done');
//       jQuery("#uploding_image").text("Image is uploading...");
//     }, function(error) {
//     }, function() {
//         uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
//             jQuery("#uploding_image").text("Upload is completed");
//             photo = downloadURL;
//             $(".user_image").empty();
//             $(".user_image").append('<img class="rounded" style="width:50px" src="'+photo+'" alt="image">');


//       });   
//     });
    
//     };
//   })(f);
//   reader.readAsDataURL(f);
// }   


</script> -->
@endsection
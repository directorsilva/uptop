@extends('layouts.app')

@section('content')
    <div class="page-wrapper">

        <!-- ============================================================== -->

        <!-- Bread crumb and right sidebar toggle -->

        <!-- ============================================================== -->

        <div class="row page-titles">

            <div class="col-md-5 align-self-center">

                <h3 class="text-themecolor">{{trans('lang.all_rides')}}</h3>

            </div>

            <div class="col-md-7 align-self-center">

                <ol class="breadcrumb">

                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>



                    <li class="breadcrumb-item active">{{trans('lang.all_rides')}}</li>

                </ol>

            </div>

            <div>

            </div>

        </div>


        <div class="container-fluid">

            <div class="row">

                <div class="col-12">

                    <div class="card">

                        <div class="card-body">

                            <h4 class="card-title"></h4>

                            <div class="userlist-topsearch d-flex mb-3">
                                <div class="userlist-top-left">
                                    <a class="nav-link" href="{{ route('bookNow') }}"><i
                                                class="fa fa-plus mr-2"></i>{{trans('lang.book_now')}}</a>
                                </div>&nbsp;&nbsp;

                                <div id="users-table_filter" class="ml-auto">
                                    <div class="form-group  mb-0">

                                        <form action="{{ route('rides') }}" method="get" id="rideFormData">
                                            <div class="search-box position-relative">
                                                <select id="ride_status" class="search form-control" name="ride_status">
                                                    <option value="">{{ trans('lang.select_status')}}</option>
                                                    <option @if(@$_GET['ride_status']=='confirmed')selected="selected" @endif  value="confirmed">{{ trans('lang.confirmed')}}</option>
                                                    <option @if(@$_GET['ride_status']=='new')selected="selected" @endif  value="new">{{ trans('lang.new')}}</option>
                                                    <option @if(@$_GET['ride_status']=='on ride')selected="selected" @endif  value="on ride">{{ trans('lang.on_ride')}}</option>
                                                    <option @if(@$_GET['ride_status']=='completed')selected="selected" @endif  value="completed">{{ trans('lang.completed')}}</option>
                                                    <option @if(@$_GET['ride_status']=='canceled')selected="selected" @endif  value="canceled">{{ trans('lang.canceled')}}</option>
                                                    <option @if(@$_GET['ride_status']=='rejected')selected="selected" @endif  value="rejected">{{ trans('lang.rejected')}}</option>
                                                    <option @if(@$_GET['ride_status']=='driver rejected')selected="selected" @endif  value="driver rejected">{{ trans('lang.driver_rejected')}}</option>
                                                </select>
                                                <!--<button type="submit" class="btn-flat position-absolute"><i class="fa fa-search"></i></button>-->
                                            </div>
                                        </form>

                                    </div>

                                </div>


                            </div>

                            <div class="table-responsive m-t-10">

                                <table id="example24"
                                       class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                       cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>{{trans('lang.ride_id')}}</th>
                                      {{--  <th>{{trans('lang.user_name')}}</th>
                                        <th>{{trans('lang.driver_name')}}</th>
                                        <th>{{trans('lang.cost_amount')}}</th>--}}
                                        <th>{{trans('lang.pickup_location')}}</th>
                                        <th>{{trans('lang.dropup_location')}}</th>
                                        <th>{{trans('lang.ride_status')}}</th>
                                        <th>{{trans('lang.date')}}</th>
                                        <th>{{trans('lang.actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody id="append_list12">

                                        @if(count($rides) > 0)
                                            @foreach($rides as $ride)
                                            <tr>
                                                <td><a href="{{route('ride.show', ['id' => $ride->id])}}">{{ $ride->id}}</a></td>
                                              {{--  <td>{{ $ride->userNom}}{{ $ride->userPreNom}} </td>
                                            <td>{{ $ride->driverPreNom}} {{ $ride->driverNom}}</td>
                                            <td>@if($ride->montant)
                                                {{$currency->symbole}}{{ $ride->montant}}
                                                @else
                                                @endif</td>--}}
                                                <td>{{ $ride->depart_name}}</td>
                                                <td>{{ $ride->destination_name}}</td>

                                                <td>  @if($ride->statut=='new')
                                                <span class="badge badge-primary">{{ trans('lang.new')}}</span>
                                                      @elseif($ride->statut=='on ride')
                                                      <span class="badge badge-warning"> {{ trans('lang.on_ride')}}</span>
                                                      @elseif($ride->statut=='confirmed')
                                                      <span class="badge badge-success">{{ trans('lang.confirmed')}}</span>
                                                      @elseif($ride->statut=='canceled')
                                                      <span class="badge badge-danger">{{ trans('lang.canceled')}}</span>
                                                      @elseif($ride->statut=='completed')
                                                      <span class="badge badge-success"> {{ trans('lang.completed')}}</span>
                                                      @elseif($ride->statut=='rejected')
                                                      <span class="badge badge-danger"> {{ trans('lang.rejected')}}</span>
                                                      @elseif($ride->statut=='driver rejected')
                                                      <span class="badge badge-danger">{{ trans('lang.driver_rejected')}}</span>
                                                      @endif</td>
                                                <td class="dt-time">

                                                        <span class="date">{{ date('d F Y',strtotime($ride->creer))}}</span>
                                                        <span class="time">{{ date('h:i A',strtotime($ride->creer))}}</span>

                                                </td>
                                                <td class="action-btn">
                                                    <a href="{{route('ride.show', ['id' => $ride->id])}}" class=""
                                                        data-toggle="tooltip" data-original-title="Details"><i
                                                          class="fa fa-eye"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" align="center">{{trans("lang.no_result")}}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>

                                <nav aria-label="Page navigation example" class="custom-pagination">
                                    {{$rides->appends(request()->query())->links()}}
                                </nav>
                                {{ $rides->links('pagination.pagination') }}

                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection

@section('scripts')

    <script type="text/javascript">
        $("#is_active").click(function () {
            $("#example24 .is_open").prop('checked', $(this).prop('checked'));

        });

        $("#deleteAll").click(function () {
            if ($('#example24 .is_open:checked').length) {
                if (confirm('Are You Sure want to Delete Selected Data ?')) {
                    var arrayUsers = [];
                    $('#example24 .is_open:checked').each(function () {
                        var dataId = $(this).attr('dataId');
                        arrayUsers.push(dataId);

                    });

                    arrayUsers = JSON.stringify(arrayUsers);
                    var url = "{{url('ride/delete', 'rideid')}}";
                    url = url.replace('rideid', arrayUsers);

                    $(this).attr('href', url);
                }
            } else {
                alert('Please Select Any One Record .');
            }
        });

        $("#ride_status").change(function () {

            $('#rideFormData').submit();
        });
    </script>
@endsection

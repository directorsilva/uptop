@extends('layouts.app')

@section('content')
<div class="page-wrapper">

    <div class="row page-titles">

        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor">{{trans('lang.complaints')}}</h3>

        </div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a>
                </li>
                <li class="breadcrumb-item active">
                    {{trans('lang.complaints')}}
                </li>
            </ol>
        </div>

    </div>

    <div class="container-fluid">

        <div class="row">

            <div class="col-12">

                <div class="card">

                    <div class="card-body">

                        <div class="userlist-topsearch d-flex mb-3">

                            <div id="users-table_filter" class="ml-auto">

                                <label>{{ trans('lang.search_by')}}

                                    <div class="form-group">

                                        <form action="{{ route('complaints') }}" method="get">
                                            @if(isset($_GET['selected_search']) && $_GET['selected_search'] != '')
                                            <select name="selected_search" id="selected_search"
                                                    class="form-control input-sm">

                                                @if($_GET['selected_search'] == "title")
                                                <option value="title" selected>{{ trans('lang.title')}}</option>
                                                <option value="message">{{ trans('lang.message')}}</option>
                                                @elseif($_GET['selected_search'] == "message")
                                                <option value="title">{{ trans('lang.title')}}</option>
                                                <option value="message" selected>{{ trans('lang.message')}}</option>
                                                @endif

                                            </select>
                                            @else
                                            <select name="selected_search" id="selected_search"
                                                    class="form-control input-sm">
                                                <option value="title">{{ trans('lang.title')}}</option>
                                                <option value="message">{{ trans('lang.message')}}</option>
                                            </select>
                                            @endif
                                            <div class="search-box position-relative">
                                                @if(isset($_GET['search']) && $_GET['search'] != '')
                                                <input type="text" class="search form-control" name="search"
                                                       id="search" value="{{$_GET['search']}}">
                                                @else
                                                <input type="text" class="search form-control" name="search"
                                                       id="search">
                                                @endif
                                                <button type="submit" class="btn-flat position-absolute"><i
                                                            class="fa fa-search"></i></button>
                                                <a class="btn btn-warning btn-flat"
                                                   href="{{url('complaints')}}">Clear</a>
                                            </div>
                                        </form>
                                    </div>
                                 </label>
                            </div>

                        </div>

                        <div class="table-responsive m-t-10">

                            <table id="example24"
                                   class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                   cellspacing="0" width="100%">

                                <thead>

                                <tr>
                                    <th class="delete-all"><input type="checkbox" id="is_active"><label
                                                class="col-3 control-label" for="is_active"><a id="deleteAll"
                                                                                               class="do_not_delete"
                                                                                               href="javascript:void(0)"><i
                                                        class="fa fa-trash"></i> All</a></label></th>
                                    <th>{{trans('lang.driver_plural')}}</th>
                                    <th>{{trans('lang.user_name')}}</th>
                                    <th>{{trans('lang.title')}}</th>
                                    <th>{{trans('lang.message')}}</th>
                                    <th>{{trans('lang.created')}}</th>
                                    {{--
                                    <th>{{trans('lang.modified')}}</th>
                                    --}}
                                    <th>{{trans('lang.actions')}}</th>
                                </tr>

                                </thead>

                                <tbody id="append_list1">
								@if(count($complaints) > 0)
                                @foreach($complaints as $complaint)

                                <tr>
                                    <td class="delete-all"><input type="checkbox"
                                                                  id="is_open_{{$complaint->id}}"
                                                                  class="is_open"
                                                                  dataid="{{$complaint->id}}"><label
                                                class="col-3 control-label"
                                                for="is_open_{{$complaint->id}}"></label></td>

                                    <td><a href="{{route('driver.show', ['id' => $complaint->driverId])}}">{{ $complaint->driverName}}</a></td>
                                    <td><a href="{{route('users.show', ['id' => $complaint->userId])}}">{{ $complaint->userName}}</a></td>
                                    <td>{{ $complaint->title}}</td>
                                    <td>{{ $complaint->description}}</td>
                                    <td>
                                        <span class="date">{{ date('d F Y',strtotime($complaint->created))}}</span>
                                        <span class="time">{{ date('h:i A',strtotime($complaint->created))}}</span>
                                    </td>
                                    {{--
                                    <td>{{ $complaint->modifier}}</td>
                                    --}}

                                    <td class="action-btn">
                                    <a href="{{route('complaints.show', ['id' => $complaint->id])}}" class=""
                                                   data-toggle="tooltip" data-original-title="Details"><i
                                                            class="fa fa-eye"></i></a>
                                        <a id="'+val.id+'"
                                           class="do_not_delete"
                                           name="user-delete"
                                           href="{{route('complaints.delete', ['id' => $complaint->id])}}"><i
                                                    class="fa fa-trash"></i></a>
                                    </td>
                                </tr>

                                @endforeach
                                  @else
                                	<tr><td colspan="11" align="center">{{trans("lang.no_result")}}</td></tr>
                                @endif
                                </tbody>

                            </table>

                            <nav aria-label="Page navigation example" class="custom-pagination">
                            {{$complaints->appends(request()->query())->links()}}
                            </nav>
{{ $complaints->links('pagination.pagination') }}
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
    $(document).ready(function () {

    })

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
                var url = "{{url('complaints/delete', 'id')}}";
                url = url.replace('id', arrayUsers);

                $(this).attr('href', url);
            }
        } else {
            alert('Please Select Any One Record .');
        }
    });
    
</script>

@endsection

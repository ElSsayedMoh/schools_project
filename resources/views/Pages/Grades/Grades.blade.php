@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    {{trans('trans_school.list_school_grade')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0"> {{trans('trans_school.School_Grade')}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">{{trans('trans_school.Home')}}</a></li>
                <li class="breadcrumb-item active">{{trans('trans_school.School_Grade')}}</li>
            </ol>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <div class="col-xl-12 mb-30">     
        <div class="card card-statistics h-100"> 
            <div class="card-body">

                <button type="button" class="button x-small" data-toggle="modal" data-target="#exampleModal">
                    {{ trans('trans_school.add_Grade') }}
                </button>
                <br><br>

            <div class="table-responsive">
                <table id="datatable" class="table table-striped table-bordered p-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <i class="fa-regular fa-trash-can"></i>
                            <th>{{trans('trans_school.Name_Grade')}}</th>
                            <th>{{trans('trans_school.Notes')}}</th>
                            <th>{{trans('trans_school.Processes')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($grades as $grade)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{$grade->name}}</td>
                                <td>{{$grade->notes}}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#edit{{$grade->id}}"
                                        title="{{trans('trans_school.Edit')}}"><i class="fa fa-edit"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#delete{{$grade->id}}"
                                        title="{{trans('trans_school.Delete')}}"><i
                                            class="fa fa-trash"></i></button>
                                </td>
                            </tr>




                    <!-- edit_modal_Grade -->
                    <div class="modal fade" id="edit{{$grade->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                        id="exampleModalLabel">
                                        {{trans('trans_school.Edit_Trans')}}
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <!-- add_form -->
                                    <form action="{{route('Grade.update' , 'test')}}" method="post">
                                        {{ method_field('patch') }}
                                        @csrf
                                        <div class="row">
                                            <div class="col">
                                                <label for="Name"
                                                    class="mr-sm-2">{{trans('trans_school.Name_Grade_Ar')}}
                                                    :</label>
                                                <input id="Name" type="text" name="name_ar"
                                                    class="form-control"
                                                    value="{{$grade->getTranslation('name', 'ar')}}"
                                                    required>
                                                <input id="id" type="hidden" name="id" class="form-control"
                                                    value="{{$grade->id}}">
                                            </div>
                                            <div class="col">
                                                <label for="Name_en"
                                                    class="mr-sm-2">{{trans('trans_school.Name_Grade_En')}}
                                                    :</label>
                                                <input type="text" class="form-control"
                                                    value="{{$grade->getTranslation('name', 'en')}}"
                                                    name="name_en" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label
                                                for="exampleFormControlTextarea1">{{trans('trans_school.Notes')}}
                                                :</label>
                                            <textarea class="form-control" name="note"
                                                id="exampleFormControlTextarea1"
                                                rows="3">{{$grade->notes}}</textarea>
                                        </div>
                                        <br><br>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">{{trans('trans_school.Close')}}</button>
                                            <button type="submit"
                                                class="btn btn-success">{{trans('trans_school.Submit')}}</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- delete_modal_Grade -->
                    <div class="modal fade" id="delete{{$grade->id}}" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                        id="exampleModalLabel">
                                        {{trans('trans_school.delete_grade')}}
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('Grade.destroy' , 'test')}}" method="post">
                                        {{ method_field('Delete') }}
                                        @csrf
                                        <span >{{trans('trans_school.Are_you_sure_to_delete_the_process')}}</span>
                                        
                                        <input id="id" type="hidden" name="id" class="form-control"
                                            value="{{$grade->id}}">

                                        <input type="text" class="form-control mt-3" value="{{$grade->name}}" readonly>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">{{trans('trans_school.Close')}}</button>
                                            <button type="submit"
                                                class="btn btn-danger">{{trans('trans_school.Submit')}}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach

                                        {{-- add model grade --}}
                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                                                        {{ trans('Trans_school.add_Grade') }}
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- add_form -->
                                                    <form action="{{route('Grade.store')}}" method="POST">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="Name" class="mr-sm-2">{{ trans('trans_school.Name_Grade_Ar') }}
                                                                    :</label>
                                                                <input id="Name" type="text" name="name_ar" class="form-control" required>
                                                            </div>
                                                            <div class="col">
                                                                <label for="Name_en" class="mr-sm-2">{{ trans('trans_school.Name_Grade_En') }}
                                                                    :</label>
                                                                <input type="text" class="form-control" name="name_en" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleFormControlTextarea1">{{ trans('trans_school.Notes') }}
                                                                :</label>
                                                            <textarea class="form-control" name="Notes" id="exampleFormControlTextarea1"
                                                                rows="3"></textarea>
                                                        </div>
                                                        <br><br>
                                                
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">{{ trans('trans_school.Close') }}</button>
                                                            <button type="submit" class="btn btn-success">{{ trans('trans_school.Submit') }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                </tbody>
                </table>
            </div>
        </div>
      </div>   
    </div>
</div> 
<!-- row closed -->
@endsection
@section('js')
    @toastr_js
    @toastr_render
@endsection

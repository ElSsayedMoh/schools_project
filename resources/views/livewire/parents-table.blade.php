<button onclick="parent_add()" class="btn btn-success btn-sm btn-lg pull-right" wire:click="go_to_add_parent"
    type="button">{{ trans('trans_school.add_parent') }}</button><br><br>

<div class="table-responsive">
    <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
           style="text-align: center">
        <thead>
        <tr class="table-success">
            <th>#</th>
            <th>{{ trans('trans_school.Email') }}</th>
            <th>{{ trans('trans_school.Name_Father') }}</th>
            <th>{{ trans('trans_school.National_Number') }}</th>
            <th>{{ trans('trans_school.Passport_ID') }}</th>
            <th>{{ trans('trans_school.Phone') }}</th>
            <th>{{ trans('trans_school.Job') }}</th>
            <th>{{ trans('trans_school.Processes') }}</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 0; ?>
        @foreach ($Parents as $parent)
            <tr>
                <?php $i++; ?>
                <td>{{ $i }}</td>
                <td>{{ $parent->email }}</td>
                <td>{{ $parent->name_father }}</td>
                <td>{{ $parent->national_id_father }}</td>
                <td>{{ $parent->passport_id_father }}</td>
                <td>{{ $parent->phone_father }}</td>
                <td>{{ $parent->job_father }}</td>
                <td>
                    <button onclick="parent_edit()" wire:click="edit({{ $parent->id }})" title="{{ trans('trans_school.Edit') }}"
                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>

                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{$parent->id}}" 
                            title="{{ trans('trans_school.Delete') }}"><i class="fa fa-trash"></i></button>

                            {{-- <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                            data-target="#delete{{$grade->id}}"
                            title="{{trans('trans_school.Delete')}}"><i
                                class="fa fa-trash"></i></button> --}}

                    <!-- delete_modal_Grade -->
                    <div class="modal fade" id="delete{{$parent->id}}" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                        id="exampleModalLabel">
                                        {{trans('trans_school.Delete')}}
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                        <span class="float-left" style="font-size: initial;" >{{trans('trans_school.Are_you_sure_to_delete_the_process')}}</span><br><br>
                                        
                                        <input id="id" type="hidden" name="id" class="form-control"
                                            value="{{$parent->id}}">
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">{{trans('trans_school.Close')}}</button>
                                            <button type="button" wire:click="delete({{ $parent->id }})"
                                                class="btn btn-danger" data-dismiss="modal">{{trans('trans_school.Submit')}}</button>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </td>
            </tr>
        @endforeach
    </table>
</div>
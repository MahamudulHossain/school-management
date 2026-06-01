@extends('layouts.al4_main')
@section('settings_mo','menu-open')
@section('settings','active')
@section('manage_shift','active')
@section('title','Edit Shift')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Edit {{ $title }}</a>
    </li>
@endsection
@push('css')

@endpush
@section('maincontent')
    <div class="row justify-content-center ">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit {{ $title }}</h3>
                </div>
                <div style="padding: 0 15px">
                    <div class="alert alert-danger mt-3" role="alert" >
                        ** Period Number must be 0 for Assembly and Tiffin.
                    </div>
                </div>
                <form action="{{ route('shift.update', 1) }}" method="POST" id="saveForm">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="shift_id" value="{{ $shift_id }}">
                    <div class="card-body">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Period Number</th>
                                    <th>Type</th>
                                    <th>Title</th>
                                    <th>Start At</th>
                                    <th>End At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $datum)
                                    <tr>
                                        <td>
                                            <select name="period_number[]" id="period_number" class="form-control">
                                                @foreach ($perido_number as $pn)
                                                    <option value="{{ $pn }}" {{ $pn == $datum->period_number ? 'selected':'' }}>{{ $pn }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="type[]" id="type" class="form-control">
                                                @foreach ($types as $type)
                                                    <option value="{{ $type }}" {{ $type == $datum->type ? 'selected':'' }}>{{ $type }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="title[]" class="form-control" value="{{ $datum->title }}">
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="time" name="start_time[]" class="form-control" value="{{ $datum->start_time }}">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button">
                                                        <i class="fa fa-clock-o"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="time" name="end_time[]" class="form-control" value="{{ $datum->end_time }}">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button">
                                                        <i class="fa fa-clock-o"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end mt-2">
                            <button type="button" class="btn btn-sm btn-success" id="addMore">
                                <i class="fa fa-plus" aria-hidden="true"></i>Add New</button>
                        </div>
                    </div>


                    <div class="d-flex justify-content-end card-footer">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-primary"><i
                                    class="fa fa-arrow-left"
                                    aria-hidden="true"></i>{{ __('all_settings.Back') }}</a>
                        <button type="submit" class="btn btn-success float-right" id="saveButton" style="margin-left:5px"><i
                                    class="fa fa-save"
                                    aria-hidden="true"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
{{--prevent multiple form submits (Jquery needed)--}}
<script>
    $('#saveForm').submit(function () {
        $("#saveButton", this)
            .html("Please Wait...")
            .attr('disabled', 'disabled');
        return true;
    });
</script>
<script>
    // Add more rows
    $('#addMore').click(function () {
        var newRow = `<tr>
                <td>
                    <select name="period_number[]" id="period_number" class="form-control" required>
                        @foreach ($perido_number as $pn)
                            <option value="{{ $pn }}">{{ $pn }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="type[]" id="type" class="form-control" required>
                        @foreach ($types as $type)
                            <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="text" name="title[]" class="form-control" value="" required>
                </td>
                <td>
                    <div class="input-group">
                        <input type="time" name="start_time[]" class="form-control" value="" required>
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <i class="fa fa-clock-o"></i>
                            </button>
                        </span>
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <input type="time" name="end_time[]" class="form-control" value="" required>
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <i class="fa fa-clock-o"></i>
                            </button>
                        </span>
                    </div>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm removeRow">
                        <i class="fa fa-minus" aria-hidden="true"></i>
                    </button>
                </td>
            </tr>`;
        $('table tbody').append(newRow);
    });

    // Remove row
    $(document).on('click', '.removeRow', function () {
        $(this).closest('tr').remove();
    });
</script>
@endpush


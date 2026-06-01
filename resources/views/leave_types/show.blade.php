@extends('layouts.al4_main')
@section('leave_mo','menu-open')
@section('leave','active')
@section('list_leavetype','active')
@section('title','Leave Type')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('leave-type')}}" class="nav-link">Leave Type</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Show Leave Type</a>
    </li>
@endsection
@push('css')
@endpush
@section('maincontent')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Show Leave Type</h3>
        </div>

        <div class="card-body">
            <div class="mb-2">
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            Leave Type Name
                        </th>
                        <td>
                            {{ $leave_type->leave_type_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Comments
                        </th>
                        <td>
                            {{ $leave_type->comments }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer">
            <a href="{{ url()->previous() }}" class="btn btn-outline-primary btn-sm"><i
                        class="fa fa-arrow-left"
                        aria-hidden="true"></i>{{ __('all_settings.Back') }}</a>
            {{--                    @can('geo_location-access')--}}
            <form method="POST" action="{{ url('leave-type/' . $leave_type->id) }}" style="display:inline">
                @csrf
                @method('DELETE')

                <button type="submit"
                    class="btn btn-danger btn-sm"
                    title="Delete"
                    onclick="return confirm('Confirm delete?')">
                    <span class="far fa-trash-alt" aria-hidden="true" title="Delete"></span>
                </button>
            </form>
            <a href="{{ url('leave-type/' . $leave_type->id . '/edit') }}"
               class="btn btn-info btn-sm fa-pull-right" title="Edit" style="margin-right: 10px"><span
                        class="far fa-edit"
                        aria-hidden="true"></span></a>

        </div>
    </div>

@endsection

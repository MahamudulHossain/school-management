@extends('layouts.al4_main')
@section('attendant_mo','menu-open')
@section('attendant','active')
@section('manage_attendant','active')
@section('title','Attendant')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Show Attendant</a>
    </li>
@endsection
@push('css')

@endpush
@section('maincontent')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Show Attendant Info</h3>
        </div>

        <div class="card-body">
            <div class="mb-2">
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            Name
                        </th>
                        <td>
                            {{ $data->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Gender
                        </th>
                        <td>
                            {{ $data->gender }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Contact No
                        </th>
                        <td>
                            {{ $data->contact_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Email
                        </th>
                        <td>
                            {{ $data->email ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            NID No
                        </th>
                        <td>
                            {{ $data->nid  ?? ''}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Address
                        </th>
                        <td>
                            {{ $data->address ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Image</th>
                        <td>
                            <img src="{!! asset( 'storage/image_profile/'. $data->image. '?'. 'time='. time()) !!}" class="profile-user-img img-fluid img-circle" alt="Attendant Image" style="width: 200px; height: 150px;">
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
            <form method="POST" action="{{ url('data/' . $data->id) }}" style="display:inline">
                @csrf
                @method('DELETE')

                <button type="submit"
                    class="btn btn-danger btn-sm"
                    title="Delete"
                    onclick="return confirm('Confirm delete?')">
                    <span class="far fa-trash-alt" aria-hidden="true" title="Delete"></span>
                </button>
            </form>
            <a href="{{ url('attendant/' . $data->id . '/edit') }}"
               class="btn btn-info btn-sm fa-pull-right" title="Edit" style="margin-right: 10px"><span
                        class="far fa-edit"
                        aria-hidden="true"></span></a>

        </div>
    </div>

@endsection

@push('js')

@endpush

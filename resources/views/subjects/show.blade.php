@extends('layouts.al4_main')
@section('academic_mo','menu-open')
@section('academic','active')
@section('subject_mo','menu-open')
@section('subject','active')
@section('manage_subject','active')
@section('title','Subject')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('subject')}}" class="nav-link">Subject</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Show Subject</a>
    </li>
@endsection
@push('css')
@endpush
@section('maincontent')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Show Subject</h3>
        </div>

        <div class="card-body">
            <div class="mb-2">
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            Subject Name
                        </th>
                        <td>
                            {{ $subject->subject_name }}
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
            <form method="POST" action="{{ url('subject/' . $subject->id) }}" style="display:inline">
                @csrf
                @method('DELETE')

                <button type="submit"
                    class="btn btn-danger btn-sm"
                    title="Delete"
                    onclick="return confirm('Confirm delete?')">
                    <span class="far fa-trash-alt" aria-hidden="true" title="Delete"></span>
                </button>
            </form>
            <a href="{{ url('subject/' . $subject->id . '/edit') }}"
               class="btn btn-info btn-sm fa-pull-right" title="Edit" style="margin-right: 10px"><span
                        class="far fa-edit"
                        aria-hidden="true"></span></a>

        </div>
    </div>

@endsection
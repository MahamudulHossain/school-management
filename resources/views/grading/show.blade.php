@extends('layouts.al4_main')
@section('exam_mo','menu-open')
@section('exam','active')
@section('grading','active')
@section('title','Show Grading')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('grading')}}" class="nav-link">Manage Grading</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Show Grading</a>
    </li>
@endsection
@push('css')
@endpush
@section('maincontent')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Show Grading</h3>
        </div>

        <div class="card-body" id="print_this0">
            <div class="mb-2">
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            Letter Grade
                        </th>
                        <td>
                            {{ $grading->letter_grade }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Grade Point
                        </th>
                        <td>
                            {{ $grading->grade_point }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Marks Interval
                        </th>
                        <td>
                            {{ $grading->starting_marks.' to '.$grading->ending_marks }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Remarks
                        </th>
                        <td>
                            {{ $grading->remarks }}
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
            <form method="POST" action="{{ url('grading/' . $grading->id) }}" style="display:inline">
                @csrf
                @method('DELETE')

                <button type="submit"
                    class="btn btn-danger btn-sm fa-pull-right"
                    title="Delete"
                    onclick="return confirm('Confirm delete?')">
                    <span class="far fa-trash-alt" aria-hidden="true" title="Delete"></span>
                </button>
            </form>
            <a href="{{ url('grading/' . $grading->id . '/edit') }}"
               class="btn btn-info btn-sm fa-pull-right" title="Edit" style="margin-right: 10px"><span
                        class="far fa-edit"
                        aria-hidden="true"></span></a>

        </div>
    </div>

@endsection

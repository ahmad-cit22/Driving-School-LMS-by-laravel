@extends('layouts.admin')
@section('content')
    {{-- overall report --}}
    <div class="row mb-5">
        <div class="col">
            <div class="table-responsive">
                <table class="fs-6 table table-striped table-bordered">
                    <tr>
                        <th class="text-center">Instructor Name: {{ $instructor->name }}</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col">

        </div>
    </div>
    <div class="row">
        <div class="col text-center">
            <a href="{{ route('admin.enroll.index') }}" class=""><button class="btn btn-info text-white" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="In order to give attendance or generate certificate">Browse Enrollments</button></a>
        </div>
    </div>
@endsection
@section('script')
@endsection

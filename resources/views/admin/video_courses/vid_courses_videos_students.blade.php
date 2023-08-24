@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <table class="datatable table-striped table-bordered table text-center align-middle">
                    <thead>
                        <tr>
                            <th width='10%'>Class No.</th>
                            <th>Title</th>
                            <th>Video</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($videos as $video)
                            <tr>
                                <td>{{ $video->class_no }}</td>
                                <td>{{ $video->video_title }}</td>
                                <td> <a class="fw-bold site-text-primary text-decoration-underline" href="{{ $video->video_link }}" target="_blank" rel="">Click to Watch</a> </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11">No Videos Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    @if ($isOnline)
        <div class="row">
            <div class="col-6 col-md-2 mx-auto">
                <a href="{{ route('admin.online_course.certificate.view', $enroll_id) }}" class="btn site-bg-primary text-white" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="You can get certificate when you have watched all the classes.">Get Certificate</a>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-6 col-md-2 mx-auto">
                <a href="{{ route('admin.index') }}" class="btn site-bg-primary text-white">Go to Dashboard</a>
            </div>
        </div>
    @endif
@endsection

@section('style')
@endsection

@section('script')
@endsection

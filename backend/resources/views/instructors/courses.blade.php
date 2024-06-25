<!-- resources/views/instructors/courses.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
<h1>Manage Courses for {{ $instructor->FirstName ?? '' }} {{ $instructor->MiddleName ?? '' }} {{ $instructor->LastName }}</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="courses">Courses</label>
                <ul class="list-group">
                    @foreach($courses as $course)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $course->CourseID }} - {{ $course->Description }}</span>
                        <div>
                            @if(in_array($course->CourseID, $addedCourseIDs))
                            <form action="{{ route('instructors.courses.drop', [$instructor->InstructorID, $course->CourseID]) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-danger">Drop</button>
                            </form>
                            @else
                            <form action="{{ route('instructors.courses.add', [$instructor->InstructorID, $course->CourseID]) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-success">Add</button>
                            </form>
                            @endif
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="added_courses">Added Courses</label>
                <select id="added_courses" name="added_courses[]" class="form-control" multiple>
                    @foreach($addedCourses as $addedCourse)
                    <option value="{{ $addedCourse->CourseID }}">{{ $addedCourse->CourseID }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
@endsection

<?php

// app/Http/Controllers/InstructorController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instructor;
use App\Models\CourseManagement;
use Illuminate\Support\Facades\DB;

class CourseInstructor extends Controller
{
    public function index()
    {
        $instructors = Instructor::all();
        return view('instructors.index', compact('instructors'));
    }

    public function edit($id)
    {
        $instructor = Instructor::findOrFail($id);
        return view('instructors.edit', compact('instructor'));
    }

    public function update(Request $request, $id)
    {
        $instructor = Instructor::findOrFail($id);
        $instructor->update($request->all());
        return redirect()->route('instructors.index');
    }

        // app/Http/Controllers/InstructorController.php

public function showCourses($id)
{
    $instructor = Instructor::findOrFail($id);

    // Fetch added courses for the instructor
    $addedCourses = DB::table('course_instructor')
                     ->where('InstructorID', $id)
                     ->where('Drop', 0)
                     ->select('CourseID')
                     ->get();

    $addedCourseIDs = $addedCourses->pluck('CourseID')->toArray();  // Convert to array of IDs
    $courses = CourseManagement::all();

    return view('instructors.courses', compact('instructor', 'courses', 'addedCourses', 'addedCourseIDs'));
}

public function addCourse($instructorId, $courseId)
{
    $instructor = Instructor::findOrFail($instructorId);

    // Attach the course to the instructor
    $instructor->courses()->attach($courseId);

    return redirect()->route('instructors.courses', $instructor->InstructorID)
                     ->with('success', 'Course added successfully.');
}
public function dropCourse($instructorId, $courseId)
{
    $instructor = Instructor::findOrFail($instructorId);

    // Find the course_instructor record and mark it as deleted
    $courseInstructor = DB::table('course_instructor')
                         ->where('InstructorID', $instructorId)
                         ->where('CourseID', $courseId)
                         ->update(['Drop' => 1]);

    return redirect()->route('instructors.courses', $instructor->InstructorID)
                     ->with('success', 'Course dropped successfully.');
}

}

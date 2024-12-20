<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Response;

class StudentController extends Controller
{
    public function index()
    {
        // Mengambil semua data students
        $students = Student::all();

        // Mengembalikan response dengan format yang sesuai
        return response()->json([
            'success' => true,
            'data' => $students
        ], 200);
    }

    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'nim' => 'required|integer|unique:students',
            'name' => 'required|string',
            'ukt_paid' => 'nullable|boolean',
        ]);

        // Simpan data
        $student = Student::create($request->all());

        // Mengembalikan response dengan status 201 (created)
        return response()->json([
            'success' => true,
            'message' => 'Student created successfully',
            'data' => $student
        ], 200);
    }

    public function show($nim)
    {
        // Cari student berdasarkan nim
        $student = Student::where('nim', $nim)->first();

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found'
            ], 404);
        }

        // Mengembalikan data satu student
        return response()->json([
            'success' => true,
            'data' => $student
        ], 200);
    }

    public function update(Request $request, $nim)
    {
        // Validasi data
        $request->validate([
            'name' => 'nullable|string',
            'ukt_paid' => 'nullable|boolean',
        ]);

        // Cari student berdasarkan nim
        $student = Student::where('nim', $nim)->first();

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found'
            ], 404);
        }

        // Update data student
        $student->update($request->all());

        // Mengembalikan response setelah update
        return response()->json([
            'success' => true,
            'message' => 'Student updated successfully',
            'data' => $student
        ], 200);
    }

    public function destroy($nim)
    {
        // Cari student berdasarkan nim
        $student = Student::where('nim', $nim)->first();

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found'
            ], 404);
        }

        // Hapus data student
        $student->delete();

        // Mengembalikan response setelah delete
        return response()->json([
            'success' => true,
            'message' => 'Student deleted successfully'
        ], 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Crypt;
use Illuminate\Http\Request;
use Log;
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
        try {
            Log::info('Searching for student with NIM: ' . $nim);

            $foundStudent = Student::all()->first(function ($student) use ($nim) {
                return $student->nim === $nim;
            });

            if (!$foundStudent) {
                Log::warning('Student not found with NIM: ' . $nim);
                return response()->json([
                    'success' => false,
                    'message' => 'Student not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $foundStudent
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error in show method: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error processing request'
            ], 500);
        }
    }

    public function update(Request $request, $nim)
    {
        try {
            // Validasi data
            $request->validate([
                'name' => 'nullable|string',
                'ukt_paid' => 'nullable|boolean',
            ]);

            $foundStudent = Student::all()->first(function ($student) use ($nim) {
                return $student->nim === $nim;
            });

            if (!$foundStudent) {
                Log::warning('Student not found with NIM: ' . $nim);
                return response()->json([
                    'success' => false,
                    'message' => 'Student not found'
                ], 404);
            }

            // Update data student
            $foundStudent->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Student updated successfully',
                'data' => $foundStudent
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error in update method: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($nim)
    {
        try {
            $foundStudent = Student::all()->first(function ($student) use ($nim) {
                return $student->nim === $nim;
            });

            if (!$foundStudent) {
                Log::warning('Student not found with NIM: ' . $nim);
                return response()->json([
                    'success' => false,
                    'message' => 'Student not found'
                ], 404);
            }

            // Hapus data student
            $foundStudent->delete();

            return response()->json([
                'success' => true,
                'message' => 'Student deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error in destroy method: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error processing request'
            ], 500);
        }
    }
}

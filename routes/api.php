<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Employee;
use App\Models\Department;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// 1. Criar, Listar, Buscar por Id, Atualizar, Deletar Funcionários
Route::post('/employees', function (Request $request) {
    $employee = new Employee();
    $employee->name = $request->input('name');
    $employee->email = $request->input('email');
    $employee->phone = $request->input('phone');
    $employee->department_id = $request->input('department_id');
    $employee->save();
    return response()->json([
        'message' => 'Funcionário criado com sucesso!',
        'employee' => $employee
    ], 201);
});

Route::get('/employees', function () {
    $employees = Employee::all();
    return response()->json($employees);
});

Route::get('/employees/{id}', function ($id) {
    $employee = Employee::find($id);
    if (!$employee) {
        return response()->json(['message' => 'Funcionário não encontrado!'], 404);
    }
    return response()->json($employee);
});

Route::patch('/employees/{id}', function (Request $request, $id) {
    $employee = Employee::find($id);
    if (!$employee) {
        return response()->json(['message' => 'Funcionário não encontrado!'], 404);
    }
    $employee->name = $request->input('name');
    $employee->email = $request->input('email');
    $employee->phone = $request->input('phone');
    $employee->department_id = $request->input('department_id');
    $employee->save();
    return response()->json([
        'message' => 'Funcionário atualizado com sucesso!',
        'employee' => $employee
    ]);
});

Route::delete('/employees/{id}', function ($id) {
    $employee = Employee::find($id);
    if (!$employee) {
        return response()->json(['message' => 'Funcionário não encontrado!'], 404);
    }
    $employee->delete();
    return response()->json(['message' => 'Funcionário deletado com sucesso!']);
});

// 2. Criar, Listar, Buscar por Id, Atualizar, Deletar Departamentos

Route::post('/departments', function (Request $request) {
    $department = new Department();
    $department->name = $request->input('name');
    $department->description = $request->input('description');
    $department->save();
    return response()->json([
        'message' => 'Departamento criado com sucesso!',
        'department' => $department
    ], 201);
});

Route::get('/departments', function () {
    $departments = Department::all();
    return response()->json($departments);
});

Route::get('/departments/{id}', function ($id) {
    $department = Department::find($id);
    if (!$department) {
        return response()->json(['message' => 'Departamento não encontrado!'], 404);
    }
    return response()->json($department);
});

Route::patch('/departments/{id}', function (Request $request, $id) {
    $department = Department::find($id);
    if (!$department) {
        return response()->json(['message' => 'Departamento não encontrado!'], 404);
    }
    $department->name = $request->input('name');
    $department->description = $request->input('description');

    $department->save();
    return response()->json([
        'message' => 'Departamento atualizado com sucesso!',
        'department' => $department
    ]);
});

Route::delete('/departments/{id}', function ($id) {
    $department = Department::find($id);
    if (!$department) {
        return response()->json(['message' => 'Departamento não encontrado!'], 404);
    }
    $department->delete();
    return response()->json(['message' => 'Departamento deletado com sucesso!']);
});

//3. Listar Funcionários com seus Departamentos
Route::get('/employees-with-departments', function () {
    $employees = Employee::with('department')->get();
    return response()->json($employees);
});

// 4. Listar Departamentos com seus Funcionários
Route::get('/departments-with-employees', function () {
    $departments = Department::with('employees')->get();
    return response()->json($departments);
});

// 5. Buscar Departamento de um Funcionário
Route::get('/employees/{id}/department', function ($id) {
    $employee = Employee::find($id);
    if (!$employee) {
        return response()->json(['message' => 'Funcionário não encontrado!'], 404);
    }
    $department = $employee->department;
    if (!$department) {
        return response()->json(['message' => 'Departamento não encontrado!'], 404);
    }
    return response()->json($department);
});

//6. Buscar Funcionários de um Departamento
Route::get('/departments/{id}/employees', function ($id) {
    $department = Department::find($id);
    if (!$department) {
        return response()->json(['message' => 'Departamento não encontrado!'], 404);
    }
    $employees = $department->employees;
    return response()->json($employees);
});
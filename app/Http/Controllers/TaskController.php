<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        try {
            $tasks = Task::all();
            
            return response()->json($tasks);

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Resource not found'], 404);
        } catch (ValidationException $e) {
            return response()->json(['errors' => validator()->errors()], 422);
        } catch (QueryException $e) {
            return response()->json(['error' => "$e"], 500);
        } 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return ['teste' => 'For front-end'];
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'description' => 'required|string',
                'attachments' => 'nullable',
                'user_id' => 'required',
            ]);
    
            if ($validator->fails()) {
                return redirect()
                    ->back()    // Redirects where the request come (to front-end)
                    ->withErrors($validator)    // To redirect with all validation errors
                    ->withInput();  // To not lose data filled previously (On front-end form)
            }
    
            Task::create($validator->validated());

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Resource not found'], 404);
        } catch (ValidationException $e) {
            return response()->json(['errors' => validator()->errors()], 422);
        } catch (QueryException $e) {
            return response()->json(['error' => 'DB error'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $task = Task::findOrFail($id);

            return response()->json($task);

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Resource not found'], 404);
        } catch (ValidationException $e) {
            return response()->json(['errors' => validator()->errors()], 422);
        } catch (QueryException $e) {
            return response()->json(['error' => 'DB error'], 500);
        } 
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        try {
            $task = Task::findOrFail($id);

            $validatedData = $request->validate([
                'title' => 'string',
                'description' => 'string',
            ]);

            $task->update($validatedData);

            return response()->json($task);

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Resource not found'], 404);
        } catch (ValidationException $e) {
            return response()->json(['errors' => validator()->errors()], 422);
        } catch (QueryException $e) {
            return response()->json(['error' => 'DB error'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();

            return response()->json(['message' => 'Task deleted']);

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Resource not found'], 404);
        } catch (ValidationException $e) {
            return response()->json(['errors' => validator()->errors()], 422);
        } catch (QueryException $e) {
            return response()->json(['error' => 'DB error'], 500);
        }
    }

    /**
     * Mark the specific resource as completed
     */
    public function complete($id)
    {
        try {
            // Código normal da ação
            $task = Task::findOrFail($id);
            $task->update([
                'completed' => true,
                'completed_at' => Carbon::now(),
            ]);

            return response()->json($task);

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Resource not found'], 404);
        } catch (ValidationException $e) {
            return response()->json(['errors' => validator()->errors()], 422);
        } catch (QueryException $e) {
            return response()->json(['error' => 'DB error'], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()
                     ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
    
            User::create($validator->validated());

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Resource not found'], 404);
        } catch (ValidationException $e) {
            return response()->json(['errors' => validator()->errors()], 422);
        } catch (QueryException $e) {
            return response()->json(['error' => 'DB error'], 500);
        } 
    }
}

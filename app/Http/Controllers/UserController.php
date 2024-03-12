<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\MessageResource;
use App\Http\Traits\GeneralTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function login(LoginRequest $request)
    {
        try {

            $user = User::where("email", $request->email)->firstOrFail();

            return (
            (!Hash::check($request->password,$user->password))? $this->unAuthorizedResponse() :
                $this->apiResponse($user->createToken("token")->plainTextToken)
            );

        }catch (\Exception $e){
            return $this->requiredField($e->getMessage());
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request)
    {
        try {

            $data = User::create(
                [
                    "uuid" => Str::uuid(),
                    "name" => $request->name,
                    "email" => $request->email,
                    "password" => Hash::make($request->password)
                ]
            );

            return ($data)? $this->apiResponse(
                MessageResource::make("user currectly registered")
            ) : $this->requiredField(
                MessageResource::make("can't register user")
            );

        }catch (\Exception $e){
            return $this->requiredField($e->getMessage());
        }
    }

    public function logout()
    {
        try {

            $data = auth("sanctum")->user()->tokens()->delete();

            return ($data)? $this->apiResponse(
                MessageResource::make("logout done")
            ) : $this->requiredField(
                MessageResource::make("can't logout")
            );

        }catch (\Exception $e){
            return $this->requiredField($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}

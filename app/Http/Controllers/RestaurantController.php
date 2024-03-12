<?php

namespace App\Http\Controllers;

use App\Http\Resources\RestaurantResource;
use App\Http\Traits\GeneralTrait;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            return $this->apiResponse(RestaurantResource::collection(Restaurant::all()));

        }catch (\Exception $e){
            return $this->requiredField($e->getMessage());
        }
    }
    public function search(Request $request)
    {
        try {

            if ($request->name)
                return $this->apiResponse(
                    RestaurantResource::make(Restaurant::where("name", $request->name)->first())
                );
            else if ($request->cuisine && $request->address)
                return $this->apiResponse(
                    RestaurantResource::collection(Restaurant::where("cuisine_type", $request->cuisine)->where("address", $request->address)->get())
                );
            else if ($request->cuisine)
                return $this->apiResponse(
                    RestaurantResource::collection(Restaurant::where("cuisine_type", $request->cuisine)->get())
                );
            else if ($request->address)
                return $this->apiResponse(
                    RestaurantResource::collection(Restaurant::where("address", $request->address)->get())
                );
            else
                return $this->requiredField("you must give me something to search with");

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function show(Restaurant $restaurant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Restaurant $restaurant)
    {
        //
    }
}

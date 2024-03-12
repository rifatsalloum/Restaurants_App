<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRatingRequest;
use App\Http\Resources\MessageResource;
use App\Http\Traits\GeneralTrait;
use App\Models\Rating;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RatingController extends Controller
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRatingRequest $request)
    {
        try {

            $restaurant = Restaurant::where("uuid", $request->restaurant_uuid)->firstOrFail();
            $user = auth("sanctum")->user();
            $rating = Rating::where("user_id",$user->id)->where("restaurant_id",$restaurant->id)->first();

            if($rating)
                return $this->update($request,$rating);

            Rating::create([
                "uuid" => Str::uuid(),
                "restaurant_id" => $restaurant->id,
                "user_id" => $user->id,
                "rate" => $request->rate,
                "comment" => $request->comment
            ]);

            return $this->apiResponse(MessageResource::make("rating added correctly"));

        }catch (\Exception $e){
            return $this->requiredField($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function show(Rating $rating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rating $rating)
    {
        try {

            $rating->rate = $request->rate;
            $rating->comment = $request->comment;
            $rating->save();

            return $this->apiResponse(MessageResource::make("The Rate Updated Correctly"));

        }catch (\Exception $e){
            return $this->requiredField($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rating $rating)
    {
        //
    }
}

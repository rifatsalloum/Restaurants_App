<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyOrderRequest;
use App\Http\Requests\ReorderRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\MessageResource;
use App\Http\Resources\OrderResource;
use App\Http\Traits\GeneralTrait;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Restaurant;
use App\Notifications\SendEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class OrderController extends Controller
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

            return $this->apiResponse(
                OrderResource::collection(Order::where("user_id", auth("sanctum")->user()->id)->get())
            );

        }catch (\Exception $e){
            return $this->requiredField($e->getMessage());
        }
    }
    public function newPricesOrder(Request $request)
    {
        try {

            $request["new_price"] = true;
            return $this->apiResponse(
                OrderResource::make(Order::where("uuid", $request->order_uuid)->firstOrFail())
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
    public function store(StoreOrderRequest $request)
    {
        try {

            $restaurant_uuids = collect(array_keys($request->data));
            $menu_items = $this->buildMatrix($restaurant_uuids);

            if(!$menu_items)
                return $this->notFoundResponse("data not found");

            if(!$request->checkInMenu($restaurant_uuids,$menu_items))
                return $this->requiredField("your order is not good");

            $user = auth("sanctum")->user();

            $order = Order::create([
                "uuid" => Str::uuid(),
                "user_id" => $user->id,
                "type" => $request->type,
            ]);

            $restaurant_uuids->each(function ($uuid) use ($menu_items, $request, $order) {
                foreach ($request->data[$uuid] as $item_uuid => $number)
                    OrderItem::create([
                        "uuid" => Str::uuid(),
                        "order_id" => $order->id,
                        "restaurant_item_id" => $menu_items[$uuid][$item_uuid][0],
                        "price" => $menu_items[$uuid][$item_uuid][1],
                        "number" => $number
                    ]);
            });

            $user->notify(new SendEmailNotification());

            return $this->apiResponse(MessageResource::make("order added correctly"));

        }catch (\Exception $e){
            return $this->requiredField($e->getMessage());
        }
    }
    private function buildMatrix($data)
    {
        try {

            return $data->mapWithKeys(function ($restaurant_uuid) {

                $restaurant = Restaurant::where("uuid", $restaurant_uuid)->firstOrFail();

                return [
                    $restaurant_uuid => $restaurant->menuItems->mapWithKeys(
                        fn($item) => [$item->uuid => [$item->pivot->id, $item->pivot->price]]
                    )->toArray()
                ];

            })->toArray();

        }catch (\Exception $e){
            return null;
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(StoreOrderRequest $request)
    {
        try {

            $order = Order::where("uuid",$request->order_uuid)->firstOrFail();

            $restaurant_uuids = collect(array_keys($request->data));
            $menu_items = $this->buildMatrix($restaurant_uuids);

            if(!$menu_items)
                return $this->notFoundResponse("data not found");

            if(!$request->checkInMenu($restaurant_uuids,$menu_items))
                return $this->requiredField("your order is not good");

            $order->items()->delete();

            $order->status = "not_taked";
            $order->save();

            $restaurant_uuids->each(function ($uuid) use ($menu_items, $request, $order) {
                foreach ($request->data[$uuid] as $item_uuid => $number)
                    OrderItem::create([
                        "uuid" => Str::uuid(),
                        "order_id" => $order->id,
                        "restaurant_item_id" => $menu_items[$uuid][$item_uuid][0],
                        "price" => $menu_items[$uuid][$item_uuid][1],
                        "number" => $number
                    ]);
            });

            auth("sanctum")->user()->notify(new SendEmailNotification());

            return $this->apiResponse(MessageResource::make("reorderation done"));

        }catch (\Exception $e){
            return $this->requiredField($e->getMessage());
        }
    }
    public function makeOrderTaked(UpdateOrderRequest $request)
    {
        try {

            $order = Order::where("uuid",$request->order_uuid)->firstOrFail();
            $order->status = "taked";
            $order->save();

            return $this->apiResponse(MessageResource::make("update done"));

        }catch (\Exception $e){
            return $this->requiredField($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyOrderRequest $request)
    {
        try {

            $order = Order::where("uuid", $request->order_uuid)->firstOrFail();

            $order->items()->delete();

            $order->delete();

            return $this->apiResponse(MessageResource::make("deletion done"));

        }catch (\Exception $e){
            return $this->requiredField($e->getMessage());
        }
    }
}

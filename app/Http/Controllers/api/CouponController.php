<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $coupons = Coupon::where('user_id', $request->user_id)->orderBy("created_at", "DESC")->get();

        $coupons->each(function($coupon) {
            $coupon->is_used_in_courses = $coupon->isPromoCodeUsed();
        });

        return response()->json([
            "status" => "success", 
            "promocodes" => $coupons
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'promo_title'       => 'required|string',
            'date'              => 'required|date',
            'promo_code'        => 'required|string|size:6',
        ];
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                "status" => "error", 
                "message" => $validator->errors()->first()
            ], 400);
        }

        if( $request->promo_id ) {
            // $coupon = Coupon::find($request->promo_id)->update([
            //     'promo_title'   => $request->promo_title, 
            //     'date'          => $request->date, 
            //     'promo_code'    => $request->promo_code
            // ]);
        } else {
            $promo_code = $request->promo_code;

            $coupon = Coupon::create([
                'user_id'       => $request->user_id, 
                'promo_title'   => $request->promo_title, 
                'date'          => $request->date, 
                'promo_code'    => $promo_code
            ]);

            $course = Course::where('coupon', $promo_code)->first();

            if($course) {
                Transaction::create([
                    'admin_id'      => 0, 
                    'user_id'       => $request->user_id, 
                    'course_id'     => $course->id, 
                    'lecture_id'    => 0, 
                    'transaction_id'=> '', 
                    'type'          => "Promo Code", 
                    'title'         => $course->title, 
                    'content'       => 'You got this course using ' . $promo_code, 
                    'amount'        => 0, 
                    'date'          => date("Y/m/d, H:i", time()), 
                ]);
            }
        }

        return response()->json([
            "status" => "success", 
            "coupon" => $coupon
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $couponApi)
    {
        return response()->json([
            "status" => "success", 
            "coupon" => $couponApi
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        return response()->json([
            "status" => "success", 
            "coupon" => $coupon
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Coupon $couponApi)
    {
        // $course = Course::where('coupon', $couponApi->promo_code)->first();
        // Transaction::where(['user_id' => $request->user_id, 'course_id' => $course->id])->delete();
        // $couponApi->delete();

        return response()->json([
            "status" => "success", 
            "coupon" => $couponApi
        ], 200);
    }
}

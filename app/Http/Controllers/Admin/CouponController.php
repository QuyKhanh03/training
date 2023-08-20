<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    protected $coupon;

    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $coupons = $this->coupon->latest('id')->paginate(5);
        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           'name' => 'required|unique:coupons,name',
            'type' => 'required',
            'value' => 'required',
            'expery_date' => 'required|date|after_or_equal:today'
        ],
            [
                'name.required' => 'Tên mã giảm giá không được để trống',
                'name.unique' => 'Tên mã giảm giá đã tồn tại',
                'type.required' => 'Hình thức giảm giá không được để trống',
                'value.required' => 'Giá trị giảm giá không được để trống',
                'expery_date.required' => 'Ngày hết hạn không được để trống',
                'expery_date.date' => 'Ngày hết hạn không đúng định dạng',
                'expery_date.after_or_equal' => 'Ngày hết hạn phải lớn hơn hoặc bằng ngày hiện tại'

            ]
        );
        $dataCreate = $request->all();

        $this->coupon->create($dataCreate);
        return redirect()->route('coupons.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $coupon = $this->coupon->findOrFail($id);
        return view('admin.coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
           'name' => 'required|unique:coupons,name,'.$id,
            'type' => 'required',
            'value' => 'required',
            'expery_date' => 'required|date|after_or_equal:today'
        ],
            [
                'name.required' => 'Tên mã giảm giá không được để trống',
                'name.unique' => 'Tên mã giảm giá đã tồn tại',
                'type.required' => 'Hình thức giảm giá không được để trống',
                'value.required' => 'Giá trị giảm giá không được để trống',
                'expery_date.required' => 'Ngày hết hạn không được để trống',
                'expery_date.date' => 'Ngày hết hạn không đúng định dạng',
                'expery_date.after_or_equal' => 'Ngày hết hạn phải lớn hơn hoặc bằng ngày hiện tại'
            ]
        );
        $dataUpdate = $request->all();
        $this->coupon->findOrFail($id)->update($dataUpdate);
        return redirect()->route('coupons.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();
        return redirect()->route('coupons.index');
    }
}

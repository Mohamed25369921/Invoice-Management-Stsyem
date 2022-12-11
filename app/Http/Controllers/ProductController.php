<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Section;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        $sections = Section::all();
        return view('products.index',compact('products','sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        Product::create([
            'product_name' => $request->product_name,
            'section_id' => $request->section_id,
            'description' => $request->description,
        ]);
        return redirect()->back()->with(['success' => 'تم اضافة المنتج بنجاح'])->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $section_id = Section::where('section_name',$request->section_name)->first()->id;
        $this->validate($request,[
            'product_name' => 'required|unique:products,product_name,'.$request->id,
        ],[
            'product_name.required' => 'يرجى ادخال اسم المنتج',
            'product_name.unique' => 'اسم المنتج مسجل مسبقا',
        ]);
        $product = Product::findOrFail($request->id);
        $product->update([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $section_id,
        ]);
        return redirect()->back()->with(['success' => 'تم تعديل المنتج بنجاح'])->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $product = Product::findOrFail($request->id);
            if($product){
                $product->delete();
                return redirect()->back()->with(['success' => 'تم حذف المنتج بنجاح'])->withInput();
            }else{
                return redirect()->back()->with(['error' => 'هذا المنتج غير موجود في قاعدة البيانات'])->withInput();
            }
            
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'حدث خطأما'.$ex])->withInput();
        }
       
    }
}

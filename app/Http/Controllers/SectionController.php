<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::get();
        return view('sections.index',compact('sections'));
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
    public function store(SectionRequest $request)
    {
        Section::create([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'created_by' => auth()->user()->name,
        ]);
        return redirect()->back()->with(['success' => 'تم تسجيل القسم بنجاح'])->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'section_name' => 'required|unique:sections,section_name,'. $request->id,
        ],[
            'section_name.required' => 'يرجى ادخال اسم القسم',
            'section_name.unique' => 'اسم القسم مسجل مسبقا',
        ]);
        $section = Section::find($request->id);
        $section->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);
        return redirect()->back()->with(['success' => 'تم تعديل القسم بنجاح'])->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $section = Section::findOrFail($request->id);
            if($section){
                $section->delete();
                return redirect()->back()->with(['success' => 'تم حذف القسم بنجاح'])->withInput();
            }else{
                return redirect()->back()->with(['error' => 'هذا القسم غير موجود في قاعدة البيانات'])->withInput();
            }
            
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'حدث خطأما'.$ex])->withInput();
        }
    }
}

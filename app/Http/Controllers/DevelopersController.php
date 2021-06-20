<?php

namespace App\Http\Controllers;

use App\Developer;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DevelopersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $developers = Developer::orderBy('created_at', 'desc')->paginate(10);
        $users = auth()->user()->name;

         return view('developers.index',
          ['developers' => $developers],
          ['users' => $users]
      );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $developers = Developer::all();
        return view('developers.create',
        ['developers' => $developers]
      );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email|unique:developers',
        'phone_number' => 'required',
        'address' => 'required',
        'avatar' => 'required',
      ]);

      $add = new Developer;
      $add->id = Uuid::uuid4()->getHex();
      $add->first_name = $request->first_name;
      $add->last_name = $request->last_name;
      $add->email = $request->email;
      $add->phone_number = $request->phone_number;
      $add->address = $request->address;

      //Handle if there is any picture uploaded, and saved in the storage
      if ($request->hasFile('avatar')) {
        $file = $request->file('avatar');
        $path = $file->store('file/Avatar', 'public');
        $add->avatar = $path;
      }
      $add->save();
      return redirect('developers')->with('status','Developer has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $developers = Developer::find($id);
        return view('developers.edit',
        ['developers' => $developers]
      );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $developers = Developer::find($id);
      $developers->first_name = $request->first_name;
      $developers->last_name = $request->last_name;
      $developers->email = $request->email;
      $developers->phone_number = $request->phone_number;
      $developers->address = $request->address;
      if ($request->hasFile('logo')) {
        $file = $request->file('logo');
        $path = $file->store('file/Avatar', 'public');
        $developers->logo = $path;
      }
       $developers->save();
       return redirect('developers')->with('status','Developer successfully edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $developers = Developer::find($id);
      $developers->delete();
      return back()->with('success','Developer has been deleted successfully');
    }

    
}

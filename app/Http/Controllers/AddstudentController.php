<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use App\User;
use Illuminate\Http\Request;

class AddstudentController extends Controller
{
  //    public function index()
  //   {   
		// $data=User::all();
  //       // dd($data);
  //           return view('admin.add_user', ['users' => $data]);
        
  //   }
	 public function index(){
     	$data = DB::table('users')->where('Status', '=', 'New')->get();
     	
   		return view('admin.add_user',['users' => $data]);
   }
    public function update (Request $request,$id){
         $name = $request->input('Approved');
         $data = DB::table('users')->where('Status', '=', 'New')->get();
          DB::update('update users set Status = "Approved" where id = ?',[$id]);
      return view('admin.add_user',['users' => $data]);
    }
}
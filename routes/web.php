<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
Route::get('/', function () {
	$data=\App\ActivateVote::latest()->first();
           $mytime = Carbon\Carbon::now();
           if ($data!=null) {
             $end=$data->enddate;
           $today=$mytime->toDateString();
           if ($end==$today) {
                $data->status='disabled';
                $data->save();}}
    return view('welcome');
});


Route::group(['middleware'=>['web','auth']], function(){
Route::get('/home',function(){
	if (Auth::user()->role==0) {
		return view('home');
	}
	else if(Auth::user()->role==1)
	{
		$users['users']=\App\User::all();
		return view('admin.home',$users);
	}
	else if(Auth::user()->role==2)
	{
		$users['users']=\App\User::all();
		return view('candidates.home',$users);
	}
})->name('home');
});

Route::resource('post', 'PostController');
Route::get('/news', 'PostController@userview');
Route::get('addpost', 'PostController@addpost');
Route::get('/add/new/student', 'AddstudentController@index');
Route::post('/home/profile/{id}', 'UserProfileController@index')->name('profile');
Route::post('/home/profile/{id}', 'UserProfileController@update')->name('profile');
Route::get('/user/privilage', 'PrevilageController@previlage');
Route::get('/report', 'ReportController@index');
Route::get('/setup/vote', 'VoteController@index');
Route::get('/setup/vote1', 'VoteController@delete1');
Route::post('/setup/vote', 'VoteController@activate')->name('activate');
Route::get('/add/new/student/{id}','AddstudentController@update');
Route::get('/add/new/student/deny/{id}','AddstudentController@deny');
Route::get('/add/new/student', 'AddstudentController@index');
Route::get('representativevote', 'RepresentativeVoteController@posts')->name('posts');
Route::post('representativevote', 'RepresentativeVoteController@postPost')->name('posts.post');
Route::get('representativevote/{id}', 'RepresentativeVoteController@show')->name('postsshow');
Route::get('/user/privilage/admin/{id}', 'PrevilageController@admin');
Route::get('/user/privilage/user/{id}', 'PrevilageController@user');
Route::get('/user/privilage/candidate/{id}', 'PrevilageController@candidate');
Route::get('presidentvote', 'PresidentVoteController@posts')->name('pposts');
Route::post('presidentvote', 'PresidentVoteController@postPost')->name('pposts.post');
Route::get('presidentvote/{id}', 'PresidentVoteController@show')->name('pposts.show');
Route::POST('addPost', 'PostController@addPost');
Route::get('post', function(){
	$post = DB::table('posts')->get();
	return view('admin.post', ['posts' => $post]);
});
Route::resource('posts', 'PostController');
Route::post('vote/delete/{id}', 'VoteController@destroy')->name('deletevote');

Route::resource('canposts', 'CampaignPostController');


Route::get('/admin/view/active/vote','VoteController@display')->name('viewActiveVote');
Route::get('pp', 'VoteController@delete1');
Route::get('/result', function (){
	return view('candidates.result');
});
Route::get('/adm/result', function (){
	return view('admin.result');
});
Route::get('/campaign/post',function(){
	return view('user.campaignpost');
});
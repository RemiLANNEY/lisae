<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use DB;


class UserController extends Controller
{
    
	protected $userRepository;
	
	protected $nbrPerPage = 10;
	
	public function __construct(UserRepository $userRepository)
	{
		$this->middleware('auth');
		$this->userRepository = $userRepository;
	}
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    	$users = $this->userRepository->getPaginate($this->nbrPerPage);
    	$links = $users->render();
    	
    	return view('index', compact('users', 'links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    	$users = $this->userRepository->getPaginate(0);  
    	$promos = DB::table('promos')->get();
        return view('create', compact('users', 'promos'));
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
    	$user = $this->userRepository->store($request->all());
    	
    	return redirect('user')->withOk("L'utilisateur " . $user->name . " a été créé.");
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
    	$user = $this->userRepository->getById($id);
    	return view('show',  compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    	$user = $this->userRepository->getById($id);
    	$users = $this->userRepository->getPaginate(0);
    	if(empty($user->promo_id))
    		$promos = DB::table('promos')->get();
    	else 
    		$promos = DB::table('promos')->where('user_id', '=', $user->id)->orWhere([['user_id', '=', $user->admin], ['user_id', '!=', 1]])->get();
    	return view('edit',  compact('user', 'users', "promos"));
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
        //
        //print_r($request);
    	$this->userRepository->update($id, $request->all());
    	return redirect('user')->withOk("L'utilisateur " . $request->input('name') . " a été modifié.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    	$this->userRepository->destroy($id);
    	
    	return back()->withOk("L'utilisateur a été supprimé.");
    }
}

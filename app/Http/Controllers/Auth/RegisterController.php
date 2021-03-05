<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Events\UserRegistered;
use Illuminate\Support\Facades\Http;
use App\Services\SmartStreetService;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:10', 'unique:users'],
            'street_address' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:50','regex:/(^[A-Za-z ]+$)+/'],
            'state' => ['required', 'string', 'max:50','regex:/(^[A-Za-z ]+$)+/'],
            'zip' => ['required', 'string', 'max:5'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'street_address' => $data['street_address'],
            'city' => $data['city'],
            'state' => $data['state'],
            'zip' => $data['zip'],
            'password' => Hash::make($data['password'])
        ]);

        event(new UserRegistered($user));

        //update county
        $smartStreet = new SmartStreetService();
        $streetDetail = $smartStreet->getCounty($user->id,$user->street_address,$user->city,$user->state,$user->zip);
        if(!empty($streetDetail) && count($streetDetail)){
            $user->county = $streetDetail['county_name'];
            $user->update();
        }

        return $user;
    }

    public function getStreetData(Request $request){
        //dd($request->qry);
        $response = array("status"=>false,"data"=>"Something went wrong!","msg"=>"Something went wrong!");
        $smartStreet = new SmartStreetService();
        $suggestionList = $address = array();

        if($request->qry != ''){
            $qry = $request->qry;
            $autocompleteStreetList = $smartStreet->getAutocompleteStreet($qry);
            foreach ($autocompleteStreetList as $suggestion){
                $address['text'] = $suggestion->getText();
                $address['street'] = $suggestion->getStreetLine();
                $address['city'] = $suggestion->getCity();
                $address['state'] = $suggestion->getState();
                $suggestionList[] = $address;
            }
            if(!empty($suggestionList) && count($suggestionList)>0){
                $response = array("status"=>true,"data"=>$suggestionList,"msg"=>"Successfully retrieved data!");
            }else{
                $response = array("status"=>false,"data"=>"Something went wrong!","msg"=>"Unable to retrieve data!");
            }
        }
        return $response;
    }

    public function getZipcodeData(Request $request){
        //dd($request->qry);
        $response = array("status"=>false,"data"=>"Something went wrong!","msg"=>"Something went wrong!");
        $smartStreet = new SmartStreetService();
        $zipDetail = $address = array();

        if($request->city != '' && $request->state != ''){
            $city = $request->city;
            $state = $request->state;
            $zipDetail = $smartStreet->getZipCode($city,$state);
            if(!empty($zipDetail) && count($zipDetail)>0){
                $response = array("status"=>true,"data"=>$zipDetail,"msg"=>"Successfully retrieved data!");
            }else{
                $response = array("status"=>false,"data"=>"Something went wrong!","msg"=>"Unable to retrieve data!");
            }
        }
        return $response;
    }


}

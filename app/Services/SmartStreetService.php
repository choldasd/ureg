<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;

use SmartyStreets\PhpSdk\Exceptions\SmartyException;
use SmartyStreets\PhpSdk\StaticCredentials;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\US_Autocomplete\Lookup;
use SmartyStreets\PhpSdk\ArrayUtil;
use SmartyStreets\PhpSdk\US_ZIPCode\Lookup as ZipLookup;
use SmartyStreets\PhpSdk\US_Street\Lookup as StreetLookup;


class SmartStreetService {

    private $authId = '8391c643-7fb3-d19d-82d2-29b54845d0b3';
    private $authToken = 'DLPnsIK6vejRh3MrFbWI';

    public function __construct(){

    }

    public function getAutocompleteStreet($qry){
        $client = $this->getClient();

        $lookup = new Lookup($qry);
        $client->sendLookup($lookup);

        $streetList = $lookup->getResult();
        return $streetList;
    }

    public function getZipCode($city,$state){
        $zipDetail = array();
        $client = $this->getZipCodeClient();

        $lookup = new ZipLookup();
        $lookup->setCity($city);
        $lookup->setState($state);

        try {
            $client->sendLookup($lookup);
            $zipDetail = $this->displayZipcodeResults($lookup);
            //print_r($result); die;

        }catch (SmartyException $ex) {
            echo($ex->getMessage());
        } catch (\Exception $ex) {
            echo($ex->getMessage());
        }

        return $zipDetail;
    }

    public function displayZipcodeResults(ZipLookup $lookup) {
        $details = array();
        $result = $lookup->getResult();
        $zipCodes = $result->getZIPCodes();
        $cities = $result->getCities();

        foreach ($cities as $city) {
            $details['state'] = $city->getState();
        }
        foreach ($zipCodes as $zip) {
            $details['zipcode'] = $zip->getZIPCode();
        }

        return $details;
    }

    public function getCounty($id,$street_address,$city,$state,$zipcode){
        $streetDetail = array();
        $client = $this->getStreetClient();

        $zipcode = (string) $zipcode;
        $city = (string) trim($city);
        $state = (string) $state;

        $lookup = new StreetLookup();
        $lookup->setInputId($id);
        $lookup->setStreet($street_address);
        $lookup->setCity($city);
        $lookup->setState($state);
        $lookup->setZipcode($zipcode);

        $lookup->setMaxCandidates(3);
        $lookup->setMatchStrategy("invalid");

        try {
            $client->sendLookup($lookup);
            $streetDetail = $this->displayCountyResults($lookup);

        }catch (SmartyException $ex) {
            echo($ex->getMessage());
        } catch (\Exception $ex) {
            echo($ex->getMessage());
        }

        return $streetDetail;
    }

    public function displayCountyResults(StreetLookup $lookup) {
        $details = array();
        $results = $lookup->getResult();

        if (empty($results)) {
            return $details;
        }
        $firstCandidate = $results[0];
        $details['county_name'] = $firstCandidate->getMetadata()->getCountyName();
        return $details;
    }

    public function getClient(){
        //print_r($this->authId);die;
        $staticCredentials = new StaticCredentials($this->authId, $this->authToken);
        $client = (new ClientBuilder($staticCredentials))->buildUSAutocompleteApiClient();
        return $client;
    }

    public function getZipCodeClient(){
        $staticCredentials = new StaticCredentials($this->authId, $this->authToken);
        $client = (new ClientBuilder($staticCredentials))->buildUsZIPCodeApiClient();
        return $client;
    }

    public function getStreetClient(){
        $staticCredentials = new StaticCredentials($this->authId, $this->authToken);
        $client = (new ClientBuilder($staticCredentials))->buildUsStreetApiClient();
        //$client = (new ClientBuilder($staticCredentials))
                        //->viaProxy("http://localhost:8080", "username", "password")->buildUsStreetApiClient();
// uncomment this line to point to the specified proxy.

        return $client;
    }





}

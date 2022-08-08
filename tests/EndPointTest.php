<?php

require_once "./model/ID90Api.php";
require_once "./model/destination.model.php";
require_once "./model/admin.model.php";

/**
 * TEST Endpoints ID90
 * 
 * ./vendor/bin/phpunit tests/EndpointTest.php
 * 
 */
class EndpointTest extends \PHPUnit\Framework\TestCase
{
		
    public function testEndpointLogin(){
			try {
				$this->initApi();
				$request = [
					"airline" => "f9",
					"username" => "f9user",
					"password" => "123456",
					"remember_me" => "1"
				];
				$test = ModelAdm::mdlLoginAdm($request);
				$this->assertTrue($test, 'Faill ID90Api::loginAirline');
			} catch(Exception $e) {
				$this->fail($e->getMessage());
			}
    }

		public function testEndpointAirlines(){
			try {
				$this->initApi();
				$test = ID90Api::getAirlines();
				$this->assertGreaterThan(0,count($test), 'Faill ID90Api::getAirlines');
			} catch(Exception $e) {
				$this->fail($e->getMessage());
			}
    }


		public function testEndpointSearch(){
			try {
				$this->initApi();
				$values = [
					"guests[]" => 2,
					"checkin" => '2020-10-24',
					"checkout" => '2020-10-25',
					"destination" => 'Cancun',
					"rooms" => 1,
					"sort_criteria" => "Overall",
					"sort_order" => "desc",
					"per_page" => 25,
					"page" => 1
				];

				$test = DestinationModel::searchDestination($values);
				$this->assertArrayHasKey("hotels",$test, 'Faill DestinationModel::searchDestination');
			} catch(Exception $e) {
				$this->fail($e->getMessage());
			}
    }

		private function initApi(){
			ID90Api::init('https://beta.id90travel.com');
		}
}
<?php 

	class DestinationController {

		public function viewSearchDestination(){
			if(isset($_POST["search"])){
				$search = $this->searchDestination();
				require_once "./view/modules/index/results.php";
			}
		}

		public function searchDestination(){
			$return = [
				"errors" => DestinationModel::validateSearch($_REQUEST),
				"data" => null
			];

			$checkin = str_replace('/', '-', explode("-",$_REQUEST["reservation"])[0] );
			$checkout = str_replace('/', '-', explode("-",$_REQUEST["reservation"])[1] );

			if(count($return["errors"]) == 0){
				$values = [
					"guests[]" => $_REQUEST["guests"],
					"checkin" => date('Y-m-d',strtotime($checkin)),
					"checkout" => date('Y-m-d',strtotime($checkout)),
					"destination" => $_REQUEST["destination"],
					"rooms" => 1,
					"sort_criteria" => "Overall",
					"sort_order" => "desc",
					"per_page" => 25,
					"page" => 1
				];

				$return["data"] = DestinationModel::searchDestination($values);
			}
			return $return;

		}
		
	}
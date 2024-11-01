<?php
namespace gsdParameters;
use \gsdParameters\parameters;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

trait parameters {


	static function defaultParams(){
		
		\gsd\google_structured_data::$organiztion_parameters = array();
		\gsd\google_structured_data::$local_business_parameters = array();
		\gsd\google_structured_data::$local_business_types = array();
		\gsd\google_structured_data::$organiztion_phone_types = array();
			
		
	}
	
	
	static function setParamsValues(){

		\gsd\google_structured_data::$organiztion_parameters = array(
			'gsd_active',
			'default_website',
			'website_url',
			'phones',
		);

		\gsd\google_structured_data::$organiztion_phone_types = array(
			'customer support',    
			'technical support',    
			'billing support',    
			'credit card support',    
			'bill payment',    
			'baggage tracking',    
			'package tracking',    
			'roadside assistance',    
			'reservations',    
			'sales',    
			'emergency',    
		);

		\gsd\google_structured_data::$local_business_parameters = array(
			'local_business_active',
			'local_business_type',
			'website_url',
			'default_website',
			'local_business_photos',
			'website_name_default',
			'local_business_name',
			'local_business_description',
			'local_business_description_default',
			'local_business_telephone',
			'local_business_email',
			'local_business_street_address',
			'local_business_address_locality',
			'local_business_address_region',
			'local_business_postal_code',
			'local_business_address_country',
			'local_business_geo_longitude',
			'local_business_geo_latitude',
		);

		\gsd\google_structured_data::$local_business_types = array(
			'AnimalShelter',
			'AutomotiveBusiness',
			'ChildCare',
			'Dentist',
			'DryCleaningOrLaundry',
			'EmergencyService',
			'EmploymentAgency',
			'EntertainmentBusiness',
			'FinancialService',
			'FoodEstablishment',
			'GovernmentOffice',
			'HealthAndBeautyBusiness',
			'HomeAndConstructionBusiness',
			'InternetCafe',
			'LegalService',
			'Library',
			'LodgingBusiness',
			'ProfessionalService',
			'RadioStation',
			'RealEstateAgent',
			'RecyclingCenter',
			'SelfStorage',
			'ShoppingCenter',
			'SportsActivityLocation',
			'Store',
			'TelevisionStation',
			'TouristInformationCenter',
			'TravelAgency',
		);
		
		
	}

	
}

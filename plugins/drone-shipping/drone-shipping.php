<?php 
/**
 * Plugin Name: Drone shipping
 * Description: Fastest shipping in the world
 * Author: Olle Nilsson
 */

 add_action('woocommerce_shipping_init', 'drone_shipping_init');

 function drone_shipping_init() {
     if( ! class_exists('WC_DRONE_SHIPPING') ){
         class WC_DRONE_SHIPPING extends WC_Shipping_Method {
            //Cunstruct funktion behövs för class, alla standard värden
            public function __construct(){
                $this->id                 = 'drone_shipping'; 
				$this->method_title       = __( 'Best Drone Shipping' );  
				$this->method_description = __( 'Fastest shipping in the world direct to your window' ); 

				$this->enabled            = "yes"; 
				$this->title              = "Best Drone Shipping"; 

				$this->init();
                
            }
            public function init(){
                 
				$this->init_form_fields(); // Funktionen defineras längre ner
				$this->init_settings(); 

				add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
            }
            

            //Beräknar frakt beroende på vikt på varan
            public function calculate_shipping($package = array()){
                $weight = 0;
                $cost = 0;
                $country = $package["destination"]["country"];

                foreach ( $package['contents'] as $item_id => $values ) 
                { 
                    $_product = $values['data']; 
                    $weight = $weight + $_product->get_weight() * $values['quantity']; 
                }

                $weight = wc_get_weight( $weight, 'kg' );

                if( $weight <= 10 ) {

                    $cost = 200;

                } elseif( $weight <= 30 ) {

                    $cost = 300;

                } elseif( $weight <= 50 ) {

                    $cost = 400;

                } else {

                    $cost = 500;

                }

                $countryZones = array(
                    'SE' => 0,
                    'US' => 3,
                    'GB' => 2,
                    'CA' => 3,
                    'ES' => 2,
                    'DE' => 1,
                    'IT' => 1
                    );

                $zonePrices = array(
                    0 => 10,
                    1 => 30,
                    2 => 50,
                    3 => 70
                    );

                $zoneFromCountry = $countryZones[ $country ];
                $priceFromZone = $zonePrices[ $zoneFromCountry ];

                $cost += $priceFromZone;

                $rate = array(
                    'id' => $this->id,
                    'label' => $this->title,
                    'cost' => $cost
                );

                $this->add_rate( $rate );
                
            }

            function init_form_fields() {
                
                $this->form_fields = array(

                    'enabled' => array(
                        'title' => __('Enable', 'woocommerce'),
                        'type' => 'checkbox',
                        'description' => __('Enable this shippingmethod.', 'woocommerce'),
                        'default' => 'yes'
                    ),
                    'title' => array(
                        'title' => __( 'Title', 'woocommerce' ),
                        'type' => 'text',
                        'description' => __( 'This controls the title which the user sees during checkout.', 'woocommerce' ),
                        'default' => __( 'Drone Shipping', 'woocommerce' )
                    ),
                    'weight' => array(
                        'title' => __( 'Weight (kg)', 'woocommerce' ),
                        'type' => 'number',
                        'description' => __( 'Maximum allowed weight', 'woocommerce' ),
                        'default' => 100
                    ),
                    'price' => array(
                        'title' => __( 'Price', 'woocommerce' ),
                        'type' => 'number',
                        'description' => __( 'Default Price', 'woocommerce' ),
                        'default' => __( 99, 'woocommerce' )
                          ),

                );
            }

         }
     }
 }

 add_filter('woocommerce_shipping_methods', 'add_drone_method');

 function add_drone_method( $methods ) {
     $methods['drone_shipping'] = 'WC_DRONE_SHIPPING';
     return $methods;

 }
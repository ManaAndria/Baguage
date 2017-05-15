<?php
class BookingSearch_shortcode
{   
    private $lang;

	public function __construct()
	{
		add_action('init', array($this, 'bookingSearch_shortcodes_init'));

        //translation
        $this->lang = array(
            'from' => array(
                'en_us' => 'from',
                'fr_fr' => 'à partir de'
                ),
            'Booking' => array(
                            'en_us' => 'Booking',
                            'fr_fr' => 'Réservation'
                            ),
            'See details' => array(
                            'en_us' => 'See details',
                            'fr_fr' => 'Voir détails'
                            )

            );
	}

	//shortcode initialisation
    function bookingSearch_shortcodes_init()
    {
        add_shortcode('bookingSearch_result', array($this, 'bookingSearch_shortcode'));
    }    

    //generate page link to correct language
    function getPageLinkLang($pageID="")
    {
        $id = $pageID;
        $term_list = wp_get_post_terms($id, 'language', array('field'    => 'slug',
                        'taxonomy' => 'language'));

        if ($term_list[0]->slug != "") {
            if (($term_list[0]->slug != the_curlang()))
                if((get_post_custom_values('lang-'.the_curlang(), $id) != null )) {
                    $id = get_post_custom_values('lang-'.the_curlang(), $id)[0];
            }            
        }

        return get_page_link($id);
    }

        //get post having specific rentatlId
    function postHavingRentalId($availables, $pageID)
    {	
        //page id for the reservation
        $id = $pageID;

        $rentalId = implode(',', $availables);

        //wp_query arguments
    	$args = array(
	        	'post_type' => 'post',
                'category_name' => 'nos-villas',
                'tax_query' => array(
                    array(
                        'field'    => 'slug',
                        'taxonomy' => 'language',
                        'terms'    => the_curlang(),
                    ),
                ),
	        	'meta_query' => array(
							array(
								'key'     => 'rentalId',
								'value'   => $rentalId,
								'compare' => 'IN',
							),
				)
				
		   	);

		$post_query = new WP_Query($args);
		
		$html='';
		
		if($post_query->have_posts() ) {
            $max = $post_query->found_posts;
            $count = 0;

		  	foreach ($post_query->posts as $post){

                // head-result
                if ($count % 3 == 0 ) {
                    $html .= '<div class="vc_row wpb_row vc_inner vc_row-fluid vc_column-gap-10 vc_row-o-equal-height vc_row-o-content-top vc_row-flex">';
                }
                $html .='<div class="wpb_column vc_column_container vc_col-sm-4">
                                <div class="vc_column-inner ">
                                    <div class="wpb_wrapper">
                                        <div class="kleo_text_column wpb_content_element  luxueuses-villas vc_custom_1494420149540">
                                            <div class="wpb_wrapper">
                                                <p>';
                // end head-result

                //link
                $html .= '<a href="'.$this->getPageLinkLang($post->ID).'"><br>';
                    //image
                            $html .=get_the_post_thumbnail( $post->ID, 'medium' ).'<br>';
                    //end image

                    //span prix
                    $html .='   <span class="bg-transparent">
                                                            <span class="partir">'.isset($this->lang['from'][the_curlang()]) ? $this->lang['from'][the_curlang()].' ' : 'from '.'</span>
                                                                <span class="prix">';
                    $html .= isset( get_post_custom( $post->ID )['prix-villa'] ) ? get_post_custom_values('prix-villa', $post->ID)[0] : '' ;
                    $html .= '                                      <span class="euro">€</span>
                                                                </span>
                                </span>';
                    //end span prix
                $html .= '</a><br>';
                //end link

                //description
                $html .= '<span class="description-villas">';
                    //titre
                    $html .= '<span class="titre">'.$post->post_title.'</span><br>';
                    //description
                    $html .='<span class="description">'.isset( get_post_custom( $post->ID )['description-villa'] ) ? get_post_custom_values('description-villa', $post->ID)[0] : '';
                    $html .='</span>';
                $html .= '</span><br>';
                //end description
                
                //reservation
                $html .= '<span class="reservation"><a style="color: #333333;" href="'.$this->getPageLinkLang($id).'">';
                $html .= '<i class="fa fa-phone"></i> '.isset($this->lang['Booking'][the_curlang()]) ? $this->lang['Booking'][the_curlang()] : 'Booking';
                $html .='</a></span>';
                //end reservation

                //voir details
                $html .='<span class="détails">
                        <a style="color: #333333;" href="'.$this->getPageLinkLang($post->ID).'" >';
                $html .='   <i class="fa fa-search-plus"></i>'.isset($this->lang['See details'][the_curlang()]) ? $this->lang['See details'][the_curlang()] : 'See details';
                $html .='</a></span>';
                //end voir details
                
                // footer-result
                $html .='                       </p>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                            </div>';
                // end footer-result

                $count = $count + 1;
                if ($count % 3 == 0 || $count == $max) {
                    $html .='
                        </div><div class="vc_empty_space" style="height: 30px"><span class="vc_empty_space_inner"></span></div>';
                }
		  	}

            wp_reset_query();
		  	return $html;
		}
		return null;
    }

    //change date format
    function dateYmdFormat($date_str)
    {
        if ($date_str != '') {
            $date_str = str_replace('/', '-', $date_str);
            $date_str = date('Ymd', strtotime($date_str));
            return $date_str;
        }
    }

    //the bookingSearch_result shortcode content
    function bookingSearch_shortcode($atts = [])
    {
        $atts = shortcode_atts( array(
            'page-id' => 'null',
        ), $atts, 'bookingSearch_result' );

        $from="";
        $until="";
        $nb_person=0;

        $html = '';
        $html .='
        <section class="container-wrap  main-color ">
            <div class="section-container container">
                <div class="vc_row vc_row-fluid row">
                    <div class="wpb_column vc_column_container vc_col-sm-12">
                        <div class="vc_column-inner ">
                            <div class="wpb_wrapper">
                                ';
        
        if (isset($_POST['form']) && !empty($_POST['form'])) {
            $from = $this->dateYmdFormat($_POST['form']['dateDebut']);
            $until = $this->dateYmdFormat($_POST['form']['dateFin']);
            $nb_person = $_POST['form']['capacite'];

            //get rental from bookingsync
            $all_rentals = $this->getRentals();
            if (!$all_rentals) {
                $this->refreshToken();
                $all_rentals = $this->getRentals();
            }
            $unavailables = $this->getUnavailableRentals($from, $until);
            $availables = array();
            foreach ($all_rentals as $all_rental) {
                if (!in_array($all_rental, $unavailables)) {
                    $availables[] = $all_rental;
                }
            }
            

            $html.= $this->postHavingRentalId($availables,  $atts['page-id']);
       

        }

        // end if query->have_posts()
        $html .='              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>';

        

        return $html;
    }

    // get all rentals
    function getRentals() {
        $access_token = get_option('dsb_access_token');
        if ($access_token == '') {
            if ($this->getFromFile('access_token') !== false) {
                update_option('dsb_access_token', $this->getFromFile('access_token'));
                $access_token = get_option('dsb_access_token');
            }
            else{
                //if dbs_options.json file doesn't have the option string or the file doesn't exist
            }
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer $access_token", "Content-Type: application/json", "Accept: application/json"));
        curl_setopt($ch, CURLOPT_URL, "https://www.bookingsync.com/api/v3/rentals");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $response_arr = json_decode($response);
        if (isset($response_arr->errors))
            return false;

        $rentals = $response_arr->rentals;
        $all_rentals = array();

        foreach ($rentals as $rental) {
            $all_rentals[] = $rental->id;
        }

        return $all_rentals;
    }

    // refresh token when expired
    function refreshToken() {
        $refresh_token = get_option('dsb_refresh_token');
        if ($refresh_token == '') {
            if ($this->getFromFile('refresh_token') !== false) {
                update_option('dsb_refresh_token', $this->getFromFile('refresh_token'));
                $refresh_token = get_option('dsb_refresh_token');
            }
            else{
                //if dbs_options.json file doesn't have the option string or the file doesn't exist
                
            }
        }

        $ch = curl_init();
        $data = array
        (
          "client_id" => get_option('dbs_client_id'),
          "client_secret" => get_option('dbs_client_secret'),
          "refresh_token" => $refresh_token,
          "grant_type" => "refresh_token",
          "redirect_uri" => "urn:ietf:wg:oauth:2.0:oob"
        );
        $data_string = json_encode($data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer cOkustgdj7MmKEQBAjBUK0no9EOs", "Content-Type: application/json", "Accept: application/json"));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_URL, "https://www.bookingsync.com/oauth/token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_arr = json_decode($response);
        $access = $response_arr->access_token;
        $refresh = $response_arr->refresh_token;

        update_option('dsb_access_token', $access);
        update_option('dsb_refresh_token', $refresh);

        $this->saveToFile($access, $refresh);

        return $access;
    }

    //unavailable rentals
    function getUnavailableRentals($from, $until) {
        $access_token = get_option('dsb_access_token');

        $ch3 = curl_init();
        curl_setopt($ch3, CURLOPT_HTTPHEADER, array("Authorization: Bearer $access_token", "Content-Type: application/json", "Accept: application/json"));
        curl_setopt($ch3, CURLOPT_URL, "https://www.bookingsync.com/api/v3/bookings?status=booked,unavailable&from=$from&until=$until");
        curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
        $response3 = curl_exec($ch3);
        curl_close($ch3);

        $response_arr3 = json_decode($response3);
        $results = $response_arr3->bookings;
        $unavailables = array();
        foreach ($results as $result) {
            $unavailables[] = $result->links->rental;

        }
        return $unavailables;
    }

    //save access and refresh token to json file
    function saveToFile($access_token, $refresh_token)
    {   
        $content = array(
            "clientID" => get_option('dbs_client_id'),
            "clientSecret" => get_option('dbs_client_secret'),
            "authorization" => get_option('dbs_authorization'),
            "access" => $access_token,
            "refresh" => $refresh_token,
            "date" => date("Y:m:d"),
            );

        $content_str = json_encode($content);
        $file = fopen(plugin_dir_path( __FILE__ ).'/dbs_options.json', "w+");
        fwrite($file, $content_str);
        fclose($file);
    }

    //read option from file
    function getFromFile($option = '')
    {   if ($option != '') {
            $file = fopen(plugin_dir_path( __FILE__ ).'/dbs_options.json', "r");
            $options_str = $fwrite($file, $content_str);
            fclose($file);
            $options = json_decode($options_str);

            if ($option === 'access_token' && isset($options->access)) {
                return $options->access;
            }
            if ($option === 'access_token' && isset($options->refresh)) {
                return $options->refresh;
            }

            return false;
        }
        return false;
    }

    
}
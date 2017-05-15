<?php
class BookingSearch_Widget extends WP_Widget
{
    public $lang;

    public function __construct()
    {
        parent::__construct('bookingSearch_widget', 'BookingSearch', array('description' => __('Search engine.','Booking-search')));
        $this->lang = array(
            "Arrival date" => "Date d'arrivée",
            "Departure date" => "Date de départ",
            "Number of person" => "Nombre de personne",
            "FIND A VILLA" => "TROUVER UNE VILLA"
        );

    }
    
    //check page Id existance
    function isPageIdExist($id = '')
    {
        $pageID = $id;
        if (get_post_status($pageID) === false) {
            //page not exist
            return __('Page not exist!','Booking-search');
        }
        elseif (get_post_status($pageID) != 'publish') {
            //page is private
            return __('Page not published!','Booking-search');
        }
        else
        {
            return true;
        }
    }

    //widget form creation
	function form($instance)
	{
		//check values
        if ($instance) {
            $pageId = esc_attr($instance['pageId']);
            
        } else
        {
            $pageId = '';
        }

        $err = $this->isPageIdExist($pageId);

        ?>
        <p>
            <label for="<?php echo $this->get_field_id('pageId');?>"> <?php _e('Page Id', 'bookingSearch')?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('pageId');?>" name="<?php echo $this->get_field_name('pageId');?>" type="text" value="<?php echo $pageId; ?>" />
        </p>
        <?php if ($err !== true && $pageId != '') {?>

            <div class="" style="
                padding: 15px;
                margin-bottom: 20px;
                border: 1px solid transparent;
                border-radius: 4px; 

                color: #a94442;
                background-color: #f2dede;
                border-color: #ebccd1;
  ">
                <strong><?php echo $err; ?></strong>
            </div>
        <?php } ?>
        <?php
	}

	//widget update
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
        // Fields
        $instance['pageId'] = strip_tags($new_instance['pageId']);
        return $instance;
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

    //get word translation
    function getTranslationWord($original)
    {
        $currlang = the_curlang();
        if( $currlang == 'fr_fr' )
        {
            if(array_key_exists($original, $this->lang)) {
                return $this->lang[$original];
            } else {
                return $original;
            }
        } else {
            return $original;
        }   
    }

    //widget display
	function widget($args, $instance)
	{

        ?>
        <div class="container-fluid" id="search">
            <div class="booking_container">
      
                <form name="form" method="post" 
                action="<?php echo $this->getPageLinkLang($instance['pageId']);?>" 

                id="formulaire" class="booking_row">
                    <div class="booking_col-md-1" ><span ></span></div>

                    <div class="booking_col-md-10">
                        <div class="booking_row">
                            <div class="booking_col-md-3 booking_col-sm-6 booking_col-xs-6 dateDpt">
                                <span class="frmPicto">
                                   <input type="text" id="form_dateDebut" name="form[dateDebut]" class="form-control" placeholder="<?= $this->getTranslationWord("Arrival date")?>" />
                                </span>  
                            </div>
                            <div class="booking_col-md-3 booking_col-sm-6 booking_col-xs-6 dateDpt">
                                <span class="frmPicto">
                                     <input type="text" id="form_dateFin" name="form[dateFin]" class="form-control" placeholder="<?= $this->getTranslationWord("Departure date");?>" />
                                </span> 
                            </div>
                            <div class="booking_col-md-3 booking_col-sm-6 booking_col-xs-6" id="nbPerso">
                                <span class="frmPicto">
                                    <input type="text" id="form_capacite" name="form[capacite]" class="form-control" placeholder="<?=$this->getTranslationWord("Number of person");?>" />
                                </span>   
                            </div>
                            <div class="booking_col-md-3 booking_col-sm-6 booking_col-xs-6" id="btnFrmPicto">
                                <span class="frmPicto">
                                    <input type="submit" class="btn-default btn" value="<?=$this->getTranslationWord("FIND A VILLA");?>" style="
    height: 35.5px;
    padding-top: 12.8px !important;
    padding-bottom: 26.8px !important;
    font-size: 14px !important;
    font-weight: 700 !important;>
                                </span>   
                            </div>                                                                        
                        </div> <!--end input text-->                    
                        
                    </div><!--end booking_col-->
     
                    <div class="booking_col-md-1" ><span ></span></div>
                </form> <!--end row form-->
            
            </div> <!--end container-->
        </div><!--end container-fluide search-->
        <?php	 
	}

}


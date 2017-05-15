<?php

class BookingSearch_post_meta_box
{

	public function __construct()
	{
		//add meta_box to post
        add_action( 'add_meta_boxes', array($this,'cd_meta_box_add') );
        //save meta_box
        add_action( 'save_post', array($this,'cd_meta_box_save') );
	}

	//add the meta_box
    function cd_meta_box_add()
    {
        add_meta_box( 'my-meta-box-id', 'BookingSearch - Villa', array($this, 'cd_meta_box_cb'), 'post', 'side', 'high' );
    }
    
    //fill the content of the meta_box and have a input variable
    function cd_meta_box_cb($post)
    {
        global $post;
        $values = get_post_custom( $post->ID );
        $rentalId = isset( $values['rentalId'] ) ? esc_attr( $values['rentalId'][0] ) : '';
        $description = isset( $values['description-villa'] ) ? esc_attr( $values['description-villa'][0] ) : '';
        $prix = isset( $values['prix-villa'] ) ? esc_attr( $values['prix-villa'][0] ) : '';

        // We'll use this nonce field later on when saving.
        wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
        ?>
            <label for="rentalId"><?=__('ID rental','Booking-search');?></label>
            <input class="widefat" type="text" name="rentalId" id="rentalId" value="<?php echo $rentalId; ?>"/>

            <label for="prix-villa"><?=__('Price','Booking-search');?></label>
            <input class="widefat" type="text" name="prix-villa" id="prix-villa" value="<?php echo $prix; ?>"/>

            <label for="description-villa"><?=__('Description','Booking-search');?></label>
            <textarea class="widefat" id="description-villa" name="description-villa"><?php echo $description; ?></textarea>

        <?php 
    }

    //function related to the meta box save
    function cd_meta_box_save( $post_id )
    {
        // Bail if we're doing an auto save
        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
         
        // if our nonce isn't there, or we can't verify it, bail
        if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
         
        // if our current user can't edit this post, bail
        if( !current_user_can( 'edit_post' ) ) return;

        // now we can actually save the data
        $allowed = array( 
            'a' => array( // on allow a tags
                'href' => array() // and those anchors can only have href attribute
            )
        );

        // Make sure your data is set before trying to save it
        if( isset( $_POST['rentalId'] ) )
        {
            update_post_meta( $post_id, 'rentalId', wp_kses( $_POST['rentalId'], $allowed ) );
            update_post_meta( $post_id, 'prix-villa', wp_kses( $_POST['prix-villa'], $allowed ) );
            update_post_meta( $post_id, 'description-villa', wp_kses( $_POST['description-villa'], $allowed ) );
        }
             
    }
}
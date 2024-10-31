<?php
/*
Plugin Name: Post Images Gallery
Plugin URI: http://www.gport.nl/
Description: Shows a gallery in the sidebar out of all the images in a post.
Author: Gerben van Dijk
Version: 1.7
Author URI: http://www.gport.nl/
*/
 
function postimg_widget( $args ) {
	
	if (is_array($args)) {
	
		extract( $args );
		
	}

	if ( is_singular() ) {
	    
	    // Get the post ID.
	    global $wp_query;
	    $iPostID = $wp_query->post->ID;
	    
	    // Get images for this post.
	    $arrImages =&get_children('post_type=attachment&post_mime_type=image&post_parent=' .$iPostID );
	
	    // If images exist for this page.
	    if($arrImages) {
	    
			// Adding the Post Image Gallery stylesheet
			echo '<link rel="stylesheet" href="'.WP_PLUGIN_URL.'/post-image-gallery/postimggal.css" type="text/css" media="screen">';


	        // Get array keys representing attached image numbers.
	        $arrKeys = array_keys($arrImages);

			// Getting the options.
			$options = get_option("postimg_widget");
			
			// No options? No problem! We set them here. Unfortunately this is not working yet.
			if (!is_array( $options )) {
				$options = array(
			  	'title' => 'Post Images Gallery',
			  	'thumb_width' => '50',
			  	'thumb_height' => '50',
			  	'js_framework' => '1'	  	
			  	  	
				);
				
			}
			
			// Calling the javascript.
			// We use Fancybox (http://fancybox.net/home) for this. Credits to the author!
			if ($options['js_framework'] == 1) {
				
				echo '<script type="text/javascript" src="'.WP_PLUGIN_URL.'/post-image-gallery/jquery/jquery.fancybox-1.2.6.js"></script>';
				echo '<link rel="stylesheet" href="'.WP_PLUGIN_URL.'/post-image-gallery/jquery/jquery.fancybox-1.2.6.css" type="text/css" media="screen">';
				
				echo '<script type="text/javascript">$(document).ready(function() {$("a.postimggal").fancybox(); });</script>';
				
			}
			
			elseif ($options['js_framework'] == 2) {

				echo 'Currently Prototype is unsupported. More soon.';
			
			}		

			elseif ($options['js_framework'] == 3) {

				echo 'Currently Mootools is unsupported. More soon.';
			
			}
			
			elseif ($options['js_framework'] == 4) {
			
				echo '<script type="text/javascript" src="'.WP_PLUGIN_URL.'/postimggal/jquery/jquery-1.3.2.min.js"></script>';
				echo '<script type="text/javascript" src="'.WP_PLUGIN_URL.'/postimggal/jquery/jquery.fancybox-1.2.6.js"></script>';
				echo '<link rel="stylesheet" href="'.WP_PLUGIN_URL.'/postimggal/jquery/jquery.fancybox-1.2.6.css" type="text/css" media="screen">';
				
				echo '<script type="text/javascript">$(document).ready(function() {$("a.postimggal").fancybox(); });</script>';
							
			}	
						
	        // Show widget start + title.
	        		    
		    echo $before_widget;
		    
			echo $before_title . $options['title'] . $after_title;
			echo '<div class="postimggal_container">';
			
	        // Get all image attachments.
			foreach($arrKeys as $imgId) {
	
		        $iNum = $imgId;
		
		        // Get the thumbnail url for the attachment.
		        $sThumbUrl = wp_get_attachment_thumb_url($iNum);
		        $sImageUrl = wp_get_attachment_url($iNum);
		
		        // Build the <img> string.
		        $sImgString = '<a href="' . $sImageUrl . '" rel="postablum" class="postimggal"><img src="' . $sThumbUrl . '" width="' .$options['thumb_width']. '" height="' .$options['thumb_height']. '" alt="Thumbnail Image" title="Thumbnail Image" /></a>';
		
		        // Print the image.
		        echo $sImgString;
		        
		    }

	        // Show widget end.
			echo '</div>';
			echo $after_widget;

		}
		
	}
	
}
 
function init_postimg(){

	register_sidebar_widget("Post Images Widget", "postimg_widget");
	register_widget_control('Post Images Widget', 'postimg_control');	

}

function postimg_control() {
 
	// We need to grab any preset options.
	$options = get_option("postimg_widget");
 
	// No options? No problem! We set them here.
	if (!is_array( $options )) {
		$options = array(
	  	'title' => 'Post Images Gallery',
	  	'thumb_width' => '50',
	  	'thumb_height' => '50',	  	
	  	'js_framework' => '3'	  	
		);
		
	}
 
	// Is the user has set the options and clicked save, then we grab them using the $_POST function.
	if ($_POST['postimg-submit']) {
	
		$options['title'] = htmlspecialchars($_POST['widgettitle']);
		$options['thumb_width'] = htmlspecialchars($_POST['thumb_width']);
		$options['thumb_height'] = htmlspecialchars($_POST['thumb_height']);
		$options['js_framework'] = htmlspecialchars($_POST['js_framework']);
		
		// And we also update the options in the Wordpress Database.
		update_option("postimg_widget", $options);
		
	}
 
 	// Showing the form for the control area.
	echo '  <p>
			<label for="widgettitle">Title:</label><br />
			<input type="text" id="widgettitle" name="widgettitle" value="' .$options['title']. '" /><BR/>
			<BR/>
			<label for="thumb_width">Thumbnail Width:</label><BR/>
			<input type="text" id="thumb_width" name="thumb_width" value="' .$options['thumb_width']. '" /><BR/>
			<BR/>
			<label for="thumb_height">Thumbnail Height:</label><BR/>
			<input type="text" id="thumb_height" name="thumb_height" value="' .$options['thumb_height']. '" /><BR/>
			<BR/>	
			<label for="js_framework">Javascript Framework:</label>
			<select id="js_framework" name="js_framework">';
			
			// Making sure the correct value is selected.
			if ($options['js_framework'] == 1) {
			
				echo '<option value="1" selected="selected">Jquery.</option>';
				echo '<option value="2">Prototype. (coming soon)</option>';
				echo '<option value="3">MooTools. (coming soon)</option>';
				echo '<option value="4">I dont have one, just give me one.</option>';
				
			}
			
			elseif ($options['js_framework'] == 2) {

				echo '<option value="1">Jquery.</option>';
				echo '<option value="2" selected="selected">Prototype. (coming soon)</option>';
				echo '<option value="3">MooTools. (coming soon)</option>';
				echo '<option value="4">I dont have one, just give me one.</option>';
							
			}
			
			elseif ($options['js_framework'] == 3) {
			
				echo '<option value="1">Jquery.</option>';
				echo '<option value="2">Prototype. (coming soon)</option>';
				echo '<option value="3" selected="selected">MooTools. (coming soon)</option>';
				echo '<option value="4">I dont have one, just give me one.</option>';
							
			}				
			
			elseif ($options['js_framework'] == 4) {
			
				echo '<option value="1">Jquery.</option>';
				echo '<option value="2">Prototype. (coming soon)</option>';
				echo '<option value="3">MooTools. (coming soon)</option>';
				echo '<option value="4" selected="selected">I dont have one, just give me one.</option>';
							
			}	
						
	echo '  </select>
			<p>Only Jquery is supported at the moment, more soon.</p>				
			<input type="hidden" id="postimg-submit" name="postimg-submit" value="1" />
		    </p>';
	
}
 
add_action("plugins_loaded", "init_postimg");

?>
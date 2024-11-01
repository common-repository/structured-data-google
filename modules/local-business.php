<?php
namespace gsdLocalBusiness;
use \gsdLocalBusiness\localBusiness;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

trait localBusiness {
	
	static function updateSettingsLocal(){
		
		
		if (!empty($_POST)){
			foreach (\gsd\google_structured_data::$local_business_parameters as $key){
				$value = false;
				if ( isset($_POST[$key]) ) $value = esc_sql($_POST[$key]);
				
				
				if ($key == 'website_url'){
					$value = esc_url($value);
				}
								
				if ($key == 'local_business_email'){
					$value = sanitize_email($value);
				}
				
				if ($key == 'local_business_telephone'){
					$value = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
				}
				
				
				update_option($key, $value );
			}
			echo '<h2>update success</h2><br>';
		}
		
	}






	static function settings_local(){
		
		\gsdLocalBusiness\localBusiness::updateSettingsLocal();
		
		add_action('admin_footer', function() {

	?>

	<script>
		jQuery(document).ready(function($){

			var custom_uploader
			  , click_elem = jQuery('.wpse-228085-upload')
			  , target = jQuery('input[name="local_business_photos"]')
			  , photos_preview = jQuery('#photos_preview')

			click_elem.click(function(e) {
				e.preventDefault();
				//If the uploader object has already been created, reopen the dialog
				if (custom_uploader) {
					custom_uploader.open();
					return;
				}
				//Extend the wp.media object
				custom_uploader = wp.media.frames.file_frame = wp.media({
					title: 'Choose Image',
					button: {
						text: 'Choose Image'
					},
					multiple: true
				});
				//When a file is selected, grab the URL and set it as the text field's value
				custom_uploader.on('select', function() {
					attachments = custom_uploader.state().get('selection');
					target.val('');
					photos_preview.html('');
					var next_string = "";
					attachments.map( function( attachment ) {
						attachment = attachment.toJSON();
						target.val( target.val() + next_string + attachment.url );
						photos_preview.html( photos_preview.html() + '<img width="320" src="' + attachment.url + '">');
						next_string = ",";
					});
				});
				//Open the uploader dialog
				custom_uploader.open();
			});      
		});
	</script>

	<?php
		});
		
		
		$data = array();
		foreach (\gsd\google_structured_data::$local_business_parameters as $key){
			$data[$key] = get_option($key);
		}	

	?>
		<h1><?php _e('Google Structured Data Settings', 'gsd'); ?></h1>
		<form method="post">
			<div class="row"><label><?php _e('Active', 'gsd') ?>: <input type="checkbox" value="1" name="local_business_active" <?php if ($data['local_business_active']) echo ' checked' ?>>
			</label></div>
			<div id="gsd-active"<?php if ($data['local_business_active']) echo ' class="active"' ?>>
				<div class="row">
				<label><?php _e('Business type', 'gsd') ?>: <select name="local_business_type">
					<?php foreach (\gsd\google_structured_data::$local_business_types as $type): ?>
						<option<?php if ($data['local_business_type'] == $type) echo ' selected' ?>><?php echo $type ?></option>
					<?php endforeach; ?>
				</select></label>
				</div>
				<div class="row"><label><?php _e('Uniqe URL', 'gsd') ?>: <input type="text" name="website_url" value="<?php echo esc_url($data['website_url']) ?>" <?php if ($data['default_website']) echo ' readonly' ?>> <label><?php _e('Home URL', 'gsd') ?><input type="checkbox" value="1" name="default_website" <?php if ($data['default_website']) echo ' checked' ?>></label>
				</label></div>			
				<div class="row"><label><?php _e('Business name', 'gsd') ?>: <input type="text" name="local_business_name" value="<?php echo sanitize_text_field($data['local_business_name']) ?>" <?php if ($data['website_name_default']) echo ' readonly' ?>> <label><?php _e('Website name', 'gsd') ?><input type="checkbox" value="1" name="website_name_default" <?php if ($data['website_name_default']) echo ' checked' ?>></label>
				</label></div>
				<div class="row"><label><?php _e('Business email', 'gsd') ?>: 
				<input type="text" name="local_business_email" value="<?php echo sanitize_email($data['local_business_email']) ?>">
				</label></div>			
				<div class="row"><label><?php _e('Business telephone', 'gsd') ?>: 
				<input type="text" name="local_business_telephone" value="<?php echo filter_var($data['local_business_telephone'], FILTER_SANITIZE_NUMBER_INT) ?>">
				</label></div>				
				<div class="row"><label><?php _e('Business Description', 'gsd') ?>: 
				<textarea name="local_business_description"<?php if ($data['local_business_description_default']) echo ' readonly' ?>><?php echo esc_textarea($data['local_business_description']) ?></textarea>
				<label><?php _e('Website description', 'gsd') ?><input type="checkbox" value="1" name="local_business_description_default" <?php if ($data['local_business_description_default']) echo ' checked' ?>></label>
				</label></div>
				<div class="row"><label><?php _e('Business photos', 'gsd') ?>: <input type="hidden" name="local_business_photos" value="<?php echo $data['local_business_photos'] ?>">
						<button type="button" class="button wpse-228085-upload">Select</button></label>
				</label>
				<div id="photos_preview" class="row">
					<?php 
					
					if ($data['local_business_photos']){
						$preview_html = "";
						
						if(strpos($data['local_business_photos'],",") !== false){
							$imgs = explode(",", $data['local_business_photos']);
							foreach ($imgs as $img){
								$preview_html.='<img width="320" src="' . esc_url($img) . '">';
							}
						}else{
							$preview_html.='<img width="320" src="' . esc_url($data['local_business_photos']) . '">';
						}

						echo $preview_html;
					}
					?>
				</div>
				</div>
				<div class="row"><label><?php _e('Business Steert address', 'gsd') ?>: 
				<input type="text" name="local_business_street_address" value="<?php echo sanitize_text_field($data['local_business_street_address']) ?>" placeholder="Sderot Jerusalem 10">
				</label></div>				
				<div class="row"><label><?php _e('Business Address locality', 'gsd') ?>: 
				<input type="text" name="local_business_address_locality" value="<?php echo sanitize_text_field($data['local_business_address_locality']) ?>" placeholder="Israel">
				</label></div>				
				<div class="row"><label><?php _e('Business address region', 'gsd') ?>: 
				<input type="text" name="local_business_address_region" value="<?php echo sanitize_text_field($data['local_business_address_region']) ?>" placeholder="IL">
				</label></div>				
				<div class="row"><label><?php _e('Business postal code', 'gsd') ?>: 
				<input type="text" name="local_business_postal_code" value="<?php echo sanitize_text_field($data['local_business_postal_code']) ?>" placeholder="1234567">
				</label></div>				
				<div class="row"><label><?php _e('Business address country', 'gsd') ?>: 
				<input type="text" name="local_business_address_country" value="<?php echo sanitize_text_field($data['local_business_address_country']) ?>" placeholder="Outside israel">
				</label></div>			
				<div class="row"><label><?php _e('Business geo coordinates latitude', 'gsd') ?>: 
				<input type="text" name="local_business_geo_latitude" value="<?php echo sanitize_text_field($data['local_business_geo_latitude']) ?>">
				</label></div>				
				<div class="row"><label><?php _e('Business geo coordinates longitude', 'gsd') ?>: 
				<input type="text" name="local_business_geo_longitude" value="<?php echo sanitize_text_field($data['local_business_geo_longitude']) ?>">
				</label></div>	
			</div>		
			<div class="row"><label><button type="submit"><?php _e('Save', 'gsd') ?></button></label></div>

		</form>
		
		<?php
	}

		

	static function load_front_gsd_local_business(){
		
		
		$data = array();
		
				
		foreach (\gsd\google_structured_data::$local_business_parameters as $key){
			$data[$key] = get_option($key);
		}
		
		if (!$data['local_business_active']) return;
		$gsd_url = $data['website_url'];
		if (!$gsd_url || $data['default_website']){
			$gsd_url = get_site_url() . "/";
		}
		
		$images_schema = "";		
		
		if ($data['local_business_photos']){
			$images_schema = str_replace(',', '","', $images_schema);
			$images_schema = '"image": ["' . $data['local_business_photos'] . '"],';
		}
		
		$business_type = 'LocalBusiness';
		if ($data['local_business_type']){
			$business_type = $data['local_business_type'];
		}
		
		
		$business_name = $data['local_business_name'];
		if ($data['website_name_default']){
			$business_name = get_bloginfo('name');
		}
			
		$business_description = $data['local_business_description'];
		if ($data['local_business_description_default']){
			$business_description = get_bloginfo('description');
		}
		
		
		
		?>
		
	<script type="application/ld+json">
	{
	"@context": "https://schema.org",
	"@type": "<?php echo sanitize_text_field($business_type) ?>",
	"@id": "<?php echo esc_url($gsd_url) ?>",
	<?php echo $images_schema ?>

	"description": "<?php echo sanitize_text_field($business_description) ?>",
	"name": "<?php echo sanitize_text_field($business_name) ?>",
	"address": {
	"@type": "PostalAddress",
	<?php if ($data['local_business_address_country']): ?>
	"addressCountry": "<?php echo sanitize_text_field($data['local_business_address_country']) ?>",
	<?php endif; ?>
	"addressLocality": "<?php echo sanitize_text_field($data['local_business_address_locality']) ?>",
	"addressRegion": "<?php echo sanitize_text_field($data['local_business_address_region']) ?>",
	"postalCode": "<?php echo sanitize_text_field($data['local_business_postal_code']) ?>",
	"streetAddress": "<?php echo sanitize_text_field($data['local_business_street_address']) ?>"
	}
	<?php if ($data['local_business_geo_latitude'] && $data['local_business_geo_longitude']): ?>
	,"geo": {
	"@type": "GeoCoordinates",
	"latitude": <?php echo sanitize_text_field($data['local_business_geo_latitude']) ?>,
	"longitude": <?php echo sanitize_text_field($data['local_business_geo_longitude']) ?>
	}
	<?php endif; ?>
	<?php if ($data['local_business_telephone']): ?>
	,"telephone": "<?php echo filter_var($data['local_business_telephone'], FILTER_SANITIZE_NUMBER_INT) ?>"
	<?php endif; ?>
	}
	</script>
		<?php
		
	}
}

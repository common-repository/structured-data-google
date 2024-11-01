<?php
namespace gsdOrganiztion;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class organiztion {
	
	static function updateSettings(){
		
		if (!empty($_POST)){
			foreach (\gsd\google_structured_data::$organiztion_parameters as $key){
				$value = false;
				if ( isset($_POST[$key]) && $key != 'phones' ) $value = esc_sql($_POST[$key]);
				if ($key == 'phones'){
					if (empty($_POST['phones'])) $_POST['phones'] = '';
					$value = array();
					$counter = 0;
					if (!empty($_POST[$key])){
						foreach ($_POST[$key] as $phone_number){
							$phone_number = filter_var($phone_number, FILTER_SANITIZE_NUMBER_INT);
							if ($phone_number){						
								$value[] = array($_POST['phone_types'][$counter] => $phone_number);
								$counter++;
							}
						}
					}
					
					$value = json_encode( $value );
				}
				
				if ($key == 'website_url'){
					$value = esc_url($value);
				}
				
				update_option($key, $value );
			}
			echo '<h2>update success</h2><br>';
		}
		
	}



	static function settings_page() {
			
		\gsdOrganiztion\organiztion::updateSettings();
		
		$data = array();
		foreach (\gsd\google_structured_data::$organiztion_parameters as $key){
			$data[$key] = get_option($key);
		}
		$data['phones'] = json_decode($data['phones']);


	?>
		<h1><?php _e('Google Structured Data Settings', 'gsd'); ?></h1>
		<form method="post">
			<div class="row"><label><?php _e('Active', 'gsd') ?>: <input type="checkbox" value="1" name="gsd_active" <?php if ($data['gsd_active']) echo ' checked' ?>>
			</label></div>
			<div id="gsd-active"<?php if ($data['gsd_active']) echo ' class="active"' ?>>

				<div class="row"><label><?php _e('Website URL', 'gsd') ?>: <input type="text" name="website_url" value="<?php echo $data['website_url'] ?>" <?php if ($data['default_website']) echo ' readonly' ?>> <label><?php _e('Home URL', 'gsd') ?><input type="checkbox" value="1" name="default_website" <?php if ($data['default_website']) echo ' checked' ?>></label>
				</label></div>
				<div class="row">
					<?php if (is_object($data['phones'])) $data['phones'] = (array) $data['phones']; ?>
					<?php $data['phones'][] = array(''=>''); ?>
					<?php foreach ($data['phones'] as $phone): ?>
					<?php $phone = (array) $phone; ?>
					<?php if (!end($phone) && isset($second_empty_number) ) continue; ?>
					<?php if (!end($phone)) $second_empty_number = 1; ?>
						<div class="row">
							<select name="phone_types[]">
								<?php foreach (\gsd\google_structured_data::$organiztion_phone_types as $type): ?>
									<option<?php if (key($phone) == $type) echo ' selected' ?>><?php echo $type ?></option>
								<?php endforeach; ?>
							</select><input name="phones[]" type="text" value="<?php echo end($phone) ?>" placeholder="+972-052-555-1212">
						</div>
						
						
						
					<?php endforeach; ?>
					
				</div>
			</div>
			<div class="row"><label><button type="submit"><?php _e('Save', 'gsd') ?></button></label></div>
		</form>
		
		<?php
	}



	static function load_front_gsd_organization(){
		
		$data = array();
		
		foreach (\gsd\google_structured_data::$organiztion_parameters as $key){
			$data[$key] = get_option($key);
		}
		
		if (!$data['gsd_active']) return;
			
		$gsd_url = $data['website_url'];
		if (!$gsd_url || $data['default_website']){
			$gsd_url = get_site_url() . "/";
		}
		
		$phones = json_decode($data['phones']);
		
		$phones_schema = "";
		
		
		
		if ($phones && is_array($phones)){
			$next= "";
			foreach ($phones as $phone){
				$phone = (array) $phone;

				if ( key($phone) && end($phone) ){
					if (!$phones_schema){
						$phones_schema = '"contactPoint": [';
					}
					
					$phones_schema.= $next . '{ "@type": "ContactPoint",
					  "telephone": "'. end($phone) .'",
					  "contactType": "'. key($phone) .'"
					}';
					$next=",";
					
				}
			}
			  
			  if ($phones_schema){
				  $phones_schema.= ']';
			  }
			
		}
		
		?>
		
	<script type='application/ld+json'>
	{
	"@context": "http://schema.org",
	"@type": "Organization",
	"url": "<?php echo esc_url($gsd_url) ?>",
	<?php echo $phones_schema; ?>
	}
	</script>
		
		<?php
	}
}


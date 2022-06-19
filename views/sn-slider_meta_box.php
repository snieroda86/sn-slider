<?php 
$sn_slider_link_text = get_post_meta( $post->ID, 'sn_slider_link_text', true );
$sn_slider_link_url = get_post_meta( $post->ID, 'sn_slider_link_url', true );
 ?>

<table class="form-table sn-slider-metabox">
	<input type="hidden" name="sn_slider_nonce" value="<?php echo wp_create_nonce( 'sn_slider_nonce' )?>">
	<tr>
		<th>
			<label for="sn_slider_link_text">Link text</label>
		</th>
		<td>
			<input type="text" name="sn_slider_link_text" class="regular-text" id="sn_slider_link_text"  value="<?php echo (isset($sn_slider_link_text)) ? esc_html($sn_slider_link_text) : ''  ; ?>" required>
		</td>
	</tr>

	<tr>
		<th>
			<label for="sn_slider_link_url">Link url</label>
		</th>
		<td>
			<input type="url" name="sn_slider_link_url" class="regular-text" id="sn_slider_link_url"  value="<?php echo (isset($sn_slider_link_url)) ? esc_url( $sn_slider_link_url ) : '' ; ?>" required>
		</td>
	</tr>


</table>


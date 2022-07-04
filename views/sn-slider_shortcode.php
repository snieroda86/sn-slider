
<h3><?php echo(!empty($content)) ? esc_html($content) : esc_html( SN_Slider_Settings::$options['sn_slider_title'] );   ?></h3>

<div class="flexslider sn-slider <?php echo(isset( SN_Slider_Settings::$options['sn_slider_style'])) ? esc_attr(SN_Slider_Settings::$options['sn_slider_style']) : 'style-1';  ?>">
  <ul class="slides">
  	<?php 
  	$args = array(
  		'post_type' => 'sn_slider' ,
  		'post_status' => 'publish' ,
  		'post__in' => $id ,
  		'orderby' => $orderby
  	);

  	$slides_query = new WP_Query($args);
  	if($slides_query->have_posts()):
  		while ($slides_query->have_posts()) : $slides_query->the_post(); 
  			$button_text = get_post_meta( get_the_ID(), 'sn_slider_link_text', true );
  			$button_link = get_post_meta( get_the_ID(), 'sn_slider_link_url', true );
  			?>
  			 <li>
  			 	<?php 
          if(has_post_thumbnail()){
            the_post_thumbnail('full' , ['class'=> 'img-fluid']);   
          }else{ ?>
            <img src="<?php echo SN_SLIDER_URL.'assets/images/default.jpg' ?>" alt="Placeholder image" class="img-fluid wp-post-image">
          <?php } ?>
          
		      <div class="sns-container">
		      	<div class="sn-slide-details-container">
		      		<div class="wrapper">
		      			<div class="sn-slide-title">
		      				<h2 class="sn-slider-title">
		      					<?php the_title(); ?>
		      				</h2>
		      			</div>
		      			<div class="sn-slide-description">
		      				<div class="sn-slider-subtitle">
		      					<?php the_content(); ?>
		      				</div>
		      				<div class="sn-slider-link">
		      					<a class="sn-link" href="<?php echo esc_attr( $button_link ); ?>"><?php echo esc_html( $button_text );  ?></a>
		      				</div>
		      			</div>

		      		</div>
		      	</div>
		      </div>
		    </li>
  		<?php endwhile;
  		wp_reset_postdata();
  	endif;	
  	?>
   
  </ul>
</div>
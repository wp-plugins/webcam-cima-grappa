<?php

// Creating the widget 
class webcamcimagrappa_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			// Base ID of your widget
			'webcamcimagrappa_widget', 

			// Widget name will appear in UI
			__('Webcam Cima Grappa Widget', 'webcamcimagrappa_widget_domain'), 

			// Widget description
			array( 'description' => __( 'Webcam Cima Grappa Widget', 'webcamcimagrappa_widget_domain' ), ) 
		);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];

			$rnd = rand();
			
		?>
		
			<style>
				
				div.webcam_cima_grappa_slideshow {
					position:relative;
					height:350px;
				}

				div.webcam_cima_grappa_slideshow IMG {
					position:absolute;
					top:0;
					left:0;
					z-index:8;
					cursor:pointer;
				}

				div.webcam_cima_grappa_slideshow IMG.webcam_active {
					z-index:10;
				}

				div.webcam_cima_grappa_slideshow IMG.webcam_last_active {
					z-index:9;
				}
			
			</style>
			
		
			<div class='webcam_cima_grappa_slideshow'>
				<img src="http://www.meteocimagrappa.altervista.org/sacrario/cam.jpg?r=<?php echo $rnd ?>" data-link="http://www.cimagrappa.it/meteo/webcam.php" class='webcam_active' />
				<img src="http://www.meteocimagrappa.it/webcam/cam.jpg?r=<?php echo $rnd ?>" data-link="http://www.cimagrappa.it/meteo/webcam2.php" />
				<img src="http://www.meteocimagrappa.it/webcam/cam2.jpg?r=<?php echo $rnd ?>" data-link="http://www.cimagrappa.it/meteo/webcam4.php" />
				<img src="http://www.meteocimagrappa.it/webcam2/cam.jpg?r=<?php echo $rnd ?>" data-link="http://www.cimagrappa.it/meteo/webcam3.php" />
			</div>

			<a href='http://www.cimagrappa.it/meteo/' target="_blank">Meto cima grappa</a>
			
			<script>
			
				function webcamCimaGrappaSlideSwitch() {
				
		
					var $active = jQuery('div.webcam_cima_grappa_slideshow img.webcam_active');

					if ( $active.length == 0 ) $active = jQuery('div.webcam_cima_grappa_slideshow IMG:last');

					var $next =  $active.next().length ? $active.next()	: jQuery('div.webcam_cima_grappa_slideshow IMG:first');
				
					$active.addClass('webcam_last_active');
						
					$next.css({opacity: 0.0})
						.addClass('webcam_active')
						.animate({opacity: 1.0}, 1000, function() {
							$active.removeClass('webcam_active webcam_last_active');
						});

				}
				
				jQuery(function() {				
					jQuery('div.webcam_cima_grappa_slideshow').height( jQuery('div.webcam_cima_grappa_slideshow').width() * 0.7 + 20 );				
					setInterval( "webcamCimaGrappaSlideSwitch()", 5000 );
				});
				
				jQuery("div.webcam_cima_grappa_slideshow img").click(function() {
					window.open(jQuery(this).attr("data-link"));
				});
				
			
			</script>
		
		<?php

		echo $args['after_widget'];
	}
			
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Webcam Cima Grappa', 'webcamcimagrappa_widget_domain' );
		}
		// Widget admin form
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}
		
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
} // Class webcamcimagrappa_widget ends here

// Register and load the widget
function wpb_load_widget() {
	register_widget( 'webcamcimagrappa_widget' );
}

add_action( 'widgets_init', 'wpb_load_widget' );
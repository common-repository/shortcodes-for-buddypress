<?php
/**
 * BP Nouveau - Groups Directory
 *
 * @since 3.0.0
 * @version 3.0.0
 */
global $groups_atts;

$classes = array();
$group_loop_classes = static function () use ( $classes ) {
	$bp_nouveau = bp_nouveau();
	$classes[] = 'item-list';
	$classes[] = 'groups-list';
	$classes[] = 'bp-list';
	$component = sanitize_key( bp_current_component() );
	$bp_nouveau_appearance = get_option( 'bp_nouveau_appearance' );
	$groups_layout         = ( isset( $bp_nouveau_appearance['groups_layout'] ) && $bp_nouveau_appearance['groups_layout'] != '' ) ? $bp_nouveau_appearance['groups_layout'] : '3';

	if ( function_exists( 'bp_nouveau_customizer_grid_choices' ) ) {
		$customizer_option = sprintf( '%s_layout', $component );
		$layout_prefs      = bp_nouveau_get_temporary_setting(
			$customizer_option,
			bp_nouveau_get_appearance_settings( $customizer_option )
		);

		if ( $layout_prefs && (int) $layout_prefs > 1 && function_exists('bp_nouveau_customizer_grid_choices') ) {
			$grid_classes = bp_nouveau_customizer_grid_choices( 'classes' );

			if ( isset( $grid_classes[ $layout_prefs ] ) ) {
				$classes = array_merge( $classes, array(
					'grid',
					$grid_classes[ $layout_prefs ],
				) );
			}
			
			if ( ! isset( $bp_nouveau->{$component} ) ) {
				$bp_nouveau->{$component} = new stdClass;
			}
			// Set the global for a later use.
			$bp_nouveau->{$component}->loop_layout = $layout_prefs;
		}
	} else {
		$classes = array_merge(
			$classes,
			array(
				'grid',
				'three',
			)
		);
	}	

	return $classes;
};
add_filter( 'bp_nouveau_get_loop_classes', $group_loop_classes );
$loop_layout = !empty( $groups_atts['loop-layout'] ) ? $groups_atts['loop-layout'] : '';
?>

<div id="buddypress" class="bp-dir-hori-nav <?php echo esc_attr( bp_nouveau_get_container_classes() ) . ' ' . esc_attr( $groups_atts['container_class'] ); ?>">
	<div class="screen-content">
		<input type="hidden" data-bp-filter="groups" value="<?php echo esc_attr( $groups_atts['bpsh_query'] ); ?>" />
		<div id="groups-dir-list" class="groups dir-list" data-bp-list="groups" data-ajax="false">
			<?php if ( bp_has_groups( $groups_atts['bpsh_query'] ) ) : ?>
				<div class="bpsp-group-count">	
					<?php echo bp_get_groups_pagination_count(); ?>
				</div>
				<ul id="groups-list" class="grid 
				<?php
				bp_nouveau_loop_classes();
				echo ' ' . $loop_layout;
				?>
				">
					<?php
					while ( bp_groups() ) :
						bp_the_group();
						?>
						<li <?php bp_group_class( array( 'item-entry' ) ); ?> data-bp-item-id="<?php bp_group_id(); ?>" data-bp-item-component="groups">
							<div class="list-wrap">
								<?php
								$active_theme = wp_get_theme();
								if ( 'BuddyX' == $active_theme || 'BuddyxPro' == $active_theme ) {
									if ( function_exists( 'buddyx_render_group_cover_image' ) ) {
										buddyx_render_group_cover_image();
									}
								} elseif ( 'REIGN' == $active_theme ) {
									if ( function_exists( 'reign_render_group_cover_image' ) ) {
										reign_render_group_cover_image();
									}
								}
								?>
								<?php if ( ! bp_disable_group_avatar_uploads() ) : ?>
									<div class="item-avatar">
										<a href="<?php bp_group_url(); ?>"><?php bp_group_avatar( bp_nouveau_avatar_args() ); ?></a>
									</div>
								<?php endif; ?>
								<div class="item">
									<div class="item-block">
										<h2 class="list-title groups-title"><?php bp_group_link(); ?></h2>
										<?php if ( bp_nouveau_group_has_meta() ) : ?>
											<p class="item-meta group-details"><?php bp_nouveau_the_group_meta( array( 'keys' => array( 'status', 'count' ) ) ); ?></p>
										<?php endif; ?>
										<p class="last-activity item-meta">
											<?php
												printf(
													/* translators: %s: last activity timestamp (e.g. "Active 1 hour ago") */
													esc_html__( 'Active %s', 'shortcodes-for-buddypress' ),
													sprintf(
														'<span data-livestamp="%1$s">%2$s</span>',
														bp_core_get_iso8601_date( bp_get_group_last_active( 0, array( 'relative' => false ) ) ),
														esc_html( bp_get_group_last_active() )
													)
												);
											?>
										</p>

										<?php bp_nouveau_groups_loop_buttons(); ?>
									</div>

									<div class="group-desc"><p><?php bp_nouveau_group_description_excerpt(); ?></p></div>
									<?php bp_nouveau_groups_loop_item(); ?>
								</div>
							</div>
						</li>
					<?php endwhile; ?>
				</ul>
				<?php if ( $groups_atts['per_page'] ) { ?>
				<div class="bpsp-group-pagination">	
					<?php echo bp_get_groups_pagination_links(); ?>
				</div>
				<?php } ?>				
			<?php endif; ?>
		</div>
	</div>
</div>
<?php
<?php
/**
 * BuddyPress Members Directory
 *
 * @version 3.0.0
 */
global $members_atts;

$classes = array();
$member_loop_classes = static function () use ( $classes ) {

	$classes[] = 'item-list';
	$classes[] = 'members-list';
	$classes[] = 'bp-list';

	$bp_nouveau_appearance = get_option( 'bp_nouveau_appearance' );
	$members_layout        = ( isset( $bp_nouveau_appearance['members_layout'] ) && $bp_nouveau_appearance['members_layout'] != '' ) ? $bp_nouveau_appearance['members_layout'] : '3';

	if ( function_exists( 'bp_nouveau_customizer_grid_choices' ) ) {
		$grid_classes = bp_nouveau_customizer_grid_choices( 'classes' );
		if ( isset( $grid_classes[ $members_layout ] ) ) {
			$classes = array_merge(
				$classes,
				array(
					'grid',
					$grid_classes[ $members_layout ],
				)
			);
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
add_filter( 'bp_nouveau_get_loop_classes', $member_loop_classes );
$loop_layout = !empty( $members_atts['loop-layout'] ) ? $members_atts['loop-layout'] : '';

?>

<div id="buddypress" class="bp-dir-hori-nav <?php echo esc_attr( bp_nouveau_get_container_classes() ) . ' ' . esc_attr( $members_atts['container_class'] ); ?>">
	<?php bp_nouveau_before_members_directory_content(); ?>

	<?php if ( bp_has_members( $members_atts['bpsh_query'] ) ) : ?>
	<div id="members-dir-list" class="members dir-list" data-bp-list="members" data-ajax="false">
		<div class="bpsp-member-count">			
			<?php echo bp_get_members_pagination_count(); ?>
		</div>
		<ul id="members-list" class="<?php bp_nouveau_loop_classes(); ?>">		
			<?php
			while ( bp_members() ) :
				bp_the_member();
				?>
				<li <?php bp_member_class( array( 'item-entry' ) ); ?> data-bp-item-id="<?php bp_member_user_id(); ?>" data-bp-item-component="members">
					<div class="list-wrap">
						<?php
							$active_theme = wp_get_theme();
						if ( 'BuddyX' == $active_theme || 'BuddyxPro' == $active_theme ) {
							if ( function_exists( 'buddyx_render_member_cover_image' ) ) {
								buddyx_render_member_cover_image();
							}
						} elseif ( 'REIGN' == $active_theme ) {
							if ( function_exists( 'reign_render_member_cover_image' ) ) {
								reign_render_member_cover_image();
							}
						}
						?>
						<div class="item-avatar">
							<a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar( bp_nouveau_avatar_args() ); ?></a>
						</div>
						<div class="item">
							<div class="item-block">
								<h2 class="list-title member-name">
									<a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a>
								</h2>
								<?php if ( bp_nouveau_member_has_meta() ) : ?>
									<p class="item-meta last-activity">
										<?php bp_nouveau_member_meta(); ?>
									</p><!-- .item-meta -->
									<?php endif; ?>
									<?php if ( function_exists( 'bp_nouveau_member_has_extra_content' ) && bp_nouveau_member_has_extra_content() ) : ?>
										<div class="item-extra-content">
											<?php bp_nouveau_member_extra_content(); ?>
										</div><!-- .item-extra-content -->
									<?php endif; ?>
									<?php
									bp_nouveau_members_loop_buttons(
										array(
											'container'      => 'ul',
											'button_element' => 'button',
										)
									);
									?>
							</div>
						</div><!-- // .item -->
					</li>
				<?php endwhile; ?>
			</ul>
			<?php if ( $members_atts['per_page'] ) { ?>
			<div class="bpsp-member-pagination">			
				<?php echo bp_get_members_pagination_links(); ?>
			</div>
			<?php } ?>

			
		</div>
	<?php endif; ?>
</div>
<?php

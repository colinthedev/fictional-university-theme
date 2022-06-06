
<?php 

		get_header();

		while(have_posts()) {
				the_post();

					pageBanner(
						array(
							'subtitle' => 'single-program.php'
						),
							'something class1 class2'
					);
				?>

        <div class="container container--narrow page-section">
          <div class="metabox metabox--position-up metabox--with-home-link">
						<p>
							<a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program') ?>"><i class="fa fa-home" aria-hidden="true"></i>All Programs</a> <span class="metabox__main"><?php the_title(); ?></span>
						</p>
					</div>

          <div class="generic-content">
            <?php the_content(); ?>
          </div>

          <?php 
            $relatedProfessors = new WP_Query(array(
              'posts_per_page' => -1,
              'post_type' => 'professor',
              'orderby' => 'title',
              'order' => 'ASC',
              'meta_query' => array(
                array(
                  // related_programs is the custom field name 
                  'key' => 'related_programs',
                  'compare' => 'LIKE',
                  'value' => '"' . get_the_ID() . '"'
                )
              )
            ));

            if( $relatedProfessors->have_posts() ) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium"> '. get_the_title() . ' Professors </h2>';

            echo '<ul class="professor-cards">';
            while( $relatedProfessors->have_posts() ) {
            $relatedProfessors->the_post(); ?>
              <li class="professor-card__list-item">
                <a class="professor-card" href="<?php the_permalink(); ?>">
                  <img src="<?php the_post_thumbnail_url( 'professorLandscape' ); ?>" alt="" class="professor-card__image">
                  <span class="professor-card__name"><?php the_title(); ?></span>
                </a>
              </li>
            <?php }
            echo '</ul>';
            }

            wp_reset_postdata();

            $today = date( 'Ymd' );
            $homepageEvents = new WP_Query(array(
              'posts_per_page' => 2,
              'post_type' => 'event',
              'meta_key' => 'event_date',
              'orderby' => 'meta_value_num',
              'order' => 'ASC',
              'meta_query' => array(
                array(
                  'key' => 'event_date',
                  'compare' => '>=',
                  'value' => $today,
                  'type' => 'numeric'
                ),
                array(
                  // related_programs is the custom field name 
                  'key' => 'related_programs',
                  'compare' => 'LIKE',
                  'value' => '"' . get_the_ID() . '"'
                )
              )
            ));

            if( $homepageEvents->have_posts() ) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium"> Upcomming '. get_the_title() . ' Events </h2>';

            while( $homepageEvents->have_posts() ) {
            $homepageEvents->the_post(); ?>
              <div class="event-summary">
                <a class="event-summary__date t-center" href="#">
                  <span class="event-summary__month">
                  <?php
                    $eventDate = new DateTime(get_field( 'event_date' ));
                    echo $eventDate->format('M');
                  ?>
                  </span>
                  <span class="event-summary__day">
                  <?php
                    echo $eventDate->format('d');
                  ?>
                  </span>
                </a>
                <div class="event-summary__content">
                  <h5 class="event-summary__title headline headline--tiny">
                    <a href="<?php the_permalink(); ?>">
                  <?php the_title(); ?></a>
                  </h5>
                  <?php has_excerpt() ? the_excerpt() : wp_trim_words(get_the_content(), 18) ?>
                  <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a>
                </div>
              </div>
            <?php }
            }
          ?>

        </div>
		<?php }

		get_footer();
?>

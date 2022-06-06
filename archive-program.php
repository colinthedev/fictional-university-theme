<?php 

get_header();

pageBanner(
	array(
	'title' => 'All Programs',
	'subtitle' => 'archive-program.php',
	'backgroundPhoto' => get_field('page_banner_background_image'), 
	),
	'something class1 class2'
);

?> 

<div class="container container--narrow page-section">

<ul class="link-list min-list">
  <?php 
    while(have_posts()) {
      the_post(); ?>
      <li><a href="<?php the_permalink(); ?>"><?php  the_title(); ?></a></li>
    <?php }

    echo paginate_links();
  ?>
</ul>

</div>

<?php get_footer();

?>
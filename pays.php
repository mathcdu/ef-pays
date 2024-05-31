<?php

/**
 * Plugin Name: Pays
 * Description: Filter posts by country.
 * Version: 1.0
 * Author: Your Name
 */

function pays_enqueue_scripts()
{
  wp_enqueue_script('pays-script', plugin_dir_url(__FILE__) . 'pays.js', array('jquery'), null, true);
  wp_localize_script('pays-script', 'pays_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'pays_enqueue_scripts');

function pays_filter_posts()
{
  $country = sanitize_text_field($_POST['country']);

  $args = array(
    'post_type' => 'post',
    's' => $country,
  );

  $query = new WP_Query($args);

  if ($query->have_posts()) {
    while ($query->have_posts()) {
      $query->the_post();
?>
      <article>
        <h2><?php the_title(); ?></h2>
        <div><?php the_excerpt(); ?></div>
      </article>
<?php
    }
  } else {
    echo 'No posts found.';
  }

  wp_reset_postdata();
  wp_die();
}
add_action('wp_ajax_nopriv_pays_filter_posts', 'pays_filter_posts');
add_action('wp_ajax_pays_filter_posts', 'pays_filter_posts');
?>
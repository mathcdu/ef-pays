<?php

/**
 * Nom du Plugin: Pays
 * Description: Filtrer articles par pays.
 * Version: 1.0
 * Auteur: Mathieu Croteau-Dufour
 */

function pays_enqueue_scripts()
{
  wp_enqueue_script('pays-script', plugin_dir_url(__FILE__) . 'js/pays.js', array('jquery'), null, true);
  wp_localize_script('pays-script', 'pays_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'pays_enqueue_scripts');

// Filtrer les articles
function filtre_pays()
{
  $pays = sanitize_text_field($_POST['pays']);

  $args = array(
    'post_type' => 'post',
    's' => $pays,
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
    echo 'Aucun article trouvé.';
  }

  wp_reset_postdata();
  wp_die();
}
add_action('wp_ajax_nopriv_filtre_pays', 'filtre_pays');
add_action('wp_ajax_filtre_pays', 'filtre_pays');

// Fonction pour Shortcode
function afficher_pays_bouttons()
{
  ob_start(); ?>
  <div id="pays_bouttons">
    <?php
    $pays = ["France", "États-Unis", "Canada", "Argentine", "Chili", "Belgique", "Maroc", "Mexique", "Japon", "Italie", "Islande", "Chine", "Grèce", "Suisse"];
    foreach ($pays as $pays) {
      echo '<button class="pays_bouton" data-pays="' . $pays . '">' . $pays . '</button>';
    }
    ?>
  </div>
  <div id="posts-container"></div>
<?php
  return ob_get_clean();
}
add_shortcode('pays_button', 'afficher_pays_bouttons');
?>
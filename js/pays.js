jQuery(document).ready(function ($) {
  $('.pays_bouton').on('click', function () {
    var pays = $(this).data('pays');

    $.ajax({
      url: pays_ajax.ajax_url,
      type: 'post',
      data: {
        action: 'filtre_pays',
        pays: pays
      },
      success: function (response) {
        $('#posts-container').html(response);
      }
    });
  });

  $('.pays_bouton[data-pays="France"]').click();
});

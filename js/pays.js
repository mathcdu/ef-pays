jQuery(document).ready(function ($) {
  $('.country-button').on('click', function () {
    var country = $(this).data('country');

    $.ajax({
      url: pays_ajax.ajax_url,
      type: 'post',
      data: {
        action: 'pays_filter_posts',
        country: country
      },
      success: function (response) {
        $('#posts-container').html(response);
      }
    });
  });

  // Trigger the AJAX call for France when the page loads
  $('.country-button[data-country="France"]').click();
});

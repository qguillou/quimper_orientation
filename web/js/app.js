$(document).ready(function() {
  $(".selLabel").click(function () {
      console.log("ok");
    $(this).parent().toggleClass('active');
  });

  $(".dropdown-custom .dropdown-custom-list li").click(function() {
    $('.selLabel').text($(this).text());
    $('.dropdown-custom').removeClass('active');
    $('.selected-item p span').text($('.selLabel').text());
    console.log("test");
  });
});

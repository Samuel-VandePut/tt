// jQuery to collapse the navbar on scroll
function collapseTopLine() {
    if ($(".navbar").offset().top > 50) {
        $(".top-line").addClass("hidden");
    } else {
        $(".top-line").removeClass("hidden");
    }
}

// Carousel Auto-Cycle
$(document).ready(function() {
$('.carousel').carousel({
  interval: 6000
})
});

$('.carousel').carousel({
   interval: 3000
})

$(window).scroll(collapseTopLine);
$(document).ready(collapseTopLine);
/*$(window).scroll(function(){
    $(".top-line").css("opacity", 1 - $(window).scrollTop() / 250);
  });*/

 $('#carousel-example-generic').on('fade', '', function() {
  var $this = $(this);

  $this.find('.main-text').show();

  /*if($('.carousel-inner .item:first').hasClass('active')) {
    $this.children('.left.carousel-control').hide();
  } else if($('.carousel-inner .item:last').hasClass('active')) {
    $this.children('.right.carousel-control').hide();
  }*/

});
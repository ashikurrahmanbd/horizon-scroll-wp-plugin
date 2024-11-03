(function($) {

    $(document).ready(function() {
        
        //add a listener for scroll
        $(window).scroll(() => {
            //get total height
            let docHeight = $("body").height();
  
            //get window height
            let winHeight = $(window).height();
  
            //calculate the view port
            let viewport = docHeight - winHeight;
  
            //get current scroll position
            let scrollPos = $(window).scrollTop();
  
            //get current scroll percent
            let scrollPercent = (scrollPos / viewport) * 100;
  
            //add the percent to the top progress bar
            $(".indicator").css("width", scrollPercent + "%");
        });
          

    });
})(jQuery);
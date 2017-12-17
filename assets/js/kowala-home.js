jQuery(document).ready(function ($) {


    /************ INIT *************/
    
    

    

    var ImagesTransitionTime = 550;
    var lastWindowWidth = $(window).width();
 
    
    function sliderInit() {
        
        $('.paysHomeSlide:eq(0)').addClass('currentSlide');
    }
    sliderInit();
    
    function homePaysDisplay(){
        
        $('.paysHomeSlide').width( $('.paysHomeWrapper').width() );
        
    }
    homePaysDisplay();


    function sliderGoto(img_index, directionStr){
        
        
        
        
        // gere le marqueur de l'image courante:
        $('.currentSlide').removeClass('currentSlide');
        
        var slideToGo = $('.paysHomeSlidesWrapper > .paysHomeSlide:eq(' + img_index + ')');
        slideToGo.addClass('currentSlide');
        
        // gere les bullets
        $('.bulletsWrapper > .bullet.current').removeClass('current');
        $('.bulletsWrapper > .bullet:eq(' + img_index + ')').addClass('current');
        
        // on fait glisser
        $('.paysHomeSlidesWrapper').stop(false, false).animate( {left: -slideToGo.position().left }, ImagesTransitionTime);
            
    }


    $('.paysHomeNextSlide').click(function() {

        var toGo = $('.currentSlide').index() + 1;
        var nbImages = $('.paysHomeSlide').length;
        
        if( toGo === nbImages ){
            toGo = 0;
        }
        sliderGoto(toGo, 'next');
        
    });
    
    $('.paysHomePrevSlide').click(function() {

        var toGo = $('.currentSlide').index() - 1;
        var nbImages = $('.paysHomeSlide').length;

        if( toGo === -1 ){
            toGo = nbImages-1;
        }
        sliderGoto(toGo, 'prev');
        
    });
    
    $('.bulletsWrapper > a').click(function(){
		
		sliderGoto( $(this).index('.bulletsWrapper > a') , 'next');
		return false;
    });

    /************ see more button *************/
    
    $('.seeMorePays a').click(function(){
        $('.paysHomeSlidesWrapper').css('height', 'auto');
        $(this).fadeOut();
        return false;
    });

    /************ ON RESIZE *************/
    
    $(window).resize(function() {
        
        if( lastWindowWidth !== $(window).width() ){
            sliderGoto(0, 'prev');
            lastWindowWidth = $(window).width();
        }
        homePaysDisplay();
        
        
    });
    
    
    /************  *************/
    
    
});
jQuery(document).ready(function ($) {


    $('.menu-toggle').click(function(){
		
		//$('#leftMenuWrapper').stop(true,true).slideToggle(330);
                $('body').toggleClass('leftMenuOpened');
                
		return false;
    });
    
    $('.wrapper, .menu-close').click(function(){
        
        if( $('body').hasClass('leftMenuOpened') ){
            $('body').toggleClass('leftMenuOpened');
            return false;
        }
    });
    
    
    
    
    
    /**************  Promo bandeau rollOver **************/
    
    var defaultTitleBandeau = $('.bandeauPromo .titleBandeau').html();
    
    $('.promoIconsList li a').mouseover(function(){
        $('.bandeauPromo .titleBandeau').html( $(this).find('.text').html() );
    });
    $('.promoIconsList li a').mouseout(function(){
        $('.bandeauPromo .titleBandeau').html( defaultTitleBandeau );
    });
    
    
    /**************  static sidebar **************/
    
    

                        
                        
            
    function staticSidebar() {
        
        if ($('#sidebar').length !== 0) {
            

            var sidebarHeight = $('#sidebar .sidebar-inner').height();

            if( ( sidebarHeight  < $('#main').height() ) 
                    && ( $(window).scrollTop() > $('#sidebar').position().top )  
                    && ( $(window).width() > 992 )  ){

                var mainPositionBottom = $('#main').position().top + $('#main').height();
                if( $(window).scrollTop() >=  ( mainPositionBottom - sidebarHeight) ){
                    //$('#sidebar .sidebar-inner').removeClass('fixed');
                    
                    //var distance =   $(window).scrollTop() - $('#sidebar').position().top;
                    var distance =  (mainPositionBottom - sidebarHeight) -  $(window).scrollTop() ;
                    $('#sidebar .sidebar-inner').css('top', distance);
                }
                else {
                    $('#sidebar .sidebar-inner').addClass('fixed');
                    
                    $('#sidebar .sidebar-inner').css('top', '0');
                    
                }

            }
            else {
                $('#sidebar .sidebar-inner').removeClass('fixed');
                $('#sidebar .sidebar-inner').css('top', 0);
            }
        }
    }
    
    staticSidebar();
    
    
    /**************  links list select **************/
    
        if ($('.linksListWrapper').length !== 0) {
            
            $('.linksListWrapper a.selectedItem').click(function(){
                $(this).parent().toggleClass('open');
                return false;
            });
            
            $('.linksListWrapper').mouseleave(function(){
                $(this).removeClass('open');
            });
            
        }
        
        
        
  
    
    
    
    
    /************ ON SCROLL *************/
    
    $(window).scroll(function() {
        staticSidebar();
    });
    
    

});
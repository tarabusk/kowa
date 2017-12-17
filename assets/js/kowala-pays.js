jQuery(document).ready(function ($) {

//console.dir(pbd_alp);
        
 // The number of the next page to load (/page/x/).
	var pageNum = parseInt(pbd_alp.startPage) + 1;
	
	// The maximum number of pages the current query can return.
	var max = parseInt(pbd_alp.maxPages);
	
	// The link of the next page of posts.
	var nextLink = pbd_alp.nextLink;
	
	/**
	 * Replace the traditional navigation with our own,
	 * but only if there is at least one page of new posts to load.
	 */
        /*
	if(pageNum <= max) {
		// Insert the "More Posts" link.
		$('#content')
			.append('<div class="pbd-alp-placeholder-'+ pageNum +'"></div>')
			.append('<p id="pbd-alp-load-posts"><a href="#">Load More Posts</a></p>');
			
		// Remove the traditional navigation.
		$('.navigation').remove();
	}
	*/
	
	/**
	 * Load new posts when the link is clicked.
	 */
	$('.navigation.col-sm-12 a').click(function() {
	
		
		$(this).text('Chargement...');
			$('.paysPostsListTmp').html(' ');
                        var urlToLoad = $(this).attr('href');
			$('.paysPostsListTmp').load( urlToLoad + ' .postInList, .navigation',
				function() {
                                    var isNextPage = 0;
                                    if ( $(this).find('.navigation a').length ) {
                                        console.log('ppp' + urlToLoad);
                                        var newUrl = $(this).find('.navigation a').attr('href');
                                        $('.paysPostsList .navigation.col-sm-12 a').attr('href', newUrl );
                                        $(this).find('.navigation').remove();
                                        isNextPage = 1;
                                    }
                                    
                                    //console.log(newUrl);
                                    
					
                                     $('.paysPostsList .navigation.col-sm-12').before( $('.paysPostsListTmp').html() );
                                     $(this).html('');
                                    if ( isNextPage === 1 ) { 
                                        $('.paysPostsList .navigation.col-sm-12 a').text('Plus d\'articles');
                                    }
                                    else {
                                        $('.paysPostsList .navigation.col-sm-12').remove();
                                    }
				}
			);
			
		
		return false;
	});

    

});
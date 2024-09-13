jQuery(function($){
    
    if($('body').hasClass('woocommerce-page')){
        //Do not Init Infinite Scroll
    } else {
        if(aleloadmore.maxpage > 1) {
            $('.archive_blog_page').append('<div class="news__footer archive_page load-more"><span class="news__btn main-btn"><div class="main-btn__name"><p>' + aleloadmore.button_text + '</p></div></span></div>');
        }
        var button = $('.archive_blog_page .load-more');
        var page = 2;
        var loading = false;

        $('body').on('click', '.load-more', function () {


            if (!loading) {
                loading = true;
                var data = {
                    action: 'ale_ajax_load_more',
                    nonce: aleloadmore.nonce,
                    page: page,
                    query: aleloadmore.query,
                };
                $.post(aleloadmore.url, data, function (res) {
                    if (res.success) {

                        var $content = $(res.data);
                        $('.archive_blog_page .news__list').append($content)
                        $('.archive_blog_page').append(button);

                        //Hide the Load More button if no more posts to load
                        
                        if (page == aleloadmore.maxpage) {
                            button.hide();
                            console.log('test');
                        }
                        page = page + 1;
                        loading = false;

                    } else {

                    }
                }).fail(function (xhr, textStatus, e) {

                });
            }

        });
    }
});
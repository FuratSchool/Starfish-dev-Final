(function ($){
    $.fn.navigation = function(angularScope){
        var navigation = this;
        navigation.angularScope = angularScope;
        navigation.page = 1;

        navigation.showPage = function(pageNumber){
            navigation.page = pageNumber;

            navigation.angularScope.viewPage(pageNumber);

            navigation.generateHTML();
        };

        navigation.generateHTML = function(pages, page){
            pages = typeof pages !== 'undefined' ? pages : 1;
            navigation.page = page;

            // Generate HTML
            var html = '';
            // first caret
            html += navigation.btnBuilder('&laquo;', navigation.page === 1, 'prevPage');

            // first page
            html += navigation.btnBuilder(1, navigation.page === 1);

            // page divider
            if(navigation.page - 4 > 1){
                html += navigation.btnBuilder('&nbsp;', true); // tell that there are more to the left
            } else if(navigation.page - 3 > 1) {
                html += navigation.btnBuilder(2, false); // or show the page if it's the actual one
            }


            /* Middle pages */
            for(var pg = navigation.page - 2; pg <= navigation.page + 2; pg++){
                if(pg <= 1 || pg >= pages) continue;
                html += navigation.btnBuilder(pg, pg === navigation.page);
            }
            /**/

            // page divider
            if(navigation.page + 4 < pages) {
                html += navigation.btnBuilder('&nbsp;', true); // tell that there are more
            } else if(navigation.page + 3 < pages){
                html += navigation.btnBuilder(pages-1, false); // tell that there are more
            }

            // last page
            if(pages !== 1) html += navigation.btnBuilder(pages, navigation.page === pages);

            // last caret
            html += navigation.btnBuilder('&raquo;', navigation.page === pages, 'nextPage');
            navigation.html(html);

            // Link events to the HTML
            navigation.find(".pageNr").click(function(event){
                navigation.angularScope.viewPage($(this).data("pagenr"));
            });

            if(page > 1) {
                navigation.find(".prevPage").click(function (event) {
                    navigation.angularScope.viewPage(page - 1);
                });
            }

            if(page < pages) {
                navigation.find(".nextPage").click(function (event) {
                    navigation.angularScope.viewPage(page + 1);
                });
            }

            navigation.find("[data-pagenr='"+page+"']").removeClass('disabled').addClass('active');
        };

        navigation.btnBuilder = function(nr, disabled, clazz){
            clazz = typeof clazz !== 'undefined' ? clazz : '';
            var liClasses = clazz+''+((disabled)?' disabled':'')+((clazz === '')?' pageNr':'');
            return '<li class="'+liClasses+'" data-pagenr="'+nr+'"><span>'+nr+'</span></li>';
        };


        return this;
    }
}(jQuery));




// Deze class moet paginanummers genereren en hier een functie aan linken.
// functie maken die de juiste HTML genereert
// functie genaamd "showPage(pagenummer)"
// functie voor volgende en vorige pagina.



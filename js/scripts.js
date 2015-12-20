$(function() {
    
    var LOCALSTORAGE_PAGES_SHORT_KEY = 'k_LOCALSTORAGE_PAGES_SHORT_KEY'
    var LOCALSTORAGE_PAGES_LONG_KEY = 'k_LOCALSTORAGE_PAGES_LONG_KEY'
    
    function loadData(short) {
        return (
            JSON.parse(
                localStorage.getItem(
                    short ? LOCALSTORAGE_PAGES_SHORT_KEY : LOCALSTORAGE_PAGES_LONG_KEY
                )
            ) || []
        );
    }
    
    Array.prototype.saveAsData = function(short) {
        return localStorage.setItem(
            short ? LOCALSTORAGE_PAGES_SHORT_KEY : LOCALSTORAGE_PAGES_LONG_KEY,
            JSON.stringify(this) || []
        );
    }
    
    function init() {
        refreshList();
    }
    
    function isPageUpToDate(page) {
        return getHash(getPageWithId(page.id, true)) === getHash(page);
    }
    
    function getHash(page) {
        if (typeof page === 'string') {
            var hash = 0;
            if (page.length == 0) return hash;
            for (i = 0; i < page.length; i++) {
                char = page.charCodeAt(i);
                hash = ((hash<<5)-hash)+char;
                hash = hash & hash; // Convert to 32bit integer
            }
            return hash;
        } else {
            return page ? page.hash : '';
        }
    }
    
    function getPageWithId(pageID, short) {
        return loadData(short)
        .filter(function(p) {
            return p.id === pageID;
        })
        .pop();
    }
    
    function setPageChecked(page) {
        loadData()
        .map(function(p) {
            if (p.id === page.id) {
                return getPageWithId(page.id, true);
            }
            return p;
        }).saveAsData();
        refreshList();
    }
    
    function refreshList() {
        $pages = $('#pages-tbody').html('');
        
        loadData()
        .map(function(page) {
            $('<tr />')
            .addClass(isPageUpToDate(page) ? 'success' : 'error')
            .append(
                $('<td />')
                .text(page.name)
            )
            .append(
                $('<td />')
                .text(isPageUpToDate(page) ? 'OK' : 'CHANGED')
            )
            .append(
                $('<td />')
                .append(
                    $('<a />')
                    .addClass('btn')
                    .text('Remove page')
                    .click(function() {
                        loadData().filter(function(p) {
                            return p.id !== page.id;
                        }).saveAsData();
                        refreshList();
                    })
                )
                .append(
                    isPageUpToDate(page) ? '' :
                        $('<a />')
                        .addClass('btn btn-danger')
                        .click(function() {
                            setPageChecked(page);
                        })
                        .text('Set page as checked')
                )
            )
            .appendTo($pages);
            return page;
        });
    }
    
    function addPage(name, url) {
        var id = new Date().getTime();
        loadData()
        .concat([{
            'name': name,
            'url': url,
            'id': id
        }])
        .saveAsData();
        
        loadData(true)
        .concat([{
            'name': name,
            'url': url,
            'id': id
        }])
        .saveAsData(true);
        refreshList();
    }
    
    $("#add-page-to-list").click(function() {
        var name = prompt('Name of the page');
        var url = prompt('URL of the page');
        if (name && url) {
            addPage(name, url);
        }
    });
    
    $("#update-list").click(function() {
        loadData(true)
        .map(function(page) {
            var url = 'https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20html%20where%20url%3D%22' + encodeURIComponent(page.url) + '%22&format=json&callback=?';
            $.getJSON(url, function(response) {
                page.hash = getHash(JSON.stringify(response.query.results));
                loadData(true)
                .map(function(p) {
                    if (p.id == page.id) {
                        return page;
                    }
                    return p;
                })
                .saveAsData(true);
                refreshList();
            });
        })
    });
    
    
    init();
});

$(document).ready(function () {
    var searchSchedule = undefined;
    var previousSearch = '';
    const TYPING_WAIT = 500;

    $('.search-box').click(function () {
        $(this).find('input').focus();
    });

    $('.search-box #search').keyup(function () {
        $('.search-box #search').removeClass('active-search');
        $(this).addClass('active-search');
        if (searchSchedule) {
            clearTimeout(searchSchedule);
        }
        searchSchedule = setTimeout(searchRequest, TYPING_WAIT);
    });

    function searchRequest() {
        const search = $('.search-box #search.active-search').val().trim();
        console.log('search initiated for keyword ' + search);
        // call search API
    }
});
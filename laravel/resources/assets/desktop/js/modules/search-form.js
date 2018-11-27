$('.search-form').submit(function () {

    var searchText = $(this).find('input[name="search_text"]').val();


    location.href = '/search/'+searchText;

    return false;
});

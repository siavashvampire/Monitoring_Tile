var options = {page: 1,perEachPage : 25};
var searchIn = '';
var searchLink = '';
function load() {
    $.ajax({
        url: searchLink,
        type: 'post',
        dataType: 'html',
        data: options,
        success: function (html) {
            if (html) {
                var result = $('<div />').append(html).find(searchIn).html();
                $(searchIn).html(result).selectpicker('refresh');
                $('.selectpicker').selectpicker('refresh');
            }
        }
    });
}

function navigatePage(link ,searchInDiv , page) {
    searchIn = searchInDiv ;
    searchLink = link ;
    optionsSearch = $( searchIn+'Form' ).serializeArray();
    jQuery.each( optionsSearch, function( i, field ) {
        options[field.name] = field.value ;
    });
    options.page = page;
    load();
}

function perEachPage(link ,searchInDiv , perEachPae) {
    searchIn = searchInDiv ;
    searchLink = link ;
    optionsSearch = $( searchIn+'Form' ).serializeArray();
    jQuery.each( optionsSearch, function( i, field ) {
        options[field.name] = field.value ;
    });
    options.perEachPage = perEachPae;
    options.page = 1;
    load();
}

function setPageAndPerEach(link ,searchInDiv , page , perEachPae) {
    searchIn = searchInDiv ;
    optionsSearch = $( searchIn+'Form' ).serializeArray();
    jQuery.each( optionsSearch, function( i, field ) {
        options[field.name] = field.value ;
    });
    searchLink = link ;
    options.perEachPage = perEachPae;
    options.page = page;
}


$('#closeSearch').on('click', function () {
    $(searchIn+'Form').trigger("reset");
    optionsSearch = $( searchIn+'Form' ).serializeArray();
    jQuery.each( optionsSearch, function( i, field ) {
        options[field.name] = field.value ;
    });
    options.page = 1;
    load();
});
function reloadTableData() {
    optionsSearch = $( searchIn+'Form' ).serializeArray();
    jQuery.each( optionsSearch, function( i, field ) {
        options[field.name] = '' ;
    });
    options.page = 1;
    load();
}
function search(link ,searchInDiv ) {
    searchIn = searchInDiv ;
    searchLink = link ;
    optionsSearch = $( searchIn+'Form' ).serializeArray();
    jQuery.each( optionsSearch, function( i, field ) {
        var  name = field.name ;
        if ( name.includes("[]") ){
            name = name.replace("[]", "");
            if ( typeof options[name] == "undefined" ){
                options[name] = [];
            }
            options[name].push(field.value);
        } else {
            options[field.name] = field.value;
        }
    });
    options.page = 1;
    load();
    //options = {page: 1,perEachPage : options.perEachPage};


    return false ;
}
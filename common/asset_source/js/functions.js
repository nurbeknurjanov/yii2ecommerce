function implode( glue, pieces ) {
    return ( ( pieces instanceof Array ) ? pieces.join ( glue ) : pieces );
}

function in_array(needle, haystack, strict) {	// Checks if a value exists in an array
    //
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)

    var found = false, key, strict = !!strict;

    for (key in haystack) {
        if ((strict && haystack[key] === needle) || (!strict && haystack[key] == needle)) {
            found = true;
            break;
        }
    }

    return found;
}


function str_replace ( search, replace, subject ) {	// Replace all occurrences of the search string with the replacement string
    //
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Gabriel Paderni

    if(!(replace instanceof Array)){
        replace=new Array(replace);
        if(search instanceof Array){//If search	is an array and replace	is a string, then this replacement string is used for every value of search
            while(search.length>replace.length){
                replace[replace.length]=replace[0];
            }
        }
    }

    if(!(search instanceof Array))search=new Array(search);
    while(search.length>replace.length){//If replace	has fewer values than search , then an empty string is used for the rest of replacement values
        replace[replace.length]='';
    }

    if(subject instanceof Array){//If subject is an array, then the search and replace is performed with every entry of subject , and the return value is an array as well.
        for(k in subject){
            subject[k]=str_replace(search,replace,subject[k]);
        }
        return subject;
    }

    for(var k=0; k<search.length; k++){
        var i = subject.indexOf(search[k]);
        while(i>-1){
            subject = subject.replace(search[k], replace[k]);
            i = subject.indexOf(search[k],i);
        }
    }

    return subject;

}

function strip_tags( str ){	// Strip HTML and PHP tags from a string
    //
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)

    return str.replace(/<\/?[^>]+>/gi, '');
}


function countProperties(obj) {
    var count = 0;

    for(var prop in obj) {
        if(obj.hasOwnProperty(prop))
            ++count;
    }

    return count;
}

/*
var fruits = ["Banana", "Orange", "Apple", "Mango"];
var energy = fruits.join(',');
*/

var numbers = [1,2,3];
numbers =$.map(numbers , function (value) {
    return value*2;
});


$.urlParam = function(name, url){
    if (url == undefined)
        url = window.location.href;
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(url);
    return results[1] || 0;
}

function updateQueryStringParameter(uri, key, value) {
    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    var separator = uri.indexOf('?') !== -1 ? "&" : "?";
    if (uri.match(re)) {
        return uri.replace(re, '$1' + key + "=" + value + '$2');
    }
    else {
        return uri + separator + key + "=" + value;
    }
}


function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

function setCookie(name, value, options) {
    options = options || {};

    var expires = options.expires;

    if (typeof expires == "number" && expires) {
        var d = new Date();
        d.setTime(d.getTime() + expires * 1000);
        expires = options.expires = d;
    }
    if (expires && expires.toUTCString) {
        options.expires = expires.toUTCString();
    }

    value = encodeURIComponent(value);

    var updatedCookie = name + "=" + value;

    for (var propName in options) {
        updatedCookie += "; " + propName;
        var propValue = options[propName];
        if (propValue !== true) {
            updatedCookie += "=" + propValue;
        }
    }

    document.cookie = updatedCookie;
}

function deleteCookie(name) {
    setCookie(name, "", {
        expires: -1
    })
}




var iteration = 1;
var isDown = false;
var mousedownTimeout;
function getIncrement(iteration){
    var increement = 50;

    if(iteration >= 3)
        increement = 100;

    if(iteration >= 9)
        increement = 1000;

    if(iteration >= 27){
        increement = 10000;
    }
    return  increement;
}
function mousePress(obj, func) {
    // запрет навешивания нескольких обработчиков одного события на один объект
    obj.unbind('mousedown');
    obj.unbind('mouseup');
    obj.unbind('mouseleave');
    obj.bind('mousedown', function() {
        isDown = true;
        mousedownTimeout = setTimeout(func, 50);
    });

    obj.bind('mouseup', function() {
        isDown = false;
        iteration = 1;
        clearTimeout(mousedownTimeout);
    });

    obj.bind('mouseleave', function() {
        isDown = false;
        iteration = 1;
        clearTimeout(mousedownTimeout);
    });
}
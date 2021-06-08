var $ = require('jquery');

$(function() {
    console.log('launched')
    var breakPointPC = 768;
    var windowWidth = $(window).width();
    if(windowWidth > breakPointPC) {
        console.log('pc view')
    }
}) 

function nav(){
    $('div#nav ul li').mouseover(function() {
        $(this).find('ul:first').show();
    });

    $('div#nav ul li').mouseleave(function() {
        $('div#nav ul li ul').hide();
    });

    $('div#nav ul li ul').mouseleave(function() {
        $('div#nav ul li ul').hide();;
    });
};

$(document.body).ready(function() {
    nav();
});

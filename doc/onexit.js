window.addEventListener("unload", function(){
    $.ajax({
        method: "POST",
        url: "exit.php",
        data: { href: $(".img_name").attr("name") }
    }).done(function( response ) {});
});
function cacher()
{
	$(".expand").hide();
}

$(document).ready( function() {
	
    var expanders = new Array($(".expander").size());
    
    for ( i = 0 ; i < expanders.length ; i++ )
    {
        expanders[i] = $(".expander")[i].value;
    }
    
    $(".expander").click( function()
    {
        var nb_btns = document.getElementsByClassName("expand").length;
        var i = 0;
        
        for ( i = 0 ; i < nb_btns ; i++ )
        {
            if ( document.getElementsByClassName("expander")[i].value == this.value && !$(document.getElementsByClassName("expand")[i]).hasClass("cache") )
            {
                $(document.getElementsByClassName("expand")[i]).addClass("cache");
                $(document.getElementsByClassName("expand")[i]).hide();
                $(this).val("Montrer le code");
            }
            else if ( document.getElementsByClassName("expander")[i].value == this.value && $(document.getElementsByClassName("expand")[i]).hasClass("cache") )
            {
                $(document.getElementsByClassName("expand")[i]).removeClass("cache");
                $(document.getElementsByClassName("expand")[i]).show();
                $(this).val("Cacher le code");
            }
        }
    });
    
    var compteur = setTimeout("cacher()", 100);
});
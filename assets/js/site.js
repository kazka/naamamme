$(document).ready(function(){

     $('form.destroy-form').on('submit', function(submit){
        var confirm_message = $(this).attr('data-confirm');

        if(!confirm(confirm_message)){
            submit.preventDefault();
        }
    });

    // haku
    $("#haku").on("keyup change", function() {
        var hakusana = this.value.toLowerCase();
        $("div.naama-etusivu").each(function() {
            var haettavaNick = $(this).find('.naama-nick').text().toLowerCase();
            var haettavaNimi = $(this).find('.naama-nimi').text().toLowerCase();
            if (haettavaNick.indexOf(hakusana) < 0 && haettavaNimi.indexOf(hakusana) < 0 ) {
                $(this).hide();
            } else {
                $(this).show();
            }
        });
    });

});

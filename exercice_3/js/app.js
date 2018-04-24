$( document ).ready(function() {
    // console.log( "ready!" );
    
    $('input[type="submit"]').click(function(e){
        e.preventDefault();
        $.ajax({
            url: 'inc/addCarAjax.php',
            type: 'post',
            // serialize permet de créer un tableau des données du formulaire
            data: $('form').serialize(),
            dataType: 'json',
            success: function(result) {
                if(result.code == 'success'){
                    $('#resultForm').html('<div class="green">'+result.msg+'</div>');
                    // Permet après l'enregistrement dans la base de vider les champs du formulaire
                    $('input[type="text"]').val('');
                }
                else {
                    $('#resultForm').html('<div class="red">'+result.msg+'</div>');
                }
            },
            error: function(err){
                // Si une erreur ajax s'est produite
            }
        });
    });
});
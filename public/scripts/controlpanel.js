$('document').ready(function() {
    loadEditButtons();
    loadFileUpload();
    //alert('carregado');
});
/* append buttons to edit forms */
function loadEditButtons() {
    $('#username .editbutton').click(
        function(){
            $('#username input').prop('disabled', false);
            $('#username .editbutton').hide().unbind();
        }
    );
    $('#firstname .editbutton').click(
        function(){
            $('#firstname input').prop('disabled', false);
            $('#firstname .editbutton').hide().unbind();
        }
    );
    $('#lastname .editbutton').click(
        function(){
            $('#lastname input').prop('disabled', false);
            $('#lastname .editbutton').hide().unbind();
        }
    );
    $('#residence .editbutton').click(
        function(){
            //$('#residence input').prop('disabled', false);
            //create a function to get from api all countrys and replacewith the inputtext to a select
            $('#residence input').replaceWith("<select class='dropdownlist' name='residence'><option>Portugal</option><option>Espanha</option></select>");
            $('#residence .editbutton').hide().unbind();
        }
    );
    $('#nationality .editbutton').click(
        function(){
            $('#nationality input').prop('disabled', false);
            $('#nationality .editbutton').hide().unbind();
        }
    );
    $('#agerange .editbutton').click(
        function(){
            $('#agerange input').prop('disabled', false);
            $('#agerange .editbutton').hide().unbind();
        }
    );
    $('#email .editbutton').click(
        function(){
            $('#email input').prop('disabled', false);
            $('#email .editbutton').hide().unbind();
        }
    );
    $('#phonenumber .editbutton').click(
        function(){
            $('#phonenumber input').prop('disabled', false);
            $('#phonenumber .editbutton').hide().unbind();
        }
    );
    $('#address .editbutton').click(
        function(){
            $('#address input').prop('disabled', false);
            $('#address .editbutton').hide().unbind();
        }
    );
    $('#city .editbutton').click(
        function(){
            $('#city input').prop('disabled', false);
            $('#city .editbutton').hide().unbind();
        }
    );
    $('#postalcode .editbutton').click(
        function(){
            $('#postalcode input').prop('disabled', false);
            $('#postalcode .editbutton').hide().unbind();
        }
    );
    $('#date .editbutton').click(
        function(){
            $('#date input').prop('disabled', false);
            $('#date .editbutton').hide().unbind();
        }
    );
    $('#organization .editbutton').click(
        function(){
            $('#organization input').prop('disabled', false);
            $('#organization .editbutton').hide().unbind();
        }
    );
}
function loadFileUpload(){
    $('.custom-upload input[type=file]').change(function(){
        $('.custom-upload input[type=text]').val($(this).val());
    });
}
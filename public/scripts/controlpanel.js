$('document').ready(function() {
    loadEditButtons();
    loadFileUpload();
    loadAutocompleteUsername();
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
            $.getJSON( "user/api/countries", function( data ) {
                var country = "<select class='dropdownlist' name='residence'>";
                var selected = $('#residence input').val();
                $.each(data, function(k, v) {
                    if(v==selected)
                        country+="<option value='"+k+"'selected>" + v + "</option>";
                    else
                        country+="<option value='"+k+"'>" + v + "</option>";
                });
                country+="</select>";

                $('#residence input').replaceWith(country);
                $('#residence .editbutton').hide().unbind();
            });
        }
    );
    $('#nationality .editbutton').click(
        function(){
            $.getJSON( "user/api/countries", function( data ) {
                var country = "<select class='dropdownlist' name='nationality'>";
                var selected = $('#nationality input').val();
                $.each(data, function(k, v) {
                    if(v== selected)
                        country+="<option value='"+k+"'selected>" + v + "</option>";
                    else
                        country+="<option value='"+k+"'>" + v + "</option>";
                });
                country+="</select>";

                $('#nationality input').replaceWith(country);
                $('#nationality .editbutton').hide().unbind();
            });
        }
    );
    $('#agerange .editbutton').click(
        function(){
            $.getJSON( "user/api/ages", function( data ) {
                var age = "<select class='dropdownlist' name='agerange'>";
                var selected = $('#agerange input').val();
                $.each(data, function(k, v) {
                    if(v== selected)
                        age+="<option value='"+k+"'selected>" + v + "</option>";
                    else
                        age+="<option value='"+k+"'>" + v + "</option>";
                });
                age+="</select>";

                $('#agerange input').replaceWith(age);
                $('#agerange .editbutton').hide().unbind();
            });
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

    // Privilages Page
    $('#department .edit_button').click(
        function() {
            $('#department input').prop('disabled', false);
            $('#department .edit_button').hide().unbind();
        }
    );


}
function loadFileUpload(){
    $('.custom-upload input[type=file]').change(function(){
        $('.custom-upload input[type=text]').val($(this).val());
    });
}


function loadAutocompleteUsername() {

    $.getJSON( "api/usernames", function( data ) {
        $( "#username" ).autocomplete({
            source: data
        });
    });

    $.getJSON( "api/emails", function( data ) {
        $( "#email" ).autocomplete({
            source: data
        });
    });
}

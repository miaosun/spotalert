var languages = [];
var tabtoremove;
var idtoremove;
var languagetoremove;
$(document).ready(function () {
    
    
     $('#addlanguage_tab').click(function(event) {
         event.preventDefault();
         $('.add-language-modal').modal('show');
    });
    
    $("#choose_language_button").on("click", function(event) {
        event.preventDefault();
        
        var language_text = $('#languages-select option:selected').text();
        var language_id = $('#languages-select option:selected').val();
        //add tab and container to the form
        //visual
        $('.add-language-modal').modal('hide');
        $("<li class='active'><a id='alert_tab_" + language_id + "' href='#alert_" + language_id + "' data-toggle='tab'>" + language_text + "</a><span id='rm-language' class='glyphicon glyphicon-remove'></span></li>").insertBefore(".nav-tabs li:last");
        $(".tab-content").find(".active").removeClass("active");
        $(".tab-content").append('<div class="tab-pane fade in active" id="alert_' + language_id + '"><div class="form-group"><label for="alert-title-label">Title</label><input name="alert-title' + language_id + '" type="text"></div><div class="form-group"><label for="alert-description-label">Description</label><textarea name="alert-description' + language_id + '" cols="50" rows="10"></textarea></div></div>');
        $('#languages_tabs a:nth-last-child(2)').tab('show');
        
        //functional
        delete window.language_options[language_id];
        $("#languages-select").empty();
        window.updatelangselect();
        languages.push(language_id);
    });
    
    $(document).on("click", "#rm-language", function(event) {
        event.preventDefault();

        idtoremove = $(this).closest('li').children('a').attr('id');
        tabtoremove = idtoremove.split("_").pop();
        languagetoremove = $(this).closest('li').children('a').text();            
        $('.rm-language-modal').modal('show');
    });
    
    
    $("#rm_language_button").on("click", function(event) {
        event.preventDefault();
        
        //visual
        $('.rm-language-modal').modal('hide');
        //remove tab
        $("#alert_tab_"+tabtoremove).closest('li').remove();
        //remove div
        $("#alert_"+tabtoremove).remove();
        $('#languages_tabs a:first-child').tab('show');
        
        //functional
        //add language to array
        window.language_options[tabtoremove] = languagetoremove;
        window.updatelangselect();
        languages.splice(languages.indexOf(tabtoremove));
        //languages.pop(language_id);
    });
    
    

    $('#languages_tabs a:not(#addlanguage_tab)').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    $('form').submit(function(){
        var lang = JSON.stringify(languages);
        $('input[name=alert-languages]').val(lang);
    });
    
});
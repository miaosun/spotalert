var languages = [];
var tabtoremove;
var idtoremove;
var languagetoremove;
$(document).ready(function () {
    
    if (typeof window.contents != 'undefined') {
        languages = window.contents;
    } 
    
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
        $("<li class='active'><a id='alert_tab_" + language_id + "' href='#alert_" + language_id + "' data-toggle='tab'>" + language_text + "<span id='rm-language' class='glyphicon glyphicon-remove' style='padding-left: 5px'></span></a></li>").insertBefore(".nav-tabs li:last");
        $(".nav-tabs").find(".active").removeClass("active");
        $(".tab-content").find(".active").removeClass("active");
        $(".tab-content").append('<div class="tab-pane fade in active" id="alert_' + language_id + '"><h1>NEW LANGUAGE</h1><div class="col-md-5 col-sm-5 col-md-offset-0" id="moveright"><div class="row"><div class="col-md-12 col-sm-12"><h5>TITLE* <span>(maximum of 50 characters)</span></h5><textarea placeholder="Write your title here" name="alert-title' + language_id + '"  cols="50"></textarea></div><div class="col-md-12 col-sm-12"><h5>DESCRIPTION*</h5><textarea placeholder="Write your description here" name="alert-description' + language_id + '" cols="50" rows="10"></textarea></div></div></div></div>');
        
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
        $(".tab-content").find(".active").removeClass("active");
        $('#languages_tabs a:first-child').tab('show');
        
        //functional
        //add language to array
        window.language_options[tabtoremove] = languagetoremove;
        window.updatelangselect();
        languages.splice(languages.indexOf(tabtoremove));
        //languages.pop(language_id);
    });
    
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();

    if(dd<10) {
        dd='0'+dd
    } 

    if(mm<10) {
        mm='0'+mm
    } 

    today = yyyy+'-'+mm+'-'+dd;
    yyyy--;
    var yesterday = yyyy+'-'+mm+'-'+dd;
    
    $("#activate_publication").click(function(e){
        e.preventDefault();
        
        $("input[name=alert-durationfrom]").val(today);
        $("input[name=alert-durationto]").val("");
        $("input[name=guideline-durationfrom]").val(today);
        $("input[name=guideline-durationto]").val("");
        
    });
    
    $("#deactivate_publication").click(function(e){
        e.preventDefault();
        
        $("input[name=alert-durationfrom]").val("");
        $("input[name=alert-durationto]").val(yesterday);
        $("input[name=guideline-durationfrom]").val("");
        $("input[name=guideline-durationto]").val(yesterday);

    });

    $('#languages_tabs a:not(#addlanguage_tab)').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    $('form').submit(function(){
        var lang = JSON.stringify(languages);
        $('input[name=alert-languages]').val(lang);
    });
    
    $(document).on("click", '.eye .imgremove',function(){
        var $image = $(this).parent();
        var image = $(this).prev().children().attr('href');
        var filename = image.replace(/^.*[\\\/]/, '');
        console.log(filename);
        var eye = $(this).prev().children('img').attr('class');
        $.post("/deleteimagew/"+eye+"/"+filename).done(function(){
            $image.remove();
            if($("#gallery").children().length == 0)
                $("#uploaded").remove();
            alert("The image was deleted successufully.");
        }).fail(function(){
            alert( "Something went wrong. The image was not deleted." );
        });
    });
    
    $(document).on("click", '.pub .imgremove',function(){
        var $image = $(this).parent();
        var image = $(this).prev().children().attr('src');
        var filename = image.replace(/^.*[\\\/]/, '')
        var pub = $(this).prev().children('img').attr('class');
        $.post("/deleteimage/"+pub+"/"+filename ).done(function(){
            $image.remove();
            if($("#gallery").children().length == 0)
                $("#uploaded").remove();
            alert("The image was deleted successufully.");
        }).fail(function(){
            alert( "Something went wrong. The image was not deleted." );
        });
    });
    
});
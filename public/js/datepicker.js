$(document).ready(function () {
    date_form=$('#article_form_publish_date').val();
    if(date_form != ''){
        $('#article_form_publish_date').datetimepicker({
            format: "YYYY-MM-DD HH:mm",
            locale: 'en',
            date: date_form,
        });

    }else{
        $('#article_form_publish_date').datetimepicker({
            format: "YYYY-MM-DD HH:mm",
            locale: 'en',
            
        });

    }
    tinymce.init({
        selector: '#article_form_body'
    });

});
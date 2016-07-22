function gradeChange(str) {
    'use strict';
    console.log(str);
    $.ajax({
        type: 'GET',
        url: '../admin/handlers/content_handler.php', //this should be url to your PHP file
        dataType: 'html',/*
        data: {func: 'toptable', 'user_id': uname},*/
        beforeSend: function () {
            $('#right').html('checking');
        },
        complete: function () {},
        success: function (html) {
            console.log('success');
            //('#right').html(html);
        }
    });
}
function subjectChange(str) {
    'use strict';
    var obj = jQuery.parseJSON(str);
    var chosenSubject = obj.curSubLevel;
    console.log(chosenSubject);
    $.ajax({
        type: 'POST',
        url: '../admin/handlers/dynamic_content.php', //url to your PHP file
        dataType: 'html',
        data: {'chosenSubjectLevel': chosenSubject},
        //beforeSend: function() {
            //$('#right').html('checking');
        //},
        complete: function () {},
        success: function (html) {
            console.log('success');
            $('#gradeDropdown').html(html);
            //console.log(html);
        },
        error: function (html) {
            console.log('error');
        }
    });
}

$(window).load(function () {
    var str = $('#subjectDropdown').val();
    subjectChange(str);
});
/*jslint browser: true*/
/*global $, jQuery, alert*/

function gradeChange(str) {
    'use strict';
    var chosenGrade, subjectVal, obj, chosenSubject;
    
    subjectVal = $('#subjectDropdown').val();
    obj = jQuery.parseJSON(subjectVal);
    chosenSubject = obj.curSubId;
    chosenGrade = str;
    
    //console.log(chosenSubject);
    //console.log(chosenGrade);
    
    $.ajax({
        type: 'POST',
        url: '../admin/handlers/dynamic_content.php', //this should be url to your PHP file
        dataType: 'html',
        data: {'chosenGrade': chosenGrade, 'chosenSubject': chosenSubject},
        //beforeSend: function () {
        //    console.log('sending');
        //},
        complete: function () {},
        success: function (html) {
            //console.log('success');
            $('#topicDropdown').html(html);
            //console.log(html);
            str = $('#topicDropdown').val();
            //console.log(str);
            checkOutputVal(str);
        },
        error: function (html) {
            //console.log('error');
        }
    });
}

function subjectChange(str) {
    'use strict';
    var obj = jQuery.parseJSON(str);
    var chosenSubject = obj.curSubLevel;
    //console.log(chosenSubject);
    $.ajax({
        type: 'POST',
        url: '../admin/handlers/dynamic_content.php',
        dataType: 'html',
        data: {'chosenSubjectLevel': chosenSubject},
        //beforeSend: function() {
            //console.log('sending');
        //},
        complete: function () {},
        success: function (html) {
            //console.log(html);
            $('#gradeDropdown').html(html);
            
            var str = $('#gradeDropdown').val();
            gradeChange(str);
            //console.log(html);
            
        },
        error: function (html) {
            //console.log('error');
        }
    });
}

function checkOutputVal(str) {
    'use strict';
    var value = str;
    if (value === '') {
        //console.log('empty');
        $('#topicDropdown').prop('disabled', true);
    } else {
        $('#topicDropdown').removeAttr('disabled');
        //console.log(value);
    }
    
}//END OF AJAX FUNCTIONS


//JQUERY SEARCH FUNCTIONS
function statisticsSearch() {
    'use strict';
    var searchVal, searchDiv, keyWord, table, assSearchVal, scheduleSearchVal, checkboxChange, value;
    
    //console.log('reached');
    $('.empty-data-error').remove();
    $('.btn').click(function () {
        searchVal = $(this).attr('id');
        $('.schedule-table-container .table').removeClass('in');
        $('.stat-table-container .table').removeClass('in');
        $( ".table tr td").removeAttr('class');
        $('.empty-data-error').remove();
        if (searchVal === 'stat_schedule_search') {
            scheduleSearchVal = true;
            assSearchVal = false;
            //console.log('scheduleSearchVal true');
        } else if (searchVal === 'stat_ass_search') {
            assSearchVal = true;
            scheduleSearchVal = false;
            //console.log('assSearchVal true');
            //console.log(assClassCheckbox);
        }
        if (assSearchVal === true) {
            
            searchDiv = $('#assStat .checkbox :checkbox:checked');
            checkboxChange = $('#assStat .checkbox :checkbox');
            keyWord = $('#AssStatsInput').val();
            
            $('.stat-table-container .table').addClass('in');
            $('.schedule-table-container .table').removeClass('in');
            table = '.stat-table-container .table.in ';
            //console.log(searchDiv.length);
            
            if (keyWord.length === 0) {
                
                //display error message once
                $('<div class="empty-data-error">Please fill in to search through the table</div>').prependTo($('.table.in').parent());
                
                //console.log('doing nothing');
            } else {
                var err = $('.empty-data-error').hide();
                //console.log(err);
                //console.log(table);
                if (searchDiv.length > 0) {
                    
                        searchDiv.each(function () {
                        
                        value = searchDiv.map(function () {
                            return $(this).attr('id');
                        }).get();
                        searchTableQuery(value, keyWord, table);
                    });
                //    console.log(searchDiv.length);
                } else {
                    value = ['none','none'];
                    searchTableQuery(value, keyWord, table);
                }
                checkboxChange.change(function () {
                    //console.log('checkbox changed');
                });
                
            }
            
        } else if (scheduleSearchVal === true) {
            
            searchDiv = $('#scheduleStat .checkbox :checkbox:checked');
            checkboxChange = $('#scheduleStat .checkbox :checkbox');
            keyWord = $('#ScheduleStatsInput').val();
            
            $('.schedule-table-container .table').addClass('in');
            $('.stat-table-container .table').removeClass('in');
            
            table = '.schedule-table-container .table.in ';
            console.log('schedule true');
            
            if (keyWord.length === 0) {
                
                //display error message once
                $('<div class="empty-data-error">Please fill in to search through the table</div>').prependTo($('.table.in').parent());
                
                //console.log('doing nothing');
            } else {
                var err = $('.empty-data-error').hide();
                //console.log(err);
                //console.log(table);
                if (searchDiv.length > 0) {
                    
                        searchDiv.each(function () {
                        
                        value = searchDiv.map(function () {
                            return $(this).attr('id');
                        }).get();
                        searchTableQuery(value, keyWord, table);
                    });
                //    console.log(searchDiv.length);
                } else {
                    value = ['none','none'];
                    searchTableQuery(value, keyWord, table);
                }
                checkboxChange.change(function () {
                    //console.log('checkbox changed');
                });
                
            }
            
        }
    });
    
    
}

function searchTableQuery(value, keyWord, table) {
    'use strict';
    var valueNi, keyWordNi, tableNi, columnNi, searchAt, array;
    
    valueNi = value;
    keyWordNi = keyWord;
    tableNi = table;
    //console.log('---------->'+valueNi);
    $.each(valueNi, function (ind, currentValue) {
    if (currentValue === 'byTeacherName') {
        columnNi = 'tr td:nth-child(1)';
        searchAt = $(tableNi + columnNi);
        $( ".table tr td:not(:nth-child(1))").removeAttr('style');
        array = searchAt.map(function () {
            return $(this).text();
        }).get();
        //console.log('searching in 1');
        //console.log('/////////'+array);
        textAlike(keyWordNi, array);
        
    } else if (currentValue === 'byTitle') {
        columnNi = 'tr td:nth-child(2)';
        searchAt = $(tableNi + columnNi);
        $( ".table tr td:not(:nth-child(2))").removeAttr('style');
        array = searchAt.map(function () {
            return $(this).text();
        }).get();
        //console.log('searching in 2');
        //console.log('/////////'+array);
        textAlike(keyWordNi, array);
        
    } else if (currentValue === 'byClass') {
        columnNi = 'tr td:nth-child(3)';
        searchAt = $(tableNi + columnNi);
        $( ".table tr td:not(:nth-child(3))").removeAttr('style');
        array = searchAt.map(function () {
            return $(this).text();
        }).get();
        //console.log('searching in 3');
        //console.log('/////////'+array);
        textAlike(keyWordNi, array);
        
    } else if (currentValue === 'none') {
        //console.log('searching all');
        columnNi = 'tr td';
        searchAt = $(tableNi + columnNi);
        array = searchAt.map(function () {
            return $(this).text();
        }).get();
        //console.log('/////////'+array);
        textAlike(keyWordNi, array);
    }
    //console.log(valueNi);
    });
}


function textAlike(keyWordNi, array) {
    'use strict';
    var myArray, keyWordni, lowercaseText, lowercaseKeyWord, trimText, index, keywords, element, list, result, trimKeyWord, found, counter, attr;
    
    myArray = array;
    keyWordni = keyWordNi;
    //console.log(myArray);
    found = 1;
    
    index = $('.empty-data-error').length;
    $.each(myArray, function (ind, currentElement) {
        // CURRENTLY INTEGERS WILL SHOW EVERYTHING
        counter = 1;
        
        lowercaseText = currentElement.toLowerCase();
        trimText = $.trim(lowercaseText).split(" ").join("");
        lowercaseKeyWord = keyWordni.toLowerCase();
        trimKeyWord = $.trim(lowercaseKeyWord).split(" ").join("").replace(/\./g, "");
        //console.log('TRIM KEY WORD'+trimKeyWord);
        
        if (trimText.indexOf(trimKeyWord) >= 0) {//IF THEY MATCH
            
            $( ".table.in tr td:contains('" + currentElement + "')").addClass('highlight-text');
            
            ++counter;
            //console.log('ADDED CLASS: ' + counter);
            
            
        } else {
            //console.log('INDEX NOT FOUND In: ' + currentElement);
            
            if (index <= found && counter < 1) {
                $('<div class="empty-data-error">Please fill in to search through the table</div>').prependTo($('.table.in').parent());
            }
            
        }
        
    });
    
    
    attr = $('td.highlight-text').length;
    if( attr === 0) {
        $('div').remove('.empty-data-error');//remove the existing divs with error messages
        $('<div class="empty-data-error">Nothing found</div>').prependTo($('.table.in').parent());
    }
}

function scrollHighlighted() {
    'use strict';
    //----------------------------------
    //FUTURE FEATURE
    //IF THERE IS ANY HIGHLETED TEXT AND IS MORE THAN{}px FROM THE TOP, AN ARROW APPEARS, AUTOMATICALLY SCROLLS YOU TO THE NEXT HIGHLITED <td>
    //----------------------------------
}

$(window).ready(function () {
    'use strict';
    var str = $('#subjectDropdown').val();
    subjectChange(str);
});
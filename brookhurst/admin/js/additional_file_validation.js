/*!
 * jQuery Validation Plugin v1.14.0
 *
 * http://jqueryvalidation.org/
 *
 * Copyright (c) 2015 Jörn Zaefferer
 * Released under the MIT license
 */
(function( factory ) {
	if ( typeof define === "function" && define.amd ) {
		define( ["jquery", "./jquery.validate"], factory );
	} else {
		factory( jQuery );
	}
}(function( $ ) {

(function() {

	function stripHtml(value) {
		// remove html tags and space chars
		return value.replace(/<.[^<>]*?>/g, " ").replace(/&nbsp;|&#160;/gi, " ")
		// remove punctuation
		.replace(/[.(),;:!?%#$'\"_+=\/\-“”’]*/g, "");
	}

	$.validator.addMethod("maxWords", function(value, element, params) {
		return this.optional(element) || stripHtml(value).match(/\b\w+\b/g).length <= params;
	}, $.validator.format("Please enter {0} words or less."));

	$.validator.addMethod("minWords", function(value, element, params) {
		return this.optional(element) || stripHtml(value).match(/\b\w+\b/g).length >= params;
	}, $.validator.format("Please enter at least {0} words."));

	$.validator.addMethod("rangeWords", function(value, element, params) {
		var valueStripped = stripHtml(value),
			regex = /\b\w+\b/g;
		return this.optional(element) || valueStripped.match(regex).length >= params[0] && valueStripped.match(regex).length <= params[1];
	}, $.validator.format("Please enter between {0} and {1} words."));

}());

// Accept a value from a file input based on a required mimetype then alter contenttype dropdown
$.validator.addMethod("accept", function(value, element, param) {
	// Split mime on commas in case we have multiple types we can accept
	var typeParam = typeof param === "string" ? param.replace(/\s/g, "").replace(/,/g, "|") : "image/*",
	optionalValue = this.optional(element),
	i, file, fileType, chosenFileType;

	// Element is optional
	if (optionalValue) {
		return optionalValue;
	}

	if ($(element).attr("type") === "file") {
		// If we are using a wildcard, make it regex friendly
		typeParam = typeParam.replace(/\*/g, ".*");

		// Check if the element has a FileList before checking each file
		if (element.files && element.files.length) {
			for (i = 0; i < element.files.length; i++) {
				file = element.files[i];
                
                //console.log('files: ' + $(element).val());
				
                // Grab the mimetype from the loaded file, verify it matches
				if (!file.type.match(new RegExp( "\\.?(" + typeParam + ")$", "i"))) {
                    //wrong mimetype

					return false;
				} else {
                    //required mimetype
                    
                    
                    /* ====================================================================
                    EXTENDED CODE BY mwauramuchiri.co.ke ====================================================================
                    */
                    
                    
                    //ALLOWED CONTENT FORMATS ARE: -> image/*,video/*,application/pdf, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel
                    
                    //SWITCH STATEMENT
                    fileType = file.type;
                    
                    switch (fileType) { 
                        case 'application/pdf': 
                            //console.log('PDF FILE!');
                            //Article or book or test
                            chosenFileType = 'a';
                            break;
                            
                        case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet': 
                            //console.log('SPREADSHEET DOCUMENT');
                            //Article or book or test
                            chosenFileType = 'a';
                            break;
                            
                        case 'image/jpeg': 
                            //console.log('IMAGE!');
                            //Article or book or test
                            chosenFileType = 'a';
                            break;		
                        
                        case 'image/gif': 
                            //console.log('IMAGE!');
                            //Article or book or test
                            chosenFileType = 'a';
                            break;		
                        
                        case 'image/png': 
                            //console.log('IMAGE!');
                            //Article or book or test
                            chosenFileType = 'a';
                            break;		
                            
                        case 'application/vnd.ms-excel': 
                            //console.log('EXCEL SHEET!');
                            //article or book or test
                            chosenFileType = 'a';
                            break;
                            
                        case 'video/mp4': 
                            //console.log('VIDEO!');
                            //video
                            chosenFileType = 'v';
                            break;
                            
                        default:
                            //console.log('NOT DECIDED. ARTICLE OR BOOK OR VIDEO');
                            chosenFileType = '';
                    }
                    
                    //console.log('b: ' + file.type);
                    //console.log('===============');
                    
                    if(chosenFileType != '') {
                        switch (chosenFileType) {
                            case 'a':
                                //remove video
                                resetDropdown();
                                removeV();
                                break;
                            
                            case 'v':
                                // remove article, book and test
                                resetDropdown();
                                removeA();
                                break;
                                
                            default:
                                console.log('error in ajax switchcase');
                        }
                    }
                }
			}
		}
	}

	// Either return true because we've validated each file, or because the
	// browser does not support element.files and the FileList feature
	return true;
}, $.validator.format("Please enter a value with a valid mimetype."));
    
    function removeA() {            
        $('#contTypeDrop').children('option[value^="article"]').hide();
        $('#contTypeDrop').children('option[value^="book"]').hide();
        $('#contTypeDrop').children('option[value^="test"]').hide();
        $('#contTypeDrop').find('option').removeAttr('selected').end().trigger('chosen:updated');
    }
    
    function removeV() {
        $('#contTypeDrop').children('option[value^="video"]').hide();
        $('#contTypeDrop').find('option').removeAttr('selected').end().trigger('chosen:updated');
    }
    
    function resetDropdown() {
        
        $('#contTypeDrop').children('option').show();
    }
    
}));
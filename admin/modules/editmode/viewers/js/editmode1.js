(function($) {

        $.fn.InputEdit = function(options) {
        
            // define some options with sensible default values
            // - hoverClass: the css classname for the hover style
            options = $.extend({
                hoverClass: 'hover'
            }, options);
        
            return $.each(this, function() {
        
                // define self container
                var self = $(this);
        
                // create a value property to keep track of current value
                self.value = self.text();
        
                // bind the dblclick event to the current element, in this example it's span.editable
                self.bind('dblclick', function() {

                    self
                        // populate current element with an input element and add the current value to it
                        .html('<input type="text" value="'+ self.value +'"><button class="save">save</button><button class="cancel">cancel</button>')		
                        // select this newly created input element
                        .find('input')
                            // bind the blur event and make it save back the value to the original span area
                            // there by replacing our dynamically generated input element
                            .bind('blur', function(event) {
                                self.value = $(this).val();
                                self.text(self.value);
                            });
                            // give the newly created input element focus
                            //.focus();
							$('.save').click(function() {
                                self.text(self.value);
							});
                            
                })
                // on hover add hoverClass, on rollout remove hoverClass
                .hover(
                    function(){
                        self.addClass(options.hoverClass);
                    },
                    function(){
                        self.removeClass(options.hoverClass);
                    }
                );
            });
        }
        
    })(jQuery);
	
	(function($) {

        $.fn.TextEdit = function(options) {
            options = $.extend({
                hoverClass: 'hover'
            }, options);
        
            return $.each(this, function() {
                var self = $(this);
                self.value = self.html();
                self.bind('dblclick', function() {
                    self
                        .html('<textarea id="editor1" name="editor1">'+ $(this).html() +'</textarea><button class="save">save</button><button class="cancel">cancel</button>')		
                        .find('textarea');
							//$('#editor1').ckeditor();
							
							$('.save').click(function() {
								//CKEDITOR.instances.editor1.updateElement();
								//self.value2 = CKEDITOR.instances['editor1'].getData();
								//CKEDITOR.instances.editor1.destroy();
                               //self.html(self.value2);
								
								self.value2 = $('#editor1').val();
								$('#content').html(self.value2);
							});
                });
            });
        }
        
    })(jQuery);
	
$(document).ready(function(){

$('.editinput').InputEdit();
$('.edittext').TextEdit();

$("#img").rotate(180);
	$('#open').click(function(){
		$("#admin_menu1").show();
		$('#admin_menu1').animate({ 
                marginTop: "0px"
                }, 500 );
	});
	$('#close').click(function(){
		$('#admin_menu1').animate({ 
            marginTop: "-57px"
        }, 500 );
		$("#admin_menu1").hide(500);
	});
	$('#admin_menu1_toggle').click(function(){
		if ($("#admin_menu1").css("margin-top") == '-57px') {
				$("#img").rotate({
				  angle:180, 
				  animateTo:0,
				  duration: 300
				});
				$('#admin_menu1').animate({ 
					marginTop: "15px"
					}, 500 );
				$(".editmode_text").animate({
					marginTop: "-57px",
					//marginLeft: "150px"
				}, 500);
				$('#editmode_text2').fadeOut();
		}else{
				$('#admin_menu1').animate({ 
						marginTop: "-57px"
				}, 500 );
				$("#img").rotate({
				  angle:0, 
				  animateTo:180,
				  duration: 300
				});
				$(".editmode_text").animate({
					marginTop: "22px"
				}, 500);
				$('#editmode_text2').fadeIn();
		}
	});
});
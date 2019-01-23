


var formErrorStatus={
	"errorSize":function(){
		var size=0;
		for(var key in formErrorStatus){
			if (formErrorStatus.hasOwnProperty(key)) {
				size++;
			}

			
		}
		return size;
	}
};


var fx = {  
	"initModal" : function() {                                         
		if ( $(".modal-window").length==0 ){                     
        	// Creates a div, adds a class, and appends it to the body tag                                
        	return $("<div>").addClass("modal-window").append("<div class='loader'></div>").appendTo("body");                 
        }else{                     
        // Returns the modal window if one                                    
        return $(".modal-window");                 
    }             
} ,

"boxin" : function(data, modal) {                 
 // Creates an overlay for the site, adds                 
 // a class and a click event handler, then                 
 // appends it to the body element  
                $('.modal-window .loader').remove();
 $("<div>").hide().addClass("modal-overlay").click(
 	function(event){                             
 			// Removes event                             
 			fx.boxout(event); 
 		}).appendTo("body"); 
 
                // Loads data into the modal window and                 
                // appends it to the body element 

                modal.hide().append(data).appendTo("body"); 

                // Fades in the modal window and overlay                 
                $(".modal-window,.modal-overlay").fadeIn("slow");
			//make Event Title input the focus




		}, 

		"boxout" : function(event) {                
  // If an event was triggered by the element                 
  // that called this function, prevents the                
   // default action from firing                 
   if ( event!=undefined ){                     
   	event.preventDefault();                 
   } 

                // Removes the active class from all links                 
                $("a").removeClass("active"); 

                // Fades out the modal window, then removes                 
                // it from the DOM entirely                 
                $(".modal-window") .fadeOut("slow", function() {                             
                	$(this).remove(); 
                	$('.modal-overlay').remove();                        
                } );    
            }
           

}





$(function(){

/*This function is used in causing an Image slideShow*/
if ($('.slideshow-container').length>0) {

	var slideIndex = 1;
	showSlides(slideIndex);
	
	setInterval(function(){
		if (slideIndex>3) {
			slideIndex=1;
		}
		showSlides(slideIndex);
		slideIndex++;

	},10000);

	function plusSlides(n) {
		showSlides(slideIndex += n);
	}
	$('.prev').on('click',function(e){
		plusSlides(-1);
	});

	$('.next').on('click',function(e){
		plusSlides(1);
	});
	function currentSlide(n) {
		showSlides(slideIndex = n);
	}
	$('span.dot').on('click',function(e){
		$target=$(e.target);
		if ($('span.dot').index($target)==0){
			currentSlide(1);
		}else if($('span.dot').index($target)==1){
			currentSlide(2);
		}else if($('span.dot').index($target)==2){
			currentSlide(3);
		}else{

		}
	});

	function showSlides(n) {
		var i;
		var slides = document.getElementsByClassName("mySlides");
		var dots = document.getElementsByClassName("dot");
		if (n > slides.length) {slideIndex = 1}    
			if (n < 1) {slideIndex = slides.length}
				for (i = 0; i < slides.length; i++) {
					slides[i].style.display = "none";  
				}
				for (i = 0; i < dots.length; i++) {
					dots[i].className = dots[i].className.replace(" active", "");
				}
				slides[slideIndex-1].style.display = "block";  
				dots[slideIndex-1].className += " active";
			}

		}
		/*End of codes used in causing an Image slideShow*/





/*Adding Behaviour to LOG IN & REGISTER buttons*/
 $(".cover-text a").on('click', function(e){
    	//alert('Testing...');

    		e.preventDefault();
   		var anchorUrl=$(e.target)[0].href.split('?'); //get $_GET part of a href
   		var modal=fx.initModal();
   		var topPos=$(e.target)[0].offsetTop;
   		//alert(topPos);
   		modal.offset({top:topPos});
   		
   		$.ajax({
   			type:"GET",
   			url:"assets/inc/login.inc.php",
   			data:/*{"action":"login"}*/anchorUrl[1],
   			success:function(data){

   				fx.boxin(data,modal);

   				$('html, body').animate({scrollTop : $('#login-content')[0].offsetTop},1000);
   			},
   			error:function(msg){
   				resultmsg=msg.status+':'+msg.statusText;
   				fx.boxin(resultmsg,modal);
   			}
   		});
   	

   });

//Load Contents of ponds.php through ajax
if ($('#ponds').length>0) {



		$('body').css('background-color','white');
	$.ajax({
   			type:"POST",
   			url:"assets/inc/process.inc.php",
   			data:{"action":"load_ponds"},
   			success:function(data){
   				$('.row').html(data).hide().fadeIn(500);
   				$('main#pond-page-wrapper #admin').css('height',$('footer')[0].offsetTop);
   				

   			},
   			error:function(msg){
   				resultmsg=msg.status+':'+msg.statusText;
   				fx.boxin(resultmsg,modal);
   			}
   		});

  }



if ($('#fish-tips').length>0) {

		$('body').css('background-color','white');
	
   				
   				$('main#pond-page-wrapper #admin').css('height',$('footer')[0].offsetTop);
   				
}

$('body').on('click','#menu-tips',function(e){
	e.preventDefault();
	$target=$(e.target);
	$('.row').load('tips.html').hide().fadeIn(500);

});






//Adds behaviour to Update Pond and Delete Pond buttons in ponds.php
  $("a:contains('Delete Pond')").on('click',function(e){
     	e.preventDefault();
     	$target=$(e.target);
     	$('.active').removeClass('active');
	$target.addClass('active');


	if (!$('#myModal').length>0) {
          $modal_bottom=$('<div id="myModal" class="modal-bottom">')
      }else{

        $modal_bottom=$('#myModal').css('display','block');
      }
     	var data='<div id="modal-bottom-content" class="modal-bottom-content">'+
         '<div class="modal-bottom-header">'+
         '<span class="close-bottom" >&times;</span>'+
         '<h3>Welcome To Andrah Help Center</h3>'+
         '</div>'+
         '<div class="modal-bottom-body">'+
         '<p><strong>Are you sure you want to delete a Pond? Action cannot be reversed.</strong></p>'+
'<p style="color:grey;">'+
'<form action="assets/inc/process.inc.php" method="post"> '+
'<input style="border:1px solid orange;" type="text" name="pond_id" value="" placeholder="Enter Pond Id you wish to Delete"></p>'+
         '<input type="submit" id="delete_pond_submit" value="Delete">'+
         '<input type="hidden" name="action" value="delete_pond">'+
         '</form></div>'+
         /*'<div class="modal-bottom-footer">'+
         ' <h3>Modal Footer</h3>'+
         '</div>'+*/
         '</div>';

    
      $modal_bottom.append($(data));
      $('body').append($modal_bottom);


      $('.close-bottom, #myModal').on('click',function(e){
        e.preventDefault();
        $target=$(e.target);
        //$('#modal-bottom-content').removeClass('modal-bottom-content');
          if ($target.is(".close-bottom")) {
            $('#myModal').fadeOut(1000);
            // $('#modal-bottom-content').addClass('slideOut');
          }
           
       

            });

     	

     });

//Adding behaviour to Update pond button
  $("a:contains('Update Pond')").on('click',function(e){
      e.preventDefault();
      $target=$(e.target);
      $('.active').removeClass('active');
  $target.addClass('active');
    if (!$('#myModal').length>0) {
          $modal_bottom=$('<div id="myModal" class="modal-bottom">')
      }else{

        $modal_bottom=$('#myModal').css('display','block');
      }
      var data='<div id="modal-bottom-content" class="modal-bottom-content">'+
         '<div class="modal-bottom-header">'+
         '<span class="close-bottom" >&times;</span>'+
         '<h3>Welcome To Andrah Help Center</h3>' +
         '</div>'+
         '<div class="modal-bottom-body">'+
         '<p><strong>Please Enter Pond name to continue...</strong></p>'+
'<p style="color:grey;">'+
'<form action="assets/inc/process.inc.php" method="post"> '+
'<input style="border:1px solid orange;" type="text" name="pond_id" value="" placeholder="Enter Pond Id you wish to Update"></p>'+
         '<input type="submit" id="update_pond_submit" value="Update">'+
         '<input type=hidden name="action" value="update_pond">'+
         '</div>'+
         /*'<div class="modal-bottom-footer">'+
         ' <h3>Modal Footer</h3>'+
         '</div>'+*/
         '</div>';

      $modal_bottom.append($(data));
      $('body').append($modal_bottom);


      $('.close-bottom, #myModal').on('click',function(e){
        e.preventDefault();
        $target=$(e.target);
        //$('#modal-bottom-content').removeClass('modal-bottom-content');
          if ($target.is(".close-bottom")) {
            $('#myModal').fadeOut(1000);
            // $('#modal-bottom-content').addClass('slideOut');
          }
           
       

            });

  });

$('body').on('click','#delete_pond_submit',function(e){
  e.preventDefault();
  $target=$(e.target);
 //alert('dyfgyfgh');
 var formData=$target.parents('form').serialize();

    $.ajax({
        type:"POST",
        url:"assets/inc/process.inc.php",
        data:formData,
        success:function(data){
          $('.row').html(data).hide().fadeIn(500);
       
        },
        error:function(msg){
          resultmsg=msg.status+':'+msg.statusText;
          fx.boxin(resultmsg,modal);
        }
      });
 $('#myModal').fadeOut(1000);

});

$('body').on('click','#update_pond_submit',function(e){
  e.preventDefault();
  $target=$(e.target);
  var formData=$target.parents('form').serialize();

    $.ajax({
        type:"POST",
        url:"assets/inc/process.inc.php",
        data:formData,
        success:function(data){
          $('.row').html(data).hide().fadeIn(500);
       
        },
        error:function(msg){
          resultmsg=msg.status+':'+msg.statusText;
          fx.boxin(resultmsg,modal);
        }
      });
 $('#myModal').fadeOut(1000);

});


//Adds behaviour to Stock Pond button
$('#stock-pond').on('click',function(e){
	e.preventDefault();
	$target=$(e.target);
	$('.active').removeClass('active');
	$target.addClass('active');

	
	//$('.row').html(data).hide().fadeIn(1000);
	$('.row').load('sel_stock.html').hide().fadeIn(500);

});

$('body').on('click','#single-stock',function(e){
	e.preventDefault();
	
	$.ajax({
   			type:"POST",
   			url:"assets/inc/process.inc.php",
   			data:{
   				"action":"load_fishes",
   				"stock_method":"single"
   				},
   			success:function(data){
   				$('.row').html(data).hide().fadeIn(500);
   		
   			},
   			error:function(msg){
   				resultmsg=msg.status+':'+msg.statusText;
   				fx.boxin(resultmsg,modal);
   			}
   		});




});

$('body').on('click','#multiple-stock',function(e){
	e.preventDefault();

	$.ajax({
   			type:"POST",
   			url:"assets/inc/process.inc.php",
   			data:{
   				"action":"load_fishes",
   				"stock_method":"multiple"
   			},
   			success:function(data){
   				$('.row').html(data).hide().fadeIn(500);
   		
   			},
   			error:function(msg){
   				resultmsg=msg.status+':'+msg.statusText;
   				fx.boxin(resultmsg,modal);
   			}
   		});


	
});


$('body').on('input','input#myRange',function(e){
	$target=$(e.target);
	$('span#demo').text($target.val());
	

});


$('body').on('click','#stock_save',function(e){
	e.preventDefault();
	$target=$(e.target);
	var formData=$target.parents('form').serialize();
	console.log(formData);
	$.ajax({
   			type:"POST",
   			url:"assets/inc/process.inc.php",
   			data:/*{
   				"action":"stock_fish",
   				"stock_method":"single"
   			}*/formData,
   			success:function(data){
   				$('.row').html(data).hide().fadeIn(500);
   		
   			},
   			error:function(msg){
   				resultmsg=msg.status+':'+msg.statusText;
   				fx.boxin(resultmsg,modal);
   			}
   		});

});

//This section adds behaviour to Create pond button in ponds.php
$('#create-pond').on('click',function(e){
  e.preventDefault();
  $target=$(e.target);
  $('.active').removeClass('active');
  $target.addClass('active');
  $('.row').load('create.php').hide().fadeIn(500);

  
});


$('body').on('click','#create_pond_submit',function(e){
    e.preventDefault();
  $target=$(e.target);
  var formData=$target.parents('form').serialize();
  console.log(formData);
  $.ajax({
        type:"POST",
        url:"assets/inc/process.inc.php",
        data:/*{
          "action":"stock_fish",
          "stock_method":"single"
        }*/formData,
        success:function(data){
          $('.row').html(data).hide().fadeIn(500);
      
        },
        error:function(msg){
          resultmsg=msg.status+':'+msg.statusText;
          fx.boxin(resultmsg,modal);
        }
      });
});



//Adds behaviour to Transfer Fish button
$('#transfer-fish').on('click',function(e){
	e.preventDefault();
	$target=$(e.target);
	$('.active').removeClass('active');
	$target.addClass('active');
	
	$('.row').load('transfer-fish.html').hide().fadeIn(500);
	

});
//Associated operations with transfer fish
if ($('#transfer-fish').length>0) {

	$('body').on('click','#tilapia',function(e){
	e.preventDefault();
	$target=$(e.target);

	$.ajax({
   			type:"POST",
   			url:"assets/inc/process.inc.php",
   			data:{
   				"action":"transfer_fishes",
   				"fish_type":"tilapia"
   			},
   			success:function(data){
   				$('.row').html(data).hide().fadeIn(500);
   		
   			},
   			error:function(msg){
   				resultmsg=msg.status+':'+msg.statusText;
   				fx.boxin(resultmsg,modal);
   			}
   		});


});
$('body').on('click','#cat-fish',function(e){
	e.preventDefault();
	$target=$(e.target);

	$.ajax({
   			type:"POST",
   			url:"assets/inc/process.inc.php",
   			data:{
   				"action":"transfer_fishes",
   				"fish_type":"cat fish"
   			},
   			success:function(data){
   				$('.row').html(data).hide().fadeIn(500);
   		
   			},
   			error:function(msg){
   				resultmsg=msg.status+':'+msg.statusText;
   				fx.boxin(resultmsg,modal);
   			}
   		});


});
$('body').on('click','#electric-fish',function(e){
	e.preventDefault();
	$target=$(e.target);

	$.ajax({
   			type:"POST",
   			url:"assets/inc/process.inc.php",
   			data:{
   				"action":"transfer_fishes",
   				"fish_type":"electric fish"
   			},
   			success:function(data){
   				$('.row').html(data).hide().fadeIn(500);
   		
   			},
   			error:function(msg){
   				resultmsg=msg.status+':'+msg.statusText;
   				fx.boxin(resultmsg,modal);
   			}
   		});


});

$('body').on('click',"button:contains('Edit')",function(e){
	$target=$(e.target);
var id=$target.attr('id');
	$.ajax({
   			type:"POST",
   			url:"assets/inc/process.inc.php",
   			data:{
   				"action":"edit_fish",
   				"fish_id":id
   			},
   			success:function(data){
   				$('.row').html(data).hide().fadeIn(500);
   		
   			},
   			error:function(msg){
   				resultmsg=msg.status+':'+msg.statusText;
   				fx.boxin(resultmsg,modal);
   			}
   		});
});

$('body').on('click',"button:contains('Delete')",function(e){
  $target=$(e.target);
var id=$target.attr('id');
  $.ajax({
        type:"POST",
        url:"assets/inc/process.inc.php",
        data:{
          "action":"delete_fish",
          "fish_id":id
        },
        success:function(data){
          $('.row').html(data).hide().fadeIn(500);
      
        },
        error:function(msg){
          resultmsg=msg.status+':'+msg.statusText;
          fx.boxin(resultmsg,modal);
        }
      });
});

$('body').on('click','#transfer_fish_submit',function(e){
	e.preventDefault();
	$target=$(e.target);
	var formData=$target.parents('form').serialize();

		$.ajax({
   			type:"POST",
   			url:"assets/inc/process.inc.php",
   			data:formData,
   			success:function(data){
   				$('.row').html(data).hide().fadeIn(500);
   		
   			},
   			error:function(msg){
   				resultmsg=msg.status+':'+msg.statusText;
   				fx.boxin(resultmsg,modal);
   			}
   		});
})


}//End of transfer fish function

//Adds behaviour to Record Motality button
/*$('#record-motality').on('click',function(e){
	e.preventDefault();
	$target=$(e.target);
	$('.active').removeClass('active');
	$target.addClass('active');
	var data="<div>Testing of data</div>";
	$('.row').html(data).hide().fadeIn(1000);

});*/


//Adds behaviour to Record Lost Fish button
$('#record-motality').on('click',function(e){
	e.preventDefault();
	$target=$(e.target);
	$('.active').removeClass('active');
	$target.addClass('active');
		$.ajax({
   			type:"POST",
   			url:"assets/inc/process.inc.php",
   			data:{
   				//action should have been dead fish
   				"action":"transfer_fishes",
   				
   			},
   			success:function(data){
   				$('.row').html(data).hide().fadeIn(500);
   		
   			},
   			error:function(msg){
   				resultmsg=msg.status+':'+msg.statusText;
   				fx.boxin(resultmsg,modal);
   			}
   		});

});


//Adding active behaviuor to primary navigational links

$('.icon-bar-wrapper a').on('click', function(e){
  $target=$(e.target);
  $('.icon-bar-wrapper a.active').removeClass('active');
  $target.addClass('acive');
});

}); //End of Ready Function

var fixedTop = false;
var transparent = true;
var navbar_initialized = false;
var button_val = "";
var nav_open = false;
$(document).ready(function(){
    window_width = $(window).width();

    // Init navigation toggle for small screens
    if(window_width <= 991){
        //pd.initRightMenu();
    }
	
	$(document).on('click','.mobile-nav',function(){		
		if(nav_open == false){
          if(direction == "ltr"){			
			 $(".sidebar").animate({left: '0px'}, 300);
		  }else{
			 $(".sidebar").animate({right: '0px'}, 300);  
		  }
		  nav_open = true;
		}else{
		  if(direction == "ltr"){	
			 $(".sidebar").animate({left: '-260px'}, 300);
		  }else{
			 $(".sidebar").animate({right: '-260px'}, 300);  
		  }
		  nav_open = false;
		}
	});

    //  Activate the tooltips
    $('[rel="tooltip"]').tooltip(); 
	
	$("#menu").metisMenu();

	$(document).on('click','.btn-remove',function(){
		var c = confirm("Are you sure you want to permanently remove this record?");
	    if(c){
			return true;
		}
		return false;
	});
	
	$(".select2").select2(); 
	
    $(".niceselect").niceSelect();	

	$(document).on('focus', '.datepicker', function(){
		$(this).datepicker({
			format: 'yyyy-mm-dd'
		}).on('changeDate', function(){
			$(this).datepicker('hide');
			$("#main_modal").css("overflow-y","auto");
		});
	});

	$(document).on('focus', '.monthpicker', function(){
		$(this).datepicker( {
			format: "mm/yyyy",
			viewMode: "months", 
			minViewMode: "months"
		}).on('changeDate', function(){
			$(this).datepicker('hide');
		});	
	});
	
	$(".monthpicker").datepicker( {
		format: "mm/yyyy",
		viewMode: "months", 
		minViewMode: "months"
	});	

	$('.dropify').dropify();
	
	$('.datetimepicker').datetimepicker({
		format:'YYYY-MM-DD HH:mm:00'
	});
	
	$('.timepicker').datetimepicker({
		format:'HH:mm:00'
	});

	//Form validation
	validate();	

    /*Summernote editor*/
	if ($("#summernote,.summernote").length) {
		$('#summernote,.summernote').summernote({
			height: 200,
			dialogsInBody: true
		});
	}	
	
	$(".float-field").keypress(function(event) {
	   if ((event.which != 46 || $(this).val().indexOf('.') != -1) &&
			(event.which < 48 || event.which > 57)) { event.preventDefault();
		}
	});	

	$(".int-field").keypress(function(event) {
		if ((event.which < 48 || event.which > 57)) { event.preventDefault();
		}
	});	
	
	$(document).on('click','#modal-fullscreen',function(){
		$("#main_modal >.modal-dialog").toggleClass("fullscreen-modal");
	});
	
	//Mask Plugin
	$('.year').mask('0000-0000');
		
	$(".metismenu li.active").parent().parent().addClass("m-active");
    
	$(".m-active").addClass("active");
	$(".m-active >ul").addClass("in");
	
	$(".form-horizontal input:required, select:required, textarea:required").parent().prev().append("<span class='required'> *</span>");
	
	$("input:required, select:required, textarea:required").prev().append("<span class='required'> *</span>");
	
	$(document).on("click",".off-canvas-sidebar li a",function(){
		if ( $(this).has("ul")) {
			if(typeof $(this).parent().attr("class") == 'undefined'){
			   $(this).next().slideToggle(200);
			}
		}
	});
	
	//Print Command
	$(document).on('click','.print',function(){
		$("#preloader").css("display","block");
		var div = "#"+$(this).data("print");	
		$(div).print({
			timeout: 1000,
		});		
	});
	
	//Appsvan File Upload Field
	$(".appsvan-file").after("<input type='text' class='form-control filename' readOnly>"
	+"<button type='button' class='btn btn-info appsvan-upload-btn'>Browse</button>");
    
	$(".appsvan-file").each(function(){
		if($(this).data("value")){
			$(this).parent().find(".filename").val($(this).data("value"));
		}
		if($(this).attr("required")){
			$(this).parent().find(".filename").prop("required",true);
		}
	});
	
	$(document).on("click",".appsvan-upload-btn",function(){
		$(this).parent().find("input[type=file]").click();
	});
	
	$(document).on('change','.appsvan-file',function(){
		readFileURL(this);
	});

	function readFileURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {};
	
			$(input).parent().find(".filename").val(input.files[0].name);
			reader.readAsDataURL(input.files[0]);
		}
	}
	
	//Ajax Modal Function
	$(document).on("click",".ajax-modal",function(){
		 var link = $(this).attr("href");
		 var title = $(this).data("title");
		 var fullscreen = $(this).data("fullscreen");
		 $.ajax({
			 url: link,
			 beforeSend: function(){
				$("#preloader").css("display","block"); 
			 },success: function(data){
				$("#preloader").css("display","none");
				$('#main_modal .modal-title').html(title);
				$('#main_modal .modal-body').html(data);
				$("#main_modal .alert-success").css("display","none");
				$("#main_modal .alert-danger").css("display","none");
				$('#main_modal').modal('show'); 
				
				if(fullscreen ==true){
					$("#main_modal >.modal-dialog").addClass("fullscreen-modal");
				}else{
					$("#main_modal >.modal-dialog").removeClass("fullscreen-modal");
				}
				
				//init Essention jQuery Library
				$("select.select2").select2();
				$('.year').mask('0000-0000');
				$(".ajax-submit").validate();
				$('.timepicker').datetimepicker({
					format:'HH:mm:00'
				});
				$(".dropify").dropify();
				$("input:required, select:required, textarea:required").prev().append("<span class='required'> *</span>");
			 }
		 });
		 
		 return false;
	 }); 
	 
	 $("#main_modal").on('show.bs.modal', function () {
         $('#main_modal').css("overflow-y","hidden"); 		
     });
	 
	 $("#main_modal").on('shown.bs.modal', function () {
		setTimeout(function(){
		  $('#main_modal').css("overflow-y","auto");
		}, 1000);	
     });

	 
	 //Ajax Modal Submit
	 $(document).on("submit",".ajax-submit",function(){			 
		 var link = $(this).attr("action");
		 $.ajax({
			 method: "POST",
			 url: link,
			 data:  new FormData(this),
			 mimeType:"multipart/form-data",
			 contentType: false,
			 cache: false,
			 processData:false,
			 beforeSend: function(){
				 
			 },success: function(data){
		
				var json = JSON.parse(data);
				if(json['result'] == "success"){
					$("#main_modal .alert-success").html(json['message']);
					$("#main_modal .alert-success").css("display","block");
					if(json['action'] == "update"){
						$('#row_'+json['data']['id']).find('td').each (function() {
						   if(typeof $(this).attr("class") != "undefined"){
							   $(this).html(json['data'][$(this).attr("class")]);
						   }
						});  
						
					}else if(json['action'] == "store"){
						$('.ajax-submit')[0].reset();
						//store = true;
						
						var new_row = $("table").find('tr:eq(1)').clone();
						
						$(new_row).attr("id", "row_"+json['data']['id']);
						
						$(new_row).find('td').each (function() {
						   if($(this).attr("class") == "dataTables_empty"){
							   window.location.reload();
						   }	
						   if(typeof $(this).attr("class") != "undefined"){
							   $(this).html(json['data'][$(this).attr("class")]);
						   }
						}); 
						
						var url  = window.location.href; 
						$(new_row).find('form').attr("action",url+"/"+json['data']['id']);
						$(new_row).find('.btn-warning').attr("href",url+"/"+json['data']['id']+"/edit");
						$(new_row).find('.btn-info').attr("href",url+"/"+json['data']['id']);
						
						$("table").prepend(new_row);
		
						//window.setTimeout(function(){window.location.reload()}, 2000);
					}
				}else{
					jQuery.each( json['message'], function( i, val ) {
					   $("#main_modal .alert-danger").append("<p>"+val+"</p>");
					});
					$("#main_modal .alert-danger").css("display","block");
				}
			 }
		 });

		 return false;
	 });

	 //Ajax Modal Submit
	$(document).on("submit",".ajax-submit2",function(){		 
		var link = $(this).attr("action");
		$.ajax({
			method: "POST",
			url: link,
			data:  new FormData(this),
			mimeType:"multipart/form-data",
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function(){
				$("#preloader").css("display","block");  
			},success: function(data){
				$("#preloader").css("display","none"); 
				var json = JSON.parse(data);
				if(json['result'] == "success"){
					if(typeof json['redirect'] != 'undefined' && json['redirect'] != ''){
						if(typeof json['message'] != 'undefined' && json['message'] != ''){
							Command: toastr['success'](json['message']);
						}
						window.location.replace(json['redirect']);
						return true;
					}
					if(typeof json['message'] != 'undefined' && json['message'] != ''){
						Command: toastr['success'](json['message']);
					}
					$('#main_modal').modal('hide');
				}else{
					jQuery.each( json['message'], function( i, val ) {
						$("#main_modal .alert-danger").html("<p>"+val+"</p>");
					});
					$("#main_modal .alert-success").css("display","none");
					$("#main_modal .alert-danger").css("display","block");
				}
			}
		});
		return false;
	});

	//Ajax Non Modal Submit
	$(".ajax-submit3").validate({
		submitHandler: function(form) {
			var link = $(form).attr("action");
			$.ajax({
				method: "POST",
				url: link,
				data:  new FormData(form),
				mimeType:"multipart/form-data",
				contentType: false,
				cache: false,
				processData:false,
				beforeSend: function(){
					$("#preloader").css("display","block");  
				},success: function(data){
					$("#preloader").css("display","none"); 
					var json = JSON.parse(data);
					if(json['result'] == "success"){
						Command: toastr['success'](json['message']);
						window.location.replace(json['redirect']);
					}else{
						jQuery.each( json['message'], function( i, val ) {
							Command: toastr['error'](val);
						});
						$("#main_modal .alert-success").css("display","none");
						$("#main_modal .alert-danger").css("display","block");
					}
				}
			});
			return false; 
		},invalidHandler: function(form, validator) {},
		errorPlacement: function(error, element) {}
	});
	 
	 //Ajax submit with validate
	 $(".appsvan-submit-validate").validate({
		 submitHandler: function(form) {
			 var elem = $(form);
			 $(elem).find("button[type=submit]").prop("disabled",true);
			 var link = $(form).attr("action");
			 $.ajax({
				 method: "POST",
				 url: link,
				 data:  new FormData(form),
				 mimeType:"multipart/form-data",
				 contentType: false,
				 cache: false,
				 processData:false,
				 beforeSend: function(){
				   button_val = $(elem).find("button[type=submit]").text();
				   $(elem).find("button[type=submit]").html('<i class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i>');
				 
				 },success: function(data){
					$(elem).find("button[type=submit]").html(button_val);
					$(elem).find("button[type=submit]").attr("disabled",false);				
					var json = JSON.parse(data);
					if(json['result'] == "success"){
						Command: toastr["success"](json['message']);
					}else{
						jQuery.each( json['message'], function( i, val ) {
						   Command: toastr["error"](val);
						});
					}
				 }
			 });

			return false; 
		},invalidHandler: function(form, validator) {},
		  errorPlacement: function(error, element) {}
	 });
	 
	 //Ajax submit without validate
	 $(document).on("submit",".appsvan-submit",function(){		 
		 var elem = $(this);
		 $(elem).find("button[type=submit]").prop("disabled",true);
		 var link = $(this).attr("action");
		 $.ajax({
			 method: "POST",
			 url: link,
			 data:  new FormData(this),
			 mimeType:"multipart/form-data",
			 contentType: false,
			 cache: false,
			 processData:false,
			 beforeSend: function(){
			   button_val = $(elem).find("button[type=submit]").text();
			   $(elem).find("button[type=submit]").html('<i class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i>');
			 
			 },success: function(data){
				$(elem).find("button[type=submit]").html(button_val);
				$(elem).find("button[type=submit]").attr("disabled",false);				
				var json = JSON.parse(data);
				if(json['result'] == "success"){
					Command: toastr["success"](json['message']);
				}if(json['result'] == "error"){
					Command: toastr["error"](json['message']);
				}else{
					jQuery.each( json['message'], function( i, val ) {
					   Command: toastr["error"](val);
					});
					
				}
			 }
		 });

		 return false;
	 });
	 
	 
	$("#main_modal").on("hidden.bs.modal", function () {

	});
	 

});

// activate collapse right menu when the windows is resized
/*$(window).resize(function(){
    if($(window).width() <= 991){
        //pd.initRightMenu();
		if(direction == "ltr"){
		   $(".sidebar").css("left","-260px");
		}else{
		   $(".sidebar").css("right","-260px");
		}
    }else{
		if(direction == "ltr"){
		   $(".sidebar").css("left","0px");
		}else{
		   $(".sidebar").css("right","0px");
		}
	}
});*/

function validate(){
	//Validation Form
	$(".validate").validate({
		submitHandler: function(form) {
			form.submit();
		},invalidHandler: function(form, validator) {},
		  errorPlacement: function(error, element) {}
	});
}

function readURLimage(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$('#image').attr('src', e.target.result);
			$('#image').css("max-width","100%");
		};
		reader.readAsDataURL(input.files[0]);
	}
}



// Returns a function, that, as long as it continues to be invoked, will not
// be triggered. The function will be called after it stops being called for
// N milliseconds. If `immediate` is passed, trigger the function on the
// leading edge, instead of the trailing.

function debounce(func, wait, immediate) {
	var timeout;
	return function() {
		var context = this, args = arguments;
		clearTimeout(timeout);
		timeout = setTimeout(function() {
			timeout = null;
			if (!immediate) func.apply(context, args);
		}, wait);
		if (immediate && !timeout) func.apply(context, args);
	};
};

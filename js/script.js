
//$.ajax({
//  url: 'try_login.php',
//  success: function(data) {
//    $('.result').html(data);
//  }
//});

$(document).ready(function(){
	$(".following").click(function() {
		var $this = $(this);
		var text = $(this).text();
		if (text == "Add to fav") {

			var id = $(this).attr("id");

			$.post("fav.php", {"op": "add_clique", "id": id}, function(d) {
                            //alert(d);
				//if(d.trim() == "Done") {
				      $this.text("Drop from fav");
                                //}
			});
		}


		if (text == "Drop from fav") {
			var adder_id = $(this).data("adder_id");
			var clique_id = $(this).data("clique_id");
			$.post("fav.php", {"op": "del_clique", "adder_id": adder_id, "clique_id": clique_id}, function(d) {
				//alert(d);
				//if(d.trim() == "Done") {
					$this.text("Add to fav");


				//}
			});
		}

        });
	$('#desc').keyup(function(){
            var max_length =  200;
            var _length = $('#desc').val().length;
            var current_length = max_length - _length;
            $('#id').html(current_length +" "+ "characters remaining");
        });

	$('#message').keyup(function(){
            var max_length =  160;
            var _length = $('#message').val().length;
            var current_length = max_length - _length;
            $('#length_status').html(current_length +" "+ "characters remaining");

        });

	$('#up').click(function(){
	  alert('hi');
	});

	$('#no_pay').click(function(){
	$('#price').attr("disabled", "disabled");
	});
	$('#pay').click(function(){
	$('#price').removeAttr('disabled');
	});

	$('#no_acc').click(function(){
	  $('.pay_1, .pay_2, .pay_3').hide();

	});
	$('#yes_acc').click(function(){
	  $('.pay_1, .pay_2, .pay_3').show();

	});

	$('.clickable').click(function(){
	  $.post("notification.php", {"op": "notify"}, function(data){
	  });
	});

	$('.click').click(function(){
	  var receiver_id = $(this).attr("receiver_id");
	  var sender_id = $(this).attr("sender_id");

	  $.post("notification.php", {"op": "notify_single", "sender_id": sender_id, "receiver_id": receiver_id}, function(data){
	    alert(data);
	  });
	});

	function changeColor(){
	  document.write("unread");
	}
	$('.container_3').hide();

	$(document).scroll(function(){
	  var scrollHeight = $(this).scrollTop();
	  //$('.scroll').text(scrollHeight);
	  if (scrollHeight == 0) {
	    $('.container_3').show();
	    //$('.scroll').html("<a href='' class='scroll_all'>See more here</a>");

	  }

	});

	$('#student').click(function(){
	var href = $(this).attr('href');
	$('#display').load(href);
	return false;
	});
	$('#estate').click(function(){
	var href = $(this).attr('href');
	$('#display').load(href);
	return false;
	});
	$('#roommate').click(function(){
	var href = $(this).attr('href');
	$('#display').load(href);
	return false;
	});

	//$('#ads').click(function(){
	//var href = $(this).attr('href');
	//$('#display').load(href);
	//return false;
	//});

	//$('#admin_1').click(function(){
	//var href = $(this).attr('href');
	//$('#display').load(href);
	//return false;
	//});
	//$('#admin_2').click(function(){
	//var href = $(this).attr('href');
	//$('#display').load(href);
	//return false;
	//});
	//
	//$('#click').click(function(){
	//alert('hi');
	//});
	//
	$('.update_password').hide();
	$('.update_pass').click(function(){
	  if($(this).prop("checked") == true){
	      $('.update_password').show();
	  }
	  else if($(this).prop("checked") == false){
	      $('.update_password').hide();
	  }
	});

	$('.update_payment').hide();
	$('.update_pay').click(function(){
	  if($(this).prop("checked") == true){
	      $('.update_payment').show();
	  }
	  else if($(this).prop("checked") == false){
	      $('.update_payment').hide();
	  }
	});
	//live search verified students
	$('#search').keyup(function(){
	  var search_text = $(this).val();
	  $.post("search_student.php", {'search_text': search_text}, function(data){
	  $('.bb').hide();
	  $('.cc').hide();
	  $('#show').html(data);
	  });

	});
	//ends
	//live search Unverified students
	$('#search_2').keyup(function(){
	  var search_text_2 = $(this).val();

	  $.post("search_student_2.php", {'search_text_2': search_text_2}, function(data){
	  $('.bb').hide();
	  $('.cc').hide();
	  $('#show').html(data);
	  });

	});
	//ends
	//live search verified agents
	$('#search_3').keyup(function(){
	  var search_text_3 = $(this).val();

	  $.post("search_agent.php", {'search_text_3': search_text_3}, function(data){
	  $('.bb').hide();
	  $('.cc').hide();
	  $('#show').html(data);
	  });

	});
	//ends
	//live search unverified agents
	$('#search_4').keyup(function(){
	  var search_text_4 = $(this).val();

	  $.post("search_agent_2.php", {'search_text_4': search_text_4}, function(data){
	  $('.bb').hide();
	  $('.cc').hide();
	  $('#show').html(data);
	  });

	});
	//ends

	//$('#student_toggle').hide();
	//$('#admin_toggle').hide();

	//$('#admin_student').click(function(){
	//$('#student_toggle').toggle();
	//
	//});
	//
	//$('#admin_agent').click(function(){
	//$('#admin_toggle').toggle();
	//
	//});

	//$(".click").click(function(e) {
	//
	//	e.preventDefault();
	//	var receiver = $(this).attr("receiver");
	//	var sender = $(this).attr("sender");
	//	$.get("viewmessage.php", {"receiver_id": receiver, "sender_id":sender}, function(d) {
	//		$("#source").html(d);
	//
	//	});
	//});

});
//$(document).ready(function(){
//    $("#icons a").click(function(){
//        $("i").toggle();
//    });
//});

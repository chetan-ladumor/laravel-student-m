<script type="text/javascript">
	var n = $('#disabled').val();
	
	$('.create-fee').on('click', function (e) {
		$('#createFeeOpup').modal('show');
	});
	//==================== Create Fee ====================
	 $('#formFee').on('submit', function (e) {
	    e.preventDefault();
	    enableFormElement(this);
	    var data = $(this).serialize();
	    var url  = $(this).attr('action');

	    $.post(url, data, function (data) {
	    	location.reload();
	    });
	});

  //==================== Enable form element functions ====================
	 function enableFormElement(frmName) {
	    $.each($(frmName).find('input, select'), function (i, element) {
	    	$(element).attr('disabled', false).css({'background':'#fff', 'border':'1px solid #ccc'});
	    });
	 }
	
	$('.btn-paid').on('click', function (e) {
		e.preventDefault();
		s_fee_id = $(this).data('id-paid');
		balance  = $(this).val();
		
		
		$.get("{{ route('getRemainingFeeToPay') }}", {s_fee_id:s_fee_id}, function (data) {
			console.log(data);
			$('#Paid').attr('id', 'Pay');//change the attribute id value to 'Pay'
			//$("#program_id").val(data.program_id);
			//$('#Level_ID').val(data.level_id);
			$("#LevelId").val(data.level_id);
			$('#s_fee_id').val(data.s_fee_id);
			$('#Fee').val(data.school_fee);
			$("#FeeId").val(data.fee_id);
			$('#Amount').val(data.student_amount);
			$('#Discount').val(data.discount);
			$('#Pay').val(balance).focus().select();
			$('#b').val(balance);
			addItem(data);
			showStudentLevel(data);
			changeInvoiceId(data);
		});
	});
 
	function disabled_input()
	{
		$.each($('body').find('.d'), function(i, item) {
			$(item).attr('disabled', true).css({'background' : '#f5f5f5',
												'border': '1px solid #ccc'});
			$(item).attr('readonly', false);
		});
	}

	$(document).ready(function () {
		if (n ==0)
		{
			disabled_input();
		}
	});
	
	$('.btn-reset').on('click', function (e) {
		e.preventDefault();
		var caption = $(this).val();
		
		if (caption == 'Reset')
		{
			$(this).val('Cancel');
			$('#btn-go').val('Save');
			$('#Pay').attr('id', 'Paid');
			$('#frm-payment').attr('action', "{{ route('savePayment') }}");
			enableFormElement('#frm-payment');
			return;
		}
		location.reload();
	});

  function addItem(data)
  {
    $('#program_id').empty().append($('<option/>', {
       value: data.program_id,
       text : data.program
    }));

    $('#Level_ID').empty().append($('<option/>', {
        value: data.level_id,
        text : data.level
    }));
  }

  function showStudentLevel(data) {
     $.get("{{ route('showLevelStudent') }}", { level_id:data.level_id, student_id:data.student_id},function (data) {
             $('.academicDetail').text(data.detail);
         });
  }


  function changeInvoiceId(data)
  {
  	$.get("{{ route('changeInvoiceId') }}", { s_fee_id:data.s_fee_id, student_id:data.student_id},function (data) {
  	        $('.invoice-number').html('Receipt Number<sup>0</sup>: <b>'+data.receipt_id+'</b>');
  	    });
  }
</script>
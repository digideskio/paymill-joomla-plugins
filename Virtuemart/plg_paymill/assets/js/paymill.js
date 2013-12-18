// Paymill.js
 $(document).ready(function(){ 
			var or = document.getElementsByName("virtuemart_paymentmethod_id");
			for (var i = 0; i < or.length; i++) {
					or[i].checked = false;
			}
			$('input:radio[name=virtuemart_paymentmethod_id]').click(function() {
				var paymethod  = $('label:[for='+this.id+']').text();
				if(paymethod == 'Paymill')	
				{ $(".buttonBar-right").css("display", "none"); }	
				else 
				{ $(".buttonBar-right").css("display", "block"); }		
			});  
			var flag;         
		$('#btn-payment-cc').click(function() { 
				$("#cc").css("display", "block");
				$("#dc").css("display", "none");
				$("#iban").css("display", "none");
				method = 'cc';
					   
			});  
           $('#btn-payment-debit').click(function() { 
				$("#cc").css("display", "none");
				$("#dc").css("display", "block");
				$("#iban").css("display", "none");			   
				method = 'elv';
			    });
           $('#btn-payment-debit-v2').click(function() { 
				$("#cc").css("display", "none");
				$("#dc").css("display", "none");
				$("#iban").css("display", "block");	
				method = 'iban/bic';	
		});
		


       
        $('#test-transaction-button').click(function(){
  			var paytype = $('.btn-primary').attr('id');
			var params;
			if(paytype == 'btn-payment-cc')
			{
                   params = {
                        number: $('#CC_NUMBER').val(),
                        exp_month: $('#test-transaction-form-month').val(),
                        exp_year: $('#test-transaction-form-year').val(),
                        cvc: $('#test-transaction-form-cvc').val(),
                        amount: $('#test-transaction-form-sum').attr('value').replace(/,/, "."),
                        currency: 'EUR',
                        cardholder: $('#test-transaction-form-name').val()
                    };		
			}				
			if(paytype == 'btn-payment-debit')
			{ 
				var bcode = $('#test-transaction-form-code').val();
                   params = {
                        number: $('#test-transaction-form-account').val(),
                        bank: bcode,
                        accountholder: $('#test-transaction-form-name').val()
                    };			
			}
			if(paytype == 'btn-payment-debit-v2')
			{
                    params = {
                        iban: $('#test-transaction-form-iban').val(),
                        bic: $('#test-transaction-form-bic').val(),
                        accountholder: $('#test-transaction-form-name').val()
                    };			
			}
            paymill.createToken(params, tokenResponseHandler);
            return false;
        });

        function tokenResponseHandler(error,result) { 	
		
            if (error) { 
				 	$.ajax({
					type: "POST",
					url: 'index.php?option=com_paymillapi&task=transError&error='+error.apierror+'&format=raw',
					data: {flag:true},
					cache: false,
					success: function(html)
					{
						alert(html);
					}
					});   
				
            } else { 
                var token = result.token;
                var amount = $('#test-transaction-form-sum').attr('value');
                amount = amount.replace(/,/, ".");
                amount = parseFloat(amount);
                amount *= 100;
                amount = Math.round(amount);
                if( isNaN(amount) || amount <= 0) {
                    alert( $('#sum_error').text() );
                    return false;
                }
                var account = $('#test-transaction-form-account').attr('value');
                var vmpid = $('input:radio[name=virtuemart_paymentmethod_id]:checked').val();
 				$.ajax({
					type: "POST",
					url: 'index.php?option=com_paymillapi&task=chkPayment&token='+token+'&format=raw',
					data: {currency:'EUR', amount:amount, token:token, vmpid:vmpid },
					cache: false,
					success: function(html)
					{
						$('#paymentForm').submit();
						return true;
					}
					});               
            }
        }

        function paymillPreconditionErrorHandler(response) {
            var data = $.parseJSON(response.responseText);
            var msg = '';
            if (data && data.error) {
                $('#test-transaction-form').hide();

                for (var key in data.error.messages) {
                    msg += data.error.messages[key] + " ";
                }
                $('#test-transaction-apierror').text(data.error.field + ' ' + msg ).show();
            }
        }
        function paymillErrorHandler(response) {
            var data = $.parseJSON(response.responseText);
            if (data && data.error) {
                $('#test-transaction-form').hide();
                $('#test-transaction-apierror').text(data.error).show();
            }
        }

        $('.btn-payment').click(function() {
            if ($(this).hasClass('btn-primary')) return;

            $('.btn-payment').removeClass('btn-primary');
            $(this).addClass('btn-primary');
            var index = $('.btn-payment').index(this);

            $('.payment-input').hide();
            $('.payment-input').eq(index).show();
        });

        $('.back-to-form-link').live('click', function(event) {
            $('#test-transaction-form').show();
            $('.test-transaction-messages').hide();
            event.preventDefault();
            return false;
        });

	 });
	 

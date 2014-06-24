$(document).ready(function()
{
	for (var i=1; i<5; i++) {
		var post1 = document.getElementById('addinputResponse'+i);
		post1.style.display = 'none';
		var options = document.getElementById('position0').innerHTML;
    	document.getElementById('position'+i).innerHTML = options;
    	var options2 = document.getElementById('depid0').innerHTML;
    	document.getElementById('depid'+i).innerHTML = options2;
	}
	$(function(){
		

		$('#resid0').autocomplete({
			source: function(request, response){
				 $.ajax({
                    url: "<?php echo site_url('manageindicator/autocompleteResponse'); ?>",
                    dataType: "json",
                    data: {term: request.term},
                    success: function(data) {
                                response($.map(data, function(pwemployee) {
                                return {
									id: pwemployee.userid,
									//position: pwemployee.poname,
									positionid: pwemployee.positionid,
                                    pwname: pwemployee.pwname,
									value: pwemployee.pwname,
									pwtelephone: pwemployee.pwtelephone

                                    };
                            }));
                        }
                    });
    

			},
			minLength: 2,
			autofocus: true,
			select: function (event, ui) {
            event.preventDefault();
            //$("#position").val(ui.item.position);
			$("#resid0").val(ui.item.pwname);
			$("#position0").val(ui.item.positionid);
			$("#telephone0").val(ui.item.pwtelephone);
			$("#uid0").val(ui.item.id);
        }
		});

		
		
	});

	
	
});

$(document).ready(function()
{
	$(function(){
		

		$('#resid1').autocomplete({
			source: function(request, response){
				 $.ajax({
                    url: "<?php echo site_url('manageindicator/autocompleteResponse'); ?>",
                    dataType: "json",
                    data: {term: request.term},
                    success: function(data) {
                                response($.map(data, function(pwemployee) {
                                return {
									id: pwemployee.userid,
									//position: pwemployee.poname,
									positionid: pwemployee.positionid,
                                    pwname: pwemployee.pwname,
									value: pwemployee.pwname,
									pwtelephone: pwemployee.pwtelephone

                                    };
                            }));
                        }
                    });
    

			},
			minLength: 2,
			autofocus: true,
			select: function (event, ui) {
            event.preventDefault();
            //$("#position").val(ui.item.position);
			$("#resid1").val(ui.item.pwname);
			$("#position1").val(ui.item.positionid);
			$("#telephone1").val(ui.item.pwtelephone);
			$("#uid1").val(ui.item.id);
        }
		});

		
		
	});

	
	
});

$(document).ready(function()
{
	$(function(){
		

		$('#resid2').autocomplete({
			source: function(request, response){
				 $.ajax({
                    url: "<?php echo site_url('manageindicator/autocompleteResponse'); ?>",
                    dataType: "json",
                    data: {term: request.term},
                    success: function(data) {
                                response($.map(data, function(pwemployee) {
                                return {
									id: pwemployee.userid,
									//position: pwemployee.poname,
									positionid: pwemployee.positionid,
                                    pwname: pwemployee.pwname,
									value: pwemployee.pwname,
									pwtelephone: pwemployee.pwtelephone

                                    };
                            }));
                        }
                    });
    

			},
			minLength: 2,
			autofocus: true,
			select: function (event, ui) {
            event.preventDefault();
            //$("#position").val(ui.item.position);
			$("#resid2").val(ui.item.pwname);
			$("#position2").val(ui.item.positionid);
			$("#telephone2").val(ui.item.pwtelephone);
			$("#uid2").val(ui.item.id);
        }
		});

		
		
	});

	
	
});

$(document).ready(function()
{
	$(function(){
		

		$('#resid3').autocomplete({
			source: function(request, response){
				 $.ajax({
                    url: "<?php echo site_url('manageindicator/autocompleteResponse'); ?>",
                    dataType: "json",
                    data: {term: request.term},
                    success: function(data) {
                                response($.map(data, function(pwemployee) {
                                return {
									id: pwemployee.userid,
									//position: pwemployee.poname,
									positionid: pwemployee.positionid,
                                    pwname: pwemployee.pwname,
									value: pwemployee.pwname,
									pwtelephone: pwemployee.pwtelephone

                                    };
                            }));
                        }
                    });
    

			},
			minLength: 2,
			autofocus: true,
			select: function (event, ui) {
            event.preventDefault();
            //$("#position").val(ui.item.position);
			$("#resid3").val(ui.item.pwname);
			$("#position3").val(ui.item.positionid);
			$("#telephone3").val(ui.item.pwtelephone);
			$("#uid3").val(ui.item.id);
        }
		});

		
		
	});

	
	
});

$(document).ready(function()
{
	$(function(){
		

		$('#resid4').autocomplete({
			source: function(request, response){
				 $.ajax({
                    url: "<?php echo site_url('manageindicator/autocompleteResponse'); ?>",
                    dataType: "json",
                    data: {term: request.term},
                    success: function(data) {
                                response($.map(data, function(pwemployee) {
                                return {
									id: pwemployee.userid,
									//position: pwemployee.poname,
									positionid: pwemployee.positionid,
                                    pwname: pwemployee.pwname,
									value: pwemployee.pwname,
									pwtelephone: pwemployee.pwtelephone

                                    };
                            }));
                        }
                    });
    

			},
			minLength: 2,
			autofocus: true,
			select: function (event, ui) {
            event.preventDefault();
            //$("#position").val(ui.item.position);
			$("#resid4").val(ui.item.pwname);
			$("#position4").val(ui.item.positionid);
			$("#telephone4").val(ui.item.pwtelephone);
			$("#uid4").val(ui.item.id);
        }
		});

		
		
	});

	
	
});

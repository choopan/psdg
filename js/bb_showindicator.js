function viewallindicator() {
	var some_html = '<h4>ตัวชี้วัดระดับกระทรวงทั้งหมด</h4>';
	some_html += '<table class="table table-striped row-border table-hover" id="dataTables-example">';
	some_html += '<thead><tr><th>ตัวชี้วัด</th><th>ชื่อ</th><th>เป้าหมาย</th><th>น้ำหนัก</th><th>หน่วยงาน</th></tr></thead>';

	var oTable = $('#dataTables-example').dataTable
        ({
            "bJQueryUI": false,
            "bProcessing": true,
            "sPaginationType": "full_numbers",
            'bServerSide'    : false,
			"bPaginate" : false,
            "bDeferRender": true,
            'sAjaxSource'    : '<?php echo site_url("manageindicator/getdataAndButtonbyajax"); ?>',
            "fnServerData": function ( sSource, aoData, fnCallback ) {
                $.ajax( {
                    "dataType": 'json',
                    "type": "POST",
                    "url": sSource,
                    "data": aoData,
                    "success":fnCallback
                
                });
            }
        });
    some_html += '</table>';
	bootbox.alert(some_html);
}


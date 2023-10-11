<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Credit Request Form List</title>
	<style>
		.tabledate {
			width: 10% !important;
		}

		@media (max-width:480px) {
			.tabledate {
				width: 20% !important;
			}
		}

		@media (max-width:768px) {
			.tabledate {
				width: 20% !important;
			}
		}
	</style>
</head>

<body>
	<div class="container bg-white p-3">
		<h2 align="center">Credit Request Form List</h2>

		<hr>
		<div class="row">
			<div class="col-md-3 form-group">
				<a href="<?=base_url('main/addEx')?>"><button class="btn btn-info btn-block"><i class="fas fa-plus-circle"></i>&nbsp;New CRF Form</button></a>
			</div>
			<div class="col-md-6 form-group form-inline">
				<label>Search&nbsp;</label>
				<input hidden type="text" name="checkSearchChooseEx" id="checkSearchChooseEx">
				<select name="searchdataex" id="searchdataex" class="form-control form-control-sm">
					<option value="">Please select item</option>
					<option value="bydatecreate">Search by date created.</option>
					<option value="byformno">Search by form no.</option>
					<option value="bycompanyname">Search by company name.</option>
				</select>&nbsp;
				<a href="javascript:void(0)" id="clearSearch"><i class="fas fa-undo m-2" style="font-size:24px;color:#FF6600"></i></a>
			</div>

			<!-- ค้นหาจากวันที่ -->
			<div class="col-md-6 form-group form-inline searchByDate" style="display:none;">
				<input type="date" name="startdateex" id="startdateex" class="form-control form-control-sm m-1" placeholder="Date Start">
				<label for="">TO</label>
				<input type="date" name="enddateex" id="enddateex" class="form-control form-control-sm m-1" placeholder="Date End">
				<button type="button" name="btnSearchDateCreateex" id="btnSearchDateCreateex" class="btn btn-secondary">Search</button>
			</div>

			<!-- ค้นหาจากเลขที่คำขอ -->
			<div class="col-md-6 form-group form-inline searchByForm" style="display:none;">
				<input type="text" name="searchFormnoex" id="searchFormnoex" class="form-control form-control-sm m-1" placeholder="Fill form no." style="width:60%;">
				<button type="button" name="btnSearchFormnoex" id="btnSearchFormnoex" class="btn btn-secondary">Search</button>
			</div>

			<!-- ค้นหาจากชื่อบริษัท -->
			<div class="col-md-6 form-group form-inline searchByCompany" style="display:none;">
				<input type="text" name="searchCompanyex" id="searchCompanyex" class="form-control form-control-sm m-1" placeholder="Fill company name." style="width:60%;">
				<button type="button" name="btnSearchCompanyex" id="btnSearchCompanyex" class="btn btn-secondary">Search</button>
			</div>


		</div>
		<div class="row">
			<div class="col-md-12 crfexMainScroll">
				<div class="" id="country_tableex"></div>
			</div>
			<div class="col-md-12 form-group">
				<div align="center" class="mt-2">
					<span>Total</span>&nbsp;<span id="countTotalex" class="p-3"></span>&nbsp;<span>list</span>
				</div>
			</div>

			

		</div>
		<div class="row mt-2 d-flex justify-content-center">
			<div id="pagination_linkex"></div>
		</div>

		
	</div>

</body>



<script>
	$(document).ready(function() {
		load_data_allex(1);

		$(document).on("click", ".pagination li a", function(event) {
			event.preventDefault();
			var page = $(this).data("ci-pagination-page");
			if($('#checkSearchChooseEx').val() == ""){
				load_data_allex(page);
			}
		});


if(!$('#searchdataex').val()){
	$('#searchdataex').change(function(){
		var searchdataex = $('#searchdataex').val();
		$('#checkSearchChooseEx').val(searchdataex);




		if($('#checkSearchChooseEx').val() == "bydatecreate"){
			$('#btnSearchDateCreateex').on('click', function() {
			var dateStart = $('#startdateex').val();
			var dateEnd = $('#enddateex').val();
			load_data_byDateex(1, dateStart, dateEnd);

			$(document).on("click", ".pagination li a", function(event) {
				event.preventDefault();
				var page = $(this).data("ci-pagination-page");
				if($('#checkSearchChooseEx').val() == "bydatecreate"){
					load_data_byDateex(page, dateStart, dateEnd);
				}
			});
		});
		}else if($('#checkSearchChooseEx').val() == "byformno"){
			$('#btnSearchFormnoex').on('click', function() {
			var formno = $('#searchFormnoex').val();
			load_data_byFormNoex(1, formno);

			$(document).on("click", ".pagination li a", function(event) {
				event.preventDefault();
				var page = $(this).data("ci-pagination-page");
				if($('#checkSearchChooseEx').val() == "byformno"){
					load_data_byFormNoex(page, formno);
				}
			});
		});
		}else if($('#checkSearchChooseEx').val() == "bycompanyname"){
			$('#btnSearchCompanyex').on('click', function() {
			var companyName = $('#searchCompanyex').val();
			load_data_byCompanyex(1, companyName)

			$(document).on("click", ".pagination li a", function(event) {
				event.preventDefault();
				var page = $(this).data("ci-pagination-page");
				if($('#checkSearchChooseEx').val() == "bycompanyname"){
					load_data_byCompanyex(page, companyName);
				}
			});
		});
		}
	});
}



		





		$('#clearSearch').on('click', function() {
			location.reload();
		});

	});


	function load_data_allex(page) {
		$.ajax({
			url: "<?php echo base_url(); ?>main/paginationex/" + page,
			method: "GET",
			dataType: "json",
			success: function(data) {
				$('#country_tableex').html(data.country_table);
				$('#pagination_linkex').html(data.pagination_link);
				$('#countTotalex').html(data.countTotal);
			}
		});
	}

	function load_data_byDateex(page, dateStart, dateEnd) {
		$.ajax({
			url: "<?php echo base_url(); ?>main/paginationByDateex/" + page + "/" + dateStart + "/" + dateEnd,
			method: "GET",
			dataType: "json",
			success: function(data) {
				$('#country_tableex').html(data.country_table);
				$('#pagination_linkex').html(data.pagination_link);
				$('#countTotalex').html(data.countTotal);
			}
		});
	}

	function load_data_byFormNoex(page, formno) {
		$.ajax({
			url: "<?php echo base_url(); ?>main/paginationByFormNoex/" + page + "/" + formno,
			method: "GET",
			dataType: "json",
			success: function(data) {
				$('#country_tableex').html(data.country_table);
				$('#pagination_linkex').html(data.pagination_link);
				$('#countTotalex').html(data.countTotal);
			}
		});
	}

	function load_data_byCompanyex(page, companyName) {
		$.ajax({
			url: "<?php echo base_url(); ?>main/paginationByCompanyex/" + page + "/" + companyName,
			method: "GET",
			dataType: "json",
			success: function(data) {
				$('#country_tableex').html(data.country_table);
				$('#pagination_linkex').html(data.pagination_link);
				$('#countTotalex').html(data.countTotal);
			}
		});
	}
</script>

</html>
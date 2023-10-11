<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>รายการใบ Credit Request Form</title>
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
		<h3 align="center">รายการ Credit Request Form</h3>

		<hr>
		<div class="row">
			<div class="col-md-3 form-group">
				<a href="<?= base_url('main/addTH') ?>"><button class="btn btn-info btn-block"><i class="fas fa-plus-circle"></i>&nbsp;เพิ่มรายการในประเทศ</button></a>
			</div>


			<div class="col-md-6 form-group form-inline">
				<input hidden type="text" name="checkSearchChoose" id="checkSearchChoose" class="form-control">
				<label>ค้นหาข้อมูล&nbsp;</label>
				<select name="searchdata" id="searchdata" class="form-control form-control-sm">
					<option value="">กรุณาเลือกการค้นหา</option>
					<option value="จากวันที่สร้างรายการ">ค้นหาจากวันที่สร้างรายการ</option>
					<option value="จากเลขที่คำขอ">จากเลขที่คำขอ</option>
					<option value="จากชื่อบริษัท">จากชื่อบริษัท</option>
				</select>&nbsp;
				<a href="javascript:void(0)" id="clearSearch"><i class="fas fa-undo m-2" style="font-size:24px;color:#FF6600"></i></a>
			</div>

			<!-- ค้นหาจากวันที่ -->
			<div class="col-md-6 form-group form-inline searchByDate" style="display:none;">
				<input type="date" name="startdate" id="startdate" class="form-control form-control-sm m-1" placeholder="เริ่มวันที่">
				<label for="">ถึง</label>
				<input type="date" name="enddate" id="enddate" class="form-control form-control-sm m-1" placeholder="สิ้นสุดวันที่">
				<button type="button" name="btnSearchDateCreate" id="btnSearchDateCreate" class="btn btn-secondary">ค้นหา</button>
			</div>

			<!-- ค้นหาจากเลขที่คำขอ -->
			<div class="col-md-6 form-group form-inline searchByForm" style="display:none;">
				<input type="text" name="searchFormno" id="searchFormno" class="form-control form-control-sm m-1" placeholder="พิมพ์เลขที่คำขอ" style="width:60%;">
				<button type="button" name="btnSearchFormno" id="btnSearchFormno" class="btn btn-secondary">ค้นหา</button>
			</div>

			<!-- ค้นหาจากชื่อบริษัท -->
			<div class="col-md-6 form-group form-inline searchByCompany" style="display:none;">
				<input type="text" name="searchCompany" id="searchCompany" class="form-control form-control-sm m-1" placeholder="พิมพ์ชื่อบริษัท" style="width:60%;">
				<button type="button" name="btnSearchCompany" id="btnSearchCompany" class="btn btn-secondary">ค้นหา</button>
			</div>


		</div>
		<hr>
		<label for="" style="color:#000;text-align:center;"><b>จำนวนรายการของท่าน ตาม Status</b></label>
		<div class="row">
			<?= showCountStatus(getUser()->ecode) ?>
		</div>
		<hr>

		<section id="statusAcc" style="display:none;">
			<!-- Check acc dept for show -->
			<input hidden type="text" name="listStatusAcc" id="listStatusAcc" value="<?=getUser()->DeptCode?>">
			<label for="" style="color:#000;"><b>จำนวนรายการ รอดำเนินการ(สำหรับบัญชี)</b></label>
			<div class="row">
				<?= showCountStatusAcc(getUser()->DeptCode) ?>
			</div>
			<hr>
		</section>

		<!-- <div class="row d-flex justify-content-center mt-2">
			<div class="pagination_link"></div>
		</div> -->
		<div class="row">
			<div class="col-md-12 crfMainScroll">
				<div class="" id="country_table"></div>
			</div>
			<div class="col-md-12">
				<div align="center" class="mt-2">
					<span>รวมทั้งสิ้น</span>&nbsp;<span id="countTotal" class="p-3"></span>&nbsp;<span>รายการ</span>
				</div>
				
			</div>
		</div>
		<div class="row d-flex justify-content-center mt-2">
			<div class="pagination_link"></div>
		</div>
	</div>

</body>



<script>
	$(document).ready(function() {

		load_data_all(1);

		$(document).on("click", ".pagination li a", function(event) {
			event.preventDefault();
			var page = $(this).data("ci-pagination-page");
			if($('#checkSearchChoose').val() == ""){
				load_data_all(page);
			}
		});

		if (!$('#searchdata').val()) {

			$('#searchdata').change(function() {
				var searchdata = $('#searchdata').val();
				$('#checkSearchChoose').val(searchdata);


				if ($('#checkSearchChoose').val() == "จากวันที่สร้างรายการ") {
					$('#btnSearchDateCreate').click(function() {
						var dateStart = $('#startdate').val();
						var dateEnd = $('#enddate').val();
						load_data_byDate(1, dateStart, dateEnd);

						$(document).on("click", ".pagination li a", function(event) {
							event.preventDefault();
							var pagedate = $(this).data("ci-pagination-page");
							if ($('#checkSearchChoose').val() == "จากวันที่สร้างรายการ") {
								load_data_byDate(pagedate, dateStart, dateEnd);
							}
						});
					});

				} else if ($('#checkSearchChoose').val() == "จากเลขที่คำขอ") {
					$('#btnSearchFormno').click(function() {
						var formno = $('#searchFormno').val();
						load_data_byFormNo(1, formno);

						$(document).on("click", ".pagination li a", function(event) {
							event.preventDefault();
							var pageForm = $(this).data("ci-pagination-page");
							if ($('#checkSearchChoose').val() == "จากเลขที่คำขอ") {
								load_data_byFormNo(pageForm, formno);
							}
						});
					});
				} else if ($('#checkSearchChoose').val() == "จากชื่อบริษัท") {
					$('#btnSearchCompany').click(function() {
						var companyName = $('#searchCompany').val();
						load_data_byCompany(1, companyName)

						$(document).on("click", ".pagination li a", function(event) {
							event.preventDefault();
							var page = $(this).data("ci-pagination-page");
							if($('#checkSearchChoose').val() == "จากชื่อบริษัท"){
								load_data_byCompany(page, companyName);
							}
						});
					});
				}

			});
		}


		$('.statusFilter').click(function() {
			var status = $(this).attr("data_status");
			var ecode = $(this).attr("data_ecode");
			load_data_byStatusUser(1, status, ecode);

			$(document).on("click", ".pagination li a", function(event) {
				event.preventDefault();
				var pagedate = $(this).data("ci-pagination-page");
				load_data_byStatusUser(pagedate, status, ecode);
			});
		});


		$('.statusFilterAcc').click(function() {
			var statusAcc = $(this).attr("data_statusAcc");
			var deptcodeAcc = $(this).attr("data_deptcodeAcc");
			load_data_byStatusAcc(1, statusAcc);

			$(document).on("click", ".pagination li a", function(event) {
				event.preventDefault();
				var pagedate = $(this).data("ci-pagination-page");
				load_data_byStatusAcc(pagedate, statusAcc);
			});
		});


		if($('#listStatusAcc').val() == 1003){
			$('#statusAcc').css('display' , '');
		}else{
			$('#statusAcc').css('display' , 'none');
		}


		$('#clearSearch').on('click', function() {
			location.reload();
		});

	});


	function load_data_all(page) {
		$.ajax({
			url: "<?php echo base_url(); ?>main/pagination/" + page,
			method: "GET",
			dataType: "json",
			success: function(data) {
				$('#country_table').html(data.country_table);
				$('.pagination_link').html(data.pagination_link);
				$('#countTotal').html(data.countTotal);
			}
		});
	}

	function load_data_byDate(page, dateStart, dateEnd) {
		$.ajax({
			url: "<?php echo base_url(); ?>main/paginationByDate/" + page + "/" + dateStart + "/" + dateEnd,
			method: "GET",
			dataType: "json",
			success: function(data) {
				$('#country_table').html(data.country_table);
				$('#pagination_link').html(data.pagination_link);
				$('#countTotal').html(data.countTotal);
			}
		});
	}

	function load_data_byFormNo(page, formno) {
		$.ajax({
			url: "<?php echo base_url(); ?>main/paginationByFormNo/" + page + "/" + formno,
			method: "GET",
			dataType: "json",
			success: function(data) {
				$('#country_table').html(data.country_table);
				$('#pagination_link').html(data.pagination_link);
				$('#countTotal').html(data.countTotal);
			}
		});
	}

	function load_data_byCompany(page, companyName) {
		$.ajax({
			url: "<?php echo base_url(); ?>main/paginationByCompany/" + page,
			method: "POST",
			data: {
				companyName: companyName
			},
			dataType: "json",
			success: function(data) {
				$('#country_table').html(data.country_table);
				$('#pagination_link').html(data.pagination_link);
				$('#countTotal').html(data.countTotal);
			}
		});
	}

	function load_data_byStatusUser(page, status, ecode) {
		$.ajax({
			url: "<?php echo base_url(); ?>main/paginationByStatusUser/" + page,
			method: "POST",
			data: {
				status: status,
				ecode: ecode
			},
			dataType: "json",
			success: function(data) {
				$('#country_table').html(data.country_table);
				$('#pagination_link').html(data.pagination_link);
				$('#countTotal').html(data.countTotal);
			}
		});
	}


	function load_data_byStatusAcc(page, status) {
		$.ajax({
			url: "<?php echo base_url(); ?>main/paginationByStatusAcc/" + page,
			method: "POST",
			data: {
				status: status
			},
			dataType: "json",
			success: function(data) {
				$('#country_table').html(data.country_table);
				$('#pagination_link').html(data.pagination_link);
				$('#countTotal').html(data.countTotal);
			}
		});
	}


</script>

</html>
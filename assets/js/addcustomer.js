// Global variables for search management
let searchTimeout = null;
let currentRequest = null;

const escapeHtml = (input = "") =>
	String(input ?? "")
		.replace(/&/g, "&amp;")
		.replace(/</g, "&lt;")
		.replace(/>/g, "&gt;")
		.replace(/"/g, "&quot;")
		.replace(/'/g, "&#39;");

const deriveContactName = (name = "") => {
	const trimmed = String(name ?? "").trim();
	return trimmed === "" ? "" : trimmed.split(/\s+/)[0];
};

const buildCustomerListMarkup = (customers = []) =>
	customers
		.map((customer) => {
			const accountnum = escapeHtml(customer.accountnum || "");
			const rawName = customer.name || "";
			const name = escapeHtml(rawName);
			const area = escapeHtml(customer.data_area_id || "");
			const addressValue = escapeHtml(customer.address || "");
			const phoneValue = escapeHtml(customer.phone || "");
			const faxValue = escapeHtml(customer.telefax || "");
			const emailValue = escapeHtml(customer.email || "");
			const taxIdValue = escapeHtml(customer.tax_id || "");
			const branchValue = escapeHtml(customer.branch || "");
			const termIdValue = escapeHtml(customer.credit_term_id || "");
			const termNameValue = escapeHtml(customer.credit_term_name || "");
			const creditLimitRaw = escapeHtml(customer.credit_limit ?? "");
			const creditLimitDisplay = escapeHtml(customer.credit_limit_display || "");
			const salesgroupValue = escapeHtml(customer.salesgroup || "");
			const addressLine = addressValue
				? `<div class="small text-muted">${addressValue}</div>`
				: "";
			const contactParts = [];
			if (phoneValue) contactParts.push(`โทร. ${phoneValue}`);
			if (faxValue) contactParts.push(`แฟกซ์ ${faxValue}`);
			if (emailValue) contactParts.push(emailValue);
			const contactLine = contactParts.length
				? `<div class="small text-secondary">${contactParts.join(" | ")}</div>`
				: "";
			const dueParts = [];
			if (customer.due_description)
				dueParts.push(escapeHtml(customer.due_description));
			if (customer.due_days)
				dueParts.push(`${escapeHtml(customer.due_days)} วัน`);
			const dueLine = dueParts.length
				? `<div class="small text-secondary">กำหนดชำระ: ${dueParts.join(
					" | "
				)}</div>`
				: "";
			const creditBadge = creditLimitDisplay
				? `<span class="badge bg-light text-dark ms-3">${creditLimitDisplay}</span>`
				: "";
			const firstNameAttr = escapeHtml(deriveContactName(rawName));

			return `
				<ul class="list-group mb-1">
					<a href="javascript:void(0)" class="selectCusCodeManualcode"
						data-addcus-code="${accountnum}"
						data-addcus-name="${name}"
						data-addcus-address="${addressValue}"
						data-addcus-phone="${phoneValue}"
						data-addcus-fax="${faxValue}"
						data-addcus-email="${emailValue}"
						data-addcus-taxid="${taxIdValue}"
						data-addcus-area="${area}"
						data-addcus-branch="${branchValue}"
						data-addcus-termid="${termIdValue}"
						data-addcus-termname="${termNameValue}"
						data-addcus-creditlimit="${creditLimitRaw}"
						data-addcus-firstname="${firstNameAttr}"
						data-addcus-salesgroup="${salesgroupValue}"
					>
						<li class="list-group-item d-flex justify-content-between align-items-start">
							<div class="me-3">
								<div class="fw-bold">${accountnum} ${name} (${area})</div>
								${addressLine}
								${contactLine}
								${dueLine}
							</div>
							${creditBadge}
						</li>
					</a>
				</ul>
			`;
		})
		.join("");

const renderSearchResults = (payload, targetSelector) => {
	const $target = $(targetSelector);
	if (
		payload &&
		payload.status === "success" &&
		Array.isArray(payload.results) &&
		payload.results.length > 0
	) {
		$target.html(buildCustomerListMarkup(payload.results));
		return;
	}

	const message = payload && payload.message ? payload.message : "ไม่พบข้อมูลที่ค้นหา";
	$target.html(
		`<div class="text-muted small p-2">${escapeHtml(message)}</div>`
	);
};

// Function to lock customer fields after selection
const lockCustomerFields = () => {
	$("#addcus_customercode").prop("readonly", true).addClass("bg-light");
	$("#addcus_customername").prop("readonly", true).addClass("bg-light");
	$("#addcus_customertaxid").prop("readonly", true).addClass("bg-light");
	// $("#addcus_customerbranch").prop("readonly", true).addClass("bg-light");
	$("#addcus_addressname").prop("readonly", true).addClass("bg-light");
	$("#addcus_telcontact").prop("readonly", true).addClass("bg-light");
	$("#addcus_faxcontact").prop("readonly", true).addClass("bg-light");
	$("#addcus_emailcontact").prop("readonly", true).addClass("bg-light");
	$("#addcus_namecontact").prop("readonly", true).addClass("bg-light");
	
	// Show reset button
	$("#btnResetCustomerSearch").fadeIn();
};

// Function to unlock customer fields
const unlockCustomerFields = () => {
	$("#addcus_customercode").prop("readonly", false).removeClass("bg-light");
	$("#addcus_customername").prop("readonly", false).removeClass("bg-light");
	$("#addcus_customertaxid").prop("readonly", false).removeClass("bg-light");
	// $("#addcus_customerbranch").prop("readonly", false).removeClass("bg-light");
	$("#addcus_addressname").prop("readonly", false).removeClass("bg-light");
	$("#addcus_telcontact").prop("readonly", false).removeClass("bg-light");
	$("#addcus_faxcontact").prop("readonly", false).removeClass("bg-light");
	$("#addcus_emailcontact").prop("readonly", false).removeClass("bg-light");
	$("#addcus_namecontact").prop("readonly", false).removeClass("bg-light");
	
	// Hide reset button
	$("#btnResetCustomerSearch").fadeOut();
};

// Function to clear customer data
const clearCustomerData = () => {
	// Refresh the page to reset all fields
	location.reload();
};

$(document).ready(() => {
	// Reset button click handler
	$("#btnResetCustomerSearch").click(() => {
		clearCustomerData();
	});

	$("#addcus_customercode").keyup(function () {
		const cuscode = $(this).val().trim();

		// Cancel previous timeout
		if (searchTimeout) {
			clearTimeout(searchTimeout);
		}

		// Cancel previous AJAX request
		if (currentRequest) {
			currentRequest.abort();
		}

		if (cuscode !== "") {
			// Show loading state
			$("#autocuscodemanual").html(
				'<div class="text-muted small p-2"><i>กำลังค้นหา...</i></div>'
			);

			// Debounce: รอ 300ms หลังจากพิมพ์ค่าสุดท้าย
			searchTimeout = setTimeout(() => {
				autosearchCustomermanual(cuscode);
			}, 300);
		} else {
			$("#autocuscodemanual").html("");
		}
	});

	// control addCustomer
	// Get customer data Zone add customer manual
	if ($("#checkaddcuspage").val() === "addCustomer") {
		// ตรวจสอบเงื่อนไขว่าเป็นบุคคลทั่วไปหรือว่า นิติบุคคล
		$('input:radio[name="crf_person_type"]').change(function () {
			if ($(this).val() === "natural") {
				$("#for_natural_manual").css("display", "");
				$("#labelDateCreate").text("วันเดือนปีเกิด");
				$(
					"#addcus_file1 , #addcus_file2 ,#addcus_file3,#addcus_file4,#addcus_file5,#addcus_file6"
				).prop("disabled", true);
			} else {
				$("#for_natural_manual").css("display", "none");
				$("#labelDateCreate").text("วันที่ก่อตั้ง");
				$(
					"#addcus_file1 , #addcus_file2 ,#addcus_file3,#addcus_file4,#addcus_file5,#addcus_file6"
				).prop("disabled", false);
			}

			if ($(this).val() === "juristic") {
				$("#for_juristic_manual").css("display", "");
				$("#labelDateCreate").text("วันที่ก่อตั้ง");
				$("#crf_file_person").prop("disabled", true);
			} else {
				$("#for_juristic_manual").css("display", "none");
				$("#labelDateCreate").text("วันเดือนปีเกิด");
				$("#crf_file_person").prop("disabled", false);
			}
		});

		$("#addcus_customername").keyup(function () {
			const cusname = $(this).val().trim();
			if (cusname !== "") {
				autosearchCustomermanualname(cusname);
			} else {
				$("#autocuscodemanualname").html("");
			}
		});

		$(document).on("click", ".selectCusCodeManualcode", function () {
			const data_addcus_code = $(this).attr("data-addcus-code");
			const data_addcus_name = $(this).attr("data-addcus-name");
			const data_addcus_address = $(this).attr("data-addcus-address");
			const data_addcus_phone = $(this).attr("data-addcus-phone");
			const data_addcus_fax = $(this).attr("data-addcus-fax");
			const data_addcus_email = $(this).attr("data-addcus-email");
			const data_addcus_taxid = $(this).attr("data-addcus-taxid");
			const data_addcus_area = $(this).attr("data-addcus-area");
			const data_addcus_branch = $(this).attr("data-addcus-branch");
			const data_addcus_termid = $(this).attr("data-addcus-termid");
			const data_addcus_termname = $(this).attr("data-addcus-termname");
			const data_addcus_creditlimit = $(this).attr("data-addcus-creditlimit");
			const data_addcus_firstname = $(this).attr("data-addcus-firstname");
			const data_addcus_salesgroup = $(this).attr("data-addcus-salesgroup");

			if (data_addcus_termname !== "") {
				$("#addcus_creditterm").attr("style", "pointer-events: none;");
				$("#alertOldCusCredit").html(
					'<span style="color:red;">** รายการ Credit term ไม่สามารถแก้ไขได้ เนื่องจากข้อมูลมาจาก ระบบ AX **</span>'
				);
			}
			if (data_addcus_creditlimit !== "") {
				$("#crf_finance_req_number").attr("readonly", true);
			}

			const baseUrl = `${window.location.origin}/intsys/crf`;

			$.ajax({
				url: `${baseUrl}/customers/fetchCustomercode`,
				method: "POST",
				data: {
					cuscode: data_addcus_code,
					areaid: data_addcus_area,
				},
				dataType: "json",
				timeout: 10000,
				success: function (data) {
					console.log("Check duplicate result:", data.result);
					if (data.result > 0) {
						$("#alertCuscode").fadeIn();
						$("#alertCuscode")
							.html(
								'<div class="alert alert-danger" role="alert">พบข้อมูลซ้ำในระบบ</div>'
							)
							.fadeOut(3500);
						$("#addcus_customercode").val("");
						$("#autocuscodemanual").html("");
                        clearCustomerData();
                        $("#addcus_customercode").focus();
					} else {
						// Populate form fields
						$("#addcus_customercode").val(data_addcus_code);
						$("#addcus_customername").val(data_addcus_name);
						$("#addcus_addressname").val(data_addcus_address);
						$("#addcus_telcontact").val(data_addcus_phone);
						$("#addcus_faxcontact").val(data_addcus_fax);
						$("#addcus_emailcontact").val(data_addcus_email);
						$("#addcus_customertaxid").val(data_addcus_taxid);
						$("#addcus_customerbranch").val(data_addcus_branch);
						$("#addcus_creditterm option:selected")
							.val(data_addcus_termid)
							.text(data_addcus_termname);
						$("#crf_finance_req_number").val(data_addcus_creditlimit);
						$("#addcus_namecontact").val(data_addcus_firstname);
						$("#addcus_salesreps")
							.val(data_addcus_salesgroup)
							.prop("readonly", true);

						$('input:radio[id="addcus_addresstype1"]').prop("checked", true);

						// Convert Currency to comma
						$("input[name=addcus_regiscost]").keyup(function (event) {
							/*****Comma function*******/
							// skip for arrow keys
							if (event.which >= 37 && event.which <= 40) return;

							// format number
							$(this).val(function (index, value) {
								return value
									.replace(/\D/g, "")
									.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
							});
						});

						// Select company radio button
						if (data_addcus_area === "sln") {
							$('input:radio[id="addcus_company_sln"]').prop("checked", true);
						} else if (data_addcus_area === "poly") {
							$('input:radio[id="addcus_company_poly"]').prop("checked", true);
						} else if (data_addcus_area === "ca") {
							$('input:radio[id="addcus_company_ca"]').prop("checked", true);
						} else if (data_addcus_area === "tbb") {
							$('input:radio[id="addcus_company_tb"]').prop("checked", true);
						} else if (data_addcus_area === "st") {
							$('input:radio[id="addcus_company_st"]').prop("checked", true);
						}

						$("#autocuscodemanual").html("");
						$("#autocuscodemanualname").html("");
						
						// Lock fields after successful selection
						lockCustomerFields();
					}
				},
				error: function (xhr, status, error) {
					console.error("Error checking duplicate:", error);
					$("#alertCuscode")
						.html(
							'<div class="alert alert-danger" role="alert">เกิดข้อผิดพลาดในการตรวจสอบข้อมูล</div>'
						)
						.fadeOut(3500);
				},
			});
		});
	}
	// Control by page
});

const autosearchCustomermanual = (cuscode) => {
	// Get base URL dynamically
	const baseUrl = `${window.location.origin}/intsys/crf`;

	// Store AJAX request reference
	currentRequest = $.ajax({
		url: `${baseUrl}/customers/searchcustomerdata`,
		method: "POST",
		data: { cuscode },
		dataType: "json",
		timeout: 10000, // 10 second timeout
		success: (data) => {
			renderSearchResults(data, "#autocuscodemanual");
			currentRequest = null;
		},
		error: (xhr, status, error) => {
			// Don't show error if request was aborted
			if (status !== "abort") {
				$("#autocuscodemanual").html(
					`<div class="alert alert-warning small" role="alert">
						เกิดข้อผิดพลาดในการค้นหา กรุณาลองใหม่อีกครั้ง
					</div>`
				);
			}
			currentRequest = null;
		},
	});
};

const autosearchCustomermanualname = (cusname) => {
	// Get base URL dynamically
	const baseUrl = `${window.location.origin}/intsys/crf`;

	$.ajax({
		url: `${baseUrl}/customers/searchcustomerdataname`,
		method: "POST",
		data: { cusname },
		dataType: "json",
		timeout: 10000, // 10 second timeout
		success: (data) => {
			renderSearchResults(data, "#autocuscodemanualname");
		},
		error: (xhr, status, error) => {
			$("#autocuscodemanualname").html(
				`<div class="alert alert-warning small" role="alert">
					เกิดข้อผิดพลาดในการค้นหา กรุณาลองใหม่อีกครั้ง
				</div>`
			);
		},
	});
};

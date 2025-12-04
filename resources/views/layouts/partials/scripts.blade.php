<script type="text/javascript" src="{{ asset('assets/mdb/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/mdb/js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/mdb/js/bootstrap.min.js') }}"></script>
{{-- <script type="text/javascript" src="{{ asset('assets/mdb/js/mdb.min.js') }}"></script> --}}
<script type="text/javascript" src="{{ asset('assets/mdb/js/addons/datatables.min.js') }}"></script>
{{-- <script src="{{ asset('assets/js/nepali.datepicker.v3.min.js') }}" type="text/javascript"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
{{-- <script
src="http://nepalidatepicker.sajanmaharjan.com.np/nepali.datepicker/js/nepali.datepicker.v4.0.4.min.js"
type="text/javascript"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</script>
@livewireScripts
<script src="{{ asset('nepali-date-picker.min.js') }}"></script>
<script>
    jQuery(document).ready(function() {
        $('.date-picker').nepaliDatePicker();
    })
</script>

<script>
    $(document).ready(() => {

         $("#kshati_document_edit_btn").on('click', () => {
            $("#kshati_document").addClass('d-none');
            $("#kshati_document_form").removeClass('d-none');
            $("#kshati_document_form").addClass('d-flex');
            document.getElementById('kshati_document_div').style.padding = 0;
            $("#kshati_document_edit_btn").addClass('d-none');
            $("#kshati_document_calcel_btn").removeClass('d-none');
        });

          $("#kshati_document_calcel_btn").on('click', () => {
            $("#kshati_document").removeClass('d-none');
            $("#kshati_document_form").addClass('d-none');
            $("#kshati_document_form").removeClass('d-flex');
            document.getElementById('kshati_document_div').style.padding = '10px';
            $("#kshati_document_edit_btn").removeClass('d-none');
            $("#kshati_document_calcel_btn").addClass('d-none');
        });


        $("#hospital_document_edit_btn").on('click', () => {
            $("#hospital_document").addClass('d-none');
            $("#hospital_document_form").removeClass('d-none');
            $("#hospital_document_form").addClass('d-flex');
            document.getElementById('hospital_document_div').style.padding = 0;
            $("#hospital_document_edit_btn").addClass('d-none');
            $("#hospital_document_calcel_btn").removeClass('d-none');
        });

        $("#hospital_document_calcel_btn").on('click', () => {
            $("#hospital_document").removeClass('d-none');
            $("#hospital_document_form").addClass('d-none');
            $("#hospital_document_form").removeClass('d-flex');
            document.getElementById('hospital_document_div').style.padding = '10px';
            $("#hospital_document_edit_btn").removeClass('d-none');
            $("#hospital_document_calcel_btn").addClass('d-none');
        });

        // =====================
        $("#disease_proved_document_edit_btn").on('click', () => {
            $("#disease_proved_document").addClass('d-none');
            $("#disease_proved_document_form").removeClass('d-none');
            $("#disease_proved_document_form").addClass('d-flex');
            document.getElementById('disease_proved_document_div').style.padding = 0;
            $("#disease_proved_document_edit_btn").addClass('d-none');
            $("#disease_proved_document_calcel_btn").removeClass('d-none');
        });

        $("#disease_proved_document_calcel_btn").on('click', () => {
            $("#disease_proved_document").removeClass('d-none');
            $("#disease_proved_document_form").addClass('d-none');
            $("#disease_proved_document_form").removeClass('d-flex');
            document.getElementById('disease_proved_document_div').style.padding = '10px';
            $("#disease_proved_document_edit_btn").removeClass('d-none');
            $("#disease_proved_document_calcel_btn").addClass('d-none');
        });

        // =====================
        $("#citizenship_card_document_edit_btn").on('click', () => {
            $("#citizenship_card_document").addClass('d-none');
            $("#citizenship_card_document_form").removeClass('d-none');
            $("#citizenship_card_document_form").addClass('d-flex');
            document.getElementById('citizenship_card_document_div').style.padding = 0;
            $("#citizenship_card_document_edit_btn").addClass('d-none');
            $("#citizenship_card_document_calcel_btn").removeClass('d-none');
        });

        $("#citizenship_card_document_calcel_btn").on('click', () => {
            $("#citizenship_card_document").removeClass('d-none');
            $("#citizenship_card_document_form").addClass('d-none');
            $("#citizenship_card_document_form").removeClass('d-flex');
            document.getElementById('citizenship_card_document_div').style.padding = '10px';
            $("#citizenship_card_document_edit_btn").removeClass('d-none');
            $("#citizenship_card_document_calcel_btn").addClass('d-none');
        });

        // =====================
        $("#application_document_edit_btn").on('click', () => {
            $("#application_document").addClass('d-none');
            $("#application_document_form").removeClass('d-none');
            $("#application_document_form").addClass('d-flex');
            document.getElementById('application_document_div').style.padding = 0;
            $("#application_document_edit_btn").addClass('d-none');
            $("#application_document_calcel_btn").removeClass('d-none');
        });

        $("#application_document_calcel_btn").on('click', () => {
            $("#application_document").removeClass('d-none');
            $("#application_document_form").addClass('d-none');
            $("#application_document_form").removeClass('d-flex');
            document.getElementById('application_document_div').style.padding = '10px';
            $("#application_document_edit_btn").removeClass('d-none');
            $("#application_document_calcel_btn").addClass('d-none');
        });

        // =====================
        $("#doctor_recomandation_document_edit_btn").on('click', () => {
            $("#doctor_recomandation_document").addClass('d-none');
            $("#doctor_recomandation_document_form").removeClass('d-none');
            $("#doctor_recomandation_document_form").addClass('d-flex');
            document.getElementById('doctor_recomandation_document_div').style.padding = 0;
            $("#doctor_recomandation_document_edit_btn").addClass('d-none');
            $("#doctor_recomandation_document_calcel_btn").removeClass('d-none');
        });
        $("#doctor_recomandation_document_calcel_btn").on('click', () => {
            $("#doctor_recomandation_document").removeClass('d-none');
            $("#doctor_recomandation_document_form").addClass('d-none');
            $("#doctor_recomandation_document_form").removeClass('d-flex');
            document.getElementById('doctor_recomandation_document_div').style.padding = '10px';
            $("#doctor_recomandation_document_edit_btn").removeClass('d-none');
            $("#doctor_recomandation_document_calcel_btn").addClass('d-none');
        });

        // =====================
        $("#bank_cheque_document_edit_btn").on('click', () => {
            $("#bank_cheque_document").addClass('d-none');
            $("#bank_cheque_document_form").removeClass('d-none');
            $("#bank_cheque_document_form").addClass('d-flex');
            document.getElementById('bank_cheque_document_div').style.padding = 0;
            $("#bank_cheque_document_edit_btn").addClass('d-none');
            $("#bank_cheque_document_calcel_btn").removeClass('d-none');
        });
        $("#bank_cheque_document_calcel_btn").on('click', () => {
            $("#bank_cheque_document").removeClass('d-none');
            $("#bank_cheque_document_form").addClass('d-none');
            $("#bank_cheque_document_form").removeClass('d-flex');
            document.getElementById('bank_cheque_document_div').style.padding = '10px';
            $("#bank_cheque_document_edit_btn").removeClass('d-none');
            $("#bank_cheque_document_calcel_btn").addClass('d-none');
        });

        // =====================
        $("#decision_document_document_edit_btn").on('click', () => {
            $("#decision_document_document").addClass('d-none');
            $("#decision_document_document_form").removeClass('d-none');
            $("#decision_document_document_form").addClass('d-flex');
            document.getElementById('decision_document_document_div').style.padding = 0;
            $("#decision_document_document_edit_btn").addClass('d-none');
            $("#decision_document_document_calcel_btn").removeClass('d-none');
        });
        $("#decision_document_document_calcel_btn").on('click', () => {
            $("#decision_document_document").removeClass('d-none');
            $("#decision_document_document_form").addClass('d-none');
            $("#decision_document_document_form").removeClass('d-flex');
            document.getElementById('decision_document_document_div').style.padding = '10px';
            $("#decision_document_document_edit_btn").removeClass('d-none');
            $("#decision_document_document_calcel_btn").addClass('d-none');
        });

        // =====================
        $("#renewing_document_edit_btn").on('click', () => {
            $("#renewing_document").addClass('d-none');
            $("#renewing_document_form").removeClass('d-none');
            $("#renewing_document_form").addClass('d-flex');
            document.getElementById('renewing_document_div').style.padding = 0;
            $("#renewing_document_edit_btn").addClass('d-none');
            $("#renewing_document_calcel_btn").removeClass('d-none');
        });
        $("#renewing_document_calcel_btn").on('click', () => {
            $("#renewing_document").removeClass('d-none');
            $("#renewing_document_form").addClass('d-none');
            $("#renewing_document_form").removeClass('d-flex');
            document.getElementById('renewing_document_div').style.padding = '10px';
            $("#renewing_document_edit_btn").removeClass('d-none');
            $("#renewing_document_calcel_btn").addClass('d-none');
        });

        // =====================
        $("#closing_document_edit_btn").on('click', () => {
            $("#closing_document").addClass('d-none');
            $("#closing_document_form").removeClass('d-none');
            $("#closing_document_form").addClass('d-flex');
            document.getElementById('closing_document_div').style.padding = 0;
            $("#closing_document_edit_btn").addClass('d-none');
            $("#closing_document_calcel_btn").removeClass('d-none');
        });
        $("#closing_document_calcel_btn").on('click', () => {
            $("#closing_document").removeClass('d-none');
            $("#closing_document_form").addClass('d-none');
            $("#closing_document_form").removeClass('d-flex');
            document.getElementById('closing_document_div').style.padding = '10px';
            $("#closing_document_edit_btn").removeClass('d-none');
            $("#closing_document_calcel_btn").addClass('d-none');
        })
    })
</script>

<script>
    function toggleSidebar() {
        document.getElementsByTagName('body')[0].classList.toggle('sidebar-opened')
    }
    document.onkeydown = function(e) {
        if (e.ctrlKey && e.shiftKey && e.keyCode === 83) {
            toggleSidebar();
        }
    };

    function filterOptions(searchTerm, targets, dataKey) {
        $(targets).each(function() {
            if ($(this).data(dataKey) == searchTerm) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    $(function() {
        $('[data-toggle="tooltip"]').tooltip();

        if ($('.nepali-date')[0]) {
            $('.nepali-date').nepaliDatePicker({
                // disableDaysAfter: 1,
                ndpYear: true,
                ndpMonth: true,
                ndpYearCount: 10,
                disableDaysAfter: 0,
            });
        }

        if ($('.nepali-date1')[0]) {
            $('.nepali-date1').nepaliDatePicker({
                disableDaysAfter: 1,
                ndpYear: true,
                ndpMonth: true,
                ndpYearCount: 10
            });
        }

        var today = NepaliFunctions.ConvertDateFormat(NepaliFunctions.GetCurrentBsDate('YYYY-MM-DD'),
            'YYYY-MM-DD');
        $(".date-today[value='']").val(today);

    });
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            width: '100%',
            dropdownCssClass: 'custom-dropdown',
        });
    });
</script>
<script type="text/javascript">
    window.onload = function() {
        var mainInput = document.getElementById("nepali-datepicker");
        if (mainInput) {

            mainInput.nepaliDatePicker({
                disableDaysAfter: 1,
                ndpYear: true,
                ndpMonth: true,
                ndpYearCount: 10
            });
        }
        var mainInput1 = document.getElementById("nepali-datepicker1");
        if (mainInput1) {

            mainInput1.nepaliDatePicker({
                disableDaysAfter: 1,
                ndpMonth: true,
            });
        }
    };
</script>
@stack('scripts')
<script>
    $(document).ready(function() {
        $(".nav-group").on('click', function() {
            $('.nav-group').removeClass('active');
            $(this).addClass('active');
        })
    })
</script>
<script>
    $(document).ready(function() {
        $('#sidebarCollapse').on('click', function() {
            $("#sidebarCollapse").removeClass('active')
            $('#sidebar').toggleClass('active');
        });
    });
</script>

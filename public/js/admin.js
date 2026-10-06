/* MLEB - admin.js v3 | DataTables by ID, bukan by class */

/**
 * Toast notification global (pakai SweetAlert2).
 * Otomatis hilang sendiri setelah beberapa detik.
 * icon: 'success' | 'error' | 'warning' | 'info'
 */
function mlebToast(icon, title, timer) {
    if (typeof Swal === 'undefined' || !title) return;
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: icon,
        title: title,
        showConfirmButton: false,
        timer: timer || 4000,
        timerProgressBar: true,
        didOpen: function (toast) {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });
}

$(document).ready(function () {

    // Alert lama (jika masih ada) tetap auto-hilang setelah 4 detik
    $('.alert.fade.show').each(function () {
        var el = this;
        setTimeout(function () {
            var bsAlert = bootstrap.Alert.getOrCreateInstance(el);
            if (bsAlert) bsAlert.close();
        }, 4000);
    });

    // ── SIDEBAR TOGGLE ──────────────────────────────────
    var $sidebar = $('#sidebar');
    var $overlay = $('<div class="sidebar-overlay"></div>').appendTo('body');

    $('#sidebarToggle').on('click', function () {
        $sidebar.toggleClass('show');
        $overlay.toggleClass('show');
    });
    $overlay.on('click', function () {
        $sidebar.removeClass('show');
        $overlay.removeClass('show');
    });

    // ── DATATABLES — inisialisasi per ID ─────────────────
    // Setiap tabel diberi ID unik, bukan class .datatable
    var dtConfig = {
        pageLength:  15,
        lengthMenu:  [10, 15, 25, 50, 100],
        ordering:    true,
        autoWidth:   false,
        responsive:  false,
        language: {
            search:         '<i class="bi bi-search me-1"></i> Cari:',
            searchPlaceholder: 'Ketik untuk mencari...',
            lengthMenu:     'Tampilkan _MENU_ baris',
            info:           'Menampilkan _START_–_END_ dari _TOTAL_ data',
            infoEmpty:      'Tidak ada data',
            infoFiltered:   '(difilter dari _MAX_ data)',
            zeroRecords:    'Data tidak ditemukan',
            emptyTable:     'Belum ada data',
            paginate: {
                first:    '&laquo;',
                last:     '&raquo;',
                next:     '&rsaquo;',
                previous: '&lsaquo;',
            },
        },
        dom:
        '<"row align-items-center mb-3"' +
            '<"col-md-6"f>' +
            '<"col-md-6 text-end"l>' +
        '>' +
        't' +
        '<"row align-items-center mt-3"' +
            '<"col-md-6"i>' +
            '<"col-md-6 text-end"p>' +
        '>',
        initComplete: function () {
            // Tambah class Bootstrap ke input search DataTables
            $('#' + this.api().table().node().id + '_filter input')
                .addClass('form-control form-control-sm');
            $('#' + this.api().table().node().id + '_length select')
                .addClass('form-select form-select-sm d-inline-block w-auto');
        },
    };

    // Inisialisasi setiap tabel dengan ID spesifik
    var tableIds = [
        'tbl-jenis-tiket',
        'tbl-bundling',
        'tbl-jadwal',
        'tbl-kesan',
        'tbl-informasi',
    ];

    tableIds.forEach(function (id) {
        var $el = $('#' + id);
        if ($el.length && !$.fn.DataTable.isDataTable('#' + id)) {
            $('#' + id).DataTable(dtConfig);
        }
    });

    // ── CONFIRM (SweetAlert2) ────────────────────────────
    $(document).on('click', '[data-confirm]', function (e) {
        e.preventDefault();
        var msg  = $(this).data('confirm') || 'Yakin ingin melanjutkan?';
        var form = $(this).closest('form')[0];
        var href = $(this).attr('href');

        Swal.fire({
            title: 'Konfirmasi',
            text:  msg,
            icon:  'warning',
            showCancelButton:   true,
            confirmButtonColor: '#0f3460',
            cancelButtonColor:  '#6b7280',
            confirmButtonText:  'Ya, Lanjutkan',
            cancelButtonText:   'Batal',
            reverseButtons:     true,
        }).then(function (result) {
            if (result.isConfirmed) {
                if (form) form.submit();
                else if (href) window.location.href = href;
            }
        });
    });

    // ── AUTO DISMISS ALERTS ──────────────────────────────
    setTimeout(function () {
        $('.alert.alert-success, .alert.alert-info').fadeOut(400, function () {
            $(this).remove();
        });
    }, 5000);

    // ── IMAGE PREVIEW ────────────────────────────────────
    $(document).on('change', 'input[type="file"][data-preview]', function () {
        var pid   = $(this).data('preview');
        var $prev = $('#' + pid);
        var file  = this.files[0];
        if (!file || !$prev.length) return;
        var reader = new FileReader();
        reader.onload = function (e) { $prev.attr('src', e.target.result).show(); };
        reader.readAsDataURL(file);
    });

    // ── COPY TO CLIPBOARD ────────────────────────────────
    $(document).on('click', '[data-copy]', function () {
        var text = $(this).data('copy');
        if (!navigator.clipboard) return;
        navigator.clipboard.writeText(String(text)).then(function () {
            Swal.fire({
                toast: true, position: 'top-end', icon: 'success',
                title: 'Berhasil disalin!', showConfirmButton: false, timer: 1500,
            });
        });
    });

    // ── SELECT ALL CHECKBOX ──────────────────────────────
    $('#checkAll').on('change', function () {
        $('.check-item').prop('checked', this.checked);
    });

});

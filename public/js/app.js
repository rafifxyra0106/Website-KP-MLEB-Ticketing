/* MLEB - app.js */

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

document.addEventListener('DOMContentLoaded', function () {

    // Alert lama (jika masih ada di suatu halaman) tetap auto-hilang setelah 4 detik
    document.querySelectorAll('.alert.fade.show').forEach(function (el) {
        setTimeout(function () {
            var bsAlert = bootstrap.Alert.getOrCreateInstance(el);
            if (bsAlert) bsAlert.close();
        }, 4000);
    });

    // SweetAlert confirm delete
    document.querySelectorAll('[data-confirm]').forEach(function (el) {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            const msg  = this.dataset.confirm || 'Yakin ingin menghapus data ini?';
            const form = this.closest('form') || document.getElementById(this.dataset.form);
            const href = this.href;

            Swal.fire({
                title: 'Konfirmasi',
                text: msg,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0f3460',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Batal',
            }).then(function (result) {
                if (result.isConfirmed) {
                    if (form) form.submit();
                    else if (href) window.location.href = href;
                }
            });
        });
    });

    // Image preview
    document.querySelectorAll('input[type="file"][data-preview]').forEach(function (input) {
        var previewId = input.dataset.preview;
        var preview   = document.getElementById(previewId);
        if (!preview) return;
        input.addEventListener('change', function () {
            var file = this.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    });

    // Copy to clipboard
    document.querySelectorAll('[data-copy]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var text = this.dataset.copy;
            navigator.clipboard.writeText(text).then(function () {
                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Berhasil disalin!', showConfirmButton: false, timer: 1500 });
            });
        });
    });

    // Auto calculate subtotal on reservasi form
    recalcTotal();
    document.addEventListener('change', function (e) {
        if (e.target.matches('[data-qty]') || e.target.matches('[data-tiket-check]')) {
            recalcTotal();
        }
    });
    document.addEventListener('input', function (e) {
        if (e.target.matches('[data-qty]')) recalcTotal();
    });

    function recalcTotal() {
        var total = 0;
        document.querySelectorAll('.tiket-qty-row').forEach(function (row) {
            var check = row.querySelector('[data-tiket-check]');
            var qty   = row.querySelector('[data-qty]');
            var harga = parseFloat(row.dataset.harga || 0);
            var sub   = row.querySelector('[data-subtotal]');
            if (check && !check.checked) { if (sub) sub.textContent = 'Rp 0'; return; }
            var q = parseInt(qty ? qty.value : 1) || 0;
            var s = harga * q;
            total += s;
            if (sub) sub.textContent = 'Rp ' + s.toLocaleString('id-ID');
        });
        var totalEl = document.getElementById('grand-total');
        if (totalEl) totalEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
    }
});

function formatRupiah(n) {
    return 'Rp ' + parseInt(n).toLocaleString('id-ID');
}

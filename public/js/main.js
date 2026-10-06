document.addEventListener('DOMContentLoaded', function () {
    var toggleBtn = document.getElementById('toggleSidebar');
    var sidebar = document.getElementById('adminSidebar');
    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('show');
        });
    }
});

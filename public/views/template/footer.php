</div>
<!-- end quick Info -->
</div>
<!-- end content -->
</div>
<!-- end wrapper -->

<!-- script -->
<script src=" https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="<?= BASE_URL; ?>/public/views/assets/js/scripts.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("submitBtn").addEventListener("click", function() {
            this.disabled = true;
            this.form.submit();
        });
    });
</script>
<!-- end script -->

</body>

</html>
<h1 class="mt-4">Reportes</h1>

<div class="row mt-5">
    <!-- Left Column: Graphics -->
    <div class="col-lg-4 col-md-12">
        <form method="post" action="/exportcsv">
            <div class="mb-3">
                <label for="start_date" class="form-label">FECHA INICIO:</label>
                <input type="date" id="start_date" name="start_date" class="form-control">
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">FECHA FIN:</label>
                <input type="date" id="end_date" name="end_date" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">DESCARGAR CSV</button>
        </form>
    </div>
</div>
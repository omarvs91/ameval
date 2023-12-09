<div class="row justify-content-center">
    <div class="col-lg-10">
        <h1 class="mb-5">REGISTRO DE COMPROBANTE</h1>
        <form method="post" action="/submit_comprobante">
            <div class="row g-5">
                <div class="col-lg-8 col-md-12">
                    <div class="row mb-4">
                        <div class="col-md-12 input-group-lg">
                            <select class="form-select is-required" name="clienteDropdown" id="clienteDropdown" required>
                                <!-- Clientes will be populated here through js -->
                            </select>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <select class="form-select is-required" name="metodopagoDropdown" id="metodopagoDropdown" required>                                
                                <!-- Metodo de Pago will be populated here through JavaScript -->
                            </select>
                        </div>
                        <div class="col-md-6 d-grid gap-2">
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check" name="btnradio" id="btnradio1" value="N"
                                    autocomplete="off" checked>
                                <label class="btn btn-outline-primary" for="btnradio1">NOTA DE VENTA</label>

                                <input type="radio" class="btn-check" name="btnradio" id="btnradio2" value="B"
                                    autocomplete="off">
                                <label class="btn btn-outline-primary" for="btnradio2">BOLETA</label>

                                <input type="radio" class="btn-check" name="btnradio" id="btnradio3" value="F"
                                    autocomplete="off">
                                <label class="btn btn-outline-primary" for="btnradio3">FACTURA</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <input type="number" name="num_ruc" id="num_ruc" class="form-control"
                                placeholder="N° DE RUC" disabled>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="razon_social" id="razon_social" class="form-control"
                                placeholder="RAZON SOCIAL" disabled>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-8 input-group-lg">
                            <select class="form-select is-required" name="servicioDropdown" id="servicioDropdown">
                                <!-- Servicios will be populated here through JavaScript -->
                            </select>
                        </div>
                        <div class="col-md-4 d-grid gap-2">
                            <button class="btn btn-primary" id="addRowButton">AÑADIR</button>
                        </div>
                    </div>
                    <!-- START TABLE -->
                    <div class="row mb-5 pb-5">
                        <div class="col-md-12">
                            <table class="table table-hover" id="productTableBody">
                                <thead>
                                    <tr>
                                        <th scope="col">SERVICIO</th>
                                        <th scope="col">PESO EN KG</th>
                                        <th scope="col" style="text-align: center;">PRECIO POR KG (S/.)</th>
                                        <th scope="col" style="text-align: center;">TOTAL (S/.)</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END TABLE -->
                </div>
                <div class="col-lg-4 col-md-12">
                    <!-- START TOTAL + SUBMIT BUTTON -->
                    <div class="row total-block">
                        <h5>OP. GRAVADAS: <span id="sub_total_register"></span></h5>
                        <h5 class="mb-4">IGV 18%: <span id="igv_register"></span></h5>
                        <h5>TOTAL A PAGAR: <span id="total_register"></span></h5>
                    </div>
                    <div class="row">
                        <div class="d-grid gap-2 py-2">
                            <h5 style="font-weight: bold;">MONTO ABONADO:</h5>
                            <input class="form-control" type="number" step="0.01" id="monto_abonado" name="monto_abonado">
                        </div>
                    </div>
                    <div class="row total-block">
                        <div class="d-grid gap-2 pt-4 pb-2">
                            <h5>OBSERVACIONES:</h5>                            
                            <textarea name="comprobante_observaciones" id="comprobante_observaciones" class="form-control" rows="3"></textarea>
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="d-grid gap-2 py-4">
                            <button id="btn_registrar_comprobante" class="btn btn-success btn-lg">REGISTRAR</button>
                        </div>
                    </div>
                    <!-- END TOTAL + SUBMIT BUTTON -->
                </div>
            </div>
        </form>
    </div>
</div>
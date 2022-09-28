<div>
    <!--========================
    TITULO
    ========================-->
    <!-- <div class="row">

        <div class="col-md-12 ">
            <h3 style="font-weight: bold;">Peticiones Recibidas</h3>
        </div>

    </div> -->

    <!--========================
    BOTÓN AGREGAR PETICIÓN
    ========================-->
    <div class="row">

        <div class="col-md-12">

            <div>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAgregar" style="margin-bottom: 5px; margin-top: 5px;">
                    Agregar
                </button>
            </div>

        </div>

    </div>

    <!--========================
    ICONOS DE REFERENCIA
    ========================-->
    <div class="row">

        <div class="col-md-12">

            <label class="referencia">
                <i style="color: green;" class="tam-i bi bi-check-circle-fill" aria-hidden="true"></i>Completado
            </label>

            <label class="referencia">
                <i style="color: #2995B8;" class="tam-i bi bi-laptop-fill" aria-hidden="true"></i>Desarrollo
            </label>

            <label class="referencia">
                <i style="color: orange;" class="tam-i bi bi-exclamation-triangle-fill" aria-hidden="true"></i>Pendiente
            </label>

            <label class="referencia">
                <i style="color: red;" class="tam-i bi bi-x-circle-fill" aria-hidden="true"></i>Rechazado
            </label>

        </div>
    </div>

    <!--========================
    TABLA
    ========================-->
    <div class="row">

        <div class="col-md-12">

            <!-- AQUI SE GENERA LA TABLA -->
            <div id="displayDataTable">

            </div>

        </div>
    </div>
</div>
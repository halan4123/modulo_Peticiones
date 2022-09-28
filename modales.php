 <!--========================
    MODAL AGREGAR PETICION
    ========================-->
    <div id="modalAgregar" class="modal fade" role="dialog" data-backdrop="static">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header modal-color">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Agregar</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="asuntoAdd">Asunto:</label>
                        <input type="text" class="form-control" id="asuntoAdd" placeholder="Asunto">
                    </div>


                    <div class="form-group">
                        <label for="laboratorioAdd">Laboratorio:</label>
                        <select class="form-control" id="laboratorioAdd" style="width: 100%;">

                            <!-- <option value='0'>Seleccionar</option> -->

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="soporteAdd">Soporte:</label>
                        <select class="form-control" id="soporteAdd" style="width: 100%;">

                            <!-- <option value='0'>Seleccionar</option> -->

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="descripcionAdd">Descripción:</label>
                        <textarea class="form-control" rows="15" id="descripcionAdd" placeholder="Descripción"></textarea>
                    </div>

                    <input type="hidden" id="fechaEntregaEstimadaAdd" value="0000-00-00 00:00:00">

                    <input type="hidden" id="fechaCompletadoAdd" value="0000-00-00 00:00:00">

                    <input type="hidden" id="nivelAdd" value="<?php echo $ID_NIVEL ?>">

                    <input type="hidden" id="estatusAdd" value="<?php echo $ID_ESTATUS ?>">


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal" onclick="agregar()">Agregar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>

        </div>
    </div>

    <!--========================
    MODAL INFORMACIÓN PETICION
    ========================-->
    <div id="modalVer" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header modal-color">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Consultar</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="idSee">id</label>
                        <input type="text" class="form-control" id="idSee" disabled>
                    </div>

                    <div class="form-group">
                        <label for="asuntoSee">Asunto:</label>
                        <input type="text" class="form-control" id="asuntoSee" disabled>
                    </div>

                    <div class="form-group">
                        <label for="laboratorioSee">Laboratorio:</label>
                        <input type="text" class="form-control" id="laboratorioSee" disabled>
                    </div>

                    <div class="form-group">
                        <label for="fecha_llegadaSee">Fecha de solicitud:</label>
                        <input type="text" class="form-control" id="fecha_llegadaSee" disabled>
                    </div>

                    <div class="form-group">
                        <label for="fecha_entregaSee">Fecha de entrega:</label>
                        <input type="text" class="form-control" id="fecha_entregaSee" disabled>
                    </div>

                    <div class="form-group">
                        <label for="fecha_completadoSee">Fecha de completado:</label>
                        <input type="text" class="form-control" id="fecha_completadoSee" disabled>
                    </div>

                    <div class="form-group">
                        <label for="soporteSee">Soporte:</label>
                        <input type="text" class="form-control" id="soporteSee" disabled>
                    </div>

                    <div class="form-group">
                        <label for="desarrolladorSee">Desarrollador:</label>
                        <input type="text" class="form-control" id="desarrolladorSee" disabled>
                    </div>

                    <div class="form-group">
                        <label for="nivelSee">Nivel:</label>
                        <input type="text" class="form-control" id="nivelSee" disabled>
                    </div>

                    <div class="form-group">
                        <label for="estatusSee">Estatus:</label>
                        <input type="text" class="form-control" id="estatusSee" disabled>
                    </div>

                    <div class="form-group">
                        <label for="descripcionSee">Descripción:</label>
                        <textarea class="form-control" rows="5" id="descripcionSee" disabled></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

                </div>
            </div>

        </div>
    </div>

    <!--========================
    MODAL EDITAR PETICION
    ========================-->
    <div id="modalEditar" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header modal-color">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="asuntoUpdate">Asunto:</label>
                        <input type="text" class="form-control" id="asuntoUpdate">
                    </div>

                    <div class="form-group">
                        <label for="laboratorioUpdate">Laboratorio:</label>
                        <select class="form-control" id="laboratorioUpdate" style="width: 100%;">

                            <!-- <option value='0'>Seleccionar</option> -->

                        </select>
                    </div>

                    <!-- <div class="form-group">
                        <label for="fecha_llegadaUpdate">Fecha de solicitud:</label>
                        <input type="text" class="form-control" id="fecha_llegadaUpdate" disabled>
                    </div> -->

                    <div class="form-group">
                        <label for="fecha_entregaUpdate">Fecha de entrega:</label>
                        <input type="datetime-local" class="form-control" id="fecha_entregaUpdate">
                    </div>

                    <!-- <div class="form-group">
                        <label for="fecha_completadoUpdate">Fecha de completado:</label>
                        <input type="text" class="form-control" id="fecha_completadoUpdate" disabled>
                    </div>

                    <div class="form-group">
                        <label for="soporteUpdate">Soporte:</label>
                        <input type="text" class="form-control" id="soporteUpdate" disabled>
                    </div> -->

                    <div class="form-group">
                        <label for="desarrolladorUpdate">Desarrollador:</label>
                        <select class="form-control" id="desarrolladorUpdate" style="width: 100%;">

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nivelUpdate">Nivel:</label>
                        <select class="form-control" id="nivelUpdate" style="width: 100%;">

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="estatusUpdate">Estatus:</label>
                        <select class="form-control" id="estatusUpdate" style="width: 100%;">

                        </select>
                    </div>

                    <!-- <div class="form-group">
                        <label for="estatusUpdate">Estatus:</label>
                        <input type="text" class="form-control" id="estatusUpdate">
                    </div> -->

                    <div class="form-group">
                        <label for="descripcionUpdate">Descripción:</label>
                        <textarea class="form-control" rows="15" id="descripcionUpdate"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal" onclick="actualizar()">Actualizar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <input type="hidden" id="idHidden">
                </div>
            </div>

        </div>
    </div>

    <!--========================
    MODAL AGREGAR DESARROLLADOR
    ========================-->
    <div id="modalAgregarDesarrollador" class="modal fade" role="dialog" data-backdrop="static">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header modal-color">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Agregar Desarrollador</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="nombreDesarrolladorAdd">Nombre(s):</label>
                        <input type="text" class="form-control" id="nombreDesarrolladorAdd" placeholder="Nombre(s)">
                    </div>

                    <div class="form-group">
                        <label for="apellidoDesarrolladorAdd">Apellido(s):</label>
                        <input type="text" class="form-control" id="apellidoDesarrolladorAdd" placeholder="Apellido(s)">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal" onclick="agregarDesarrollador()">Agregar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>

        </div>
    </div>

    <!--========================
    MODAL INFO DESARROLLADOR
    ========================-->
    <div id="modalInfoDesarrollador" class="modal fade" role="dialog" data-backdrop="static">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header modal-color">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Consultar Desarrollador</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="idDesarrolladorSee">id:</label>
                        <input type="text" class="form-control" id="idDesarrolladorSee" disabled>
                    </div>

                    <div class="form-group">
                        <label for="nombreDesarrolladorSee">Nombre(s):</label>
                        <input type="text" class="form-control" id="nombreDesarrolladorSee" disabled>
                    </div>

                    <div class="form-group">
                        <label for="apellidoDesarrolladorSee">Apellido(s):</label>
                        <input type="text" class="form-control" id="apellidoDesarrolladorSee" disabled>
                    </div>

                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>

        </div>
    </div>

    <!--========================
    MODAL ACTUALIZAR DESARROLLADOR
    ========================-->
    <div id="modalEditarDesarrollador" class="modal fade" role="dialog" data-backdrop="static">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header modal-color">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Consultar Desarrollador</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="nombreDesarrolladorUpdate">Nombre(s):</label>
                        <input type="text" class="form-control" id="nombreDesarrolladorUpdate" placeholder="Nombre(s)">
                    </div>

                    <div class="form-group">
                        <label for="apellidoDesarrolladorUpdate">Apellido(s):</label>
                        <input type="text" class="form-control" id="apellidoDesarrolladorUpdate" placeholder="Apellido(s)">
                    </div>

                </div>

                <input type="hidden" id="idHiddenDesarrollador">

                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal" onclick="actualizarDesarrollador()">Actualizar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>

        </div>
    </div>

    <!--========================
    MODAL AGREGAR SOPORTE
    ========================-->
    <div id="modalAgregarSoporte" class="modal fade" role="dialog" data-backdrop="static">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header modal-color">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Agregar Soporte</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="nombreSoporteAdd">Nombre(s):</label>
                        <input type="text" class="form-control" id="nombreSoporteAdd" placeholder="Nombre(s)">
                    </div>

                    <div class="form-group">
                        <label for="apellidoSoporteAdd">Apellido(s):</label>
                        <input type="text" class="form-control" id="apellidoSoporteAdd" placeholder="Apellido(s)">
                    </div>

                    <div class="form-group">
                        <label for="numeroSoperteAdd">Numero de celular:</label>
                        <input type="text" class="form-control" id="numeroSoperteAdd" placeholder="Numero de celular">
                    </div>

                    <div class="form-group">
                        <label for="correoSoporteAdd">Correo:</label>
                        <input type="email" class="form-control" id="correoSoporteAdd" placeholder="Correo">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal" onclick="agregarSoporte()">Agregar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>

        </div>
    </div>
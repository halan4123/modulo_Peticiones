<!--=====================================================================================================================
MODAL AGREGAR PETICION -> maxlength="75" en asunto
======================================================================================================================-->
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
                    <input type="text" class="form-control" id="asuntoAdd" placeholder="Asunto" maxlength="75">
                </div>


                <div class="form-group">
                    <label for="laboratorioAdd">Laboratorio:</label>
                    <select class="form-control" id="laboratorioAdd" style="width: 100%;">
                    </select>
                </div>

                <div class="form-group">
                    <label for="soporteAdd">Soporte:</label>
                    <select class="form-control" id="soporteAdd" style="width: 100%;">
                    </select>
                </div>

                <div class="form-group">
                    <label for="desarrolladorAdd">Desarrollador:</label>
                    <div class="input-group">
                        <select class="form-control" id="desarrolladorAdd" style="width: 100%">
                        </select>
                        <span class="input-group-btn">
                            <button class="btn btn-default" onclick="limpiarModal()"><i class="bi bi-arrow-clockwise"></i></button>
                        </span>
                    </div>
                </div>


                <div class="form-group">
                    <label for="descripcionAdd">Descripci??n:</label>
                    <textarea class="form-control" rows="15" id="descripcionAdd" placeholder="Descripci??n"></textarea>
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

<!--=====================================================================================================================
MODAL VER INFORMACI??N PETICION 
======================================================================================================================-->
<div id="modalVer" class="modal fade" role="dialog" data-backdrop="static">
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
                    <label for="descripcionSee">Descripci??n:</label>
                    <textarea class="form-control" rows="15" id="descripcionSee" disabled></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

            </div>
        </div>

    </div>
</div>

<!--=====================================================================================================================
MODAL EDITAR PETICION -> maxlength="75" en asunto
======================================================================================================================-->
<div id="modalEditar" class="modal fade" role="dialog" data-backdrop="static">
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
                    <input type="text" class="form-control" id="asuntoUpdate" maxlength="75">
                </div>

                <div class="form-group">
                    <label for="laboratorioUpdate">Laboratorio:</label>
                    <select class="form-control" id="laboratorioUpdate" style="width: 100%;">

                    </select>
                </div>

                <div class="form-group">
                    <label for="fecha_entregaUpdate">Fecha de entrega estimada:</label>
                    <input type="datetime-local" class="form-control" id="fecha_entregaUpdate">
                </div>

                <div class="form-group">
                    <label for="desarrolladorUpdate">Desarrollador:</label>
                    <select class="form-control" id="desarrolladorUpdate" style="width: 100%;">

                    </select>
                </div>


                <div class="form-group">
                    <label class="" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="
                    <b>Nivel 1: </b> 1 d??a. <br> 
                    Modificaciones sencillas y modificaciones de Urgencia. <br>
                    <br>
                    <b>Nivel 2: </b> 1 - 3 d??as. <br> 
                    Modificaciones medianamente sencillas que ya se han hecho en otros sistemas. <br>
                    <br>
                    <b>Nivel 3: </b> 3 - 7 d??as. <br> 
                    Modificaciones nuevas o nuevos desarrollos que no son tan dif??ciles de implementar. <br>
                    <br>
                    <b>Nivel 4: </b> Dias hasta semanas. <br> 
                    Nuevos desarrollos o nuevos m??dulos. <br>
                    <br>" title="<b>Duraci??n en base al nivel</b>">Nivel: <span class="bi bi-question-circle-fill"></span></label>

                    <!-- <label for="nivelUpdate">Nivel: <span class="bi bi-question-circle-fill"></span></label> -->
                    <select class="form-control" id="nivelUpdate" style="width: 100%;">

                    </select>
                </div>

                <div class="form-group">
                    <label for="estatusUpdate">Estatus:</label>
                    <select class="form-control" id="estatusUpdate" style="width: 100%;">

                    </select>
                </div>

                <div class="form-group">
                    <label for="descripcionUpdate">Descripci??n:</label>
                    <textarea class="form-control" rows="15" id="descripcionUpdate"></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal" onclick="actualizar()">Actualizar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <input type="hidden" id="idHidden">
                <input type="hidden" id="numeroCelularSoporte">
                <input type="hidden" id="fecha_completadoUpdate">
                <input type="hidden" id="fecha_llegadaUpdate">
                <input type="hidden" id="soporte_Update">
                <input type="hidden" id="desarrollador_nombre">
                <input type="hidden" id="caso_display">
            </div>
        </div>

    </div>
</div>

<!--=====================================================================================================================
MODAL AGREGAR DESARROLLADOR  -> maxlength="25" en nombre y apellido
======================================================================================================================-->
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
                    <input type="text" class="form-control" id="nombreDesarrolladorAdd" placeholder="Nombre(s)" maxlength="25">
                </div>

                <div class="form-group">
                    <label for="apellidoDesarrolladorAdd">Apellido(s):</label>
                    <input type="text" class="form-control" id="apellidoDesarrolladorAdd" placeholder="Apellido(s)" maxlength="25">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal" onclick="agregarDesarrollador()">Agregar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>

    </div>
</div>

<!--=====================================================================================================================
MODAL VER INFORMACI??N DESARROLLADOR 
======================================================================================================================-->
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

<!--=====================================================================================================================
MODAL ACTUALIZAR DESARROLLADOR -> maxlength="25" en nombre y apellido
======================================================================================================================-->
<div id="modalEditarDesarrollador" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-color">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Editar Desarrollador</h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="nombreDesarrolladorUpdate">Nombre(s):</label>
                    <input type="text" class="form-control" id="nombreDesarrolladorUpdate" placeholder="Nombre(s)" maxlength="25">
                </div>

                <div class="form-group">
                    <label for="apellidoDesarrolladorUpdate">Apellido(s):</label>
                    <input type="text" class="form-control" id="apellidoDesarrolladorUpdate" placeholder="Apellido(s)" maxlength="25">
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

<!--=====================================================================================================================
MODAL AGREGAR SOPORTE -> maxlength
======================================================================================================================-->
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
                    <input type="text" class="form-control" id="nombreSoporteAdd" placeholder="Nombre(s)" maxlength="25">
                </div>

                <div class="form-group">
                    <label for="apellidoSoporteAdd">Apellido(s):</label>
                    <input type="text" class="form-control" id="apellidoSoporteAdd" placeholder="Apellido(s)" maxlength="25">
                </div>

                <div class="form-group">
                    <label for="numeroSoperteAdd">Numero de celular:</label>
                    <input type="text" class="form-control" id="numeroSoperteAdd" placeholder="Numero de celular" maxlength="10" onkeypress="return soloNumeros(event)" onpaste="return false">
                </div>

                <div class="form-group">
                    <label for="correoSoporteAdd">Correo:</label>
                    <input type="email" class="form-control" id="correoSoporteAdd" placeholder="Correo" maxlength="30">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal" onclick="agregarSoporte()">Agregar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>

    </div>
</div>

<!--=====================================================================================================================
MODAL VER INFORMACI??N SOPORTE 
======================================================================================================================-->
<div id="modalInfoSoporte" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-color">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Consultar Soporte</h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="idSoporteSee">id:</label>
                    <input type="text" class="form-control" id="idSoporteSee" placeholder="id" disabled>
                </div>

                <div class="form-group">
                    <label for="nombreSoporteSee">Nombre(s):</label>
                    <input type="text" class="form-control" id="nombreSoporteSee" placeholder="Nombre(s)" disabled>
                </div>

                <div class="form-group">
                    <label for="apellidoSoporteSee">Apellido(s):</label>
                    <input type="text" class="form-control" id="apellidoSoporteSee" placeholder="Apellido(s)" disabled>
                </div>

                <div class="form-group">
                    <label for="numeroSoperteSee">Numero de celular:</label>
                    <input type="text" class="form-control" id="numeroSoperteSee" placeholder="Numero de celular" disabled>
                </div>

                <div class="form-group">
                    <label for="correoSoporteSee">Correo:</label>
                    <input type="text" class="form-control" id="correoSoporteSee" placeholder="Correo" disabled>
                </div>

            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>

    </div>
</div>

<!--=====================================================================================================================
MODAL EDITAR SOPORTE 
======================================================================================================================-->
<div id="modalEditarSoporte" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-color">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Editar Soporte</h4>
            </div>
            <div class="modal-body">


                <div class="form-group">
                    <label for="nombreSoporteSee">Nombre(s):</label>
                    <input type="text" class="form-control" id="nombreSoporteUpdate" placeholder="Nombre(s)" maxlength="25">
                </div>

                <div class="form-group">
                    <label for="apellidoSoporteSee">Apellido(s):</label>
                    <input type="text" class="form-control" id="apellidoSoporteUpdate" placeholder="Apellido(s)" maxlength="25">
                </div>

                <div class="form-group">
                    <label for="numeroSoperteSee">Numero de celular:</label>
                    <input type="text" class="form-control" id="numeroSoperteUpdaate" placeholder="Numero de celular" maxlength="10" onkeypress="return soloNumeros(event)" onpaste="return false">
                </div>

                <div class="form-group">
                    <label for="correoSoporteSee">Correo:</label>
                    <input type="text" class="form-control" id="correoSoporteUpdate" placeholder="Correo" maxlength="30">
                </div>

                <input type="hidden" id="idHiddenSoporte">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal" onclick="actualizarSoporte()">Actualizar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>

    </div>
</div>

<!--=====================================================================================================================
MODAL HISTORIAL 
======================================================================================================================-->
<div id="modalHistorialPeticion" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-color">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Historial</h4>
            </div>
            <div class="modal-body">

                <div id="display-historial">
                    
                </div>



            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>

    </div>
</div>
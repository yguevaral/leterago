<?php

class view_acceso {

    public function drawContenidoModalAcceso($id_acceso, $_acceso, $urlA, $lista_accesos, $_accesos) {
        ?>
        <div class="modal-header">
            <h4 class="modal-title">
                <?php
                print $_acceso ? "Editar Acceso" : "Nuevo Acceso";
                ?>
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="material-icons">clear</i>
            </button>
        </div>                   
        <div class="modal-body" >


            <form method="POST" action="<?= base_url . $urlA ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-12">
                        <div class="row" id="divInformacion">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Codigo Acceso</label>
                                    <input type="text" class="form-control" name="txt_codigo_acceso" value="<?= isset($_acceso) ? $_acceso->codigo_acceso : '' ?>" required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <select class="selectpicker" data-style="select-with-transition" name="opt_acceso" id="opt_acceso">
                                    <?php while ($data = $_accesos->fetch_object()): ?>
                                        <option value="<?= $data->id ?>" <?= isset($_acceso) && $data->id == $_acceso->tipo_acceso ? 'selected' : '' ?>> <?= $data->nombre ?> </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-fill btn-info">Guardar Información</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Lista de Accesos -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary card-header-icon">
                            <h4 class="card-title">Información almacenada</h4>
                        </div>
                        <div class="card-body">
                            <div class="toolbar">
                                <!-- Here you can write extra buttons/actions for the toolbar -->
                            </div>
                            <div class="material-datatables">
                                <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Id Acceso</th>
                                            <th>Codigo Acceso</th>
                                            <th>Tipo Acceso</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($data = $lista_accesos->fetch_object()): ?>
                                            <tr>
                                                <td>
                                                    <span class="badge badge-info h5" onclick="fntShowModalAccesos('<?= $data->id_acceso; ?>');" style="cursor: pointer"><?= $data->id_acceso; ?></span>
                                                </td>
                                                <td><?= $data->codigo_acceso; ?></td>
                                                <td><?= utils::getAccesoById($data->tipo_acceso)?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- end content-->
                    </div>
                    <!--  end card  -->
                </div>
                <!-- end col-md-12 -->
            </div>

        </div>
        <script>

            $(document).ready(function () {
                $('#opt_acceso').selectpicker();
            });

        </script>

        <?php
    }

}

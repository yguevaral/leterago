<?php

class view_empresa {

    public function drawListaEmpresas($lista_empresas) {
        ?>
        <div class="col-md-12">
            <div class="material-datatables">
                <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre Empresa</th>
                            <th>Nombre Contacto</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($data = $lista_empresas->fetch_object()): ?>
                            <tr>
                                <td><a href="javascript:void(0)" onclick="agregarEmpresa(<?= $data->id; ?>, '<?= $data->nombreEmpresa; ?>');"><?= $data->id; ?></a></td>
                                <td><?= $data->nombreEmpresa; ?></td>
                                <td><?= $data->nombreContacto; ?></td>
                                <td><?= utils::getEstadoAIById($data->estado); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <!-- end content-->
        </div>

        <script>
            function agregarEmpresa(id, nombre) {
                var id = id;
                var nombre = nombre;

//                        console.log(codigo + ' ' + nombre);

                $.ajax({
                    url: "<?= base_url ?>usuario/&getAddArray=true&key=2&id=" + id + "&nombreEmpresa=" + nombre,
                    success: function (result) {

                        $("#divInformacion").html(result);
                    }
                });

                $('#infoEmpresas').modal('hide');

            }            
        </script>

        <?php
    }

    public function drawEmpresaByCodigo($id, $nombre) {
        ?>
        <div class="col-md-5">
            <div class="form-group">
                <input type="hidden" name="id_empresa" value="<?= $id; ?>"/>
                <label class="bmd-label-floating">Empresa</label>
                <input type="text" class="form-control" name="txt_nombreEmpresa" value="<?= $nombre; ?>"/>
            </div>
        </div>
        <div class="col-md-1" style="margin-top: 2%;">
            <a href="#infoEmpresas" data-toggle="modal" data-target="#infoEmpresas">
                <span class="material-icons">search</span>
            </a>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="bmd-label-floating">Nombre</label>
                <input type="text" class="form-control" name="txt_nombre" />
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="bmd-label-floating">Usuario</label>
                <input type="text" class="form-control" name="txt_usuario" />
            </div>
        </div>
        <?php
    }

}

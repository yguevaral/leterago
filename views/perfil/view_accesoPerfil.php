<script>
    function fntTomarId(idPerfil) {
        const selectedAccess = $('#opt_acceso').val();
        if (selectedAccess.length === 0) {
            swal.fire('Alerta', 'No seleccionados', 'error');
            return
        }
        window.location = "<?= base_url ?>perfil/saveAccesoPerfil&idPerfil=" + idPerfil + "&accesos=" + selectedAccess.join(',');
        /*
        $.ajax({
            type: 'GET',
            url: "<?= base_url ?>perfil/saveAccesoPerfil&idPerfil=" + idPerfil + "&accesos=" + selectedAccess.join(','),
            success: (response) => {
                $('#modalContentAccesoPerfil').html(response)
               // console.log(response);                
            }

        })
        */
    }
</script>
<?php

class view_accesoPerfil {

    public function drawContenidoModalAccesoPerfil($id_perfil, $_perfil, $urlA, $no_access, $yes_access) {
        
        ?>
        <div class="modal-header">
            <h4 class="modal-title">
                <?php
                print "Accesos";
                ?>
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="material-icons">clear</i>
            </button>
        </div>                   
        <div class="modal-body" >
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="form-group">
                        <select class="selectpicker" multiple data-style="select-with-transition" name="opt_acceso" id="opt_acceso">
                            <?php foreach ($yes_access as $access): ?>
                            <option value="<?= $access->id_acceso ?>" selected><?php print $access->codigo_acceso.": ".utils::getAccesoById($access->tipo_acceso) ?> </option>
                            <?php endforeach; ?>
                            <?php foreach ($no_access as $data): ?>
                            <option value="<?= $data->id_acceso ?>"><?php print $data->codigo_acceso.": ".utils::getAccesoById($data->tipo_acceso) ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <div class="form-group">
                        <button type="submit" id="guardarInfo" onclick="fntTomarId('<?= $id_perfil ?>');" class="btn btn-fill btn-info">Guardar Información</button>
                    </div>
                </div>
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
?>


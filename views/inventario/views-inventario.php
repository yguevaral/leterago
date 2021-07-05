<?php

class viewsInventario {

    public function drawTallaTamano($lista_tallas_tamanos){
        ?>
        <div class="form-group">
            <select class="selectpicker dropdown" data-style="select-with-transition" title="Talla/Tamaño" name="opt_TallaTamano" id="opt_TallaTamano" data-live-search="true">
                <option disabled>Seleccione una opcion...</option>
                <?php while ($data = $lista_tallas_tamanos->fetch_object()): ?>
                    <option value="<?= $data->idTallaTamano ?>"> <?= $data->nombreTallaTamano ?> </option>
                <?php endwhile; ?>
            </select>
        </div>
        <script>

            $("#opt_TallaTamano").selectpicker();

        </script>
        <?php
    }

}
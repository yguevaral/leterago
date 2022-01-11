<?php

class viewReporte {

    public function drawDetalleOrden($lista_detalle) {
        ?>
            <div class="table-responsive">
                <table id="tblInventario" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                    <thead>
                        <tr>
                            <th>Cod. Producto</th>
                            <th>Producto</th>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($data = $lista_detalle->fetch_object()): ?>
                            <tr>
                                <td><?= $data->codigoProducto; ?></td>
                                <td><?= utils::getPrendaArticuloById($data->idPrendaArticulo)." ". utils::getTallaTamanoById($data->idTallaTamano)." ". utils::getColorById($data->idColor); ?></td>
                                <td><?= $data->descripcion; ?></td>
                                <td><?= $data->cantidad; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php
    }

}
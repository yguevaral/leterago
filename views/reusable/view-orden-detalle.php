<?php

class viewOrdenDetalle {

    public function drawOrdenDetalle($array_items, $id_orden, $validacion) {
        if ($validacion == 1) {
            ?>
            <input type="hidden" name="hdd_orden" id="hdd_orden" value="<?= $id_orden ?>" />
            <div class="table-responsive">
                <table class="table">
                    <thead class="">
                    <th>Codigo</th>
                    <th>Descripcion</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                    <th>Seleccionar</th>
                    <th>Observación</th>
                    </thead>
                    <tbody>
                        <?php if (isset($array_items)): ?>
                            <?php $int_count = 1; ?>
                            <?php foreach ($array_items as $clave => $valor): ?>
                                <tr>
                                    <td><?= $valor['codigoProducto']; ?></td>
                                    <td><?= $valor['descripcion']; ?></td>
                                    <td><?= $valor['cantidad']; ?></td>
                                    <td><?= $valor['precio']; ?></td>
                                    <td><?= $valor['subtotal']; ?></td>
                                    <td>
                                        <div class="form-check text-center">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" id="ckb_devolucion_<?= $int_count ?>" value="">
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                        <input type="hidden" id="hdd_devolucion_<?= $int_count ?>" value="<?= $valor['id']; ?>" />
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="txt_dev_<?= $int_count ?>" id="txt_dev_<?= $int_count ?>"/>
                                    </td>
                                </tr>
                                <?php $int_count++; ?>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>

                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php
        } else if ($validacion == 2) {
            ?>
            <input type="hidden" name="hdd_orden" id="hdd_orden" value="<?= $id_orden ?>" />
            <div class="table-responsive">
                <table class="table">
                    <thead class="">
                    <th>Codigo</th>
                    <th>Descripcion</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                    </thead>
                    <tbody>
                        <?php if (isset($array_items)): ?>
                            <?php $int_count = 1; ?>
                            <?php foreach ($array_items as $clave => $valor): ?>
                                <tr>
                                    <td><?= $valor['codigoProducto']; ?></td>
                                    <td><?= $valor['descripcion']; ?></td>
                                    <td><?= $valor['cantidad']; ?></td>
                                    <td><?= $valor['precio']; ?></td>
                                    <td><?= $valor['subtotal']; ?></td>
                                </tr>
                                <?php $int_count++; ?>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>

                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php
        }
    }

}

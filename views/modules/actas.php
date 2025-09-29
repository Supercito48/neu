<?php
$url = Ruta::ctrRuta();
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Carga de actas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo $url; ?>inicio">Inicio</a></li>
                        <li class="breadcrumb-item active">Carga de actas</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalActa">
                                Nueva acta
                            </button>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover tablaActas">
                                <thead>
                                    <tr>
                                        <th>Provincia</th>
                                        <th>Distrito</th>
                                        <th>Mesa</th>
                                        <th>Total hábiles</th>
                                        <th>Blanco</th>
                                        <th>Nulo</th>
                                        <th>Impugnado</th>
                                        <th>Total emitidos</th>
                                        <th>Acta</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modalActa" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formActa" enctype="multipart/form-data">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title">Registrar acta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="provinciaActa">Provincia</label>
                                <select class="form-control select2" id="provinciaActa" name="provinciaActa" style="width: 100%;" required>
                                    <option value="">Seleccione</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="distritoActa">Distrito</label>
                                <select class="form-control select2" id="distritoActa" name="distritoActa" style="width: 100%;" required>
                                    <option value="">Seleccione</option>
                                </select>
                                <input type="hidden" id="ubigeoActa" name="ubigeoActa">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mesaSufragio">Mesa de sufragio</label>
                                <input type="number" class="form-control" id="mesaSufragio" name="mesaSufragio"
                                    placeholder="Ingrese la mesa de sufragio" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="totalHabiles">Total RENIEC hábiles</label>
                                <input type="number" class="form-control" id="totalHabiles" name="totalHabiles"
                                    placeholder="Ingrese el total de electores" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="votosBlanco">Votos en blanco</label>
                                <input type="number" class="form-control" id="votosBlanco" name="votosBlanco" value="0"
                                    min="0" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="votosNulo">Votos nulos</label>
                                <input type="number" class="form-control" id="votosNulo" name="votosNulo" value="0" min="0"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="votosImpugnado">Votos impugnados</label>
                                <input type="number" class="form-control" id="votosImpugnado" name="votosImpugnado" value="0"
                                    min="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="totalEmitidos">Total votos emitidos</label>
                                <input type="number" class="form-control" id="totalEmitidos" name="totalEmitidos" value="0"
                                    min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fotoActa">Fotografía del acta</label>
                                <input type="file" class="form-control-file" id="fotoActa" name="fotoActa" accept="image/*"
                                    required>
                                <small class="form-text text-muted">Formatos permitidos: JPG, PNG. Máximo 5 MB.</small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Detalle de votos por candidato</label>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tablaCandidatosActa">
                                <thead>
                                    <tr>
                                        <th>Agrupación política</th>
                                        <th>Candidato</th>
                                        <th class="text-center" style="width: 160px;">Votos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Seleccione una provincia y distrito para
                                            cargar los candidatos.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar acta</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?php echo $url; ?>views/js/actas.js"></script>

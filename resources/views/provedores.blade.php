@extends('layouts.app')

{{-- <link rel="stylesheet" href="{{ asset('css/tablas.css') }}"> --}}
@vite('resources/css/tablas.css')

@section('title', 'Proveedores')

@section('content')
    <div class="container">
        <b>
            <h2 class="text-center my-5">Provedores</h2>
        </b>

        <b>
            <p class="text-center">Listado de provedores</p>
        </b>
        <button id="btnRegistrarProveedor" class="btn btn-success mb-3">Registrar Proveedor</button>


        <button id="btnFiltrosProveedores" class="btn btn-primary mb-3">
            Filtrar proveedores
        </button>
        <button id="btnVerProveedoresEliminados" class="btn btn-danger mb-3">
            Ver eliminados
        </button>


        <div class="row">
            <div class="col-lg-12">
                <br>
                <div class="check-out-box">
                    <meta name="csrf-token" content="{{ csrf_token() }}">

                    <div class="row">
                        <table class="table_id" id="tbl_provedores">
                            <thead>
                                <tr>
                                    <th class="text-center">Id</th>
                                    <th class="text-center">Nombre Marca</th>
                                    <th class="text-center">Provedor</th>
                                    <th class="text-center">Contacto Provedor</th>
                                    <th class="text-center">Telefono</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Dirección</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Modal Registrar Proveedor -->
<div class="modal fade" id="modalRegistrarProveedor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formRegistrarProveedor">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar Proveedor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nuevoNombre" class="form-label">Nombre del Proveedor</label>
                        <input type="text" class="form-control" id="nuevoNombre" name="nombre_proveedor">
                    </div>

                    <div class="mb-3">
                        <label for="nuevoContacto" class="form-label">Contacto</label>
                        <input type="text" class="form-control" id="nuevoContacto" name="contacto">
                    </div>

                    <div class="mb-3">
                        <label for="nuevoTelefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="nuevoTelefono" name="telefono">
                    </div>

                    <div class="mb-3">
                        <label for="nuevoEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="nuevoEmail" name="email">
                    </div>

                    <div class="mb-3">
                        <label for="nuevaDireccion" class="form-label">Dirección</label>
                        <textarea class="form-control" id="nuevaDireccion" name="direccion" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="nuevoIdCatMarcas" class="form-label">Marca</label>
                        <select class="form-select" id="nuevoIdCatMarcas" name="id_cat_marcas" required>
                            <option value="">Selecciona una marca</option>
                            <!-- Se llenará dinámicamente con JS -->
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Proveedor -->
<div class="modal fade" id="modalEditarProveedor" tabindex="-1" aria-labelledby="modalEditarProveedorLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formEditarProveedor">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarProveedorLabel">Editar Proveedor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="proveedorId" name="proveedorId">

                    <div class="mb-3">
                        <label for="nombre_proveedor" class="form-label">Nombre del Proveedor</label>
                        <input type="text" class="form-control" id="nombre_proveedor" name="nombre_proveedor" required>
                    </div>

                    <div class="mb-3">
                        <label for="contacto" class="form-label">Contacto</label>
                        <input type="text" class="form-control" id="contacto" name="contacto">
                    </div>

                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>

                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <textarea class="form-control" id="direccion" name="direccion" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="id_cat_marcas" class="form-label">Marca</label>
                        <select class="form-select" id="id_cat_marcas" name="id_cat_marcas" required>
                            <option value="">Selecciona una marca</option>
                            <!-- Opciones cargadas dinámicamente vía JS -->
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Filtros Proveedores --}}

<div class="modal fade modal-producto" id="modalFiltrosProveedores" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formFiltrosProveedores">
                <div class="modal-header">
                    <h5 class="modal-title">Filtros de Proveedores</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="filtroMarca" class="form-label">Marca</label>
                        <select id="filtroMarca" class="form-select">
                            <option value="">Todas</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="filtroNombre" class="form-label">Proveedor</label>
                        <input type="text" id="filtroNombre" class="form-control" placeholder="Nombre del proveedor">
                    </div>
                    <div class="mb-3">
                        <label for="filtroContacto" class="form-label">Nombre proveedor</label>
                        <input type="text" id="filtroContacto" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="filtroTelefono" class="form-label">Teléfono</label>
                        <input type="text" id="filtroTelefono" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="filtroEmail" class="form-label">Email</label>
                        <input type="text" id="filtroEmail" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Aplicar filtros</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('js_footer')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/tienda/provedores.js') }}"></script>
@endsection

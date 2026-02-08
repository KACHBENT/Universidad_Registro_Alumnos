<?= $this->extend('layout/main') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="<?= base_url('css/inicio.styles.css') ?>">
<style>
  .hero-school{
    border-radius: 18px;
    border: 1px solid rgba(0,0,0,.08);
    box-shadow: 0 12px 30px rgba(0,0,0,.08);
    overflow: hidden;
    background:white;
  }
  .hero-badge{
    display:inline-flex; align-items:center; gap:.5rem;
    padding:.35rem .65rem; border-radius:999px;
    background:rgb(0 0 0);
    border: 1px solid rgba(25,135,84,.18);
    font-weight: 600;
  }
  .quick-card{
    border-radius: 16px;
    border: 1px solid rgba(0,0,0,.08);
    box-shadow: 0 10px 22px rgba(0,0,0,.06);
    transition: .15s ease;
    text-decoration: none;
    color: inherit;
  }
  .quick-card:hover{ transform: translateY(-2px); box-shadow: 0 16px 30px rgba(0,0,0,.08); }
  .icon-pill{
    width: 42px; height: 42px;
    border-radius: 12px;
    display:flex; align-items:center; justify-content:center;
    background: rgb(255, 255, 255);
    border: 1px solid rgba(25,135,84,.16);
  }
  .stat-card{
    border-radius: 16px;
    border: 1px solid rgba(0,0,0,.08);
    background: #fff;
  }
  .soft-muted{ color: rgba(0,0,0,.60); }
</style>
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('layout/NavBar') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container my-4">

  <!-- HERO / BIENVENIDA -->
  <div class="hero-school p-4 p-md-5 mb-4">
    <div class="row align-items-center g-4">
      <div class="col-12 col-lg-7">
        <div class="hero-badge mb-3">
          <span class="material-symbols-rounded">school</span>
          Panel académico
        </div>

        <h2 class="mb-2 text-black">Bienvenido a Universidad Mexicana</h2>
        <p class="soft-muted mb-4">
          Administra alumnos, catálogos y operaciones desde un solo lugar.
          Usa los accesos rápidos para registrar, consultar y actualizar información.
        </p>

        <div class="d-flex gap-2 flex-wrap">
          <a href="<?= site_url('alumnos') ?>" class="btn btn-success">
            <span class="material-symbols-rounded align-middle">groups</span>
            Ver alumnos
          </a>
          <a href="<?= site_url('alumnos/create') ?>" class="btn btn-outline-success">
            <span class="material-symbols-rounded align-middle">person_add</span>
            Registrar alumno
          </a>
          <a href="<?= site_url('operaciones/grupos') ?>" class="btn btn-outline-primary">
            <span class="material-symbols-rounded align-middle">hub</span>
            Gestionar grupos
          </a>
        </div>
      </div>

      <div class="col-12 col-lg-5">
        <div class="row g-3">
          <div class="col-6">
            <div class="stat-card p-3 h-100">
              <div class="d-flex align-items-center gap-2 mb-2">
                <span class="material-symbols-rounded text-success">library_books</span>
                <span class="text-black">Catálogos</span>
              </div>
              <div class="soft-muted small">Carreras y turnos</div>
              <div class="d-flex gap-2 mt-3 flex-wrap">
                <a class="btn btn-sm btn-outline-secondary" href="<?= site_url('categorias/carreras') ?>">Carreras</a>
                <a class="btn btn-sm btn-outline-secondary" href="<?= site_url('categorias/turnos') ?>">Turnos</a>
              </div>
            </div>
          </div>

          <div class="col-6">
            <div class="stat-card p-3 h-100">
              <div class="d-flex align-items-center gap-2 mb-2">
                <span class="material-symbols-rounded text-primary">playlist_add</span>
                <span class="text-black">Operaciones</span>
              </div>
              <div class="soft-muted small">Organización académica</div>
              <div class="d-flex gap-2 mt-3 flex-wrap">
                <a class="btn btn-sm btn-outline-secondary" href="<?= site_url('operaciones/grupos') ?>">Grupos</a>
                <a class="btn btn-sm btn-outline-secondary" href="<?= site_url('contacto') ?>">Contacto</a>
              </div>
            </div>
          </div>

          <div class="col-12">
            <div class="stat-card p-3">
              <div class="d-flex align-items-center justify-content-between">
                <div>
                  <div class="fw-semibold">
                    <span class="material-symbols-rounded align-middle text-success">info</span>
                    Aviso rápido
                  </div>
                  <div class="soft-muted small">
                    Mantén activos (1) los registros que se usan en selección de grupos.
                  </div>
                </div>
                <span class="badge bg-success-subtle text-success border border-success-subtle">
                  OK
                </span>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- ACCESOS RÁPIDOS -->
  <div class="d-flex align-items-center justify-content-between mb-2">
    <h5 class="mb-0 text-black">Accesos rápidos</h5>
  </div>

  <div class="row g-3 mb-4">

    <div class="col-12 col-md-6 col-lg-4">
      <a class="quick-card d-block p-3" href="<?= site_url('alumnos') ?>">
        <div class="d-flex gap-3 align-items-start">
          <div class="icon-pill">
            <span class="material-symbols-rounded text-success">groups</span>
          </div>
          <div class="flex-grow-1">
            <div class="fw-semibold">Alumnos</div>
            <div class="soft-muted small">Listado, edición, activar/desactivar</div>
          </div>
          <span class="material-symbols-rounded soft-muted">chevron_right</span>
        </div>
      </a>
    </div>

    <div class="col-12 col-md-6 col-lg-4">
      <a class="quick-card d-block p-3" href="<?= site_url('alumnos/create') ?>">
        <div class="d-flex gap-3 align-items-start">
          <div class="icon-pill">
            <span class="material-symbols-rounded text-success">person_add</span>
          </div>
          <div class="flex-grow-1">
            <div class="fw-semibold">Registrar alumno</div>
            <div class="soft-muted small">Alta de persona + asignación de grupo</div>
          </div>
          <span class="material-symbols-rounded soft-muted">chevron_right</span>
        </div>
      </a>
    </div>

    <div class="col-12 col-md-6 col-lg-4">
      <a class="quick-card d-block p-3" href="<?= site_url('operaciones/grupos') ?>">
        <div class="d-flex gap-3 align-items-start">
          <div class="icon-pill" style="background: rgba(13,110,253,.12); border-color: rgba(13,110,253,.16);">
            <span class="material-symbols-rounded text-primary">hub</span>
          </div>
          <div class="flex-grow-1">
            <div class="fw-semibold">Grupos</div>
            <div class="soft-muted small">Crear y administrar grupos por carrera/turno</div>
          </div>
          <span class="material-symbols-rounded soft-muted">chevron_right</span>
        </div>
      </a>
    </div>

    <div class="col-12 col-md-6 col-lg-4">
      <a class="quick-card d-block p-3" href="<?= site_url('categorias/carreras') ?>">
        <div class="d-flex gap-3 align-items-start">
          <div class="icon-pill">
            <span class="material-symbols-rounded text-success">menu_book</span>
          </div>
          <div class="flex-grow-1">
            <div class="fw-semibold">Carreras</div>
            <div class="soft-muted small">Catálogo de carreras (siglas y estatus)</div>
          </div>
          <span class="material-symbols-rounded soft-muted">chevron_right</span>
        </div>
      </a>
    </div>

    <div class="col-12 col-md-6 col-lg-4">
      <a class="quick-card d-block p-3" href="<?= site_url('categorias/turnos') ?>">
        <div class="d-flex gap-3 align-items-start">
          <div class="icon-pill">
            <span class="material-symbols-rounded text-success">schedule</span>
          </div>
          <div class="flex-grow-1">
            <div class="fw-semibold">Turnos</div>
            <div class="soft-muted small">Matutino / Vespertino / Mixto…</div>
          </div>
          <span class="material-symbols-rounded soft-muted">chevron_right</span>
        </div>
      </a>
    </div>

    <div class="col-12 col-md-6 col-lg-4">
      <a class="quick-card d-block p-3" href="<?= site_url('contacto') ?>">
        <div class="d-flex gap-3 align-items-start">
          <div class="icon-pill" style="background: rgba(255,193,7,.18); border-color: rgba(255,193,7,.22);">
            <span class="material-symbols-rounded text-warning">mail</span>
          </div>
          <div class="flex-grow-1">
            <div class="fw-semibold">Contacto</div>
            <div class="soft-muted small">Registro de solicitudes y atención</div>
          </div>
          <span class="material-symbols-rounded soft-muted">chevron_right</span>
        </div>
      </a>
    </div>

  </div>

  <div class="row g-3 mb-4">
    <div class="col-12 col-lg-7">
      <div class="card stat-card p-3 p-md-4 h-100">
        <div class="d-flex align-items-center gap-2 mb-2">
          <span class="material-symbols-rounded text-primary">campaign</span>
          <h6 class="mb-0 fw-bold">Avisos</h6>
        </div>

        <ul class="mb-0 soft-muted">
          <li>Recuerda mantener activos los catálogos (Carreras y Turnos).</li>
          <li>Para registrar alumnos, primero crea grupos disponibles.</li>
          <li>Los cambios se notifican por toast.</li>
        </ul>
      </div>
    </div>

    <div class="col-12 col-lg-5">
      <div class="card stat-card p-3 p-md-4 h-100">
        <div class="d-flex align-items-center gap-2 mb-2">
          <span class="material-symbols-rounded text-success">verified</span>
          <h6 class="mb-0 fw-bold">Guía rápida</h6>
        </div>

        <ol class="mb-0 soft-muted">
          <li>Registra Carreras</li>
          <li>Registra Turnos</li>
          <li>Crea Grupos</li>
          <li>Registra Alumnos</li>
        </ol>
      </div>
    </div>
  </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('footer') ?>
<?= $this->include('layout/Footer') ?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>

</script>
<?= $this->endSection() ?>

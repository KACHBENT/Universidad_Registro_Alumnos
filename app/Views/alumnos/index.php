<?= $this->extend('layout/main') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="<?= base_url('css/inicio.styles.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/table.styles.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('layout/NavBar') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container my-4">

  <div class="card pg-card overflow-hidden">
    <div class="card-header card-header-custom linea-contenedor">
      <h3>Administración Alumnos</h3>
    </div>
    <?php
    echo view('components/table', [
      'title' => 'Listado de Alumnos',
      'buttons' => [
        '<a href="' . site_url('alumnos/create') . '" class="btn btn-sm btn-success mb-2">+ Nuevo</a>',
      ],
      'columns' => [
        'AlumnoId' => 'ID',
        'Nombre_Completo' => 'Nombre',
        'Carrera_Asignado' => 'Carrera',
        'Turno_Asignado' => 'Turno',
        'Grupo_Asignado' => 'Grupo',
        'Estatus' => 'Estatus',
        'Acciones' => 'Acciones',
      ],
      'rows' => $rows ?? [],
      'rawColumns' => ['Estatus', 'Acciones'],

      'cardTitleField' => 'Nombre_Completo',
      'cardSubtitleField' => 'Grupo_Asignado',
      'cardBadgeField' => 'Estatus',
      'cardBadgeAsHtml' => true,

      'defaultSize' => 10,
      'pageSizes' => [5, 10, 20, 50],
    ]);
    ?>
  </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('footer') ?>
<?= $this->include('layout/Footer') ?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('javascript/table.script.js') ?>"></script>
<?= $this->endSection() ?>
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
    <?= view('components/table', [
      'title' => 'Listado de Grupos',
      'buttons' => [
        '<a href="'.site_url('operaciones/grupos/create').'" class="btn btn-sm btn-primary">+ Nuevo</a>',
      ],
      'columns' => [
        'grupoId'      => 'ID',
        'grupo_Label'  => 'Grupo',
        'carrera_Valor'=> 'Carrera',
        'turno_Valor'  => 'Turno',
        'grupo_Grado'  => 'Grado',
        'grupo_Num'    => 'Num',
        'Estatus'      => 'Estatus',
        'Acciones'     => 'Acciones',
      ],
      'rows' => $rows ?? [],
      'rawColumns' => ['Estatus','Acciones'],
      'cardTitleField' => 'grupo_Label',
      'cardSubtitleField' => 'carrera_Valor',
      'cardBadgeField' => 'Estatus',
      'cardBadgeAsHtml' => true,
      'defaultSize' => 10,
      'pageSizes' => [5,10,20,50],
    ]) ?>
  </div>

</div>
<?= $this->endSection() ?>

<?= $this->section('footer') ?><?= $this->include('layout/Footer') ?><?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('javascript/table.script.js') ?>"></script>
<?= $this->endSection() ?>

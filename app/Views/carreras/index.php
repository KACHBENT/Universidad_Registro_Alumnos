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
      'title' => 'Listado de Carreras',
      'buttons' => [
        '<a href="'.site_url('categorias/carreras/create').'" class="btn btn-sm btn-primary">+ Nuevo</a>',
      ],
      'columns' => [
        'carreraId'     => 'ID',
        'carrera_Valor' => 'Carrera',
        'carrera_Sigla' => 'Sigla',
        'Estatus'       => 'Estatus',
        'Acciones'      => 'Acciones',
      ],
      'rows' => $rows ?? [],
      'rawColumns' => ['Estatus','Acciones'],
      'cardTitleField' => 'carrera_Valor',
      'cardSubtitleField' => 'carrera_Sigla',
      'cardBadgeField' => 'Estatus',
      'cardBadgeAsHtml' => true,
    ]) ?>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('footer') ?>
<?= $this->include('layout/Footer') ?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('javascript/table.script.js') ?>"></script>
<?= $this->endSection() ?>

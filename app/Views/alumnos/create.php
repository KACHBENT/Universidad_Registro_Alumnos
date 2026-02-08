<?= $this->extend('layout/main') ?>

<?= $this->section('navbar') ?>
<?= $this->include('layout/NavBar') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container my-4">
  <div class="card pg-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="mb-0">Nueva carrera</h4>
      <a class="btn btn-outline-secondary btn-sm" href="<?= site_url('categorias/carreras') ?>">Volver</a>
    </div>

    <form method="post" action="<?= site_url('categorias/carreras/store') ?>">
      <?= csrf_field() ?>

      <div class="row g-3">
        <div class="col-12 col-md-8">
          <label class="form-label">Carrera</label>
          <input class="form-control" name="carrera_Valor" required maxlength="50" value="<?= esc(old('carrera_Valor') ?? '') ?>">
        </div>
        <div class="col-12 col-md-4">
          <label class="form-label">Sigla</label>
          <input class="form-control" name="carrera_Sigla" required maxlength="12" value="<?= esc(old('carrera_Sigla') ?? '') ?>">
        </div>
      </div>

      <div class="d-flex justify-content-end gap-2 mt-3">
        <a class="btn btn-outline-secondary" href="<?= site_url('categorias/carreras') ?>">Cancelar</a>
        <button class="btn btn-primary" type="submit">Guardar</button>
      </div>
    </form>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('footer') ?>
<?= $this->include('layout/Footer') ?>
<?= $this->endSection() ?>

<?= $this->extend('layout/main') ?>
<?= $this->section('navbar') ?><?= $this->include('layout/NavBar') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container my-4">
  <div class="card pg-card overflow-hidden">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0"><?= esc($title ?? 'Turno') ?></h4>
        <a class="btn btn-outline-secondary btn-sm" href="<?= site_url('categorias/turnos') ?>">Volver</a>
      </div>

      <form method="post" action="<?= site_url('categorias/turnos/store') ?>">
        <?= csrf_field() ?>

        <div class="row g-3">
          <div class="col-12 col-md-8">
            <label class="form-label">Turno</label>
            <input class="form-control" name="turno_Valor" maxlength="15" required value="<?= esc(old('turno_Valor') ?? '') ?>">
          </div>
          <div class="col-12 col-md-4">
            <label class="form-label">Sigla</label>
            <input class="form-control" name="turno_Sigla" maxlength="5" required value="<?= esc(old('turno_Sigla') ?? '') ?>">
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-3">
          <a class="btn btn-outline-secondary" href="<?= site_url('categorias/turnos') ?>">Cancelar</a>
          <button class="btn btn-primary" type="submit">Guardar</button>
        </div>
      </form>

    </div>
  </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('footer') ?><?= $this->include('layout/Footer') ?><?= $this->endSection() ?>

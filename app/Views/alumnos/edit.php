<?= $this->extend('layout/main') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="<?= base_url('css/inicio.styles.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('layout/NavBar') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container my-4">

  <div class="row justify-content-center">
    <div class="col-12 col-lg-8">

      <div class="card pg-card overflow-hidden">
        <div class="card-header  card-header-custom linea-contenedor">
              <h3 class="mb-0">Editar Alumno</h3>
              <small class="text-white">Actualiza persona y grupo</small>
            </div>
        <div class="card-body">

          <div class="d-flex align-items-center justify-content-between mb-3">
          </div>

          <?php $errors = session()->getFlashdata('errors') ?? []; ?>
          <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
              <ul class="mb-0">
                <?php foreach ($errors as $err): ?>
                  <li><?= esc($err) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <form method="post" action="<?= site_url('alumnos/update/' . (int)$alumno['alumnoId']) ?>">
            <?= csrf_field() ?>

            <div class="row g-3">

              <div class="col-12 col-md-4">
                <label class="form-label">Nombre</label>
                <input class="form-control" name="persona_Nombre" required maxlength="35"
                  value="<?= esc(old('persona_Nombre') ?? $alumno['persona_Nombre']) ?>">
              </div>

              <div class="col-12 col-md-4">
                <label class="form-label">Apellido Paterno</label>
                <input class="form-control" name="persona_ApllP" required maxlength="35"
                  value="<?= esc(old('persona_ApllP') ?? $alumno['persona_ApllP']) ?>">
              </div>

              <div class="col-12 col-md-4">
                <label class="form-label">Apellido Materno</label>
                <input class="form-control" name="persona_ApllM" maxlength="35"
                  value="<?= esc(old('persona_ApllM') ?? ($alumno['persona_ApllM'] ?? '')) ?>">
              </div>

              <div class="col-12">
                <label class="form-label">Grupo</label>
                <select name="grupoId" class="form-select" required>
                  <option value="">-- Selecciona un grupo --</option>
                  <?php foreach (($grupos ?? []) as $g): ?>
                    <?php $selected = (old('grupoId') ?? $alumno['grupoId']) == $g['grupoId']; ?>
                    <option value="<?= esc($g['grupoId']) ?>" <?= $selected ? 'selected' : '' ?>>
                      <?= esc($g['grupo_Label'] ?? ('Grupo ID ' . $g['grupoId'])) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="col-12 d-flex gap-2 justify-content-end">
                <a href="<?= site_url('alumnos') ?>" class="btn btn-secondary">Volver</a>
                <button class="btn btn-primary" type="submit">Guardar cambios</button>
              </div>

            </div>
          </form>

        </div>
      </div>

    </div>
  </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('footer') ?>
<?= $this->include('layout/Footer') ?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?= $this->endSection() ?>

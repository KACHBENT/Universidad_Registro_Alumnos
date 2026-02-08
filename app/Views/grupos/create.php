<?= $this->extend('layout/main') ?>
<?= $this->section('navbar') ?><?= $this->include('layout/NavBar') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container my-4">
  <div class="card pg-card overflow-hidden">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Nuevo Grupo</h4>
        <a class="btn btn-outline-secondary btn-sm" href="<?= site_url('operaciones/grupos') ?>">Volver</a>
      </div>

      <form method="post" action="<?= site_url('operaciones/grupos/store') ?>">
        <?= csrf_field() ?>

        <div class="row g-3">
          <div class="col-12 col-md-6">
            <label class="form-label">Carrera</label>
            <select class="form-select" name="carreraId" required>
              <option value="">-- Selecciona --</option>
              <?php foreach (($carreras ?? []) as $c): ?>
                <option value="<?= esc($c['carreraId']) ?>" <?= old('carreraId') == $c['carreraId'] ? 'selected' : '' ?>>
                  <?= esc($c['carrera_Valor']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label">Turno</label>
            <select class="form-select" name="turnoId" required>
              <option value="">-- Selecciona --</option>
              <?php foreach (($turnos ?? []) as $t): ?>
                <option value="<?= esc($t['turnoId']) ?>" <?= old('turnoId') == $t['turnoId'] ? 'selected' : '' ?>>
                  <?= esc($t['turno_Valor']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label">Grado (1-11)</label>
            <input type="number" class="form-control" name="grupo_Grado" min="1" max="11" required
              value="<?= esc(old('grupo_Grado') ?? '') ?>">
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label">Número</label>
            <input type="number" class="form-control" name="grupo_Num" min="1" required
              value="<?= esc(old('grupo_Num') ?? '') ?>">
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-3">
          <a class="btn btn-outline-secondary" href="<?= site_url('operaciones/grupos') ?>">Cancelar</a>
          <button class="btn btn-primary" type="submit">Guardar</button>
        </div>
      </form>

    </div>
  </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('footer') ?><?= $this->include('layout/Footer') ?><?= $this->endSection() ?>

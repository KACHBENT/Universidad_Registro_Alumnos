<?php
$path = trim(service('uri')->getPath(), '/'); // para active
$active = fn($starts) => str_starts_with($path, trim($starts,'/')) ? 'active' : '';
?>

<!-- Navbar superior -->
<nav class="navbar bg-custom px-3 sticky-top">
  <button class="btn btn-light me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar"
    aria-controls="sidebar">
    <img src="<?= base_url('images/icons/menu.svg') ?>" class="black-filter" alt="menu" width="20" height="20">
  </button>

  <a class="navbar-brand content-logo-business d-flex align-items-center gap-2 text-white fw-semibold text-decoration-none"
    href="<?= site_url('/') ?>" aria-label="Ir al inicio">
    <picture class="brand-logo d-inline-block rounded-2 overflow-hidden">
      <source srcset="<?= base_url('images/universidad.webp') ?>" type="image/webp">
      <img src="<?= base_url('images/universidad.webp') ?>" width="45" height="45" loading="lazy"
        alt="universidad-mexicana">
    </picture>
    <span class="d-flex flex-column lh-1">
      <span class="brand-title text-black">Universidad Mexicana</span>
    </span>
  </a>
</nav>

<!-- Sidebar lateral -->
<nav class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="sidebarLabel">Menú principal</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
  </div>

  <div class="offcanvas-body d-flex flex-column">
    <nav class="nav flex-column gap-1 flex-grow-1">

      <a class="nav-link nav-link-function text-white d-flex align-items-center gap-2 <?= $active('') ?>"
        href="<?= site_url('/') ?>">
        <img src="<?= base_url('images/icons/home.svg') ?>" class="white" alt="inicio" width="30" height="30">
        Inicio
      </a>

      <!-- Alumnos -->
      <div>
        <button class="btn btn-toggle nav-link-function align-items-center rounded text-start w-100 text-white d-flex gap-2"
          data-bs-toggle="collapse" data-bs-target="#submenuAlumnos" aria-expanded="false">
          <img src="<?= base_url('images/icons/book.svg') ?>" class="white" alt="alumnos" width="30" height="30">
          Alumnos
          <i class="bi bi-chevron-down ms-auto"></i>
        </button>

        <div class="collapse ps-4 mt-1" id="submenuAlumnos">
          <a class="nav-link nav-link-list text-white <?= $active('alumnos') ?>" href="<?= site_url('alumnos') ?>">Listado</a>
          <a class="nav-link nav-link-list text-white" href="<?= site_url('alumnos/create') ?>">Registrar alumno</a>
        </div>
      </div>

      <!-- Catálogos -->
      <div>
        <button class="btn btn-toggle nav-link-function align-items-center rounded text-start w-100 text-white d-flex gap-2"
          data-bs-toggle="collapse" data-bs-target="#submenuCatalogos" aria-expanded="false">
          <img src="<?= base_url('images/icons/category.svg') ?>" class="white" alt="catálogos" width="30" height="30">
          Catálogos
          <i class="bi bi-chevron-down ms-auto"></i>
        </button>

        <div class="collapse ps-4 mt-1" id="submenuCatalogos">
          <a class="nav-link nav-link-list text-white <?= $active('categorias/carreras') ?>" href="<?= site_url('categorias/carreras') ?>">Carreras</a>
          <a class="nav-link nav-link-list text-white <?= $active('categorias/turnos') ?>" href="<?= site_url('categorias/turnos') ?>">Turnos</a>
        </div>
      </div>

      <!-- Operaciones -->
      <div>
        <button class="btn btn-toggle nav-link-function align-items-center rounded text-start w-100 text-white d-flex gap-2"
          data-bs-toggle="collapse" data-bs-target="#submenuOperaciones" aria-expanded="false">
          <img src="<?= base_url('images/icons/settings.svg') ?>" class="white" alt="operaciones" width="30" height="30">
          Operaciones
          <i class="bi bi-chevron-down ms-auto"></i>
        </button>

        <div class="collapse ps-4 mt-1" id="submenuOperaciones">
          <a class="nav-link nav-link-list text-white <?= $active('operaciones/grupos') ?>" href="<?= site_url('operaciones/grupos') ?>">Grupos</a>
        </div>
      </div>

    </nav>
  </div>
</nav>

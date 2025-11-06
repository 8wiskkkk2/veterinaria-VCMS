<div class="container mt-4">
    <div class="card mb-4">
        <div class="card-header">
            <h3>Estadísticas del Sistema</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h4 class="text-center">Cantidad de Autorizaciones por Tipo</h4>
                        </div>
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <canvas id="autorizacionesPorTipoChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h4 class="text-center">Tratamientos Preventivos</h4>
                        </div>
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <canvas id="tratamientosPreventivoChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h4 class="text-center">Distribución por Tipo de Mascota</h4>
                        </div>
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <canvas id="mascotasPorTipoChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h4 class="text-center">Usuarios por Rol</h4>
                        </div>
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <canvas id="usuariosPorRolChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Espacio para más gráficos en el futuro -->
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> Más estadísticas serán añadidas próximamente.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gráfico de mascotas por tipo
    const mascotas = <?= json_encode($mascotas) ?>;
    const tiposMascota = {
        'perro': 0,
        'gato': 0,
        'otro': 0
    };
    
    // Contar cada tipo de mascota
    mascotas.forEach(mascota => {
        const especie = mascota.especie.toLowerCase();
        if (especie.includes('perro')) {
            tiposMascota.perro++;
        } else if (especie.includes('gato')) {
            tiposMascota.gato++;
        } else {
            tiposMascota.otro++;
        }
    });
    
    // Crear el gráfico de torta para mascotas
    const ctxMascotas = document.getElementById('mascotasPorTipoChart').getContext('2d');
    const mascotasPorTipoChart = new Chart(ctxMascotas, {
        type: 'pie',
        data: {
            labels: ['Perros', 'Gatos', 'Otros'],
            datasets: [{
                label: 'Tipos de Mascotas',
                data: [tiposMascota.perro, tiposMascota.gato, tiposMascota.otro],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(255, 206, 86, 0.7)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Distribución por Tipo de Mascota'
                }
            }
        }
    });
    
    // Gráfico de usuarios por rol (versión de barras)
    const usuarios = <?= json_encode($usuarios) ?>;
    const roleUsuarios = {
        'administrador': 0,
        'usuario': 0,
        'veterinario': 0,
        'recepcionista': 0
    };
    
    // Contar cada rol de usuario
    usuarios.forEach(usuario => {
        const rol = usuario.role ? usuario.role.toLowerCase() : 'usuario';
        if (rol === 'administrador') {
            roleUsuarios.administrador++;
        } else if (rol === 'veterinario') {
            roleUsuarios.veterinario++;
        } else if (rol === 'recepcionista') {
            roleUsuarios.recepcionista++;
        } else {
            roleUsuarios.usuario++;
        }
    });
    
    // Crear el gráfico de barras para usuarios
    const ctxUsuarios = document.getElementById('usuariosPorRolChart').getContext('2d');
    const usuariosPorRolChart = new Chart(ctxUsuarios, {
        type: 'pie',
        data: {
            labels: ['Administrador', 'Usuario', 'Veterinario', 'Recepcionista'],
            datasets: [{
                label: 'Usuarios por Rol',
                data: [
                    roleUsuarios.administrador, 
                    roleUsuarios.usuario, 
                    roleUsuarios.veterinario,
                    roleUsuarios.recepcionista
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(255, 206, 86, 0.7)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Distribución de Usuarios por Rol'
                }
            }
        }
    });
    
    // Gráfico de autorizaciones por tipo
    const autorizaciones = {
        'cirugia': <?= $total_autorizaciones_cirugia ?>,
        'eutanasia': <?= $total_autorizaciones_eutanasia ?>,
        'sedacion': <?= $total_autorizaciones_sedacion ?>
    };
    
    const ctxAutorizaciones = document.getElementById('autorizacionesPorTipoChart').getContext('2d');
    const autorizacionesPorTipoChart = new Chart(ctxAutorizaciones, {
        type: 'bar',
        data: {
            labels: ['Cirugías', 'Eutanasias', 'Sedaciones'],
            datasets: [{
                label: 'Cantidad',
                data: [
                    autorizaciones.cirugia,
                    autorizaciones.eutanasia,
                    autorizaciones.sedacion
                ],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Cantidad de Autorizaciones por Tipo'
                }
            }
        }
    });

    // Gráfico de tratamientos preventivos
    const tratamientosPreventivos = {
        'vacunas': <?= $total_vacunas ?>,
        'desparasitaciones': <?= $total_desparasitaciones ?>
    };

    const ctxTratamientos = document.getElementById('tratamientosPreventivoChart').getContext('2d');
    const tratamientosPreventivoChart = new Chart(ctxTratamientos, {
        type: 'bar',
        data: {
            labels: ['Vacunas', 'Desparasitaciones'],
            datasets: [{
                label: 'Cantidad',
                data: [
                    tratamientosPreventivos.vacunas,
                    tratamientosPreventivos.desparasitaciones
                ],
                backgroundColor: [
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 159, 64, 0.7)'
                ],
                borderColor: [
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Cantidad de Tratamientos Preventivos'
                }
            }
        }
    });
});
</script>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
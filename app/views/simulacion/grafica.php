<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Gráfica de Tráfico Vehicular</h2>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Historial de Tráfico</h5>
            <canvas id="traficoChart"></canvas> <!-- 📊 Gráfica de tráfico -->
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Velocidad Promedio</h5>
            <canvas id="velocidadChart"></canvas> <!-- 📊 Gráfica de velocidad -->
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js -->
<script>
    async function cargarDatos() {
        const response = await fetch('api/get_trafico.php'); // 📌 API optimizada
        const data = await response.json();

        if (data.error) {
            console.error("Error:", data.error);
            return;
        }

        // 📊 Carga vehicular
        const ctxTrafico = document.getElementById('traficoChart').getContext('2d');
        new Chart(ctxTrafico, {
            type: 'line',
            data: {
                labels: data.fechas, // 📆 Fechas
                datasets: [{
                    label: 'Carga Vehicular',
                    data: data.cargas, // 🚗 Número de vehículos
                    borderColor: 'blue',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: { title: { display: true, text: 'Fecha y Hora' } },
                    y: { title: { display: true, text: 'Número de Vehículos' }, beginAtZero: true }
                }
            }
        });

        // 📊 Velocidad promedio
        const ctxVelocidad = document.getElementById('velocidadChart').getContext('2d');
        new Chart(ctxVelocidad, {
            type: 'line',
            data: {
                labels: data.fechas, // 📆 Fechas
                datasets: [{
                    label: 'Velocidad Promedio (km/h)',
                    data: data.velocidades, // 🚗 Velocidad media
                    borderColor: 'red',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: { title: { display: true, text: 'Fecha y Hora' } },
                    y: { title: { display: true, text: 'Velocidad (km/h)' }, beginAtZero: true }
                }
            }
        });
    }

    cargarDatos(); // Cargar datos al iniciar
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

<?php
/** @var array $intersecciones */
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container mt-5">
    <h2 class="text-center">Intersección de Tráfico</h2>

    <!-- Selector de Intersección -->
    <div class="mb-4">
        <label for="interseccion" class="form-label">Selecciona una Intersección:</label>
        <select id="interseccion" class="form-select" onchange="cargarDatosInterseccion()">
            <option value="">Seleccione...</option>
            <?php foreach ($intersecciones as $interseccion): ?>
                <option value="<?= $interseccion['Id']; ?>">
                    Intersección <?= $interseccion['Id']; ?> - <?= $interseccion['Descripcion']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="intersection">
        <div class="road vertical"></div>
        <div class="road horizontal"></div>

        <!-- 📌 Contenedor de Semáforos -->
        <div id="contenedorSemaforos"></div>

        <!-- 📌 Contenedor de Vehículos -->
        <div id="contenedorVehiculos"></div>
    </div>

    <!-- Controles para cambiar estado de semáforos -->
    <div class="mt-4">
        <h5>Cambiar Estado del Semáforo:</h5>
        <select id="semaforoSeleccionado" class="form-select">
            <option value="">Seleccione un semáforo</option>
        </select>
        <button class="btn btn-success mt-2" onclick="cambiarEstadoSemaforo('VERDE')">Verde</button>
        <button class="btn btn-warning mt-2" onclick="cambiarEstadoSemaforo('AMARILLO')">Amarillo</button>
        <button class="btn btn-danger mt-2" onclick="cambiarEstadoSemaforo('ROJO')">Rojo</button>
    </div>
</div>

<style>
    .vehiculo {
        position: absolute;
        width: 20px;
        height: 40px;
        border-radius: 5px;
        opacity: 0.9;
    }

    .carro { background: blue; }
    .moto { background: orange; width: 15px; height: 30px; }
    .camion { background: black; width: 30px; height: 60px; }
    .bus { background: purple; width: 40px; height: 70px; }
    .intersection {
        position: relative;
        width: 500px;
        height: 500px;
        margin: auto;
        background-color: #ccc;
        overflow: hidden;
    }
    .road {
        position: absolute;
        background: gray;
    }
    .vertical {
        width: 150px;
        height: 100%;
        left: 50%;
        transform: translateX(-50%);
    }
    .horizontal {
        width: 100%;
        height: 150px;
        top: 50%;
        transform: translateY(-50%);
    }
    .semaforo {
        width: 40px;
        height: 80px;
        border-radius: 5px;
        position: absolute;
        border: 2px solid black;
    }
    /* Posiciones fijas para semáforos */
    .semaforo-top { top: 10px; left: 225px; }
    .semaforo-bottom { bottom: 10px; left: 225px; }
    .semaforo-left { left: 10px; top: 225px; }
    .semaforo-right { right: 10px; top: 225px; }

    @keyframes moverDesdeAbajo {
        from { transform: translateY(0px); }
        to { transform: translateY(-300px); }
    }

    @keyframes moverDesdeArriba {
        from { transform: translateY(0px); }
        to { transform: translateY(300px); }
    }

    @keyframes moverDesdeIzquierda {
        from { transform: translateX(0px); }
        to { transform: translateX(300px); }
    }

    @keyframes moverDesdeDerecha {
        from { transform: translateX(0px); }
        to { transform: translateX(-300px); }
    }

</style>

<script>
    // Estado de los semáforos
    let semaforos = {};

    window.onload = function () {
        document.getElementById('interseccion').addEventListener('change', cargarDatosInterseccion);
    };

    async function cambiarEstadoSemaforo(nuevoEstado) {
        const selectSemaforo = document.getElementById('semaforoSeleccionado');
        const idSemaforo = selectSemaforo.value;

        if (!idSemaforo) {
            return;
        }

        if (!semaforos[idSemaforo]) {
            return;
        }

        if (semaforos[idSemaforo].intervalo) {
            clearTimeout(semaforos[idSemaforo].intervalo);
        }

        try {
            const response = await fetch('api/set_semaforo.php', {
                method: 'POST',
                body: JSON.stringify({ idSemaforo, estado: nuevoEstado }),
                headers: { 'Content-Type': 'application/json' }
            });

            const data = await response.json();
            if (!data.success) {
                return;
            }
        } catch (error) {
            return;
        }

        semaforos[idSemaforo].estado = nuevoEstado;
        document.getElementById(`semaforo${idSemaforo}`).style.backgroundColor = obtenerColor(nuevoEstado);

        iniciarCicloSemaforo(idSemaforo);
    }


    async function cargarDatosInterseccion() {
        const idInterseccion = document.getElementById('interseccion').value;
        if (!idInterseccion) return;

        await cargarSemaforos(idInterseccion);
        await cargarTrafico(idInterseccion);
    }


    async function cargarTrafico(idInterseccion) {
        const response = await fetch(`api/get_trafico.php?idInterseccion=${idInterseccion}`);

        const data = await response.json();

        if (data.error) {
            console.error("Error:", data.error);
            return;
        }



        const contenedorVehiculos = document.getElementById('contenedorVehiculos');
        contenedorVehiculos.innerHTML = ''; // Limpiar contenedor

        const tiposVehiculo = {
            "1": "carro",
            "2": "moto",
            "3": "camion",
            "4": "bus"
        };

        let posicionesInicio = [
            { left: "45%", top: "100%", destino: "semaforo-top", animacion: "moverDesdeAbajo" },
            { left: "45%", top: "-10%", destino: "semaforo-bottom", animacion: "moverDesdeArriba" },
            { left: "-10%", top: "45%", destino: "semaforo-right", animacion: "moverDesdeIzquierda" },
            { left: "100%", top: "45%", destino: "semaforo-left", animacion: "moverDesdeDerecha" }
        ];

        let totalVehiculos = 0;

        Object.keys(data.vehiculos).forEach(tipo => {
            let cantidad = data.vehiculos[tipo];

            for (let i = 0; i < cantidad; i++) {
                if (totalVehiculos >= 40) break; // Limitar a 40 vehículos

                const vehiculo = document.createElement('div');
                vehiculo.classList.add('vehiculo', tiposVehiculo[tipo]);

                let inicio = posicionesInicio[totalVehiculos % posicionesInicio.length]; // Alternar posiciones
                vehiculo.style.left = inicio.left;
                vehiculo.style.top = inicio.top;
                vehiculo.dataset.destino = inicio.destino;

                let duracion = Math.max(3, 10 - data.velocidadPromedio / 5);
                vehiculo.dataset.animacion = inicio.animacion;
                vehiculo.dataset.duracion = duracion;

                // ✅ Aplicar la animación correcta
                vehiculo.style.animation = `${inicio.animacion} ${duracion}s linear infinite`;

                contenedorVehiculos.appendChild(vehiculo);
                totalVehiculos++;
            }
        });

    }


    // ✅ Cargar semáforos y actualizar su estado automáticamente
    async function cargarSemaforos(idInterseccion) {
        const response = await fetch(`api/get_semaforos.php?idInterseccion=${idInterseccion}`);
        const data = await response.json();

        if (data.error) {
            console.error("Error:", data.error);
            return;
        }

        const contenedorSemaforos = document.getElementById('contenedorSemaforos');
        const selectSemaforo = document.getElementById('semaforoSeleccionado');

        contenedorSemaforos.innerHTML = '';
        selectSemaforo.innerHTML = '<option value="">Seleccione un semáforo</option>'; // ✅ NO SE SOBREESCRIBIRÁ

        semaforos = {}; // Reiniciar el estado de los semáforos

        let posiciones = ["semaforo-top", "semaforo-bottom", "semaforo-left", "semaforo-right"];

        data.forEach((semaforo, index) => {
            const nuevoSemaforo = document.createElement('div');
            nuevoSemaforo.classList.add('semaforo', posiciones[index % posiciones.length]);
            nuevoSemaforo.id = `semaforo${semaforo.Id}`;

            let estadoLimpio = semaforo.EstadoActual.trim().toUpperCase();
            semaforos[semaforo.Id] = {
                estado: estadoLimpio,
                tiempoVerde: semaforo.TiempoVerde * 1000,
                tiempoAmarillo: semaforo.TiempoAmarillo * 1000,
                tiempoRojo: semaforo.TiempoRojo * 1000
            };

            nuevoSemaforo.style.backgroundColor = obtenerColor(estadoLimpio);
            contenedorSemaforos.appendChild(nuevoSemaforo);

            // ✅ AHORA SÍ SE AGREGAN BIEN LAS OPCIONES
            selectSemaforo.innerHTML += `<option value="${semaforo.Id}">Semáforo ${semaforo.Id}</option>`;

            // Iniciar el ciclo de cambios de estado
            iniciarCicloSemaforo(semaforo.Id);
        });
    }

    function iniciarCicloSemaforo(id) {
        let semaforo = semaforos[id];
        let domSemaforo = document.getElementById(`semaforo${id}`);

        if (!semaforo || !domSemaforo) return;

        async function ciclo() {
            while (true) {
                if (!semaforos[id]) return; 

                if (semaforo.estado === "VERDE") {
                    await esperar(semaforo.tiempoVerde);
                    actualizarSemaforo(id, "AMARILLO");
                } else if (semaforo.estado === "AMARILLO") {
                    await esperar(semaforo.tiempoAmarillo);
                    actualizarSemaforo(id, "ROJO");
                } else if (semaforo.estado === "ROJO") {
                    await esperar(semaforo.tiempoRojo);
                    actualizarSemaforo(id, "VERDE");
                }
            }
        }

        semaforos[id].intervalo = setTimeout(ciclo, 1000);
    }

    async function actualizarSemaforo(idSemaforo, nuevoEstado) {
        if (!semaforos[idSemaforo]) return;

        // ⚠ Verificar si el cambio de estado es válido
        let estadoActual = semaforos[idSemaforo].estado;
        let cambioValido = false;

        if (estadoActual === "VERDE" && nuevoEstado === "AMARILLO") {
            cambioValido = true;
        } else if (estadoActual === "AMARILLO" && nuevoEstado === "ROJO") {
            cambioValido = true;
        } else if (estadoActual === "ROJO" && nuevoEstado === "VERDE") {
            cambioValido = true;
        }

        if (!cambioValido) {

            return;
        }

        // ✅ Aplicar el cambio de estado
        semaforos[idSemaforo].estado = nuevoEstado;
        document.getElementById(`semaforo${idSemaforo}`).style.backgroundColor = obtenerColor(nuevoEstado);

        // ✅ Enviar actualización a la base de datos
        await fetch('api/set_semaforo.php', {
            method: 'POST',
            body: JSON.stringify({ idSemaforo, estado: nuevoEstado }),
            headers: { 'Content-Type': 'application/json' }
        });


    }

    // ✅ Función auxiliar para obtener el color del semáforo
    function obtenerColor(estado) {
        switch (estado.toUpperCase()) {
            case "VERDE": return "green";
            case "AMARILLO": return "yellow";
            case "ROJO": return "red";
            default: return "gray";
        }
    }

    // ✅ Función de espera en milisegundos
    function esperar(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    // ✅ Al cambiar de intersección, reiniciar los ciclos
    document.getElementById('interseccion').addEventListener('change', async function () {
        await cargarDatosInterseccion();
    });



</script>

<?php
require_once __DIR__ . '/../layouts/footer.php';?>

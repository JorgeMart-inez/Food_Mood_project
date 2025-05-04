//EVENTO DE HILOS
//--sugerencias
const worker = new Worker('../js/worker.js');
document.addEventListener("DOMContentLoaded", function() {
    const selectAperitivo    = document.getElementById("aperitivo");
    const selectEntrada      = document.getElementById("entrada");
    const selectPlatoFuerte  = document.getElementById("plato_fuerte");

    const sugerenciaAperitivo= document.getElementById("sugerencia_aperitivo");
    const sugerenciaEntrada  = document.getElementById("sugerencia_entrada");
    const sugerenciaPF       = document.getElementById("sugerencia_plato_fuerte");

    const divSugerencia = document.getElementById("sugerencia");
    let timeoutID; 

    function mostrarSugerencias() { //hilo cooperativo
        divSugerencia.style.display = "block"; 
        clearTimeout(timeoutID); 
        timeoutID = setTimeout(() => {
            divSugerencia.style.display = "none"; 
        }, 9000);
    }

    selectAperitivo.addEventListener("change", function() {
       const aperitivo = selectAperitivo.value;
            worker.postMessage({ tipo: "aperitivo", valor: aperitivo}); 
    });

    selectEntrada.addEventListener("change", function() {
        const entrada = selectEntrada.value;
            worker.postMessage({ tipo: "entrada", valor: entrada });
    });

    selectPlatoFuerte.addEventListener("change", function() {
        const platoFuerte = selectPlatoFuerte.value;
            worker.postMessage({ tipo: "plato_fuerte", valor: platoFuerte });
    });

    worker.onmessage = function(event) {
    const { tipo, recomendacion } = event.data;
        if(tipo === "aperitivo")
        {
            sugerenciaAperitivo.innerText = recomendacion || "No hay sugerencias";
        } 
        else if (tipo === "entrada") 
        {
            sugerenciaEntrada.innerText = recomendacion || "No hay sugerencias.";
        } 
        else if (tipo === "plato_fuerte") 
        {
            sugerenciaPF.innerText = recomendacion || "No hay sugerencias.";
        } 
        mostrarSugerencias();
    };
});
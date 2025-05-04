
const sugerenciasAperitivo = {
    queso     : "Le recomendamos como entrada: Pinchos de filete de ternera con salsa de reducción de vino.",
    falafel   : "Le recomendamos como entrada: Mini tartaletas de langostinos con salsa de mantequilla.",
    pinchos   : "Le recomendamos como entrada: Mini hamburguesas de ternera",
    quiches   : "Le recomendamos como entrada: Croquetas de pescado con salsa tártara.",
    brochetas : "Le recomendamos como entrada: Crema de langostino con crutones de Baguette",
    tostadas  : "Le recomendamos como entrada: Crema de champiñones con crutones de Masa madre."
}

const sugerenciasEntrada = {
    hamburguesas : "Le recomendamos como plato fuerte: Salmón a la parrilla con ensalada de aguacate y mango.",
    pinchos      : "Le recomendamos como plato fuerte: Lasaña de verduras con queso y salsa de tomate",
    croquetas    : "Le recomendamos como plato fuerte: Salmón ahumado con ensalada de aguacate y caviar.",
    tartaletas   : "Le recomendamos como plato fuerte: Paella de mariscos con arroz y verduras.",
    crema_langos : "Le recomendamos como plato fuerte: Pollo al horno con trufa y puré de papas",
    crema_champi : "Le recomendamos como plato fuerte: Filete de ternera a la pimienta con puré de papas."
};

const sugerenciasPlatoFuerte = {
    albondigas : "Le recomendamos como postre: Mousse de Fresa",
    paella     : "Le recomendamos como postre: Pastel Integral de Zanahoria",
    lasaña     : "Le recomendamos como postre: Mousse de Mango",
    filete     : "Le recomendamos como postre: Chessecake de frutos rojos",
    salmon     : "Le recomendamos como postre: Brownies de chocolate y vainilla con nueces de castilla",
    pollo      : "Le recomendamos como postre: Chessecake de frutos rojos",
    salmon     : "Le recomendamos como postre: Queso Napolitano",
    camarones  : "Le recomendamos como postre: Queso Napolitano"
};

onmessage = function(event) {
    const { tipo, valor } = event.data;
    let recomendacion = "";
    if(tipo === "aperitivo"){
        recomendacion = sugerenciasAperitivo[valor] || "No hay sugerencias para este aperitivo.";
    }
    else if (tipo === "entrada") {
        recomendacion = sugerenciasEntrada[valor] || "No hay sugerencias para esta entrada.";
    } else if (tipo === "plato_fuerte") {
        recomendacion = sugerenciasPlatoFuerte[valor] || "No hay sugerencias para este plato fuerte.";
    }
    postMessage({ tipo, recomendacion });
};


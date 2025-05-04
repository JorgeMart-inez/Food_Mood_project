
const sugerenciasAperitivo = {
    1   : "Le recomendamos como entrada: Pinchos de filete de ternera con salsa de reducción de vino.",
    2   : "Le recomendamos como entrada: Mini tartaletas de langostinos con salsa de mantequilla.",
    3   : "Le recomendamos como entrada: Mini hamburguesas de ternera",
    4   : "Le recomendamos como entrada: Croquetas de pescado con salsa tártara.",
    5   : "Le recomendamos como entrada: Crema de langostino con crutones de Baguette",
    6   : "Le recomendamos como entrada: Crema de champiñones con crutones de Masa madre."
}

const sugerenciasEntrada = {
    1 : "Le recomendamos como plato fuerte: Salmón a la parrilla con ensalada de aguacate y mango.",
    2 : "Le recomendamos como plato fuerte: Lasaña de verduras con queso y salsa de tomate",
    3 : "Le recomendamos como plato fuerte: Salmón ahumado con ensalada de aguacate y caviar.",
    4 : "Le recomendamos como plato fuerte: Paella de mariscos con arroz y verduras.",
    5 : "Le recomendamos como plato fuerte: Pollo al horno con trufa y puré de papas",
    6 : "Le recomendamos como plato fuerte: Filete de ternera a la pimienta con puré de papas."
};

const sugerenciasPlatoFuerte = {
    1 : "Le recomendamos como postre: Mousse de Fresa",
    2 : "Le recomendamos como postre: Pastel Integral de Zanahoria",
    3 : "Le recomendamos como postre: Mousse de Mango",
    4 : "Le recomendamos como postre: Chessecake de frutos rojos",
    5 : "Le recomendamos como postre: Brownies de chocolate y vainilla con nueces de castilla",
    6 : "Le recomendamos como postre: Chessecake de frutos rojos",
    7 : "Le recomendamos como postre: Queso Napolitano",
    8 : "Le recomendamos como postre: Queso Napolitano"
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


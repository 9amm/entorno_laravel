async function guardarValorModoOscuroEnServidor(modoOscuroActivado) {
    await fetch("/theme", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `modoOscuroActivado=${modoOscuroActivado}`
    })
}


function cssModoOscuroActivado(estaActivado) {
    let body = document.querySelector("body");

    if(estaActivado) {
        body.classList.add("tema-oscuro");
    } else {
        body.classList.remove("tema-oscuro");
    }
}

async function modoOscuroActivado(estaActivado) {
    cssModoOscuroActivado(estaActivado);

    document.cookie = `modoOscuroActivado=${estaActivado};path=/`;
    await guardarValorModoOscuroEnServidor(estaActivado)
}


function getCookieValue(name) {
    const regex = new RegExp(`(^| )${name}=([^;]+)`)
    const match = document.cookie.match(regex)
    if (match) {
        return match[2]
    }
}

function cookieModoOscuroEstaActivada(){
    return getCookieValue("modoOscuroActivado") == "true";
}

async function cargarTema() {
    cssModoOscuroActivado(cookieModoOscuroEstaActivada());
}
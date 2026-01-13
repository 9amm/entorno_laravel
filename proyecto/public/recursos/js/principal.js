//Modo Oscuro
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


//MODERACION
function getIdMensaje(boton) {
    return boton.getAttribute("id_mensaje");
}

async function enviarPost(ruta) {
    let peticion = await fetch(ruta, {method: "POST"})
}

async function approveMessage(boton) {
    let idMensaje = getIdMensaje(boton);
    ruta = `/moderation/${idMensaje}/approve`;
    await enviarPost(ruta);
    location.reload();
}

async function rejectMessage(boton) {
    let idMensaje = getIdMensaje(boton);
    ruta = `/moderation/${idMensaje}/reject`;
    await enviarPost(ruta);
    location.reload();
}


//LOGOUT
async function enviarPeticionLogout() {
    await fetch("/logout", {method: "POST"});
    location.reload();
}

async function logout() {
    if(confirm("¿Cerrar sesión?")) {
        await enviarPeticionLogout();
    }
}
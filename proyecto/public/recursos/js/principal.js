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

function getCsrfToken(botonAprobarORechazar) {
    return botonAprobarORechazar.parentElement.getAttribute("csrf-token");
}


//TODO: codigo muy parecido, guardar url en el boton?
async function approveMessage(boton) {
    let idMensaje = getIdMensaje(boton);
    ruta = `/moderation/${idMensaje}/approve`;
    let peticion = await fetch(ruta, {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': getCsrfToken(boton)
        }
    })
    location.reload();
}

async function rejectMessage(boton) {
    let idMensaje = getIdMensaje(boton);
    ruta = `/moderation/${idMensaje}/reject`;
    let peticion = await fetch(ruta, {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': getCsrfToken(boton)
        }
    })
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
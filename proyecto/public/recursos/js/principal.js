//Modo Oscuro
async function guardarValorModoOscuroEnServidor(modoOscuroActivado) {
    await fetch("/theme", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            'X-CSRF-TOKEN': getCsrfToken(),
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


function getCsrfToken(elemento) {
    return document.querySelector("meta[csrf-token]").getAttribute("csrf-token")
}


//TODO: codigo muy parecido, guardar url en el boton?
async function approveMessage(idMensaje) {
    //let idMensaje = getIdMensaje(boton);
    ruta = `/moderation/${idMensaje}/approve`;
    await fetch(ruta, {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': getCsrfToken()
        }
    })
    location.reload();
}

async function rejectMessage(idMensaje) {
    ruta = `/moderation/${idMensaje}/reject`;
    await fetch(ruta, {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': getCsrfToken()
        }
    })
    location.reload();
}


//LOGOUT
async function enviarPeticionLogout() {
    await fetch("/logout", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': getCsrfToken()
        }
    });
    location.reload();
}

async function logout() {
    if(confirm("¿Cerrar sesión?")) {
        await enviarPeticionLogout();
    }
}


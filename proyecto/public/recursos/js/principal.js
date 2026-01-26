//Modo Oscuro
async function guardarValorModoOscuroEnServidor(url, modoOscuroActivado) {
    await fetch(url, {
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

async function modoOscuroActivado(boton) {
    const estaActivado = boton.checked;

    cssModoOscuroActivado(estaActivado);
    const url = getUrl(boton);

    document.cookie = `modoOscuroActivado=${estaActivado};path=/`;
    await guardarValorModoOscuroEnServidor(url, estaActivado)
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
async function approveMessage(boton) {
    await fetch(getUrl(boton), {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': getCsrfToken()
        }
    })
    location.reload();
}

async function rejectMessage(boton) {
    await fetch(getUrl(boton), {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': getCsrfToken()
        }
    })
    location.reload();
}

function getUrl(elemento) {
    return elemento.dataset.url
}

//LOGOUT
async function enviarPeticionLogout(url) {
    await fetch(url, {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': getCsrfToken()
        }
    });
    window.location.href = "/";
}

async function logout(boton) {
    const url = getUrl(boton)
    if(confirm("¿Cerrar sesión?")) {
        await enviarPeticionLogout(url);
    }
}


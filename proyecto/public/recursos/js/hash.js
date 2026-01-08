async function sha256(string) {
    // encode as UTF-8
    const msgBuffer = new TextEncoder().encode(string);

    // hash the message
    const hashBuffer = await crypto.subtle.digest('SHA-256', msgBuffer);

    // convert ArrayBuffer to Array
    const hashArray = Array.from(new Uint8Array(hashBuffer));

    // convert bytes to hex string 
    const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
    return hashHex;
}


document.querySelector("form").addEventListener("submit", async (e) => {
    e.preventDefault();
    const formulario = e.target;

    const inputPassTextoPlano = document.getElementById("pass");
    const inputPassHasheada = document.getElementById("hashed-pass");

    inputPassHasheada.value = await sha256(inputPassTextoPlano.value);

    formulario.submit();
});
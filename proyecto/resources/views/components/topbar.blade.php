<div class="topbar">
    <button id="boton-atras" onclick="history.back()" title="Volver Atrás"></button>
    <p>{{ $slot }}</p>

    <label class="switch">
        <input id="checkbox-modo-oscuro" data-url="{{route('set_tema')}}" onchange="modoOscuroActivado(this)" type="checkbox">
        <span class="slider round"></span>
    </label>

    <script>
        document.getElementById("checkbox-modo-oscuro").checked = getCookieValue("modoOscuroActivado") == "true";
    </script>
</div>


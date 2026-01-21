@extends("layouts.base")


@section('contenido')
    <x-sidebar></x-sidebar>

    <x-contenido-principal titulo="Crear mensaje">
        <form method="post" action="{{route('mensaje_formulario_guardar')}}" class="form-crear-mensaje">
            @csrf

            <label for="asignatura">Asignatura</label>
            <select required name="id_asignatura" id="asignatura">
                <option value="">--Selecciona asignatura--</option>

                <?foreach($asignaturas as $asignatura):?>
                    <option value="{{$asignatura->id}}">{{$asignatura->nombre}}</option>
                <?endforeach;?>

            </select>
            
            <label for="contenido-mensaje">Mensaje</label>
            <textarea required minlength="1" maxlength="280" placeholder="Escribe aqui tu mensaje..." name="mensaje" id="contenido-mensaje"></textarea>
            <p id="contador-caracteres">0/280</p>

            <input id="boton-publicar-mensaje" class="boton" type="submit" value="Publicar">
        </form>

        <script>
            const LONGITUD_MAXIMA_CARACTERES = 280;

            const textareaMensaje = document.getElementById("contenido-mensaje");
            const contadorCaracteres = document.getElementById("contador-caracteres");

            textareaMensaje.addEventListener("input", () => {
                let caracteresEscritos = textareaMensaje.value.length;
                contadorCaracteres.textContent = `${caracteresEscritos}/${LONGITUD_MAXIMA_CARACTERES}`
            })
        </script>


    </x-contenido-principal>

@endsection

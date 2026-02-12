INSERT ignore INTO `asignatura` (`id`, `nombre`) VALUES 
    (1, 'Bases de datos'),
    (2, 'Sistemas'),
    (3, 'Lenguajes de marca'),
    (4, 'Programacion'),
    (5, 'Entornos de desarrollo');


/*
Usuarios de prueba:
    usuario      pass
    alumno1      @Holaquetal
    profesor1    @Holaquetal
*/
INSERT INTO `usuario` (`id`, `nombre`, `email`, `pass_hasheada`, `rol`, `modo_oscuro_activado`) VALUES (NULL, 'alumno1', 'alumno1@gmail.com', 'cdc9bba7f88d0f712e233ddb4ed64de872d77081e0c9e1a97af162ae1eb4d1bf', 'alumno', '0');
INSERT INTO `usuario` (`id`, `nombre`, `email`, `pass_hasheada`, `rol`, `modo_oscuro_activado`) VALUES (NULL, 'profesor1', 'profesor1@gmail.com', 'cdc9bba7f88d0f712e233ddb4ed64de872d77081e0c9e1a97af162ae1eb4d1bf', 'profesor', '0');
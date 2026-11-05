<?php
function perfilesDeRespuestasQuiz(array $respuestas): ?array
{
    $generosPorOpcion = [
        [['indie', 'soul', 'electronica'], ['pop', 'electronica', 'latin'], ['indie', 'rock', 'latin'], ['rock', 'pop', 'hiphop']],
        [['hiphop', 'electronica', 'latin'], ['indie', 'soul', 'latin'], ['rock', 'indie', 'soul'], ['electronica', 'pop', 'indie']],
        [['pop', 'latin'], ['indie', 'rock'], ['hiphop', 'electronica'], ['rock', 'soul', 'pop']],
        [['rock', 'indie'], ['electronica', 'pop'], ['hiphop', 'soul', 'latin'], ['soul', 'pop', 'latin']],
        [['rock', 'hiphop', 'pop'], ['indie', 'soul'], ['latin', 'electronica', 'pop'], ['soul', 'indie', 'hiphop']],
    ];
    $ordenGeneros = ['indie', 'pop', 'rock', 'electronica', 'hiphop', 'latin', 'soul'];

    if (count($respuestas) !== count($generosPorOpcion)) {
        return null;
    }

    $puntuaciones = array_fill_keys($ordenGeneros, 0);
    foreach (array_values($respuestas) as $indicePregunta => $indiceOpcion) {
        if (!is_int($indiceOpcion) || !isset($generosPorOpcion[$indicePregunta][$indiceOpcion])) {
            return null;
        }

        foreach ($generosPorOpcion[$indicePregunta][$indiceOpcion] as $posicion => $genero) {
            $puntuaciones[$genero] += $posicion === 0 ? 2 : 1;
        }
    }

    usort($ordenGeneros, static function (string $a, string $b) use ($puntuaciones): int {
        return $puntuaciones[$b] <=> $puntuaciones[$a];
    });

    return array_slice($ordenGeneros, 0, 2);
}

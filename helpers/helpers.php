<?php



// helper para formatear la fecha en formato AA/MM/DD ej 24/06/11

if (!function_exists('formatDate')) {
    function formatDate($date)
    {
        return date('d/m/y', strtotime($date));
    }
}

// Helper para formatear la trazabilidad de los articulos

if (!function_exists('formatTraceability')) {
    function formatTrazabilidad($traceability)
    {

        // Dividir el string en partes usando el guion como delimitador
        $traceabilityFormat = explode('-', $traceability);

        // Verificar que hay al menos 5 elementos en el array
        if (count($traceabilityFormat) < 5) {
            return $traceability; // Si no cumple con el formato esperado, retornamos el original
        }

        // Eliminar el tercer elemento (que corresponde al año)
        unset($traceabilityFormat[2]);

        // Reindexar el array para asegurarnos de que no haya huecos
        $traceabilityFormat = array_values($traceabilityFormat);

        // Asegurarse de que el segundo elemento tenga un "0" delante si es necesario
        $traceabilityFormat[1] = str_pad($traceabilityFormat[1], 2, '0', STR_PAD_LEFT);

        // Volver a unir los elementos con guiones
        return implode('-', $traceabilityFormat);
    }
}


// Helper para formatear El nombre de una carpeta para que no tenga espacios o caracteres especiales
if (!function_exists('formatFolderName')) {
    function formatFolderName($folderName)
    {

        // validar si el nombre de la carpeta es muy largo y cortarlo
        if (strlen($folderName) > 100) {
            $folderName = substr($folderName, 0, 100);
        }

        $nombreFolder = str_replace(' ', '_', $folderName);
        $nombreFolder = str_replace('/', '_', $nombreFolder);
        $nombreFolder = str_replace('\\', '_', $nombreFolder);
        $nombreFolder = str_replace(':', '_', $nombreFolder);
        $nombreFolder = str_replace('*', '_', $nombreFolder);
        $nombreFolder = str_replace('?', '_', $nombreFolder);
        $nombreFolder = str_replace('"', '_', $nombreFolder);
        $nombreFolder = str_replace('<', '_', $nombreFolder);
        $nombreFolder = str_replace('>', '_', $nombreFolder);
        $nombreFolder = str_replace('.', '_', $nombreFolder);
        $nombreFolder = str_replace('|', '_', $nombreFolder);
        $nombreFolder = str_replace(';', '_', $nombreFolder);
        $nombreFolder = str_replace(',', '_', $nombreFolder);
        $nombreFolder = str_replace('!', '_', $nombreFolder);
        $nombreFolder = str_replace('¡', '_', $nombreFolder);
        $nombreFolder = str_replace('¿', '_', $nombreFolder);
        $nombreFolder = str_replace('?', '_', $nombreFolder);
        $nombreFolder = str_replace('(', '_', $nombreFolder);
        $nombreFolder = str_replace(')', '_', $nombreFolder);
        $nombreFolder = str_replace('[', '_', $nombreFolder);
        $nombreFolder = str_replace(']', '_', $nombreFolder);
        $nombreFolder = str_replace('{', '_', $nombreFolder);
        $nombreFolder = str_replace('}', '_', $nombreFolder);
        $nombreFolder = str_replace('=', '_', $nombreFolder);
        $nombreFolder = str_replace('+', '_', $nombreFolder);
        $nombreFolder = str_replace('-', '_', $nombreFolder);
        $nombreFolder = str_replace('_', '_', $nombreFolder);
        $nombreFolder = str_replace('´', '_', $nombreFolder);
        $nombreFolder = str_replace('`', '_', $nombreFolder);
        $nombreFolder = str_replace('~', '_', $nombreFolder);
        $nombreFolder = str_replace('¨', '_', $nombreFolder);
        $nombreFolder = str_replace('^', '_', $nombreFolder);
        $nombreFolder = str_replace('´', '_', $nombreFolder);
        $nombreFolder = str_replace('`', '_', $nombreFolder);
        $nombreFolder = str_replace('!', '_', $nombreFolder);
        $nombreFolder = str_replace('@', '_', $nombreFolder);
        $nombreFolder = str_replace('#', '_', $nombreFolder);
        $nombreFolder = str_replace('$', '_', $nombreFolder);
        $nombreFolder = str_replace('%', '_', $nombreFolder);
        $nombreFolder = str_replace('&', '_', $nombreFolder);
        $nombreFolder = str_replace('¬', '_', $nombreFolder);
        $nombreFolder = str_replace('°', '_', $nombreFolder);
        $nombreFolder = str_replace(';', '_', $nombreFolder);
        $nombreFolder = str_replace(':', '_', $nombreFolder);
        $nombreFolder = str_replace('¡', '_', $nombreFolder);
        $nombreFolder = str_replace('!', '_', $nombreFolder);

        return $nombreFolder;
    }
}

// Funcion para formatear los precios a euros con comas y 2 decimales
if (!function_exists('formatPrice')) {
    function formatPrice($price)
    {
        return number_format($price, 2, ',', '.') . ' €';
    }
}
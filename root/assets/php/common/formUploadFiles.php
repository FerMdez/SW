<?php
require_once('../assets/php/form.php');

class FormUploadFiles extends Form {
    //Constants:
    const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$'; 

    public function __construct() {
        $options = array('enctype' => 'multipart/form-data');
        parent::__construct('formUploadFiles', $options);
    }
    
    protected function generaCamposFormulario($datos, $errores = array()) {

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorFile = self::createMensajeError($errores, 'archivo', 'span', array('class' => 'error'));

        foreach($datos as $key => $value){
            $dats = $key." ".$value."  ";
        }

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = '
                <div class="file">
                    <label for="file">Imagen:</label><input type="file" name="file" id="file" /><pre>'.$htmlErroresGlobales.'</pre>
                </div>
                <input type="submit" id="submit" value="Subir" class="primary" /><pre>'.$errorFile.'</pre>
                ';

        return $html;
    }

    protected function procesaFormulario($datos) {
        // Solo se pueden definir arrays como constantes en PHP >= 5.6
        global $ALLOWED_EXTENSIONS;
        
        $result = array();
        $ok = count($_FILES) == 1 && $_FILES['archivo']['error'] == UPLOAD_ERR_OK;
        
        if ( $ok ) {
            $archivo = $_FILES['archivo'];
            $nombre = $_FILES['archivo']['name'];
            /* 1.a) Valida el nombre del archivo */
            $ok = $this->check_file_uploaded_name($nombre) && $this->check_file_uploaded_length($nombre) ;
            /* 1.b) Sanitiza el nombre del archivo 
            $ok = sanitize_file_uploaded_name($nombre);
            */
            /* 1.c) Utilizar un id de la base de datos como nombre de archivo */

            /* 2. comprueba si la extensión está permitida*/
            $ok = $ok && in_array(pathinfo($nombre, PATHINFO_EXTENSION), $ALLOWED_EXTENSIONS);

            /* 3. comprueba el tipo mime del archivo correspode a una imagen image/* */
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $_FILES['archivo']['tmp_name']);
            $ok = preg_match('/image\/*./', $mimeType);
            finfo_close($finfo);

            if ( $ok ) {
            $tmp_name = $_FILES['archivo']['tmp_name'];

            if ( !move_uploaded_file($tmp_name, FILMS_DIR.$nombre) ) {
                $result[] = 'Error al mover el archivo';
            }

            // 4. Si fuese necesario guardar en la base de datos la ruta relativa $nombre del archivo
            //return "index.php#img=".urlencode('img/'.$nombre);
            } else {
                $result["errorFile"] = 'El archivo tiene un nombre o tipo no soportado';
            }
        } else {
            $result[] = 'Error al subir el archivo.';
        }
        return $result;
    }


    /**
     * Check $_FILES[][name]
     *
     * @param (string) $filename - Uploaded file name.
     * @author Yousef Ismaeil Cliprz
     * @See http://php.net/manual/es/function.move-uploaded-file.php#111412
     */
    protected function check_file_uploaded_name ($filename) {
        return (bool) ((mb_ereg_match('/^[0-9A-Z-_\.]+$/i',$filename) === 1) ? true : false );
    }

    /**
     * Sanitize $_FILES[][name]. Remove anything which isn't a word, whitespace, number
     * or any of the following caracters -_~,;[]().
     *
     * If you don't need to handle multi-byte characters you can use preg_replace
     * rather than mb_ereg_replace.
     * 
     * @param (string) $filename - Uploaded file name.
     * @author Sean Vieira
     * @see http://stackoverflow.com/a/2021729
     */
    protected function sanitize_file_uploaded_name($filename) {
        /* Remove anything which isn't a word, whitespace, number
        * or any of the following caracters -_~,;[]().
        * If you don't need to handle multi-byte characters
        * you can use preg_replace rather than mb_ereg_replace
        * Thanks @Łukasz Rysiak!
        */
        $newName = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $filename);
        // Remove any runs of periods (thanks falstro!)
        $newName = mb_ereg_replace("([\.]{2,})", '', $newName);

        return $newName;
    }

    /**
     * Check $_FILES[][name] length.
     *
     * @param (string) $filename - Uploaded file name.
     * @author Yousef Ismaeil Cliprz.
     * @See http://php.net/manual/es/function.move-uploaded-file.php#111412
     */
    protected function check_file_uploaded_length ($filename) {
        return (bool) ((mb_strlen($filename,'UTF-8') < 250) ? true : false);
    }
}
?>
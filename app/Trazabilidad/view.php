<?php
$diccionario = array(
    'subtitle'=>array(VIEW_SET_USER=>'Crear un nuevo usuario',
                      VIEW_GET_USER=>'Buscar usuario',
                      VIEW_DELETE_USER=>'Eliminar un usuario',
                      VIEW_EDIT_USER=>'Modificar usuario',
                      VIEW_VISTA_USER=>'Todos los usuarios'
                     ),
    'links_menu'=>array(
        'VIEW_SET_USER'=>MODULO.VIEW_SET_USER.'/',
        'VIEW_GET_USER'=>MODULO.VIEW_GET_USER.'/',
        'VIEW_EDIT_USER'=>MODULO.VIEW_EDIT_USER.'/',
        'VIEW_DELETE_USER'=>MODULO.VIEW_DELETE_USER.'/',
        'VIEW_VISTA_USER'=>MODULO.VIEW_VISTA_USER.'/'
    ),
    'form_actions'=>array(
        'SET'=>'/mvc/'.MODULO.SET_USER.'/',
        'GET'=>'/mvc/'.MODULO.GET_USER.'/',
        'DELETE'=>'/mvc/'.MODULO.DELETE_USER.'/',
        'EDIT'=>'/mvc/'.MODULO.EDIT_USER.'/',
        'vista'=>'/mvc/'.MODULO.VISTA_USER.'/'
    )
);

function get_template($form='get') {
    if ($form=='template'){
        $file = '../site_media/html/'.$form.'.html';
    }else{
       $file = '../site_media/html/usuario/user_'.$form.'.html'; 
    }    
    $template = file_get_contents($file);
    return $template;
}

function render_dinamic_data($html, $data) {
    foreach ($data as $clave=>$valor) {
        $html = str_replace('{'.$clave.'}', $valor, $html);
    }
    return $html;
}

function render_dinamic_tabla($html, $data) {
   $registo= '';
    foreach ($data as $clave) {
        $registo.= '<tr>'
                . '<th> '.$clave['nombre'].'</th>'
                . '<th> '.$clave['apellido'].'</th>'
                . '<th> '.$clave['email'].'</th>'
                . ' </tr>';       
    }
    
    $html = str_replace('{registos}', $registo, $html);
    return $html;
}

function retornar_vista($vista, $data=array()) {
    global $diccionario;
    $html = get_template('template');
    $html = str_replace('{subtitulo}', $diccionario['subtitle'][$vista], $html);    
    $html = str_replace('{formulario}', get_template($vista), $html);    
    $html = render_dinamic_data($html, $diccionario['form_actions']);
    $html = render_dinamic_data($html, $diccionario['links_menu']);
    
    $html = render_dinamic_data($html, $data);

    // render {mensaje}
    if(array_key_exists('nombre', $data)&&
       array_key_exists('apellido', $data)&&
       $vista==VIEW_EDIT_USER) {
        $mensaje = 'Editar usuario '.$data['nombre'].' '.$data['apellido'];
    } else {
        if(array_key_exists('mensaje', $data)) {
            $mensaje = $data['mensaje'];
        } else {
            $mensaje = 'Datos del usuario:';
        }
    }
    $html = str_replace('{mensaje}', $mensaje, $html);

    print $html;
}

function retornar_vista_array($vista,$encabezado = array(),$datos = array()){
     global $diccionario;
    $html = get_template('template');
    $html = str_replace('{formulario}', get_template($vista), $html);
    $html = str_replace('{subtitulo}', $diccionario['subtitle'][$vista], $html); 
    $html = render_dinamic_data($html, $diccionario['links_menu']);    
    $html = render_dinamic_data($html, $encabezado);
    $html = render_dinamic_tabla($html, $datos);
    print $html;
}
?>

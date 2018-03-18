<?php

namespace GestionBundle\Controller;

use GestionBundle\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Usuario controller.
 *
 */
class UsuarioController extends Controller
{
    /**
     * Lists all usuario entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $usuarios = $em->getRepository('GestionBundle:Usuario')->findAll();

         return $this->render('usuario/index.html.twig', array(
            'usuarios' => $usuarios,
        ));
    }

    /**
     * Creates a new usuario entity.
     *
     */
    public function newAction(Request $request)
    {
        $usuario = new Usuario();
        $form = $this->createForm('GestionBundle\Form\UsuarioType', $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush($usuario);

            return $this->redirectToRoute('usuario_show', array('id' => $usuario->getId()));
        }

        return $this->render('usuario/new.html.twig', array(
            'usuario' => $usuario,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a usuario entity.
     *
     */
    public function showAction(Usuario $usuario)
    {
        $deleteForm = $this->createDeleteForm($usuario);

        return $this->render('usuario/show.html.twig', array(
            'usuario' => $usuario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing usuario entity.
     *
     */
    public function editAction(Request $request, Usuario $usuario)
    {
        $deleteForm = $this->createDeleteForm($usuario);
        $editForm = $this->createForm('GestionBundle\Form\UsuarioType', $usuario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('usuario_edit', array('id' => $usuario->getId()));
        }

        return $this->render('usuario/edit.html.twig', array(
            'usuario' => $usuario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a usuario entity.
     *
     */
    public function deleteAction(Request $request, Usuario $usuario)
    {
        $form = $this->createDeleteForm($usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($usuario);
            $em->flush($usuario);
        }

        return $this->redirectToRoute('usuario_index');
    }

    /**
     * Creates a form to delete a usuario entity.
     *
     * @param Usuario $usuario The usuario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Usuario $usuario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usuario_delete', array('id' => $usuario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

     /**
     * Creates a new usuario entity.
     *
     */
    public function loginAction(Request $request)
    {
       if($request->getMethod()=="POST"){
            $username = $request->get("nomb_us");
            $pass = $request->get("nomb_cl");

            $user = $this->getDoctrine()->getRepository('GestionBundle:Usuario')->findOneBy(array("nombreUsuario"=>$username,"clave"=>md5($pass)));
                    if($user)                    {
                        $session = $request->getSession();
                        $session->set("usuarionombre",$user->getNombreUsuario());
                        $session->set("myrol",$user->getTipo());
                        $session->set("ID",$user->getId());

                            if($user->getTipo() == 'Prohibido'){
                                $this->get('session')->getFlashBag()->add('fall','ACCESO Prohibido');              
                                
                            }
                            if($user->getTipo() == 'Administrador' || $user->getTipo() == 'Limitado'){
                                
                                return $this->redirect($this->generateUrl('inicio_detalles'));
                            }
                    }else{
                         $this->get('session')->getFlashBag()->add('fall','ACCESO INVALIDO');               
                        return $this->redirect($this->generateUrl('usuario_login'));
                    }
        }

        return $this->render('usuario/login.html.twig');
    }

    public function detallesAction(Request $request)
    {
        $session = $request->getSession(); 
        $id=$session->get("ID");
        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
        
        $dtsusuario= $conn->query("SELECT * FROM usuario where id=".$id)->fetchAll();
        return $this->render('usuario/miperfil.html.twig',array('dtsusuario' => $dtsusuario));
        
    }



    public function modificarAction(Request $request)
    {
        
        $session = $request->getSession(); 
        $id=$session->get("ID");
        $nombre=$_POST['nombre'];
        $nvacl= $_POST['nvaclave'];
        $nvacl=md5($nvacl);
        $cr_clave=$_POST['confr_const'];
        $cr_clave=md5($cr_clave);
        $act_clave=$_POST['clave_actual'];
        $usuario=$_POST['usuario'];
        $status_usuario=$_POST['status'];
        $apellido=$_POST['apellido'];

        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();

    if(empty($_POST['nva_clave'])){
        $cadenaP = $conn->query("UPDATE usuario SET nombre='$nombre', apellido='$apellido',status='$status_usuario' WHERE id=$id");
    } 
    if(!empty($nvacl) and (!empty($cr_clave)) and (!empty($act_clave))) {  
            if($nvacl == $cr_clave){
              $cadena = $conn->query("UPDATE usuario SET nombre='$nombre', apellido='$apellido',status='$status_usuario',clave='$nvacl' WHERE id=$id");
            }
        } if($nvacl != $cr_clave){
                // <script>
                //      alert("Las Contraseñas no coinciden");
               
                // </script>
        //return $this->render('usuario/miperfil.html.twig');   
    }
}

public function datosusuariosAction(Request $request)
    {
            $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();

        $session = $request->getSession(); 
        $id=$session->get("ID");
        
        $dtsusuario= $conn->query("SELECT * FROM usuario where id=".$id)->fetchAll();


            $cadena = $conn->query("SELECT * FROM usuario")->fetchAll();
            return $this->render('usuario/detallesusuario.html.twig',array('cadena' => $cadena,'dtsusuario' => $dtsusuario));


    }

    public function registrousuarioAction(Request $request)
    {

        $usuario = ($_POST['usuario']);
        $nombre = ($_POST['nombre']);
        $apellido = ($_POST['apellido']);
        $comentarios = ($_POST['comentarios']);
        $clave = ($_POST['contraseña']);
        $status = ($_POST['status']);
        $tipo = ($_POST['tipo']);

        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
        $em = $this->getDoctrine()->getManager();
                    $queryc = $em->createQuery(
                    'SELECT p
                    FROM GestionBundle:Usuario p   
                    WHERE p.nombreUsuario = :price '
                    )->setParameter('price', $usuario);
                     $query2 = $queryc->getResult();

                     foreach($query2 as $entity){
                        $existe= $entity->getNombreUsuario();
                     }

                    //$localidad['datosusuarios']  = $existe;
                      //  $dtusuario[] = $localidad;
                     $dtsusuario = array();
                if(count($query2)==0){

                    $fecha_creacion=strftime( "%Y-%m-%d", time() );
                    $clave=md5($clave);

                        $cadena = new Usuario();
                        $cadena->setClave($clave);
                        $cadena->setNombreUsuario($usuario);
                        $cadena->setNombre($nombre);
                        $cadena->setApellido($apellido);
                        $cadena->setStatus($status);
                        $cadena->setFechaUltimoIngreso($fecha_creacion);
                        $cadena->setFechaCreacion($fecha_creacion);
                        $cadena->setTipo($tipo);
                        $cadena->setComentario($comentarios);
                        
                        $em=$this->getDoctrine()->getManager();
                        $em->persist($cadena);        
                        $em->flush();

                        $localidad['datosusuarios']  = "E";
                        $dtsusuario[] = $localidad;
                        
                    }else{
                        $localidad['datosusuarios']  = "N";
                        $dtsusuario[] = $localidad;
                        
                         
                    }
                    return new JsonResponse($dtsusuario);
                    
                }
        public function eliminarusuarioAction(Request $request)
        {   
            $idusuario = ($_POST['idusuario']);
            $manager = $this->getDoctrine()->getManager();
            $conn = $manager->getConnection();
            $datosequipos= $conn->query("DELETE FROM usuario WHERE id= $idusuario"); 
        }

        public function modificarusuarioAction(Request $request)
        {   
            $id=$_POST['id'];
            $usuario = ($_POST['usuario']);
            $nombre = ($_POST['nombre']);
            $apellido = ($_POST['apellido']);
            $comentarios = ($_POST['comentarios']);
            $clave = ($_POST['clave']);
            $status = ($_POST['status']);
            $tipo = ($_POST['tipo']);
            $manager = $this->getDoctrine()->getManager();
            $conn = $manager->getConnection();
            
            $clave=md5($clave);
            $act= $conn->query("UPDATE usuario SET tipo='$tipo',nombre='$nombre', apellido='$apellido',clave='$clave', status='$status'where id =".$id);
        }



 public function logoutAction(Request $request){ 
        $this->get('session')->getFlashBag()->add('edit','GRACIAS POR USAR EL SISTEMA');                    
        $session=$request->getSession();
        $session->clear();
        return $this->redirect($this->generateUrl('usuario_login'));

    }

}

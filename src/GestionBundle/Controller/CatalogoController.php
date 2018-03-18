<?php

namespace GestionBundle\Controller;
use GestionBundle\Entity\Catalogo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class CatalogoController extends Controller
{

	public function detallescatalogoAction(Request $request)
	{
    $session = $request->getSession(); 
      if(!$session->get("usuarionombre")){
          $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
          return $this->redirect($this->generateUrl('usuario_login'));

      }
    $session = $request->getSession(); 
    $id=$session->get("ID");
		$manager = $this->getDoctrine()->getManager();
    $conn = $manager->getConnection();
		$dtscatalogo= $conn->query("SELECT * FROM catalogo")->fetchAll();  
		return $this->render('equipos/catalogo.html.twig',array('dtscatalogo' => $dtscatalogo));
	}

	public function registrocatalogoAction(Request $request)
	{
    $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }
	  $clave=$_POST['clave'];
    $categoria=$_POST['categoria'];
    $precio=$_POST['precio'];
    $equipo=$_POST['equipo'];
    $status=$_POST['status'];
		$manager = $this->getDoctrine()->getManager();
   	$conn = $manager->getConnection();
    $dtscatalogo= $conn->query("SELECT clave from catalogo WHERE clave='$clave'")->fetchAll();
    if (count($dtscatalogo)== 0){
      	    $cadena = new Catalogo();
            $cadena->setClave($clave);
            $cadena->setCategoria($categoria);
            $cadena->setPrecio($precio);
            $cadena->setEquipo($equipo);
            $cadena->setStatus($status);
            $em=$this->getDoctrine()->getManager();
            $em->persist($cadena);        
            $em->flush();
          }
            return new JsonResponse($dtscatalogo); 
	   }

  public function modificarAction(Request $request)
  {
    $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }
    $clave=$_POST['clave'];
    $categoria=$_POST['categoria'];
    $precio=$_POST['precio'];
    $equipo=$_POST['equipo'];
    $status=$_POST['status'];

    $manager = $this->getDoctrine()->getManager();
    $conn = $manager->getConnection();
    $cadenaP = $conn->query("UPDATE catalogo SET clave='$clave', categoria='$categoria',precio=$precio,equipo='$equipo',status='$status' WHERE clave='$clave'"); 


  }

  public function eliminarAction(Request $request)
  {
    $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }
    $clave = ($_POST['clave']);
    $manager = $this->getDoctrine()->getManager();
    $conn = $manager->getConnection();
    $datosequipos= $conn->query("DELETE FROM catalogo WHERE clave= '$clave'"); 
  }
  public function filtrarAction(Request $request)
  {
    $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }
    $clave=($_POST['clave']);
    $categoria=($_POST['categoria']);
    $equipo=($_POST['equipo']);
    $status=($_POST['status']);
    $sql="SELECT * FROM catalogo";
    $con=0;
    if ($equipo<>'')
  {
    $sql= $sql." where equipo like '".$equipo."%'";
    $con=1;
  }

if ($clave<>'')
  {
    if ($con==1){
      $sql= $sql." and clave like '".$clave."%'";
      $con=2;
      
    }else {
    $sql=$sql. " where clave like '".$clave."%'"; 
    $con=3;
    }
    
  }

if ($status<>''){
  if ($con==1 OR $con==2 OR $con==3 ){
    $sql= $sql." and status like '".$status."%'";
      $con=4;
  }else{
    $sql=$sql. " where status like '".$status."%'"; 
    $con=5;
  }
}
if ($categoria<>''){
  if ($con==1 OR $con==2 OR $con==3 OR $con==4 OR $con==5 ){
    $sql= $sql." and categoria like '".$categoria."%'";
  }else{
    $sql=$sql. " where categoria like '".$categoria."%'"; 
  }
}
 
    $manager = $this->getDoctrine()->getManager();
    $conn = $manager->getConnection();
    $dtscatalogo= $conn->query($sql)->fetchAll();
    
    return new JsonResponse($dtscatalogo); 

  }
}

<?php

namespace GestionBundle\Controller;
use GestionBundle\Entity\DetallesDevoluciones;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class DetallesDevolucionesController extends Controller
{

	public function detallesdtAction(Request $request,$pd){
		$manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
        $datos_pedido= $conn->query("SELECT p.pedido,p.folio,p.cliente,p.cuenta,s.status FROM pedidos p,status_entrega s where p.status_pedido=s.id and pedido=$pd")->fetchAll();    
		  return $this->render('pedidos/detallesdevoluciones.html.twig',array('pedido' => $datos_pedido));
	}

	public function consultarfolioAction(Request $request)
    {
    	$folio=$_POST['folio'];
      $pd=$_POST['pedidop'];
      $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));
        }
      $manager = $this->getDoctrine()->getManager();
      $conn = $manager->getConnection();
      $em = $this->getDoctrine()->getManager();
      $dts2= $conn->query("SELECT claveequipo,equipo,cantidad FROM detalles_devoluciones  WHERE foliodevolucion=$folio and pedidosistema=$pd")->fetchAll();
        return new JsonResponse($dts2);
    }


    public function filtrosdevolucionesAction(Request $request)
  	 
  	  {
    	$session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));
        }

      $pedid = $_POST['pedid']; 
      $contar=0;
      $manager = $this->getDoctrine()->getManager();
      $conn = $manager->getConnection();
      $em = $this->getDoctrine()->getManager();

        /*PEDIDOS*/
        $generardatos = array();
        $queryc = $em->createQuery(
        'SELECT p
        FROM  GestionBundle:Pedidos p
        WHERE p.pedido = :price ' 
        )->setParameter('price', $pedid);
        //$cnt = $queryc->getResult();
        $row = $queryc->getResult();

         foreach ($row as $entidad){
            $clave = $entidad->getClave();
            $equipo = $entidad->getEquipo();
            $localidad['clave'] = $clave;
            $localidad['equipo'] = $equipo;
            
            //OBTENER CANTIDAD ENTREGADO
                $devoluciones = $em->createQuery(
                'SELECT p 
                FROM  GestionBundle:DetallesDevoluciones p
                WHERE p.foliodevolucion = :price and p.claveequipo=:clave and p.pedidosistema =:pedido' 
                )->setParameter('clave', $clave)
                ->setParameter('pedido', $pedid)
                ->setParameter('price', 0);
                                                       
                $row2 = $devoluciones->getResult();
                  
                foreach ($row2 as $cantidad){
                     $total_entregado = $cantidad->getCantidad();
                     $localidad['cantidad'] =$total_entregado; 

                // CANTIDAD DEVUELTOS

                 $sumdevueltos = $em->createQuery(
                'SELECT sum(p.cantidad) as cantdevueltos
                FROM  GestionBundle:DetallesDevoluciones p
                WHERE p.pedidosistema = :price and p.foliodevolucion <> :foliodv and p.claveequipo = :clave ' 
                )->setParameter('foliodv', 0)
                ->setParameter('clave', $clave)
                ->setParameter('price', $pedid);
                $row3 = $sumdevueltos->getResult();

                foreach ($row3 as $totaldevuelto){
                     $localidad['devuelto'] = $totaldevuelto["cantdevueltos"];
                     //PENDIENTE
                     $localidad['pendiente']= $localidad['cantidad'] - $localidad['devuelto'];
                   
                    $generardatos[]=$localidad;
                }
              }
            }
       return new JsonResponse($generardatos);
   }
   public function consultafoliodevAction(Request $request)
     {
          $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));
        }

      $pedido = $_POST['pedid']; 
      
      $manager = $this->getDoctrine()->getManager();
      $conn = $manager->getConnection();
      $em = $this->getDoctrine()->getManager();

      $generardatos = array();
            $queryc2 = $em->createQuery(
             'SELECT p
             FROM  GestionBundle:DetallesDevoluciones p
             WHERE p.pedidosistema = :price and p.foliodevolucion <> 0 ' 
             )->setParameter('price', $pedido);
             $row2 = $queryc2->getResult();
                foreach ($row2 as $entidaddev){
                    $fl = $entidaddev->getFolioDevolucion();
                    $fechadev = $entidaddev->getFechaMovimiento();
                    $localidad['folio'] = $fl;
                    $localidad['fecha_devolucion'] = $fechadev;
                    $generardatos[]=$localidad;
         }
	    return new JsonResponse($generardatos);
	}
  public function eliminardevAction(Request $request)
  {
    $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }

     $folio=$_POST['folio'];
     $manager = $this->getDoctrine()->getManager();
     $conn = $manager->getConnection();
     $sql= $conn->query("DELETE from detalles_devoluciones where foliodevolucion=$folio");
  }
  public function buscarfolioAction(Request $request)
  {
        $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }
      $folio = ($_POST['folio']);
      $manager = $this->getDoctrine()->getManager();
      $conn = $manager->getConnection();
      $em = $this->getDoctrine()->getManager();

      $generardatos = array();
      $queryc2 = $em->createQuery(
       'SELECT p
       FROM  GestionBundle:DetallesDevoluciones p
       WHERE p.foliodevolucion = :price ' 
       )->setParameter('price', $folio);
       $row2 = $queryc2->getResult();
        foreach ($row2 as $entidaddev){
          $id = $entidaddev->getId();
          $localidad['id'] = $id;
          $generardatos[]=$localidad;
        }
        $entrega='NO';
        if (count($row2)> 0){
          $entrega='Este Folio ya Existe';
        }
        


          
          return new JsonResponse($entrega);
        

  }
  public function registrodevolucionesAction(Request $request)
    {
        $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }
    $pedido = ($_POST['pedido']);
    $fecha_mov = ($_POST['fecha_mov']);
    $folio_padre = ($_POST['folio_padre']);
    $folio_entrega = ($_POST['folio_entrega']);
    $clave = ($_POST['clave']);
    $equipo = ($_POST['equipo']);
    $cantidad = ($_POST['cantidad']);

     
        
          $cadena = new DetallesDevoluciones();
              $cadena->setPedidoSistema($pedido);
              $cadena->setFechaMovimiento($fecha_mov);
              $cadena->setFolioPadre($folio_padre);
              $cadena->setFolioDevolucion($folio_entrega);
              $cadena->setCantidad($cantidad);
              $cadena->setEquipo($equipo);
              $cadena->setClaveequipo($clave);
              $em=$this->getDoctrine()->getManager();
              $em->persist($cadena);        
              $em->flush();
              
       



     
  }
       public function actstatusdevAction(Request $request)
        {
             $session = $request->getSession(); 
            if(!$session->get("usuarionombre")){
                $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
                return $this->redirect($this->generateUrl('usuario_login'));
        }
        $pedido=$_POST['pedido'];
        $estado=$_POST['estado'];
        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();

       $identrega= $conn->query("SELECT status FROM status_entrega where id=$estado ")->fetchAll();
       //$id= $identrega[0]['id'];

        $conn->query("UPDATE pedidos_entregados SET statuspedido=$estado where pedido=$pedido");
        $conn->query("UPDATE pedidos SET status_pedido=$estado where pedido=$pedido");
         
          return new JsonResponse($identrega); 
     }

     public function filtrosdevAction(Request $request)
        {
            $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }  
           //$sql="SELECT foliopadre,foliodevolucion FROM detalles_devoluciones";
           //$sql2="SELECT cliente,cuenta,fecha,devolucion FROM pedidos"
           $sql="SELECT p.cliente,p.cuenta,p.fecha,p.devolucion,a.foliopadre,a.foliodevolucion FROM pedidos p,detalles_devoluciones a";
           //SELECT p.cliente,p.cuenta,p.fecha,p.devolucion,p.folio,a.foliodevolucion FROM pedidos p,detalles_devoluciones a WHERE a.pedidosistema=29 and p.pedido=29
           $con=0;
           $pedido=$_POST['pedido'];
           $folio=$_POST['folio'];
           $cliente=$_POST['cliente'];
           $cuenta=$_POST['cuenta'];
           $foliodev=$_POST['foliodev'];
           $desde=$_POST['desde'];
           $hasta=$_POST['hasta'];

           if ($pedido<>'')
        {
          $sql= $sql." where p.pedido like '".$pedido."%' and a.pedidosistema like '".$pedido."%'";
          $con=1;
        }
        if ($folio<>'')
          {
            if ($con==1){
              $sql= $sql." and a.foliopadre like '".$folio."%' and p.folio like '".$folio."%'";
              $con=2;
              
            }else {
            $sql=$sql. " where a.foliopadre like '".$folio."%' and p.folio like '".$folio."%'";
            $con=3;
            }
              }
          if ($cliente<>''){
  
          if ($con==1 OR $con==2 OR $con==3 ){
            $sql= $sql." and cliente like '".$cliente."%'";
            $con=4;
          }else{
          $sql=$sql. " where cliente like '".$cliente."%'"; 
          $con=5;
          }
        }
        if ($cuenta<>''){
          if ($con==1 OR $con==2 OR $con==3 OR $con==4 OR $con==5 ){
            $sql= $sql." and cuenta like '".$cuenta."%'";
            $con=6;
          }else{
            $sql=$sql. " where cuenta like '".$cuenta."%'"; 
            $con=7;
          }
        }
        if ($foliodev<>''){
          if ($con==1 OR $con==2 OR $con==3 OR $con==4 OR $con==5 OR $con==6 OR $con==7 ){
            $sql= $sql." and folio like '".$foliodev."%'";
            $con=8;
          }else{
            $sql=$sql. " where folio like '".$foliodev."%'"; 
            $con=9;
          }
        }
         if ($desde<>'' and $hasta<>''){
          if ($con==1 OR $con==2 OR $con==3 OR $con==4 OR $con==5 OR $con==6 OR $con==7 OR $con==8 OR $con==9 ){
            $sql= $sql." and fecha_devolucion >= '".$desde."' and fecha_devolucion <= '".$hasta."'";
            $con=10;
          }else{
            $sql=$sql. " where fecha_devolucion >= '".$desde."' and fecha_devolucion <= '".$hasta."'"; 
            $con=11;
          }
        }
        if ($desde <> '' and $hasta ==''){ 
          if ($con==1 OR $con==2 OR $con==3 OR $con==4 OR $con==5 OR $con==6 OR $con==7 OR $con==8 OR $con==9 OR $con==11 OR $con==12 ){
            $sql= $sql." and fecha_devolucion = '".$desde."'";
            $con=12;
          }else{
            $sql=$sql. " where fecha_devolucion = '".$desde."'"; 
            $con=13;
          }
        }
         $manager = $this->getDoctrine()->getManager();
         $conn = $manager->getConnection();
         $dts= $conn->query($sql)->fetchAll();
         return new JsonResponse($dts); 
      }
}

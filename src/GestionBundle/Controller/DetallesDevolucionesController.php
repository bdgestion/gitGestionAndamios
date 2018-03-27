<?php

namespace GestionBundle\Controller;
use GestionBundle\Entity\DetallesDevoluciones;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Console\Helper\ProgressBar;


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
          $cliente=$_POST['cliente'];
           $cuenta=$_POST['cuenta'];
           $foliodev=$_POST['foliodev'];
           $desde=$_POST['desde'];
           $hasta=$_POST['hasta'];
         $sql="SELECT a.id,a.pedidosistema,p.cliente,p.obra,a.foliodevolucion,a.fechamovimiento,a.equipo,a.cantidad FROM ultpedido p, detalles_devoluciones a WHERE p.pedido=a.pedidosistema";
           $con=0;
          

        //    if ($pedido<>'')
        // {
        //   $sql= $sql." where a.pedidosistema like '".$pedido."%' and a.pedidosistema like '".$pedido."%'";
        //   $con=1;
        // }
        if ($cliente<>''){
          $sql=$sql. " and p.cliente like '".$cliente."%'"; 
          $con=1;
          }
        
        if ($cuenta<>''){
            $sql= $sql." and p.obra like '".$cuenta."%'";
        }
        if ($foliodev<>''){
            $sql= $sql." and a.foliodevolucion like '".$foliodev."%'";
        }
         if ($desde<>'' and $hasta<>''){
            $sql= $sql." and a.fechamovimiento >= '".$desde."' and a.fechamovimiento <= '".$hasta."'";
        }
        if ($desde <> '' and $hasta ==''){ 
            $sql= $sql." and a.fechamovimiento = '".$desde."'";
        }
        
         $manager = $this->getDoctrine()->getManager();
         $conn = $manager->getConnection();
         $dts= $conn->query($sql)->fetchAll();
         return new JsonResponse($dts); 
      }


     public function imprimirdevolucionAction($pedido,$folio,$desde,$hasta,Request $request)
     { 
        $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }
        $desde= str_replace("-", "/", $desde);
        $hasta= str_replace("-", "/", $hasta);
        $con=0;
        $sql="SELECT d.pedidosistema,d.foliodevolucion,d.fechamovimiento,d.cantidad,d.equipo FROM detalles_devoluciones d";

        if ($desde <>'0' and $hasta <>'0'){
            $sql= $sql." where fechamovimiento >= '".$desde."' and fechamovimiento <= '".$hasta."'";
            $con=1;
        }

         if ($desde <>'0' and $hasta =='0'){ 
          if($con==1){
            $sql= $sql." and fechamovimiento = '".$desde."'";
          }else{
            $sql= $sql." where fechamovimiento = '".$desde."'";
          }
          $con=2;
        }

        if ($folio <>'0'){
          if($con==1 or $con==2){
            $sql= $sql." and foliodevolucion = '".$folio."'";
          }else{
            $sql= $sql." where foliodevolucion = '".$folio."'";
          }
          $con=3;
        }
        if ($pedido <>'xxx'){
          if($con==1 or $con==2 or $con==3){
            $sql= $sql." and pedidosistema = '".$pedido."'";
          }else{
            $sql= $sql." where pedidosistema = '".$pedido."'";
          }
        }

        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
          
        $peds= $conn->query($sql);
       
        $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetAuthor('JJC');
        $pdf->SetTitle(('Reporte_Pedidos'));
        $pdf->SetSubject('Our Code World Subject');
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('Helvetica', '', 10); 
        $pdf->AddPage();
        
    $content = ''; 
     
    $content .= ' 

         <div class=""> 
          <h3 style="color:#00BFFF">Fecha de Impresión:'.date("d-m-Y").' </h3>
         </div>
            <div class="col-md-12"> 
                <h1 style="text-align:center;">REPORTE DE DEVOLUCIONES</h1> 
            
                    <table border="1" cellpadding="5"> 
                      <thead> 
                        <tr align="center"> 
                         <th bgcolor="#00BFFF" style="font-size:100%;">PEDIDO</th>
                         <th bgcolor="#00BFFF" style="font-size:100%;">FOLIO</th>
                         <th bgcolor="#00BFFF" style="font-size:100%;">Fecha</th>
                         <th bgcolor="#00BFFF" style="font-size:100%;">CANTIDAD</th>
                         <th bgcolor="#00BFFF" style="font-size:100%;">EQUIPO</th>
                        </tr> 
                      </thead> 
                      '; 

                      while($row = $peds->fetch()) {

                      $content .= ' 
                              <tr> 
                          <td style= "text-align:center;">'.$row['pedidosistema'].'</td> 
                          <td style= "text-align:center;">'.$row['foliodevolucion'].'</td> 
                          <td style= "text-align:center;">'.$row['fechamovimiento'].'</td> 
                          <td style= "text-align:center;">'.$row['cantidad'].'</td>
                          <td style= "text-align:center;">'.$row['equipo'].'</td> 
                      </tr> 
                      '; 
                      } 

                      $content .= '</table>'; 
     
    $content .= ' 
        <div class="row padding"> 
            <div class="col-md-12" style="text-align:center;"> 
                 
                </div> 
                </div> 
         
    '; 
     
       $pdf->writeHTML($content, true, 0, true, 0); 
       $pdf->lastPage(); 
       $pdf->output('Reporte_Devoluciones.pdf', 'I');

     }
}

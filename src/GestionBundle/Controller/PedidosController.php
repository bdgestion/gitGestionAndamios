<?php

namespace GestionBundle\Controller;

use GestionBundle\Entity\Pedidos;
use GestionBundle\Entity\Factura;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * Pedido controller.
 *
 */
class PedidosController extends Controller
{
    /**
     * Lists all pedido entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pedidos = $em->getRepository('GestionBundle:Pedidos')->findAll();

        return $this->render('pedidos/index.html.twig', array(
            'pedidos' => $pedidos,
        ));
    }
    /**
     * Finds and displays a pedido entity.
     *
     */
    public function showAction(Pedidos $pedido)
    {
        return $this->render('pedidos/show.html.twig', array(
            'pedido' => $pedido,
        ));
    }
    public function homeAction(Request $request)
    {
        $fecha=date("d/m/Y");
        $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));
        }
    $manager = $this->getDoctrine()->getManager();
    $conn = $manager->getConnection();
    $eliminar= $conn->query("DELETE FROM home_temp");    
    $factconsl= $conn->query("SELECT DISTINCT d.pedido,d.id,d.fechapago,d.montopago,f.formas,d.foliofactura FROM detalles_pago d,formas_pagos f where d.formapago=f.id AND foliofactura='Pendiente'")->fetchAll();    
    $fecha=date("d/m/Y");  
    $pdconsulta= $conn->query(" SELECT DISTINCT p.pedido,p.folio,p.devolucion,p.cliente,p.status_pedido,m.statussaldo,p.fecha,m.saldorestante FROM pedidos p ,montospedidos m WHERE m.id=p.idmontopedido AND p.devolucion >='$fecha' AND p.status_pedido=1")->fetchAll();
    
    for ($i=0;$i<count($pdconsulta); $i++)
      {
        $ped=$pdconsulta[$i]['pedido'];
        $folio=$pdconsulta[$i]['folio'];
        $dev=$pdconsulta[$i]['devolucion'];
        $cliente=$pdconsulta[$i]['cliente'];
        $stpd=$pdconsulta[$i]['status_pedido'];
        $stpag=$pdconsulta[$i]['statussaldo'];
        $stfecha=$pdconsulta[$i]['fecha'];
        $saldo1=$pdconsulta[$i]['saldorestante'];
        if($stpd<>3){
          $insertar = $conn->query("INSERT INTO home_temp (pedido,folio,fecha_pedido,fecha_dev,cliente,status_pedido,status_pago,saldo) VALUES ($ped,'$folio','$stfecha','$dev','$cliente','$stpd','$stpag',$saldo1)");   
        }
        
        
      }

   $pdconsulta2= $conn->query("SELECT DISTINCT p.pedido,p.folio,p.devolucion,p.cliente,p.status_pedido,m.statussaldo,p.fecha,m.saldorestante FROM pedidos p ,montospedidos m, status_saldos s WHERE p.idmontopedido= m.id AND p.devolucion >='$fecha' AND m.statussaldo=1")->fetchAll();

    
    //$idstatus=array();

    for ($x=0;$x<count($pdconsulta2); $x++)
      {
        $ped2=$pdconsulta2[$x]['pedido'];
        $folio2=$pdconsulta2[$x]['folio'];
        $dev2=$pdconsulta2[$x]['devolucion'];
        $cliente2=$pdconsulta2[$x]['cliente'];
        $stpdido2=$pdconsulta2[$x]['status_pedido'];
        $stpag2=$pdconsulta2[$x]['statussaldo'];
        $stfecha2=$pdconsulta2[$x]['fecha'];
        $saldo=$pdconsulta2[$x]['saldorestante'];
        $idstatus= $conn->query("SELECT * FROM home_temp  where pedido=$ped2 ")->fetchAll();
       if(empty($idstatus)) {
            $insertar2 = $conn->query("INSERT  INTO home_temp (pedido,folio,fecha_pedido,fecha_dev,cliente,status_pedido,status_pago,saldo) VALUES ($ped2,'$folio2','$stfecha2','$dev2','$cliente2','$stpdido2','$stpag2',$saldo)");     

       }

      }

      $pedidosconsl= $conn->query(" SELECT h.pedido,h.folio,h.fecha_pedido,h.fecha_dev,h.cliente, s.status,l.statussaldos,h.saldo FROM home_temp h, status_entrega s, status_saldos l WHERE h.status_pedido=s.id AND h.status_pago=l.id ORDER BY h.pedido ASC")->fetchAll();
  

    return $this->render('pedidos/home.html.twig',array('pedidosconsl' => $pedidosconsl,'factconsl' => $factconsl));
    }
    public function detallescotizacionesAction(Request $request,$cot)
    {
     $session = $request->getSession(); 
      if(!$session->get("usuarionombre")){
          $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
          return $this->redirect($this->generateUrl('usuario_login'));
      }

       $manager = $this->getDoctrine()->getManager();
       $conn = $manager->getConnection();
       $cots = $conn->query("SELECT p.cotizacion,p.pedido, p.devolucion,p.cliente,p.obra,p.fecha,p.status,p.cantidad,p.clave,p.equipo,p.dias,p.PU,p.importe,p.direccion_entrega,p.comentarios,p.descuento,p.impuesto,p.total,p.subtotal,p.subtotal2,p.servicioentrega,p.id FROM cotizaciones p  where p.cotizacion=".$cot)->fetchAll(); 
        return $this->render('pedidos/detallespedido.html.twig',array('cotizaciones' => $cots,'cot' => $cot));


    }
    public function detallespedidoAction(Request $request,$id)
      {
        $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));
        }
            $fechadevol='';
            $idpd=0;
            if($id<>0){ 
            $manager = $this->getDoctrine()->getManager();
            $conn = $manager->getConnection();
            $datosequipos = $conn->query("SELECT p.pedido, p.folio,p.devolucion,p.cliente,p.cuenta,p.fecha,s.status,p.cant,p.clave,p.equipo,p.dias,p.PU,p.importe,p.direccion_entrega,p.comentarios,p.descuento,p.impuesto,p.total,p.subtotal,p.subtotal2,p.servicioentrega,p.id FROM pedidos p, status_entrega s where p.status_pedido=s.id AND p.pedido=".$id)->fetchAll(); 

                 // $em = $this->getDoctrine()->getManager();
                 //    $queryc = $em->createQuery(
                 //    'SELECT p
                 //    FROM GestionBundle:Pedidos p
                 //    WHERE p.pedido = :price '
                 //    )->setParameter('price', $id);
                 //     $idq = $queryc->getResult();

                 //     foreach($idq as $entity){
                 //        $idpd= $entity->getId();
                 //     }

                 //    $em = $this->getDoctrine()->getManager();
                 //    $queryc = $em->createQuery(
                 //    'SELECT p
                 //    FROM GestionBundle:Pedidos p   
                 //    WHERE p.pedido = :price and p.statusPedido = :status '
                 //    )->setParameter('price', $id)
                 //     ->setParameter('status', 'Pendiente de Devolucion');
                 //     $query2 = $queryc->getResult();

                 //     foreach($query2 as $entity){
                 //        $fechadevol= $entity->getDevolucion();
                 //     }
    return $this->render('pedidos/detallespedido.html.twig',array('datosequipos' => $datosequipos,'id' => $id,'cot' => '00'));//,'query2' => $query2,));
    }if($id==0){ 
        $cont=0;
        $pedido=0;
        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
        $pd= $conn->query("SELECT pedido FROM pedidos order by pedido desc limit 1")->fetchAll();
        if (count($pd)== 0){
            $pedido=1;
        }else{
            $pedido= ($pd[0]['pedido'])+1;     
        }
       // $insertar = $conn->query("INSERT INTO pedidos (pedido) VALUES ($pedido)");    
        //var_dump($pedido);
        $datosequipos=array();
        $query2=array();
        $dts=array();
        return $this->render('pedidos/detallespedido.html.twig',array('datosequipos' => $datosequipos,'query2' => $query2,'dts' => $dts,'id' => $id,'pd' => $pedido,'cot'=>'00'));
        }
    }  
    public function modificarpedidoAction(Request $request){
        $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));
        }
        $cot = ($_POST['cot']);
        $cantidad = ($_POST['cantidad']);
        $equipo_2 = ($_POST['equipo_2']);
        $clv = ($_POST['clv']);
        $PU_1 = ($_POST['PU_1']);
        $importe = ($_POST['importe']);
        $cliente = ($_POST['cliente']);
        $cuenta = ($_POST['cuenta']);
        $fecha_1 = ($_POST['fecha_1']);
        $fecha_2 = ($_POST['fecha_2']);
        $status = ($_POST['status']);
        $pedido_1 = ($_POST['pedido_1']);
        $folio_1 = ($_POST['folio_1']);
        $subtotal_1 = ($_POST['subtotal_1']);
        $subtotal_2 = ($_POST['subtotal_2']);
        $descuento = ($_POST['descuento_1']);
        $dias = ($_POST['dias_1']);
        $impuesto = ($_POST['impuesto']);
        $total = ($_POST['total']);
        $comentario_1 = ($_POST['comentario_1']);
        $direccion_entrega = ($_POST['direccion_entrega']);
        $sv = ($_POST['sv']);

        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
        if($cot<>0){
          $datosequiposinsr = $conn->query("UPDATE cotizaciones SET cliente='$cliente',obra='$cuenta',fecha='$fecha_1',devolucion='$fecha_2',cantidad=$cantidad,clave='$clv',equipo='$equipo_2',dias=$dias,PU=$PU_1,importe=$importe,direccion_entrega='$direccion_entrega',comentarios='$comentario_1',descuento=$descuento,impuesto=$impuesto,total=$total,subtotal=$subtotal_1,subtotal2=$subtotal_2,servicioentrega=$sv WHERE cotizacion=$cot and clave='$clv'"); 
        }else{
        $idstatus= $conn->query("SELECT id FROM status_entrega  where status='En Renta' ")->fetchAll();
        $idst= $idstatus[0]['id'];

        $idact= $conn->query("SELECT id FROM pedidos  where clave='$clv' and pedido=$pedido_1")->fetchAll();
        if (count($idact)== 0){
          $insertar = $conn->query("INSERT INTO pedidos (pedido,folio,cliente,cuenta,fecha,devolucion,status_pedido,cant,clave,equipo,dias,PU,importe,direccion_entrega,comentarios,descuento,impuesto,total,subtotal,subtotal2,servicioentrega) VALUES ($pedido_1,'$folio_1','$cliente','$cuenta','$fecha_1','$fecha_2',$idst,$cantidad,'$clv','$equipo_2',$dias,$PU_1,$importe,'$direccion_entrega','$comentario_1',$descuento,$impuesto,$total,$subtotal_1,$subtotal_2,$sv)");    
          }else{
          $datosequiposinsr = $conn->query("UPDATE pedidos SET pedido=$pedido_1,folio='$folio_1',cliente='$cliente',cuenta='$cuenta',fecha='$fecha_1',devolucion='$fecha_2',status_pedido=$idst,cant=$cantidad,clave='$clv',equipo='$equipo_2',dias=$dias,PU=$PU_1,importe=$importe,direccion_entrega='$direccion_entrega',comentarios='$comentario_1',descuento=$descuento,impuesto=$impuesto,total=$total,subtotal=$subtotal_1,subtotal2=$subtotal_2,servicioentrega=$sv WHERE pedido=$pedido_1 and clave='$clv'"); 
          }
          $saldors= $conn->query("SELECT saldorestante FROM montospedidos  where pedido=$pedido_1")->fetchAll();
          $totalrest= $saldors[0]['saldorestante'];
          $tsald=($total - $totalrest);
          $t= $tsald + $totalrest;
          $cadenaact = $conn->query("UPDATE montospedidos SET montopedido=$total,statussaldo=1,saldorestante=$t WHERE pedido=$pedido_1"); 
           }
        
    }

    public function buscarclaveAction(Request $request)
    {
        $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));
        }
            $generardatos = array();
            $consultaBusqueda = $_POST['valorBusqueda'];
            $manager = $this->getDoctrine()->getManager();
            $conn = $manager->getConnection();
                    $em = $this->getDoctrine()->getManager();
                    $queryc = $em->createQuery(
                    'SELECT p
                    FROM GestionBundle:Catalogo p
                    WHERE p.clave = :consultaBusqueda'
                    )->setParameter('consultaBusqueda', $consultaBusqueda)
                     ->setMaxResults(1);
                    $query2 = $queryc->getResult();
                    if(count($query2)>0){
                    foreach($query2 as $entity){
                            $equipo2= $entity->getEquipo();
                            $precio= $entity->getPrecio();
                            $status= $entity->getStatus();
                            $localidad['equipo2']  = $equipo2;
                            $localidad['precio']  = $precio;
                            $localidad['status']  = $status;
                            $generardatos[] = $localidad;
                     }
                }
                     if(count($query2)==0){
                        $localidad['equipo2']  = 'N';
                        $generardatos[] = $localidad;

                     }
                     return new JsonResponse($generardatos); 
    }

  public function buscarequiposAction(Request $request)
    {
        $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));
        }
            $generardatos = array();
            $consultaBusqueda = $_POST['valorBusqueda'];
            $manager = $this->getDoctrine()->getManager();
            $conn = $manager->getConnection();
            $em = $this->getDoctrine()->getManager();
            $queryc = $em->createQuery(
                    'SELECT p
                    FROM GestionBundle:Catalogo p
                    WHERE p.equipo = :consultaBusqueda'
                    )->setParameter('consultaBusqueda', $consultaBusqueda)
                     ->setMaxResults(1);
                    $query2 = $queryc->getResult();
                    if(count($query2)>0){
                    foreach($query2 as $entity){
                            $clave= $entity->getClave();
                            $precio= $entity->getPrecio();
                            $status= $entity->getStatus();
                            $localidad['clave']  = $clave;
                            $localidad['precio'] = $precio;
                            $localidad['status'] = $status;
                            $generardatos[] = $localidad;
                     }
                }  if(count($query2)==0){
                        $localidad['clave']  = 'N';
                        $generardatos[] = $localidad;

                     }
               
                    return new JsonResponse($generardatos); 
    }

    public function registrofolioAction(Request $request)
    {
        $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));
        }
        $folio=$_POST['folio'];
        $fecha_1=$_POST['fechaactfl'];
        $pedido=$_POST['pedido'];
        $status_entrega=$_POST['status_entrega'];
        $clave=$_POST['clave'];
        $equipo=$_POST['equipo'];
        $cantidad=$_POST['cantidad'];
        $total=$_POST['total'];
        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
        // $fecha=date("m/d/Y");
         $em = $this->getDoctrine()->getManager();
         // $queryc = $em->createQuery(
         //    'SELECT p
         //    FROM GestionBundle:Pedidos p
         //    WHERE p.folio = :consultaBusqueda'
         //    )->setParameter('consultaBusqueda', $folio)
         //     ->setMaxResults(1);
         //    $query2 = $queryc->getResult();
            // if(count($query2)==0){
            //     if ($fecha_1==$fecha){
                
            //     }else{
            //     //$cadenafolio = $conn->query("UPDATE pedidos SET folio='$folio', status_pedido=1 WHERE pedido=$pedido");
            //     }
            // }

            $cadenaP = $conn->query("UPDATE pedidos SET folio='$folio' WHERE pedido=$pedido"); 
         $identrega= $conn->query("SELECT id FROM status_entrega where status='$status_entrega' ")->fetchAll();
          $id= $identrega[0]['id'];

          $idpden= $conn->query("SELECT * FROM pedidos_entregados where pedido=$pedido ")->fetchAll();
        if (count($idpden)== 0){
             $cadena2 =$conn->query("INSERT INTO pedidos_entregados (foliofisico,fechafolio,statuspedido,pedido) VALUES ($folio,'$fecha_1',$id,$pedido)");
        }
            
             $cadena3 =$conn->query("INSERT INTO detalles_devoluciones (pedidosistema,foliopadre,foliodevolucion,fechamovimiento,cantidad,claveequipo,equipo) VALUES ($pedido,$folio,0,'$fecha_1',$cantidad,'$clave','$equipo')");
         if($total<>0){
            $status_saldo=1;
         }else{
            $status_saldo=2;
         }
    }

    // public function actpagoAction(Request $request)
    // {
    //     $session = $request->getSession(); 
    //     if(!$session->get("usuarionombre")){
    //         $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
    //         return $this->redirect($this->generateUrl('usuario_login'));

    //     }
    //     $pedido=$_POST['pedido'];
    //     $total=$_POST['total'];
    //     $statusf=$_POST['statusf'];
    //     $cr_ped=$_POST['cr_ped'];
    //      $manager = $this->getDoctrine()->getManager();
    //     $conn = $manager->getConnection();
    //     //$cadena = $conn->query("UPDATE factura SET saldo=$total,status_financiero='$statusf',cargo_pedido=$cr_ped WHERE pedido=$pedido");
    //      $cadena2 = $conn->query("UPDATE pedidos SET montoact=$total,total=$cr_ped WHERE pedido=$pedido");
    //     if($statusf=='Sin Adeudo'){
    //         $cadena = $conn->query("UPDATE pedidos SET status_pago='Sin Adeudo',montoact=$total,total=$cr_ped WHERE pedido=$pedido");
    //     }

    // }


   

 public function consultaspdsAction(Request $request)
      {
        $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }
        return $this->render('pedidos/consultaspedidos.html.twig');
      }
      public function configuracionAction(Request $request)
      {
        $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }
        return $this->render('usuario/configuracion.html.twig');
      }
      
      public function consultdevdetallesAction(Request $request)
      {
        $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }
        return $this->render('pedidos/consultasdevoluciones.html.twig');
      }
      

      // public function rptpedidoAction(Request $request)
      // {
      //   $session = $request->getSession(); 
      //   if(!$session->get("usuarionombre")){
      //       $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
      //       return $this->redirect($this->generateUrl('usuario_login'));

      //   }
      //   return $this->render('reportes/reportespedidos.html.twig');
      // }

public function llenardtAction(Request $request)
  {
    $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('GestionBundle:Clientes')->findAll();
                foreach($entities as $entity){
                            $clave= $entity->getRazonSocial();                            
                            $localidad['razonsocial']  = $clave;                            
                            $generardatos[] = $localidad;
                     }
                    return new JsonResponse($generardatos); 
  }

  public function llenarctaAction(Request $request)
  {
    $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }
        $cliente=$_POST['clienterz'];
        $restr='';
        $generardatos = array();
        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
        $em = $this->getDoctrine()->getManager();
        $queryc = $em->createQuery(
        'SELECT p
        FROM GestionBundle:Clientes p
        WHERE p.razonSocial = :consultaBusqueda'
        )->setParameter('consultaBusqueda', $cliente)
        ->setMaxResults(1);
        $query2 = $queryc->getResult();
        $clienteid =  0;
        foreach($query2 as $entity){
            $clienteid= $entity->getCliente();
                      }

       
        $queryc = $em->createQuery(
        'SELECT p
        FROM GestionBundle:CuentasCliente p
        WHERE p.cliente = :consultaBusqueda'
        )->setParameter('consultaBusqueda', $clienteid);
        $query2 = $queryc->getResult();
        $generardatos = array();
        foreach($query2 as $entity){
            
            $cuenta= $entity->getCuentaId();
            $localidad['cuenta_Id']  = $cuenta;
            $localidad['restringir']  = $restr;
            $generardatos[] = $localidad;
          }

       
        return new JsonResponse($generardatos);
  }
  public function eliminarCotAction(Request $request)
  {
    $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));
        }
        $cotizacion = ($_POST['cotizaciones']);
        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
        $eliminar= $conn->query("DELETE FROM cotizaciones where cotizacion=$cotizacion");    
        return new JsonResponse('Cotización Eliminada');

  }
   public function registrarpedidoAction(Request $request)
  {
    $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }
    $cantidad = ($_POST['cantidad']);
    $dias = ($_POST['dias_1']);
    $equipo_2 = ($_POST['equipo_2']);
    $clv = ($_POST['clv']);
    $PU_1 = ($_POST['PU_1']);
    $importe = ($_POST['importe']);
    $cliente = ($_POST['cliente']);
    $cuenta = ($_POST['cuenta']);
    $fecha_1 = ($_POST['fecha_1']);
    $fecha_2 = ($_POST['fecha_2']);
    $status = ($_POST['status']);
    $pedido_1 = ($_POST['pedido_1']);
    $folio_1 = ($_POST['folio_1']);
    $subtotal_1 = ($_POST['subtotal_1']);
    $subtotal_2 = ($_POST['subtotal_2']);
    $descuento = ($_POST['descuento_1']);
    $impuesto = ($_POST['impuesto']);
    $total = ($_POST['total']);
    $comentario_1 = ($_POST['comentario_1']);
    $f = ($_POST['f']);
    $radio = ($_POST['radio']);
    $direccion_entrega = ($_POST['direccion_entrega']);
    $sventrega = ($_POST['sventr']);
    $cotz = ($_POST['cot']);

    $manager = $this->getDoctrine()->getManager();
    $conn = $manager->getConnection();

    if($radio=='Pedido'){
        if($cotz<>''){
          $idct= $conn->query("SELECT id FROM cotizaciones where cotizacion=$cotz ")->fetchAll();
          $idfiltro= $idct[0]['id'];
          if (count($idfiltro)<> 0){
            $conn->query("UPDATE cotizaciones SET status='En Renta',pedido=$pedido_1 where cotizacion=$cotz");
          }     
        }
        $idsta= $conn->query("SELECT id FROM status_entrega where status='$status' ")->fetchAll();
        $idstat= $idsta[0]['id'];
        $ultimopedidos= $conn->query("SELECT pedido FROM pedidos  order by id desc limit 1")->fetchAll();
         if (count($ultimopedidos)== 0){
            $pdult=1;    
         }else{
            $pdult= $ultimopedidos[0]['pedido'];    
         }
         $idact= $conn->query("SELECT pedido FROM ultpedido  where pedido=$pedido_1")->fetchAll();
          if (count($idact)==0){
            $cadena4 =$conn->query("INSERT INTO ultpedido (pedido,cliente,obra) VALUES ($pedido_1,'$cliente','$cuenta')");
          }
          $idact= $conn->query("SELECT * FROM montospedidos  where pedido=$pedido_1")->fetchAll();
          if (count($idact)== 0){
            $cadena4 =$conn->query("INSERT INTO montospedidos (montopedido,statussaldo,pedido,saldorestante) VALUES ($total,1,$pedido_1,$total)");
          }
        $ultpedido1= $conn->query("SELECT id FROM montospedidos  order by id desc limit 1")->fetchAll();
        if (count($ultpedido1)== 0){
          $ultp= 1;
          $id2= 1;
        }else{
          $id2= $ultpedido1[0]['id'];
        }
        $cadenaP = $conn->query( "INSERT INTO pedidos (pedido,folio,cliente,cuenta,fecha,devolucion,status_pedido,cant,clave,equipo,dias,PU,importe,direccion_entrega,comentarios,descuento,impuesto,total,subtotal,subtotal2,servicioentrega,idmontopedido,fecharg) VALUES ($pedido_1, '$folio_1', '$cliente','$cuenta','$fecha_1','$fecha_2',$idstat,'$cantidad','$clv','$equipo_2','$dias','$PU_1','$importe','$direccion_entrega','$comentario_1','$descuento','$impuesto','$total','$subtotal_1',$subtotal_2,$sventrega,$id2,'$f')");
        return new JsonResponse($ultpedido1);
    }else{
      $cadenaP = $conn->query( "INSERT INTO cotizaciones (cliente,obra,fecha,devolucion,status,cantidad,clave,equipo,dias,PU,importe,direccion_entrega,comentarios,descuento,impuesto,total,subtotal,subtotal2,servicioentrega,fechaHoy,cotizacion) VALUES ('$cliente','$cuenta','$fecha_1','$fecha_2','Cotizacion','$cantidad','$clv','$equipo_2','$dias','$PU_1','$importe','$direccion_entrega','$comentario_1','$descuento','$impuesto','$total','$subtotal_1',$subtotal_2,$sventrega,'$f',$cotz)");
  $ultpedido1= $conn->query("SELECT cotizacion FROM cotizaciones  order by cotizacion desc limit 1")->fetchAll();
   return new JsonResponse($ultpedido1);
    }
    
  }
  public function ultipedidoAction(Request $request)
  {
    $radio = ($_POST['radio']);
    $manager = $this->getDoctrine()->getManager();
    $conn = $manager->getConnection();
    if($radio=='Pedido'){
         $ultpds= $conn->query("SELECT pedido FROM ultpedido  order by pedido desc limit 1")->fetchAll();
         if (count($ultpds)== 0){
          $ulp= 1;
         }else{
          $ulp= $ultpds[0]['pedido'];
         }
    }else{
        $ultpds= $conn->query("SELECT cotizacion FROM cotizaciones  order by cotizacion desc limit 1")->fetchAll();
         if (count($ultpds)== 0){
          $ulp= 1;
         }else{
          $ulp= $ultpds[0]['cotizacion'];
         }
    }
         return new JsonResponse($ultpds);
  }
  public function consultarcotAction(Request $request)
  {
     $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }
      $sql="SELECT DISTINCT p.cotizacion,p.cliente,p.obra,p.pedido,p.fecha,p.status FROM cotizaciones p";
      $con=0;
      $cliente=$_POST['cliente'];
      $obra=$_POST['obra'];
      $desde=$_POST['desde'];
      $hasta=$_POST['hasta'];
      $cotizacion=$_POST['cotizacion'];


      if ($cliente<>'')
        {
          $sql= $sql." where cliente like '".$cliente."%'";
          $con=1;
        }
        if ($cotizacion<>''){
          if($con==1){
            $sql= $sql." and cotizacion like '".$cotizacion."%'";
          }else{
            $sql= $sql." where cotizacion like '".$cotizacion."%'";
          }
          $con=2;
        }
        if ($desde <> '' and $hasta <> ''){
            if($con==1 or $con==2){
              $sql= $sql." and fecha >= '".$desde."' and fecha <= '".$hasta."'";
          }else{
            $sql= $sql." where fecha >= '".$desde."' and fecha <= '".$hasta."'";
          }
          $con=3;
        }
         if ($desde <> '' and $hasta == '') {
          if($con==1 or $con==2 or $con==3){
            $sql= $sql." and fecha = '".$desde."'";
          }else{
            $sql= $sql." where fecha = '".$desde."'";
          }
          $con=4;
        }
        if ($obra <> '' ){
          if($con==1 or $con==2 or $con==3 or $con==4){
              $sql= $sql." and obra like '".$obra."%'";
          }else{
            $sql= $sql." where obra like '".$obra."%'";
          }
        }
         $manager = $this->getDoctrine()->getManager();
         $conn = $manager->getConnection();
         $dts= $conn->query($sql)->fetchAll();
         return new JsonResponse($dts); 
  }
  public function consultaspdstablaAction(Request $request)
      {
        $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }
      $sql="SELECT DISTINCT p.cliente,p.cuenta,p.folio,p.pedido,p.fecha,p.devolucion,s.status FROM pedidos p, status_entrega s  where p.status_pedido=s.id";
      $con=0;
      $cliente=$_POST['cliente'];
      $folio=$_POST['folio'];
      $pedido=$_POST['pedido'];
      $desde=$_POST['desde'];
      $hasta=$_POST['hasta'];
      $desdedev=$_POST['desdedev'];
      $hastadev=$_POST['hastadev'];


      if ($cliente<>'')
        {
          $sql= $sql." and cliente like '".$cliente."%'";
        }
        if ($folio<>'')
        {
            $sql= $sql." and folio like '".$folio."%'";
        }
        if ($pedido<>''){
            $sql= $sql." and pedido like '".$pedido."%'";
        }
        if ($desde <> '' and $hasta <> ''){
            $sql= $sql." and fecha >= '".$desde."' and fecha <= '".$hasta."'";
        }
         if ($desde <> '' and $hasta == '') {
            $sql= $sql." and fecha = '".$desde."'";
        }
        if ($desdedev <> '' and $hastadev <> ''){
            $sql= $sql." and devolucion >= '".$desdedev."' and devolucion <= '".$hastadev."'";
        }
        if ($desdedev <> '' and $hastadev == '') { 
            $sql=$sql. " and devolucion = '".$desdedev."'"; 
          }
        
         $manager = $this->getDoctrine()->getManager();
         $conn = $manager->getConnection();
         $dts= $conn->query($sql)->fetchAll();
         return new JsonResponse($dts); 
      }


 public function imprimircotAction($cuenta,$cliente,$desde,$hasta,$cotizacion,Request $request)
     { 
        $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }
        $sql="SELECT DISTINCT p.cotizacion,p.cliente,p.obra,p.pedido,p.fecha,p.status,p.devolucion FROM cotizaciones p";
        $con=0;
        $desde= str_replace("-", "/", $desde);
        $hasta= str_replace("-", "/", $hasta);

      if ($cliente<>'0')
        {
          $sql= $sql." where cliente like '".$cliente."%'";
          $con=1;
        }
        if ($cotizacion<>'xxx'){
          if($con==1){
            $sql= $sql." and cotizacion like '".$cotizacion."%'";
          }else{
            $sql= $sql." where cotizacion like '".$cotizacion."%'";
          }
          $con=2;
        }
        if ($desde <> '0' and $hasta <> '0'){
            if($con==1 or $con==2){
              $sql= $sql." and fecha >= '".$desde."' and fecha <= '".$hasta."'";
          }else{
            $sql= $sql." where fecha >= '".$desde."' and fecha <= '".$hasta."'";
          }
          $con=3;
        }
         if ($desde <> '0' and $hasta == '0') {
          if($con==1 or $con==2 or $con==3){
            $sql= $sql." and fecha = '".$desde."'";
          }else{
            $sql= $sql." where fecha = '".$desde."'";
          }
          $con=4;
        }
        if ($cuenta <> '0' ){
          if($con==1 or $con==2 or $con==3 or $con==4){
              $sql= $sql." and obra like '".$cuenta."%'";
          }else{
            $sql= $sql." where obra like '".$cuenta."%'";
          }
        }
        //var_dump($sql);
         $manager = $this->getDoctrine()->getManager();
         $conn = $manager->getConnection();
         $peds= $conn->query($sql);
        
        $con=0;
        
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
                <h1 style="text-align:center;">REPORTE DE COTIZACIONES</h1> 
            
                    <table border="1" cellpadding="5"> 
                      <thead> 
                        <tr align="center"> 
                         <th bgcolor="#00BFFF" style="font-size:100%;">Cotizacion</th>
                         <th bgcolor="#00BFFF" style="font-size:100%;">Cliente</th>
                         <th bgcolor="#00BFFF" style="font-size:100%;">Obra</th>
                         <th bgcolor="#00BFFF" style="font-size:100%;">Fecha</th>
                         <th bgcolor="#00BFFF" style="font-size:100%;">Status</th>
                         <th bgcolor="#00BFFF" style="font-size:100%;">Devolución</th>
                        </tr> 
                      </thead> 
                      '; 

                      while($row = $peds->fetch()) {

                      $content .= ' 
                              <tr> 
                          <td style= "text-align:center;">'.$row['cotizacion'].'</td> 
                          <td style= "text-align:center;">'.$row['cliente'].'</td> 
                          <td style= "text-align:center;">'.$row['obra'].'</td> 
                          <td style= "text-align:center;">'.$row['fecha'].'</td>
                          <td style= "text-align:center;">'.$row['status'].'</td> 
                          <td style= "text-align:center;">'.$row['devolucion'].'</td> 
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
       $pdf->output('Reporte_Cotizaciones.pdf', 'I');

     }


     public function sqlpedAction($cuenta,$cliente,$desde,$hasta,$folio,$pedido,Request $request)
     { 
        $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }
        $desde= str_replace("-", "/", $desde);
        $hasta= str_replace("-", "/", $hasta);
        $con=0;
        $sql="SELECT p.pedido,p.cliente,p.cuenta,p.fecha,s.status,p.folio,p.devolucion FROM pedidos p,status_entrega s where p.status_pedido=s.id";

         if ($cuenta<>'0')
        {
          $sql= $sql." and cuenta like '".$cuenta."%'";
        }
        if ($cliente<>'0')
        {
            $sql= $sql." and cliente like '".$cliente."%'";
        }
        if ($desde <>'0' and $hasta <>'0'){
            $sql= $sql." and fecha >= '".$desde."' and fecha <= '".$hasta."'";
        }
         if ($desde <>'0' and $hasta =='0'){ 
            $sql= $sql." and fecha = '".$desde."'";
        }
       if ($folio <>'0'){
            $sql= $sql." and folio = '".$folio."'";
       }
       if ($pedido <>'xxx'){
            $sql= $sql." and pedido = '".$pedido."'";
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
                <h1 style="text-align:center;">REPORTE DE PEDIDOS</h1> 
            
                    <table border="1" cellpadding="5"> 
                      <thead> 
                        <tr align="center"> 
                         <th bgcolor="#00BFFF" style="font-size:100%;">Pedido</th>
                         <th bgcolor="#00BFFF" style="font-size:100%;">Cliente</th>
                         <th bgcolor="#00BFFF" style="font-size:100%;">Obra</th>
                         <th bgcolor="#00BFFF" style="font-size:100%;">Fecha</th>
                         <th bgcolor="#00BFFF" style="font-size:100%;">Status</th>
                         <th bgcolor="#00BFFF" style="font-size:100%;">Folio</th>
                         <th bgcolor="#00BFFF" style="font-size:100%;">Devolución</th>
                        </tr> 
                      </thead> 
                      '; 

                      while($row = $peds->fetch()) {

                      $content .= ' 
                              <tr> 
                          <td style= "text-align:center;">'.$row['pedido'].'</td> 
                          <td style= "text-align:center;">'.$row['cliente'].'</td> 
                          <td style= "text-align:center;">'.$row['cuenta'].'</td> 
                          <td style= "text-align:center;">'.$row['fecha'].'</td>
                          <td style= "text-align:center;">'.$row['status'].'</td> 
                          <td style= "text-align:center;">'.$row['folio'].'</td> 
                          <td style= "text-align:center;">'.$row['devolucion'].'</td> 
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
       $pdf->output('Reporte_Pedidos.pdf', 'I');

     }
 
     public function ReportepedidoAction($pedido,Request $request)
     {
        $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }

      $sql="SELECT * from pedidos where pedido='".$pedido."'";

        $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetAuthor('JJC');
        $pdf->SetTitle(('Reporte_Pedidos'));
        $pdf->SetSubject('Our Code World Subject');
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('Helvetica', '', 10); 
        $pdf->AddPage();

        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
          
        $peds= $conn->query($sql);

    while($row = $peds->fetch()) {
         
    $cliente = ($row['cliente']);
    $fecha_1 = ($row['fecha']);
    $cuenta = ($row['cuenta']);
    $fecha_2 = ($row['devolucion']);
    $status = ($row['status_pedido']);
    $folio_1 = ($row['folio']);
    $subtotal_1 = ($row['subtotal']);
    $subtotal_2 = ($row['subtotal2']);
    $descuento =($row['descuento']);
    $impuesto = ($row['impuesto']);
    $total = ($row['total']);
    $comentario_1 = ($row['comentarios']);
    $direccion_entrega = ($row['direccion_entrega']);
    $pedido_id = $row['pedido'];
    $servicio = $row['servicioentrega'];
    }

    $content = ''; 
     
    $content .= ' 

        
        <div class="row"> 
        <label class="label6" for="" bgcolor="#E4DBDA">Cliente: '.$cliente.'</label>&nbsp;&nbsp;<label class="label7" for="" bgcolor="#E4DBDA">Cuenta:       '.$cuenta.'</label><br/>
        <br/>
        <label class="label8" for="" bgcolor="#E4DBDA">Pedido:     '.$pedido_id.'</label>&nbsp;&nbsp;<label class="label9" for="" bgcolor="#E4DBDA">Fecha:     '.$fecha_1.'</label><br/>
           <br/>
        <label class="label10" for="" bgcolor="#E4DBDA">Devolucion:     '.$fecha_2.'</label>&nbsp;&nbsp;<label class="label11" for="" bgcolor="#E4DBDA">Folio:     '.$folio_1.'</label><br/>
           <br/>
           <label class="label12" for="" bgcolor="#E4DBDA">Status:     '.$status.'</label>&nbsp;&nbsp;<label class="label13" for="" bgcolor="#E4DBDA">Direccion de Entrega:     '.$direccion_entrega.'</label><br/>



            <div class="col-md-12"> 
                <h1 style="text-align:center;">REPORTE DE PEDIDOS</h1> 
            
                    <table border="1" cellpadding="5"> 
                      <thead> 
                        <tr align="center"> 
                         <th bgcolor="#E4DBDA">Cant</th>
                         <th bgcolor="#E4DBDA">Equipo</th>
                         <th bgcolor="#E4DBDA">Clave</th>
                         <th bgcolor="#E4DBDA">Días</th>
                         <th bgcolor="#E4DBDA">PU</th>
                         <th bgcolor="#E4DBDA">Importe</th>
                        </tr> 
                      </thead> 
                      '; 
                      $sql2="SELECT * from pedidos where pedido='".$pedido."'";
                      $manager = $this->getDoctrine()->getManager();
                      $conn = $manager->getConnection();
                      $peds= $conn->query($sql2);
                      while($row = $peds->fetch()){ 

                      $content .= ' 
                              <tr> 
                          <td>'.$row['cant'].'</td> 
                          <td>'.$row['equipo'].'</td> 
                          <td>'.$row['clave'].'</td> 
                          <td>'.$row['dias'].'</td> 
                          <td>'.$row['PU'].'</td> 
                          <td>'.$row['importe'].'</td> 
                      </tr> 
                      '; 
                      } 

                      $content .= '</table>'; 
     
    $content .= ' 
        <div class="row padding"> 
            <div class="col-md-12" style="text-align:center;"> 
                </div> 
               
                </div> 
                Comentarios:<input class="inp" id="inpt1" type="text" value="">'.$comentario_1.'</input>

                 <div class="col-md-12_total" style="text-align:right;"> 
                Subtotal:<input class="inp" id="inpt1" type="text" value="">'.$subtotal_1.'</input>
                </br>
                </div>
                 <div class="col-md-12_total2" style="text-align:right;"> 
                Descuento %:<input class="inp" id="inpt2" type="text" value="">'.$descuento.'</input>
                </br></div>
                 <div class="col-md-12_total3" style="text-align:right;"> 
                Subtotal:<input class="inp" id="inpt3" type="text" value="">'.$subtotal_2.'</input>
                </br></div>
                <div class="col-md-12_total3" style="text-align:right;"> 
                Servicio Entrega:<input class="inp" id="inpt10" type="text" value="">'.$servicio.'</input>
                </br></div>
                 <div class="col-md-12_total4" style="text-align:right;"> 
                Impuestos:<input class="inp" id="inpt4" type="text" value="">'.$impuesto.'</input>
                </br></div>
                 <div class="col-md-12_total5" style="text-align:right;"> 
                Total:<input class="inp" id="inpt5" type="text" value="">'.$total.'</input></br></div>
         
    '; 
    $pdf->writeHTML($content, true, 0, true, 0); 
    $pdf->lastPage(); 
    $pdf->output('Reporte_Pedido.pdf', 'I'); 
         
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
        $idp=0;
        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
        $conn->query("UPDATE devoluciones SET status_pedido='$estado' where pedido=$pedido");
        $em = $this->getDoctrine()->getManager();
                    $queryc = $em->createQuery(
                    'SELECT p
                    FROM GestionBundle:Pedidos p
                    WHERE p.id = :consultaBusqueda'
                    )->setParameter('consultaBusqueda', $pedido);
                    $query2 = $queryc->getResult();
                    foreach($query2 as $entity){
                            $idp= $entity->getPedido();
                        }
        $conn->query("UPDATE pedidos SET status_pedido='$estado' where pedido=$idp");
         

     }

public function modifpedcanceladoAction(Request $request)
{
 $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));
        }
        $pedido = $_POST['pedido']; 
        $comentarios = $_POST['razoncanc']; 
        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
        $devolact= $conn->query("UPDATE pedidos SET status_pedido=3,comentarios='$comentarios' where pedido=$pedido");
        $ult= $conn->query("UPDATE montospedidos SET statussaldo=3 where pedido=$pedido");
  }
}

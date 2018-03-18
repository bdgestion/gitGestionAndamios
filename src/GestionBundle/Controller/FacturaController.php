<?php

namespace GestionBundle\Controller;
use GestionBundle\Entity\Factura;
use GestionBundle\Entity\DetallesPago;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


class FacturaController extends Controller
{
	public function pedidofactAction(Request $request)
        {
          $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }

        	return $this->render('pagos/pagosindividuales.html.twig');
        
        }
    public function cnscomentarioAction(Request $request)
    {
       $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));
        }
        $id=$_POST['id'];
        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
        $comentario= $conn->query("SELECT DISTINCT comentariopago FROM detalles_pago where id=$id")->fetchAll();
        return new JsonResponse($comentario); 
    }

    public function dtpagosAction(Request $request,$id)
        {
          $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
          $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
          return $this->redirect($this->generateUrl('usuario_login'));
        }
        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();

        $datos_pedido= $conn->query("SELECT DISTINCT p.cliente,p.cuenta,p.total,p.pedido,s.statussaldo FROM pedidos p, montospedidos s WHERE p.idmontopedido=s.id AND p.pedido=".$id)->fetchAll();
        $st=$datos_pedido[0]['statussaldo'];
        $datos_st= $conn->query("SELECT statussaldos FROM status_saldos where id=$st")->fetchAll();
       
        
        $datos_pagos= $conn->query("SELECT d.id,d.pedido,d.fechapago,f.formas,d.montopago,d.comentariopago,d.statusfacturacion,d.foliofactura,d.operacion,d.saldo_restante FROM detalles_pago d, formas_pagos f where d.formapago=f.id and pedido=$id")->fetchAll();

        $datosformas= $conn->query("SELECT DISTINCT formas FROM formas_pagos")->fetchAll();

        return $this->render('pagos/homepagos.html.twig',array('pedido' => $datos_pedido,'dtpagos' => $datos_pagos,'statu' => $datos_st,'formaspg' => $datosformas));
        } 

        
        public function sqlpagsAction(Request $request)
        {
          $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }
          $manager = $this->getDoctrine()->getManager();
          $conn = $manager->getConnection();
          $datosformas= $conn->query("SELECT DISTINCT formas FROM formas_pagos")->fetchAll();
          return $this->render('reportes/reportesaldos.html.twig',array('formaspg' => $datosformas));
        }
         
        public function rptsaldoAction(Request $request)
        {
          $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }
          $manager = $this->getDoctrine()->getManager();
          $conn = $manager->getConnection();
          $datosformas= $conn->query("SELECT DISTINCT formas FROM formas_pagos")->fetchAll();
          return $this->render('reportes/reportesaldos.html.twig',array('formaspg' => $datosformas));
        } 
        public function registropagoAction(Request $request)
        {
           $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));
        }
          $pedido=$_POST['pedido'];
          $fecha=$_POST['fecha'];
          $formapago=$_POST['formapago'];
          $monto_pagar=$_POST['monto_pagar'];
          $operacion=$_POST['operacion'];
          $comentario=$_POST['comentarios'];
          $statussald=$_POST['statusfac'];
          $montopedido=$_POST['montopedido'];
          $saldorestante=$_POST['saldo_restante'];

          $manager = $this->getDoctrine()->getManager();
          $conn = $manager->getConnection();
          // $idstatus= $conn->query("SELECT id FROM status_saldos  where statussaldos='$statusfac' ")->fetchAll();
          // $idst= $idstatus[0]['id'];
          $idformap= $conn->query("SELECT id FROM formas_pagos where formas='$formapago' ")->fetchAll();
          $idforma= $idformap[0]['id'];
          $cadena =$conn->query("INSERT INTO detalles_pago (pedido,fechapago,formapago,montopago,comentariopago,statusfacturacion,foliofactura,operacion,saldo_restante) VALUES ($pedido,'$fecha',$idforma,$monto_pagar,'$comentario',1,'Pendiente','$operacion',$saldorestante)");
          
          $cadenaP = $conn->query("UPDATE montospedidos SET statussaldo=$statussald,saldorestante=$saldorestante WHERE pedido=$pedido");   
           
        }

      
  public function saldosAction(Request $request)
        {
          $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }
          return $this->render('pagos/saldos.html.twig');
        } 

        public function filtropagosAction(Request $request)
         {
          $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }
         	$sql="SELECT d.pedido,d.fechapago,d.montopago,d.foliofactura,d.operacion, u.cliente,u.obra,f.formas,s.statusfac FROM detalles_pago d, ultpedido u, formas_pagos f, status_facturacion s where d.pedido=u.pedido and d.formapago=f.id and d.statusfacturacion=s.id";
    		$con=0;
	        $pedido=$_POST['pedido'];
	        
	        $cliente=$_POST['cliente'];
	        $cuenta=$_POST['cuenta'];
	        $desde=$_POST['desde'];
	        $hasta=$_POST['hasta'];
	        $tipo=$_POST['operacion'];
	        $forma_pago=$_POST['forma'];

     if ($pedido<>'')
        {
          $sql= $sql." and d.pedido like '".$pedido."%'";
        }
        if ($cliente<>''){
            $sql= $sql." and u.cliente like '".$cliente."%'";
        }
        if ($cuenta<>''){
            $sql= $sql." and u.obra like '".$cuenta."%'";
        }

        // if ($tipo<>''){
        //     $sql= $sql." and d.operacion like '".$tipo."%'";
        // }
        // if ($facturacion<>''){
        //     $sql= $sql." and d.statusfacturacion like '".$facturacion."%'";
        // }
        // if ($forma_pago<>''){
        //     $sql= $sql." and d.formapago like '".$forma_pago."%'";
        // }
        // if ($desde<>'' and $hasta<>''){
        //     $sql= $sql." and fecha >= '".$desde."' and fecha <= '".$hasta."'";
        // }
        // if ($desde <> '' and $hasta==''){
        //     $sql= $sql." and fecha = '".$desde."'";
        // }

			 $manager = $this->getDoctrine()->getManager();
             $conn = $manager->getConnection();
             $dts= $conn->query($sql)->fetchAll();
             return new JsonResponse($dts); 


          	
         } 


         public function detallesfacturasAction(Request $request)
         {
          $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }
          $pedidofac = $_POST['pedidofac'];
          $manager = $this->getDoctrine()->getManager();
             $conn = $manager->getConnection();
             $em = $this->getDoctrine()->getManager();
             $queryc = $em->createQuery(
                    'SELECT p
                    FROM GestionBundle:Factura p
                    WHERE p.pedido LIKE :consultaBusqueda'
                    )->setParameter('consultaBusqueda', $pedidofac.'%');
                    $query2 = $queryc->getResult();
                    foreach($query2 as $entity){
                            $cliente= $entity->getCliente();
                            $cta= $entity->getCuenta();
                            $pedido= $entity->getPedido();
                            $fecha= $entity->getFecha();
                            $devolucion= $entity->getDevolucion();
                            $status= $entity->getStatus();
                            $statusf= $entity->getStatusFinanciero();
                            $cargo= $entity->getCargoPedido();
                            $opid= $entity->getOpId();
                            $tipo= $entity->getTipo();
                            $formapago= $entity->getFormaPago();
                            $comentario= $entity->getComentario();
                            $facturacion= $entity->getFacturacion();
                            $monto= $entity->getMonto();
                            $localidad['cliente']  = $cliente;
                            $localidad['tipo']  = $tipo;
                            $localidad['cuenta'] = $cta;
                            $localidad['fecha'] = $fecha;
                            $localidad['devolucion'] = $devolucion;
                            $localidad['status'] = $status;
                            $localidad['statusf'] = $statusf;
                            $localidad['cargo'] = $cargo;
                            $localidad['opid'] = $opid;
                            $localidad['formapago'] = $formapago;
                            $localidad['comentario'] = $comentario;
                            $localidad['facturacion'] = $facturacion;
                            $localidad['monto'] = $monto;

                            $generardatos[] = $localidad;
                     }
                     
            return new JsonResponse($generardatos); 
         }
			public function agregarflAction(Request $request)
			{
        $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));
        }
				$id=$_POST['id'];
				$folio=$_POST['folio'];
        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();

        $idformap= $conn->query("SELECT id FROM status_facturacion where statusfac='$folio' ")->fetchAll();
          //$idforma= $idformap[0]['id'];
          if ($folio!='Pendiente' && $folio!='No Requiere Factura'){
            $cadenaP = $conn->query("UPDATE detalles_pago SET foliofactura='$folio',statusfacturacion=2  WHERE id=$id");
          }
          if ($folio=='No Requiere Factura'){
            $cadenaP = $conn->query("UPDATE detalles_pago SET foliofactura='$folio',statusfacturacion=3  WHERE id=$id");
          }
			}

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

  public function llenarcta2Action(Request $request)
  {
      $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }
        $cliente =$_POST['clienterz'];

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
            $restr= $entity->getRestringir();
          }

        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
        $em = $this->getDoctrine()->getManager();
        $queryc = $em->createQuery(
        'SELECT p
        FROM GestionBundle:CuentasCliente p
        WHERE p.cliente = :consultaBusqueda'
        )->setParameter('consultaBusqueda', $clienteid)
        ->setMaxResults(1);
        $query2 = $queryc->getResult();

        foreach($query2 as $entity){
            $generardatos = array();
            $cuenta= $entity->getCuentaId();
            $localidad['cuenta_Id']  = $cuenta;
            $localidad['restringir']  = $restr;

            $generardatos[] = $localidad;
          }
        return new JsonResponse($generardatos);
  }

      public function filtrossaldosAction(Request $request)
      {
        $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }
        
    $sql="SELECT * FROM factura";
    $con=0;
        $pedido=$_POST['pedido'];
        $folio_pedido=$_POST['folio'];
        $cliente=$_POST['cliente'];
        $cuenta=$_POST['cuenta'];
        $desde=$_POST['desde'];
        $hasta=$_POST['hasta'];
        $status=$_POST['status'];
        if ($pedido <> '')
        {
          $sql= $sql." where pedido like '".$pedido."%'";
          $con=1;
        }
        if ($folio_pedido <>'')
        {
          if ($con==1){
            $sql= $sql." and folio_pedido like '".$folio_pedido."%'";
            $con=2;
        }else {
          $sql=$sql. " where folio_pedido like '".$folio_pedido."%'"; 
          $con=3;
         }
        }
        if ($cliente <> ''){
  
          if ($con==1 OR $con==2 OR $con==3 ){
            $sql= $sql." and cliente like '".$cliente."%'";
            $con=4;
          }else{
          $sql=$sql. " where cliente like '".$cliente."%'"; 
          $con=5;
          }
        }
        if ($cuenta <> ''){
          if ($con==1 OR $con==2 OR $con==3 OR $con==4 OR $con==5 ){
            $sql= $sql." and cuenta like '".$cuenta."%'";
            $con=6;
          }else{
            $sql=$sql. " where cuenta like '".$cuenta."%'"; 
            $con=7;
          }
        }
        if ($status <> ''){
          if ($con==1 OR $con==2 OR $con==3 OR $con==4 OR $con==5 ){
            $sql= $sql." and status_financiero like '".$status."%'";
            $con=6;
          }else{
            $sql=$sql. " where status_financiero like '".$status."%'"; 
            $con=7;
          }
        }

        if ($desde <> '' and $hasta <> ''){
          if ($con==1 OR $con==2 OR $con==3 OR $con==4 OR $con==5 OR $con==6 OR $con==7){
            $sql= $sql." and fecha >= '".$desde."' and fecha <= '".$hasta."'";
            $con=8;
          }else{
            $sql=$sql. " where fecha >=  '".$desde."' and fecha <=  '".$hasta."'"; 
            $con=9;
          }
        }
         if ($desde <> '' and  $hasta==''){
          if ($con==1 OR $con==2 OR $con==3 OR $con==4 OR $con==5 OR $con==6 OR $con==7 OR $con==8 OR $con==9){
            $sql= $sql." and fecha = '".$desde."'";
            $con=10;
          }else{
            $sql=$sql. " where fecha = '".$desde."'"; 
            $con=11;
          }
        }
          $manager = $this->getDoctrine()->getManager();
          $conn = $manager->getConnection();
          $dts= $conn->query($sql)->fetchAll();
          return new JsonResponse($dts); 
         }
      
         public function reporteoperacionesAction(Request $request)
         {
          $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }
            return $this->render('reportes/reporteoperaciones.html.twig');
         }

        public function rptopiltroAction(Request $request)
        {
          $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }
        $sql="SELECT * FROM factura";
        $con=0;

        $cliente=$_POST['cliente'];
        $cuenta=$_POST['cuenta'];
        $desde=$_POST['desde'];
        $hasta=$_POST['hasta'];
        $filtro1=$_POST['filtro1'];
        $filtro2=$_POST['filtro2'];
        $filtro3=$_POST['filtro3'];
        $filtro4=$_POST['filtro4'];
        $filtro5=$_POST['filtro5'];
        $filtro6=$_POST['filtro6'];
        $filtro7=$_POST['filtro7'];
        $filtro8=$_POST['filtro8'];
        $filtro9=$_POST['filtro9'];

        if ($cuenta <>'')
        {
          $sql= $sql." where cuenta like '".$cuenta."%'";
          $con=1;
        }
        if ($cliente <> '')
        {
          if ($con==1){
            $sql= $sql." and cliente like '".$cliente."%'";
            $con=2;
        }else {
          $sql=$sql. " where cliente like '".$cliente."%'"; 
          $con=3;
         }
        }
        if ($desde <> '' and $hasta <> ''){
          if ($con==1 OR $con==2 OR $con==3 ){
            $sql= $sql." and fecha >= '".$desde."' and fecha <= '".$hasta."'";
            $con=4;
          }else{
            $sql=$sql. " where fecha >= '".$desde."' and fecha <= '".$hasta."'"; 
            $con=5;
          }
        }
         if ($desde <> '' and $hasta=='') { 
          if ($con==1 OR $con==2 OR $con==3 OR $con==4 OR $con==5){
            $sql= $sql." and fecha = '".$desde."'";
            $con=6;
          }else{
            $sql=$sql. " where fecha = '".$desde."'"; 
            $con=7;
          }
        }
         if($filtro1=='Activo'){
           if ($con==1 OR $con==2 OR $con==3 OR $con==4 OR $con==5 OR $con==6 OR $con==7){
            $sql= $sql." or tipo='Pago'";
            $con=8;
          }else{
            $sql=$sql. " where tipo='Pago'";
            $con=9;
          }
        }

    if($filtro2=='Activo'){
      if ($con==1 OR $con==2 OR $con==3 OR $con==4 OR $con==5 OR $con==6 OR $con==7 OR $con==8 OR $con==9){
            $sql= $sql." or tipo='Cargo'";
            $con=10;
          }else{
            $sql=$sql. " where tipo='Cargo'";
            $con=11;
          }
        }
    if($filtro3=='Activo'){
        if ($con==1 OR $con==2 OR $con==3 OR $con==4 OR $con==5 OR $con==6 OR $con==7 OR $con==8 OR $con==9 OR $con==10 OR $con==11){
            $sql= $sql." or forma_pago='Efectivo'";
            $con=12;
          }else{
            $sql=$sql. " where forma_pago='Efectivo'";
            $con=13;
          }
        }
        if($filtro4=='Activo'){
        if ($con==1 OR $con==2 OR $con==3 OR $con==4 OR $con==5 OR $con==6 OR $con==7 OR $con==8 OR $con==9 OR $con==10 OR $con==11 OR $con==12 OR $con==13){
            $sql= $sql." or forma_pago='Cheque'";
            $con=14;
          }else{
            $sql=$sql. " where forma_pago='Cheque'";
            $con=15;
          }
        }
      if($filtro5=='Activo'){
        if ($con==1 OR $con==2 OR $con==3 OR $con==4 OR $con==5 OR $con==6 OR $con==7 OR $con==8 OR $con==9 OR $con==10 OR $con==11 OR $con==12 OR $con==13 OR $con==14 OR $con==15){
            $sql= $sql." or forma_pago='Transferencia'";
            $con=16;
          }else{
            $sql=$sql. " where forma_pago='Transferencia'";
            $con=17;
          }
        }
      if($filtro6=='Activo'){
        if ($con==1 OR $con==2 OR $con==3 OR $con==4 OR $con==5 OR $con==6 OR $con==7 OR $con==8 OR $con==9 OR $con==10 OR $con==11 OR $con==12 OR $con==13 OR $con==14 OR $con==15 OR $con==16 OR $con==17){
            $sql= $sql." or forma_pago='Tarjeta'";
            $con=18;
          }else{
            $sql=$sql. " where forma_pago='Tarjeta'";
            $con=19;
          }
        }
      if($filtro7=='Activo'){
        if ($con==1 OR $con==2 OR $con==3 OR $con==4 OR $con==5 OR $con==6 OR $con==7 OR $con==8 OR $con==9 OR $con==10 OR $con==11 OR $con==12 OR $con==13 OR $con==14 OR $con==15 OR $con==16 OR $con==17 OR $con==18 OR $con==19){

            $sql= $sql." or facturacion='Facturado'";
            $con=20;
          }else{
            $sql=$sql. " where facturacion='Facturado'";
            $con=21;
          }
        }
        if($filtro8=='Activo'){
        if ($con==1 OR $con==2 OR $con==3 OR $con==4 OR $con==5 OR $con==6 OR $con==7 OR $con==8 OR $con==9 OR $con==10 OR $con==11 OR $con==12 OR $con==13 OR $con==14 OR $con==15 OR $con==16 OR $con==17 OR $con==18 OR $con==19 OR $con==20 OR $con==21){
            $sql= $sql." or facturacion = 'Pendiente'";
            $con=22;
          }else{
            $sql=$sql. " where facturacion = 'Pendiente'";
            $con=23;
          }
        }
      if($filtro9=='Activo'){
        if ($con==1 OR $con==2 OR $con==3 OR $con==4 OR $con==5 OR $con==6 OR $con==7 OR $con==8 OR $con==9 OR $con==10 OR $con==11 OR $con==12 OR $con==13 OR $con==14 OR $con==15 OR $con==16 OR $con==17 OR $con==18 OR $con==19 OR $con==20 OR $con==21 OR $con==22 OR $con==23){
            $sql= $sql." or facturacion = 'No Requiere Factura'";
            $con=24;
          }else{
            $sql=$sql. " where facturacion = 'No Requiere Factura'";
            $con=25;
          }
        }

        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
          
        $peds= $conn->query($sql)->fetchAll();
        return new JsonResponse($peds);



        }

        public function sqloperAction($cliente2,$cuenta2,$desde2,$hasta2,$cuenta,$cliente,$desde,$hasta,$filtro1,$filtro2,$filtro3,$filtro4,$filtro5,$filtro6,$filtro7,$filtro8,$filtro9,Request $request)
        {
          $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }
        $desde= str_replace(",", "/", $desde);
        $hasta= str_replace(",", "/", $hasta);
        $con=0;
        $sql="SELECT * FROM factura";

        if ($cuenta <>'0')
        {
          $sql= $sql." where cuenta like '".$cuenta."%'";
          $con=1;
        }
        if ($cliente <> '0')
        {
          if ($con==1){
            $sql= $sql." and cliente like '".$cliente."%'";
            $con=2;
        }else {
          $sql=$sql. " where cliente like '".$cliente."%'"; 
          $con=3;
         }
        }
        if ($desde <> '0' and $hasta <> '0'){
          if ($con==1 OR $con==2 OR $con==3 ){
            $sql= $sql." and fecha >= '".$desde."' and fecha <= '".$hasta."'";
            $con=4;
          }else{
            $sql=$sql. " where fecha >= '".$desde."' and fecha <= '".$hasta."'"; 
            $con=5;
          }
        }
         if ($desde <> '0' and $hasta=='0') { 
          if ($con==1 OR $con==2 OR $con==3 OR $con==4 OR $con==5){
            $sql= $sql." and fecha = '".$desde."'";
            $con=6;
          }else{
            $sql=$sql. " where fecha = '".$desde."'"; 
            $con=7;
          }
        }
         if($filtro1=='Activo'){
           if ($con==1 OR $con==2 OR $con==3 OR $con==4 OR $con==5 OR $con==6 OR $con==7){
            $sql= $sql." or tipo='Pago'";
            $con=8;
          }else{
            $sql=$sql. " where tipo='Pago'";
            $con=9;
          }
        }

    if($filtro2=='Activo'){
      if ($con==1 OR $con==2 OR $con==3 OR $con==4 OR $con==5 OR $con==6 OR $con==7 OR $con==8 OR $con==9){
            $sql= $sql." or tipo='Cargo'";
            $con=10;
          }else{
            $sql=$sql. " where tipo='Cargo'";
            $con=11;
          }
        }
    if($filtro3=='Activo'){
        if ($con==1 OR $con==2 OR $con==3 OR $con==4 OR $con==5 OR $con==6 OR $con==7 OR $con==8 OR $con==9 OR $con==10 OR $con==11){
            $sql= $sql." or forma_pago='Efectivo'";
            $con=12;
          }else{
            $sql=$sql. " where forma_pago='Efectivo'";
            $con=13;
          }
        }
        if($filtro4=='Activo'){
        if ($con==1 OR $con==2 OR $con==3 OR $con==4 OR $con==5 OR $con==6 OR $con==7 OR $con==8 OR $con==9 OR $con==10 OR $con==11 OR $con==12 OR $con==13){
            $sql= $sql." or forma_pago='Cheque'";
            $con=14;
          }else{
            $sql=$sql. " where forma_pago='Cheque'";
            $con=15;
          }
        }
      if($filtro5=='Activo'){
        if ($con==1 OR $con==2 OR $con==3 OR $con==4 OR $con==5 OR $con==6 OR $con==7 OR $con==8 OR $con==9 OR $con==10 OR $con==11 OR $con==12 OR $con==13 OR $con==14 OR $con==15){
            $sql= $sql." or forma_pago='Transferencia'";
            $con=16;
          }else{
            $sql=$sql. " where forma_pago='Transferencia'";
            $con=17;
          }
        }
      if($filtro6=='Activo'){
        if ($con==1 OR $con==2 OR $con==3 OR $con==4 OR $con==5 OR $con==6 OR $con==7 OR $con==8 OR $con==9 OR $con==10 OR $con==11 OR $con==12 OR $con==13 OR $con==14 OR $con==15 OR $con==16 OR $con==17){
            $sql= $sql." or forma_pago='Tarjeta'";
            $con=18;
          }else{
            $sql=$sql. " where forma_pago='Tarjeta'";
            $con=19;
          }
        }
      if($filtro7=='Activo'){
        if ($con==1 OR $con==2 OR $con==3 OR $con==4 OR $con==5 OR $con==6 OR $con==7 OR $con==8 OR $con==9 OR $con==10 OR $con==11 OR $con==12 OR $con==13 OR $con==14 OR $con==15 OR $con==16 OR $con==17 OR $con==18 OR $con==19){

            $sql= $sql." or facturacion='Facturado'";
            $con=20;
          }else{
            $sql=$sql. " where facturacion='Facturado'";
            $con=21;
          }
        }
        if($filtro8=='Activo'){
        if ($con==1 OR $con==2 OR $con==3 OR $con==4 OR $con==5 OR $con==6 OR $con==7 OR $con==8 OR $con==9 OR $con==10 OR $con==11 OR $con==12 OR $con==13 OR $con==14 OR $con==15 OR $con==16 OR $con==17 OR $con==18 OR $con==19 OR $con==20 OR $con==21){
            $sql= $sql." or facturacion = 'Pendiente'";
            $con=22;
          }else{
            $sql=$sql. " where facturacion = 'Pendiente'";
            $con=23;
          }
        }
      if($filtro9=='Activo'){
        if ($con==1 OR $con==2 OR $con==3 OR $con==4 OR $con==5 OR $con==6 OR $con==7 OR $con==8 OR $con==9 OR $con==10 OR $con==11 OR $con==12 OR $con==13 OR $con==14 OR $con==15 OR $con==16 OR $con==17 OR $con==18 OR $con==19 OR $con==20 OR $con==21 OR $con==22 OR $con==23){
            $sql= $sql." or facturacion = 'No Requiere Factura'";
            $con=24;
          }else{
            $sql=$sql. " where facturacion = 'No Requiere Factura'";
            $con=25;
          }
        }

        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
          
        $peds= $conn->query($sql);
        

        
  if ($filtro1=='Desactivado'){
    $chekeado='';
  }else{
    $chekeado='checked="checked"';
  }
  if ($filtro2=='Desactivado'){
    $chekeado='';
  }else{
    $chekeado='checked="checked"';
  }
  if ($filtro3=='Desactivado'){
    $chekeado='';
  }else{
    $chekeado='checked="checked"';
  }
  if ($filtro4=='Desactivado'){
    $chekeado='';
  }else{
    $chekeado='checked="checked"';
  }
  if ($filtro5=='Desactivado'){
    $chekeado='';
  }else{
    $chekeado='checked="checked"';
  }
  if ($filtro6=='Desactivado'){
    $chekeado='';
  }else{
    $chekeado='checked="checked"';
  }
  if ($filtro7=='Desactivado'){
    $chekeado='';
  }else{
    $chekeado='checked="checked"';
  }
  if ($filtro8=='Desactivado'){
    $chekeado='';
  }else{
    $chekeado='checked="checked"';
  }
  if ($filtro9=='Desactivado'){
    $chekeado='';
  }else{
    $chekeado='checked="checked"';
  }
  $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetAuthor('JJC');
        $pdf->SetTitle(('Reporte_Operaciones'));
        $pdf->SetSubject('Our Code World Subject');
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('Helvetica', '', 10); 
        $pdf->AddPage();



 $content = ''; 
     
    $content .= ' 

      
        <div class="row"> 
        <label class="label6" for="" bgcolor="#E4DBDA" style="text-align:right;">Cliente: '.$cliente.'</label><br/>
        <br/>
        <label class="label7" for="" bgcolor="#E4DBDA">Cuenta:       '.$cuenta.'</label><br/>
        <br/>
        <label class="label8" for="" bgcolor="#E4DBDA">Desde:     '.$desde.'</label><br/>
          <br/>
        <label class="label9" for="" bgcolor="#E4DBDA">Hasta:     '.$hasta.'</label><br/>
           <br/>
        <label class="label9" for="" bgcolor="#E4DBDA">FILTROS:</label><br/>
           <br/>
           Pago<input type="checkbox" id="chk1" name="chk1" value="Emitida"'.$chekeado.'>
           Cargo<input type="checkbox" id="chk2" name="chk2" value="Emitida"'.$chekeado.'>
           Efectivo<input type="checkbox" id="chk3" name="chk3" value="Emitida"'.$chekeado.'>
           Cheque<input type="checkbox" id="chk4" name="chk4" value="Emitida"'.$chekeado.'>
           Transferencia<input type="checkbox" id="chk5" name="chk5" value="Emitida"'.$chekeado.'>
           Tarjeta<input type="checkbox" id="chk6" name="chk6" value="Emitida"'.$chekeado.'>
           Facturado<input type="checkbox" id="chk7" name="chk7" value="Emitida"'.$chekeado.'>
           Pendiente<input type="checkbox" id="chk8" name="chk8" value="Emitida"'.$chekeado.'>
           No Requiere Factura<input type="checkbox" id="chk9" name="chk9" value="Emitida"'.$chekeado.'>

            <div class="col-md-12"> 
                <h1 style="text-align:center;">REPORTE DE PEDIDOS</h1> 
            
                    <table border="1" cellpadding="5"> 
                      <thead> 
                        <tr align="center"> 
                         <th bgcolor="#E4DBDA">Operación ID</th>
                     <th bgcolor="#E4DBDA">Tipo de Operación</th>
                     <th bgcolor="#E4DBDA">Fecha</th>
                     <th bgcolor="#E4DBDA">Monto</th>
                     <th bgcolor="#E4DBDA">Forma de Pago</th>
                     <th bgcolor="#E4DBDA">Status Factura</th>
                        </tr> 
                      </thead> 
                      '; 


                      while($row = $peds->fetch()) {

                      $content .= ' 
                              <tr> 
                          <td>'.$row['Op_ID'].'</td> 
                          <td>'.$row['tipo'].'</td> 
                          <td>'.$row['fecha'].'</td> 
                          <td>'.$row['monto'].'</td> 
                          <td>'.$row['forma_pago'].'</td> 
                          <td>'.$row['facturacion'].'</td> 
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
    $pdf->output('Reporte_Operaciones.pdf', 'I'); 
    
   }

   public function filtrosaldoAction(request $request)
   {
    $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));
        }
        
        $cliente=$_POST['cliente'];
        $cuenta=$_POST['cuenta'];
        $desde=$_POST['desde'];
        $hasta=$_POST['hasta'];
        $tipo=$_POST['tipofecha'];


       // if($tipo=='1'){
        $manager = $this->getDoctrine()->getManager();
    $conn = $manager->getConnection();
    $eliminar= $conn->query("DELETE FROM home_temp");    
    $pdconsulta= $conn->query("SELECT DISTINCT m.pedido,p.folio,p.devolucion,p.fecha,m.saldorestante FROM pedidos p ,montospedidos m WHERE m.id=p.idmontopedido AND p.cliente='$cliente' AND p.cuenta='$cuenta'")->fetchAll();

    for ($i=0;$i<count($pdconsulta); $i++)
      {
        $ped=$pdconsulta[$i]['pedido'];
        $folio=$pdconsulta[$i]['folio'];
        $dev=$pdconsulta[$i]['devolucion'];
        $stfecha=$pdconsulta[$i]['fecha'];
        $saldo1=$pdconsulta[$i]['saldorestante'];

        $año2 = substr($dev, -4);
        $dia2 = substr($dev,3,2);
        $mes2 = substr($dev,0,2);
        $fecha2= $año2."-".$dia2."-".$mes2;

        $año = substr($stfecha, -4);
        $dia = substr($stfecha,3,2);
        $mes = substr($stfecha,0,2);
        $fecha1= $año."-".$dia."-".$mes;

          $insertar = $conn->query("INSERT INTO home_temp (pedido,folio,fecha_pedido,fecha_dev,cliente,status_pedido,status_pago,saldo) VALUES ($ped,'$folio','$fecha1','$fecha2','cliente',1,1,$saldo1)");   
      }

      if($tipo=='1'){
        $sql="SELECT pedido,folio,fecha_pedido,fecha_dev,saldo FROM home_temp WHERE fecha_pedido Between '$desde' AND '$hasta'";
      }else{
        $sql="SELECT pedido,folio,fecha_pedido,fecha_dev,saldo FROM home_temp WHERE fecha_dev BETWEEN '$desde' AND '$hasta'";

      }

        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
          
        $peds= $conn->query($sql)->fetchAll();
        return new JsonResponse($peds);
   }

   public function sqlsaldoAction($cliente,$cuenta,$fechahasta,$fechadesde,$tipofecha,Request $request)
   {
    $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }
        $año = substr($fechahasta,0,4);
        $dia = substr($fechahasta,8,9);
        $mes = substr($fechahasta,5,2);
        
        $fechahastaf=$dia."/".$mes."/".$año;

        $añod = substr($fechadesde,0,4);
        $diad = substr($fechadesde,8,9);
        $mesd = substr($fechadesde,5,2);
        
        $fechadesdef=$diad."/".$mesd."/".$añod;

        //2018,02,16
        $fechadesde= str_replace(",", "-", $fechadesde);
        $fechahasta= str_replace(",", "-", $fechahasta);
        //$sql="SELECT * FROM factura ";
        //$con=0;

         if($tipofecha=='1'){
        $sql="SELECT pedido,folio,fecha_pedido,fecha_dev,saldo FROM home_temp WHERE fecha_pedido Between '$fechadesde' AND '$fechahasta'";
      }else{
        $sql="SELECT pedido,folio,fecha_pedido,fecha_dev,saldo FROM home_temp WHERE fecha_dev BETWEEN '$fechadesde' AND '$fechahasta'";

      }
        
        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
        $peds= $conn->query($sql);

   $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->SetAuthor('JJC');
        $pdf->SetTitle(('Reporte_Saldos'));
        $pdf->SetSubject('Our Code World Subject');
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('Helvetica', '', 10); 
        $pdf->AddPage();

    $content = ''; 
    $content .= ' 

 <div class=""> 
  <h2>DETALLES:</h2>
  </div>

        <label class="label6" style=" font-size:150%;color: #00BFFF">Cliente: </label> <label style="font-size:150%;"> '.$cliente.'</label><br/>
        <br/>
        <label class="label7"  style="font-size:150%; color: #00BFFF">Obra:</label><label style="font-size:150%;"> '.$cuenta.'</label><br/>
        <br/>
        <label class="label8" for=""  style="font-size:150%; color: #00BFFF">Desde:</label><label style="font-size:150%;"> '.$fechadesdef.'</label><br/>
          <br/>
        <label class="label9" for=""  style="font-size:150%;color: #00BFFF">Hasta:</label> <label style="font-size:150%;"> '.$fechahastaf.'</label><br/></div>
        <hr style= "color:#00BFFF; ">
            <div class="col-md-12"> 
                <h1 style="text-align:center;">REPORTE DE SALDOS</h1> 
            
                    <table border="1" cellpadding="5"> 
                      <thead> 
                        <tr align="center"> 
                 <th bgcolor="#00BFFF" style="font-size:150%;">Pedido</th>
                 <th bgcolor="#00BFFF" style="font-size:150%;">Folio</th>
                 <th bgcolor="#00BFFF" style="font-size:150%;">Fecha</th>
                 <th bgcolor="#00BFFF" style="font-size:150%;">Saldo</th>
                        </tr> 
                      </thead> 
                      '; 
                      $total_saldo=0;

                     while ($row = $peds->fetch()) {
                        $añod = substr($row['fecha_pedido'],0,4);
                        $diad = substr($row['fecha_pedido'],8,9);
                        $mesd = substr($row['fecha_pedido'],5,2);
                        $fechafiltro=$diad."/".$mesd."/".$añod;

                      $content .= ' 
                              <tr> 

                          <td style= "text-align:center;">'.$row['pedido'].'</td> 
                          <td style= "text-align:center;">'.$row['folio'].'</td> 
                          <td style= "text-align:center;">'.$fechafiltro.'</td> 
                          <td style= "text-align:center;">'.$row['saldo'].'</td> 

                      </tr> 
                      '; $total_saldo=$total_saldo+ $row['saldo'];
                      } 


                      $content .= '</table>'; 

     
    $content .= ' 
     <div class="row padding"> 
            <div class="col-md-12" style="text-align:right;"> 
            <label class="label7" for="" style="text-align:right;font-size:150%;">Total Saldo:</label><label style="font-size:150%; color:#FF4500"> $'.$total_saldo.'</label><br/>
                </div> 
                </div> 
         
    ';
                   $pdf->writeHTML($content, true, 0, true, 0); 
                   $pdf->lastPage(); 
                   $pdf->output('Reporte_Saldos.pdf', 'I'); 

   }
}

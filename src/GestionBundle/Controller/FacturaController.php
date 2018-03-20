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
          return $this->render('reportes/ConsultasReportes.html.twig',array('formaspg' => $datosformas));
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
          return $this->render('reportes/ConsultasReportes.html.twig',array('formaspg' => $datosformas));
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

			 $manager = $this->getDoctrine()->getManager();
             $conn = $manager->getConnection();
             $dts= $conn->query($sql)->fetchAll();
             return new JsonResponse($dts); 
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

          $insertar = $conn->query("INSERT INTO home_temp (pedido,folio,fecha_pedido,fecha_dev,cliente,status_pedido,status_pago,saldo) VALUES ($ped,'$folio','$fecha1','$fecha2','$cliente',1,1,$saldo1)");   
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

   public function sqlsaldoAction($cliente,$cuenta,$fechadesde,$fechahasta,$tipofecha,Request $request)
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
     public function imprimirpagoAction($pedido,$folio,$fechadesde,$fechahasta,$cliente,$obra,Request $request)
   {
    $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));
        }
       
       $sql="SELECT d.pedido,d.fechapago,d.montopago,d.foliofactura,d.operacion, u.cliente,u.obra,f.formas,s.statusfac FROM detalles_pago d, ultpedido u, formas_pagos f, status_facturacion s where d.pedido=u.pedido and d.formapago=f.id and d.statusfacturacion=s.id";

     if ($pedido<>'xxx')
        {
          $sql= $sql." and d.pedido like '".$pedido."%'";
        }
        if ($cliente<>'0'){
            $sql= $sql." and u.cliente like '".$cliente."%'";
        }
        if ($obra<>'0'){
            $sql= $sql." and u.obra like '".$obra."%'";
        }
         if ($fechadesde <>'0' and $fechahasta <>'0'){
            $sql= $sql." and fecha >= '".$fechadesde."' and fecha <= '".$fechahasta."'";
        }
         if ($fechadesde <>'0' and $fechahasta =='0'){ 
            $sql= $sql." and fecha = '".$fechadesde."'";
        }

        
        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
        $peds= $conn->query($sql);
   $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->SetAuthor('JJC');
        $pdf->SetTitle(('Reporte_Pagos'));
        $pdf->SetSubject('Our Code World Subject');
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('Helvetica', '', 10); 
        $pdf->AddPage();

    $content = ''; 
    $content .= ' 

        <div class=""> 
          <h3 style="color:#00BFFF">Fecha de Impresión:'.date("d-m-Y").' </h3>
        </div>
                <h1 style="text-align:center;">REPORTE DE PAGOS</h1> 
            
                    <table border="1" cellpadding="5"> 
                      <thead> 
                        <tr align="center"> 
                 <th bgcolor="#00BFFF" style="font-size:100%;">PEDIDO</th>
                 <th bgcolor="#00BFFF" style="font-size:100%;">FECHA</th>
                 <th bgcolor="#00BFFF" style="font-size:100%;">FOLIO</th>
                 <th bgcolor="#00BFFF" style="font-size:100%;">TIPO</th>
                 <th bgcolor="#00BFFF" style="font-size:100%;">CLIENTE</th>
                 <th bgcolor="#00BFFF" style="font-size:100%;">OBRA</th>
                 <th bgcolor="#00BFFF" style="font-size:100%;">FORMA DE PAGO</th>
                 <th bgcolor="#00BFFF" style="font-size:100%;">STATUS DE PAGO</th>
                 <th bgcolor="#00BFFF" style="font-size:100%;">MONTO</th>
                        </tr> 
                      </thead> 
                      '; 
                      $total_saldo=0;

                     while ($row = $peds->fetch()) {
                        $añod = substr($row['fechapago'],0,4);
                        $diad = substr($row['fechapago'],8,9);
                        $mesd = substr($row['fechapago'],5,2);
                        $fechafiltro=$diad."/".$mesd."/".$añod;

                      $content .= ' 
                              <tr> 

                          <td style= "text-align:center;">'.$row['pedido'].'</td> 
                          <td style= "text-align:center;">'.$fechafiltro.'</td> 
                          <td style= "text-align:center;">'.$row['foliofactura'].'</td> 
                          <td style= "text-align:center;">'.$row['operacion'].'</td> 
                          <td style= "text-align:center;">'.$row['cliente'].'</td> 
                          <td style= "text-align:center;">'.$row['obra'].'</td> 
                          <td style= "text-align:center;">'.$row['formas'].'</td> 
                          <td style= "text-align:center;">'.$row['statusfac'].'</td> 
                          <td style= "text-align:center;">'.$row['montopago'].'</td> 
                      </tr> 
                      '; $total_saldo=$total_saldo+ $row['montopago'];
                      } 


                      $content .= '</table>'; 

     
    $content .= ' 
     <div class="row padding"> 
            <div class="col-md-12" style="text-align:right;"> 
            <label class="label7" for="" style="text-align:right;font-size:150%;">Monto Pagado:</label><label style="font-size:150%; color:#FF4500"> $'.$total_saldo.'</label><br/>
                </div> 
                </div> 
         
    ';
                   $pdf->writeHTML($content, true, 0, true, 0); 
                   $pdf->lastPage(); 
                   $pdf->output('Reporte_Pagos.pdf', 'I'); 

   }
}

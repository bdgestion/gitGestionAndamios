<?php

namespace GestionBundle\Controller;

use GestionBundle\Entity\Recolecciones;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * Recolecciones controller.
 *
 */
class RecoleccionesController extends Controller
{
    /**
     * Lists all Recoleccionees entities.
     *
     */

    public function crearrecoleccionesAction(Request $request)
    {
      $session = $request->getSession(); 
        if(!$session->get("usuarionombre")){
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
            return $this->redirect($this->generateUrl('usuario_login'));

        }
          $em = $this->getDoctrine()->getManager();
        $pedidos = $em->getRepository('GestionBundle:Recolecciones')->findAll();
        $fecha=date("Y-m-d");  
        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
        $em = $this->getDoctrine()->getManager();
        $recolecciones= $conn->query("SELECT * FROM recolecciones WHERE fecha='$fecha'")->fetchAll();    
        return $this->render('recolecciones/recolecciones.html.twig',array('datosrecolecciones' => $recolecciones));
    }

     public function eliminarrecoleccionAction(Request $request)
      {
        $session = $request->getSession(); 
            if(!$session->get("usuarionombre")){
                $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
                return $this->redirect($this->generateUrl('usuario_login'));
            }

         $recoleccion=$_POST['recoleccion'];
         $manager = $this->getDoctrine()->getManager();
         $conn = $manager->getConnection();
         $sql= $conn->query("DELETE from recolecciones where id=$recoleccion");
      }
      public function filtrarAction(Request $request)
      {
         $session = $request->getSession(); 
            if(!$session->get("usuarionombre")){
                $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
                return $this->redirect($this->generateUrl('usuario_login'));
            }

         $sql="SELECT DISTINCT * FROM recolecciones";
         $obra=$_POST['cuenta'];
         $cliente=$_POST['cliente'];
         $desde=$_POST['desde'];
         $hasta=$_POST['hasta'];

      
        $año = substr($desde, -4);
        $dia = substr($desde,0,2);
        $mes = substr($desde,3,2);
        $desderec= $año."-".$mes."-".$dia;


        $año2 = substr($hasta, -4);
        $dia2 = substr($hasta,0,2);
        $mes2 = substr($hasta,3,2);
        $hastarec= $año2."-".$mes2."-".$dia2;
        $con=0;
         if ($cliente<>'')
        {
          $sql= $sql." WHERE clientes like '".$cliente."%'";
          $con=1;
        }
        if ($obra<>'')
        {
            if($con==1){
              $sql= $sql." and obra like '".$obra."%'";  
            }else{
              $sql= $sql." where obra like '".$obra."%'";
            }
            $con=2;
        }
        if ($desde <> '' and $hasta <> ''){
          if($con==1 or $con==2){
            $sql= $sql." and fecha >= '".$desderec."' and fecha <= '".$hastarec."'";
          }else{
            $sql= $sql." where fecha >= '".$desderec."' and fecha <= '".$hastarec."'";
          }
          $con=3;
        }
         if ($desde <> '' and $hasta == '') {
          if($con==1 or $con==2 or $con==3){
            $sql= $sql." and fecha = '".$desde."'";
          }else{
            $sql= $sql." where fecha = '".$desde."'";
          }
        }

        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
        $dts= $conn->query($sql)->fetchAll();
        return new JsonResponse($dts); 

      }

    public function dtpdAction(Request $request)
      {
          $rz=$_POST['clienterz'];
           $manager = $this->getDoctrine()->getManager();
            $conn = $manager->getConnection();
            $em = $this->getDoctrine()->getManager();
            $queryc = $em->createQuery(
            'SELECT p
            FROM GestionBundle:Ultpedido p
            WHERE p.cliente = :consultaBusqueda'
            )->setParameter('consultaBusqueda', $rz);
            $query2 = $queryc->getResult();
            $generardatos = array();
            foreach($query2 as $entity){
                $pd= $entity->getPedido();
                $localidad['pedido']  = $pd;
                $generardatos[] = $localidad;
              }
            return new JsonResponse($generardatos);
      }

  public function domicilioAction(Request $request)
  {
        $rz=$_POST['clienterz'];
        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
        $em = $this->getDoctrine()->getManager();
        $queryc = $em->createQuery(
        'SELECT p
        FROM GestionBundle:Clientes p
        WHERE p.razonSocial = :consultaBusqueda'
        )->setParameter('consultaBusqueda', $rz);
        $query2 = $queryc->getResult();
        $generardatos = array();
        foreach($query2 as $entity){
            $pd= $entity->getDomicilioFiscal();
            $localidad['domicilio']  = $pd;
            $generardatos[] = $localidad;
          }
        return new JsonResponse($generardatos);
  }

   public function registrorecoleccionesAction(Request $request)
      {
        $session = $request->getSession(); 
            if(!$session->get("usuarionombre")){
                $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
                return $this->redirect($this->generateUrl('usuario_login'));
            }

        $cliente = ($_POST['clienterz']);
        $obra = ($_POST['obra']);
        $pedido = ($_POST['pedido']);
        $domicilio = ($_POST['domicilio']);
        $fecha = ($_POST['fecha']);
        $hora = ($_POST['hora']);

        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
        $em = $this->getDoctrine()->getManager();
        $dtscliente='';

        $año2 = substr($fecha, -4);
        $dia2 = substr($fecha,0,2);
        $mes2 = substr($fecha,3,2);
        $fecha2= $año2."-".$mes2."-".$dia2;

//        var_dump($fecha2);

        $dtscliente = array();
          $cadena = new Recolecciones();
          $cadena->setClientes($cliente);
          $cadena->setObra($obra);
          $cadena->setDomicilio($domicilio);
          $cadena->setPedidos($pedido);
          $cadena->setFecha($fecha2);
          $cadena->setHora($hora);

          $em=$this->getDoctrine()->getManager();
          $em->persist($cadena);        
          $em->flush();


        //return new JsonResponse($ultpedido1);
      }

      public function modificarAction(Request $request)
      {
            $session = $request->getSession(); 
            if(!$session->get("usuarionombre")){
                $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
                return $this->redirect($this->generateUrl('usuario_login'));
            }
            $recoleccion=$_POST['recoleccion'];
            $cliente=$_POST['cliente'];
            $obra=$_POST['obra'];
            $fecha=$_POST['fecha'];
            $pedido=$_POST['pedido'];
            $hora=$_POST['hora'];
            $domicilio=$_POST['domicilio'];

             $año2 = substr($fecha, -4);
             $dia2 = substr($fecha,0,2);
             $mes2 = substr($fecha,3,2);
             $fecha2= $año2."-".$mes2."-".$dia2;

            $manager = $this->getDoctrine()->getManager();
            $conn = $manager->getConnection();
            $em = $this->getDoctrine()->getManager();

             $cadenaP = $conn->query("UPDATE recolecciones SET clientes='$cliente',obra='$obra', fecha='$fecha2',pedidos='$pedido',hora='$hora', domicilio='$domicilio' WHERE id=$recoleccion");   



      }

      public function imprimirrecoleccionAction($fecha,Request $request)
      {
        $session = $request->getSession(); 
            if(!$session->get("usuarionombre")){
                $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
                return $this->redirect($this->generateUrl('usuario_login'));
            }


        $sql="SELECT * FROM recolecciones WHERE fecha='$fecha'";
        
        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
        $rec= $conn->query($sql);

        $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $añod = substr($fecha,0,4);
          $diad = substr($fecha,8,9);
          $mesd = substr($fecha,5,2);
          $fechafiltro=$diad."/".$mesd."/".$añod;

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
         <label class="label6" style=" font-size:150%;color: #00BFFF">Fecha de Recolección: </label> <label style="font-size:150%;"> '.$fechafiltro.'</label><br/>


            <h1 style="text-align:center;">REPORTE DE RECOLECCIONES</h1> 
              <table border="1" cellpadding="5"> 
                <thead> 
                  <tr align="center"> 
                   <th bgcolor="#00BFFF" style="font-size:100%;">Recolecciones</th>
                   <th bgcolor="#00BFFF" style="font-size:100%;">Clientes</th>
                   <th bgcolor="#00BFFF" style="font-size:100%;">Obra</th>
                   <th bgcolor="#00BFFF" style="font-size:100%;">Hora</th>
                   <th bgcolor="#00BFFF" style="font-size:100%;">Pedidos</th>
                   <th bgcolor="#00BFFF" style="font-size:100%;">Domicilio</th>
                  </tr> 
                </thead> 
                      '; 
                $total_saldo=0;

                     while ($row = $rec->fetch()) {
                        
                        $content .= ' 
                      <tr> 
                          <td style= "text-align:center;">'.$row['id'].'</td> 
                          <td style= "text-align:center;">'.$row['clientes'].'</td>
                          <td style= "text-align:center;">'.$row['obra'].'</td>
                          <td style= "text-align:center;">'.$row['hora'].'</td> 
                          <td style= "text-align:center;">'.$row['pedidos'].'</td> 
                          <td style= "text-align:center;">'.$row['domicilio'].'</td> 
                      </tr> 
                      ';
                      } 
                      $content .= '</table>'; 
        $content .= ' 
    ';
                   $pdf->writeHTML($content, true, 0, true, 0); 
                   $pdf->lastPage(); 
                   $pdf->output('Reporte_Diario_Recolecciones.pdf', 'I'); 


      }
       public function filtrogeneralAction($desde,$hasta,$cliente,$cuenta,Request $request)
      {
        $session = $request->getSession(); 
            if(!$session->get("usuarionombre")){
                $this->get('session')->getFlashBag()->add('fall','ES NECESARIO INICIAR SESSION');
                return $this->redirect($this->generateUrl('usuario_login'));
            }
        $sql="SELECT * FROM recolecciones";
        $con=0;
         if ($cliente<>'0')
        {
          $sql= $sql." WHERE clientes like '".$cliente."%'";
          $con=1;
        }
        if ($cuenta<>'0')
        {
            if($con==1){
              $sql= $sql." and obra like '".$cuenta."%'";  
            }else{
              $sql= $sql." where obra like '".$cuenta."%'";
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
        }
        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
        $rec= $conn->query($sql);

        $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
          $añod = substr($desde,0,4);
          $diad = substr($desde,8,9);
          $mesd = substr($desde,5,2);
          $fechafiltrodesde=$diad."/".$mesd."/".$añod;

          $añod2 = substr($hasta,0,4);
          $diad2 = substr($hasta,8,9);
          $mesd2 = substr($hasta,5,2);
          $fechafiltrohasta=$diad2."/".$mesd2."/".$añod2;

            $pdf->SetAuthor('JJC');
            $pdf->SetTitle(('Reporte_Recolecciones'));
            $pdf->SetSubject('Our Code World Subject');
            $pdf->setFontSubsetting(true);
            $pdf->SetFont('Helvetica', '', 10); 
            $pdf->AddPage();

        $content = ''; 
        $content .= ' 

        <div class=""> 
          <h2>DETALLES:</h2>
        </div>
         <label class="label6" style=" font-size:150%;color: #00BFFF">Fecha de Recolección Desde: </label> <label style="font-size:150%;"> '.$fechafiltrodesde.'</label><br/>
         <label class="label6" style=" font-size:150%;color: #00BFFF">Fecha de Recolección Hasta: </label> <label style="font-size:150%;">  '.$fechafiltrohasta.'</label><br/>


            <h1 style="text-align:center;">REPORTE DE RECOLECCIONES</h1> 
              <table border="1" cellpadding="5"> 
                <thead> 
                  <tr align="center"> 
                   <th bgcolor="#00BFFF" style="font-size:100%;">Recolecciones</th>
                   <th bgcolor="#00BFFF" style="font-size:100%;">Clientes</th>
                   <th bgcolor="#00BFFF" style="font-size:100%;">Obra</th>
                   <th bgcolor="#00BFFF" style="font-size:100%;">Hora</th>
                   <th bgcolor="#00BFFF" style="font-size:100%;">Pedidos</th>
                   <th bgcolor="#00BFFF" style="font-size:100%;">Domicilio</th>
                  </tr> 
                </thead> 
                      '; 
                $total_saldo=0;

                     while ($row = $rec->fetch()) {
                        
                        $content .= ' 
                      <tr> 
                          <td style= "text-align:center;">'.$row['id'].'</td> 
                          <td style= "text-align:center;">'.$row['clientes'].'</td>
                          <td style= "text-align:center;">'.$row['obra'].'</td>
                          <td style= "text-align:center;">'.$row['hora'].'</td> 
                          <td style= "text-align:center;">'.$row['pedidos'].'</td> 
                          <td style= "text-align:center;">'.$row['domicilio'].'</td> 
                      </tr> 
                      ';
                      } 
                      $content .= '</table>'; 
        $content .= ' 
    ';
                   $pdf->writeHTML($content, true, 0, true, 0); 
                   $pdf->lastPage(); 
                   $pdf->output('Reporte_Diario_Recolecciones.pdf', 'I'); 


      }
}
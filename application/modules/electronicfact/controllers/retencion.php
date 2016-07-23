<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Retencion extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
                $this->user->check_session();
                $this->load->library('grocery_CRUD');
	}

        public function index(){
            $res['view'] = $this->load->view('retencion_search','',TRUE);
            $res['slidebar'] = $this->load->view('slidebar','',TRUE);
            $this->load->view('templates/dashboard',$res);
        }        
                
	public function get_crud()
	{
            $this->config->load('grocery_crud');
            $this->config->set_item('grocery_crud_dialog_forms',true);
//		$this->config->set_item('grocery_crud_default_per_page',10);            
            $crud = new grocery_CRUD();
            $crud->set_theme('datatables2');
            
            
            $crud->where( 'bill_retencion.autorizado_sri', 1 );
            $crud->where( 'bill_retencion.proveedor_id', $this->user->supplier_id );
            
            $fecha_desde = $this->input->post('fecha_desde');
            $fecha_hasta = $this->input->post('fecha_hasta');
            $nro = $this->input->post('nro');
            if(!empty($fecha_desde) AND !empty($fecha_hasta)){
                $crud->where( 'bill_retencion.fecha >=', $fecha_desde );
                $crud->where( 'bill_retencion.fecha <=', $fecha_hasta );
            }
            if(!empty($nro)){
                $crud->where( 'bill_retencion.nro', $nro );
            }            
            
            $ver_anulados = $this->input->post('ver_anulados');
            if(!empty($ver_anulados)){
                $crud->where( 'bill_retencion.estado', -1 );
            }else{
                $crud->where( 'bill_retencion.estado', 1 );
            }            
            
            $crud->columns('total','proveedor_id','nro_ret','fecha','hora','tipo_transaccion','cod_fact_electronica');
            $crud->display_as('tipo_transaccion','Tipo');
            
            $crud->callback_column('nro_ret',array($this,'get_nro_ret'));
//            $crud->callback_column('autorizado_sri',array($this,'get_autorizado_sri'));
            $crud->callback_column('cod_fact_electronica',array($this,'get_pdf_retencion'));
            
            $crud->set_table('bill_retencion');
            $crud->set_relation('proveedor_id', 'billing_proveedor', '{nombres} {apellidos}');
            $crud->set_relation('tipo_transaccion', 'billing_tipotransaccion', '{nombre}');
            $crud->unset_add()->unset_delete();
            $crud->set_subject('Retenciones');
            $output = $crud->render();
            $this->load->view('crud_view_datatable', $output);
    	}   
                
            public function get_pdf_retencion($value, $row) {
                $output = 'No Autorizada';
                if($row->cod_fact_electronica != null){
                    $output = tagcontent('a', 'retencion.pdf', array('href'=>  get_settings('DOWNLOAD_FACT_XML').$row->cod_fact_electronica.'.pdf', 'target'=>'_blank'));                    
                }
                return $output;
            }
        
        public function get_nro_ret($value, $row){
//            foreach ($tipos_precio as $tp) {
                $output = '';
                $nro_ret = $row->establecimiento.$row->pemision.'-'.str_pad($row->nro, 9, '0', STR_PAD_LEFT);
                $output .= tagcontent('a', $nro_ret, array('id'=>'ajaxpanelbtn','data-target'=>'retencioneslist_out','data-url'=>  base_url('cxp/retencion/abrir_retencion/'.$row->id),'href'=>'#', 'title'=>'Comprobante de Retencion'));
            return $output;
        }

}
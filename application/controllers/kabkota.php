<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class kabkota extends REST_Controller {
  function  __construct()
  {
      parent::__construct();
      $this->load->model('M_api');
  }

  function index_get()
  {
    $id = $this->get('id_kabupaten');

    if($id === null) {
      $kabkota = $this->M_api->rekapkabkota();

      foreach($kabkota as $item){
        $posts[] = array(
            'id_kabupaten'  => $item->id_kabupaten,
            'kabkota'       => $item->nama_kab,
            'confirm'       => $item->confirm,
            'perawatan'     => $item->positif,
            'meninggal'     => $item->meninggal,
            'sembuh'        => $item->sembuh,
        );
      }

      if ($kabkota) {
        $this->response([
          'status'  => true,
          'result'  => $posts
        ], REST_Controller::HTTP_OK);
      }
    }
    else {
      $kabkota = $this->M_api->rekapkabkota($id);

      foreach($kabkota as $item){
        $posts[] = array(
            'id_kabupaten'  => $item->id_kabupaten,
            'kabkota'       => $item->nama_kab,
            'confirm'       => $item->confirm,
            'perawatan'     => $item->positif,
            'meninggal'     => $item->meninggal,
            'sembuh'        => $item->sembuh,
        );
      }

      if ($kabkota) {
        $this->response([
          'status'      => true,
          'id_kabupaten'=> $id,
          'result'      => $posts,
        ], REST_Controller::HTTP_OK);
      }
    }
  }
}